<?php
require_once __DIR__."./ICRUD.php";
require_once __DIR__."./Usuarios.php";

class Empleado extends Usuario implements ICRUD{
    public int $sueldo;
    public array|string $foto;

    public function __construct($id, $nombre, $correo, $clave, $id_perfil,$sueldo,$foto){
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil);
        $this->sueldo = $sueldo;
        $this->foto = $foto;
    }
    
    public function Agregar(){
        $ruta_foto = "./empleados/fotos/";
        $nombre_foto = $this->nombre . "_" . date("His") . ".jpg"; // Nombre único de la foto

        // Mover la foto al directorio de destino
        if (move_uploaded_file($this->foto["tmp_name"], $ruta_foto . $nombre_foto)) {
            // Insertar el empleado en la base de datos
            $objPdo = AccesoDatos::dameUnObjetoAcceso();
            $query = $objPdo->retornarConsulta("INSERT INTO empleados (nombre, correo, clave, id_perfil, sueldo, foto) 
                                                 VALUES (:nombre, :correo, :clave, :id_perfil, :sueldo, :foto)");
            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $query->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $query->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $query->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);
            $query->bindValue(":foto", $ruta_foto . $nombre_foto, PDO::PARAM_STR);

            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false; // Error al mover la foto
        }
    }
    public static function TraerTodos(){
        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("
            SELECT e.id, e.nombre, e.correo, e.clave, e.id_perfil, e.sueldo, e.foto, p.descripcion as perfil
            FROM empleados e
            JOIN perfiles p ON e.id_perfil = p.id
        ");
        $query->execute();

        $empleados = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $empleado = new Empleado(
                $row['id'],
                $row['nombre'],
                $row['correo'],
                $row['clave'],
                $row['id_perfil'],
                $row['sueldo'],
                $row['foto']
            );
            $empleado->perfil = $row['perfil'];
            $empleados[] = $empleado;
        }

        return $empleados;
    }
    public function Modificar(){
        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("
            SELECT foto
            FROM empleados 
            WHERE id = $this->id
        ");
        $query->execute();
        // Obtener la fila resultante
        $foto_row = $query->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró una fila y si tiene una foto
        if ($foto_row && isset($foto_row['foto'])) {
            if(file_exists($foto_row['foto'])){
                unlink($foto_row['foto']);
            }
        }
        $objPdo = AccesoDatos::dameUnObjetoAcceso();

        $ruta_foto = "./empleados/fotos/";
        $nombre_foto = $this->nombre . "_" . date("His") . ".jpg"; // Nombre único de la foto

        // Mover la foto al directorio de destino
        if (move_uploaded_file($this->foto["tmp_name"], $ruta_foto . $nombre_foto)) {

            // Construir la consulta SQL para modificar el empleado en la base de datos
            $query = "UPDATE empleados SET nombre = :nombre, correo = :correo, 
            clave = :clave, id_perfil = :id_perfil, sueldo = :sueldo, foto = :foto 
            WHERE id = :id";



            // Preparar la consulta
            $stmt = $objPdo->retornarConsulta($query);

            // Vincular los parámetros de la consulta
            $stmt->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $stmt->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $stmt->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $stmt->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $stmt->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);
            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);      
            $stmt->bindValue(":foto", $ruta_foto . $nombre_foto, PDO::PARAM_STR);
            

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se realizó la modificación
            if ($stmt->rowCount() > 0) {
                return true; // Se modificó correctamente
            } else {
                return false; // No se pudo modificar
            }
        }else {
            return false; // Error al mover la foto
        }
    }
    public static function Eliminar($id){
        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("
            SELECT foto
            FROM empleados 
            WHERE id = $id
        ");
        $query->execute();
        // Obtener la fila resultante
        $foto_row = $query->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró una fila y si tiene una foto
        if ($foto_row && isset($foto_row['foto'])) {
            if (file_exists($foto_row['foto'])) {
                unlink($foto_row['foto']);
            }
        }

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->retornarConsulta("DELETE FROM empleados WHERE id = :id");
        
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }
}   
?>