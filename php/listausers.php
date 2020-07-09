<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        
?>
<html>
  <head>
    <title>ONG Céu Azul - Usuários</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
  </head>

  <body>
    <div class="navbar-fixed">
        <nav class='blue lighten-2'>
            <div class="nav-wrapper">
                <div class='container'>
                    <a href="#" class="brand-logo"><img src="../img/ceuAzulLogo.png" style='width: 13%;'></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="row">
        <div class='col s2 sidenav sidenav-fixed z-depth-2 no-padding' style="height: 100vh;top: 11%;">
            <ul class="center">
                <li>
                    <div>
                        <ul>
                            <li>
                                <div class='row center'>
                                    <a href="listausers.php" class="btn blue lighten-2" style="width:55%;height:5%" id='user'>Usuário</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listaopers.php" class="btn blue lighten-2" style="width:55%;height:5%" id='oper'>Operador</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listamens.php" class="btn blue lighten-2" style="width:55%;height:5%" id='mens'>Mensageiro</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listacontrs.php" class="btn blue lighten-2" style="width:55%;height:5%" id='contr'>Contribuinte</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listadoac.php" class="btn blue lighten-2" style="width:55%;height:5%" id='doac'>Doações</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="relatorioComissao.php" class="btn blue lighten-2" style="width:55%;height:5%" id='relat'>Relatório</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class='col l10 offset-l2' id='conteudo'>
            <div class="row">
                <div class="col l10">
                    <table class="centered responsive-table card" style='max-height: 10px;'>
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Perfil</th>
                                <th>Ativo</th>
                                <th class="exclui">Excluir</th>
                                <th class="altera">Alterar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                        include 'config/conexao.php';

                        $sql="SELECT u.*, p.nomeperfil FROM tabusuario u, tabperfil p WHERE p.idperfil = u.idperfilusuario ORDER BY ativo DESC";
                        $result=$connect->query($sql);
                        while($res= $result->fetch_array()){
                            switch($res['ativo']){
                                case 0:
                                    $ativo= 'Inativo';
                                    $atl = '';
                                break;
                                case 1:
                                    $ativo = 'Ativo';
                                    $atl = 'checked';
                                break;
                            }

                            switch($res['operadorusuario']){
                                case 0:
                                    $op = '';
                                break;
                                case 1:
                                    $op = 'checked';
                                break;
                            }
                            ?>
                            <tr>
                                <td><?php echo $res['usuario'] ?></td>
                                <td><?php echo $res['nomeperfil'] ?></td>
                                <td><?php echo $ativo ?></td>
                                <td class='exclui' onclick="confirmaExclu(<?php echo $res['idusuario'] ?>)"><a><i class='material-icons red-text'>clear</i></a></td>
                                <td class='altera'><a href='#altera<?php echo $res['idusuario'] ?>' class='modal-trigger'><i class='material-icons purple-text'>create</i></a></td>
                            </tr>

                            <div class='modal' id='altera<?php echo $res['idusuario'] ?>'>
                                <div class='modal-content'>
                                    <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                    <h4>Alterar dados</h4>
                                    <div class='center' id='conteudo<?php echo $res['idusuario'] ?>'>
                                        <form class='col m12 center' id='formUser<?php echo $res['idusuario'] ?>' action='' method='POST'>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='user<?php echo $res['idusuario'] ?>' type='text' class='validate' name='user<?php echo $res['idusuario'] ?>' value='<?php echo $res['usuario'] ?>' required>
                                                    <label for='user<?php echo $res['idusuario'] ?>'>Usuário</label>
                                                </div>
                                                <div class='input-field col l6'>
                                                    <select name='perfil<?php echo $res['idusuario'] ?>' id='perfil<?php echo $res['idusuario'] ?>'>
                                                    <option value='<?php echo $res['idperfilusuario'] ?>' selected><?php echo $res['nomeperfil'] ?></option>
                                                    <option value='1'>Administrador</option>
                                                    <option value='2'>Operador</option>
                                                    </select>
                                                    <label>Perfil</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col l6'>
                                                    <p>
                                                        <label>
                                                            <input type='checkbox' class='filled-in' id='ativo<?php echo $res['idusuario'] ?>' <?php echo $atl ?> />
                                                            <span>Ativo</span>
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class='col l3'>
                                                    <p>
                                                        <label>
                                                            <input type='checkbox' class='filled-in operador' id='operador<?php echo $res['idusuario'] ?>' name='operador<?php echo $res['idusuario'] ?>' <?php echo $op ?> />
                                                            <span>Operador</span>
                                                        </label>
                                                    </p>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='idoper<?php echo $res['idusuario'] ?>' type='text' class='validate' name='idoper<?php echo $res['idusuario'] ?>' value='<?php echo $res['idoperadorusuario'] ?>' required>
                                                    <label for='idoper<?php echo $res['idusuario'] ?>'>Id do operador</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='pass<?php echo $res['idusuario'] ?>' type='password' class='validate' name='pass<?php echo $res['idusuario'] ?>' required>
                                                    <label for='pass<?php echo $res['idusuario'] ?>'>Nova senha</label>
                                                </div>
                                                <div class='input-field col l6'>
                                                    <input id='confirmPass<?php echo $res['idusuario'] ?>' type='password' class='validate' required>
                                                    <label for='confirmPass<?php echo $res['idusuario'] ?>'>Confirma senha</label>
                                                </div>
                                            </div>
                                            
                                            <div class='btn blue lighten-2 botao' id='<?php echo $res['idusuario'] ?>' type='submit' name='action'>Atualizar
                                                <i class='material-icons right'>check</i>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="col l2 center">
                    <a class="btn right blue lighten-2 card modal-trigger" href="#modal-user" id='novo-user' style='width:80%;'>Novo</a>
                    <a class="btn right blue lighten-2 card" id='alter-user' style='width:80%;'>Alterar</a>
                    <a class="btn right blue lighten-2 card" id='excl-user' style='width:80%;'>Excluir</a>
                </div>

                <div class="modal" id="modal-user">
                    <div class="modal-content">
                        <div class="row right"><i class="material-icons modal-close">close</i></div>
                        <h4>Novo usuário</h4>
                        <div id="user-conteudo">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').material_select();
            $('.altera').hide();
            $('.exclui').hide();
            $('#excl-user').click(function(){
                $('.exclui').toggle();
            });
            $('#alter-user').click(function(){
                $('.altera').toggle();
            });
            $('.modal').modal();
            $('#novo-user').click(function(){
                $('#user-conteudo').load('cadastroUser.php');
            });
            $(".operador").click(function(e) { 
                var id = $(this).attr('id');
                if($(this).is(':checked')) { //Retornar true ou false 
                    $('#idoper'+id).show(); // CheckBox marcado
                    $('#idoper'+id).attr('required', 'required');
                } else {
                    $('#idoper'+id).hide();
                    $('#idoper'+id).removeAttr('required');
                }
            }); 

            $('.botao').click(function (){
                
                var id = $(this).attr('id');
                var user = $('#user'+id).val();
                var perfil = $('#perfil'+id).val();
                var url = 'controller/atualUser.php?id='+id+'&user='+user+'&perfil='+perfil;
                if($('#ativo'+id).is(':checked')){
                    var ativo = 1;
                }else{
                    var ativo = 0;
                }

                url += '&ativo='+ativo;

                if($('#operador'+id).is(':checked')){
                    var operador = 1;
                    var idoper = $('#idoper'+id).val();

                    url += '&operador='+operador+'&idoper='+idoper;
                }else{
                    var operador = 0;
                    url += '&operador='+operador;
                }

                
                if($('#pass'+id).val() != ''){
                    if($('#pass'+id).val() == $('#confirmPass'+id).val()){
                        var senha = $('#pass'+id).val();
                        url += '&senha='+senha;

                        window.location.href = url;
                    }else{
                        alert('As senhas nao coincidem!!');
                    }
                }else{
                    window.location.href = url;
                }
                
                
            });

            
        });

        function confirmaExclu(id){
            var apagar = confirm('Deseja realmente excluir este registro?');
            if (apagar){
                window.location.href = "controller/excluiUser.php?id="+id;
            }else{
                event.preventDefault();
            }
        }

    </script>
  </body>
</html>
<?php
    }
?>