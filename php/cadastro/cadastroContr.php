<?php
    session_start();
    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2){
        header('location:../index.php');
    }else{
        include_once '../config/conexao.php';
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG - Cadastro contribuinte</title>

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

    <!-- <link rel="stylesheet" href="../../css/home.css"> -->

    <!-- Compiled and minified JavaScript -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>

<body>
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
                    <li><a href='cadastroContr.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='../consulta/listaContrib.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <!-- MENU DOACOES -->

                <ul id="doacoes-menu" class="dropdown-content">
                    <li><a href='../consulta/doacoesAberto.php'>Em aberto</a></li>
                    <li><a href='../consulta/doacoesCobranca.php'>Em cobrança</a></li>
                    <li><a href='../consulta/doacoesQuitado.php'>Quitado/Indeferido</a></li>
                    <li><a href='#'><i class="material-icons">description</i>Totais</a></li>
                </ul>

                <!-- MENU MENSAGEIROS -->

                <ul id="mensageiro-menu" class="dropdown-content">
                    <li><a href='cadastroMens.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='../consulta/listaMens.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <!-- MENU OPERADORES -->

                <ul id="operador-menu" class="dropdown-content">
                    <li><a href='cadastroOper.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='../consulta/listaOper.php'><i class="material-icons">list</i>Listagem</a></li>
                    <li><a href='../relatorios/comissao.php'><i class="material-icons">description</i>Comissão</a></li>
                </ul>

                <!-- MENU USUÁRIO -->

                <ul id="usuario-menu" class="dropdown-content">
                    <li><a href='cadastroUser.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='../consulta/listaUser.php'><i class="material-icons">list</i>Listagem</a></li>
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
                    <li><a href='cadastroContr.php'><i class="material-icons">add</i>Novo</a></li>
                    <li><a href='../consulta/listaContrib.php'><i class="material-icons">list</i>Listagem</a></li>
                </ul>

                <!-- MENU DOACOES -->

                <ul id="doacoes-menu" class="dropdown-content">
                    <li><a href='../consulta/doacoesAberto.php'>Em aberto</a></li>
                    <li><a href='../consulta/doacoesCobranca.php'>Em cobrança</a></li>
                    <li><a href='../consulta/doacoesQuitado.php'>Quitado/Indeferido</a></li>
                </ul>

                <div class="nav-content ">

                    <ul class="tabs tabs-transparent">

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
                <form class="col l12 center" action="../controller/insereContr.php" method='POST'>
                    <div class="row">
                        <div class="input-field col l6">
                            <input id="nome" type="text" class="validate" name='nome' required>
                            <label for="nome">Nome completo</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="tel" type="text" class="validate" name='telContr' required>
                            <label for="tel">Telefone</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="cep" type="text" class="validate cep" name='cepContr'>
                            <label for="cep">CEP</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l3">
                            <input id="rua" type="text" class="validate" name='ruaContr' required>
                            <label for="rua">Rua</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="num" type="text" class="validate" name='numContr' required>
                            <label for="num">Número</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="bairro" type="text" class="validate" name='bairroContr' required>
                            <label for="bairro">Bairro</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="cidade" type="text" class="validate" name='cidadeContr' required>
                            <label for="cidade">Cidade</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col l6">
                            <input id="ref" type="text" class="validate" name='ref'>
                            <label for="ref">Ponto de referência</label>
                        </div>
                        <div class="input-field col l6">
                            <input id="obs" type="text" class="validate" name='obs' data-length="40" maxlength='40'>
                            <label for="obs">Observações</label>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <h5>Contribuição</h5>
                    </div>
                    <div class="row">
                        <div class="input-field col l3">
                            <input id="val" type="text" class="validate" name='val'>
                            <label for="val">Valor</label>
                        </div>
                        <div class="input-field col l3">
                            <input placeholder='dd/mm' id="venc" type="text" class="validate" name='venc'>
                            <label for="venc">Vencimento</label>
                        </div>
                        <div class="input-field col l6">
                            <select name='tipo-contribuinte' id='perfil-user'>
                                <option value="" disabled selected>Tipo</option>
                                <?php
                            include 'config/conexao.php';
                            $sql = "SELECT * FROM tabcategoriacontribuinte ORDER BY quantidadecategoria";
                            $result=$connect->query($sql);
                            while($res = $result->fetch_array()){
                                ?>
                                <option value='<?php echo $res['idtabcategoriacontribuinte'] ?>'>
                                    <?php echo $res['descricaocategoria'] ?></option>
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
            <div class="col l2"></div>
        </div>
    </main>

    <!--JavaScript at end of body for optimized loading-->

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script type="text/javascript" src='../../js/cadastro.js'></script>
    <script type='text/javascript'>
    $(document).ready(function() {
        $("select").formSelect();
        $('#val').mask('#.##0,00', {
            reverse: true
        });
        $('#venc').mask('00/00');
    });
    </script>
</body>

</html>
<?php
    }
?>