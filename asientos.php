<?php
require 'conexion.php';

if (!isset($_GET['id_viaje'])) {
    die("Error: No se especificó un viaje.");
}
$id_viaje = $_GET['id_viaje'];

try {
    $sql_capacidad = "SELECT A.Capacidad 
                      FROM Autobus A 
                      JOIN Viaje V ON A.Placa = V.Autobus_Placa 
                      WHERE V.id_viaje = ?";
    $stmt_cap = $conexion->prepare($sql_capacidad);
    $stmt_cap->execute([$id_viaje]);
    $capacidad = $stmt_cap->fetchColumn();

    $sql_ocupados = "SELECT NumeroAsiento FROM Boleto WHERE id_viaje = ?";
    $stmt_ocu = $conexion->prepare($sql_ocupados);
    $stmt_ocu->execute([$id_viaje]);
    $ocupados_raw = $stmt_ocu->fetchAll(PDO::FETCH_COLUMN);
    $asientos_ocupados = array_flip($ocupados_raw); // Más rápido para buscar

} catch(PDOException $e) {
    die("Error al cargar asientos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Asientos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Selecciona tus Asientos</h1>
        <p>Viaje ID: <?= htmlspecialchars($id_viaje) ?></p>

        <form action="checkout.php" method="POST">
            <input type="hidden" name="id_viaje" value="<?= htmlspecialchars($id_viaje) ?>">
            
            <div class="asiento-mapa">
                <?php for ($i = 1; $i <= $capacidad; $i++): ?>
                    <?php if (isset($asientos_ocupados[$i])): ?>
                        <div class="asiento asiento-ocupado">
                            <label><?= $i ?> (X)</label>
                        </div>
                    <?php else: ?>
                        <div class="asiento asiento-libre">
                            <input type="checkbox" name="asientos[]" value="<?= $i ?>" id="asiento-<?= $i ?>">
                            <label for="asiento-<?= $i ?>"><?= $i ?></label>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

            <br>
            <input type="submit" value="Continuar con la reserva">
        </form>
    </div>
</body>
</html>