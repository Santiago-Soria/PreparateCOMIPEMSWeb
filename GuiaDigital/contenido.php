<?php
// Base de datos
require __DIR__ . '/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');

// Obtener las variables del enlace
if (isset($_GET['bloque'])) {
    $id_bloque = htmlspecialchars($_GET['bloque']);
} else {
    echo "Faltan parámetros en el enlace.";
}

try {
    $query = "
    SELECT
        m.nombre AS nombre_materia,
        m.icono AS icono_materia,
        m.color AS color_materia,
        m.id_materia AS id_materia,
        b.nombre AS nombre_bloque,
        b.id_bloque AS id_bloque
    FROM
        bloque b
    JOIN
        materia m ON b.id_materia = m.id_materia
    WHERE id_bloque='{$id_bloque}';
    ";

    // Obtener los resultados
    $materia_bloque = consultaBD($query, $pdo, false);
    // Imprimir el arreglo
    // echo '<pre>'; // Formatea la salida para facilitar la lectura
    // print_r($materia_bloque);
    // echo '</pre>';
} catch (PDOException $e) {
    // Manejo de error en la consulta
    echo "Error al realizar la consulta: " . $e->getMessage();
}
?>

<main class="contenedor seccion contenedor-contenido">
    <section class="acordeon-contenido">
        <div class="header-contenido">
            <div class="icono" style="background-color: <?php echo htmlspecialchars($materia_bloque['color_materia']); ?>">
                <img src="/src/img/<?php echo htmlspecialchars($materia_bloque['icono_materia']); ?>" alt="">
            </div>
            <h1 class="titulo titulo-contenido"><?php echo htmlspecialchars($materia_bloque['nombre_materia']); ?></h1>
        </div>
        <div class="accordion accordion-contenido" id="accordionExample">
            <?php
            try {
                $id_materia = $materia_bloque['id_materia'];
                $query = "
                    SELECT
                        nombre,
                        id_bloque
                    FROM
                        bloque
                    WHERE id_materia='{$id_materia}';
                    ";
                $bloques = consultaBD($query, $pdo, true);
            } catch (PDOException $e) {
                // Manejo de error en la consulta
                echo "Error al realizar la consulta: " . $e->getMessage();
            }

            foreach ($bloques as $bloque) {
                $mismo_bloque = ($materia_bloque['id_bloque'] === $bloque['id_bloque']) ? true : false;
                $area_expanded = $mismo_bloque ? 'true' : 'false';
            ?>
                <div class="accordion-item accordion-item-contenido <?php if($mismo_bloque) echo 'item-background' ?>">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-contenido <?php echo $mismo_bloque ? '' : 'collapsed' ?> " type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo htmlspecialchars($bloque['id_bloque']); ?>" aria-expanded="<?php $area_expanded ?>" aria-controls="<?php echo htmlspecialchars($bloque['id_bloque']); ?>">
                            <?php echo htmlspecialchars($bloque['nombre']); ?>
                        </button>
                    </h2>
                    <div id="<?php echo htmlspecialchars($bloque['id_bloque']); ?>" class="accordion-collapse collapse <?php echo $mismo_bloque ? 'show' : '' ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ol>
                                <?php
                                try {
                                    $id_bloque = $bloque['id_bloque'];
                                    $query = "SELECT id_tema, nombre FROM tema WHERE id_bloque = '{$id_bloque}'";
                                    $temas = consultaBD($query, $pdo, true);
                                } catch (PDOException $e) {
                                    // Manejo de error en la consulta
                                    echo "Error al realizar la consulta: " . $e->getMessage();
                                }
                                foreach ($temas as $tema) {
                                ?>
                                    <li><a href="./contenido.php?materia=<?php echo $id_materia ?>&bloque=<?php echo $id_bloque ?>&tema=<?php echo htmlspecialchars($tema['id_tema']) ?>" class="enlace-tema-contenido"><?php echo htmlspecialchars($tema['nombre']); ?></a></li>
                                <?php
                                }
                                ?>
                            </ol>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
    <section class="contenido">
        <?php
        if (isset($_GET['tema'])) {
            $id_tema = htmlspecialchars($_GET['tema']);
            try {
                $query = "
                    SELECT *
                    FROM tema 
                    WHERE id_tema= $id_tema;
                    ";

                // Obtener los resultados
                $tema_contenido = consultaBD($query, $pdo, false);
                // Imprimir el arreglo
                // echo '<pre>'; // Formatea la salida para facilitar la lectura
                // print_r($materia_bloque);
                // echo '</pre>';
        ?>
                <div class="ruta-contenido">
                    <img src="./src/img/icono-guia.svg" class="icono icono-guia" alt="">
                    <p class="ruta">
                        Guía dígital &gt;
                        <?php echo htmlspecialchars($materia_bloque['nombre_materia']); ?> &gt;
                        <?php echo htmlspecialchars($materia_bloque['nombre_bloque']); ?> &gt;
                        <strong><?php echo htmlspecialchars($tema_contenido['nombre']); ?></strong>
                    </p>
                </div>
                <div class="llenado-contenido">
                    <?php
                    $contenido = $tema_contenido['contenido'];
                    if ($contenido) {
                        $jsonData = file_get_contents("src/contenido-json/{$contenido}");
                        $dataObject = json_decode($jsonData);
                        echo $dataObject->texto; // Muestra el contenido de "texto"
                    } else {
                    ?>
                        <h2 class="titulo" style="width:100%; text-align: center;">Lo sentimos aún no hay contenido para este tema 😢</h2>
                    <?php
                    }
                    if (isset($dataObject->recurso)) {
                    ?>
                        <div class="contenido-recurso">
                            <h2>¡Complementa tu conocimiento con un vídeo!</h2>
                            <?php echo $dataObject->recurso; ?>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            <?php
            } catch (PDOException $e) {
                // Manejo de error en la consulta
                echo "Error al realizar la consulta: " . $e->getMessage();
            }
        } else {
            ?>
            <div class="ruta-contenido">
                <img src="./src/img/icono-guia.svg" class="icono icono-guia" alt="">
                <p class="ruta">
                    Guía dígital &gt;
                    <?php echo htmlspecialchars($materia_bloque['nombre_materia']); ?> &gt;
                    <strong><?php echo htmlspecialchars($materia_bloque['nombre_bloque']); ?></strong>
                </p>
            </div>
            <h2 class="titulo" style="width:100%; text-align: center;">¡Selecciona un tema para comenzar!</h2>
            <div style="display: flex; align-items: center; justify-content: center; height: 80%;">
                <img src="./src/img/logo.png" alt="" style="width: 80%;">
            </div>
        <?php
        }
        ?>

    </section>
</main>

<?php
incluirTemplate('footer');
?>