<?php
    include_once '../config/conexao.php';
    session_start();

    $id = $_GET['id'];

    $sql = $connect->prepare("DELETE FROM tabcontribuinte WHERE idcontribuinte = '$id'");
    $sql->execute();

    $sql2 = $connect->prepare("DELETE FROM tabendereco WHERE idcontribuinteendereco = '$id'");
    $sql2->execute();

    $sql3 = $connect->prepare("DELETE FROM tabcontato WHERE idcontribuintecontato = '$id'");
    $sql3->execute();

    if($_SESSION['perfil']==1){
        header('location:../consulta/listaContrib.php');
    }else if($_SESSION['perfil']==2){
        header('location:../listaContrOp.php');
    }

?>