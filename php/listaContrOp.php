<?php
    session_start();
    if($_SESSION['perfil']!=2){
        header('location:../index.php');
    }else{
        
?>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG Céu Azul - Contribuintes</title>
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

    <style>
        ::-webkit-scrollbar-track {
            background-color: #F4F4F4;
        }
        ::-webkit-scrollbar {
            width: 6px;
            background: #F4F4F4;
        }
        ::-webkit-scrollbar-thumb {
            background: #dad7d7;
        }
        #resultado{
            max-height: 70vh;
            overflow: auto;
        }
        #resultado2{
            margin: 11vh 0 0 10vh;
            height: auto;
            max-height: 50vh;
            width: 50vh;
            overflow: auto;
            position: absolute;
            z-index: 999;
        }
    </style>
  </head>
  <body onload='carregado()'>
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
        <div class='col s12 m3 l2 sidenav sidenav-fixed z-depth-2' style="height: 100vh;top: 11%;">
            <ul class="center">
                <li>
                    <div class='row center'>
                        <a href="listaContrOp.php" class="waves-effect waves-light btn blue lighten-2" style="width:85%;" id='contr'>Contribuinte</a>
                    </div>
                </li>
                <li>
                    <div class='row center'>
                    <a href="listadoacOp.php" class="waves-effect waves-light btn blue lighten-2" style="width:85%;" id='doac'>Doações</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class='col s12 m9 l10 offset-l2' id='conteudo'>
            <div class="row">
                <div class="col l10 center">
                    <div id="loader">
                                <div class="progress">
                                    <div class="indeterminate" style="width: 70%"></div>
                                </div>
                                <span>Carregando registros...</span>
                            </div>
                    <table class="centered responsive-table card" id='list' style='display: none;'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Telefone</th>
                                <th>Data de cadastro</th>
                                <th>Operador</th>
                                <th class='nova-doacao'>Doação</th>
                                <th class="exclui">Excluir</th>
                                <th class="altera">Alterar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                        include 'config/conexao.php';

                        $idoper = $_SESSION['idoperador'];

                        $sql2="SELECT count(*) as totalContr FROM tabcontribuinte c WHERE c.idopercontribuinte = '$idoper'";
                        $result2=$connect->query($sql2);
                        $res2 = $result2->fetch_array();

                        $sql="SELECT c.*, date_format(datacadastrocontribuinte, '%e/%m/%Y') as datacad, e.*, o.*, cont.* FROM 
                        tabcontribuinte c, tabendereco e, taboperador o, tabcontato cont WHERE idopercontribuinte='$idoper' AND 
                        e.idcontribuinteendereco = c.idcontribuinte AND c.idopercontribuinte = o.idoperador AND
                        cont.idcontribuintecontato = c.idcontribuinte ORDER BY datacadastrocontribuinte DESC";
                        $result=$connect->query($sql);
                        while($res= $result->fetch_array()){
                            ?>
                            <tr>
                                <td><?php echo $res['idcontribuinte'] ?></td>
                                <td><?php echo $res['nomecontribuinte'] ?></td>
                                <td><?php echo $res['cidade'] ?></td>
                                <td><?php echo $res['bairro'] ?></td>
                                <td><?php echo $res['telefone'] ?></td>
                                <td><?php echo $res['datacad'] ?></td>
                                <td><?php echo $res['nomeoperador'] ?></td>
                                <td class="nova-doacao"><a href="#nova-doacao<?php echo $res['idcontribuinte'] ?>"
                                        class='modal-trigger'><i class="material-icons green-text">add</i></a></td>
                                <td class='exclui' onclick="confirmaExclu(<?php echo $res['idcontribuinte'] ?>)"><a><i class='material-icons red-text'>clear</i></a></td>
                                <td class='altera'><a href='#alterModal<?php echo $res['idcontribuinte'] ?>' class='modal-trigger' ><i class='material-icons purple-text'>create</i></a></td>
                            </tr>

                            <div class='modal fade' id='alterModal<?php echo $res['idcontribuinte'] ?>'>
                                <div class='modal-content'>
                                    <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                    <h4>Alterar registros</h4>
                                    <div class='divider'></div>
                                    <form method='post' action='controller/atualContr.php?id=<?php echo $res['idcontribuinte'] ?>' id='atualiza<?php echo $res['idcontribuinte'] ?>'>
                                        <div class='row'>
                                            <div class='input-field col l6'>
                                                <input id='nome<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='nome' value='<?php echo $res['nomecontribuinte'] ?>' required>
                                                <label class='active' for='nome<?php echo $res['idcontribuinte'] ?>'>Nome completo</label>
                                            </div>
                                            <div class='input-field col l3'>
                                                <input id='tel<?php echo $res['idcontribuinte'] ?>' type='text' class='validate tel' name='tel' value='<?php echo $res['telefone'] ?>' data-id='<?php echo $res['idcontribuinte'] ?>' required>
                                                <label class='active' for='tel'>Telefone</label>
                                            </div>
                                            <div class='input-field col l3'>
                                                <input id='cep<?php echo $res['idcontribuinte'] ?>' type='text' class='validate cep' name='cep' value='<?php echo $res['cep'] ?>' data-id='<?php echo $res['idcontribuinte'] ?>'>
                                                <label class='active' for='cep<?php echo $res['idcontribuinte'] ?>'>CEP</label>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='input-field col l3'>
                                                <input id='rua<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='rua' value='<?php echo $res['rua'] ?>' required>
                                                <label class='active' for='rua<?php echo $res['idcontribuinte'] ?>'>Rua</label>
                                            </div>
                                            <div class='input-field col l3'>
                                                <input id='num<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='num' value='<?php echo $res['numero'] ?>' required>
                                                <label class='active' for='num<?php echo $res['idcontribuinte'] ?>'>Número</label>
                                            </div>
                                            <div class='input-field col l3'>
                                                <input id='bairro<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='bairro' value='<?php echo $res['bairro'] ?>' required>
                                                <label class='active' for='bairro<?php echo $res['idcontribuinte'] ?>'>Bairro</label>
                                            </div>
                                            <div class='input-field col l3'>
                                                <input id='cidade<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='cidade' value='<?php echo $res['cidade'] ?>' required>
                                                <label class='active' for='cidade<?php echo $res['idcontribuinte'] ?>'>Cidade</label>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='input-field col l6'>
                                                <input id='ref<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='ref' value='<?php echo $res['referencia'] ?>'>
                                                <label class='active' for='ref<?php echo $res['idcontribuinte'] ?>'>Ponto de referência</label>
                                            </div>
                                            <div class='input-field col l6'>
                                                <input id='obs<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='obs' value='<?php echo $res['obs'] ?>'>
                                                <label class='active' for='obs<?php echo $res['idcontribuinte'] ?>'>Observações</label>
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <button class='btn blue lighten-2 botao' type='submit' name='action' id='<?php echo $res['idcontribuinte'] ?>'>Atualizar
                                                <i class='material-icons right'>check</i>
                                            </button>
                                        </div>
                                
                                    </form>
                                
                                </div>
                            </div>

                            <div class='modal fade' id='nova-doacao<?php echo $res['idcontribuinte'] ?>'>
                                <div class='modal-content'>
                                    <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                    <h4>Gerar doação</h4>
                                    <div class='divider'></div>
                                    <p>Contribuinte: <?php echo $res['nomecontribuinte'] ?></p>
                                    <form method='post'
                                        action='controller/novaDoacao.php?idcontribuinte=<?php echo $res['idcontribuinte'] ?>'
                                        id='gera-doacao<?php echo $res['idcontribuinte'] ?>'>
                                        <div class="row">
                                            <div class="input-field col l3">
                                                <input id="val" type="text" class="validate val" name='val'>
                                                <label for="val">Valor</label>
                                            </div>
                                            <div class="input-field col l3">
                                                <input placeholder='mm/aa' id="venc" type="text" class="validate venc"
                                                    name='venc'>
                                                <label for="venc">Vencimento</label>
                                            </div>
                                            <div class="input-field col l3">
                                                <input id="parc" type="text" class="validate" name='parc'>
                                                <label for="parc">Parcelas</label>
                                            </div>
                                        </div>
                                        <div class="row center">
                                            <button class='btn blue lighten-2 botao' type='submit' name='action'
                                                id='<?php echo $res['idcontribuinte'] ?>'>Atualizar
                                                <i class='material-icons right'>check</i>
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="col l2 fixed">
                    <a class="btn modal-trigger right blue lighten-2 card" href="#modal-contr" id='novo-contr' style='width:100%;'>Novo</a>
                    <a class="btn right blue lighten-2 card" id='alter-contr' style='width:100%;'>Alterar</a>
                    <a class="btn right blue lighten-2 card" id='excl-contr' style='width:100%;'>Excluir</a>
                    <a class="btn right blue lighten-2 card" id='nova-doacao' style='width:100%;'>Gerar doação</a>
                    <p>Total de registros: <?php echo $res2['totalContr']; ?></p>
                </div>
                
            </div>

            <div class="modal" id="modal-contr">
                <div class="modal-content">
                    <div class="row right"><i class="material-icons modal-close">close</i></div>
                    <h4>Novo contribuinte</h4>
                    <div id="contr-conteudo">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-contr">
        <div class="modal-content">
            <div class="row right"><i class="material-icons modal-close">close</i></div>
            <h4>Novo contribuinte</h4>
            <div id="contr-conteudo">

            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/listacontrs.js"></script>
  </body>
</html>
<?php
    }
?>
