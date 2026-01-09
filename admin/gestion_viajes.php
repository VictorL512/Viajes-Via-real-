<?php 
require 'header.php'; 
require '../conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_viaje'])) {
    try {
        $sql = "INSERT INTO Viaje (FechaSalida, HoraSalida, Origen, Destino, Conductor_INE, Autobus_Placa) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            $_POST['fecha_salida'], 
            $_POST['hora_salida'],
            $_POST['origen'], 
            $_POST['destino'], 
            $_POST['conductor_ine'], 
            $_POST['autobus_placa']
        ]);
        echo "<p style='color: green; font-weight: bold;'>¡Viaje programado exitosamente!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Error al agregar viaje: " . $e->getMessage() . "</p>";
    }
}

$conductores = $conexion->query("SELECT INE, Nombre, Apellido FROM Conductor")->fetchAll(PDO::FETCH_ASSOC);
$autobuses = $conexion->query("SELECT Placa, Modelo FROM Autobus")->fetchAll(PDO::FETCH_ASSOC);

$sql_viajes = "SELECT V.*, 
                      C.Nombre as NomCond, C.Apellido as ApeCond, 
                      A.Modelo, A.Capacidad,
                      (SELECT COUNT(*) FROM Boleto B WHERE B.id_viaje = V.id_viaje) as Vendidos
               FROM Viaje V
               JOIN Conductor C ON V.Conductor_INE = C.INE
               JOIN Autobus A ON V.Autobus_Placa = A.Placa
               ORDER BY V.FechaSalida DESC, V.HoraSalida DESC";

$viajes = $conexion->query($sql_viajes)->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestión de Viajes</h2>

<div style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
    <form action="gestion_viajes.php" method="POST">
        <label for="origen">Origen:</label>
        <input type="text" id="origen" name="origen" required placeholder="Ej. Monterrey">

        <label for="destino">Destino:</label>
        <input type="text" id="destino" name="destino" required placeholder="Ej. CDMX">

        <label for="fecha_salida">Fecha de Salida:</label>
        <input type="date" id="fecha_salida" name="fecha_salida" required>
        
        <label for="hora_salida">Hora de Salida:</label>
        <input type="time" id="hora_salida" name="hora_salida" required>

        <label for="conductor_ine">Conductor:</label>
        <select id="conductor_ine" name="conductor_ine" required>
            <option value="">-- Seleccione un conductor --</option>
            <?php foreach ($conductores as $conductor): ?>
                <option value="<?= htmlspecialchars($conductor['INE']) ?>">
                    <?= htmlspecialchars($conductor['Nombre'] . ' ' . $conductor['Apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="autobus_placa">Autobús (Unidad):</label>
        <select id="autobus_placa" name="autobus_placa" required>
            <option value="">-- Seleccione un autobús --</option>
            <?php foreach ($autobuses as $autobus): ?>
                <option value="<?= htmlspecialchars($autobus['Placa']) ?>">
                    <?= htmlspecialchars($autobus['Modelo']) ?> (<?= htmlspecialchars($autobus['Placa']) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" name="add_viaje" value="Programar Viaje" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">
    </form>
</div>

<h3>Viajes Programados</h3>
<table style="width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background-color: #f8f9fa; text-align: left; border-bottom: 2px solid #dee2e6;">
            <th style="padding: 12px;">ID</th>
            <th style="padding: 12px;">Fecha Salida</th>
            <th style="padding: 12px;">Hora Salida</th>
            <th style="padding: 12px;">Origen</th>
            <th style="padding: 12px;">Destino</th>
            <th style="padding: 12px;">Conductor</th>
            <th style="padding: 12px;">Autobús</th>
            <th style="padding: 12px;">Ocupación</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viajes as $viaje): ?>
        <tr style="border-bottom: 1px solid #dee2e6;">
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['id_viaje']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['FechaSalida']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['HoraSalida']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['Origen']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['Destino']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['NomCond'] . ' ' . $viaje['ApeCond']) ?></td>
            <td style="padding: 12px;"><?= htmlspecialchars($viaje['Modelo']) ?> (<?= htmlspecialchars($viaje['Autobus_Placa']) ?>)</td>

            <td style="padding: 12px; font-weight: bold;">
                <?php 
                    $vendidos = $viaje['Vendidos'];
                    $total = $viaje['Capacidad'];
                    $color = ($vendidos >= $total) ? '#dc3545' : '#28a745';
                ?>
                <span style="color: <?= $color ?>;">
                    <?= $vendidos ?> / <?= $total ?>
                </span>
                <span style="color: #666; font-weight: normal; font-size: 0.9em;"> asientos</span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
require 'footer.php'; 
?>