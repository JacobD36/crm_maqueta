<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usuario = new usuario_model();
    $opt = $_GET['opt'];
    $id = $_POST['id'];
    $usuario->cambia_estado($id,$opt);
?>