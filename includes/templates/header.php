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
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="shortcut icon" href="build/img/icono_pestana.svg">
</head>

<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="<?php echo $auth? '/InicioLoggeado.php' : 'index.php' ?>">
                    <img src="build/img/logo.png" alt="Logotipo de PrepárateCOMIPEMS" class="logo">
                </a>

                <nav class="navegacion">
                    <?php if ($auth): ?>
                        <a href="/InicioLoggeado.php">Inicio</a>
                        <a href="/menuMaterias.php">Guía Dígital</a>
                        <a href="/Examenes_simulacro.php">Exámenes</a>
                        <a href="/progreso.php">Mi Progreso</a>
                        <a href="/comunidad.php">Comunidad</a>
                        <a href="/soporte.php">Soporte</a>
                        <a href="cerrar-sesion.php">
                            <img src="/build/img/logout.svg" alt="Cerrar sesión" title="Cerrar sesión">
                        </a>
                    <?php endif;
                    if (!$auth): ?>
                        <a href="/menuMaterias.php">Guía digital</a>
                        <a href="Examenes_simulacro.php">Examenes Simulacro</a>
                        <a href="https://guias2024.comipems.org.mx/">Información sobre COMIPEMS</a>
                        <a href="login.php" class="active">Iniciar sesión</a>
                    <?php endif; ?>
                </nav>
            </div> <!-- .barra -->
        </div>
    </header>