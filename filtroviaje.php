<?php
require 'ini.php';

$paquetes = [
    ['nombre' => 'Cancún', 'precio' => 750000, 'fecha' => '2025-08-01'],
    ['nombre' => 'Madrid', 'precio' => 780000, 'fecha' => '2025-08-15'],
    ['nombre' => 'Sao Paulo', 'precio' => 800000, 'fecha' => '2025-09-01'],
    ['nombre' => 'Santiago', 'precio' => 900000, 'fecha' => '2025-07-15'],
    ['nombre' => 'Buenos Aires', 'precio' => 950000, 'fecha' => '2025-08-10'],
    ['nombre' => 'Frutillar', 'precio' => 970000, 'fecha' => '2025-09-20'],
    ['nombre' => 'Puerto Montt', 'precio' => 110000, 'fecha' => '2025-09-10'],
    ['nombre' => 'Patagonia', 'precio' => 115000, 'fecha' => '2025-10-05'],
    ['nombre' => 'Florianopolis', 'precio' => 120000, 'fecha' => '2025-11-01'],
];

$filtrados = [];
$destino = '';
$fecha = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destino = $_POST['destino'] ?? '';
    $fecha = $_POST['fecha'] ?? '';

    foreach ($paquetes as $p) {
        if ($p['nombre'] === $destino && $p['fecha'] >= $fecha) {
            $filtrados[] = $p;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Filtrar Viajes - Agencia</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="script.js" defer></script>
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
    <h2>Filtrar Viajes</h2>
    <form method="post" action="filtroviaje.php">
        <label for="destino">Destino:
            <select name="destino" id="destino" required>
                <option value="">-- Selecciona tu destino --</option>
                <option value="Cancún" <?= ($destino==='Cancún')?'selected':'' ?>>Cancún</option>
                <option value="Madrid" <?= ($destino==='Madrid')?'selected':'' ?>>Madrid</option>
                <option value="Sao Paulo" <?= ($destino==='Sao Paulo')?'selected':'' ?>>Sao Paulo</option>
                <option value="Santiago" <?= ($destino==='Santiago')?'selected':'' ?>>Santiago</option>
                <option value="Buenos Aires" <?= ($destino==='Buenos Aires')?'selected':'' ?>>Buenos Aires</option>
                <option value="Frutillar" <?= ($destino==='Frutillar')?'selected':'' ?>>Frutillar</option>
                <option value="Puerto Montt" <?= ($destino==='Puerto Montt')?'selected':'' ?>>Puerto Montt</option>
                <option value="Patagonia" <?= ($destino==='Patagonia')?'selected':'' ?>>Patagonia</option>
                <option value="Florianopolis" <?= ($destino==='Florianopolis')?'selected':'' ?>>Florianopolis</option>
                 <option value="" <?= ($destino==='Mendoza')?'selected':'' ?>>Mendoza</option>
            </select>
        </label>
        <label for="fecha">Fecha desde:
            <input type="date" name="fecha" id="fecha" required value="<?=htmlspecialchars($fecha)?>">
        </label>
        <button type="submit">Buscar</button>
    </form>

    <?php if (!empty($filtrados)): ?>
        <h3>Resultados:</h3>
        <table>
            <thead>
                <tr>
                    <th>Destino</th><th>Precio (CLP)</th><th>Fecha</th><th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filtrados as $p): ?>
                    <tr>
                        <td><?=htmlspecialchars($p['nombre'])?></td>
                        <td>$<?=number_format($p['precio'],2)?></td>
                        <td><?=htmlspecialchars($p['fecha'])?></td>
                        <td>
                            <form method="post" action="procesar.php" style="margin:0;">
                                <input type="hidden" name="nombre" value="<?=htmlspecialchars($p['nombre'])?>">
                                <input type="hidden" name="precio" value="<?=htmlspecialchars($p['precio'])?>">
                                <input type="hidden" name="fecha" value="<?=htmlspecialchars($p['fecha'])?>">
                                <button type="submit">Agregar al carrito</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No se encontraron viajes en la fecha seleccionada.</p>
    <?php endif; ?>
</main>
</body>
</html>
