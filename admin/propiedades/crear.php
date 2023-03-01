<?php
    require "../../includes/app.php";
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as IMS;

    //Atenticar Sesion
    authLogin();

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

            <fieldset>
                <legend>Informacion General</legend>
                
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">
                
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>" min="100000">
                
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" value="<?php echo $habitaciones; ?>" min="1" max="9">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" value="<?php echo $wc; ?>" min="1" max="9">

                <label for="estacionamientos">Estacionamientos:</label>
                <input type="number" id="estacionamientos" name="estacionamientos" placeholder="Ej: 3" value="<?php echo $estacionamientos; ?>" min="1" max="9">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedorId">
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
