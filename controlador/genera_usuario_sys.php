<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usuario = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $nombre1 = strtoupper($datos->nombre1);
    $nombre2 = strtoupper($datos->nombre2);
    $apellido1 = strtoupper($datos->apellido1);
    $apellido2 = strtoupper($datos->apellido2);
    $dni = $datos->dni;
    $perfil = $datos->perfil;
    $superadm = $datos->superadm;
    $password = $usuario->generar_password_complejo(10);

    if($nombre1!="" && $apellido1!="" && $apellido2!="" && $dni!="" && $perfil!=""){
        $codusuario = $usuario->set_new_user($nombre1,$nombre2,$apellido1,$apellido2,$dni,$perfil,$superadm,$password);
    }

    echo $codusuario."|".$password;
?>