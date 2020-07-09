<?php
    include '../config/conexao.php';
    session_start();

    $converte1 = explode('/', $_GET['data-inicio']);
    $dtin = $converte1[2].'-'.$converte1[1].'-'.($converte1[0]);
    $converte2 = explode('/', $_GET['data-fim']);
    $dtfim = $converte2[2].'-'.$converte2[1].'-'.($converte2[0]);
    $stts = $_GET['stts'];


    ?>
<table class="centered striped responsive-table card" id='list' style='max-height: 10px;'>
    <thead>
        <?php
        if($_SESSION['perfil'] == 1){
            //APENAS ADM PODE ATRIBUIR MENSAGEIRO/GERAR RECIBO/RECEBER
        ?>
        <tr>
            <td colspan='3' class='recibo atribui'>
                <p>
                    <label>
                        <input type='checkbox' id="check-todos" />
                        <span>Selecionar todos</span>
                    </label>
                </p>
            </td>
            <td>
                <div class="col l2 recibo">
                    <button class='btn blue lighten-2' id='gerar-recibo'>Imprimir</button>
                </div>
            </td>
        </tr>
        <tr>
            <th class='recibo'>Recibo</th>
            <th class='atribui'>Marcar</th>
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
        //OPERADOR APENAS EDITA AS INFORMAÇÕES
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
    <tbody>
        <?php
        if($_SESSION['perfil'] == 1){
            //SELECIONA SEM DISTINGUIR OPERADOR
            $sql = $connect->prepare("SELECT tabdoacao.iddoacao, tabdoacao.doacaostatus, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
                DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador, taboperador.idoperador
                    FROM tabdoacao 
                INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
                INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
                INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
                INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                WHERE tabdoacao.doacaostatus = $stts AND tabdoacao.datavencimentodoacao >= '$dtin' AND tabdoacao.datavencimentodoacao <= '$dtfim'
                ORDER BY tabdoacao.datavencimentodoacao");
        }else if($_SESSION['perfil'] == 2){

            $idoper = $_SESSION['idoperador'];
            //SELECIONA APENAS DOACOES DO OPERADOR LOGADO
            $sql = $connect->prepare("SELECT tabdoacao.iddoacao, tabdoacao.doacaostatus, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
                DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador, taboperador.idoperador
                    FROM tabdoacao 
                INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
                INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
                INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
                INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                WHERE tabdoacao.doacaostatus = $stts AND tabdoacao.datavencimentodoacao >= '$dtin' AND tabdoacao.datavencimentodoacao <= '$dtfim' AND taboperador.idoperador = $idoper
                ORDER BY tabdoacao.datavencimentodoacao");
        }
            
        $sql->execute();

        $result = $sql->get_result();

      if($result->num_rows ==0){
        ?>
        <tr>
            <td colspan='12'>Nenhum registro encontrado</td>
        </tr>
        <?php
      }else{
        while ($res = $result->fetch_assoc()) {
          ?>
        <tr>
            <?php
                if($_SESSION['perfil'] == 1){
                    //APENAS ADM ATRIBUI MENSAGEIRO/GERA RECIBO
            ?>
            <td class='atribui'>
                <p>
                    <label>
                        <input class='checklist atribuie' type='checkbox' id='<?php echo $res['iddoacao'] ?>' />
                        <span></span>
                    </label>
                </p>
            </td>
            <td class='recibo'>
                <p>
                    <label>
                        <input class='checklist ger-recibo' type='checkbox' id="recibo<?php echo $res['iddoacao'] ?>" />
                        <span></span>
                    </label>
                </p>
            </td>
            <?php } ?>
            <td><?php echo $res['iddoacao'] ?></td>
            <td><?php echo $res['cidade'] ?></td>
            <td><?php echo $res['bairro'] ?></td>
            <td><?php echo $res['nomecontribuinte'] ?></td>
            <td><?php echo $res['valor'] ?></td>
            <td><?php echo $res['vencimento'] ?></td>
            <td><?php echo $res['nomemensageiro'] ?></td>
            <td id='status<?php echo $res['iddoacao'] ?>'><?php echo $res['nomestatus'] ?></td>
            <td><?php echo $res['nomeoperador'] ?></td>
            <td class='editar'><a href='#edita<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                        class='material-icons purple-text'>create</i></a>
            </td>
            <?php
            if($_SESSION['perfil'] == 1){
                //APENAS O ADM RECEBE
                ?>
            <td class='receber'><a href='#recebe<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                        class='material-icons green-text'>save_alt</i></a>
            </td>
            <?php
            }
            ?>
        </tr>

        <?php
        if($_SESSION['perfil'] == 1){
            //APENAS O ADM TEM O MODAL DE RECEBER DOACAO
            ?>
        <div class='modal' id='recebe<?php echo $res['iddoacao'] ?>'>
            <div class='modal-content'>
                <div class='row right'><i class='material-icons modal-close'>close</i></div>
                <h4>Receber</h4>
                <div class='divider'></div>
                <div class='row'>
                    <div class='col l6 left'>
                        <p><strong>Ref: </strong><?php echo $res['iddoacao'] ?></p>
                        <p><strong>Contribuinte:
                            </strong><?php echo $res['nomecontribuinte'] ?></p>
                        <p><strong>Valor: </strong><?php echo $res['valor'] ?></p>
                        <p><strong>Vencimento: </strong><?php echo $res['vencimento'] ?>
                        </p>
                    </div>
                    <div class='col l6 left'>
                        <p><strong>Endereco:
                            </strong><?php echo $res['rua'].', '.$res['numero'] ?></p>
                        <p><strong>Bairro: </strong><?php echo $res['bairro'] ?></p>
                        <p><strong>Cidade: </strong><?php echo $res['cidade'] ?></p>
                        <div class='divider'></div>
                        <p><strong>Operador: </strong><?php echo $res['nomeoperador'] ?>
                        </p>
                        <p><strong>Mensageiro:
                            </strong><?php echo $res['nomemensageiro'] ?></p>
                    </div>
                </div>
                <div class='center'>
                    <div class='btn blue lighten-2 oi' type='submit' name='action' id='<?php echo $res['iddoacao'] ?>'>
                        Confirmar
                        <i class='material-icons right'>check</i>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

        <div class='modal' id='edita<?php echo $res['iddoacao'] ?>'>
            <div class='modal-content'>
                <div class='row right'><i class='material-icons modal-close'>close</i></div>
                <h4>Editar doação</h4>
                <div class='divider'></div>
                <form action="controller/editaDoacao.php?iddoacao=<?php echo $res['iddoacao'] ?>" method="post"
                    id='form-edita<?php echo $res['iddoacao'] ?>'>
                    <div class='row'>
                        <div class="input-field col l3">
                            <input id="val<?php echo $res['iddoacao'] ?>" type="text" class="validate" name='val'
                                value='<?php echo $res['valor'] ?>' required>
                            <label for="val<?php echo $res['iddoacao'] ?>">Valor</label>
                        </div>
                        <div class="input-field col l3">
                            <input id="venc<?php echo $res['iddoacao'] ?>" type="text" class="validate" name='venc'
                                value='<?php echo $res['vencimento'] ?>' required>
                            <label for="venc<?php echo $res['iddoacao'] ?>">Valor</label>
                        </div>
                        <div class="input-field col l6">
                            <select id='statusdoacao<?php echo $res['iddoacao'] ?>'>
                                <option value="<?php echo $res['doacaostatus'] ?>" selected><?php echo $res['nomestatus'] ?></option>
                                <?php

                                    include_once '../config/conexao.php';

                                    $sqlStts = $connect->prepare("SELECT * FROM tabstatus ORDER BY nomestatus ASC");
                                    $sqlStts->execute();

                                    $resultStts = $sqlStts->get_result();

                                    while($rowStts = $resultStts->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $rowStts['idtabstatus'] ?>"><?php echo $rowStts['nomestatus'] ?></option>

                                <?php
                                    }
                                ?>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                    <div class='center'>
                        <button class='btn blue lighten-2 botao' data-id='<?php echo $res['iddoacao'] ?>'
                            type='submit'>Confirmar
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
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();

    $('select').formSelect();

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

    $('#gerar-recibo').click(function() {
        var url = '../geraPDF.php?';

        $('.checklist:checked.ger-recibo').each(function() {
            url += '&id=' + $(this).attr('id').replace('recibo', '');
        });

        window.location.href = url;
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

    $('#atribuir-mens').click(function() {
            var mens = $('#mensageiro').val();
            var url = '../controller/atribuiMens.php?mens=' + mens;

            $('.checklist:checked.atribuie').each(function() {
                url += '&id=' + $(this).attr('id');
            });

            alert(url);

            if (mens == null) {
                alert('Selecione um mensageiro!');
            } else {
                window.location.href = url;
            }
        });
});

function carrega() {
    var inicio = $("tbody tr").length - 1;

    $.ajax({

        url: 'controller/carregaDoacoes.php',
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
<?php
  }
?>