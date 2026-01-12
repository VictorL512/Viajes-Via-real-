<?php
require 'conexion.php';

$proximos_viajes = [];

try {
    $sql_proximos = "SELECT V.*, A.Modelo 
                     FROM Viaje V
                     JOIN Autobus A ON V.Autobus_Placa = A.Placa
                     WHERE V.FechaSalida >= CURDATE() 
                     ORDER BY V.FechaSalida ASC, V.HoraSalida ASC 
                     LIMIT 50";

    if (class_exists('R')) {
        $proximos_viajes = R::getAll($sql_proximos);
    } else {
        $stmt = $conexion->query($sql_proximos);
        $proximos_viajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(Exception $e) {}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Viajes "Vía Real"</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f7fa;
        }

        .header-titulo {
            position: relative;
            text-align: center;
            padding: 60px 20px 40px;
            background: linear-gradient(135deg, #004e92, #000428);
            color: white;
        }

        .contenido-header h1 {
            margin: 0;
            font-size: 3rem;
            font-weight: 700;
        }

        .contenido-header p {
            margin-top: 10px;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .header-actions {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-mis-boletos {
            background-color: #2ecc71;
            color: white;
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-mis-boletos:hover {
            background-color: #27ae60;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 6px 12px;
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <header class="header-titulo">
        <div class="header-actions">
            <a href="misBoletos.php" class="btn-mis-boletos">Ver Mis Boletos</a>
        </div>

        <div class="contenido-header">
            <h1>Viajes "Vía Real"</h1>
        </div>
    </header>

    <div class="container">
        <h2>Próximas Salidas Disponibles</h2>

        <?php if (!empty($proximos_viajes)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Autobús</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proximos_viajes as $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($v['FechaSalida']) ?></td>
                            <td><?= htmlspecialchars($v['HoraSalida']) ?></td>
                            <td><?= htmlspecialchars($v['Origen']) ?></td>
                            <td><?= htmlspecialchars($v['Destino']) ?></td>
                            <td><?= htmlspecialchars($v['Modelo']) ?></td>
                            <td>
                                <a href="asientos.php?id_viaje=<?= $v['id_viaje'] ?>" class="btn">
                                    Comprar Boleto
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center;">No hay viajes programados.</p>
        <?php endif; ?>
    </div>

</body>
</html>
