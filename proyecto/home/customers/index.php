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
    $_SESSION['actual_page'] = 'home/customers/index.php';

    /* CREAR O REGISTRAR UN NUEVO USUARIO */
    if(isset($_POST['save'])) {
        if(!empty($_POST['name'] && !empty($_POST['address'] && !empty($_POST['phone'] && !empty($_POST['product'] && !empty($_POST['note'])))))) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $product = $_POST['product'];
            /* OBTENER LA CANTIDAD QUE PAGAR EL CLIENTE */
            $query = "SELECT sale_price FROM products WHERE id = $product";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($result);
            $total = $row['sale_price'];
            $note = $_POST['note'];

            $query = "INSERT INTO customers(name, address, phone, product, total, note) VALUES ('$name', '$address', '$phone', '$product', '$total', '$note')";
            $result = mysqli_query($connection, $query);
            if (!$result){
                $message = 'Error al registrar el cliente!';
                $message_type = 'danger';
            } else{

                $customer_id = mysqli_insert_id($connection);

                $query = "UPDATE products set status = 'SELLED' WHERE id = '$product'";
                $result = mysqli_query($connection, $query);        

                $query = "INSERT INTO sales(customer, product) VALUES ('$customer_id', '$product')";
                $result = mysqli_query($connection, $query);    

                $message = 'Cliente registrado con éxito!';
                $message_type = 'success';
            }    
        } else {
            $message = 'Por favor completa todos los campos!';
            $message_type = 'warning';
        }
    }

    /* MENSAJE PARA VERIFICAR SI EL USUARIO SE ELIMNINO CON ÉXITO O NO */
    if(isset($_GET['delete'])){
        $result = $_GET['delete'];
        if($result) {
            $message = 'Cliente eliminado con éxito!';
            $message_type = 'warning';
        } else {
            $message = 'Error al eliminar el cliente!';
            $message_type = 'danger';
        }
    }

?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Registrar nuevo cliente</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="" method="post" class="form">
            <label for="name" class="form-label">Nombre del cliente</label>
            <input type="text" name="name" id="name" placeholder="Nombre del cliente" class="form-input">
            <label for="address" class="form-label">Dirección del cliente</label>
            <input type="text" name="address" id="address" placeholder="Dirección del cliente" class="form-input">
            <label for="phone" class="form-label">Teléfono del Cliente</label>
            <input type="text" name="phone" id="phone" placeholder="Teléfono del cliente" class="form-input">
            <label for="product" class="form-label">Producto</label>
            <select class="form-input" name="product" id="product">
                <?php 
                    $query = "SELECT id, brand_name, generic_name, sale_price FROM products WHERE status = 'STOCK' AND arrival_date < NOW()";
                    $result = mysqli_query($connection, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['brand_name'] ?> - <?php echo $row['generic_name'] ?> - $<?php echo $row['sale_price'] ?></option>
                <?php
                        }
                    }
                ?>
            </select>
            <label for="note" class="form-label">Nota</label>
            <input type="text" name="note" id="note" placeholder="Nota" class="form-input">
            <input type="submit" name="save" value="Registrar cliente" class="form-submit">
        </form>
    </div>

    <h1 class="title">Lista de Clietes</h1>
    <table class="table table-sm">
        <caption>Clientes registrados</caption>
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Producto</th>
                <th scope="col">Total</th>
                <th scope="col">Nota</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php /* SELECCIONAR TODOS LOS REGISTROS QUE HAY EN LA TABLA PRODUCTOS Y MOSTRARLOS QÚE ESTAN DISPONIBLES EN LA TABLA. */
            $query = "SELECT * FROM customers";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <tr>
                <td scope="row" data-label="Nombre"><?php echo $row['name'] ?></td>
                <td scope="row" data-label="Dirección"><?php echo $row['address'] ?></td>
                <td scope="row" data-label="Teléfono"><?php echo $row['phone'] ?></td>
                <td scope="row" data-label="Producto">
                    <?php
                        $product_id = $row['product'];
                        $product_query = "SELECT brand_name, generic_name, sale_price FROM products WHERE id = $product_id";
                        $product_result = mysqli_query($connection, $product_query);
                        $product_row = mysqli_fetch_array($product_result);
                        echo $product_row['brand_name'];
                        echo ' - ';
                        echo $product_row['generic_name'];
                    ?>
                </td>
                <td scope="row" data-label="Total">$<?php echo $row['total'] ?></td>
                <td scope="row" data-label="Nota"><?php echo $row['note'] ?></td>
                <td scope="row" data-label="Fecha de registro"><?php echo $row['create_at'] ?></td>
                <td scope="row" data-label="Opciones">
                    <a href="edit.php?id=<?= $row['id'] ?>"class="btn btn-primary" disabled><i class="fas fa-edit"></i></a>
                    <a href="delete.php?id=<?= $row['id'] ?>"class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php require('../../partials/footer.php'); ?>