<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="contenedor seccion">
    <div class="contenedorInvitado">
        <h2>Explora algunos de los recursos que ofrecemos y empieza a prepararte para el examen</h2>
        <div class="contenedor-opcionesInvitado">
            <div class="contenedor-opcion contenedor-examenSimulacro">
                <div class="contenedor-imagen">
                    <img src="build/img/iconoSimulacroInvitado.png" alt="">
                </div>
                <h3>Examen Simulacro</h3>
                <p>
                    Realiza un examen de 30 preguntas para probar tu conocimiento.
                    <ul>
                        <li><strong>Acceso limitado:</strong> Este examen cubre temas generales del COMIPEMS.</li>
                        <li><strong>Puntaje general:</strong> Al finalizar el examen, recibirás un puntaje total, pero no tendrás acceso a un desglose detallado de tus respuestas.</li>
                    </ul>
                </p>
                <a href="/indexExamen.php" class="boton">Realizar examen</a>
            </div>
            <div class="contenedor-opcion contenedor-previaTemario">
                <div class="contenedor-imagen">
                    <img src="build/img/iconoPreviaInvitado.png" alt="">
                </div>
                <h3>Vista previa del temario</h3>
                <p>
                    Accede a los primeros temas de la guía oficial COMIPEMS y descubre cómo te preparamos para el éxito.
                    <ul>
                        <li><strong>Temario disponible:</strong> Explora capítulos iniciales de Español y Matemáticas.</li>
                        <li><strong>Acceso completo:</strong> Regístrate para desbloquear la guía completa.</li>
                    </ul>
                </p>
                <a href="/menuMaterias.php" class="boton">Ver temario</a>
            </div>
        </div>
    </div>
</div>

<?php
incluirTemplate('footer');
?>