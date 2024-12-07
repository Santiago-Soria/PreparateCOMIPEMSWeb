<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="d-flex">
    <!-- Menú lateral -->
    <nav class="menu-lateral" id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="#" onclick="mostrarResumenGeneral()">Resumen general</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarResultadosPorAsignatura()">Resultados por asignatura</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarSugerenciasPorMateria()">Sugerencias de mejora</a></li>
        </ul>
        <button class="btn btn-danger mt-3 w-100" onclick="reiniciarExamen()">Reiniciar examen</button>
    </nav>

    <!-- Contenido principal -->
    <div class="contenido-examen" id="contenido-principal">
        <div class="Rectangle-81" id="resumen-general">
            <h1 class="titulo">
                ¡Felicidades por completar el examen simulacro!
            </h1>
            <p id="detalle-resultado" class="text-center fw-bold" style="font-size: 1.5rem;">
                Puntaje total: 0/0
            </p>
            <p id="porcentaje-aciertos" class="text-center fw-bold" style="font-size: 1.5rem;">
                Porcentaje de aciertos: %
            </p>
            <p id="calificacion-aciertos" class="text-center fw-bold" style="font-size: 1.5rem;">
                Calificación:
            </p>
            <div id="mensaje-motivacional" class="h1" style="margin-top: 60px; text-align: center;">
                 Tu mensaje motivacional aquí
            </div>
        </div>

        <!-- Tabla de resultados por asignatura -->
        <div id="resultados-asignatura" style="display: none;">
            <h1 class="titulo">Resultados por asignatura</h1>
            <table class="table table-bordered mt-4">
                <thead class="table-primary">
                    <th style="background-color: #004C84; color: white;">Asignatura</th> 
                    <th style="background-color: #004C84; color: white;">Preguntas</th> 
                    <th style="background-color: #004C84; color: white;">Correctas</th> 
                    <th style="background-color: #004C84; color: white;">Incorrectas</th> 
                    <th style="background-color: #004C84; color: white;">Porcentaje</th>
                </thead>
                <tbody id="tabla-resultados"></tbody>
            </table>
        </div>

        <!-- Sugerencias de mejora -->
        <div id="sugerencias-mejora" class="seccion" style="display: none;">
            <h1 class="titulo">Sugerencias de mejora</h1>
            <div id="contenido-sugerencias">
                <!-- Aquí se insertan dinámicamente las sugerencias -->
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarReinicioModal" tabindex="-1" aria-labelledby="confirmarReinicioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmarReinicioModalLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que quieres reiniciar tu examen?
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
