<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $data = new usuario_model();
    $nombre = $_GET['nombre'];
    $elem = $data->get_all_campanas($nombre);
    if ($elem!=null) {
        foreach ($elem as $lista) {
            if ($lista['estado']==0) {
                $btn_editar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm' disabled><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;' onclick='sys_camp.activa_campana(".$lista['id'].")' title='Activar Campaña'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-ok'></i></button></a>";
            } else {
                $btn_editar = "<a href='javascript:void(0)' data-toggle='modal' data-target='#myModal' onclick='sys_camp.edita_campana(".$lista['id'].");' style='text-decoration:none;' title='Editar Campaña'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;' onclick='sys_camp.desactiva_campana(".$lista['id'].")' title='Desactivar Campaña'><button type='button' class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-ban-circle'></i></button></a>";
            }
            $arreglo["data"][] = array($lista['id'],$lista['cod_campana'],$lista['desc_campana'],$lista['estado'],$btn_editar." ".$btn_eliminar);
        }
    } else {
        $arreglo["data"][] = array('','SIN REGISTROS','','','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>