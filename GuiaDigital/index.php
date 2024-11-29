<?php
// Base de datos
require __DIR__.'/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');
?>


<main class="contenedor seccion">
    <h1 class="titulo">Temario por asignatura</h1>
    <p class="descripcion">
        Aquí encontrarás todo el material necesario para prepararte de manera eficiente en cada área del examen.
        ¡Explora los materiass en detalle, sigue tu progreso y accede a recursos adicionales para mejorar tu
        rendimiento!
    </p>
</main>

<section class="seccion contenedor">
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
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                // Obtener los resultados
                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar los resultados
                if (!empty($materias)) {
                    for ($i = 0; $i < 5; $i++) {
            ?>
                        <div class="accordion-item accordion-item-materias">
                            <div class="item-header">
                                <h2 class="accordion-header">
                                    <div class="icono" style="background-color: <?php echo htmlspecialchars($materias[$i]['color']); ?>;">
                                        <img src="/src/img/<?php echo htmlspecialchars($materias[$i]['icono']); ?>" alt="">
                                    </div>
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>" aria-expanded="false" aria-controls="<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>">
                                        <?php echo htmlspecialchars($materias[$i]['nombre']); ?>
                                    </button>
                                </h2>
                            </div>
                            <div id="<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ol>
                                        <?php
                                        try {
                                            $id_materia = $materias[$i]['id_materia'];
                                            $query = "
                                                    SELECT
                                                        b.nombre AS nombre_bloque
                                                    FROM
                                                        bloque b
                                                    JOIN
                                                        materia m ON b.id_materia = m.id_materia AND m.id_materia = '{$id_materia}';
                                                ";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->execute();

                                            // Obtener los resultados
                                            $bloques = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // Mostrar los resultados
                                            if (!empty($materias)) {
                                                foreach ($bloques as $bloque) { ?>
                                                    <li>
                                                        <div class="accordion-subject">
                                                            <a href="./contenido.php">
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
        <div class="divide-accordion">
            <?php
                    for ($i = 5; $i < 10; $i++) {
            ?>
                <div class="accordion-item accordion-item-materias">
                    <div class="item-header">
                        <h2 class="accordion-header">
                            <div class="icono" style="background-color: <?php echo htmlspecialchars($materias[$i]['color']); ?>;">
                                <img src="/src/img/<?php echo htmlspecialchars($materias[$i]['icono']); ?>" alt="">
                            </div>
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>" aria-expanded="false" aria-controls="<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>">
                                <?php echo htmlspecialchars($materias[$i]['nombre']); ?>
                            </button>
                        </h2>
                    </div>
                    <div id="<?php echo htmlspecialchars($materias[$i]['id_materia']); ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ol>
                                <li>
                                    <div class="accordion-subject">
                                        <a href="#">
                                            <p><?php /*echo htmlspecialchars($materias[$i]['nombre_materias']);*/ ?></p>
                                        </a>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckCheckedDisabled" disabled>
                                        </div>
                                    </div>
                                </li>
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
</section>

<?php incluirTemplate('footer'); ?>