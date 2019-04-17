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
    $_SESSION['actual_page'] = 'home/products/index.php';

    /* CREAR O REGISTRAR UN NUEVO USUARIO */
    if(isset($_POST['save'])) {
        if(!empty($_POST['brand_name'] && !empty($_POST['generic_name'] && !empty($_POST['description'] && !empty($_POST['arrival_date'] && !empty($_POST['expiration_date'] && !empty($_POST['sale_price'] && !empty(['original_price'] && !empty(['provider']))))))))) {
            $brand_name = $_POST['brand_name'];
            $generic_name = $_POST['generic_name'];
            $description = $_POST['description'];
            $arrival_date = $_POST['arrival_date'];
            $expiration_date = $_POST['expiration_date'];
            $sale_price = $_POST['sale_price'];
            $original_price = $_POST['original_price'];
            $moneymaking = $sale_price - $original_price;
            $provider = $_POST['provider'];

            $query = "INSERT INTO products(brand_name, generic_name, description, arrival_date, expiration_date, sale_price, original_price, moneymaking, provider) VALUES ('$brand_name', '$generic_name', '$description', '$arrival_date', '$expiration_date', '$sale_price', '$original_price', '$moneymaking', '$provider')";
            $result = mysqli_query($connection, $query);
            if (!$result){
                $message = 'Error al registrar el producto!';
                $message_type = 'danger';
            } else{
                $message = 'Producto registrado con éxito!';
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
            $message = 'Producto eliminado con Éxito!';
            $message_type = 'warning';
        } else {
            $message = 'Error al eliminar el producto';
            $message_type = 'danger';
        }
    }

?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Registrar nuevo producto</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="" method="post" class="form">
            <label for="brand_name" class="form-label">Nombre del la marca</label>
            <input type="text" name="brand_name" id="brand_name" placeholder="Nombre de la marca" class="form-input">
            <label for="generic_name" class="form-label">Nombre generico</label>
            <input type="text" name="generic_name" id="generic_name" placeholder="Nombre generico" class="form-input">
            <label for="description" class="form-label">Categoria o Descripción</label>
            <input type="text" name="description" id="description" placeholder="Descripción" class="form-input">
            <label for="arrival_date" class="form-label">Fecha de llegada</label>
            <input type="date" name="arrival_date" id="arrival_date" placeholder="Fecha de llegada" class="form-input">
            <label for="expiration_date" class="form-label">Fecha de caducidad</label>
            <input type="date" name="expiration_date" id="expiration_date" placeholder="Fecha de cadicidad" class="form-input">
            <label for="sale_price" class="form-label">Precio de venta</label>
            <input type="number" name="sale_price" id="sale_price" placeholder="Precio de venta" class="form-input">
            <label for="original_price" class="form-label">Precio original</label>
            <input type="number" name="original_price" id="original_price" placeholder="Precio original" class="form-input">
            <label for="provider" class="form-label">Proveedor</label>
            <select class="form-input" name="provider" id="provider">
                <?php 
                    $query = "SELECT id, name FROM providers";
                    $result = mysqli_query($connection, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                ?>
                <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                <?php
                        }
                    } 
                ?>
            </select>            
            <input type="submit" name="save" value="Registrar producto" class="form-submit">
        </form>
    </div>

    <h1 class="title">Lista de Productos</h1>
    <table class="table table-xsm">
        <caption>Productos disonibles</caption>
        <thead>
            <tr>
                <th scope="col">Nombre de la marca</th>
                <th scope="col">Nombre generico</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha de llegada</th>
                <th scope="col">Fecha de caducidad</th>
                <th scope="col">Precio de venta</th>
                <th scope="col">Precio original</th>
                <th scope="col">Ganancía</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
        <?php /* SELECCIONAR TODOS LOS REGISTROS QUE HAY EN LA TABLA PRODUCTOS Y MOSTRARLOS QÚE ESTAN DISPONIBLES EN LA TABLA. */
            $query = "SELECT * FROM products WHERE status = 'STOCK'";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($result))
            { ?>
            <tr>
                <td scope="row" data-label="Nombre de la marca"><?php echo $row['brand_name'] ?></td>
                <td scope="row" data-label="Nombre generico"><?php echo $row['generic_name'] ?></td>
                <td scope="row" data-label="Descripción"><?php echo $row['description'] ?></td>
                <td scope="row" data-label="Fecha de llegada"><?php echo $row['arrival_date'] ?></td>
                <td scope="row" data-label="Fecha de caducidad"><?php echo $row['expiration_date'] ?></td>
                <td scope="row" data-label="Precio de venta"><?php echo $row['sale_price'] ?></td>
                <td scope="row" data-label="Precio original"><?php echo $row['original_price'] ?></td>
                <td scope="row" data-label="Ganancia"><?php echo $row['moneymaking'] ?></td>
                <td scope="row" data-label="Proveedor">
                    <?php
                        $provider_id = $row['provider'];
                        $provider_query = "SELECT name FROM providers WHERE id = $provider_id";
                        $provider_result = mysqli_query($connection, $provider_query);
                        $provider_row = mysqli_fetch_array($provider_result);
                        echo $provider_row['name'];
                    ?>
                </td>
                <td scope="row" data-label="Opciones">
                    <a href="edit.php?id=<?= $row['id'] ?>"class="btn btn-primary" disabled><i class="fas fa-edit"></i></a>
                    <a href="delete.php?id=<?= $row['id'] ?>"class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php require('../../partials/footer.php'); ?>