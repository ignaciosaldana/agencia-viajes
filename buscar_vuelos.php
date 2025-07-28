<!--Buscar vuelos -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha = $_POST['fecha'];

    echo "Buscando vuelos desde $origen a $destino el $fecha";
}
?>

<h2>Buscar Vuelos</h2>
<form method="POST">
    Origen: <input type="text" name="origen" required><br>
    Destino: <input type="text" name="destino" required><br>
    Fecha: <input type="date" name="fecha" required><br>
    <input type="submit" value="Buscar">
</form>
