<?php
// Base de datos
require __DIR__.'/includes/config/database.php';
$pdo = conectarDB();

require 'includes/funciones.php';
incluirTemplate('header');

$id_tema = 1;

try {
    $query = "
    SELECT
        m.nombre AS nombre_materia,
        m.icono AS icono_materia,
        m.color AS color_materia,
        m.id_materia AS id_materia,
        b.nombre AS nombre_bloque,
        b.id_bloque AS id_bloque,
        t.nombre AS nombre_tema,
        t.contenido AS contenido_tema
    FROM
        tema t
    JOIN
        bloque b ON t.id_bloque = b.id_bloque
    JOIN
        materia m ON b.id_materia = m.id_materia
    WHERE id_tema='{$id_tema}';
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    $contenido = $stmt->fetch(PDO::FETCH_ASSOC);
    // Imprimir el arreglo
    // echo '<pre>'; // Formatea la salida para facilitar la lectura
    // print_r($contenido);
    // echo '</pre>';
} catch (PDOException $e) {
    // Manejo de error en la consulta
    echo "Error al realizar la consulta: " . $e->getMessage();
}
?>

<main class="contenedor seccion contenedor-contenido">
    <section class="acordeon-contenido">
        <div class="header-contenido">
            <div class="icono" style="background-color: <?php echo htmlspecialchars($contenido['color_materia']); ?>">
                <img src="/src/img/<?php echo htmlspecialchars($contenido['icono_materia']); ?>" alt="">
            </div>
            <h1 class="titulo titulo-contenido"><?php echo htmlspecialchars($contenido['nombre_materia']); ?></h1>
        </div>
        <div class="accordion accordion-contenido" id="accordionExample">
            <?php
            try {
                $id_materia = $contenido['id_materia'];
                $query = "
                    SELECT
                        nombre,
                        id_bloque
                    FROM
                        bloque
                    WHERE id_materia='{$id_materia}';
                    ";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                // Obtener los resultados
                $bloques = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Imprimir el arreglo
                // echo '<pre>'; // Formatea la salida para facilitar la lectura
                // print_r($bloques);
                // echo '</pre>';
            } catch (PDOException $e) {
                // Manejo de error en la consulta
                echo "Error al realizar la consulta: " . $e->getMessage();
            }

            foreach ($bloques as $bloque) {
                $mismo_bloque = ($contenido['id_bloque'] === $bloque['id_bloque']) ? true : false;
                $area_expanded = $mismo_bloque ? 'true' : 'false';
            ?>
                <div class="accordion-item accordion-item-contenido">
                    <h2 class="accordion-header">
                        <button class="accordion-button accordion-button-contenido <?php echo $mismo_bloque? '' : 'collapsed' ?> " type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo htmlspecialchars($bloque['id_bloque']); ?>" aria-expanded="<?php $area_expanded ?>" aria-controls="<?php echo htmlspecialchars($bloque['id_bloque']); ?>">
                            <?php echo htmlspecialchars($bloque['nombre']); ?>
                        </button>
                    </h2>
                    <div id="<?php echo htmlspecialchars($bloque['id_bloque']); ?>" class="accordion-collapse collapse <?php echo $mismo_bloque ? 'show' : '' ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ol >
                                <?php
                                try {
                                    $id_bloque = $bloque['id_bloque'];
                                    $query = "SELECT id_tema, nombre FROM tema WHERE id_bloque = '{$id_bloque}'";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    $temas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    // Manejo de error en la consulta
                                    echo "Error al realizar la consulta: " . $e->getMessage();
                                }
                                foreach ($temas as $tema) {
                                ?>
                                    <li><a href="#" class="enlace-tema-contenido"><?php echo htmlspecialchars($tema['nombre']); ?></a></li>
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
        <div class="ruta-contenido">
            <img src="./src/img/icono-guia.svg" class="icono icono-guia" alt="">
            <p class="ruta">
                Guía dígital &gt;
                <?php echo htmlspecialchars($contenido['nombre_materia']); ?> &gt;
                <?php echo htmlspecialchars($contenido['nombre_bloque']); ?> &gt;
                <strong><?php echo htmlspecialchars($contenido['nombre_tema']); ?></strong>
            </p>
        </div>
        <div class="llenado-contenido">
            <?php
            $contenido_tema = $contenido['contenido_tema'];
            $jsonData = file_get_contents("src/contenido-json/{$contenido_tema}");
            $dataObject = json_decode($jsonData);
            echo $dataObject->texto; // Muestra el contenido de "texto"
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
    </section>
</main>

<?php
incluirTemplate('footer');
?>