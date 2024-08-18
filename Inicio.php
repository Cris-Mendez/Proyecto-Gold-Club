<?php
session_start();
include('coneccion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['correo_electronico'])) {
    header("Location: index.php");
    exit();
}

// Eliminar producto
$productoEliminado = false;
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_producto = intval($_GET['eliminar']);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_producto);
    mysqli_stmt_execute($stmt);
    $productoEliminado = mysqli_stmt_affected_rows($stmt) > 0;
}

// Obtener productos de la base de datos
$sql = "SELECT * FROM productos";
$result = mysqli_query($conexion, $sql);
$productos = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url("Untitled.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            font-family: 'Love Ya Like A Sister', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6 {
            flex: 0 0 48%;
            max-width: 48%;
        }

        .card {
            background-color: #4af7e3;
            border-radius: 25px; /* Bordes más ovalados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            padding: 10px;
            color: #000;
            height: auto;
            display: flex;
            flex-direction: row;
            align-items: center; /* Alinea el contenido verticalmente */
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            border-radius: 15px; /* Imagen ovalada */
            height: 80px; /* Tamaño pequeño */
            width: 80px; /* Tamaño pequeño */
            margin-right: 10px;
        }

        .product-details {
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 1rem;
            margin: 0;
        }

        .card-text {
            font-size: 0.875rem;
            margin: 0;
        }

        .card-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: auto; /* Mueve el botón al final */
        }

        .hidden-products {
            display: none;
        }

        .btn-primary {
            margin-top: 10px;
        }

        .load-more {
            text-align: center;
            margin: 20px 0;
        }

        h1 {
            font-size: 120px;
            margin-top: 5px;
            text-align: center;
        }

/* Estilos para el icono en el botón */
.icono-eliminar {
    width: 40px; /* Ajusta el tamaño según sea necesario */
    height: auto; /* Mantiene la proporción de la imagen */
    display: block; /* Asegura que la imagen esté en una línea sola */
    margin: 0; /* Quita los márgenes si es necesario */
}

/* Estilos del botón para que se ajuste al icono */
.btn-danger {
    background-color: transparent; /* Quita el fondo rojo */
    border: none; /* Quita el borde */
    padding: 0; /* Elimina el padding para ajustar el tamaño del botón al icono */
    box-shadow: none; /* Quita la sombra si es necesario */
    width: auto; /* Ajusta el ancho del botón al contenido */
    height: auto; /* Ajusta la altura del botón al contenido */
    display: flex;
    align-items: center; /* Centra verticalmente el icono dentro del botón */
    justify-content: center; /* Centra horizontalmente el icono dentro del botón */
}

/* Estilo para el botón en estado hover */
.btn-danger:hover {
    background-color: #e0e0e0; /* Color gris claro para el hover */
    border: none; /* Asegura que no haya borde */
}



    </style>
</head>
<body>
<div class="container mt-4">
    <h1>GOLD <br> CLUB</h1>
    <a href="index.php" class="btn btn-primary mb-3" style="background-color: #000;">Cerrar sesión</a>

    <div class="row" id="product-container">
        <?php 
        $visibleProducts = 8; // Número de productos visibles inicialmente
        $count = 0;
        foreach ($productos as $producto): 
            $count++;
            $hiddenClass = ($count > $visibleProducts) ? 'hidden-products' : '';
        ?>
            <div class="col-md-6 mb-3 <?php echo $hiddenClass; ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="product-info">
                            <img src="ruta-de-imagen.jpg" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="product-details">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                <p class="card-text"><strong>Precio:</strong> $<?php echo htmlspecialchars($producto['precio']); ?></p>
                                <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <p class="card-text"><strong>Cantidad:</strong> <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal<?php echo $producto['id']; ?>">
                   <img src="compartimiento.png" alt="Eliminar" class="icono-eliminar">
                   </a>
                   </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <?php foreach ($productos as $producto): ?>
        <div class="modal fade" id="confirmarEliminarModal<?php echo $producto['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a href="Inicio.php?eliminar=<?php echo $producto['id']; ?>" class="btn btn-danger">Eliminar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Modal de Producto Eliminado -->
    <?php if ($productoEliminado): ?>
        <div class="modal fade show" id="productoEliminadoModal" tabindex="-1" aria-labelledby="productoEliminadoModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productoEliminadoModalLabel">Producto Eliminado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El producto ha sido eliminado exitosamente.
                    </div>
                    <div class="modal-footer">
                        <a href="Inicio.php" class="btn btn-primary" style="background-color: #000;">Aceptar</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var eliminarModal = new bootstrap.Modal(document.getElementById('productoEliminadoModal'));
            eliminarModal.show();
        </script>
    <?php endif; ?>

    <!-- Carga más productos -->
    <div class="load-more">
        <button id="load-more" class="btn btn-primary" style="background-color: #000;">Mostrar más productos</button>
    </div>
</div>

<script>
    let productsPerPage = 8; // Número de productos visibles inicialmente
    let currentPage = 1;
    let totalProducts = <?php echo count($productos); ?>;
    
    function loadMoreProducts() {
        let products = document.querySelectorAll('.hidden-products');
        for (let i = 0; i < productsPerPage * currentPage; i++) {
            if (i < products.length) {
                products[i].classList.remove('hidden-products');
            }
        }
        if (productsPerPage * currentPage >= totalProducts) {
            document.getElementById('load-more').style.display = 'none';
        }
        currentPage++;
    }

    document.getElementById('load-more').addEventListener('click', loadMoreProducts);
</script>
</body>
</html>
