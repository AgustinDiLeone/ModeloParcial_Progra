<?php
// Definir la interfaz ICRUD
interface ICRUD {
    // Método de clase para traer todos los registros de la base de datos
    public static function TraerTodos();

    // Método de instancia para agregar un nuevo registro en la base de datos
    public function Agregar();

    // Método de instancia para modificar un registro en la base de datos
    public function Modificar();

    // Método de clase para eliminar un registro de la base de datos por su ID
    public static function Eliminar($id);
}
?>