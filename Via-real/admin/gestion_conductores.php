<?php 
require 'header.php'; 
require '../conexion.php'; 

$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_ine'])) {
    try {
        $sql_delete = "DELETE FROM Conductor WHERE INE = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->execute([$_POST['delete_ine']]);
        
        $mensaje = "Conductor eliminado exitosamente.";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'ConstraintViolation') !== false || strpos($e->getMessage(), 'foreign key') !== false) {
            $error = "No se puede borrar: Este conductor tiene viajes programados o un historial activo.";
        } else {
            $error = "Error al eliminar: " . $e->getMessage();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_telefono'])) {
    try {
        $sql_update = "UPDATE Conductor SET Telefono = ? WHERE INE = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->execute([$_POST['new_telefono'], $_POST['ine_target']]);
        
        $mensaje = "Teléfono actualizado correctamente.";
    } catch (PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_conductor'])) {
    try {
        $sql = "INSERT INTO Conductor (INE, Nombre, Apellido, Telefono) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$_POST['ine'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono']]);
        
        $mensaje = "Conductor agregado exitosamente.";
    } catch (PDOException $e) {
        $error = "Error al agregar conductor: " . $e->getMessage();
    }
}

$conductores = $conexion->query("SELECT * FROM Conductor ORDER BY Apellido, Nombre")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestionar Conductores</h2>

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

<h3>Agregar Nuevo Conductor</h3>
<form action="gestion_conductores.php" method="POST" style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 30px;">
    <!-- CAMBIO: Etiqueta actualizada a solo CURP y sin placeholder -->
    <label for="ine">CURP:</label>
    <input type="text" id="ine" name="ine" required maxlength="18">
    
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required>
    
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono">
    
    <input type="submit" name="add_conductor" value="Agregar Conductor" style="margin-top: 15px;">
</form>

<h3>Conductores Existentes</h3>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">CURP</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Nombre</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Apellido</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Teléfono (Editar)</th>
            <th style="padding: 10px; border-bottom: 2px solid #ddd;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($conductores as $conductor): ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 10px;"><?= htmlspecialchars($conductor['INE']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($conductor['Nombre']) ?></td>
            <td style="padding: 10px;"><?= htmlspecialchars($conductor['Apellido']) ?></td>
            
            <!-- Columna de Teléfono Editable -->
            <td style="padding: 10px;">
                <form action="gestion_conductores.php" method="POST" style="margin: 0; display: flex; gap: 5px;">
                    <input type="hidden" name="ine_target" value="<?= htmlspecialchars($conductor['INE']) ?>">
                    <input type="text" name="new_telefono" value="<?= htmlspecialchars($conductor['Telefono']) ?>" style="width: 100px; padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
                    <input type="submit" name="update_telefono" value="Guardar" style="background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">
                </form>
            </td>

            <td style="padding: 10px;">
                <!-- Botón Borrar -->
                <form action="gestion_conductores.php" method="POST" onsubmit="return confirm('¿Estás seguro de borrar a este conductor?');" style="margin: 0;">
                    <input type="hidden" name="delete_ine" value="<?= htmlspecialchars($conductor['INE']) ?>">
                    <input type="submit" value="Borrar" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php 
require 'footer.php'; 
?>