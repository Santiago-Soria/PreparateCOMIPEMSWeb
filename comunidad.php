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

<?php
incluirTemplate('footer');
?>