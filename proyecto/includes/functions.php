<?php
    /* FUNCIÓN PARA VERIFICAR QUE UN USUARIO ESTE CONECTADO */

    function validate_session(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

    /* FUNCIÓN PARA VERIFICAR QUE UN USUARIO TIENE UN PERMISO REQUERIDO */
    function have_permission($permission_id){
        if($_SESSION['user_rol'] ==  $permission_id) {
            return true;
        } else {
            return false;
        }
    }
?>