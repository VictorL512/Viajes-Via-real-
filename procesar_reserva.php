<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['id_viaje'], $_POST['pasajeros'])) {
    die("Error: Faltan datos para procesar la reserva.");
}

$id_viaje = $_POST['id_viaje'];
$pasajeros_data = $_POST['pasajeros']; 

$conexion->beginTransaction();

try {
    $sql_pasajero = "INSERT INTO Pasajero (CURP, Nombre, Apellido, Telefono) 
                     VALUES (?, ?, ?, ?)
                     ON DUPLICATE KEY UPDATE Nombre = VALUES(Nombre), Apellido = VALUES(Apellido), Telefono = VALUES(Telefono)";
    $stmt_pasajero = $conexion->prepare($sql_pasajero);

    $sql_boleto = "INSERT INTO Boleto (id_viaje, NumeroAsiento, Pasajero_CURP, id_tarifa) 
                   VALUES (?, ?, ?, ?)";
    $stmt_boleto = $conexion->prepare($sql_boleto);

    foreach ($pasajeros_data as $data) {
        $asiento = $data['asiento'];
        $id_tarifa = $data['id_tarifa'];
        $curp = $data['curp'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $telefono = $data['telefono'] ?? ''; 

        $stmt_pasajero->execute([$curp, $nombre, $apellido, $telefono]);

        $stmt_boleto->execute([$id_viaje, $asiento, $curp, $id_tarifa]);
    }

    $conexion->commit();

    header("Location: confirmacion.php?status=success&viaje=" . $id_viaje);
    exit;

} catch (PDOException $e) {
    $conexion->rollBack();
    die("Error al guardar la reserva: " . $e->getMessage() . ". Es posible que alguien más haya tomado uno de los asientos. Inténtalo de nuevo.");
}
?>