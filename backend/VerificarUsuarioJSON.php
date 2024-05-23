<?php
// Incluir la definición de la clase Usuario y la lógica para acceder a la base de datos
require_once './clases/Usuarios.php'; // Asegúrate de que el nombre de tu archivo sea correcto

// Verificar si se ha recibido el parámetro usuario_json
if (isset($_POST['usuario_json'])) {
    // Obtener el JSON recibido
    $usuario_json = $_POST['usuario_json'];

    // Llamar al método TraerUno para obtener el usuario
    $usuario = Usuario::TraerUno($usuario_json);

    // Verificar si se encontró el usuario
    if ($usuario) {
        // Usuario encontrado
        $respuesta = array(
            "exito" => true,
            "mensaje" => "Usuario encontrado",
            "usuario" => $usuario // Convertimos el objeto Usuario a un array asociativo
        );
    } else {
        // Usuario no encontrado
        $respuesta = array(
            "exito" => false,
            "mensaje" => "Usuario no encontrado"
        );
    }

    // Convertir la respuesta a formato JSON y enviarla
    echo json_encode($respuesta);
} else {
    // Si no se proporcionó el parámetro usuario_json, devolver un mensaje de error
    $respuesta = array(
        "exito" => false,
        "mensaje" => "No se envio el parametro usuario_json"
    );

    echo json_encode($respuesta);
}
?>