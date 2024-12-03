<?php
// Base de datos
require __DIR__ . '/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');

// Solo para las secciones que son exclusivas de un usuario loggeado
// if (!$_SESSION['login']) {
//     header('Location: /');
// }
?>

<main class="contenedor seccion">
    <h1 class="titulo"></h1>
    <p class="descripcion">
        
    </p>
</main>

<div class="contenedor seccion">
</div>

<?php
incluirTemplate('footer');
?>