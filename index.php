<?php
session_start();

// Si ya hay sesión iniciada, redirigir a la página principal
if (isset($_SESSION['user'])) {
    header('Location: filtroviaje.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // Login: usuario = admin y password = 1234, ambas establecidas por defecto
    if ($usuario === 'admin' && $password === '1234') {
        $_SESSION['user'] = $usuario;
        $_SESSION['LAST_ACTIVITY'] = time(); // para controlar una posible inactividad
        header('Location: filtroviaje.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Agencia de Viajes Santo Tomás</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main class="login-container">
    <h1>Iniciar sesión</h1>
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="index.php">
        <label>Usuario:
            <input type="text" name="usuario" required>
        </label>
        <label>Contraseña:
            <input type="password" name="password" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
</main>
</body>
</html>
