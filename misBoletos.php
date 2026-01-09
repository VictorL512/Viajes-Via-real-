<?php
require 'conexion.php';

$boletos_encontrados = [];
$busqueda_realizada = false;
$error = '';

if (isset($_GET['curp'])) {
    $curp = trim($_GET['curp']);
    $busqueda_realizada = true;

    try {
        $sql = "SELECT B.NumeroAsiento, B.FechaVenta, 
                       V.Origen, V.Destino, V.FechaSalida, V.HoraSalida,
                       A.Modelo, T.Tipo, T.PrecioBase,
                       P.Nombre, P.Apellido
                FROM Boleto B
                JOIN Viaje V ON B.id_viaje = V.id_viaje
                JOIN Autobus A ON V.Autobus_Placa = A.Placa
                JOIN Tarifa T ON B.id_tarifa = T.id_tarifa
                JOIN Pasajero P ON B.Pasajero_CURP = P.CURP
                WHERE B.Pasajero_CURP = ?
                ORDER BY V.FechaSalida DESC";

        if (class_exists('R')) {
            $boletos_encontrados = R::getAll($sql, [$curp]);
        } else {
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$curp]);
            $boletos_encontrados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (Exception $e) {
        $error = "Error al buscar boletos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Boletos - Central "Vía Real"</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .search-box {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .search-box input[type="text"] {
            width: 300px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .ticket-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ticket-info h3 { margin: 0 0 10px 0; color: #004e92; }
        .ticket-info p { margin: 5px 0; color: #555; }
        .ticket-seat {
            text-align: center;
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            min-width: 100px;
        }
        .ticket-seat span { font-size: 2em; font-weight: bold; color: #004e92; display: block; }
        .ticket-seat small { color: #666; text-transform: uppercase; font-size: 0.8em; }
    </style>
</head>
<body>

    <header class="header-titulo" style="padding: 40px 20px; margin-bottom: 30px;">
        <div class="contenido-header">
            <h1>Mis Boletos</h1>
            <p>Consulta tu historial de viajes</p>
        </div>
    </header>

    <div class="container">
        
        <div style="margin-bottom: 20px;">
            <a href="index.php" class="btn" style="background-color: #6c757d;">&larr; Volver al Inicio</a>
        </div>

        <div class="search-box">
            <form action="misBoletos.php" method="GET">
                <label for="curp" style="display: block; margin-bottom: 10px;">Ingresa tu CURP para buscar tus boletos:</label>
                <input type="text" name="curp" id="curp" required value="<?= htmlspecialchars($_GET['curp'] ?? '') ?>">
                <input type="submit" value="Buscar" class="btn" style="margin-left: 10px;">
            </form>
        </div>

        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($busqueda_realizada): ?>
            <?php if (!empty($boletos_encontrados)): ?>
                <h3>Boletos encontrados para: <?= htmlspecialchars($boletos_encontrados[0]['Nombre'] . ' ' . $boletos_encontrados[0]['Apellido']) ?></h3>
                
                <?php foreach ($boletos_encontrados as $boleto): ?>
                    <div class="ticket-card">
                        <div class="ticket-info">
                            <h3><?= htmlspecialchars($boleto['Origen']) ?> &rarr; <?= htmlspecialchars($boleto['Destino']) ?></h3>
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($boleto['FechaSalida']) ?> <strong>Hora:</strong> <?= htmlspecialchars($boleto['HoraSalida']) ?></p>
                            <p><strong>Autobús:</strong> <?= htmlspecialchars($boleto['Modelo']) ?></p>
                            <p><strong>Tarifa:</strong> <?= htmlspecialchars($boleto['Tipo']) ?> ($<?= htmlspecialchars($boleto['PrecioBase']) ?>)</p>
                            <p><small>Comprado el: <?= htmlspecialchars($boleto['FechaVenta']) ?></small></p>
                        </div>
                        <div class="ticket-seat">
                            <small>Asiento</small>
                            <span><?= htmlspecialchars($boleto['NumeroAsiento']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <p>No se encontraron boletos asociados a este CURP.</p>
                    <p><small>Verifica que el CURP esté escrito correctamente.</small></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>

</body>
</html>