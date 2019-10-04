<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $perf = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $descripcion = $datos->descripcion;

    if($descripcion!=""){
        $perf->set_new_perfil($descripcion);
    }

    echo $descripcion;
?>