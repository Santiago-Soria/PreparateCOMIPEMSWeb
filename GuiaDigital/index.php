<?php
// Configuración de la base de datos
$host = 'localhost';
$port = 3303;
$dbname = 'PreparateCOMIPEMS';
$username = 'root';
$password = '1234';

$pdo = null;

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Manejo de error en la conexión
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrepárateCOMIPEMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="build/css/app.css">
    <link rel="shortcut icon" href="src/img/icono_pestana.svg">
</head>

<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="src/img/logo.png" alt="Logotipo de PrepárateCOMIPEMS" class="logo">
                </a>

                <nav class="navegacion">
                    <a href="#">Inicio</a>
                    <a href="#" class="active">Guía Dígital</a>
                    <a href="#">Exámenes</a>
                    <a href="#">Mi Progrso</a>
                    <a href="#">Comunidad</a>
                    <a href="#">Soporte</a>
                    <a href="#">
                        <img src="src/img/iniciar_sesion.png" alt="Ícono de Inicio de Sesión" width="32" height="32">
                    </a>
                </nav>
            </div> <!-- .barra -->
        </div>
    </header>

    <main class="contenedor seccion">
        <h1 class="titulo">Temario por asignatura</h1>
        <p class="descripcion">
            Aquí encontrarás todo el material necesario para prepararte de manera eficiente en cada área del examen.
            ¡Explora los materiass en detalle, sigue tu progreso y accede a recursos adicionales para mejorar tu
            rendimiento!
        </p>
    </main>

    <section class="seccion contenedor">
        <div class="accordion" id="accordionExample">
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
                            <div class="accordion-item">
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
                                                                <a href="#">
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
                    <div class="accordion-item">
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

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="#">Inicio</a>
                <a href="#">Guía Dígital</a>
                <a href="#">Exámenes</a>
                <a href="#">Mi Progrso</a>
                <a href="">Comunidad</a>
                <a href="">Soporte</a>
            </nav>
        </div>

        <p class="copyright">Todos los derechos reservados 2024 &copy;</p>
    </footer>

    <script src="build/js/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>