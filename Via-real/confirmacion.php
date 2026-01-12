<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <h1>¡Reserva Exitosa!</h1>
            <p>Tu compra ha sido procesada correctamente.</p>
            <p>Gracias por viajar con nosotros.</p>
        <?php else: ?>
            <h1>Hubo un problema</h1>
            <p>No pudimos procesar tu solicitud.</p>
        <?php endif; ?>
        
        <a href="index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>