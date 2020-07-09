<?php
    session_start();
    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2){
        header('location:../index.php');
    }else{
        include_once '../config/conexao.php';

        if($_SESSION['perfil'] == 1){
            $sql2="SELECT DISTINCT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
                    date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
                        from tabdoacao 
                    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
                    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
                    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
                    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                    WHERE tabdoacao.doacaostatus = 2
                    ORDER BY tabdoacao.datavencimentodoacao ASC LIMIT 100";
        } else if($_SESSION['perfil'] == 2){
            $idoper = $_SESSION['idoperador'];

            $sql2="SELECT DISTINCT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
                    date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
                        from tabdoacao 
                    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
                    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
                    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
                    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                    WHERE tabdoacao.doacaostatus = 2 AND taboperador.idoperador = $idoper
                    ORDER BY tabdoacao.datavencimentodoacao ASC LIMIT 100";
        }
        
        $result2=$connect->query($sql2);
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG - Doações em cobrança</title>

    <!--Import Google Icon Font-->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->

    <link type="text/css" rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Compiled and minified CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- FONTE DA LOGO -->

    <link href="https://fonts.googleapis.com/css?family=Fauna+One&display=swap" rel="stylesheet">

    <!-- CSS DA PAGINA -->

    <link rel="stylesheet" href="../../css/home.css">

    <!-- Compiled and minified JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style>
    .recibo {
        display: none;
    }

    .atribui {
        display: none;
    }

    .receber {
        display: none;
    }

    .editar {
        display: none;
    }
    </style>
    <script>
    $(document).ready(function() {
        //BUSCA DE DOADORES PELO NOME
        $('#buscar').click(function() {

            $('#buscaContr').submit(function() {

                var dados = $(this).serialize();

                $.ajax({

                    url: '../controller/buscaDoacoesCobranca.php',
                    type: 'POST',
                    dataType: 'html',
                    data: dados,
                    success: function(data) {

                        $('#lista-doacoes').empty().html(data);
                        $('.atribui').hide();
                        $('.receber').hide();
                        $('.recibo').hide();
                        $('#data-inicio').val('');
                        $('#data-fim').val('');
                        $('#filtroStat').val('todos');
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
    <?php 

if($_SESSION['perfil'] == 1){
    ?>
    <header>

        <nav class="nav-extended ">
            <div class="container">
                <div class="nav-wrapper ">
                    <a href="#" class="brand-logo" id='logo'>Logo</a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="../controller/logout.php">Sair</a></li>
                        <li></li>
                    </ul>
                </div>
            </div>

            <div class="container menu">

                <!-- MENU CONTRIBUINTES -->

                <ul id="contribuinte-menu" class="dropdown-content">
                    <li><a href='../cadastro/cadastroContr.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='listaContrib.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <ul id="doacoes-menu" class="dropdown-content">
                    <li><a href='doacoesAberto.php'>Em aberto</a></li>
                    <li><a href='doacoesCobranca.php'>Em cobrança</a></li>
                    <li><a href='doacoesQuitado.php'>Quitado/Indeferido</a></li>
                    <li><a href='#'>Totais</a></li>
                </ul>

                <!-- MENU MENSAGEIROS -->

                <ul id="mensageiro-menu" class="dropdown-content">
                    <li><a href='../cadastro/cadastroMens.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='listaMens.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <!-- MENU OPERADORES -->

                <ul id="operador-menu" class="dropdown-content">
                    <li><a href='../cadastro/cadastroOper.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='listaOper.php'><i class="material-icons">list</i>Listagem</a></li>
                    <li><a href='../relatorios/comissao.php'><i class="material-icons">description</i>Comissão</a></li>
                </ul>

                <!-- MENU USUÁRIO -->

                <ul id="usuario-menu" class="dropdown-content">
                    <li><a href='../cadastro/cadastroUser.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='listaUser.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <div class="nav-content ">

                    <ul class="tabs tabs-transparent">

                        <li class="tab"><a class="dropdown-trigger active"
                                data-target="contribuinte-menu">CONTRIBUINTES<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                        <li class="tab"><a class="dropdown-trigger active" data-target="doacoes-menu">DOAÇÕES<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                        <li class="tab"><a class="dropdown-trigger active" data-target="mensageiro-menu">MENSAGEIROS<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                        <li class="tab"><a class="dropdown-trigger active" data-target="operador-menu">OPERADORES<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>


                        <li class="tab"><a class="dropdown-trigger active" data-target="usuario-menu">USUÁRIOS<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>
    <?php
} else if($_SESSION['perfil'] == 2){
    ?>
    <header>

        <nav class="nav-extended ">
            <div class="container">
                <div class="nav-wrapper ">
                    <a href="#" class="brand-logo" id='logo'>Logo</a>
                    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="../controller/logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>

            <div class="container menu">

                <!-- MENU CONTRIBUINTES -->

                <ul id="contribuinte-menu" class="dropdown-content">
                    <li><a href='../cadastro/cadastroContr.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='listaContrib.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <!-- MENU DOACOES -->

                <ul id="doacoes-menu" class="dropdown-content">
                    <li><a href='doacoesAberto.php'>Em aberto</a></li>
                    <li><a href='doacoesCobranca.php'>Em cobrança</a></li>
                    <li><a href='doacoesQuitado.php'>Quitado/Indeferido</a></li>
                </ul>

                <div class="nav-content ">

                    <ul class="tabs tabs-transparent ">

                        <li class="tab"><a class="dropdown-trigger active"
                                data-target="contribuinte-menu">CONTRIBUINTES<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                        <li class="tab"><a class="dropdown-trigger active" data-target="doacoes-menu">DOAÇÕES<i
                                    class='material-icons right'>arrow_drop_down</i></a></li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>
    <?php
}
?>
    <main>
        <div class="row">
            <div class="col l2">
                <form action="#" method='post' class='center'>
                    <div class="input-field col l12">
                        <label for="data-inicio">Inicio:</label>
                        <input id="data-inicio" name="data-inicio" type="text" class="datepicker">
                    </div>
                    <div class="input-field col l12">
                        <label for="data-fim">Fim:</label>
                        <input id="data-fim" name="data-fim" type="text" class="datepicker">
                    </div>
                    <button class='btn  center' id='filtro-data'>Filtrar
                        <i class='material-icons right'>check</i>
                    </button>
                </form>
            </div>
            <div class="col l8">
                <div class="row">
                    <form action="#" id='buscaContr'>
                        <div class="input-field col l4">
                            <input id="doacao" type="text" class="validate" name='doacao'>
                            <label for="doacao">Busca</label>
                            <button class='btn ' id='buscar'>Buscar</button>
                        </div>
                        <div class="input-field col l4">
                            <select id='filtroStat'>

                                <?php
                                if($_SESSION['perfil'] == 1){
                                ?>
                                <optgroup label="Operador">
                                    <?php
                                        include '../config/conexao.php';
                                        $sql = "SELECT substring_index(substring_index(taboperador.nomeoperador, ' ', 3), ' ', -3)  AS nomeoperador, taboperador.idoperador FROM taboperador WHERE taboperador.idoperador != 0";
                                        $result=$connect->query($sql);
                                        while($res = $result->fetch_array()){
                                            ?>
                                    <option class='filtro' id='filtroOper' value='oper<?php echo $res['idoperador'] ?>'>
                                        <?php echo $res['nomeoperador'] ?></option>
                                    <?php
                                        }
                                        ?>
                                </optgroup>
                                <?php
                                }
                                ?>
                                <optgroup label='Mensageiro'>
                                    <?php
                                        include '../config/conexao.php';
                                        $sql = 'SELECT * FROM tabmensageiro WHERE idmensageiro != 0';
                                        $result=$connect->query($sql);
                                        while($res = $result->fetch_array()){
                                            ?>
                                    <option class='filtro' id='filtroMens'
                                        value='mens<?php echo $res['idmensageiro'] ?>'>
                                        <?php echo $res['nomemensageiro'] ?></option>
                                    <?php
                                        }
                                        ?>
                                </optgroup>

                                <option value="todos" selected>Todos</option>
                            </select>
                            <label>Filtrar por:</label>
                        </div>
                    </form>
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
                                <?php
                            if($_SESSION['perfil'] == 1){
                                ?>
                                <tr>
                                    <td colspan='3' class='recibo'>
                                        <p>
                                            <label>
                                                <input type='checkbox' id="check-todos" />
                                                <span>Selecionar todos</span>
                                            </label>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="col l2 recibo">
                                            <button class='btn ' id='gerar-recibo'>Imprimir</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class='recibo'>Recibo</th>
                                    <th>ID</th>
                                    <th>Cidade</th>
                                    <th>Bairro</th>
                                    <th>Contribuinte</th>
                                    <th>Valor</th>
                                    <th>Vencimento</th>
                                    <th>Mensageiro</th>
                                    <th>Status</th>
                                    <th>Operador</th>
                                    <th class="receber">Receber</th>
                                    <th class='editar'>Editar</th>
                                </tr>
                                <?php
                            } else if($_SESSION['perfil'] == 2){
                                ?>
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
                                    <th class='editar'>Editar</th>
                                </tr>
                                <?php
                            }
                            ?>

                            </thead>
                            <tbody id='corpo-lista'>
                                <?php

                                while($res2 = $result2->fetch_array()){
                                    ?>
                                <tr>
                                    <?php
                                        if($_SESSION['perfil'] == 1){
                                    ?>
                                    <td class='recibo'>
                                        <p>
                                            <label>
                                                <input class='checklist ger-recibo' type='checkbox'
                                                    id="recibo<?php echo $res2['iddoacao'] ?>" />
                                                <span></span>
                                            </label>
                                        </p>
                                    </td>
                                    <?php
                                        }
                                    ?>
                                    <td><?php echo $res2['iddoacao'] ?></td>
                                    <td><?php echo $res2['cidade'] ?></td>
                                    <td><?php echo $res2['bairro'] ?></td>
                                    <td><?php echo $res2['nomecontribuinte'] ?></td>
                                    <td><?php echo $res2['valor'] ?></td>
                                    <td><?php echo $res2['vencimento'] ?></td>
                                    <td><?php echo $res2['nomemensageiro'] ?></td>
                                    <td id='status<?php echo $res2['iddoacao'] ?>'><?php echo $res2['nomestatus'] ?>
                                    </td>
                                    <td><?php echo $res2['nomeoperador'] ?></td>
                                    <?php
                                    if($_SESSION['perfil'] == 1){
                                        ?>
                                    <td class='receber'><a href='#recebe<?php echo $res2['iddoacao'] ?>'
                                            class='modal-trigger'><i class='material-icons green-text'>save_alt</i></a>
                                    </td>
                                    <?php
                                    }
                                    ?>
                                    <td class='editar'><a href='#edita<?php echo $res2['iddoacao'] ?>'
                                            class='modal-trigger'><i class='material-icons purple-text'>create</i></a>
                                    </td>
                                </tr>

                                <?php
                                    if($_SESSION['perfil'] == 1){
                                ?>
                                <div class='modal' id='recebe<?php echo $res2['iddoacao'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Receber</h4>
                                        <div class='divider'></div>
                                        <div class='row'>
                                            <div class='col l6 left'>
                                                <p><strong>Ref: </strong><?php echo $res2['iddoacao'] ?></p>
                                                <p><strong>Contribuinte:
                                                    </strong><?php echo $res2['nomecontribuinte'] ?></p>
                                                <p><strong>Valor: </strong><?php echo $res2['valor'] ?></p>
                                                <p><strong>Vencimento: </strong><?php echo $res2['vencimento'] ?>
                                                </p>
                                            </div>
                                            <div class='col l6 left'>
                                                <p><strong>Endereco:
                                                    </strong><?php echo $res2['rua'].', '.$res2['numero'] ?></p>
                                                <p><strong>Bairro: </strong><?php echo $res2['bairro'] ?></p>
                                                <p><strong>Cidade: </strong><?php echo $res2['cidade'] ?></p>
                                                <div class='divider'></div>
                                                <p><strong>Operador: </strong><?php echo $res2['nomeoperador'] ?>
                                                </p>
                                                <p><strong>Mensageiro:
                                                    </strong><?php echo $res2['nomemensageiro'] ?></p>
                                            </div>
                                        </div>
                                        <div class='center'>
                                            <div class='btn  oi' type='submit' name='action'
                                                id='<?php echo $res2['iddoacao'] ?>'>Confirmar
                                                <i class='material-icons right'>check</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>

                                <div class='modal' id='edita<?php echo $res2['iddoacao'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Editar doação</h4>
                                        <div class='divider'></div>
                                        <form
                                            action="../controller/editaDoacao.php?iddoacao=<?php echo $res2['iddoacao'] ?>"
                                            method="post" id="form-edita<?php echo $res2['iddoacao'] ?>">
                                            <div class="input-field col l3">
                                                <input id="val<?php echo $res2['iddoacao'] ?>" type="text"
                                                    class="validate" name='val' value='<?php echo $res2['valor'] ?>'
                                                    required>
                                                <label for="val<?php echo $res2['iddoacao'] ?>">Valor</label>
                                            </div>
                                            <div class="input-field col l3">
                                                <input id="venc<?php echo $res2['iddoacao'] ?>" type="text"
                                                    class="validate" name='venc'
                                                    value='<?php echo $res2['vencimento'] ?>' required>
                                                <label for="venc<?php echo $res2['iddoacao'] ?>">Valor</label>
                                            </div>
                                            <div class="input-field col l6">
                                                <select id='statusdoacao<?php echo $res2['iddoacao'] ?>'>
                                                    <option value="<?php echo $res2['doacaostatus'] ?>" selected>
                                                        <?php echo $res2['nomestatus'] ?></option>
                                                    <?php

                                                            include_once '../config/conexao.php';

                                                            $sql = $connect->prepare("SELECT * FROM tabstatus ORDER BY nomestatus ASC");
                                                            $sql->execute();

                                                            $result = $sql->get_result();

                                                            while($row = $result->fetch_assoc()) {
                                                        ?>

                                                    <option value="<?php echo $row['idtabstatus'] ?>">
                                                        <?php echo $row['nomestatus'] ?></option>

                                                    <?php
                                                            }
                                                        ?>
                                                </select>
                                                <label>Status</label>
                                            </div>
                                            <div class='center'>
                                                <button class='btn  botao' data-id='<?php echo $res2['iddoacao'] ?>'
                                                    type='submit'>Confirmar
                                                    <i class='material-icons right'>check</i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                                }
                                if($result->num_rows >= 100){
                                ?>
                                <tr id='carregar'>
                                    <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar mais...</a>
                                    </td>
                                </tr>
                                <?php
                                }else{
                                    ?>
                                <tr>
                                    <td colspan='13'>Nenhum registro encontrado </td>
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
                <?php
            if($_SESSION['perfil'] == 1){
                ?>
                <a class="btn  card" href="#" id='gera-recib' style='width: 90%;'>Gerar recibo</a>
                <a class="btn  card" href="#" id='receb-doac' style='width: 90%;'>Receber</a>
                <?php
            }
            ?>
                <a class="btn  card" href="#" id='edita-doac' style='width: 90%;'>Editar</a>
            </div>
        </div>

        <div class="fixed-action-btn" id='top'>
            <a class="btn-floating btn-large">
                <i class="large material-icons">keyboard_arrow_up</i>
            </a>
        </div>
    </main>

    <!--JavaScript at end of body for optimized loading-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            i18n: {
                months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                    'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ],
                monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out',
                    'Nov', 'Dez'
                ],
                weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
                weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                today: 'Hoje',
                clear: 'Limpar',
                cancel: 'Sair',
                done: 'Confirmar',
                labelMonthNext: 'Próximo mês',
                labelMonthPrev: 'Mês anterior',
                labelMonthSelect: 'Selecione um mês',
                labelYearSelect: 'Selecione um ano',
                selectMonths: true,
                selectYears: 15,
            },
            format: 'dd/mm/yyyy',
            container: 'body',
        });

        $('#filtroStat').change(function() {
            var stat = $('#filtroStat').val();

            if (stat.includes('oper')) {
                var id = stat.replace('oper', '');

                $.ajax({

                    url: '../controller/filtroOperador.php?id=' + id + '&stts=2',
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {

                        $('#lista-doacoes').empty().html(data);
                        $('.atribui').hide();
                        $('#loader').css('display', 'none');
                        $('#list').css('display', '');
                        $('#data-inicio').val('');
                        $('#data-fim').val('');
                        $('#doacao').val('');
                    }
                });
            } else if (stat.includes('mens')) {
                var id = stat.replace('mens', '');

                $.ajax({

                    url: '../controller/filtroMensageiro.php?id=' + id + '&stts=2',
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {

                        $('#lista-doacoes').empty().html(data);
                        $('.atribui').hide();
                        $('#loader').css('display', 'none');
                        $('#list').css('display', '');
                        $('#data-inicio').val('');
                        $('#data-fim').val('');
                        $('#doacao').val('');
                    }
                });
            } else if (stat = 'todos') {
                $.ajax({

                    url: '../controller/todosCobranca.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {

                        $('#lista-doacoes').empty().html(data);
                        $('.atribui').hide();
                        $('#loader').css('display', 'none');
                        $('#list').css('display', '');
                        $('#data-inicio').val('');
                        $('#data-fim').val('');
                        $('#doacao').val('');
                    }
                });
            }



            return false;
        });


        $('.oi').click(function() {
            var id = $(this).attr('id');

            $.ajax({

                url: '../controller/confirmaBaixa.php?id=' + id,
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    alert('Baixa confirmada!');
                    $('#status' + id).text('Quitado');
                    $('#recebe' + id).close();
                }
            });

            return false;
        });

        $('#filtro-data').click(function() {
            var dtin = $('#data-inicio').val();
            var dtfim = $('#data-fim').val();

            $.ajax({

                url: '../controller/filtroDoacoesData.php?data-inicio=' + dtin + '&data-fim=' +
                    dtfim + '&stts=2',
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $('#lista-doacoes').empty().html(data);
                    $('#carregar').remove();
                    $("#filtroStat").val('todos');
                    $('#doacao').val('');

                }
            });

            return false;
        });

        $("#check-todos").click(function(e) {
            var marcar = e.target.checked;

            if ($('#check-todos').is(':checked')) {
                $('.checklist').each(function() {
                    $(this).attr('checked', 'checked');
                });
            } else {
                $('.checklist').each(function() {
                    $(this).removeAttr('checked');
                });
            }


        });


    });
    $(document).ready(function() {
        $('.dropdown-trigger').dropdown({
            container: document.body
        });

        $('select').formSelect();

        $(".editar").hide();

        $('#edita-doac').click(function() {
            $('.editar').toggle();
        });

        $('.recibo').hide();

        $('.atribui').hide();

        $('.receber').hide();

        $('.modal').modal();

        $('#top').click(function() {
            //scroll suave
            $('html, body').animate({
                scrollTop: 0
            }, 'medium'); //slow, medium, fast
        })

        $('#buscar').click(function() {
            $('#loader').css('display', '');
            $('#list').css('display', 'none');
        });

        $('#novo-mens').click(function() {
            $('#mens-conteudo').load('cadastroMens.php');
        });

        $('#receb-doac').click(function() {
            $('.receber').toggle();
        });

        $('#atrib-mens').click(function() {
            $('.atribui').toggle();
        });

        $('#gera-recib').click(function() {
            $('.recibo').toggle();
        });

        $('#atribuir-mens').click(function() {
            var mens = $('#mensageiro').val();
            var url = '../controller/atribuiMens.php?mens=' + mens;

            $('.checklist:checked').each(function() {
                url += '&id=' + $(this).attr('id');
            });

            if (mens == null) {
                alert('Selecione um mensageiro!');
            } else {
                window.location.href = url;
            }
        });

        $('#gerar-recibo').click(function() {
            var url = '../geraPDF.php?';
            $('.checklist:checked.ger-recibo').each(function() {
                url += '&id=' + $(this).attr('id').replace('recibo', '');
            });

            window.location.href = url;
        });



        $(".botao").click(function() {
            var id = $(this).attr('data-id');
            var stat = $("#statusdoacao" + id).val();
            var action = $("#form-edita" + id).attr('action') + '&stat=' + stat;
            $("#form-edita" + id).attr('action', action);


        });


    });

    function confirmaBaixa(id) {
        window.location.href = 'controller/confirmaBaixa.php?id=' + id;
    }

    function carregado() {
        $('#loader').css('display', 'none');
        $('#list').css('display', '');
    }



    function carrega() {
        var inicio = $("tbody tr").length - 1;

        $.ajax({

            url: '../controller/carregaDoacoesCobranca.php',
            type: 'POST',
            dataType: 'html',
            data: {
                inicio: inicio
            },
            success: function(data) {
                $('#list').append(data);
                $('#carregar').remove();
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