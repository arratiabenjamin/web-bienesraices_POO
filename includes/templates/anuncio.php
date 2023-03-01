<?php 

    require "includes/config/database.php";
    $DB = conectarDB();

    if($_GET['id']){

        $idPropiedad = $_GET['id'];
        $idPropiedad = filter_var($idPropiedad, FILTER_VALIDATE_INT);

        if($idPropiedad){
            $querySelectPropiedades = "SELECT * FROM propiedades WHERE id = $idPropiedad";
            $propiedad = mysqli_query($DB, $querySelectPropiedades);

            if(!$propiedad->num_rows){
                header('Location: /');
            }

            $propiedad = mysqli_fetch_assoc($propiedad);
        }else{
            header('Location: /');
        }

    }

?>

<picture>
    <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">
</picture>

<div class="resumen-propiedad">
    <p class="precio">$<?php echo $propiedad['precio'] ?></p>
    <ul class="iconos-caracteristicas">
        <li>
            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
            <p><?php echo $propiedad['wc'] ?></p>
        </li>
        <li>
            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
            <p><?php echo $propiedad['estacionamientos'] ?></p>
        </li>
        <li>
            <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
            <p><?php echo $propiedad['habitaciones'] ?></p>
        </li>
    </ul>

    <p><?php echo $propiedad['descripcion'] ?></p>

</div>


<?php 

    mysqli_close($DB);

?>