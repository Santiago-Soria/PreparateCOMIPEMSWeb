<?php
// Base de datos
$db = new mysqli('localhost:3303', 'root', '1234', 'preparatecomipems');

if (!$db) {
    echo "Error no se pudo conectar";
    exit;
}

// Autenticar el usuario

$errores = [];
$exito = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $email = mysqli_real_escape_string($db,  filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db,  $_POST['password']);
    $passwordConf = mysqli_real_escape_string($db,  $_POST['passwordConf']);
    $nombre = mysqli_real_escape_string($db,  $_POST['nombre']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }


    if (empty($errores)) {

        // Revisar si el usuario existe.
        $query = "SELECT * FROM usuario WHERE correo = '{$email}' ";
        $resultado = mysqli_query($db, $query);




        if ($resultado->num_rows) {
            $errores[] = "Este correo ya fue registrado.";
        } else {
            if ($password != $passwordConf) {
                $errores[] = "Las contraseñas no coinciden";
            } else {
                // Base de datos
                require __DIR__ . '/includes/config/database.php';
                $pdo = conectarDB();
                try {
                    $query = "
                            INSERT INTO Usuario (nombre, correo, contrasena) VALUES
                            ('$nombre', '$email', '$password');
                        ";

                    // Obtener los resultados
                    $materias = consultaBD($query, $pdo, true);

                    $exito[] = "Usuario registrado exitosamente";
                } catch (PDOException $e) {
                    // Manejo de error en la consulta
                    echo "Error al realizar la consulta: " . $e->getMessage();
                }
            }
        }
    }
}



require 'includes/funciones.php';
incluirTemplate('header');
?>

<div class="seccion contenedor contenedor-registroUsuario">
    <div class="contenedor-imagen">
        <img src="/build/img/fondoRegistro.png" alt="" class="display-none">
    </div>
    <div class="contenedor-formulario">
        <form method="POST" class="formulairo formulario-registro" novalidate>
            <h2>Bienvenido. <span>¿Estás listo para prepararte?</span></h2>
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <?php foreach ($exito as $exito): ?>
                <div class="alerta exito">
                    <?php echo $exito; ?>
                </div>
            <?php endforeach; ?>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre">
            <input type="email" name="email" id="email" placeholder="Correo Electrónico">
            <input type="password" name="password" id="password" placeholder="Contraseña">
            <input type="password" name="passwordConf" id="passwordConf" placeholder="Confirmar contraseña">
            <button type="submit" class="registrar">Registrar</button>
        </form>
    </div>
</div>

<?php
incluirTemplate('footer');
?>