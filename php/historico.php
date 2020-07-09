<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        include_once 'config/conexao.php';
        $sql2="SELECT tabbaixa.idtabbaixa, tabcontribuinte.nomecontribuinte, tabdoacao.iddoacao, taboperador.nomeoperador, REPLACE(tabbaixa.valorbaixa,'.',',') as valorbaixa, date_format(tabbaixa.databaixa, '%e/%m/%Y') as databaixa, tabstatus.nomestatus
                    FROM tabbaixa
                INNER JOIN tabdoacao ON tabdoacao.iddoacao = tabbaixa.iddoacaobaixa
                INNER JOIN tabcontribuinte ON tabcontribuinte.idcontribuinte = tabdoacao.idcontribuintedoacao
                INNER JOIN taboperador ON taboperador.idoperador = tabbaixa.idoperadorbaixa
                INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                ORDER BY tabbaixa.idtabbaixa DESC";
        $result2=$connect->query($sql2);
?>
<html>

<head>
    <title>ONG Céu Azul - Administrador</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Compiled and minified CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>

    <!-- Compiled and minified JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        .recibo{
            display: none;
        }
        .atribui{
            display: none;
        }
        .receber{
            display: none;
        }
        .editar{
            display: none;
        }
    </style>
    <script>
            $(document).ready(function() {
                //BUSCA DE DOADORES PELO NOME
                $('#doacao').keyup(function() {

                    $('#buscaContr').submit(function() {

                        var dados = $(this).serialize();

                        $.ajax({

                            url: 'controller/buscaHistorico.php',
                            type: 'POST',
                            dataType: 'html',
                            data: dados,
                            success: function(data) {

                                $('#lista-doacoes').empty().html(data);
                            }
                        });

                        return false;

                    });

                    $('#buscaContr').trigger('submit');

                });

            })
        </script>
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
        <div class='col s2 sidenav sidenav-fixed z-depth-2 no-padding' style="height: 100vh;top: 11%;">
            <ul class="center">
                <li>
                    <div>
                        <ul>
                            <li>
                                <div class='row center'>
                                    <a href="listausers.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='user'>Usuário</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listaopers.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='oper'>Operador</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listamens.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='mens'>Mensageiro</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listacontrs.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='contr'>Contribuinte</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listadoac.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='doac'>Doações</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="historico.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='hist'>Histórico</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="relatorioComissao.php" class="btn blue lighten-2"
                                        style="width:55%;height:5%" id='relat'>Relatório</a>
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
                    <div class="row">
                        <div class="col l6">
                            <form action="#" id='buscaContr'>
                                <div class="input-field col l6">
                                    <input id="doacao" type="text" class="validate" name='doacao'>
                                    <label for="doacao">Busca</label>
                                </div>
                                <div class="input-field col l6">
                                    <select id='filtroStat'>
                                    <option class='filtro' value="indeferido">Indeferido</option>
                                    <option class='filtro' value="naocontr">Não contribuiu</option>
                                    <option class='filtro' value="quitado">Quitado</option>             
                                    <option value="todos" selected>Todos</option>
                                    </select>
                                    <label>Filtrar por:</label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col l12 center" id='lista-doacoes'>
                            <div id="loader">
                                <div class="progress">
                                    <div class="indeterminate" style="width: 70%"></div>
                                </div>
                                <span>Carregando registros...</span>
                            </div>
                            <table class="centered striped responsive-table card" id='list' style='display: none;'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Contribuinte</th>
                                        <th>Doação</th>
                                        <th>Operador</th>
                                        <th>Valor</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                while($res2 = $result2->fetch_array()){
                                    switch($res2['nomestatus']){
                                        case "<p style='color: green'>Quitado</p>":
                                            echo '<tr class="filtro quitado">';
                                        break;
                                        case "<p style='color: brow'>Não contribuiu</p>":
                                            echo '<tr class="filtro naocontr">';
                                        break;
                                        case "<p style='color: grey'>Indeferido</p>":
                                            echo '<tr class="filtro indeferido">';
                                        break;
                                    }
                                    ?>
                                        <td><?php echo $res2['idtabbaixa'] ?></td>
                                        <td><?php echo $res2['nomecontribuinte'] ?></td>
                                        <td><?php echo $res2['iddoacao'] ?></td>
                                        <td><?php echo $res2['nomeoperador'] ?></td>
                                        <td><?php echo $res2['valorbaixa'] ?></td>
                                        <td><?php echo $res2['databaixa'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col l2">
                    <a class="btn blue lighten-2 card" href="#" id='edita-doac' style='width: 90%;'>Editar</a>
                </div>
            </div>

            <div class="modal" id="modal-mens">
                <div class="modal-content">
                    <div class="row right"><i class="material-icons modal-close">close</i></div>
                    <h4>Novo mensageiro</h4>
                    <div id="mens-conteudo">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script src='../js/listadoac.js'></script>
    <script>
        $(document).ready(function(){
            $('.oi').click(function(){
                var id = $(this).attr('id');

                $.ajax({

                    url: 'controller/confirmaBaixa.php?id='+id,
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        alert('Baixa confirmada!');
                        $('#status'+id).text('Quitado');
                        $('#recebe'+id).hide();
                    }
                });

                return false;
            })
        })
    </script>
</body>

</html>
<?php
    }
?>