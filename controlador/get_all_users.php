<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $data = new usuario_model();
    $nombre = $_GET['nombre'];
    $perfil = $_GET['perfil'];
    $elem = $data->get_all_users($nombre,$perfil);
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $persona = $data->get_personal_info($lista['id']);
            $nombre = $persona['nombre1']." ".$persona['nombre2']." ".$persona['apellido1']." ".$persona['apellido2'];
            $perfil = $data->get_user_perfil($lista['idperfil']);
            if ($lista['estado']==0) {
                $btn_editar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm' disabled><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm' onclick='sys_user.activa_usuario(".$lista['id'].")'><i class='glyphicon glyphicon-ok'></i></button></a>";
                $btn_reset = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-warning btn-sm' disabled><i class='glyphicon glyphicon-eye-close'></i></button></a>";
            } else {
                $btn_editar = "<a href='javascript:void(0)' data-toggle='modal' data-target='#myModal' onclick='sys_user.edita_contacto(".$lista['id'].");' style='text-decoration:none;'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-pencil'></i></button></a>";
                $btn_eliminar = "<a href='javascript:void(0)' style='text-decoration:none;'><button type='button' class='btn btn-danger btn-sm' onclick='sys_user.desactiva_usuario(".$lista['id'].")'><i class='glyphicon glyphicon-ban-circle'></i></button></a>";
                $btn_reset = "<a href='javascript:void(0)' style='text-decoration:none;' title='Resetear Contraseña'><button type='button' class='btn btn-warning btn-sm' onclick='sys_user.reset_password(".$lista['id'].")'><i class='glyphicon glyphicon-eye-close'></i></button></a>";
            }
            $arreglo["data"][] = array(utf8_encode($nombre),utf8_encode($perfil['descripcion']),$lista['codusuario'],$lista['estado'],$btn_editar." ".$btn_eliminar." ".$btn_reset);
        }
    } else {
        $arreglo["data"][] = array('SIN REGISTROS','','',3,'');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>