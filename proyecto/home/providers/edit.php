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
        $query = "SELECT * FROM providers WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $name = $row['name'];
            $address = $row['address'];
            $contact_person = $row['contact_person'];
            $phone = $row['phone'];
            $note = $row['note'];
        }
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = '../providers/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = "home/providers/edit.php?id=$id"; 

    if(isset($_POST['update'])) {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact_person = $_POST['contact_person'];
        $phone = $_POST['phone'];
        $note = $row['note'];

        $query = "UPDATE providers set name = '$name', address = '$address', contact_person = '$contact_person', phone = '$phone', note = '$note' WHERE id = '$id'";
        echo $query;
        $result = mysqli_query($connection, $query);
        if(!$result) {
            $message = 'Error al editar proveedor';
            $message_type = 'danger';
        } else {
            $message = 'Proveedor editado con exito!';
            $message_type = 'success';
        }      
    }
?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Editar proveedor</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="post" class="form">
            <label for="name" class="form-label">Nuevo Nombre de Proveedor</label>
            <input type="text" name="name" id="name" placeholder="Nombre" class="form-input" value="<?php echo $name ?>">
            <label for="address" class="form-label">Nueva dirección del Proveedor</label>
            <input type="text" name="address" id="address" placeholder="Dirección" class="form-input" value="<?php echo $address ?>">
            <label for="contact_person" class="form-label">Nueva persona de Contacto</label>
            <input type="text" name="contact_person" id="contact_person" placeholder="Persona de Contacto" class="form-input" value="<?php echo $contact_person ?>">
            <label for="phone" class="form-label">Nueva número de Contacto</label>
            <input type="text" name="phone" id="phone" placeholder="Número" class="form-input" value="<?php echo $phone ?>">
            <label for="note" class="form-label">Nota o Descripción</label>
            <input type="text" name="note" id="note" placeholder="Nota" class="form-input" value="<?php echo $note ?>">
            <input type="submit" name="update" value="Actualizar Proveedor" class="form-submit">
        </form>
    </div>

<?php require('../../partials/footer.php'); ?>