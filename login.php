<?php
    declare(strict_types=1);

    //Conexion DB
    require "includes/app.php";
    $DB = conectarDB();

    //Almacenar errores
    $errores = [];

    //Almacenar Datos de Formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $email = mysqli_real_escape_string( $DB, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) );
        $password = mysqli_real_escape_string( $DB, $_POST['password'] );

        if(!$email){
            $errores[] = 'El Email es Obligatorio o es Erroneo';
        }
        if(!$password){
            $errores[] = 'El Password es Obligatorio';
        }

        if(empty($errores)) {

            //Revisar Existencia de Usuario
            $querySelectUsuario = "SELECT * FROM usuarios WHERE email = '$email'";
            $usuario = mysqli_query($DB, $querySelectUsuario);

            //Revisar si el Usuario Existe
            if($usuario->num_rows){
                //Conseguir Usuario
                $usuario = mysqli_fetch_assoc($usuario);
                //Verificar si el Password es Correcto
                $auth = password_verify( $password, $usuario['password'] );

                
                if($auth) {

                    //Iniciar Sesion
                    session_start();

                    //Llenar el Arreglo de Sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');

                }else{
                    $errores[] = 'El Password es Incorrecto';
                }

            }else{
                $errores[] = 'El Usuario no Existe';
            }

        }

    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" novalidate>
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password">

            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">

        </form>
    </main>

<?php
    incluirTemplate('footer');
?>
