<?php
// Incluir la definición de la clase Usuario y la lógica para acceder a la base de datos
require_once './clases/Usuarios.php'; // Asegúrate de que el nombre de tu archivo sea correcto
require_once './clases/accesoDatos.php'; // Si tienes un archivo para la conexión a la base de datos, inclúyelo aquí

// Verificar si se recibieron los parámetros id y accion
if (isset($_POST['id']) && isset($_POST['accion']) && $_POST['accion'] === "borrar") {
    // Obtener el ID recibido
    $id = $_POST['id'];

    // Llamar al método Eliminar para borrar el usuario de la base de datos
    $exito = Usuario::Eliminar($id);

    // Preparar la respuesta
    $respuesta = array(
        "exito" => $exito,
        "mensaje" => $exito ? "Usuario eliminado correctamente" : "Error al eliminar el usuario"
    );

    // Convertir la respuesta a formato JSON y enviarla
    echo json_encode($respuesta);
} else {
    // Si no se proporcionaron los parámetros requeridos, devolver un mensaje de error
    $respuesta = array(
        "exito" => false,
        "mensaje" => "Parámetros insuficientes o acción incorrecta"
    );

    echo json_encode($respuesta);
}
?>
