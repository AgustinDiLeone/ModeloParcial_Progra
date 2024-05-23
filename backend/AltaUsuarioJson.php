<?php
require_once "./clases/Usuarios.php";

$correo = isset($_POST["correo"])? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"])? $_POST["clave"] : NULL;
$nombre = isset($_POST["nombre"])? $_POST["nombre"] : NULL;

if($correo != NULL && $clave != NULL && $nombre != NULL){
    $usuario = new Usuario(0,$nombre,$correo,$clave,0,"error");
    $respuesta = $usuario->GuardarEnArchivo();
    echo json_encode($respuesta);
}
?>