<?php
    require "../includes/app.php";

    //Atenticar Sesion
    authLogin();
    
    //Importar Clase Propiedad
    use App\Propiedad;
use App\Vendedor;

    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();
    debugear($vendedores);

    //ELIMINAR PROPIEDAD
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Obtener ID de Propiedad
        $propiedadEliminar = $_POST['id'];
        $propiedadEliminar = filter_var($propiedadEliminar, FILTER_VALIDATE_INT);

        if($propiedadEliminar) {

            //Obetener Valores de Propiedades
            $propiedad = Propiedad::find($propiedadEliminar);
            $propiedad->eliminar();

        }

    }

    //Recibir Resultado de Creacion de Propiedad
    $resultado = $_GET['resultado'] ?? null;

    //Incluir Template Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if($resultado == 1) : ?>
            <p class="alerta exito"> Propiedad Creada Exitosamente </p>
        <?php elseif($resultado == 2) : ?>
            <p class="alerta exito"> Propiedad Actualizada Exitosamente </p>
        <?php elseif($resultado == 3) : ?>
            <p class="alerta exito"> Propiedad Eliminada Exitosamente </p>
        <?php endif ?>

        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>

        <!-- Mostrar Propiedades Creadas -->
        <table class="propiedades">

            <!-- Mostrar Propiedades -->

            <thead>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </thead>

            <?php foreach($propiedades as $propiedad) : ?>

                <tbody>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td class="centrado-horizontal"> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Propiedad" class="imagen-tabla"> </td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tbody>

            <?php endforeach; ?>

        </table>


    </main>

<?php


    incluirTemplate('footer');
?>
