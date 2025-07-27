<?php
require 'ini.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $fecha = $_POST['fecha'] ?? '';

    if ($nombre && $precio && $fecha) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        //Agregamos paquete al carrito con cantidad por defecto
        $_SESSION['carrito'][] = [
            'nombre' => $nombre,
            'precio' => (float)$precio,
            'fecha' => $fecha,
            'cantidad' => 1 
        ];
    }
}

header('Location: pay.php');
exit;
