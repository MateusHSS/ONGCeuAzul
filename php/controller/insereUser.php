<?php
    require_once '../config/conexao.php';

    $user = $_POST['user'];
    $perfil = $_POST['perfil'];
    $idOper = $_POST['idOper'];
    $senha = md5($_POST['senha']);

    if(isset($_POST['ativo'])){
        $ativo= 1;
    }else{
        $ativo= 0;
    }

    if(isset($_POST['operador'])){
        $operador = 1;

        $sql = $connect->prepare("INSERT INTO tabusuario (usuario, senha, ativo, idperfilusuario, operadorusuario, idoperadorusuario) VALUES (?, ?, ?, ?, ?, ?)");
        $sql->bind_param('ssssss', $user, $senha, $ativo, $perfil, $operador, $idOper);
        

        if($sql->execute()){
            header('location:../admin.php');
        }else{
            $erro = mysqli_error($connect);
            if (substr_count($erro, 'usuario')) {
                echo"<script language='javascript' type='text/javascript'>alert('Este usuário já está cadastrado!');window.location.href='../admin.php';</script>";
            }elseif (substr_count($erro, 'idOper')) {
                echo"<script language='javascript' type='text/javascript'>alert('Operador já cadastrado!');window.location.href='../admin.php';</script>";
            }
        }

    }
    else{
        $operador = 0;

        echo $user.'<br>';
        echo $senha.'<br>';
        echo $perfil.'<br>';
        echo $operador.'<br>';
        echo $ativo.'<br>';

        $sql = $connect->prepare("INSERT INTO tabusuario (usuario, senha, ativo, idperfilusuario, operadorusuario) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('sssss', $user, $senha, $ativo, $perfil, $operador);

        if($sql->execute()){
            header('location: ../consulta/listaUser.php');
        }else{
            echo mysqli_error($connect);
        }
    }

?>