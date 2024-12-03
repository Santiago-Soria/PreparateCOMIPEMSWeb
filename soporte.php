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

<main class="contenedor seccion contenedor-soporte">
    <h1 class="titulo-soporte">¿En qué podemos ayudarte?</h1>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <button class="btn btn-outline-success" type="submit">
                    <img src="/build/img/lupa-de-busqueda.png" alt="">
                </button>
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
            </form>
        </div>
    </nav>
    <div class="contenedor-apartados">
        <div class="apartado">
            <p class="titulo-apartado">Inicio de sesión</p>
            <p class="pregunta">No puedo restablecer mi contraseña</p>
        </div>
        <div class="apartado">
            <p class="titulo-apartado">Información personal</p>
            <p class="pregunta">¿Cómo actualizo mi información en mi cuenta?</p>
        </div>
        <div class="apartado">
            <p class="titulo-apartado">Eliminar cuenta</p>
            <p class="pregunta">¿Cómo puedo dar de baja mi cuenta si ya no quiero usar la plataforma?</p>
        </div>
    </div>
</main>

<div class="contenedor seccion contenedor-FAQ">
    <div class="faq">
        <h3 class="faq-header">Ayuda sobre los simulacros</h3>
        <ul>
            <li>¿Cómo están estructurados los exámenes simulacros?</li>
            <li>¿Cuántos exámenes simulacros puedo realizar?</li>
            <li>¿Los exámenes simulacros son iguales al examen COMIPEMS real?</li>
            <li>¿Puedo pausar un simulacro y continuarlo después?</li>
            <li>¿Los simulacros son adaptados a mi nivel académico?</li>

        </ul>
    </div>
    <div class="faq">
        <h3 class="faq-header">Preguntas sobre COMIPEMS</h3>
        <ul>
            <li>¿Qué temas se cubren en el examen COMIPEMS?</li>
            <li>¿Cuántas preguntas tiene el examen real?</li>
            <li>¿Cómo está estructurado el examen COMIPEMS?</li>
            <li>¿Qué materiales necesito para presentar el examen?</li>
            <li>¿Cómo se calcula el puntaje del examen COMIPEMS?</li>
        </ul>
    </div>
    <div class="faq">
        <h3 class="faq-header">Soporte tecnico</h3>
        <ul>
            <li>Tengo problemas para acceder a un simulacro, ¿qué puedo hacer?</li>
            <li>¿Cómo puedo contactar al soporte técnico si tengo problemas con la plataforma?</li>
            <li>¿En qué dispositivos puedo usar la plataforma?</li>
            <li>¿La plataforma está disponible como aplicación móvil?</li>
        </ul>
    </div>

</div>

<?php
incluirTemplate('footer');
?>