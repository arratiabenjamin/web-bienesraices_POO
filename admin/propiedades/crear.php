<?php
    require "../../includes/app.php";
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as IMS;

    //Atenticar Sesion
    authLogin();

    //Creacion Propiedad - Evitar Error con Casillas Vacias.
    $propiedad = new Propiedad();
    $vendedores = Vendedor::all();

    //Regristo para Campos Vacios
    $errores = Propiedad::getErrores();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Crear Objeto de Propieadad
        $propiedad = new Propiedad($_POST['propiedad']);
        //Generar Nombre de Imagen (Hashear)
        $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //Setear Nombre de Imagen
            $propiedad->setImagen($nombreImagen);
            //Realizar Resize a Imagen con Intervention
            $imagen = IMS::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        }

        //Validar Datos
        $errores = $propiedad->validar();

        //Insertar Datos en DB si errores esta vacio
        if (empty($errores)) {

            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }

            //Guardar Imagen
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);

            //Insertar Datos
            $propiedad->guardar();
            
        }

    }

    //Header
    incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Registrar Propiedad</h1>
        
        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <!-- method - Para definir el metodo en que se envia la informacion -->
        <!-- action - Para definir adonde se enviara la informacion -->
        <!-- enctype - Para subir archivos -->
        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Registrar Propiedad" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
