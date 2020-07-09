<?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once '../config/conexao.php';
    session_start();

    $idcontr = $_GET['idcontribuinte'];

    //DADOS DA CONTRIBUIÇÃO
    $valor = str_replace(",", ".", $_POST['val']);
    $converte = explode('/', $_POST['venc']);
    $dataVenc = new DateTime(date('Y').'-'.$converte[1].'-'.$converte[0].'');
    $vencimento = $dataVenc->format('Y-m-d');
    $categoria = $_GET['tipo-contribuinte'];

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

    $sqlContr = $connect->prepare("SELECT idopercontribuinte FROM tabcontribuinte WHERE idcontribuinte = $idcontr");
    $sqlContr->execute();
    $resultContr = $sqlContr->get_result();

    while($resContr = $resultContr->fetch_assoc()){
        $idoperador = $resContr['idopercontribuinte'];
    }

    
    $i = 0;
    while($i<$parcelas){
        $sql4 = $connect->prepare("INSERT INTO tabdoacao (idcontribuintedoacao, idoperadordoacao, datainclusaodoacao, datavencimentodoacao, valordoacao) VALUES (?, ?, now(), ?, ?)");
        $sql4->bind_param('ssss', $idcontr, $idoperador, $vencimento, $valor);
        $sql4->execute();

        $newDataVenc = $dataVenc->add(new DateInterval('P1M'));
        $vencimento = $newDataVenc->format('Y-m-d');

        $i++;
    }

    
    if($_SESSION['perfil']==1){
        header('location:../consulta/listaContrib.php');
    }else if($_SESSION['perfil']==2){
        header('location:../operador.php');
    }


?>