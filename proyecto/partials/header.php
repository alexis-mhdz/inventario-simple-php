<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Punto de Venta</title>
    <!-- ESTILOS PRINCIPALES -->
    <link rel="stylesheet" href="/proyecto/css/style.css">
    <!-- ESTILOS DE LAS TABLAS -->
    <link rel="stylesheet" href="/proyecto/css/table.css">
    <!-- ESTILOS DEL LA VISTA HOME -->
    <link rel="stylesheet" href="/proyecto/css/home.css">
    <!-- ESTILOS DEL FOOTER -->
    <link rel="stylesheet" href="/proyecto/css/footer.css">
    <!-- ESTILOS DEL HEADER -->
    <link rel="stylesheet" href="/proyecto/css/header.css">
    <!-- ICONOS FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<?php if(isset($_SESSION['user_id'])){ ?>
<header class="header">
    <a href="/proyecto/home"><i class="fas fa-home"></i></a>
    <?php if(have_permission(1)){ ?>
        <a href="/proyecto/home/users/"><i class="fas fa-users-cog"></i></a>
    <?php } ?>
    <a href="/proyecto/home/sales/"><i class="fas fa-dollar-sign"></i></a>
    <a href="/proyecto/home/products/"><i class="fas fa-boxes"></i></a>
    <a href="/proyecto/home/customers/"><i class="fas fa-users"></i></a>
    <a href="/proyecto/home/providers/"><i class="fas fa-truck-loading"></i></a>
    <a href="/proyecto/<?= $_SESSION['previous_page'] ?>"><i class="fas fa-arrow-alt-circle-left"></i></a>
<?php } ?>
</header>
