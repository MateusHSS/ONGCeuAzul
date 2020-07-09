<?php
    include_once '../config/conexao.php';
    $url = $_SERVER['REQUEST_URI'];

    $mens = $_GET['mens'];
    $ids = explode('&id=', $url);

    $i=1;
    for($i=1; $i<count($ids); $i++){
        $id = $ids[$i];
        
        $sql = $connect->prepare("UPDATE tabdoacao SET idmensageirodoacao = ?, doacaostatus = 2, datamensageirodoacao = now() WHERE iddoacao = ?");
        $sql->bind_param('ss', $mens, $id);
        $sql->execute();



    }

    //header('location:../consulta/doacoesAberto.php');

    
?>