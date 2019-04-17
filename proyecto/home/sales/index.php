<?php 
    session_start();
    require('../../includes/connection.php'); 
    require('../../includes/functions.php');

    /* VALIDAR QUE EL USUARIO SE ENCUENTRE LOGUEADO */
    if(validate_session() == false){
        header('location: ../index.php');
    }

    /* VALIDAR SI EL USUARIO TIENE EL PERMISO DE ADMINISTRADOR = 1 */
    if(have_permission(1) == false && have_permission(2) == false){
       header('location: ../index.php');
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = 'home/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = 'home/sales/index.php';

?>

<?php require('../../partials/header.php'); ?>

    <h1 class="title">Lista de Ventas</h1>
    <table class="table table-sm">
        <caption>Ventas registradas</caption>
        <thead>
            <tr>
                <th scope="col">Cliente</th>
                <th scope="col">Producto</th>
                <th scope="col">Total</th>
                <th scope="col">Ganancia</th>
            </tr>
        </thead>
        <tbody>
        <?php /* SELECCIONAR TODOS LOS REGISTROS QUE HAY EN LA TABLA PRODUCTOS Y MOSTRARLOS QÚE ESTAN DISPONIBLES EN LA TABLA. */
            $query = "SELECT * FROM sales";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <tr>
                <td scope="row" data-label="Cliente">
                    <?php
                        $customer_id = $row['customer'];
                        $customer_query = "SELECT name FROM customers WHERE id = '$customer_id'";
                        $customer_result = mysqli_query($connection, $customer_query);
                        $customer_row = mysqli_fetch_array($customer_result);
                        echo $customer_row['name'];
                    ?>
                </td>
                <td scope="row" data-label="Producto">
                    <?php
                        $product_id = $row['product'];
                        $product_query = "SELECT brand_name, generic_name, sale_price, moneymaking FROM products WHERE id = $product_id";
                        $product_result = mysqli_query($connection, $product_query);
                        $product_row = mysqli_fetch_array($product_result);
                        echo $product_row['brand_name'];
                        echo ' - ';
                        echo $product_row['generic_name'];
                    ?>          
                </td>
                <td scope="row" data-label="Total">$<?php echo $product_row['sale_price'] ?></td>
                <td scope="row" data-label="Ganancia">$<?php echo $product_row['moneymaking'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php require('../../partials/footer.php'); ?>