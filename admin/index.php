<?php
    require "../includes/app.php";

    //Atenticar Sesion
    authLogin();
    
    //Importar Clase Propiedad
    use App\Propiedad;
    use App\Vendedor;

    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //ELIMINAR PROPIEDAD
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Obtener ID de Propiedad
        $entidadEliminar = $_POST['id'];
        $entidadEliminar = filter_var($entidadEliminar, FILTER_VALIDATE_INT);

        if($entidadEliminar) {

            $contenido = $_POST['tipo'];

            //Solo si esta dentro de lo Permitido
            if(validarContenido($contenido)){
                //Depende de lo que se quiera eliminar es lo que se realizará
                if($_POST['tipo'] == 'propiedad'){
                    //Obetener Valores de Propiedades
                    $propiedad = Propiedad::find($entidadEliminar);
                    $propiedad->eliminar();
                }else if($_POST['tipo'] == 'vendedor'){
                    //Obetener Valores de Propiedades
                    $vendedor = Vendedor::find($entidadEliminar);
                    $vendedor->eliminar();
                }
            }


        }

    }

    //Recibir Resultado de Creacion de Propiedad
    $resultado = $_GET['resultado'] ?? null;

    //Incluir Template Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php 
            $mensaje = mostrarMesajes(intval($resultado));
            if($mensaje) { ?>
                <p class="alerta exito"> <?php echo s($mensaje); ?> </p>
        <?php } ?>

        <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton-amarillo">Nuevo/a Vendedor(a)</a>

        <h2>Propiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tbody>

            <?php endforeach; ?>

        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">

            <!-- Mostrar Propiedades -->

            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </thead>

            <?php foreach($vendedores as $vendedor) : ?>

                <tbody>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-verde-block">Actualizar</a>
                    </td>
                </tbody>

            <?php endforeach; ?>

        </table>


    </main>

<?php


    incluirTemplate('footer');
?>
