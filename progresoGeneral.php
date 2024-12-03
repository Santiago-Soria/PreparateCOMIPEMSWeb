<?php
require 'includes/funciones.php';
incluirTemplate('header');
if (!$_SESSION['login']) {
    header('Location: /');
}
?>

<main class="contenedor seccion">
    <h1 class="titulo">Progreso general</h1>
    <p class="descripcion">
        En esta sección, puedes ver un resumen de tu progreso total en la preparación para el examen COMIPEMS. A medida que completas actividades, ejercicios y simulacros, tu avance se actualiza automáticamente. Revisa tu rendimiento global y monitorea cuánto has avanzado en cada asignatura.
    </p>
</main>

<div class="contenedor seccion contenedor-progreso">
    <h3>!Sigue adelante y mejora tus habilidades en los temas que más lo necesitan para lograr el éxito!</h3>
    <div class="contenedor barra-progreso">
        <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 80%">80%</div>
        </div>
    </div>
    <div class="contenedor contenedor-charts-progreso">
        <div class="chart-progreso">

        </div>
        <div class="chart-progreso">

        </div>
    </div>
</div>

<?php
incluirTemplate('footer');
?>