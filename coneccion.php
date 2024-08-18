<?php
$host = "localhost:3307";
$User = "root";
$pass = "";
$db = "inicioseccion2";

// Crear conexión
$conexion = mysqli_connect($host, $User, $pass, $db);

// Verificar conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
