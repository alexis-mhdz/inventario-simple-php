<?php

    session_start();
    require('../../includes/connection.php'); 
    require('../../includes/functions.php');

    /* VALIDAR QUE EL USUARIO SE ENCUENTRE LOGUEADO */
    if(validate_session() == false){
        header('location: ../../index.php');
    }

    /* VALIDAR SI EL USUARIO TIENE EL PERMISO DE ADMINISTRADOR = 1 */
    if(have_permission(1) == false && have_permission(2) == false){
        header('location: ../../index.php');
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        /*OBTENER EL PRODUCTO QUE VOLVERA AL SOTCK */
        $query = "SELECT product FROM customers WHERE id = $id";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);
        $product_id = $row['product'];
        /* ELIMINR EL CLIENTE */
        $query = "DELETE FROM customers WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            header("location: index.php?delete=false");
        }
        /* ACTUALIAR EL PRODUCTO */
        $query = "UPDATE products set status = 'STOCK' WHERE id = '$product_id'";
        $result = mysqli_query($connection, $query);
        /* ELMINAR LA VENTA YA QUE EL PRODUCTO VOLVIO AL STOCK */
        $query = "DELETE FROM sales WHERE customer = $id";
        $result = mysqli_query($connection, $query);

        header("location: index.php?delete=true");
    }
?>