<?php

$mysql_hostname = "sql104.infinityfree.com";
$mysql_username = "if0_40115718";
$mysql_password = "Matesin67";
$mysql_database = "if0_40115718_practica";

try {
    $conexion = new PDO(
        "mysql:host=$mysql_hostname;dbname=$mysql_database;charset=utf8",
        $mysql_username,
        $mysql_password
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

?>
