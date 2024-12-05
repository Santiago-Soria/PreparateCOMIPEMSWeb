<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>


<div class="d-flex">
    <!-- Menú lateral -->
    <nav class="col-3 bg-light p-3 vh-100" id="sidebar">
        <h5 class="text-primary text-center">Retroalimentación</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="#" onclick="mostrarResumenGeneral()">Resumen general</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarResultadosPorAsignatura()">Resultados por asignatura</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarSugerenciasPorMateria()">Sugerencias de mejora</a></li>

        </ul>
        <button class="btn btn-danger mt-3 w-100" onclick="reiniciarExamen()">Reiniciar examen</button>
    </nav>

    <!-- Contenido principal -->
    <div class="col-9 p-4" id="contenido-principal">
        <div class="Rectangle-81" id="resumen-general">
            <h2 class="Felicidades-por-completar-el-examen-simulacro">
                ¡Felicidades por completar el examen simulacro!
            </h2>
            <p id="detalle-resultado" class="text-center fw-bold" style="font-size: 1.5rem;">
                Puntaje total: 0/0
            </p>
            <p id="porcentaje-aciertos" class="text-center fw-bold" style="font-size: 1.2rem;">
                Porcentaje de aciertos: %
            </p>
            <p id="calificacion-aciertos" class="text-center fw-bold" style="font-size: 1.2rem;">
                Calificación:
            </p>
        </div>

        <!-- Tabla de resultados por asignatura -->
        <div id="resultados-asignatura" style="display: none;">
            <h3 class="text-center text-primary">Resultados por Asignatura</h3>
            <table class="table table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Asignatura</th>
                        <th>Preguntas</th>
                        <th style="color: green;">Correctas</th>
                        <th style="color: red;">Incorrectas</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody id="tabla-resultados"></tbody>
            </table>
        </div>

        <div id="sugerencias-mejora" class="seccion" style="display: none;">

<h3 class="text-center text-primary">Sugerencias de Mejora</h3>

<div id="contenido-sugerencias">

    <!-- Aquí se insertan dinámicamente las sugerencias -->

</div>

</div>


    </div>
</div>

<script src="script2.js"></script>

<script>
    function reiniciarExamen() {
        window.location.href = 'indexExamen.php';
    }
</script>
<?php
incluirTemplate('footer');
?>