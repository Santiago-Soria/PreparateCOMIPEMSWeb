<?php
// Base de datos
require __DIR__ . '/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');
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

<div class="contenedor seccion contenedor-progreso">
    <h3>!Sigue adelante y mejora tus habilidades en los temas que más lo necesitan para lograr el éxito!</h3>
    <div class="contenedor barra-progreso">

    </div>
    <div class="contenedor contenedor-charts-progreso">
        <div class="contenedor-acordeon-progreso">
            <div class="accordion accordion-materias" id="accordionExample">
                <div class="divide-accordion">
                    <?php
                    try {
                        $query = "
                        SELECT 
                            id_materia,
                            nombre,
                            icono,
                            color
                        FROM 
                            materia;
                    ";

                        // Obtener los resultados
                        $materias = consultaBD($query, $pdo, true);

                        // Mostrar los resultados
                        if (!empty($materias)) {
                            foreach ($materias as $materia) {
                    ?>
                                <div class="accordion-item accordion-item-materias">
                                    <div class="item-header">
                                        <h2 class="accordion-header">
                                            <div class="icono" style="background-color: <?php echo htmlspecialchars($materia['color']); ?>;">
                                                <img src="/build/img/iconos/<?php echo htmlspecialchars($materia['icono']); ?>" alt="">
                                            </div>
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#<?php echo htmlspecialchars($materia['id_materia']); ?>" aria-expanded="false" aria-controls="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                                <?php echo htmlspecialchars($materia['nombre']); ?>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="<?php echo htmlspecialchars($materia['id_materia']); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ol>
                                                <?php
                                                try {
                                                    $id_materia = $materia['id_materia'];
                                                    $query = "
                                                    SELECT
                                                        b.nombre AS nombre_bloque,
                                                        b.id_bloque AS id_bloque
                                                    FROM
                                                        bloque b
                                                    JOIN
                                                        materia m ON b.id_materia = m.id_materia AND m.id_materia = '{$id_materia}';
                                                ";

                                                    $bloques = consultaBD($query, $pdo, true);

                                                    // Mostrar los resultados
                                                    if (!empty($materias)) {
                                                        foreach ($bloques as $bloque) {
                                                            $rutaContenido = isset($_SESSION['login']) ? "./contenidoGuiaDigital.php?materia=" . $materia['id_materia'] . "&bloque=" . $bloque['id_bloque'] : '#'
                                                ?>
                                                            <li>
                                                                <div class="accordion-subject">
                                                                    <a href="<?php echo $rutaContenido ?>">
                                                                        <p><?php echo htmlspecialchars($bloque['nombre_bloque']); ?></p>
                                                                    </a>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" value=""
                                                                            id="flexCheckCheckedDisabled" disabled>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                <?php }
                                                    }
                                                } catch (PDOException $e) {
                                                    // Manejo de error en la consulta
                                                    echo "Error al realizar la consulta: " . $e->getMessage();
                                                }
                                                ?>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                </div>
        <?php }
                    } catch (PDOException $e) {
                        // Manejo de error en la consulta
                        echo "Error al realizar la consulta: " . $e->getMessage();
                    }
        ?>

            </div>
        </div>
        <div class="chart-progreso">

        </div>
        <div class="chart-progreso">

        </div>
    </div>
</div>

<?php
incluirTemplate('footer');
?>