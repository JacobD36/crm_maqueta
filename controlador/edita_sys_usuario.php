<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $data = new usuario_model();
    $request_body = file_get_contents("php://input");
    $datos = json_decode($request_body);
    $id = $datos->id_base;
    $lista = $data->get_personal_info($id);
    $lista1 = $data->get_sysuser_info($id);
    $arreglo["data"][] = array(
        'nombre1'=>$lista['nombre1'],
        'nombre2'=>$lista['nombre2'],
        'apellido1'=>$lista['apellido1'],
        'apellido2'=>$lista['apellido2'],
        'dni'=>$lista['dni'],
        'perfil'=>$lista1['idperfil'],
        'superadm'=>$lista1['superadm'],
    );
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>