<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usuario = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $codusuario = $datos->codusuario;
    $password1 = $datos->password1;
    $password2 = $datos->password2;
    
    if($password1 == $password2){
        $usuario->actualiza_password($codusuario,$password1);
    }
?>