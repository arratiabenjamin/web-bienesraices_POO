<?php

require "../../includes/app.php";
use App\Vendedor;

authLogin();

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if(!$id){
    header('Location: /admin');
}

$vendedor = Vendedor::find($id);

$errores = Vendedor::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignacion de Valores
    $args = $_POST['vendedor'];
    //Sincronizar
    $vendedor->sincronizar($args);
    //Validar
    $errores = $vendedor->validar();

    //Validacion
    if(empty($errores)){
        //Guardar
        $vendedor->guardar();
    }

}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>
        
        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <!-- method - Para definir el metodo en que se envia la informacion -->
        <!-- action - Para definir adonde se enviara la informacion -->
        <!-- enctype - Para subir archivos -->
        <form class="formulario" method="POST">

            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar Cambios de Vendedor(a)" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
