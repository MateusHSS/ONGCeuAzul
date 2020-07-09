<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        
?>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG Céu Azul - Operadores</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.css"
        media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- FONTE DA LOGO -->
    <link href="https://fonts.googleapis.com/css?family=Fauna+One&display=swap" rel="stylesheet">

    <!-- CSS DA PAGINA -->
    <link rel="stylesheet" href="../../css/cadastro.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
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
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th class="exclui">Excluir</th>
                                <th class="altera">Alterar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                        include 'config/conexao.php';

                        $sql="SELECT o.*, e.*, cont.* FROM taboperador o, tabendereco e, tabcontato cont WHERE 
                        e.idoperadorendereco = o.idoperador AND cont.idoperadorcontato = o.idoperador ";
                        $result=$connect->query($sql);
                        while($res= $result->fetch_array()){
                            ?>
                            <tr>
                                <td><?php echo $res['idoperador'] ?></td>
                                <td><?php echo $res['nomeoperador'] ?></td>
                                <td><?php echo $res['emailoperador'] ?></td>
                                <td><?php echo $res['telefone'] ?></td>
                                <td class='exclui' onclick="confirmaExclu(<?php echo $res['idoperador'] ?>)"><a><i class='material-icons red-text'>clear</i></a></td>
                                <td class='altera'><a href='#altera<?php echo $res['idoperador'] ?>' class='modal-trigger'><i class='material-icons purple-text'>create</i></a></td>
                            </tr>

                            <div class='modal' id='altera<?php echo $res['idoperador'] ?>'>
                                <div class='modal-content'>
                                    <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                    <h4>Alterar dados</h4>
                                    <div class='center' id='conteudo<?php echo $res['idoperador'] ?>'>
                                        <form class='col l12 center' action='controller/atualOper.php?id=<?php echo $res['idoperador'] ?>' method='post'>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='nome<?php echo $res['idoperador'] ?>' type='text' class='validate' name='nome' value='<?php echo $res['nomeoperador'] ?>' required>
                                                    <label class='active' for='nome<?php echo $res['idoperador'] ?>'>Nome completo</label>
                                                </div>
                                                <div class='input-field col l6'>
                                                    <input id='email<?php echo $res['idoperador'] ?>' type='text' class='validate' name='email' value='<?php echo $res['emailoperador'] ?>' required>
                                                    <label class='active' for='email<?php echo $res['idoperador'] ?>'>Email</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='tel<?php echo $res['idoperador'] ?>' type='text' class='validate' name='tel' value='<?php echo $res['telefone'] ?>' required>
                                                    <label class='active' for='tel<?php echo $res['idoperador'] ?>'>Telefone</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cep<?php echo $res['idoperador'] ?>' type='text' class='validate' name='cep' value='<?php echo $res['cep'] ?>' >
                                                    <label class='active' for='cep<?php echo $res['idoperador'] ?>'>CEP</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='rua<?php echo $res['idoperador'] ?>' type='text' class='validate' name='rua' value='<?php echo $res['rua'] ?>' required>
                                                    <label class='active' for='rua<?php echo $res['idoperador'] ?>'>Rua</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='num<?php echo $res['idoperador'] ?>' type='text' class='validate' name='num' value='<?php echo $res['numero'] ?>' required>
                                                    <label class='active' for='num<?php echo $res['idoperador'] ?>'>Número</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='bairro<?php echo $res['idoperador'] ?>' type='text' class='validate' name='bairro' value='<?php echo $res['bairro'] ?>' required>
                                                    <label class='active' for='bairro<?php echo $res['idoperador'] ?>'>Bairro</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cidade<?php echo $res['idoperador'] ?>' type='text' class='validate' name='cidade' value='<?php echo $res['cidade'] ?>' required>
                                                    <label class='active' for='cidade<?php echo $res['idoperador'] ?>'>Cidade</label>
                                                </div>
                                            </div>
                                            <button class='btn blue lighten-2 botao' type='submit' name='action' id='<?php echo $res['idoperador'] ?>'>Salvar
                                                <i class='material-icons right'>check</i>
                                            </button>
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
                <div class="col l2 fixed" style='position:fixed;margin-left: 67%;'>
                    <a class="btn modal-trigger right blue lighten-2 card" href="#modal-oper" id='novo-oper' style='width:80%;'>Novo</a>
                    <a class="btn right blue lighten-2 card" id='alter-oper' style='width:80%;'>Alterar</a>
                    <a class="btn right blue lighten-2 card" id='excl-oper' style='width:80%;'>Excluir</a>
                </div>
            </div>

            <div class="modal" id="modal-oper">
                <div class="modal-content">
                    <div class="row right"><i class="material-icons modal-close">close</i></div>
                    <h4>Novo operador</h4>
                    <div id="oper-conteudo">

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
            $('.exclui').hide();
            $('.altera').hide();
            $('.modal').modal();
            $('#novo-oper').click(function(){
                $('#oper-conteudo').load('cadastroOper.php');
            });
            $('#excl-oper').click(function(){
                $('.exclui').toggle();
            });
            $('#alter-oper').click(function(){
                $('.altera').toggle();
            });
            $('.botao').click(function (){
                var id = $(this).attr('id');
                var nome = $('#nome'+id).val();
                var telefone = $('#tel'+id).val();
                var cep = $('#cep'+id).val();
                var rua = $('#rua'+id).val();
                var num = $('#num'+id).val();
                var bairro = $('#bairro'+id).val();
                var cidade = $('#cidade'+id).val();
                var email = $('#email'+id).val();
                
                window.location.href ='controller/atualOper.php?id='+id+'&nome='+nome+'&tel='+telefone+'&cep='+cep+'&rua='+rua+'&num='+num+'&bairro='+bairro+'&cidade='+cidade+'&email='+email;
            });
        });

        function confirmaExclu(id){
            var apagar = confirm('Deseja realmente excluir este registro?');
            if (apagar){
                window.location.href = "controller/excluiOper.php?id="+id;
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