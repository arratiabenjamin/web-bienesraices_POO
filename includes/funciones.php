<?php

require 'app.php';

function incluirTemplate( string $archivo, bool $inicio = false ) {

    include TEMPLATE_URL . "/${archivo}.php";

}

function authLogin() {
    session_start();

    $auth = $_SESSION['login'] ?? null;

    if(!$auth){
        header('Location: /');
    }
}