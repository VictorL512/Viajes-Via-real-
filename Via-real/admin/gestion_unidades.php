<?php 
require 'header.php'; 
require '../conexion.php'; 

$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_placa'])) {
    try {
        $sql_delete = "DELETE FROM Autobus WHERE Placa = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->execute([$_POST['delete_placa']]);
        
        $mensaje = "Unidad eliminada exitosamente.";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'ConstraintViolation') !== false || strpos($e->getMessage(), 'foreign key') !== false) {
            $error = "No se puede borrar: Esta unidad tiene viajes programados o un historial activo.";
        } else {
            $error = "Error al eliminar: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    try {
        $stmt = $conexion->prepare("INSERT INTO Autobus (Placa, Modelo, Capacidad) VALUES (?,?,?)");
        $stmt->execute([$_POST['placa'], $_POST['modelo'], $_POST['cap']]);
        $mensaje = "Unidad agregada exitosamente.";
    } catch (PDOException $e) { 
        $error = "Error al agregar unidad: " . $e->getMessage();
    }
}

$buses = $conexion->query("SELECT * FROM Autobus ORDER BY Placa")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestión de Unidades</h2>

<?php if ($mensaje): ?>
    <p style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; border: 1px solid #c3e6cb;">
        <?= $mensaje ?>
    </p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; border: 1px solid #f5c6cb;">
        <?= $error ?>
    </p>
<?php endif; ?>

<h3>Agregar Nueva Unidad</h3>
<form method="POST" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 30px;">
    <label>Placa:</label> 
    <input type="text" name="placa" required>
    
    <label>Modelo:</label> 
    <input type="text" name="modelo" required>
    
    <label>Capacidad:</label> 
    <input type="number" name="cap" required>
    
    <input type="submit" name="add" value="Agregar Autobús" style="margin-top: 15px;">
</form>

<h3>Unidades Existentes</h3>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Placa</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Modelo</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Capacidad</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($buses as $b): ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px;"><?= htmlspecialchars($b['Placa']) ?></td>
                <td style="padding: 10px;"><?= htmlspecialchars($b['Modelo']) ?></td>
                <td style="padding: 10px;"><?= htmlspecialchars($b['Capacidad']) ?></td>
                <td style="padding: 10px;">
                    <!-- Botón Borrar -->
                    <form action="gestion_unidades.php" method="POST" onsubmit="return confirm('¿Estás seguro de borrar esta unidad?');" style="margin: 0;">
                        <input type="hidden" name="delete_placa" value="<?= htmlspecialchars($b['Placa']) ?>">
                        <input type="submit" value="Borrar" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'footer.php'; ?>