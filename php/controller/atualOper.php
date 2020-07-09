<?php
    include_once '../config/conexao.php';
    session_start();

    $id = $_GET['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['tel'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['num'];
    $bairro= $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];

    $sql = $connect->prepare("UPDATE taboperador SET nomeoperador = upper('$nome'), emailoperador = upper('$email') WHERE idoperador = $id");
    $sql->execute();

    $sql2 = $connect->prepare("UPDATE tabendereco SET cep = upper(?), rua = upper(?), bairro = upper(?), cidade = upper(?), numero = ? WHERE idoperadorendereco = '$id'");
    $sql2->bind_param('sssss', $cep, $rua, $bairro, $cidade, $numero);
    $sql2->execute();

    if($_SESSION['perfil']==2){
        header('location:../operador.php');
    }else{
        header('location: ../consulta/listaOper.php');
    }

        




?>