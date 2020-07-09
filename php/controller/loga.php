<?php
    require_once '../config/conexao.php';
    session_start();

    //$idoperador = $_SESSION['idOper'];
    $user = $_POST['user'];
    $senha = md5($_POST['pass']);

    //SELECIONA O USUARIO
    $query = mysqli_query($connect, "SELECT * FROM tabusuario WHERE usuario= '$user' AND senha = '$senha'"); 
    
    if (mysqli_num_rows($query)>0) {
        $result = mysqli_fetch_array($query);
        if($result['idperfilusuario']==1){
            $_SESSION['perfil'] = $result['idperfilusuario'];
            $_SESSION['user'] = $result['idusuario'];
            $_SESSION['logado'] = true;
            header('location:../admin.php');
        }else if($result['idperfilusuario']==2){
            $_SESSION['idoperador'] = $result['idoperadorusuario'];
            $_SESSION['perfil'] = $result['idperfilusuario'];
            $_SESSION['user'] = $result['idusuario'];
            $_SESSION['logado'] = true;
            header('location:../operador.php');
        }
    }else{
        echo 'usuario ou senha incorreto';
    }

?>