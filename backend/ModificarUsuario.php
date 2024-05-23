<?php
require_once "./clases/accesoDatos.php";
require_once "./clases/Usuarios.php";

if (isset($_POST['usuario_json'])) {
    $usuario_json = $_POST['usuario_json'];

    // Decodificar el JSON para obtener los datos del usuario
    $datos_usuario = json_decode($usuario_json, true);

    $id = $datos_usuario['id'];
    $nombre = $datos_usuario['nombre'];
    $correo = $datos_usuario['correo'];
    $clave = $datos_usuario['clave'];
    $id_perfil = $datos_usuario['id_perfil'];


    $usuario = new Usuario($id,$nombre,$correo,$clave,$id_perfil);

    $obj = new stdClass();
    $obj->exito = $usuario -> Modificar();
    $obj -> mensaje = $obj->exito == true ?"Objeto Modificado OK":"Error en modificar";

    echo json_encode($obj);
}
?>