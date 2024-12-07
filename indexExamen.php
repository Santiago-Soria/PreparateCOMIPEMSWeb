<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="d-flex2">
    <!-- Menú lateral -->
    <nav class="menu-lateral" id="sidebar">
       
        <div class="accordion" id="materiasAccordion">
            <!-- Reemplaza "Materia X" con los nombres de las materias -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button"  data-bs-toggle="collapse" data-bs-target="#materia1">
                        Razonamiento verbal
                    </button>
                </h2>
                <div id="materia1" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoVerbal" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoVerbal" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoVerbal" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoVerbal" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoVerbal" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia2">
                        Razonamiento matematico
                    </button>
                </h2>
                <div id="materia2" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoMatematico" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoMatematico" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoMatematico" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoMatematico" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="RazonamientoMatematico" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia3">
                        Español
                    </button>
                </h2>
                <div id="materia3" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Español" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Español" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Español" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Español" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Español" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia4">
                        Matematicas
                    </button>
                </h2>
                <div id="materia4" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Matematicas" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Matematicas" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Matematicas" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Matematicas" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Matematicas" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia5">
                        Biologia
                    </button>
                </h2>
                <div id="materia5" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Biologia" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Biologia" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Biologia" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Biologia" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Biologia" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia6">
                        Fisica
                    </button>
                </h2>
                <div id="materia6" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Fisica" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Fisica" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Fisica" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Fisica" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Fisica" data-pregunta="5">5</button>


                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia7">
                        Quimica
                    </button>
                </h2>
                <div id="materia7" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Quimica" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Quimica" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Quimica" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Quimica" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Quimica" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia8">
                        Historia
                    </button>
                </h2>
                <div id="materia8" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Historia" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Historia" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Historia" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Historia" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Historia" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia9">
                        Geografia
                    </button>
                </h2>
                <div id="materia9" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="Geografia" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="Geografia" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="Geografia" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="Geografia" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="Geografia" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materia10">
                        Formacion civica y etica.
                    </button>
                </h2>
                <div id="materia10" class="accordion-collapse collapse" data-bs-parent="#materiasAccordion">
                    <div class="accordion-body">
                        <!-- Botones de preguntas -->
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary btn-sm" data-materia="FCyE" data-pregunta="1">1</button>
                            <button class="btn btn-primary btn-sm" data-materia="FCyE" data-pregunta="2">2</button>
                            <button class="btn btn-primary btn-sm" data-materia="FCyE" data-pregunta="3">3</button>
                            <button class="btn btn-primary btn-sm" data-materia="FCyE" data-pregunta="4">4</button>
                            <button class="btn btn-primary btn-sm" data-materia="FCyE" data-pregunta="5">5</button>

                            <!-- Agrega más botones según sea necesario -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Copia y pega bloques de accordion-item para más materias -->
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="contenido-examen" id="contenedor-examen">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <span id="indice" class="fw-bold text-primary" style="font-size: 1rem;">
                Examen simulacro 1 > Materia: N/A > Pregunta: N/A
            </span>
            <span id="cronometro" class="fw-bold text-danger" style="font-size: 1.2rem;">
                03:00:00
            </span>
        </div>

        <div class="contenedor-examen" id="pregunta-contenedor">
            Aquí aparecerán las preguntas.
        </div>
        <div class="border rounded p-3" id="respuesta-contenedor">
            <form id="opciones-respuesta">
                <label><input type="radio" name="respuesta" value="A"> A</label><br>
                <label><input type="radio" name="respuesta" value="B"> B</label><br>
                <label><input type="radio" name="respuesta" value="C"> C</label><br>
                <label><input type="radio" name="respuesta" value="D"> D</label><br>
            </form>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <button id="btn-anterior" class="btn btn-secondary" style="display: none;">Anterior</button>
            <button id="btn-siguiente" class="btn btn-primary">Siguiente</button>

            <script src="script2.js"></script>

        </div>
    </div>
</div>



<?php
incluirTemplate('footer');
?>

