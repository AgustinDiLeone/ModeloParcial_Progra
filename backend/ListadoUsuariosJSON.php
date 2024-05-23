<?php

require_once './clases/Usuarios.php'; // Asegúrate de que la ruta al archivo sea correcta

$usuarios = Usuario::TraerTodosJSON(); // Llama al método estático TraerTodosJSON

// Haz algo con los usuarios, como imprimirlos en formato JSON
echo json_encode($usuarios);

?>