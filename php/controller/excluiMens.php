<?php
    include_once '../config/conexao.php';
    session_start();

    $id = $_GET['id'];

    $sql = $connect->prepare("DELETE FROM tabmensageiro WHERE idmensageiro = $id");
    $sql->execute();

    if($_SESSION['perfil']==1){
        header('location:../consulta/listaMens.php');
    }else if($_SESSION['perfil']==2){
        header('location:../listaContrOp.php');
    }

?>