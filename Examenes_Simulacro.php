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
            <div class="letra-2"><img src="../build/img/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen simulacro 1</div>
            <button class="Iniciar" onclick="reiniciarExamen()">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../build/img/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen simulacro 2</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../build/img/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen simulacro 3</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        <div class="Rectangle-50">
            <div class="letra-2"><img src="../build/img/examen.png" alt="Icono examen"></div>
            <div class="Examen-simulacro-1">Examen simulacro 4</div>
            <button class="Iniciar">Iniciar</button>
        </div>
        
    </div>


</div>


<div class="modal fade" id="confirmarReinicioModal" tabindex="-1" aria-labelledby="confirmarReinicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmarReinicioModalLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que quieres iniciar tu examen?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarReinicio">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="script2.js"></script>

<script>
    // Función para mostrar el modal de confirmación
    function reiniciarExamen() {
        const modal = new bootstrap.Modal(document.getElementById('confirmarReinicioModal'));
        modal.show();

        // Configurar el botón "Aceptar" dentro del modal
        document.getElementById('btnConfirmarReinicio').addEventListener('click', () => {
            // Limpiar respuestas y resultados del localStorage
            localStorage.removeItem("respuestasUsuario");
            localStorage.removeItem("resultadoExamen");
            localStorage.removeItem("resultadoExamenPorMateria");

            // Redirigir a indexExamen.php
            window.location.href = 'indexExamen.php';
        });
    }
</script>

<?php
incluirTemplate('footer');
?>