<?php
    include_once '../config/conexao.php';
    session_start();


    $idUser = $_SESSION['user'];
    $id = $_GET['id'];

    //ATUALIZA STATUS DA DOACAO PARA 'QUITADO'
    $sql = $connect->prepare("UPDATE tabdoacao d SET d.doacaostatus = 3 WHERE d.iddoacao = '$id'");
    $sql->execute();

    //SELECIONA DADOS DA DOACAO
    $query = "SELECT * FROM tabdoacao WHERE iddoacao = '$id'";
    if ($result = $connect->query($query)) {
        while ($row = $result->fetch_array()) {
            $idoper = $row['idoperadordoacao'];
            $valor = $row['valordoacao'];
            $vencimento = $row['datavencimentodoacao'];
            $mensageiro = $row['idmensageirodoacao'];
        }
    }

    echo $vencimento;

    //INSERE BAIXA DA DOACAO
    $sql2 = $connect->prepare("INSERT INTO tabbaixa (iddoacaobaixa, idusuario, idoperadorbaixa, idmensageirobaixa, databaixa, valorbaixa, vencimentobaixa) VALUES (?, ?, ?, ?, now(), ?, ?)");
    $sql2->bind_param('ssssss', $id, $idUser, $idoper, $mensageiro, $valor, $vencimento);
    $sql2->execute();

    // header('location: ../listadoac.php');

?>