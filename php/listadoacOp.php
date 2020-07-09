<?php
    session_start();
    if($_SESSION['perfil']!=2){
        header('location:../index.php');
    }else{

        include 'config/conexao.php';

        $idoper = $_SESSION['idoperador'];

        $sql="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabcontribuinte.nomecontribuinte, tabdoacao.valordoacao, 
        DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
            FROM tabdoacao 
        INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
        INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
        INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
        INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
        INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
        WHERE tabdoacao.idoperadordoacao = '$idoper' ORDER BY tabdoacao.datavencimentodoacao LIMIT 10";
        $result=$connect->query($sql);
        
?>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG Céu Azul - Doações</title>
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
    <script>
            $(document).ready(function() {
                //input de busca pacientes canto esquerdo
                $('#buscar').click(function() {

                    $('#buscaContr').submit(function() {

                        var dados = $(this).serialize();

                        $.ajax({

                            url: 'buscaContrOp.php',
                            type: 'POST',
                            dataType: 'html',
                            data: dados,
                            success: function(data) {

                                $('#lista-doacoes').empty().html(data);
                                $('.atribui').hide();
                                $('.receber').hide();
                                $('.recibo').hide();
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
        <div class='col s12 m3 l2 sidenav sidenav-fixed z-depth-2' style="height: 100vh;top: 11%;">
            <ul class="center">
                <li>
                    <div class='row center'>
                        <a href="listaContrOp.php" class="waves-effect waves-light btn blue lighten-2" style="width:85%;" id='contr'>Contribuinte</a>
                    </div>
                </li>
                <li>
                    <div class='row center'>
                        <button href="listadoacOp.php" class="waves-effect waves-light btn blue lighten-2" style="width:85%;" id='doac'>Doações</button>
                    </div>
                </li>
            </ul>
        </div>
        <div class='col s12 m9 l10 offset-l2' id='conteudo'>
            <div class="row">
                <div class="col l12">
                    <div class="row">
                        <form action="" id='buscaContr'>
                            <div class="input-field col l4">
                                <input id="doacao" type="text" class="validate" name='doacao'>
                                <label for="doacao">Busca</label>
                                <button class='btn blue lighten-2' id='buscar'>Buscar</button>
                            </div>
                        </form>
                        <div class="input-field col l2">
                            <select id='filtroStat'>
                            <option class='filtro' value="" disabled selected>Exibir apenas:</option>
                            <option class='filtro' value="aberto">Em aberto</option>
                            <option class='filtro' value="cobranca">Em cobrança</option>
                            <option class='filtro' value="quitado">Quitado</option>
                            <option class='filtro' value="todos">Todos</option>
                            </select>
                            <label>Filtrar por:</label>
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
                                        <th>Cidade</th>
                                        <th>Bairro</th>
                                        <th>Contribuinte</th>
                                        <th>Valor</th>
                                        <th>Vencimento</th>
                                        <th>Mensageiro</th>
                                        <th>Status</th>
                                        <th>Operador</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                while($res = $result->fetch_array()){
                                    switch($res['nomestatus']){
                                        case "<p style='color: green'>Quitado</p>":
                                            echo '<tr class="filtro quitado">';
                                        break;
                                        case "<p style='color: orange'>Em cobrança</p>":
                                            echo '<tr class="filtro cobranca ">';
                                        break;
                                        case "<p style='color: red'>Em aberto</p>":
                                            echo '<tr class="filtro aberto">';
                                        break;
                                    }
                                    ?>
                                        <td><?php echo $res['iddoacao'] ?></td>
                                        <td><?php echo $res['cidade'] ?></td>
                                        <td><?php echo $res['bairro'] ?></td>
                                        <td><?php echo $res['nomecontribuinte'] ?></td>
                                        <td><?php echo $res['valordoacao'] ?></td>
                                        <td><?php echo $res['vencimento'] ?></td>
                                        <td><?php echo $res['nomemensageiro'] ?></td>
                                        <td><?php echo $res['nomestatus'] ?></td>
                                        <td><?php echo $res['nomeoperador'] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr id='carregar'>
                                    <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar
                                            mais...</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" id='top'>
        <a class="btn-floating btn-large blue">
            <i class="large material-icons">keyboard_arrow_up</i>
        </a>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script src="../js/listadoac.js"></script>
    <script>
        $(document).ready(function(){
            $('select').material_select();
            $('.modal').modal();
            $('#novo-mens').click(function(){
                $('#mens-conteudo').load('cadastroMens.php');
            });
            });

        function carrega() {
            var inicio = $("tbody tr").length - 1;

            $.ajax({

                url: 'controller/carregaDoacoesOp.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    inicio: inicio
                },
                success: function(data) {
                    $('#list').append(data);
                    $('#carregar').remove();
                    $('#list').append(
                        "<tr id='carregar'><td colspan='13'><a href='#!' class='mais' onclick='carrega()'>Carregar mais...</a></td></tr>"
                        );


                }
            });

            return false;
        }
    </script>
  </body>
</html>
<?php
    }
?>
