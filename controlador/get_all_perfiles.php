<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $data = new usuario_model();
    $elem = $data->get_all_perfiles();
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $arreglo["data"][] = array('id'=>$lista['id'],'descripcion'=>$lista['descripcion']);
        }
    } else {
        $arreglo["data"][] = array('id'=>'','descripcion'=>'SIN REGISTROS');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>