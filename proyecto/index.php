<?php
    session_start();
    require('includes/connection.php');

    /* VALIDAR SI EL USUARIO YA CUENTA CON UNA SESIÓN Y SI ES ASÍ REDIRIGIRLO A LA RUTA HOME */
    if(isset($_SESSION['user_id'])) {
        header("location: home/index.php");     
    }

    /* VALIDAR LA INFORMACIÓN QUE SE RECIBE DEL FORMULARIO */
    if(isset($_POST['submit'])) {
        if(!empty($_POST['user'] && !empty($_POST['password']))){
            $user = $_POST['user'];
            $password = $_POST['password'];
            
            $query = "SELECT * FROM users WHERE user = '$user'";
            $result = mysqli_query($connection, $query);
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $user = $row['user'];
                $real_password = $row['password'];
                if(password_verify($password, $real_password)){
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_alias'] = $row['user'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_rol'] = $row['rol'];
                    $message = 'Inició de sesión correcto!';
                    $message_type = 'success';
                    header("location: home/index.php");             
                } else {
                    $message = 'Usuario o contraseña incorrecta!';
                    $message_type = 'danger';                    
                }
            } else {
                $message = 'Usuario o contraseña incorrecta!';
                $message_type = 'danger';
            }    
        } else {
            $message = 'Por favor completa todos los campos';
            $message_type = 'warning';
        }
    }

?>

<?php require('partials/header.php'); ?>

    <div class="box">
        <h1 class="title">Inició de Sesión</h1>

        <?php if(!empty($message)) { ?>
            <div class="alert alert-<?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php } ?>

        <form action="" method="post" class="form">
            <label for="user" class="form-label">Nombre de Usuario</label>
            <input type="text" name="user" id="user" placeholder="Usuario" class="form-input">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="Contrseña" class="form-input">
            <input type="submit" name="submit" value="Iniciar Sesión" class="form-submit">
        </form>
    </div>

<?php require('partials/footer.php'); ?>