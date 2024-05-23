<?php
require_once './clases/Usuarios.php';
require_once './clases/Empleado.php';

// Recibir los datos del empleado a modificar y la nueva foto
$empleado_json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : null;
$nueva_foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

// Decodificar el JSON recibido
$datos_empleado = json_decode($empleado_json, true);

// Crear una instancia de Empleado con los datos recibidos
$empleado = new Empleado(
    $datos_empleado['id'],
    $datos_empleado['nombre'],
    $datos_empleado['correo'],
    $datos_empleado['clave'],
    $datos_empleado['id_perfil'],
    $datos_empleado['sueldo'],
    $nueva_foto // Ruta de la foto existente
);

// Llamar al método Modificar de la instancia de Empleado
$exito = $empleado->Modificar();

// Preparar la respuesta JSON
$resultado = new stdClass();
$resultado->exito = $exito;
$resultado->mensaje = $exito ? "Empleado modificado correctamente" : "Error al modificar empleado";

// Retornar la respuesta JSON
echo json_encode($resultado);
?>
