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
        $query = "SELECT * FROM customers WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
            $address = $row['address'];
            $phone = $row['phone'];
            $note = $row['note'];
        }
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = '../customers/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = "home/customers/edit.php?id=$id"; 

    if(isset($_POST['update'])) {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $note = $_POST['note'];

        $query = "UPDATE customers set name = '$name', address = '$address', phone = '$phone', note = '$note' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            $message = 'Error al editar cliente!';
            $message_type = 'danger';
        } else {
            $message = 'Cliente editado con éxito!';
            $message_type = 'success';
        }      
    }
?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Editar Cliente</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="post" class="form">
            <label for="name" class="form-label">Nuevo nombre del cliente</label>
            <input type="text" name="name" id="name" placeholder="Nombre del cliente" class="form-input" value="<?php echo $name ?>">
            <label for="address" class="form-label">Nueva dirección del cliente</label>
            <input type="text" name="address" id="address" placeholder="Dirección del cliente" class="form-input" value="<?php echo $address ?>">
            <label for="phone" class="form-label">Nuevo teléfono del cliente</label>
            <input type="text" name="phone" id="phone" placeholder="Teléfono del cliente" class="form-input" value="<?php echo $phone ?>">
            <label for="note" class="form-label">Nueva nota</label>
            <input type="text" name="note" id="note" placeholder="Nota" class="form-input" value="<?php echo $note ?>">
            <input type="submit" name="update" value="Actualizar Cliente" class="form-submit">
        </form>
    </div>

<?php require('../../partials/footer.php'); ?>