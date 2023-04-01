<?php

require "../../includes/app.php";
use App\Vendedor;

authLogin();

$vendedor = new Vendedor();
$errores = Vendedor::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendedor = new Vendedor($_POST['vendedor']);
    $errores = $vendedor->validar();

    if(empty($errores)) {
        $vendedor->guardar();
    }
    
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>
        
        <a href="/admin" class="boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>
        
        <!-- method - Para definir el metodo en que se envia la informacion -->
        <!-- action - Para definir adonde se enviara la informacion -->
        <!-- enctype - Para subir archivos -->
        <form class="formulario" method="POST" action="/admin/vendedores/crear.php">

            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Registrar Vendedor(a)" class="boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>
