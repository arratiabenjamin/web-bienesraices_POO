<?php

function conectarDB() : mysqli {
    $DB = mysqli_connect('localhost', 'root', 'Demu277353', 'bienesraices_crud');

    if (!$DB) {
        echo 'Conexion Fallida!!';
        exit;
    }

    return $DB;
}