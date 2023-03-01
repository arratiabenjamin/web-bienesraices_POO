<?php

function conectarDB() : mysqli {
    $DB = new mysqli('localhost', 'root', 'Demu277353', 'bienesraices');

    if (!$DB) {
        echo 'Conexion Fallida!!';
        exit;
    }

    return $DB;
}