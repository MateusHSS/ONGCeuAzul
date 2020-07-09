<?php
    require_once '../config/conexao.php';

    $nome = $_POST['nome'];
    $telefone = $_POST['tel'];
    $veiculo = $_POST['veiculo'];
    $placa = $_POST['placa'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $bairro= $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $numero = $_POST['num'];


    //INSERE O MENSAGEIRO NO BANCO
    $sql = $connect->prepare("INSERT INTO tabmensageiro (nomemensageiro, fonemensageiro, veiculo, placa, rgmensageiro, cpfmensageiro) VALUES (upper(?), ?, ?, upper(?), upper(?), upper(?))");
    $sql->bind_param('ssssss', $nome, $telefone, $veiculo, $placa, $rg, $cpf);
    $sql->execute();

    //SELECIONA O ULTIMO ID INSERIDO
    $query = "SELECT idmensageiro FROM tabmensageiro ORDER BY idmensageiro DESC limit 1;"; 
    if ($result = $connect->query($query)) {
        while ($row = $result->fetch_row()) {
            $idmensageiro = $row[0];
        }
        /* free result set */
        $result->close();
    }

    //INSERE O ENDERECO DO OPERADOR NO BANCO
    $sql2 = $connect->prepare("INSERT INTO tabendereco (idmensageiroendereco, cep, rua, numero, bairro, cidade) VALUES (?, ?, upper(?), ?, upper(?), upper(?))"); 
    $sql2->bind_param('ssssss', $idmensageiro, $cep, $rua, $numero, $bairro, $cidade);
    $sql2->execute();

    header('location:../consulta/listaMens.php');

?>