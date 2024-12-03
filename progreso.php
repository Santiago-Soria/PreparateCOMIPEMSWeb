<?php
require 'includes/funciones.php';
incluirTemplate('header');
if (!$_SESSION['login']) {
    header('Location: /');
}
?>

<main class="contenedor seccion">
    <h1 class="titulo">Mi progreso</h1>
    <p class="descripcion">
        Aquí podrás visualizar tu avance general y tu rendimiento por asignatura.
    </p>
</main>

<div class="contenedor seccion">
    <div class="contenedorInvitado">
        <div class="contenedor-opcionesInvitado">
            <div class="contenedor-opcion contenedor-examenSimulacro">
                <div class="contenedor-imagen">
                    <img src="build/img/progresoGeneral.png" alt="">
                </div>
                <h3>Progreso general</h3>
                <p>
                    En esta sección podrás visualizar tu avance general en la plataforma, mostrando un resumen detallado de tus examenes simulacros y el porcentaje total de progreso en todas las asignaturas.
                </p>
                <a href="/progresoGeneral.php" class="boton">Ver progreso</a>
            </div>
            <div class="contenedor-opcion contenedor-previaTemario">
                <div class="contenedor-imagen">
                    <img src="build/img/progresoAsignatura.png" alt="">
                </div>
                <h3>Progreso por asignatura</h3>
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