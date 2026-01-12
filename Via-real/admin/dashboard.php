<?php 
require 'header.php'; 
?>

<h1>Bienvenido al Panel, <?= htmlspecialchars($_SESSION['admin_nombre']) ?>!</h1>
<p>Desde aquí puedes gestionar los viajes, los autobuses (unidades) y los conductores de la central.</p>
<p>Usa el menú de navegación de arriba para empezar.</p>

<?php 
require 'footer.php'; 
?>