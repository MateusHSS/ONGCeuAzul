<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        include_once '../config/conexao.php';
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ONG - Cadastro usuário</title>

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
                <form class="col m12 center" id='formUser' action="controller/insereUser.php" method='POST'>
                    <div class="row">
                        <div class="input-field col l6">
                            <input id="user" type="text" class="validate" name='user' required>
                            <label for="user">Usuário</label>
                        </div>
                        <div class="input-field col l6">
                            <select name='perfil'>
                                <option value="" selected>Perfil do usuário</option>
                                <option value="1">Administrador</option>
                                <option value="2">Operador</option>
                            </select>
                            <label>Perfil</label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col l6'>
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" name='ativo' checked="checked" />
                                    <span>Ativo</span>
                                </label>
                            </p>
                        </div>
                        <div class='col l3'>
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" checked="checked" id='operador'
                                        name='operador' />
                                    <span>Operador</span>
                                </label>
                            </p>
                        </div>
                        <div class="input-field col l3" id='idOper'>
                            <input id="idOp" type="text" class="validate" name='idOper' required>
                            <label for="idOp">Id do operador</label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class="input-field col l6">
                            <input id="pass" type="password" class="validate" name='senha' required>
                            <label for="pass">Senha</label>
                        </div>
                        <div class="input-field col l6">
                            <input id="confirmPass" type="password" class="validate" required>
                            <label for="confirmPass">Confirma senha</label>
                        </div>
                    </div>

                    <button class="btn waves-effect waves-light " type="submit" name="action">Cadastrar
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
        $('select').formSelect();
        $("#operador").click(function(e) {
            if ($(this).is(':checked')) { //Retornar true ou false 
                $('#idOper').show(); // CheckBox marcado
                $('#idOp').attr('required', 'required');
            } else {
                $('#idOper').hide();
                $('#idOp').removeAttr('required');
            }
        });
    });
    </script>
</body>

</html>
<?php
    }
?>