<?php
  include '../config/conexao.php';
  session_start();

  $id = $_GET['id'];
  if(isset($_GET['oper'])){
    $idoper = $_GET['oper'];
  }
  

    ?>
<table class="centered striped responsive-table card" id='list' style='max-height: 10px;'>
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
            if($_SESSION['perfil'] == 1){
                $sql="SELECT tabcontribuinte.idcontribuinte, tabcontribuinte.nomecontribuinte, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabendereco.referencia, tabendereco.obs, tabendereco.cep, tabcontato.telefone, DATE_FORMAT(tabcontribuinte.datacadastrocontribuinte, '%e/%m/%Y') AS datacad, taboperador.nomeoperador
                    FROM tabcontribuinte 
                INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                INNER JOIN tabcontato ON tabcontato.idcontribuintecontato = tabcontribuinte.idcontribuinte
                INNER JOIN taboperador ON taboperador.idoperador = tabcontribuinte.idopercontribuinte
                WHERE tabcontribuinte.categoria = $id
                ORDER BY  tabcontribuinte.datacadastrocontribuinte DESC LIMIT 100";
            }else if($_SESSION['perfil'] == 2){
                $idoper = $_SESSION['idoperador'];

                $sql="SELECT tabcontribuinte.idcontribuinte, tabcontribuinte.nomecontribuinte, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabendereco.referencia, tabendereco.obs, tabendereco.cep, tabcontato.telefone, DATE_FORMAT(tabcontribuinte.datacadastrocontribuinte, '%e/%m/%Y') AS datacad, taboperador.nomeoperador
                    FROM tabcontribuinte 
                INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
                INNER JOIN tabcontato ON tabcontato.idcontribuintecontato = tabcontribuinte.idcontribuinte
                INNER JOIN taboperador ON taboperador.idoperador = tabcontribuinte.idopercontribuinte
                WHERE tabcontribuinte.categoria = $id AND taboperador.idoperador = $idoper
                ORDER BY  tabcontribuinte.datacadastrocontribuinte DESC LIMIT 100";
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
                                                        $sqlCat = "SELECT * FROM tabcategoriacontribuinte ORDER BY quantidadecategoria";
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
});

function carrega() {
    var inicio = $("tbody tr").length - 1;

    $.ajax({
        <?php 
        if($_SESSION['perfil'] == 1){
            ?>
            url: '../controller/carregaContrCat.php?id=' + <?php echo $id ?>,
            <?php
        }else if($_SESSION['perfil'] == 2){
            ?>
            url: '../controller/carregaContrCat.php?id=' + <?php echo $id ?> + '&oper='+<?php echo $idoper ?>,
            <?php
        }
        ?>
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

function confirmaBaixa(id) {
    window.location.href = 'controller/confirmaBaixa.php?id=' + id;
}
</script>
<?php
  }
?>