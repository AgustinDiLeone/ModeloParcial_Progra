<?php
require_once __DIR__ ."./accesoDatos.php";
require_once 'IBM.php';
//use stdClass;

class Usuario implements IBM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct($id, $nombre, $correo, $clave, $id_perfil,$perfil = "error") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function ToJSON() {
        {
            return '{"nombre" : "' . $this->nombre . '", "correo" : "' . $this->correo . '", "clave" : "' . $this->clave . '"}';
        }

    }
    public function GuardarEnArchivo() {

        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "Ocurrio un error al guardar el usuario";

        $path = './archivos/usuarios.json';

        $archivo = fopen($path,"a");
        $caracteresEscritos = fwrite($archivo,$this->ToJSON() . "\r\n"); //con un enter
        if($caracteresEscritos > 0){
            $ret->exito = true;
            $ret->mensaje = "Exito al guardar archivo";
        }

        fclose($archivo);
        return $ret;
    }
    public static function TraerTodosJSON(){
        $path = './archivos/usuarios.json';
        $array_res = array();
        $texto = "";

        $archivo = fopen($path,"r");
        if($archivo !==false){

            while(!feof($archivo)){
                $texto.=fgets($archivo);
            }
            fclose($archivo);
        }
        $obj_array=explode("\r\n",$texto);
        foreach($obj_array as $item){
            if($item!=="")
            {
                $obj=json_decode($item);
                $usuario = new self(0,$obj->nombre,$obj->correo,$obj->clave,0,"error");
                array_push($array_res,$usuario);
            }
        }
        return $array_res;
        
    }
    public function Agregar(){
        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("INSERT INTO usuarios(nombre,correo,clave,id_perfil)
                         VALUES(:nombre,:correo,:clave,:id_perfil)");
        $query -> bindValue(":nombre", $this->nombre,PDO::PARAM_STR);
        $query -> bindValue(":correo", $this->correo,PDO::PARAM_STR);
        $query -> bindValue(":clave", $this->clave,PDO::PARAM_STR);
        $query -> bindValue(":id_perfil", $this->id_perfil,PDO::PARAM_INT);

        $query->execute();

        if ($query->rowCount() === 1){
            return true;
        }
        else {
            return false;
        }
    }
    public static function TraerTodos(){
        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("SELECT id,nombre,correo,clave,id_perfil FROM usuarios");

        $query->execute();

        // Recupera los resultados como un array asociativo
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

        // Mapea los resultados a objetos Usuario manualmente pasando los parámetros al constructor
        $usuarios = [];
        foreach ($resultados as $fila) {
            $usuario = new Usuario(
                $fila['id'],
                $fila['nombre'],
                $fila['correo'],
                $fila['clave'],
                $fila['id_perfil']
            );
            $usuarios[] = $usuario;
        }

        return $usuarios; // Devuelve un array de objetos Usuario
    }
    public static function TraerUno($params){

        $datos = json_decode($params, true);

        // Acceder a los datos recuperados
        $correo = $datos['correo'];
        $clave = $datos['clave'];

        $objPdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $objPdo->retornarConsulta("SELECT id,nombre,correo,clave,id_perfil FROM usuarios 
                                                WHERE correo = :correo AND clave = :clave");

        // Vincular los valores de los parámetros
        $query->bindValue(":correo", $correo, PDO::PARAM_STR);
        $query->bindValue(":clave", $clave, PDO::PARAM_STR);

        $query->execute();

        // Recuperar el usuarioData como un array asociativo
        $usuarioData = $query->fetch(PDO::FETCH_ASSOC);      

        // Verificar si se encontró un usuario
        if ($usuarioData) {
            // Crear una instancia de Usuario con los datos recuperados y devolverla
            $usuario = new Usuario(
                $usuarioData['id'],
                $usuarioData['nombre'],
                $usuarioData['correo'],
                $usuarioData['clave'],
                $usuarioData['id_perfil']
            );
    
            return $usuario; // Devuelve un Usuario
        } else {
            // Si no se encontró ningún usuario, retornar NULL
            return NULL;
        }
    }
    public function Modificar() {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $query =$objetoAccesoDato->retornarConsulta("UPDATE usuarios 
        SET nombre = :nombre, correo = :correo, clave = :clave, id_perfil = :id_perfil 
        WHERE id = :id");
        
        $query -> bindValue(":id", $this->id,PDO::PARAM_INT);
        $query -> bindValue(":nombre", $this->nombre,PDO::PARAM_STR);
        $query -> bindValue(":correo", $this->correo,PDO::PARAM_STR);
        $query -> bindValue(":clave", $this->clave,PDO::PARAM_STR);
        $query -> bindValue(":id_perfil", $this->id_perfil,PDO::PARAM_INT);

        $query->execute();
        
        if ($query->rowCount() === 1){
            return true;
        }
        else {
            return false;
        }
    }

    public static function Eliminar($id) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $query =$objetoAccesoDato->retornarConsulta("DELETE FROM usuarios WHERE id = :id");
        
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        if ($query->rowCount() === 1){
            return true;
        }
        else {
            return false;
        }
    }
}
