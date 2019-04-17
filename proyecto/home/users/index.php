
<?php 
    session_start();
    require('../../includes/connection.php'); 
    require('../../includes/functions.php');

    /* VALIDAR QUE EL USUARIO SE ENCUENTRE LOGUEADO */
    if(validate_session() == false){
        header('location: ../index.php');
    }

    /* VALIDAR SI EL USUARIO TIENE EL PERMISO DE ADMINISTRADOR = 1 */
    if(have_permission(1) == false){
        header('location: ../index.php');
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = 'home/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = 'home/users/index.php';

    /* CREAR O REGISTRAR UN NUEVO USUARIO */
    if(isset($_POST['save'])) {
        if(!empty($_POST['user'] && !empty($_POST['alias'] && !empty($_POST['rol'] && !empty($_POST['password'] && !empty($_POST['confirm_password'])))))) {
            if($_POST['password'] == $_POST['confirm_password']){
                $user = $_POST['user'];
                $name = $_POST['alias'];
                $rol = $_POST['rol'];
                $password = $_POST['password'];
                $password_secure = password_hash($password, PASSWORD_DEFAULT);
    
                $query = "INSERT INTO users(user, name, password, rol) VALUES ('$user', '$name', '$password_secure', '$rol')";
                $result = mysqli_query($connection, $query);
                if (!$result){
                    $message = 'Error al registrar el usuario!';
                    $message_type = 'danger';
                } else{
                    $message = 'Usuario creado con éxito!';
                    $message_type = 'success';
                }    
            } else {
                $message = 'Las contraseñas no coinciden!';
                $message_type = 'warning';                
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
            $message = 'Usuario eliminado con Éxito!';
            $message_type = 'warning';
        } else {
            $message = 'Error al eliminar el usuario';
            $message_type = 'danger';
        }
    }

?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Crear nuevo usuario</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="" method="post" class="form">
            <label for="user" class="form-label">Nombre de Usuario</label>
            <input type="text" name="user" id="user" placeholder="Usuario" class="form-input">
            <label for="alias" class="form-label">Alias de Usuario</label>
            <input type="text" name="alias" id="alias" placeholder="Alias" class="form-input">
            <label for="rol" class="form-label">Rol de Usuario</label>
            <select class="form-input" name="rol" id="rol">
                <?php 
                    $query = "SELECT id, name FROM roles";
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
            <label for="password" class="form-label">Contraseña de Usuario</label>
            <input type="password" name="password" id="password" placeholder="Contrseña" class="form-input">
            <label for="confirm_password" class="form-label">Confirmar contraseña de Usuario</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Contrseña" class="form-input">
            <input type="submit" name="save" value="Crear Usuario" class="form-submit">
        </form>
    </div>

    <h1 class="title">Lista de Usuarios</h1>
    <table class="table">
        <caption>Usuarios registrados</caption>
        <thead>
            <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Alias</th>
                <th scope="col">Rol</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php /* SELECCIONAR TODOS LOS REGISTROS QUE HAY EN LA TABLA USUARIO Y MOSTRARLOS EN LA TABLA. */
                $query = "SELECT * FROM users";
                $result = mysqli_query($connection, $query);
                while($row = mysqli_fetch_array($result)) { 
            ?>
            <tr>
                <td scope="row" data-label="Usuario"><?php echo $row['name'] ?></td>
                <td scope="row" data-label="Alias"><?php echo $row['user'] ?></td>
                <td scope="row" data-label="Rol">
                    <?php
                        $rol_id = $row['rol'];
                        $rol_query = "SELECT name FROM roles WHERE id = $rol_id";
                        $rol_result = mysqli_query($connection, $rol_query);
                        $rol_row = mysqli_fetch_array($rol_result);
                        echo $rol_row['name'];
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