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
        $query = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $alias = $row['user'];
            $name = $row['name'];
            $rol = $row['rol'];
            $password = $row['password'];
        }
    }

    /* MODIFICAR RUTAS PARA EL BOTÓN DE REGRESO DEL HEADER */
    if(!isset($_SESSION['actual_page'])){
        $_SESSION['actual_page'] = '../users/index.php';
    }

    $_SESSION['previous_page'] = $_SESSION['actual_page'];
    $_SESSION['actual_page'] = "home/users/edit.php?id=$id"; 

    if(isset($_POST['update'])) {
        $id = $_GET['id'];
        $alias = $_POST['alias'];
        $name = $_POST['name'];
        $rol = $_POST['rol'];
        $new_password = $_POST['password'];


        if($password != $new_password) {
            $password_secure = password_hash($new_password, PASSWORD_DEFAULT);
        } else {
            $password_secure = $password;
        }

        $query = "UPDATE users set user = '$alias', password = '$password_secure', name = '$name', rol = '$rol' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            $message = 'Error al editar usuario';
            $message_type = 'danger';
        } else {
            $message = 'Usuario editado con exito!';
            $message_type = 'success';
        }      
    }
?>

<?php require('../../partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Editar usuario</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="post" class="form">
            <label for="name" class="form-label">Nuevo Nombre de Usuario</label>
            <input type="text" name="name" id="name" placeholder="Usuario" class="form-input" value="<?php echo $name ?>">
            <label for="alias" class="form-label">Nuevo Alias de Usuario</label>
            <input type="text" name="alias" id="alias" placeholder="Alias" class="form-input" value="<?php echo $alias ?>">
            <label for="rol" class="form-label">Nuevo Rol de Usuario</label>
            <select class="form-input" name="rol" id="rol">
                <?php 
                    $query = "SELECT id, name FROM roles";
                    $result = mysqli_query($connection, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $rol) { echo 'selected'; } ?>><?php echo $row['name'] ?></option>
                        <?php
                        }
                    } 
                ?>
            </select>
            <label for="password" class="form-label">Nueva contraseña de Usuario</label>
            <input type="password" name="password" id="password" placeholder="Contrseña" class="form-input" value="<?php echo $password ?>">
            <input type="submit" name="update" value="Actualizar Usuario" class="form-submit">
        </form>
    </div>

<?php require('../../partials/footer.php'); ?>