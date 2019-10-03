<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usuario = new usuario_model();
    $id = $_POST['id'];
    $usr_info = $usuario->get_sysuser_info($id);
    $password = $usuario->generar_password_complejo(10);
    $pass = $usuario->actualiza_password($usr_info['codusuario'],$password);
    echo $password;
?>