<?php
    include_once '../config/conexao.php';

    $id = $_GET['id'];

    $sql = $connect->prepare("DELETE FROM taboperador WHERE idoperador = '$id'");
    $sql->execute();

    $sql2 = $connect->prepare("DELETE FROM tabendereco WHERE idoperadorendereco = '$id'");
    $sql2->execute();

    $sql3 = $connect->prepare("DELETE FROM tabcontato WHERE idoperadorcontato = '$id'");
    $sql3->execute();

    header('location: ../consulta/listaOper.php');

?>