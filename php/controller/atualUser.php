<?php
    include_once '../config/conexao.php';
    session_start();

    $id = $_GET['id'];
    $user = $_GET['user'];
    $perfil = $_GET['perfil'];
    $operador = $_GET['operador'];
    $ativo = $_GET['ativo'];

    if($operador == 1 && isset($_GET['senha'])){
        $idoper = $_GET['idoper'];
        $senha = md5($_GET['senha']);

        $sql = $connect->prepare("UPDATE tabusuario SET usuario = ?, senha = ?, ativo = ?, idperfilusuario = ?, operadorusuario = ?, idoperadorusuario = ? WHERE idusuario = '$id'");
        $sql->bind_param('ssssss', $user, $senha, $ativo, $perfil, $operador, $idoper);
        $sql->execute();

    } else if($operador == 0 && isset($_GET['senha'])){
        $senha = md5($_GET['senha']);

        $sql = $connect->prepare("UPDATE tabusuario SET usuario = ?, senha = ?, ativo = ?, idperfilusuario = ?, operadorusuario = ? WHERE idusuario = '$id'");
        $sql->bind_param('sssss', $user, $senha, $ativo, $perfil, $operador);
        $sql->execute();
    } else if($operador == 1 && !isset($_GET['senha'])){
        $idoper = $_GET['idoper'];

        $sql = $connect->prepare("UPDATE tabusuario SET usuario = ?, ativo = ?, idperfilusuario = ?, operadorusuario = ?, idoperadorusuario = ? WHERE idusuario = '$id'");
        $sql->bind_param('sssss', $user, $ativo, $perfil, $operador, $idoper);
        $sql->execute();
    } else if($operador == 0 && !isset($_GET['senha'])){
        $sql = $connect->prepare("UPDATE tabusuario SET usuario = ?, ativo = ?, idperfilusuario = ?, operadorusuario = ? WHERE idusuario = '$id'");
        $sql->bind_param('ssss', $user, $ativo, $perfil, $operador);
        $sql->execute();
    }

    if($_SESSION['perfil']==2){
        header('location:../operador.php');
    }else{
        header('location: ../consulta/listaUser.php');
    }

        




?>