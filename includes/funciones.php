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

//Validad Contenido
function validarContenido($contenido){
    $aceptados = ['vendedor', 'propiedad'];
    return in_array($contenido, $aceptados);
}

//Mostrar Mensajes
function mostrarMesajes($cod) {
    $mensaje = '';

    switch($cod){
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}