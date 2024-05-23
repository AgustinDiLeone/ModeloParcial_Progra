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
            <th>ID</th><th>NOMBRE</th><th>CORREO</th><th>PERFIL</th><th>SUELDO</th><th>FOTO</th>
        </tr>
    <?php
    require_once './clases/Usuarios.php'; 
    require_once './clases/Empleado.php';
    $empleados = Empleado::TraerTodos();; // Llama al método estático TraerTodosJSON
    // Haz algo con los usuarios, como imprimirlos en formato JSON
    foreach($empleados as $empleado){
        $table = "";
        $table.= '<tr><td>' . $empleado->id . '</td>';
        $table.= '<td>' . $empleado->nombre . '</td>';
        $table .= '<td>' . $empleado->correo . '</td>';
        $table .= '<td>' . $empleado->perfil . '</td>';
        $table .= '<td>' . $empleado->sueldo . '</td>';
        $table .= '<td><img src= '. $empleado->foto .' alt="Foto" width="50px" hight="50px"></td></tr>';

        echo $table;
    } 
    ?>
    </table>
    
</body>
</html>
