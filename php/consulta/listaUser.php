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
    <title>ONG - Usuários</title>

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
                                    <th>Usuário</th>
                                    <th>Perfil</th>
                                    <th>Ativo</th>
                                    <th class="exclui">Excluir</th>
                                    <th class="altera">Alterar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                        include '../config/conexao.php';

                        $sql="SELECT u.*, p.nomeperfil FROM tabusuario u, tabperfil p WHERE p.idperfil = u.idperfilusuario ORDER BY ativo DESC";
                        $result=$connect->query($sql);
                        while($res= $result->fetch_array()){
                            switch($res['ativo']){
                                case 0:
                                    $ativo= 'Inativo';
                                    $atl = '';
                                break;
                                case 1:
                                    $ativo = 'Ativo';
                                    $atl = 'checked';
                                break;
                            }

                            switch($res['operadorusuario']){
                                case 0:
                                    $op = '';
                                break;
                                case 1:
                                    $op = 'checked';
                                break;
                            }
                            ?>
                                <tr>
                                    <td><?php echo $res['usuario'] ?></td>
                                    <td><?php echo $res['nomeperfil'] ?></td>
                                    <td><?php echo $ativo ?></td>
                                    <td class='exclui' onclick="confirmaExclu(<?php echo $res['idusuario'] ?>)"><a><i
                                                class='material-icons red-text'>clear</i></a></td>
                                    <td class='altera'><a href='#altera<?php echo $res['idusuario'] ?>'
                                            class='modal-trigger'><i class='material-icons purple-text'>create</i></a>
                                    </td>
                                </tr>

                                <div class='modal' id='altera<?php echo $res['idusuario'] ?>'>
                                    <div class='modal-content'>
                                        <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                        <h4>Alterar dados</h4>
                                        <div class='center' id='conteudo<?php echo $res['idusuario'] ?>'>
                                            <form class='col m12 center' id='formUser<?php echo $res['idusuario'] ?>'
                                                action='' method='POST'>
                                                <div class='row'>
                                                    <div class='input-field col l6'>
                                                        <input id='user<?php echo $res['idusuario'] ?>' type='text'
                                                            class='validate' name='user<?php echo $res['idusuario'] ?>'
                                                            value='<?php echo $res['usuario'] ?>' required>
                                                        <label for='user<?php echo $res['idusuario'] ?>'>Usuário</label>
                                                    </div>
                                                    <div class='input-field col l6'>
                                                        <select name='perfil<?php echo $res['idusuario'] ?>' id='perfil<?php echo $res['idusuario'] ?>'>
                                                            <option value='<?php echo $res['idperfilusuario'] ?>' selected><?php echo $res['nomeperfil'] ?></option>
                                                            <option value='1'>Administrador</option>
                                                            <option value='2'>Operador</option>
                                                        </select>
                                                        <label>Perfil</label>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col l6'>
                                                        <p>
                                                            <label>
                                                                <input type='checkbox' class='filled-in'
                                                                    id='ativo<?php echo $res['idusuario'] ?>'
                                                                    <?php echo $atl ?> />
                                                                <span>Ativo</span>
                                                            </label>
                                                        </p>
                                                    </div>
                                                    <div class='col l3'>
                                                        <p>
                                                            <label>
                                                                <input type='checkbox' class='filled-in operador'
                                                                    id='operador<?php echo $res['idusuario'] ?>'
                                                                    name='operador<?php echo $res['idusuario'] ?>'
                                                                    <?php echo $op ?> />
                                                                <span>Operador</span>
                                                            </label>
                                                        </p>
                                                    </div>
                                                    <div class='input-field col l3'>
                                                        <input id='idoper<?php echo $res['idusuario'] ?>' type='text'
                                                            class='validate'
                                                            name='idoper<?php echo $res['idusuario'] ?>'
                                                            value='<?php echo $res['idoperadorusuario'] ?>' required>
                                                        <label for='idoper<?php echo $res['idusuario'] ?>'>Id do
                                                            operador</label>
                                                    </div>
                                                </div>
                                                <div class='row'>
                                                    <div class='input-field col l6'>
                                                        <input id='pass<?php echo $res['idusuario'] ?>' type='password'
                                                            class='validate' name='pass<?php echo $res['idusuario'] ?>'
                                                            required>
                                                        <label for='pass<?php echo $res['idusuario'] ?>'>Nova
                                                            senha</label>
                                                    </div>
                                                    <div class='input-field col l6'>
                                                        <input id='confirmPass<?php echo $res['idusuario'] ?>'
                                                            type='password' class='validate' required>
                                                        <label for='confirmPass<?php echo $res['idusuario'] ?>'>Confirma
                                                            senha</label>
                                                    </div>
                                                </div>

                                                <div class='btn  botao'
                                                    id='<?php echo $res['idusuario'] ?>' type='submit' name='action'>
                                                    Atualizar
                                                    <i class='material-icons right'>check</i>
                                                </div>
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

                    <div class="modal" id="modal-user">
                        <div class="modal-content">
                            <div class="row right"><i class="material-icons modal-close">close</i></div>
                            <h4>Novo usuário</h4>
                            <div id="user-conteudo">
                                <form class="col m12 center" id='formUser' action="../controller/insereUser.php"
                                    method='POST'>
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
                                                    <input type="checkbox" class="filled-in" name='ativo'
                                                        checked="checked" />
                                                    <span>Ativo</span>
                                                </label>
                                            </p>
                                        </div>
                                        <div class='col l3'>
                                            <p>
                                                <label>
                                                    <input type="checkbox" class="filled-in" checked="checked"
                                                        id='operador' name='operador' />
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

                                    <button class="btn waves-effect waves-light " type="submit"
                                        name="action">Cadastrar
                                        <i class="material-icons right">check</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l2">
                <a class="btn right  card modal-trigger" href="#modal-user" id='novo-user'
                    style='width:100%;'>Novo</a>
                <a class="btn right  card" id='alter-user' style='width:100%;'>Alterar</a>
                <a class="btn right  card" id='excl-user' style='width:100%;'>Excluir</a>
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
    <script type="text/javascript" src="../../js/listauser.js"></script>
</body>

</html>
<?php
    }
?>