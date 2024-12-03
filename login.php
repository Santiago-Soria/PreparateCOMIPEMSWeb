<?php
// Base de datos
$db = new mysqli('localhost:3303', 'root', '1234', 'preparatecomipems');

if (!$db) {
    echo "Error no se pudo conectar";
    exit;
}

// Autenticar el usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $email = mysqli_real_escape_string($db,  filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db,  $_POST['password']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }

    if (empty($errores)) {

        // Revisar si el usuario existe.
        $query = "SELECT * FROM usuario WHERE correo = '{$email}' ";
        $resultado = mysqli_query($db, $query);




        if ($resultado->num_rows) {
            // Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);


            // Verificar si el password es correcto o no

            $auth = $password == $usuario['contrasena'];

            if ($auth) {
                // El usuario esta autenticado
                session_start();

                // Llenar el arreglo de la sesión
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;


                header('Location: contenidoGuiaDigital.php?materia=1&bloque=1');
            } else {
                $errores[] = 'El password es incorrecto';
            }
        } else {
            $errores[] = "El Usuario no existe";
        }
    }
}



require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="contenedor seccion contenedor-login">

    <!-- Formulario de Inicio de Sesión -->
    <div class="contenedor-formulario">
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form method="POST" class="formulairo formulario-login" novalidate>
            <h2>Bienvenido. <span>¿Estás listo para aprender un día más?</span></h2>
            <input type="email" name="email" id="email" placeholder="Correo Electrónico">
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <a href="#" class="olvidaste-contrasena">¿Olvidaste tu contraseña?</a>
            <button type="submit" class="Iniciar-sesion">Iniciar sesión</button>
            <div class="asistencia-login">
                <p>¿Necesitas una cuenta de PrepárateCOMIPEMS?</p>
                <a href="">Crear una nueva cuenta</a>
            </div>
        </form>
    </div>
    <div class="contenedor-imagen-login">
        <img src="/build/img/imagen-login.png" alt="Imagen de Inicio de sesión">
    </div>
</div>

</div>

<?php
incluirTemplate('footer');
?>