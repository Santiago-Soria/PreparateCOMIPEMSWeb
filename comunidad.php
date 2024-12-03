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

<main class="contenedor seccion contenedor-comunidad">
    <div class="contenedor-descripcion">
        <h1 class="titulo">Únete a nuestra comunidad</h1>
        <p class="descripcion">
            Interactúa con otros estudiantes que, como tú, están preparándose para el exámen. Comparte tu experiencia, resuelve dudas y encuentra apoyo en nuestra comunidad.
            <br><br>
            <strong>¿Qué necesitas para unirte?</strong>
        </p>
            <ol>
                <li>Crea tu cuenta de Discord para poder entrar a la comunidad.</li>
                <li>Ingresa por medio del siguiente botón:</li>
            </ol>
            <a href="#" class="boton">Ir a la comunidad</a>
    </div>
    <div class="contenedor-imagenes">
        <div class="contenedor-imagen">
            <img src="/build/img/comunidad.png" alt="">
            <img src="/build/img/comunidadDiscord.png" alt="">
        </div>
    </div>
</main>

<div class="contenedor seccion">
</div>

<?php
incluirTemplate('footer');
?>