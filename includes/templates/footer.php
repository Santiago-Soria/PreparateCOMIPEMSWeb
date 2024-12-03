<footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <nav class="navegacion">
            <?php
            $auth = $_SESSION['login'] ?? false;
            if ($auth): ?>
                <a href="/InicioLoggeado.php">Inicio</a>
                <a href="/menuMaterias.php">Guía Dígital</a>
                <a href="#">Exámenes</a>
                <a href="/progreso.php">Mi Progreso</a>
                <a href="/comunidad.php">Comunidad</a>
                <a href="/soporte.php">Soporte</a>
                <a href="cerrar-sesion.php">
                    <img src="/build/img/logout.svg" alt="Cerrar sesión" title="Cerrar sesión">
                </a>
            <?php endif;
            if (!$auth): ?>
                <a href="/menuMaterias.php">Guía digital</a>
                <a href="#">Examenes Simulacro</a>
                <a href="#">Información sobre COMIPEMS</a>
                <a href="login.php" class="active">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </div>

    <p class="copyright">Todos los derechos reservados <?php echo date('Y'); ?> &copy;</p>
</footer>

<script src="build/js/bundle.min.js"></script>
<script src="/build/js/script.js"></script>
<script src="/build/js/scrip2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>