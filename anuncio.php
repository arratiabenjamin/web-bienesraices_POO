<?php
    declare(strict_types=1);
    require "includes/funciones.php";
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en Venta frente al bosque</h1>

        <?php 
            include "includes/templates/anuncio.php";
        ?>

    </main>

<?php
    incluirTemplate('footer');
?>
