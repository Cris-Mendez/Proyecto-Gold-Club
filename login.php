<?php
session_start();
include('coneccion.php');

if (isset($_POST['correo_electronico']) && isset($_POST['Clave'])) {
    $correo_electronico = $_POST['correo_electronico'];
    $Clave = $_POST['Clave'];

    if (empty($correo_electronico) || empty($Clave)) {
        header("Location: index.php?error=Todos los campos son requeridos");
        exit();
    }

    // Encriptar la contraseña si es necesario
    /* $Clave = md5($Clave); */

    // Preparar y ejecutar la consulta
    $sql = "SELECT * FROM usuarios WHERE correo_electronico = ? AND contrasena = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $correo_electronico, $Clave);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['correo_electronico'] = $row['correo_electronico'];
        $_SESSION['id'] = $row['id'];
        header("Location: Inicio.php");
        exit();
    } else {
        header("Location: index.php?error=El correo o la contraseña son incorrectos");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
