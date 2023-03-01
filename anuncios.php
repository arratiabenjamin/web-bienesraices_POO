<?php
    declare(strict_types=1);
    require "includes/funciones.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php 
            $limite = 20;
            include "includes/templates/anuncios.php";
        ?>

    </main>

<?php

    //Cerrar Conexion DB
    mysqli_close($DB);

    incluirTemplate('footer');
?>
