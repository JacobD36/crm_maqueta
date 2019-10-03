<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/app_maqueta/modelo/usuario_model.php");
    session_start();
    $res = 0;
    $usuario = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $username = strtolower($datos->username);
    $userpass = $datos->userpass;
    if ($username!='' and $userpass!='') {
        $idperfil = $usuario->valida_acceso($username, $userpass);
        if ($idperfil!=null) {
            $_SESSION['usuario'] = $username;
            $_SESSION['perfil'] = $idperfil['idperfil'];    
            $_SESSION['id'] = $idperfil['id'];
            $_SESSION['superadm'] = $idperfil['superadm'];
            $_SESSION['start'] = time();
            $_SESSION['BASE'] = $_SERVER['DOCUMENT_ROOT']."/app_maqueta";
            $res = 1;
        }
    }
    echo $res;
?>