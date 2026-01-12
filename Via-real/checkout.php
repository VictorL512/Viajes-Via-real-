<?php
require 'conexion.php';

if (!isset($_POST['asientos']) || empty($_POST['asientos']) || !isset($_POST['id_viaje'])) {
    die("Error: No seleccionaste ningún asiento o el viaje es inválido. <a href='index.php'>Volver</a>");
}

$id_viaje = $_POST['id_viaje'];
$asientos_seleccionados = $_POST['asientos']; 

try {
    $tarifas = $conexion->query("SELECT id_tarifa, Tipo, PrecioBase FROM Tarifa")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar tarifas: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos del Pasajero</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Datos de los Pasajeros</h1>
        <p>Viaje ID: <?= htmlspecialchars($id_viaje) ?></p>

        <form action="procesar_reserva.php" method="POST">
            <input type="hidden" name="id_viaje" value="<?= htmlspecialchars($id_viaje) ?>">
            
            <?php foreach ($asientos_seleccionados as $asiento): ?>
                <fieldset style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                    <legend><strong>Asiento <?= htmlspecialchars($asiento) ?></strong></legend>
                    
                    <input type="hidden" name="pasajeros[<?= $asiento ?>][asiento]" value="<?= htmlspecialchars($asiento) ?>">

                    <label for="tarifa_<?= $asiento ?>">Tipo de Tarifa:</label>
                    <select id="tarifa_<?= $asiento ?>" name="pasajeros[<?= $asiento ?>][id_tarifa]" required>
                        <option value="">-- Seleccione una tarifa --</option>
                        <?php foreach ($tarifas as $tarifa): ?>
                            <option value="<?= $tarifa['id_tarifa'] ?>">
                                <?= htmlspecialchars($tarifa['Tipo']) ?> ($<?= htmlspecialchars($tarifa['PrecioBase']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="curp_<?= $asiento ?>">CURP:</label>
                    <input type="text" id="curp_<?= $asiento ?>" name="pasajeros[<?= $asiento ?>][curp]" required maxlength="18">

                    <label for="nombre_<?= $asiento ?>">Nombre:</label>
                    <input type="text" id="nombre_<?= $asiento ?>" name="pasajeros[<?= $asiento ?>][nombre]" required>

                    <label for="apellido_<?= $asiento ?>">Apellido:</label>
                    <input type="text" id="apellido_<?= $asiento ?>" name="pasajeros[<?= $asiento ?>][apellido]" required>
                    
                    <label for="telefono_<?= $asiento ?>">Teléfono (Opcional):</label>
                    <input type="text" id="telefono_<?= $asiento ?>" name="pasajeros[<?= $asiento ?>][telefono]">
                </fieldset>
            <?php endforeach; ?>
            
            <input type="submit" value="Finalizar Compra">
        </form>
    </div>
</body>
</html>