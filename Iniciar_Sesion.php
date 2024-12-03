<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<body>

    <header class="header">
        <div class="logo">
            <img src="../Recursos/logo.png" alt="Logo del Programa">
        </div>
        <div class="divider"></div>
        <nav class="nav-buttons">
            <a href="#" class="nav-button">Guía digital</a>
            <a href="#" class="nav-button">Exámenes simulacro</a>
            <a href="#" class="nav-button">Información sobre COMIPEMS</a>
            <a href="#" class="nav-button">Iniciar sesión</a>
        </nav>
    </header>

    <div class="container">

        <!-- Formulario de Inicio de Sesión -->
        <div class="Rectangle">
            <div class="Titulo">
                <div class="text-style-1">Bienvenido,</div>
                ¿Estás listo para aprender un día más?
            </div>
            <form action="#" method="POST">
                <input type="text" placeholder="Correo electronico" required>
                <input type="password" placeholder="Contraseña" required>
                <div class="Olvidaste-tu-contrasea">
                    ¿Olvidaste tu contraseña?
                </div>
                <button type="submit" class="Iniciar-sesion">Iniciar sesión</button>
            </form>
            <div class="NecesitasCuenta">
                ¿Necesitas una cuenta de PrepárateCOMIPEMS?
            </div>
            <div class="CrearCuenta">
                Crear una nueva cuenta
            </div>
        </div>

        <div class="descripcion-con-imagen">
            <div class="imagen-inicio">
                <img src="../Recursos/iniciar_sesion.png" alt="Imagen descriptiva" />
            </div>

        </div>
    </div>

    </div>

    <?php
    incluirTemplate('footer');
    ?>