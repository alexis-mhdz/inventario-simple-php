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
        $query = "DELETE FROM products WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            header("location: index.php?delete=false");
        }

        header("location: index.php?delete=true");
    }
?>