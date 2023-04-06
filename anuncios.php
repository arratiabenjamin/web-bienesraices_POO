<?php
    declare(strict_types=1);
    require "includes/app.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php 
            include "includes/templates/anuncios.php";
        ?>

    </main>

<?php
    incluirTemplate('footer');
?>
