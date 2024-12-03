<?php
// Base de datos
require __DIR__ . '/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');

// Solo para las secciones que son exclusivas de un usuario loggeado
if (!$_SESSION['login']) {
    header('Location: /');
}
?>

<main class="contenedor seccion">
    <h1 class="titulo">Progreso Asignarura</h1>
    <p class="descripcion">
        En esta sección podrás consultar tu progreso detallado en cada una de las asignaturas que forman parte del examen COMIPEMS. Se presenta un desglose por temas, permitiéndote identificar las áreas en las que has avanzado y aquellas que requieren mayor enfoque. Utiliza esta herramienta para gestionar tu estudio de manera eficiente y optimizar tu rendimiento académico.
    </p>
</main>

<div class="contenedor seccion">
</div>

<?php
incluirTemplate('footer');
?>