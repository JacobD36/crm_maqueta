<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $camp = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $id = $datos->id;
    $cod_campana = $datos->cod_campana;
    $desc_campana = $datos->desc_campana;
    
    if($cod_campana!="" && $desc_campana!=""){
        $camp->actualiza_campana($id,$cod_campana,$desc_campana);
    }
?>