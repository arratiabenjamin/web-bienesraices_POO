<?php
    require "../../includes/app.php";
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as IMS;

    //Atenticar Sesion
    authLogin();

    //Creacion Propiedad - Evitar Error con Casillas Vacias.
    $propiedad = new Propiedad();

    //DataBase
    $DB = conectarDB();
    
    //Obetener Valores de Vendedores
    $querySelectVendedores = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($DB, $querySelectVendedores);

    //Regristo para Campos Vacios
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Crear Objeto de Propieadad
        $propiedad = new Propiedad($_POST);
        //Generar Nombre de Imagen (Hashear)
        $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

        if ($_FILES['imagen']['tmp_name']) {
            //Setear Nombre de Imagen
            $propiedad->setImagen($nombreImagen);
            //Realizar Resize a Imagen con Intervention
            $imagen = IMS::make($_FILES['imagen']['tmp_name'])->fit(800,600);
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
            $resultado = $propiedad->guardar();

            //Redireccionar al panel de admin luego de insertar todo
            if($resultado) {
                header('Location: /admin?resultado=1');
            }
            
        }

    }

    //Header
    incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>
        
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

            <input type="submit" value="Crear Propiedad" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
