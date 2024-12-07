<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1 class="titulo">Exámenes simulacro</h1>
    <p class="descripcion">
    Aquí podrás practicar con exámenes simulacro que te ayudarán a prepararte para el examen. Realiza el examen completo 
    y recibe retroalimentación inmediata sobre tu desempeño, con detalles sobre tus aciertos y áreas de mejora.
    </p>
</main>


<!-- Contenedor principal dividido en dos columnas -->
<div class="container">
    <!-- Menú de exámenes simulacro -->
    <div class="menu-examenes">
        <div class="Rectangle-50">
            <div class="icono"><img src="../build/img/examen.png" alt="Icono examen"></div>
            <div class="accordion-item accordion-item-materias">Examen Simulacro 1</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../Recursos/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen Simulacro 2</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../Recursos/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen Simulacro 3</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../Recursos/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen Simulacro 4</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        
    </div>

    <!-- Frase motivacional -->
    <div class="frase-motivacional">
        <span class="Estas-a-un-solo-paso-Tu-puedes">
            Estás a un solo paso,<br>¡Tú puedes!
        </span>
    </div>
</div>


<?php
incluirTemplate('footer');
?>