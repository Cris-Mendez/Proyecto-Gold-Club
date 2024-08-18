<?php
session_start();
include('coneccion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo_electronico'])) {
    header("Location: index.php");
    exit();
}

// Obtener productos de la base de datos
$sql = "SELECT * FROM productos";
$result = mysqli_query($conexion, $sql);
$productos = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Eliminar producto
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_producto = intval($_GET['eliminar']);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_producto);
    mysqli_stmt_execute($stmt);
    header("Location: productos.php?mensaje=Producto eliminado exitosamente");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h1>Productos</h1>
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_GET['mensaje']; ?>
        </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary mb-3">Cerrar sesión</a>
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="card-text"><strong>Precio:</strong> $<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <p class="card-text"><strong>Cantidad:</strong> <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal<?php echo $producto['id']; ?>">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Modal -->
    <?php foreach ($productos as $producto): ?>
        <div class="modal fade" id="eliminarModal<?php echo $producto['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar el producto "<?php echo htmlspecialchars($producto['nombre']); ?>"?
                    </div>
                    <div class="modal-footer">
                        <a href="productos.php?eliminar=<?php echo $producto['id']; ?>" class="btn btn-danger">Eliminar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
