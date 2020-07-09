<?php
    require_once '../config/conexao.php';

    $nome = $_POST['nomeC'];
    $telefone = $_POST['telC'];
    $cep = $_POST['cepC'];
    $rua = $_POST['ruaC'];
    $numero = $_POST['numC'];
    $bairro= $_POST['bairroC'];
    $cidade = $_POST['cidadeC'];
    $email = $_POST['emailC'];
    $rg = $_POST['rgC'];
    $cpf = $_POST['cpfC'];

    //INSERE O OPERADOR NO BANCO
    $sql = $connect->prepare("INSERT INTO taboperador (nomeoperador, emailoperador, rgoperador, cpfoperador) VALUES (upper(?), upper(?), upper(?), ?)");
    $sql->bind_param('ssss', $nome, $email, $rg, $cpf);
    $sql->execute();

    //SELECIONA O ULTIMO ID INSERIDO
    $query = "SELECT idoperador FROM taboperador ORDER BY idoperador DESC limit 1;"; 
    if ($result = $connect->query($query)) {
        while ($row = $result->fetch_row()) {
            $idoperador = $row[0];
        }
        /* free result set */
        $result->close();
    }

    //INSERE O ENDERECO DO OPERADOR NO BANCO
    $sql2 = $connect->prepare("INSERT INTO tabendereco (idoperadorendereco, cep, rua, numero, bairro, cidade) VALUES (?, ?, upper(?), ?, upper(?), upper(?))"); 
    $sql2->bind_param('ssssss', $idoperador, $cep, $rua, $numero, $bairro, $cidade);
    $sql2->execute();

    //INSERE O ENDERECO DO OPERADOR NO BANCO
    $sql3 = $connect->prepare("INSERT INTO tabcontato (idoperadorcontato, telefone) VALUES (?, ?)"); 
    $sql3->bind_param('ss', $idoperador, $telefone);
    $sql3->execute();

    header('location:../consulta/listaOper.php');

?>