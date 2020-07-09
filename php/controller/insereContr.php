<?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once '../config/conexao.php';
    session_start();

    //DADOS DO CONTRIBUINTE
    if(isset($_SESSION['idoperador'])){
        $idoperador = $_SESSION['idoperador'];
    }

    $nome = $_POST['nome'];
    $telefone = $_POST['telContr'];
    $cep = $_POST['cepContr'];
    $rua = $_POST['ruaContr'];
    $numero = $_POST['numContr'];
    $bairro= $_POST['bairroContr'];
    $cidade = $_POST['cidadeContr'];
    $obs = $_POST['obs'];
    $ref = $_POST['ref'];

    //DADOS DA CONTRIBUIÇÃO
    $valor = str_replace(",", ".", $_POST['val']);
    $converte = explode('/', $_POST['venc']);
    $dataVenc = new DateTime(date('Y').'-'.$converte[1].'-'.$converte[0].'');
    $vencimento = $dataVenc->format('Y-m-d');
    $categoria = $_POST['tipo-contribuinte'];

    $sqlParcelas = $connect->prepare("SELECT quantidadecategoria FROM tabcategoriacontribuinte WHERE idtabcategoriacontribuinte = $categoria");
    $sqlParcelas->execute();
    $resultParcelas = $sqlParcelas->get_result();

    if($resultParcelas->num_rows > 0){
        while($res = $resultParcelas->fetch_assoc()){
            $parcelas = $res['quantidadecategoria'];
        }
    }else{
        echo "<script type='text/javascript'>alert('Erro ao selecionar categoria!')<script>";
    }


    //INSERE O CONTRIBUINTE NO BANCO
    if($_SESSION['perfil']==1){
        $sql = $connect->prepare("INSERT INTO tabcontribuinte (nomecontribuinte, datacadastrocontribuinte) VALUES (upper(?), now())");
        $sql->bind_param('s', $nome);
        $sql->execute();

        $result = $sql->get_result();

        if($result->num_rows <= 0){
            echo "<script type='text/javascript'>alert('Erro ao inserir 1!')<script>";
        }
    }else if($_SESSION['perfil']==2){
        $sql = $connect->prepare("INSERT INTO tabcontribuinte (nomecontribuinte, datacadastrocontribuinte, idopercontribuinte, categoria) VALUES (upper(?), now(), upper(?), ?)");
        $sql->bind_param('sss', $nome, $idoperador, $categoria);
        $sql->execute();

        $result = $sql->get_result();

        if($result->num_rows <= 0){
            echo "<script type='text/javascript'>alert('Erro ao inserir 2!')<script>";
        }
    }

    //SELECIONA O ULTIMO ID INSERIDO
    $query = "SELECT idcontribuinte FROM tabcontribuinte ORDER BY idcontribuinte DESC limit 1";
    if ($result = $connect->query($query)) {
        while ($row = $result->fetch_row()) {
            $idcontr = $row[0];
        }
    }

    //INSERE O ENDERECO DO CONTRIBUINTE NO BANCO
    $sql2 = $connect->prepare("INSERT INTO tabendereco (idcontribuinteendereco, cep, rua, numero, bairro, cidade, referencia) VALUES (?, ?, upper(?), ?, upper(?), upper(?), upper(?))"); 
    $sql2->bind_param('sssssss', $idcontr, $cep, $rua, $numero, $bairro, $cidade, $ref);
    $sql2->execute();

    $result2 = $sql2->get_result();

    if($result2->num_rows <= 0){
        echo "<script type='text/javascript'>alert('Erro ao inserir endereço!')<script>";
    }
    
    //INSERE CONTATO DO CONTRIBUINTE
    $sql3 = $connect->prepare("INSERT INTO tabcontato (idcontribuintecontato, telefone) VALUES (?, ?)"); 
    $sql3->bind_param('ss', $idcontr, $telefone);
    $sql3->execute();

    $result3 = $sql3->get_result();

    if($result3->num_rows <= 0){
        echo "<script type='text/javascript'>alert('Erro ao inserir contato!')<script>";
    }

    //INSERE CONTRIBUICAO NO BANCO
    if($_SESSION['perfil']==1){
        $i = 0;
        while($i<$parcelas){
            $sql4 = $connect->prepare("INSERT INTO tabdoacao (idcontribuintedoacao, datainclusaodoacao, datavencimentodoacao, valordoacao) VALUES (?, now(), ?, ?)"); 
            $sql4->bind_param('sss', $idcontr, $vencimento, $valor);
            $sql4->execute();

            $result4 = $sql4->get_result();

            if($result4->num_rows <= 0){
                echo "<script type='text/javascript'>alert('Erro ao inserir contribuicao no banco 1!')<script>";
            }
    
            $newDataVenc = $dataVenc->add(new DateInterval('P1M'));
            $vencimento = $newDataVenc->format('Y-m-d');
    
            $i++;
        }
    }else if($_SESSION['perfil']==2){
        $i = 0;
        while($i<$parcelas){
            $sql4 = $connect->prepare("INSERT INTO tabdoacao (idcontribuintedoacao, idoperadordoacao, datainclusaodoacao, datavencimentodoacao, valordoacao) VALUES (?, ?, now(), ?, ?)");
            $sql4->bind_param('ssss', $idcontr, $idoperador, $vencimento, $valor);
            $sql4->execute();

            $result4 = $sql4->get_result();

            if($result4->num_rows <= 0){
                echo "<script type='text/javascript'>alert('Erro ao inserir contribuicao no banco 2!')<script>";
            }
    
            $newDataVenc = $dataVenc->add(new DateInterval('P1M'));
            $vencimento = $newDataVenc->format('Y-m-d');
    
            $i++;
        }
    }
    
    if($_SESSION['perfil']==1){
        header('location:../consulta/listaContrib.php');
    }else if($_SESSION['perfil']==2){
        header('location:../listaContrOp.php');
    }


?>