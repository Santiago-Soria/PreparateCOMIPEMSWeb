<?php
function conectarDB()
{
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

    return $pdo;
}

function consultaBD($query, $pdo, bool $fetchALL)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    if($fetchALL){
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
