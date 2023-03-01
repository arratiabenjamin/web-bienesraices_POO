<?php 

    //Conexion DB
    require "includes/config/database.php";
    $DB = conectarDB();

    //Crear Usuario Admin
    $email = "bienesraices_bye@bienesraices.com";
    $password = "Demu277353#";

    //Hashear
    //Existe PASSWORD_DEFAULT y PASSWORD_BCRYPT - Los 2 hacen casi el mismo hash
    $passwordHash = password_hash( $password, PASSWORD_DEFAULT );

    //Query
    $queryInsertUser = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash'); ";

    //Insertar Datos
    mysqli_query($DB, $queryInsertUser);

?>