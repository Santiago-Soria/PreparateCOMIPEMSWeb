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

<div class="Estas-listo-para-poner-a-prueba-tus-conocimientos">
    <div class="text-container">
        <h2>¿Estás listo para poner a prueba tus conocimientos?</h2>
        <p>
            Inicia con un examen diagnóstico que te permitirá conocer tu nivel actual y descubrir en qué áreas necesitas enfocarte. ¡Es el primer paso hacia el éxito en el COMIPEMS!
        </p>
        <a href="/indexExamen.php">Ir al examen diagnóstico</a>
    </div>
    <div class="contenedor-imagen">
        <img src="build/img/imagen_test.png" alt="Logo del Programa">
    </div>
</div>

<div class="inicioGuiaEstudios contenedores-inicio">
    <h2 class="titulo-inicio">
        Toda la guía de estudios, más accesible que nunca.
    </h2>

    <div class="tablaMaterias">
        <div class="contenedor-materias">
            <?php
            try {
                $query = "
                        SELECT nombre, color, icono
                        FROM materia;
                    ";

                $materias = consultaBD($query, $pdo, true);

                // Mostrar los resultados
                if (!empty($materias)) {
                    foreach ($materias as $materia) {
            ?>
                        <div class="item-materia">
                            <h2 class="item-header">
                                <div class="icono" style="background-color: <?php echo htmlspecialchars($materia['color']); ?>;">
                                    <img src="./build/img/iconos/<?php echo htmlspecialchars($materia['icono']); ?>" alt="">
                                </div>
                                <p>
                                    <?php echo htmlspecialchars($materia['nombre']); ?>
                                </p>
                            </h2>
                        </div>
            <?php
                    }
                }
            } catch (PDOException $e) {
                // Manejo de error en la consulta
                echo "Error al realizar la consulta: " . $e->getMessage();
            }
            ?>
        </div>

        <div class="Accede-container">
            <span class="Accede-al-contenido-oficial-del-examen-de-manera-clara-y-estructurada-Organiza-tu-estudio-revisa-l">
                Accede al contenido oficial del examen de manera clara y estructurada. Organiza tu estudio, revisa los temas clave y aprovecha los recursos interactivos que hemos preparado para ti.
            </span>

            <a href="./menuMaterias.php">
                Explorar la Guía Digital
            </a>
        </div>
    </div>


</div>


<div class="inicioSigueProgreso contenedores-inicio">
    <div class="textoProgreso">
        <h2 class="titulo-inicio">
            Sigue tu progreso
        </h2>
        <div class="Accede-container">
            <span class="Accede-al-contenido2">
                Visualiza tus avances y observa cómo mejoras día a día. Mantente motivado y enfocado para alcanzar tus metas.
            </span>
            <span class="Accede-al-contenido2">
                ¡Tú puedes!
            </span>
            <a href="/progreso.php" class="Empieza-a-aprender2">
                Ver mi progreso
            </a>
        </div>
    </div>
    <div class="image-container">
        <img src="build/img/inicioProgreso.png" class="progress-image">
    </div>
</div>


<div class="inicioUneteComunidad contenedores-inicio">
    <h2 class="Toda-la-gua-de-estudios-ms-accesible-que-nunca3">
        Únete a nuestra comunidad
    </h2>

    <div class="Accede-container">
        <span class="Accede-al-contenido2">
            Interactúa con otros estudiantes que, como tú, están preparándose para el examen. Comparte tus experiencias, resuelve dudas y encuentra apoyo en nuestra comunidad.
        </span>

        <a href="#" class="Unirse-comunidad">
            Unirme a la comunidad
        </a>
    </div>
</div>

<div class="inicioDudas contenedores-inicio">
    <div>
        <h2 class="Toda-la-gua-de-estudios-ms-accesible-que-nunca">
            ¿Tienes dudas? Estamos aquí para ayudarte
        </h2>

        <div class="columns-container2">
            <div class="Accede-container">
                <span class="Accede-al-contenido2">
                    Consulta las pregunta frecuentes, reporta problemas con la plataforma y mantente en comunicación con nosotros.
                </span>
                <a href="/soporte.php" class="Empieza-a-aprender4">
                    Soporte y ayuda
                </a>
            </div>

        </div>
    </div>
    <div class="image-container">
        <img src="/build/img/ayuda.png" class="progress-image">
    </div>
</div>

<?php
incluirTemplate('footer');
?>