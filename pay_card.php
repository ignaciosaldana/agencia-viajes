<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['carrito'])) {
    header('Location: pay.php');
    exit;
}

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $cantidad = $item['cantidad'] ?? 1;
    $total += $item['precio'] * $cantidad;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarjeta = $_POST['tarjeta'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $fecha_exp = $_POST['fecha_exp'] ?? '';
    $cvv = $_POST['cvv'] ?? '';

    if (empty($tarjeta) || empty($nombre) || empty($fecha_exp) || empty($cvv)) {
        $error = 'Completa todos los campos.';
    } elseif (!preg_match('/^\d{16}$/', $tarjeta)) {
        $error = 'Número de tarjeta inválido.';
    } elseif (!preg_match('/^\d{3}$/', $cvv)) {
        $error = 'CVV inválido.';
    } else {
        $_SESSION['pago_realizado'] = true;
        header('Location: procesar_pago.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
        }
        .webpay-container {
            background: white;
            border-radius: 6px;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        h2 {
            color: #0070ba;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="month"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 25px;
            background-color: #0070ba;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .error {
            color: red;
        }
        .resumen {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="webpay-container">
        <h2>Realizar pago</h2>
        <p>Confirmar compra <strong>$<?= number_format($total, 0, ',', '.') ?></strong></p>

        <div class="resumen">
            <strong>Resumen de tu compra:</strong>
            <ul>
                <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <li><?= htmlspecialchars($item['nombre']) ?> x <?= $item['cantidad'] ?> = $<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" action="pay_card.php">
            <label>Número de tarjeta:
                <input type="text" name="tarjeta" maxlength="16" placeholder="" required>
            </label>
            <label>Nombre del titular de la tarjeta:
                <input type="text" name="nombre" placeholder="" required>
            </label>
            <label>Fecha de expiración (MM/AA):
    <input type="text" name="fecha_exp" maxlength="5" placeholder="MM/AA" pattern="^(0[1-9]|1[0-2])\/\d{2}$" required>
</label>

            </label>
            <label>CVV:
                <input type="text" name="cvv" maxlength="3" placeholder="123" required>
            </label>
            <button type="submit">Pagar</button>
        </form>
    </div>
</body>
</html>
