<?php

define('TEMPLATE_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate( string $archivo, bool $inicio = false ) {

    include TEMPLATE_URL . "/$archivo.php";

}

function authLogin() {
    session_start();

    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function debugear($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}