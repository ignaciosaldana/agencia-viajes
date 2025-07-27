<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Solo se permitirá el acceso si esque se validó el pago mediante pay_card.php
if (empty($_SESSION['pago_realizado'])) {
    header('Location: pay.php');
    exit;
}

// Aquí limpiamos el carrito yla  sesión de pago
unset($_SESSION['carrito']);
unset($_SESSION['pago_realizado']);

$mensaje = "Pago procesado exitosamente. ¡Gracias por tu compra!";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Pago Procesado</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<header>
    <h1>Agencia de Viajes Santo Tomás</h1>
    <nav>
        <a href="filtroviaje.php">Buscar paquetes</a> |
        <a href="pay.php">Carrito</a> |
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</header>
<main>
    <h2><?= $mensaje ?></h2>
    <a href="filtroviaje.php">Volver a la página principal</a>
</main>
</body>
</html>
