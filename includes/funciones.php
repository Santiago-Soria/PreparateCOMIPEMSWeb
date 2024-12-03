<?php

require 'app.php';

function incluirTemplate( string $nombre){
    include TEMPLATES_URL."\\".$nombre.".php";
}

function estaAutenticado(){
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    }
}