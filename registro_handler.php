<?php
include('coneccion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo_electronico = $_POST['correo_electronico'];
    $codigo_empleado = $_POST['codigo_empleado'];
    $contrasena = $_POST['contrasena'];

    if (empty($correo_electronico) || empty($codigo_empleado) || empty($contrasena)) {
        header("Location: registro.php?error=Todos los campos son requeridos");
        exit();
    }

    // Encriptar la contraseña
    /*$contrasena = md5($contrasena);*/

    // Preparar y ejecutar la consulta de inserción
    $sql = "INSERT INTO usuarios (correo_electronico, codigo_empleado, contrasena) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $correo_electronico, $codigo_empleado, $contrasena);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
    } else {
        header("Location: registro.php?error=Error al registrar el usuario");
    }
}

mysqli_close($conexion);
?>
