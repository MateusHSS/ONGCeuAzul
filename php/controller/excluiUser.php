<?php
    include_once '../config/conexao.php';

    $id = $_GET['id'];

    $sql = $connect->prepare("DELETE FROM tabusuario WHERE idusuario = '$id'");
    $sql->execute();

    header('location: ../consulta/listaUser.php');

?>