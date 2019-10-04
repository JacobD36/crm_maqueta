<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $data = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $id = $datos->id_base;
    $lista = $data->get_campana($id);
    $arreglo["data"][] = array(
        'cod_campana'=>$lista['cod_campana'],
        'desc_campana'=>$lista['desc_campana']
    );
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>