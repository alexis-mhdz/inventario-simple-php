<?php
    require('../includes/functions.php');

    session_start();

    /* VALIDAR QUE EL USUARIO SE ENCUENTRE LOGUEADO */
    if(validate_session() == false){
        header('location: ../index.php');
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = 'home/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = 'home/index.php';

?>

<?php require('../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Opciones Disponibles</h1>
        <ul class="home-options">
            <?php if(have_permission(1)){ ?>
            <li><a href="/proyecto/home/users/" class="link">Usuarios</a></li>
            <?php } ?>
            <li><a href="/proyecto/home/sales/" class="link">Ventas</a></li>
            <li><a href="/proyecto/home/products" class="link">Productos</a></li>
            <li><a href="/proyecto/home/customers" class="link">Clientes</a></li>
            <li><a href="/proyecto/home/providers/" class="link">Provedores</a></li>
            <li><a href="#" class="link">Reporte de ventas</a></li>
        </ul>
    </div>

<?php require('../partials/footer.php'); ?>