<?php
  include '../config/conexao.php';
  session_start();

    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ONG Céu azul - ADM</title>

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
    
<table class="centered responsive-table card center" id='list'>
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
            <td class="nova-doacao"><a href="#nova-doacao<?php echo $res['idcontribuinte'] ?>" class='modal-trigger'><i
                        class="material-icons green-text">add</i></a></td>
            <td class='exclui' onclick="confirmaExclu(<?php echo $res['idcontribuinte'] ?>)">
                <a><i class='material-icons red-text'>clear</i></a></td>
            <td class='altera'><a href='#alterModal<?php echo $res['idcontribuinte'] ?>' class='modal-trigger'><i
                        class='material-icons purple-text'>create</i></a>
            </td>
        </tr>

        <div class='modal fade' id='alterModal<?php echo $res['idcontribuinte'] ?>'>
            <div class='modal-content'>
                <div class='row right'><i class='material-icons modal-close'>close</i></div>
                <h4>Alterar registros</h4>
                <div class='divider'></div>
                <form method='post' action='../controller/atualContr.php?id=<?php echo $res['idcontribuinte'] ?>'
                    id='atualiza<?php echo $res['idcontribuinte'] ?>'>
                    <div class='row'>
                        <div class='input-field col l6'>
                            <input id='nome<?php echo $res['idcontribuinte'] ?>' type='text' class='validate'
                                name='nome' value='<?php echo $res['nomecontribuinte'] ?>' required>
                            <label class='active' for='nome<?php echo $res['idcontribuinte'] ?>'>Nome
                                completo</label>
                        </div>
                        <div class='input-field col l3'>
                            <input id='tel<?php echo $res['idcontribuinte'] ?>' type='text' class='validate tel'
                                name='tel' value='<?php echo $res['telefone'] ?>' required>
                            <label class='active' for='tel'>Telefone</label>
                        </div>
                        <div class='input-field col l3'>
                            <input id='cep<?php echo $res['idcontribuinte'] ?>' type='text' class='validate cep'
                                name='cep' value='<?php echo $res['cep'] ?>'
                                data-id='<?php echo $res['idcontribuinte'] ?>'>
                            <label class='active' for='cep<?php echo $res['idcontribuinte'] ?>'>CEP</label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='input-field col l3'>
                            <input id='rua<?php echo $res['idcontribuinte'] ?>' type='text' class='validate rua'
                                name='rua' value='<?php echo $res['rua'] ?>' required>
                            <label class='active' for='rua<?php echo $res['idcontribuinte'] ?>'>Rua</label>
                        </div>
                        <div class='input-field col l3'>
                            <input id='num<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='num'
                                value='<?php echo $res['numero'] ?>' required>
                            <label class='active' for='num<?php echo $res['idcontribuinte'] ?>'>Número</label>
                        </div>
                        <div class='input-field col l3'>
                            <input id='bairro<?php echo $res['idcontribuinte'] ?>' type='text' class='validate bairro'
                                name='bairro' value='<?php echo $res['bairro'] ?>' required>
                            <label class='active' for='bairro<?php echo $res['idcontribuinte'] ?>'>Bairro</label>
                        </div>
                        <div class='input-field col l3'>
                            <input id='cidade<?php echo $res['idcontribuinte'] ?>' type='text' class='validate cidade'
                                name='cidade' value='<?php echo $res['cidade'] ?>' required>
                            <label class='active' for='cidade<?php echo $res['idcontribuinte'] ?>'>Cidade</label>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='input-field col l6'>
                            <input id='ref<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='ref'
                                value='<?php echo $res['referencia'] ?>'>
                            <label class='active' for='ref<?php echo $res['idcontribuinte'] ?>'>Ponto de
                                referência</label>
                        </div>
                        <div class='input-field col l6'>
                            <input id='obs<?php echo $res['idcontribuinte'] ?>' type='text' class='validate' name='obs'
                                value='<?php echo $res['obs'] ?>'>
                            <label class='active' for='obs<?php echo $res['idcontribuinte'] ?>'>Observações</label>
                        </div>
                    </div>
                    <div class="row center">
                        <button class='btn blue lighten-2' type='submit' name='action'
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
                            <input id="val<?php echo $res['idcontribuinte'] ?>" type="text" class="validate val"
                                name='val'>
                            <label for="val<?php echo $res['idcontribuinte'] ?>">Valor</label>
                        </div>
                        <div class="input-field col l3">
                            <input placeholder='mm/aa' id="venc<?php echo $res['idcontribuinte'] ?>" type="text"
                                class="validate venc" name='venc'>
                            <label for="venc<?php echo $res['idcontribuinte'] ?>">Vencimento</label>
                        </div>
                        <div class="input-field col l6">
                            <select name='tipo-contribuinte' id='tipo-contr<?php echo $res['idcontribuinte'] ?>'>
                                <option value="" disabled selected>Tipo</option>
                                <?php
                                    include 'config/conexao.php';
                                    $sqlCat = "SELECT * FROM tabcategoriacontribuinte";
                                    $resultCat = $connect->query($sqlCat);
                                    while($resCat = $resultCat->fetch_array()){
                                ?>
                                <option value='<?php echo $resCat['idtabcategoriacontribuinte'] ?>'>
                                    <?php echo $resCat['descricaocategoria'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <label>Tipo</label>
                        </div>
                    </div>
                    <div class="row center">
                        <button class='btn blue lighten-2 botao' type='submit' name='action'
                            id='new-doacao<?php echo $res['idcontribuinte'] ?>'>Atualizar
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
<!--JavaScript at end of body for optimized loading-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../js/listacontrs.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();

    $('.botao').click(function() {
        var id = $(this).attr('id');
        var categoria = $('#tipo-contr' + id).val();
        var action = $("#gera-doacao" + id).attr('action');

        action += '&tipo-contribuinte=' + categoria;

        $("#gera-doacao" + id).attr('action', action);


    });
});

function confirmaBaixa(id) {
    window.location.href = 'controller/confirmaBaixa.php?id=' + id;
}
</script>

</html>