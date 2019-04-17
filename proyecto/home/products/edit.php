<?php 
    session_start();
    require('../../includes/connection.php'); 
    require('../../includes/functions.php');

    /* VALIDAR QUE EL USUARIO SE ENCUENTRE LOGUEADO */
    if(validate_session() == false){
        header('location: ../../index.php');
    }

    /* VALIDAR SI EL USUARIO TIENE EL PERMISO DE ADMINISTRADOR = 1 */
    if(have_permission(1) == false){
        header('location: ../../index.php');
    }

    $id = '';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT * FROM products WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $brand_name = $row['brand_name'];
            $generic_name = $row['generic_name'];
            $description = $row['description'];
            $arrival_date = $row['arrival_date'];
            $expiration_date = $row['expiration_date'];
            $sale_price = $row['sale_price'];
            $original_price = $row['original_price'];
            $provider = $row['provider'];
            $moneymaking = $row['moneymaking'];
        }
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = '../products/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = "home/products/edit.php?id=$id"; 

    if(isset($_POST['update'])) {
        $id = $_GET['id'];
        $brand_name = $_POST['brand_name'];
        $generic_name = $_POST['generic_name'];
        $description = $_POST['description'];
        $arrival_date = $_POST['arrival_date'];
        $expiration_date = $_POST['expiration_date'];
        $sale_price = $_POST['sale_price'];
        $original_price = $_POST['original_price'];
        $moneymaking = $sale_price - $original_price;
        $provider = $_POST['provider'];

        $query = "UPDATE products set brand_name = '$brand_name', generic_name = '$generic_name', description = '$description', arrival_date = '$arrival_date', expiration_date = '$expiration_date', sale_price = '$sale_price', original_price = '$original_price', moneymaking = '$moneymaking', provider = '$provider' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            $message = 'Error al editar producto!';
            $message_type = 'danger';
        } else {
            $message = 'Producto editado con éxito!';
            $message_type = 'success';
        }      
    }
?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Editar producto</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="post" class="form">
            <label for="brand_name" class="form-label">Nuevo nombre de la marca</label>
            <input type="text" name="brand_name" id="brand_name" placeholder="Nombre de la marca" class="form-input" value="<?php echo $brand_name ?>">
            <label for="generic_name" class="form-label">Nuevo nombre generico</label>
            <input type="text" name="generic_name" id="generic_name" placeholder="Nombre generico" class="form-input" value="<?php echo $generic_name ?>">
            <label for="description" class="form-label">Nueva categoria o descripción</label>
            <input type="text" name="description" id="description" placeholder="Descripción" class="form-input" value="<?php echo $description ?>">
            <label for="arrival_date" class="form-label">Nueva fecha de llegada</label>
            <input type="date" name="arrival_date" id="arrival_date" placeholder="Fecha" class="form-input" value="<?php echo $arrival_date ?>">
            <label for="expiration_date" class="form-label">Nueva fecha de caducidad</label>
            <input type="date" name="expiration_date" id="expiration_date" placeholder="Fecha" class="form-input" value="<?php echo $expiration_date ?>">
            <label for="sale_price" class="form-label">Nuevo precio de ventas</label>
            <input type="number" name="sale_price" id="sale_price" placeholder="Precio de venta" class="form-input" value="<?php echo $sale_price ?>">
            <label for="original_price" class="form-label">Nuevo precio original</label>
            <input type="number" name="original_price" id="original_price" placeholder="Precio de original" class="form-input" value="<?php echo $original_price ?>">
            <label for="moneymaking" class="form-label">Ganancia</label>
            <input type="number" name="moneymaking" id="moneymaking" placeholder="Ganancia" class="form-input" value="<?php echo $moneymaking ?>" readonly>
            <label for="provider" class="form-label">Nuevo proveedor</label>
            <select class="form-input" name="provider" id="provider">
                <?php 
                    $query = "SELECT id, name FROM providers";
                    $result = mysqli_query($connection, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $provider) { echo 'selected'; } ?>><?php echo $row['name'] ?></option>
                        <?php
                        }
                    } 
                ?>
            </select>
            <input type="submit" name="update" value="Actualizar Producto" class="form-submit">
        </form>
    </div>

<?php require('../../partials/footer.php'); ?>