<?php
if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrepárateCOMIPEMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="shortcut icon" href="build/img/icono_pestana.svg">
</head>

<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="build/img/logo.png" alt="Logotipo de PrepárateCOMIPEMS" class="logo">
                </a>

                <nav class="navegacion">
                    <?php if ($auth): ?>
                        <a href="#">Inicio</a>
                        <a href="#" class="active">Guía Dígital</a>
                        <a href="#">Exámenes</a>
                        <a href="#">Mi Progrso</a>
                        <a href="#">Comunidad</a>
                        <a href="#">Soporte</a>
                        <a href="cerrar-sesion.php">
                            <img src="/build/img/logout.svg" alt="Cerrar sesión" title="Cerrar sesión">
                        </a>
                    <?php else: ?>
                        <a href="#">Guía digital</a>
                        <a href="#">Examenes Simulacro</a>
                        <a href="#">Información sobre COMIPEMS</a>
                        <a href="iniciar-sesion.php">
                            <img src="/build/img/login.svg" alt="Iniciar sesión" title="Iniciar sesión">
                        </a>
                    <?php endif; ?>
                </nav>
            </div> <!-- .barra -->
        </div>
    </header>