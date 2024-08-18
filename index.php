<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-18mE4kWBq78iYhF1dvkuhfTAU6auUBtT94WrHftjDbrCEXSU1oBoqy12vZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>Gold Club</title>
</head>
<body>
    <h1>GOLD <br> CLUB</h1>
    <form action="login.php" method="post">
        <?php
        if (isset($_GET['error'])) {
            echo "<p class='error' style='color: red;'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
        ?>
        <i></i>
        <label style="font-family: 'Love Ya Like A Sister';"></label>
        <input type="email" name="correo_electronico" placeholder="Email" required>

        <i></i>
        <label style="font-family: 'Love Ya Like A Sister';"></label>
        <input type="password" name="Clave" placeholder="Password" required>

        <!-- Contenedor para los botones -->
        <div class="button-container">
            <button type="submit" style="font-family: 'Love Ya Like A Sister';">SING IN</button>
            <a href="registro.php" style="font-family: 'Love Ya Like A Sister';">SING UP</a>
        </div>
    </form>
</body>
</html>

