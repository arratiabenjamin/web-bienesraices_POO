<?php

define('TEMPLATE_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

//Include Templates
function incluirTemplate( string $archivo, bool $inicio = false ) {

    include TEMPLATE_URL . "/$archivo.php";

}

//Autenticar Login
function authLogin() {
    session_start();

    if(!$_SESSION['login']){
        header('Location: /');
    }
}

//Revisar Variable
function debugear($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}

//Sanitizar HTML
function s($html){
    $s = htmlspecialchars($html);
    return $s;
}