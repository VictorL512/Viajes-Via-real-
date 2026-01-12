<?php
session_start();
require '../conexion.php';

$error_login = '';

if (isset($_SESSION['admin_id'])) {
    header("Location: gestion_viajes.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM admin_usuarios WHERE usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $password_limpia = trim($password);
        $password_hasheada = hash('sha256', $password_limpia);

        if ($user && $password_hasheada === $user['password_hash']) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_usuario'] = $user['usuario'];
            $_SESSION['admin_nombre'] = $user['nombre_completo'];
            
            header("Location: gestion_viajes.php");
            exit;
        } else {
            $error_login = "Usuario o contraseña incorrectos.";
        }

    } catch (PDOException $e) {
        $error_login = "Error de base de datos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de Administración</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .mostrar-pass-wrapper {
            margin-top: -10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
        }
        .mostrar-pass-wrapper input {
            width: auto;
            margin-right: 8px;
            margin-bottom: 0;
            cursor: pointer;
        }
        .mostrar-pass-wrapper label {
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 50px;">
        <h2 style="text-align: center;">Acceso de Administrador</h2>
        
        <?php if ($error_login): ?>
            <p style="color: red; text-align: center;"><?= $error_login ?></p>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <div class="mostrar-pass-wrapper">
                <input type="checkbox" id="checkMostrar" onclick="mostrarPassword()">
                <label for="checkMostrar">Mostrar contraseña</label>
            </div>

            <input type="submit" value="Entrar">
        </form>
    </div>

    <script>
        function mostrarPassword() {
            var inputPass = document.getElementById("password");
            if (inputPass.type === "password") {
                inputPass.type = "text";
            } else {
                inputPass.type = "password";
            }
        }
    </script>
</body>
</html>