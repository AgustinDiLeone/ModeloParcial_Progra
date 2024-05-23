<?php
require_once "./clases/accesoDatos.php";
require_once "./clases/Usuarios.php";

$correo = isset($_POST["correo"])? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"])? $_POST["clave"] : NULL;
$nombre = isset($_POST["nombre"])? $_POST["nombre"] : NULL;
$id_perfil = isset($_POST["id_perfil"])? $_POST["id_perfil"] : NULL;

$usuario = new Usuario(-1,$nombre,$correo,$clave,$id_perfil);

$obj = new stdClass();
$obj->exito = $usuario -> Agregar();
$obj -> mensaje = $obj->exito == true ?"Objeto agregado OK":"Error en agregado";

echo json_encode($obj);
?>