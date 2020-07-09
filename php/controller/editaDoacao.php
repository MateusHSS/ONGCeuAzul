<?php
    include_once '../config/conexao.php';
    session_start();

    $id = $_GET['iddoacao'];
    $status = $_GET['stat'];

    //DADOS DA CONTRIBUIÇÃO
    $valor = str_replace(",", ".", $_POST['val']);
    $converte = explode('/', $_POST['venc']);
    $dataVenc = $converte[2].'-'.$converte[1].'-'.$converte[0];

    $sql2 = $connect->prepare("UPDATE tabdoacao SET datavencimentodoacao = ?, doacaostatus = ?, valordoacao = ? WHERE iddoacao = '$id'");
    $sql2->bind_param('sss', $dataVenc, $status, $valor);
    $sql2->execute();

    if($_SESSION['perfil']==2){
        header('location:../operador.php');
    }else{
        header('location: ../admin.php');
    }

        




?>