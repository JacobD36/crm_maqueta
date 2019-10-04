<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $camp = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $cod_campana = strtoupper($datos->cod_campana);
    $desc_campana = $datos->desc_campana;

    if($cod_campana!="" && $desc_campana!=""){
        $camp->set_new_camp($cod_campana,$desc_campana);
    }

    echo $cod_campana;
?>