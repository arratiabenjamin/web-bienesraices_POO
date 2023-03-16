<?php

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as IMS;

    require "../../includes/app.php";

    //Atenticar Sesion
    authLogin();

    //DataBase
    $DB = conectarDB();

    //Validar id
    $idPropiedad = $_GET['id'] ?? null;
    $idPropiedad = filter_var($idPropiedad, FILTER_VALIDATE_INT);

    if(!$idPropiedad) {
        header('Location: /admin');
    }
    
    //Obetener Valores de Propiedades
    $propiedad = Propiedad::find($idPropiedad);

    //Obetener Valores de Vendedores
    $querySelectVendedores = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($DB, $querySelectVendedores);

    //Regristo para Campos Vacios
    $errores = Propiedad::getErrores();

    // $_SERVER - Nos da informacion detallada sobre el servidor
    // $_SERVER['REQUEST_METHOD'] - Nos dira el metodo de envio de un formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);
        $errores = $propiedad->validar();

        //Generar Nombre de Imagen (Hashear)
        $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //Setear Nombre de Imagen
            $propiedad->setImagen($nombreImagen);
            //Realizar Resize a Imagen con Intervention
            $imagen = IMS::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        }

        //Insertar Datos en DB si errores esta vacio
        if (empty($errores)) {

            //Guardar Imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $imagen->save( CARPETA_IMAGENES . $nombreImagen );
            }

            $propiedad->guardar();
            
        }

    }

    
    //Header
    incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        
        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <!-- method - Para definir el metodo en que se envia la informacion -->
        <!-- action - Para definir adonde se enviara la informacion -->
        <!-- enctype - Para subir archivos -->
        <form class="formulario" method="POST" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>    

            <input type="submit" value="Actualizar Propiedad" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
