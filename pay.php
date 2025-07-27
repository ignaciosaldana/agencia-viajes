<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Funciones para procesar cambios en cantidades o eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['cantidades'] as $index => $cant) {
            $cant = intval($cant);
            if ($cant < 1) $cant = 1;
            $_SESSION['carrito'][$index]['cantidad'] = $cant;
        }
    }

    if (isset($_POST['eliminar'])) {
        $index = intval($_POST['eliminar']);
        if (isset($_SESSION['carrito'][$index])) {
            array_splice($_SESSION['carrito'], $index, 1);
        }
    }

    header('Location: pay.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Carrito de compras</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<header>
    <h1>Carrito de Compras</h1>
    <nav>
        <a href="filtroviaje.php">Buscar paquetes</a> |
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</header>

<main>
<?php if (!empty($_SESSION['carrito'])): ?>
    <form method="post" action="pay.php">
    <table>
        <thead>
            <tr><th>Destino</th><th>Fecha</th><th>Precio unitario</th><th>Cantidad</th><th>Subtotal</th><th>Eliminar</th></tr>
        </thead>
        <tbody>
        <?php 
            $total = 0;
            foreach ($_SESSION['carrito'] as $i => $item): 
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
        ?>
            <tr>
                <td><?=htmlspecialchars($item['nombre'])?></td>
                <td><?=htmlspecialchars($item['fecha'])?></td>
                <td>$<?=number_format($item['precio'], 0)?></td>
                <td>
                 <input type="number" name="cantidades[<?php echo $i ?>]" value="<?php echo $item['cantidad'] ?>" min="1" />


                </td>
                <td>$<?=number_format($subtotal, 0)?></td>
                <td>
                    <button type="submit" name="eliminar" value="<?=$i?>" onclick="return confirm('¿Eliminar este ítem?')">X</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="4" style="text-align:right;"><strong>Total:</strong></td><td colspan="2"><strong>$<?=number_format($total, 2)?></strong></td></tr>
        </tfoot>
    </table>
    <button type="submit" name="update">Actualizar cantidad</button>
    </form>

    <form method="post" action="vaciar_carrito.php" onsubmit="return confirm('¿Vaciar todo el carrito?')">
        <button type="submit">Vaciar carrito</button>
    </form>

    <form method="post" action="pay_card.php">
        <button type="submit">ir a pagar</button>
    </form>
<?php else: ?>
    <p>Tu carrito está vacío.</p>
    <a href="filtroviaje.php">Volver a buscar paquetes</a>
<?php endif; ?>
</main>
</body>
</html>
