<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table class="table table-hover" cellspacing="10">

        <tr>
            <th>ID</th><th>NOMBRE</th><th>CORREO</th><th>ID_PERFIL</th>
        </tr>
    <?php
    require_once './clases/Usuarios.php'; // Asegúrate de que la ruta al archivo sea correcta
    $usuarios = Usuario::TraerTodos();; // Llama al método estático TraerTodosJSON
    // Haz algo con los usuarios, como imprimirlos en formato JSON
    foreach($usuarios as $usuario){
        $table = "";
        $table.= '<tr><td>' . $usuario->id . '</td>';
        $table.= '<td>' . $usuario->nombre . '</td>';
        $table .= '<td>' . $usuario->correo . '</td>';
        $table .= '<td>' . $usuario->id_perfil . '</td></tr>';

        echo $table;
    } 
    ?>
    </table>
    
</body>
</html>
