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
    <title>ONG - Mensageiros</title>

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

<body>
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

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <main>
        <div class="row">
            <div class="col l2"></div>
            <div class="col l8">
                <div class="row">
                    <div>
                        <table class="centered responsive-table card" style='max-height: 10px;'>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Veículo</th>
                                    <th>Placa</th>
                                    <th class='altera'>Alterar</th>
                                    <th class='exclui'>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                    include '../config/conexao.php';

                    $sql="SELECT tabmensageiro.idmensageiro, tabmensageiro.nomemensageiro, tabmensageiro.fonemensageiro, tabmensageiro.veiculo, tabmensageiro.placa, tabmensageiro.rgmensageiro, 
                    tabmensageiro.cpfmensageiro, tabendereco.cep, tabendereco.bairro, tabendereco.rua, tabendereco.cidade, tabendereco.referencia, 
                    tabendereco.obs, tabendereco.numero
                        FROM tabmensageiro
                    INNER JOIN tabendereco ON tabendereco.idmensageiroendereco = tabmensageiro.idmensageiro";
                    $result=$connect->query($sql);
                    while($res= $result->fetch_array()){
                        switch($res['veiculo']){
                            case 1:
                                $veiculo= 'Carro';
                            break;
                            case 2:
                                $veiculo = 'Moto';
                            break;
                            case 3:
                                $veiculo = 'Outro';
                            break;
                        }
                        ?>
                                <tr>
                                    <td><?php echo $res['nomemensageiro']?></td>
                                    <td><?php echo $res['fonemensageiro']?></td>
                                    <td><?php echo $veiculo ?></td>
                                    <td><?php echo $res['placa']?></td>
                                    <td class='exclui' onclick="confirmaExclu(<?php echo $res['idmensageiro'] ?>)">
                                        <a><i class='material-icons red-text'>clear</i></a></td>
                                    <td class='altera'><a href='#alterModal<?php echo $res['idmensageiro'] ?>'
                                            class='modal-trigger'><i class='material-icons purple-text'>create</i></a>
                                    </td>
                                </tr>

                                <div class='modal fade' id='alterModal<?php echo $res['idmensageiro'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Alterar registros</h4>
                                        <div class='divider'></div>
                                        <form method='post'
                                            action='../controller/atualMens.php?id=<?php echo $res['idmensageiro'] ?>'
                                            id='atualiza<?php echo $res['idmensageiro'] ?>'>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='nome<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate' name='nome'
                                                        value='<?php echo $res['nomemensageiro'] ?>' required>
                                                    <label class='active'
                                                        for='nome<?php echo $res['idmensageiro'] ?>'>Nome
                                                        completo</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='tel<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate tel' name='tel'
                                                        value='<?php echo $res['fonemensageiro'] ?>' required>
                                                    <label class='active' for='tel'>Telefone</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cep<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate cep' name='cep'
                                                        value='<?php echo $res['cep'] ?>'
                                                        data-id='<?php echo $res['idmensageiro'] ?>'>
                                                    <label class='active'
                                                        for='cep<?php echo $res['idmensageiro'] ?>'>CEP</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='input-field col l3'>
                                                    <input id='rua<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate rua' name='rua'
                                                        value='<?php echo $res['rua'] ?>' required>
                                                    <label class='active'
                                                        for='rua<?php echo $res['idmensageiro'] ?>'>Rua</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='num<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate' name='num' value='<?php echo $res['numero'] ?>'
                                                        required>
                                                    <label class='active'
                                                        for='num<?php echo $res['idmensageiro'] ?>'>Número</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='bairro<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate bairro' name='bairro'
                                                        value='<?php echo $res['bairro'] ?>' required>
                                                    <label class='active'
                                                        for='bairro<?php echo $res['idmensageiro'] ?>'>Bairro</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='cidade<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate cidade' name='cidade'
                                                        value='<?php echo $res['cidade'] ?>' required>
                                                    <label class='active'
                                                        for='cidade<?php echo $res['idmensageiro'] ?>'>Cidade</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='input-field col l6'>
                                                    <input id='ref<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate' name='ref'
                                                        value='<?php echo $res['referencia'] ?>'>
                                                    <label class='active'
                                                        for='ref<?php echo $res['idmensageiro'] ?>'>Ponto de
                                                        referência</label>
                                                </div>
                                                <div class='input-field col l3'>
                                                    <input id='obs<?php echo $res['idmensageiro'] ?>' type='text'
                                                        class='validate' name='obs' value='<?php echo $res['obs'] ?>'>
                                                    <label class='active'
                                                        for='obs<?php echo $res['idmensageiro'] ?>'>Observações</label>
                                                </div>
                                                <div class="input-field col l3">
                                                    <select name='veiculo'>
                                                        <option value="<?php echo $res['veiculo'] ?>" selected>Tipo de
                                                            veículo</option>
                                                        <option value="1">Carro</option>
                                                        <option value="2">Moto</option>
                                                        <option value="3">Outro</option>
                                                    </select>
                                                    <label>Veículo</label>
                                                </div>
                                            </div>
                                            <div class="row center">
                                                <button class='btn ' type='submit' name='action'
                                                    id='<?php echo $res['idmensageiro'] ?>'>Atualizar
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
            <div class="col l2">
                <a class="btn right  card" id='alter-mens' style='width:100%;'>Alterar</a>
                <a class="btn right  card" id='excl-mens' style='width:100%;'>Excluir</a>
            </div>
        </div>
    </main>

    <!--JavaScript at end of body for optimized loading-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/listamens.js"></script>
    <script>
    $(document).ready(function() {
        $('select').formSelect();
    });
    </script>
</body>

</html>
<?php
    }
?>