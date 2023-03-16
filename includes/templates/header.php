<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">

                    <div class="derecha-botones">
                        <?php if(!$auth): ?>
                            <a href="/login.php" class="sesion">
                                <img src="/build/img/icon-login.svg" alt="Icono Login">
                            </a>
                        <?php elseif($auth) : ?>
                            <a href="/admin/index.php" class="sesion loged">
                                <img src="/build/img/icon-admin.svg" alt="Icono Admin">
                            </a>
                            
                            <a href="/cerrar-sesion.php" class="sesion loged">
                                <img src="/build/img/icon-cerrarsesion.svg" alt="Icono Cerrar Sesion">
                            </a>
                        <?php endif; ?>
                        <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    </div>

                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                    </nav>
                </div>
   
                
            </div> <!--.barra-->

            <?php if ($inicio) { ?>
                <h1>Venta de Casas y Departamentos  Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
    </header>