<?php
// Definir la interfaz IBM
interface IBM {
    // Método para modificar el registro en la base de datos
    public function Modificar();

    // Método estático para eliminar un registro de la base de datos por su ID
    public static function Eliminar($id);
}
?>