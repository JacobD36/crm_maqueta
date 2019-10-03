<?php 
    session_start();
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usuario = new usuario_model();
    $opt = $_GET['opt'];
    $id = $_POST['id'];
    $usuario->cambia_estado($id,$opt);
?>