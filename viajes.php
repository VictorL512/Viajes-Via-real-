<?php
require 'conexion.php';

if (!isset($_GET['origen']) || !isset($_GET['destino']) || !isset($_GET['fecha'])) {
    die("Error: Faltan parámetros de búsqueda.");
}

$origen = $_GET['origen'];
$destino = $_GET['destino'];
$fecha_hora = $_GET['fecha']; 

try {
    $fecha_obj = new DateTime($fecha_hora);
    $fecha_para_sql = $fecha_obj->format('Y-m-d');
    $hora_para_sql = $fecha_obj->format('H:i:s');

    $sql = "SELECT V.*, A.Modelo, T.PrecioBase,
                   CONCAT(V.FechaSalida, ' ', V.HoraSalida) AS SalidaCompleta
            FROM Viaje V
            JOIN Autobus A ON V.Autobus_Placa = A.Placa
            LEFT JOIN Boleto B ON V.id_viaje = B.id_viaje
            LEFT JOIN Tarifa T ON B.id_tarifa = T.id_tarifa OR T.id_tarifa = 1
            WHERE V.Origen = ? 
              AND V.Destino = ? 
              AND (
                 (V.FechaSalida = ? AND V.HoraSalida >= ?) -- Viajes en el mismo día, después de la hora
                 OR
                 (V.FechaSalida > ?) -- Viajes en días futuros
              )
            GROUP BY V.id_viaje
            ORDER BY V.FechaSalida, V.HoraSalida ASC";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$origen, $destino, $fecha_para_sql, $hora_para_sql, $fecha_para_sql]);
    $viajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Error al consultar viajes: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Viajes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Viajes Disponibles de <?= htmlspecialchars($origen) ?> a <?= htmlspecialchars($destino) ?></h1>
        <a href="index.php">Volver a buscar</a>
        
        <?php if (empty($viajes)): ?>
            <p>No se encontraron viajes para la ruta y fecha/hora seleccionadas.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Salida</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Autobús</th>
                        <th>Precio (Aprox)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($viajes as $viaje): ?>
                        <tr>
                            <td><?= htmlspecialchars($viaje['SalidaCompleta']) ?></td>
                            <td><?= htmlspecialchars($viaje['Origen']) ?></td>
                            <td><?= htmlspecialchars($viaje['Destino']) ?></td>
                            <td><?= htmlspecialchars($viaje['Modelo']) ?></td>
                            <td>$<?= htmlspecialchars($viaje['PrecioBase'] ?? '500.00') ?></td>
                            <td>
                                <a href="asientos.php?id_viaje=<?= $viaje['id_viaje'] ?>" class="btn">Seleccionar Asientos</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>