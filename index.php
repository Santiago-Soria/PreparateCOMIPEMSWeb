<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<body>

<div class="container">
    <div class="Texto-Bienvenida">
        ¡Prepárate para el examen COMIPEMS y asegura tu lugar en la escuela de tus sueños!
    </div>

    <div class="descripcion-con-imagen">
        <div class="imagen-plataforma">
            <img src="build/img/escuelasycomipems.png" alt="Imagen descriptiva" />
        </div>
        <div class="descripcion-plataforma">
            En esta plataforma, tienes acceso al temario oficial del COMIPEMS y una serie de exámenes simulacro diseñados para ayudarte a identificar tus fortalezas y debilidades.
        
            <div class="descripcion-plataforma_2">
                ¡Todo lo que necesitas para estar listo para el examen está aquí, en un solo lugar!
            </div>

            <button class="Rectangle1">Empieza a aprender</button>
            <button class="Rectangle2">Continuar como invitado</button>
        </div>
    </div>
</div>

<?php
incluirTemplate('footer');
?>
