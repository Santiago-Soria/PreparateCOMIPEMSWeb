<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<body>

    <div class="contenedor seccion">
        <h2 class="Texto-Bienvenida">
            ¡Prepárate para el examen COMIPEMS y asegura tu lugar en la escuela de tus sueños!
        </h2>

        <div class="descripcion-con-imagen">
            <div class="imagen-plataforma">
                <img src="build/img/escuelasycomipems.png" alt="Imagen descriptiva" />
            </div>
            <div class="descripcion-plataforma">
                <div class="descripcion-plataforma-texto">
                    <p>
                        En esta plataforma, tienes acceso al temario oficial del COMIPEMS y una serie de exámenes simulacro diseñados para ayudarte a identificar tus fortalezas y debilidades.
                        <br>
                        ¡Todo lo que necesitas para estar listo para el examen está aquí, en un solo lugar!
                    </p>
                </div>

                <div class="enlaces-bienvenida">
                    <a href="/login.php">Empieza a aprender</a>
                    <a href="">Continuar como invitado</a>
                </div>
            </div>
        </div>
    </div>

    <?php
    incluirTemplate('footer');
    ?>