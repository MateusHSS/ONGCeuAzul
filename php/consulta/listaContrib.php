<?php
    session_start();
    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2){
        header('location:../index.php');
    }else{
        
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG - Contribuintes</title>

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


    <!-- Compiled and minified JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
    $(document).ready(function() {
        //BUSCA DE DOADORES PELO NOME
        $('#buscar').click(function() {

            $('#buscaContr').submit(function() {

                var dados = $(this).serialize();

                $.ajax({

                    url: '../controller/buscaContr.php',
                    type: 'POST',
                    dataType: 'html',
                    data: dados,
                    success: function(data) {

                        $('#lista-contribuintes').empty().html(data);
                        $('.nova-doacao').hide();
                        $('.exclui').hide();
                        $('.altera').hide();
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

                    <ul class="tabs tabs-transparent ">

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

                        <li class="tab"><a class="dropdown-trigger active" data-target="#">RELATÓRIOS<i
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
            <div class="col l2"></div>
            <div class="col l8">
                <div class="row">
                    <form action="#" id='buscaContr'>
                        <div class="input-field col l6">
                            <input id="contribuinte" type="text" class="validate" name='contribuinte'>
                            <label for="contribuinte">Busca</label>
                            <button class='btn ' id='buscar'>Buscar</button>
                        </div>
                        <div class="input-field col l4">
                            <select id='filtroCat'>
                                <?php
                                if($_SESSION['perfil'] == 1){
                                ?>
                                    <?php
                                        include '../config/conexao.php';
                                        $sql = "SELECT * FROM tabcategoriacontribuinte ORDER BY quantidadecategoria";
                                        $result=$connect->query($sql);
                                        while($res = $result->fetch_array()){
                                            ?>
                                    <option class='filtro' value='cat<?php echo $res['idtabcategoriacontribuinte'] ?>'><?php echo $res['descricaocategoria'] ?></option>
                                    <?php
                                        }
                                        ?>
                                <?php
                                }
                                ?>
                                <option class='filtro' value="todos" selected>Todos</option>
                            </select>
                            <label>Filtrar por:</label>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="center" id='lista-contribuintes'>
                        <div id="loader">
                            <div class="progress">
                                <div class="indeterminate" style="width: 70%"></div>
                            </div>
                            <span>Carregando registros...</span>
                        </div>
                        <table class="centered responsive-table card center" id='list' style='display:none;'>
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

                include '../config/conexao.php';

                if($_SESSION['perfil'] == 1){
                    $sql="SELECT tabcontribuinte.idcontribuinte, tabcontribuinte.nomecontribuinte, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabendereco.referencia, tabendereco.obs, tabendereco.cep, tabcontato.telefone, DATE_FORMAT(tabcontribuinte.datacadastrocontribuinte, '%e/%m/%Y') AS datacad, taboperador.nomeoperador
                        FROM tabcontribuinte 
                    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                    INNER JOIN tabcontato ON tabcontato.idcontribuintecontato = tabcontribuinte.idcontribuinte
                    INNER JOIN taboperador ON taboperador.idoperador = tabcontribuinte.idopercontribuinte
                    ORDER BY  tabcontribuinte.datacadastrocontribuinte DESC LIMIT 100";
                }else if($_SESSION['perfil'] == 2){
                    $idoper = $_SESSION['idoperador'];

                    $sql="SELECT tabcontribuinte.idcontribuinte, tabcontribuinte.nomecontribuinte, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabendereco.referencia, tabendereco.obs, tabendereco.cep, tabcontato.telefone, DATE_FORMAT(tabcontribuinte.datacadastrocontribuinte, '%e/%m/%Y') AS datacad, taboperador.nomeoperador
                        FROM tabcontribuinte 
                    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                    INNER JOIN tabcontato ON tabcontato.idcontribuintecontato = tabcontribuinte.idcontribuinte
                    INNER JOIN taboperador ON taboperador.idoperador = tabcontribuinte.idopercontribuinte
                    WHERE taboperador.idoperador = $idoper
                    ORDER BY  tabcontribuinte.datacadastrocontribuinte DESC LIMIT 100";
                }

                
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
                                    <td class='exclui' onclick="confirmaExclu(<?php echo $res['idcontribuinte'] ?>)">
                                        <a><i class='material-icons red-text'>clear</i></a></td>
                                    <td class='altera'><a href='#alterModal<?php echo $res['idcontribuinte'] ?>'
                                            class='modal-trigger'><i class='material-icons purple-text'>create</i></a>
                                    </td>
                                </tr>

                                <div class='modal fade' id='alterModal<?php echo $res['idcontribuinte'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Alterar registros</h4>
                                        <div class='divider'></div>
                                        <form method='post'
                                            action='../controller/atualContr.php?id=<?php echo $res['idcontribuinte'] ?>'
                                            id='atualiza<?php echo $res['idcontribuinte'] ?>'>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='nome<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate' name='nome'
                                                        value='<?php echo $res['nomecontribuinte'] ?>' required>
                                                    <label class='active'
                                                        for='nome<?php echo $res['idcontribuinte'] ?>'>Nome
                                                        completo</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='tel<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate tel' name='tel'
                                                        value='<?php echo $res['telefone'] ?>' required>
                                                    <label class='active' for='tel'>Telefone</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cep<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate cep' name='cep'
                                                        value='<?php echo $res['cep'] ?>'
                                                        data-id='<?php echo $res['idcontribuinte'] ?>'>
                                                    <label class='active'
                                                        for='cep<?php echo $res['idcontribuinte'] ?>'>CEP</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='input-field col l3'>
                                                    <input id='rua<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate rua' name='rua'
                                                        value='<?php echo $res['rua'] ?>' required>
                                                    <label class='active'
                                                        for='rua<?php echo $res['idcontribuinte'] ?>'>Rua</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='num<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate' name='num' value='<?php echo $res['numero'] ?>'
                                                        required>
                                                    <label class='active'
                                                        for='num<?php echo $res['idcontribuinte'] ?>'>Número</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='bairro<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate bairro' name='bairro'
                                                        value='<?php echo $res['bairro'] ?>' required>
                                                    <label class='active'
                                                        for='bairro<?php echo $res['idcontribuinte'] ?>'>Bairro</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cidade<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate cidade' name='cidade'
                                                        value='<?php echo $res['cidade'] ?>' required>
                                                    <label class='active'
                                                        for='cidade<?php echo $res['idcontribuinte'] ?>'>Cidade</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='ref<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate' name='ref'
                                                        value='<?php echo $res['referencia'] ?>'>
                                                    <label class='active'
                                                        for='ref<?php echo $res['idcontribuinte'] ?>'>Ponto de
                                                        referência</label>
                                                </div>
                                                <div class='input-field col l6'>
                                                    <input id='obs<?php echo $res['idcontribuinte'] ?>' type='text'
                                                        class='validate' name='obs' value='<?php echo $res['obs'] ?>'>
                                                    <label class='active'
                                                        for='obs<?php echo $res['idcontribuinte'] ?>'>Observações</label>
                                                </div>
                                            </div>
                                            <div class="row center">
                                                <button class='btn ' type='submit' name='action'
                                                    id='<?php echo $res['idcontribuinte'] ?>'>Atualizar
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
                                            action='../controller/novaDoacao.php?idcontribuinte=<?php echo $res['idcontribuinte'] ?>'
                                            id='gera-doacao<?php echo $res['idcontribuinte'] ?>'>
                                            <div class="row">
                                                <div class="input-field col l3">
                                                    <input id="val<?php echo $res['idcontribuinte'] ?>" type="text"
                                                        class="validate val" name='val'>
                                                    <label for="val<?php echo $res['idcontribuinte'] ?>">Valor</label>
                                                </div>
                                                <div class="input-field col l3">
                                                    <input placeholder='mm/aa'
                                                        id="venc<?php echo $res['idcontribuinte'] ?>" type="text"
                                                        class="validate venc" name='venc'>
                                                    <label
                                                        for="venc<?php echo $res['idcontribuinte'] ?>">Vencimento</label>
                                                </div>
                                                <div class="input-field col l6">
                                                    <select name='tipo-contribuinte' id='tipo-contr<?php echo $res['idcontribuinte'] ?>'><option value="" disabled selected>Tipo</option>
                                                        <?php
                                                        include 'config/conexao.php';
                                                        $sqlCat = "SELECT * FROM tabcategoriacontribuinte ORDER BY quantidadecategoria";
                                                        $resultCat = $connect->query($sqlCat);
                                                        while($resCat = $resultCat->fetch_array()){
                                                            ?>
                                                        <option value='<?php echo $resCat['idtabcategoriacontribuinte'] ?>'><?php echo $resCat['descricaocategoria'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <label>Tipo</label>
                                                </div>
                                            </div>
                                            <div class="row center">
                                                <button class='btn  botao' type='submit' name='action'
                                                    id='new-doacao<?php echo $res['idcontribuinte'] ?>'>Atualizar
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
                                    <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar
                                            mais...</a></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="modal" id="modal-contr">
                    <div class="modal-content">
                        <div class="row right"><i class="material-icons modal-close">close</i></div>
                        <h4>Novo contribuinte</h4>
                        <div id="contr-conteudo">
                            <form class="col l12 center" action="../controller/insereContr.php" method='POST'>
                                <div class="row">
                                    <div class="input-field col l6">
                                        <input id="nome" type="text" class="validate" name='nome' required>
                                        <label for="nome">Nome completo</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="tel" type="text" class="validate tel" name='telContr' required>
                                        <label for="tel">Telefone</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="cep" type="text" class="validate cep" data-id='0' name='cepContr'>
                                        <label for="cep">CEP</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col l3">
                                        <input id="rua0" type="text" class="validate" name='ruaContr' required>
                                        <label for="rua0">Rua</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="num0" type="text" class="validate" name='numContr' required>
                                        <label for="num0">Número</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="bairro0" type="text" class="validate" name='bairroContr' required>
                                        <label for="bairro0">Bairro</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="cidade0" type="text" class="validate" name='cidadeContr' required>
                                        <label for="cidade0">Cidade</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col l6">
                                        <input id="ref" type="text" class="validate" name='ref'>
                                        <label for="ref">Ponto de referência</label>
                                    </div>
                                    <div class="input-field col l6">
                                        <input id="obs" type="text" class="validate" name='obs' data-length="40"
                                            maxlength='40'>
                                        <label for="obs">Observações</label>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="row">
                                    <h5>Contribuição</h5>
                                </div>
                                <div class="row">
                                    <div class="input-field col l3">
                                        <input id="val" type="text" class="validate val" name='val'>
                                        <label for="val">Valor</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input placeholder='dd/mm' id="venc" type="text" class="validate venc"
                                            name='venc'>
                                        <label for="venc">Vencimento</label>
                                    </div>
                                    <div class="input-field col l6">
                                        <select name='tipo-contribuinte' id='perfil-user'>
                                            <option value="" disabled selected>Tipo</option>
                                            <?php
                                                include 'config/conexao.php';
                                                $sql = "SELECT * FROM tabcategoriacontribuinte";
                                                $result=$connect->query($sql);
                                                while($res = $result->fetch_array()){
                                                    ?>
                                            <option value='<?php echo $res['idtabcategoriacontribuinte'] ?>'><?php echo $res['descricaocategoria'] ?></option>
                                            <?php
                        }
                        ?>
                                        </select>
                                        <label>Tipo</label>
                                    </div>
                                </div>
                                <button class="btn " type="submit" name="action">Cadastrar
                                    <i class="material-icons right">check</i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l2">
                <a class="btn modal-trigger right  card" href="#modal-contr" id='novo-contr'
                    style='width:100%;'>Novo</a>
                <a class="btn right  card" id='alter-contr' style='width:100%;'>Alterar</a>
                <a class="btn right  card" id='excl-contr' style='width:100%;'>Excluir</a>
                <a class="btn right  card" id='nova-doacao' style='width:100%;'>Gerar doação</a>
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
    function limpa_formulario_cep() {
        // Limpa valores do formulário de cep.
        $(".rua").val("");
        $(".bairro").val("");
        $(".cidade").val("");
    }

    //Quando o campo cep perde o foco.
    $(".cep").blur(function() {
        var id = $(this).attr('data-id');

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua" + id).val("...");
                $("#bairro" + id).val("...");
                $("#cidade" + id).val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua" + id).select();
                        $("#rua" + id).val(dados.logradouro);
                        $("#bairro" + id).select();
                        $("#bairro" + id).val(dados.bairro);
                        $("#cidade" + id).select();
                        $("#cidade" + id).val(dados.localidade);
                        $("#num" + id).select();
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulario_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulario_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    });

    $(document).ready(function() {
        $('select').formSelect();

        $('.val').mask('#.##0,00', {
            reverse: true
        });

        $('.venc').mask('00/00');

        $('.cep').mask("00000-000");

        $('.tel').mask('(00)00000-0000');
        $('.tel').blur(function(event) {
            if ($(this).val().length == 14) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                $('.tel').mask('(00)00000-0000');
            } else {
                $('.tel').mask('(00)0000-0000');
            }
        });

        $('.botao').click(function() {
            var id = $(this).attr('id').replace("new-doacao", '');
            var categoria = $('#tipo-contr' + id).val();
            alert(id);
            var action = $("#gera-doacao" + id).attr('action');

            action += '&tipo-contribuinte=' + categoria;

            $("#gera-doacao" + id).attr('action', action);


        });

        $('#top').click(function() {
            //scroll suave
            $('html, body').animate({
                scrollTop: 0
            }, 'medium'); //slow, medium, fast
        });

        $('.nova-doacao').hide();

        $('.exclui').hide();

        $('.altera').hide();

        $('.modal').modal();

        $('#novo-contr').click(function() {
            $('#contr-conteudo').load('cadastro/cadastroContr.php');
        });

        $('#nova-doacao').click(function() {
            $('.nova-doacao').toggle();
        });

        $('#excl-contr').click(function() {
            $('.exclui').toggle();
        });

        $('#alter-contr').click(function() {
            $('.altera').toggle();
        });

        $('.dropdown-trigger').dropdown({
            container: document.body
        });

        $('#filtroCat').change(function() {
            var stat = $('#filtroCat').val();

            if (stat.includes('cat')) {
                var id = stat.replace('cat', '');

                $.ajax({
                    <?php
                    if($_SESSION['perfil'] == 1){
                        ?>
                    url: '../controller/filtroCategoria.php?id=' + id,
                        <?php
                    }else if($_SESSION['perfil'] == 2){
                        ?>
                    url: '../controller/filtroCategoria.php?id=' + id + '&oper='+<?php echo $_SESSION['idoperador'] ?>,
                        <?php
                    }
                    ?>
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {

                        $('#lista-contribuintes').empty().html(data);
                        $('#loader').css('display', 'none');
                        $('#list').css('display', '');
                        $('.nova-doacao').hide();
                        $('.exclui').hide();
                        $('.altera').hide();
                    }
                });
            } else if (stat == 'todos') {
                $.ajax({

                    url: '../controller/todosContr.php',
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {

                        $('#lista-doacoes').empty().html(data);
                        $('.nova-doacao').hide();
                        $('.exclui').hide();
                        $('.altera').hide();
                    }
                });
            }



            return false;
        });
    });

    function dale(id) {
        $('#form' + id).submit();
    }

    function confirmaExclu(id) {
        var apagar = confirm('Deseja realmente excluir este registro?');
        if (apagar) {
            window.location.href = "../controller/excluiContr.php?id=" + id;
        } else {
            event.preventDefault();
        }
    }

    function carregado() {
        $('#loader').css('display', 'none');
        $('#list').css('display', '');
    }

    function carrega() {
        var inicio = $("tbody tr").length - 1;

        $.ajax({

            url: '../controller/carregaContrib.php',
            type: 'POST',
            dataType: 'html',
            data: {
                inicio: inicio
            },
            success: function(data) {
                $('#list').append(data);
                $("#carregar").remove();
                $('.nova-doacao').hide();
                $('.exclui').hide();
                $('.altera').hide();

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