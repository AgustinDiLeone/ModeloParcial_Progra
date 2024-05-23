<?php
require_once './clases/Usuarios.php';
require_once './clases/Empleado.php';

// Verificar si se recibió el parámetro id por POST
if(isset($_POST['id'])) {
    // Obtener el ID del empleado a eliminar
    $id_empleado = $_POST['id'];

    // Intentar eliminar el empleado
    $exito = Empleado::Eliminar($id_empleado);

    // Preparar la respuesta JSON
    $respuesta = new stdClass();
    $respuesta->exito = $exito;
    $respuesta->mensaje = $exito ? "Empleado eliminado correctamente" : "No se pudo eliminar el empleado";

    // Devolver la respuesta como JSON 
    echo json_encode($respuesta);
} else {
    // Si no se proporcionó el parámetro id, devolver un mensaje de error
    $respuesta = new stdClass();
    $respuesta->exito = false;
    $respuesta->mensaje = "El parámetro 'id' es requerido";

    // Devolver la respuesta como JSON
    echo json_encode($respuesta);
}
return json_encode($respuesta);
?>
