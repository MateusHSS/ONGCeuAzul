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
    $obs = $_POST['obs'];
    $ref = $_POST['ref'];

    
    $sql = $connect->prepare("UPDATE tabcontribuinte SET nomecontribuinte = upper('$nome') WHERE idcontribuinte = $id");
    $sql->execute();

    $sql2 = $connect->prepare("UPDATE tabendereco SET cep = ?, rua = upper(?), bairro = upper(?), cidade = upper(?), numero = ?, referencia = upper(?), obs = (?) WHERE idcontribuinteendereco = '$id'");
    $sql2->bind_param('sssssss', $cep, $rua, $bairro, $cidade, $numero, $ref, $obs);
    $sql2->execute();

    if($_SESSION['perfil']==2){
        header('location:../operador.php');
    }else{
        header('location: ../consulta/listaContrib.php');
    }

        




?>