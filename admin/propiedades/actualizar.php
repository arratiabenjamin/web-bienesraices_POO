<?php
    require "../../includes/funciones.php";
    require "../../includes/config/database.php";

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

    //Obetener Valores de Vendedores
    $querySelectVendedores = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($DB, $querySelectVendedores);
    
    //Obetener Valores de Propiedades
    $querySelectPropiedades = "SELECT * FROM propiedades WHERE id = $idPropiedad";
    $queryPropiedad = mysqli_query($DB, $querySelectPropiedades);
    $propiedad = mysqli_fetch_assoc($queryPropiedad);

    //Regristo para Campos Vacios
    $errores = [];
    
    //Inicializar variables de Campos
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamientos = $propiedad['estacionamientos'];
    $vendedorId = $propiedad['vendedores_id'];
    $imagenPropiedad = $propiedad['imagen'];
    $imagen = '';

    // $_SERVER - Nos da informacion detallada sobre el servidor
    // $_SERVER['REQUEST_METHOD'] - Nos dira el metodo de envio de un formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //$_POST - Nos dira toda la informacion que se envio desde un formulario
        // echo '<pre>';
        // var_dump($_POST);
        // echo '</pre>';

        //$_FILES - Nos dira la informacion sobre los archivos subidos
        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';


        //Guardar Datos de Formulario
        //mysqli_real_escape_string() - Es para poder Sanitizar la entrada de datos que realizan los usuarios.
        //(Sanitizar es para asegurar que los usuarios no introduzcan datos para vulnerar la pagina).
        $titulo = mysqli_real_escape_string( $DB, $_POST['titulo'] );
        $precio = mysqli_real_escape_string( $DB, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string( $DB, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string( $DB, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string( $DB, $_POST['wc'] );
        $estacionamientos = mysqli_real_escape_string( $DB, $_POST['estacionamientos'] );
        $vendedorId = mysqli_real_escape_string( $DB, $_POST['vendedor'] );
        $imagen = $_FILES['imagen'];
        $creado = date('Y/m/d');

        //Ingresar un error al array error si no se introdujo un dato
        if(!$titulo) {
            $errores[] = "Debes Añadir un Titulo";
        }
        if(!$precio) {
            $errores[] = 'El Precio es Obligatorio';
        }
        if( strlen( $descripcion ) < 50 ) {
            $errores[] = 'La Descripción es Obligatoria y Debe Tener al Menos 50 cCaracteres';
        }
        if(!$habitaciones) {
            $errores[] = 'El Número de Habitaciones es Obligatorio';
        }
        if(!$wc) {
            $errores[] = 'El Número de Baños es Obligatorio';
        }
        if(!$estacionamientos) {
            $errores[] = 'El Número de Lugares de Estacionamiento es Obligatorio';
        }
        if(!$vendedorId) {
            $errores[] = 'Elige un Vendedor';
        }

        //Limitar Peso de Imagen
        $limite = 1000 * 1000; //Max 1MB;
        if($imagen['size'] > $limite) {
            $errores[] = 'Su Imagen es Demasiado Pesada (Limite: 1MB)';
        }

        //Insertar Datos en DB si errores esta vacio
        if (empty($errores)) {

            //Subida de Archivos

            // Crear la Carpeta
            $carpetaImagenes = '../../imagenes/';

            $nombreImagen = '';

            //Si no existe, crearla
            if(!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }

            //Eliminar Imagen Antigua si Existe una Nueva
            if($imagen['name']) {

                //unlink() - Para Eliminar Archivos
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Generar Nombre de Imagen (Hashear)
                $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

                //Subir Imagen
                //move_uploades_file() - Para Crear Archivos
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            } else {
                $nombreImagen = $propiedad['imagen'];
            }


            //Insertar Datos
            $queryInsert = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamientos = $estacionamientos, vendedores_id = $vendedorId WHERE id = $idPropiedad";

            $resultado = mysqli_query($DB, $queryInsert);

            //Redireccionar al panel de admin luego de insertar todo
            if($resultado) {
                header('Location: /admin?resultado=2');
            }
            
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

            <fieldset>
                <legend>Informacion General</legend>
                
                <label for="titulo">Titulo:</label>
                <input
                type="text" id="titulo"
                name="titulo" placeholder="Titulo Propiedad"
                value="<?php echo $titulo; ?>">
                
                <label for="precio">Precio:</label>
                <input
                type="number" id="precio"
                name="precio" placeholder="Precio Propiedad"
                value="<?php echo $precio; ?>" min="100000">
                
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
                <img src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="Imagen de Propiedad" class="imagen-small">

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input
                type="number" id="habitaciones"
                name="habitaciones" placeholder="Ej: 3"
                value="<?php echo $habitaciones; ?>" min="1" max="9">

                <label for="wc">Baños:</label>
                <input
                type="number" id="wc"
                name="wc" placeholder="Ej: 3"
                value="<?php echo $wc; ?>" min="1" max="9">

                <label for="estacionamientos">Estacionamientos:</label>
                <input
                type="number" id="estacionamientos"
                name="estacionamientos" placeholder="Ej: 3"
                value="<?php echo $estacionamientos; ?>" min="1" max="9">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" id="vendedor">
                    <option value="" selected>-- Seleccione --</option>
                    
                    <?php foreach($vendedores as $vendedor) : ?>
                        <!-- utilizamos un operador ternario para añadir el selected al vendedor -->
                        <!-- en value se llama a la propiedad id de cada registro para asi darle un valor -->
                        <!-- en el texto se imprime el nombre y apellido de cada propiedad -->
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> 
                        value="<?php echo $vendedor['id']; ?>">
                            <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
 

                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
