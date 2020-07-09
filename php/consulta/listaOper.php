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
    <title>ONG - Operadores</title>

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
</head>

<body>
    <header>

        <nav class="nav-extended ">
            <div class="container">
                <div class="nav-wrapper ">
                    <a href="#" class="brand-logo" id='logo'><img src="../../img/ceuAzulLogo.png" style='width: 13%;'
                            id='nav-logo'></a>
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

    <main>
        <div class="row">
            <div class="col l2"></div>
            <div class="col l8">
                <div class="row">
                    <div>
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

                        include '../config/conexao.php';

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
                                    <td class='exclui' onclick="confirmaExclu(<?php echo $res['idoperador'] ?>)"><a><i
                                                class='material-icons red-text'>clear</i></a></td>
                                    <td class='altera'><a href='#altera<?php echo $res['idoperador'] ?>'
                                            class='modal-trigger'><i class='material-icons purple-text'>create</i></a>
                                    </td>
                                </tr>

                                <div class='modal' id='altera<?php echo $res['idoperador'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Alterar dados</h4>
                                        <div class='center' id='conteudo<?php echo $res['idoperador'] ?>'>
                                            <form class='col l12 center'
                                                action='../controller/atualOper.php?id=<?php echo $res['idoperador'] ?>'
                                                method='post'>
                                                <div class='row'>
                                                    <div class='input-field col l6'>
                                                        <input id='nome<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='nome'
                                                            value='<?php echo $res['nomeoperador'] ?>' required>
                                                        <label class='active'
                                                            for='nome<?php echo $res['idoperador'] ?>'>Nome
                                                            completo</label>
                                                    </div>
                                                    <div class='input-field col l6'>
                                                        <input id='email<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='email'
                                                            value='<?php echo $res['emailoperador'] ?>' required>
                                                        <label class='active'
                                                            for='email<?php echo $res['idoperador'] ?>'>Email</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='tel<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='tel'
                                                            value='<?php echo $res['telefone'] ?>' required>
                                                        <label class='active'
                                                            for='tel<?php echo $res['idoperador'] ?>'>Telefone</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='cep<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='cep'
                                                            value='<?php echo $res['cep'] ?>'>
                                                        <label class='active'
                                                            for='cep<?php echo $res['idoperador'] ?>'>CEP</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='rua<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='rua'
                                                            value='<?php echo $res['rua'] ?>' required>
                                                        <label class='active'
                                                            for='rua<?php echo $res['idoperador'] ?>'>Rua</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='num<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='num'
                                                            value='<?php echo $res['numero'] ?>' required>
                                                        <label class='active'
                                                            for='num<?php echo $res['idoperador'] ?>'>Número</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='bairro<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='bairro'
                                                            value='<?php echo $res['bairro'] ?>' required>
                                                        <label class='active'
                                                            for='bairro<?php echo $res['idoperador'] ?>'>Bairro</label>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='cidade<?php echo $res['idoperador'] ?>' type='text'
                                                            class='validate' name='cidade'
                                                            value='<?php echo $res['cidade'] ?>' required>
                                                        <label class='active'
                                                            for='cidade<?php echo $res['idoperador'] ?>'>Cidade</label>
                                                    </div>
                                                </div>
                                                <button class='btn  botao' type='submit' name='action'
                                                    id='<?php echo $res['idoperador'] ?>'>Salvar
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
                </div>

                <div class="modal" id="modal-oper">
                    <div class="modal-content">
                        <div class="row right"><i class="material-icons modal-close">close</i></div>
                        <h4>Novo operador</h4>
                        <div id="oper-conteudo">
                            <form class="col l12 center" action="../controller/insereOper.php" method='POST'>
                                <div class="row">
                                    <div class="input-field col l6">
                                        <input id="nome" type="text" class="validate" name='nomeC' required>
                                        <label for="nome">Nome completo</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="rg" type="text" class="validate" name='rgC' required>
                                        <label for="rg">RG</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="cpf" type="text" class="validate" name='cpfC' required>
                                        <label for="cpf">CPF</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col l3">
                                        <input id="tel" type="text" class="validate" name='telC' required>
                                        <label for="tel">Telefone</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="cep" type="text" class="validate" name='cepC'>
                                        <label for="cep">CEP</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="rua" type="text" class="validate" name='ruaC' required>
                                        <label for="rua">Rua</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="num" type="text" class="validate" name='numC' required>
                                        <label for="num">Número</label>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="input-field col l3">
                                        <input id="bairro" type="text" class="validate" name='bairroC' required>
                                        <label for="bairro">Bairro</label>
                                    </div>
                                    <div class="input-field col l3">
                                        <input id="cidade" type="text" class="validate" name='cidadeC' required>
                                        <label for="cidade">Cidade</label>
                                    </div>
                                    <div class="input-field col l6">
                                        <input id="email" type="email" class="validate" name='emailC' required>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <button class="btn waves-effect waves-light " type="submit"
                                    name="action">Cadastrar
                                    <i class="material-icons right">check</i>
                                </button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col l2">
                <a class="btn modal-trigger right  card" href="#modal-oper" id='novo-oper'
                    style='width:100%;'>Novo</a>
                <a class="btn right  card" id='alter-oper' style='width:100%;'>Alterar</a>
                <a class="btn right  card" id='excl-oper' style='width:100%;'>Excluir</a>
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
    <script type="text/javascript" src="../../js/listaoper.js"></script>
    <script src="../../js/cadastro.js"></script>
</body>

</html>
<?php
    }
?>