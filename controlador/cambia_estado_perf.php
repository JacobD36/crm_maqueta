<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $perf = new usuario_model();
    $opt = $_GET['opt'];
    $id = $_POST['id'];
    $perf->cambia_estado_perf($id,$opt);
?>