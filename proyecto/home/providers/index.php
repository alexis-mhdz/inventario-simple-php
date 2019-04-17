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
    $_SESSION['actual_page'] = 'home/providers/index.php';

    /* CREAR O REGISTRAR UN NUEVO USUARIO */
    if(isset($_POST['save'])) {
        if(!empty($_POST['name'] && !empty($_POST['address'] && !empty($_POST['contact_person'] && !empty($_POST['phone'] && !empty($_POST['note'])))))) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $contact_person = $_POST['contact_person'];
            $phone = $_POST['phone'];
            $note = $_POST['note'];

            $query = "INSERT INTO providers(name, address, contact_person, phone, note) VALUES ('$name', '$address', '$contact_person', '$phone', '$note')";
            $result = mysqli_query($connection, $query);
            if (!$result){
                $message = 'Error al registrar el proveedor!';
                $message_type = 'danger';
            } else{
                $message = 'Proveedor creado con éxito!';
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
            $message = 'Proveedor eliminado con Éxito!';
            $message_type = 'warning';
        } else {
            $message = 'Error al eliminar el proveedor';
            $message_type = 'danger';
        }
    }

?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Crear nuevo proveedor</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="" method="post" class="form">
            <label for="name" class="form-label">Nombre del proveedor</label>
            <input type="text" name="name" id="name" placeholder="Proveedor" class="form-input">
            <label for="address" class="form-label">Dirección del proveedor</label>
            <input type="text" name="address" id="address" placeholder="Dirección" class="form-input">
            <label for="contact_person" class="form-label">Persona de Contacto</label>
            <input type="text" name="contact_person" id="contact_person" placeholder="Persona de contacto" class="form-input">
            <label for="phone" class="form-label">Número de Contacto</label>
            <input type="phone" name="phone" id="phone" placeholder="Número" class="form-input">
            <label for="note" class="form-label">Nota o Descripción</label>
            <input type="note" name="note" id="note" placeholder="Nota" class="form-input">
            <input type="submit" name="save" value="Crear Proveedor" class="form-submit">
        </form>
    </div>

    <h1 class="title">Lista de Proveedores</h1>
    <table class="table table-sm">
        <caption>Proveedores registrados</caption>
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Persona de contacto</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Nota</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php /* SELECCIONAR TODOS LOS REGISTROS QUE HAY EN LA TABLA USUARIO Y MOSTRARLOS EN LA TABLA. */
                $query = "SELECT * FROM providers";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_array($result)) { 
            ?>
            <tr>
                <td scope="row" data-label="Nombre"><?php echo $row['name'] ?></td>
                <td scope="row" data-label="Dirección"><?php echo $row['address'] ?></td>
                <td scope="row" data-label="Persona de contacto"><?php echo $row['contact_person'] ?></td>
                <td scope="row" data-label="Teléfono"><?php echo $row['phone'] ?></td>        
                <td scope="row" data-label="Nota"><?php echo $row['note'] ?></td>        
                <td scope="row" data-label="Opciones">
                    <a href="edit.php?id=<?= $row['id'] ?>"class="btn btn-primary" disabled><i class="fas fa-edit"></i></a>
                    <a href="delete.php?id=<?= $row['id'] ?>"class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php require('../../partials/footer.php'); ?>