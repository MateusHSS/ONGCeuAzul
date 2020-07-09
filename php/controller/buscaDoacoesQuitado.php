<?php
  include '../config/conexao.php';
  session_start();

  $nome = $_POST['doacao'];

    ?>
<table class="centered striped responsive-table card" style='max-height: 10px;'>
    <thead>
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
    </thead>
    <tbody>
        <?php
        if($nome == ''){
            $sql="SELECT tabdoacao.iddoacao, tabdoacao.doacaostatus, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
                DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
                    FROM tabdoacao 
                INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
                INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
                INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
                INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
                WHERE tabdoacao.doacaostatus = 3
                ORDER BY tabdoacao.datavencimentodoacao LIMIT 100";
        }else{
            $sql="SELECT tabdoacao.iddoacao, tabdoacao.doacaostatus, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
            DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
                FROM tabdoacao 
            INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
            INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
            INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
            INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
            INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
            WHERE tabdoacao.doacaostatus = 3 AND tabcontribuinte.nomecontribuinte  LIKE '%$nome%' OR tabdoacao.iddoacao LIKE '%$nome%'
            ORDER BY tabdoacao.datavencimentodoacao";
        }
    
      $result=$connect->query($sql);

      if(mysqli_num_rows($result)==0){
        ?>
        <tr>
            <td colspan='12'>Nenhum registro encontrado</td>
        </tr>
        <?php
      }else{
        while ($res = $result->fetch_array()) {
          switch($res['nomestatus']){
            case "<p style='color: green'>Quitado</p>":
                echo '<tr class="quitado">';
            break;
            case "<p style='color: orange'>Em cobrança</p>":
                echo '<tr class="cobranca">';
            break;
            case "<p style='color: red'>Em aberto</p>":
                echo '<tr class="aberto">';
            break;
        }
          ?>
        <td class='recibo'>
            <p>
                <label>
                    <input class='checklist ger-recibo' type='checkbox' id='recibo<?php echo $res['iddoacao'] ?>' />
                    <span></span>
                </label>
            </p>
        </td>
        <td class='atribui'>
            <p>
                <label>
                    <input class='checklist' type='checkbox' id='<?php echo $res['iddoacao'] ?>' />
                    <span></span>
                </label>
            </p>
        </td>
        <td><?php echo $res['iddoacao'] ?></td>
        <td><?php echo $res['cidade'] ?></td>
        <td><?php echo $res['bairro'] ?></td>
        <td><?php echo $res['nomecontribuinte'] ?></td>
        <td><?php echo $res['valor'] ?></td>
        <td><?php echo $res['vencimento'] ?></td>
        <td><?php echo $res['nomemensageiro'] ?></td>
        <td><?php echo $res['nomestatus'] ?></td>
        <td><?php echo $res['nomeoperador'] ?></td>
        <td class='receber'><a href='#recebe<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                    class='material-icons green-text'>save_alt</i></a>
        </td>
        <td class='editar'><a href='#edita<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                    class='material-icons purple-text'>create</i></a>
        </td>
        </tr>

        <div class='modal' id='edita<?php echo $res['iddoacao'] ?>'>
            <div class='modal-content'>
                <div class='row right'><i class='material-icons modal-close'>close</i></div>
                <h4>Editar doação</h4>
                <div class='divider'></div>
                <form action="../controller/editaDoacao.php?iddoacao=<?php echo $res['iddoacao'] ?>" method="post"
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
                                <option value="<?php echo $res['doacaostatus'] ?>" selected>
                                    <?php echo $res['nomestatus'] ?></option>
                                <?php

                                    include_once '../config/conexao.php';

                                    $sqlStts = $connect->prepare("SELECT * FROM tabstatus ORDER BY nomestatus ASC");
                                    $sqlStts->execute();

                                    $resultStts = $sqlStts->get_result();

                                    while($rowStts = $resultStts->fetch_assoc()) {
                                ?>

                                <option value="<?php echo $rowStts['idtabstatus'] ?>">
                                    <?php echo $rowStts['nomestatus'] ?></option>

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

        if($nome == ''){?>
        <tr id='carregar'>
            <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar mais...</a></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();

    $('select').formSelect();

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
    })
});

function carrega() {
    var inicio = $("tbody tr").length - 1;

    $.ajax({

        url: '../controller/carregaDoacoes.php',
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