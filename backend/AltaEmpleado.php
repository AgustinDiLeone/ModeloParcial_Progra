<?php
require_once "./clases/accesoDatos.php";
require_once "./clases/Usuarios.php";
require_once "./clases/Empleado.php";

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
$correo = isset($_POST["correo"]) ? $_POST["correo"] : NULL;
$clave = isset($_POST["clave"]) ? $_POST["clave"] : NULL;
$id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : NULL;
$sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : NULL;
$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

$empleado = new Empleado(-1,$nombre, $correo, $clave, $id_perfil, $sueldo, $foto);

$obj = new stdClass();
$obj->exito = $empleado -> Agregar();
$obj -> mensaje = $obj->exito == true ?"Objeto agregado OK":"Error en agregado";

echo json_encode($obj);
?>
