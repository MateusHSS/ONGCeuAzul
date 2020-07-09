<?php
  include '../config/conexao.php';
  session_start();

  $inicio = $_POST['inicio'];
  $id = $_GET['id'];
  $stts = $_GET['stts'];

    $sql = $connect->prepare("SELECT tabdoacao.iddoacao, tabdoacao.doacaostatus, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
    DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador, taboperador.idoperador
        FROM tabdoacao 
    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
    WHERE tabdoacao.doacaostatus = $stts AND taboperador.idoperador = $id
    ORDER BY tabdoacao.datavencimentodoacao LIMIT 100 OFFSET $inicio");
    $sql->execute();

    $result = $sql->get_result();

    if(mysqli_num_rows($result)==0){
    ?>
<tr>
    <td colspan='6'>Nenhum registro encontrado</td>
</tr>
<?php
      }else{
        while ($res = $result->fetch_array()) {
            switch($res['nomestatus']){
                case "<p style='color: green'>Quitado</p>":
                    echo '<tr class="filtro quitado mens'.$res['idmensageiro'].'">';
                break;
                case "<p style='color: orange'>Em cobrança</p>":
                    echo '<tr class="filtro cobranca mens'.$res['idmensageiro'].'">';
                break;
                case "<p style='color: red'>Em aberto</p>":
                    echo '<tr class="filtro aberto mens'.$res['idmensageiro'].'">';
                break;
                case "<p style='color: brow'>Não contribuiu</p>":
                    echo '<tr class="filtro naocontr mens'.$res['idmensageiro'].'">';
                break;
                case "<p style='color: grey'>Indeferido</p>":
                    echo '<tr class="filtro indeferido mens'.$res['idmensageiro'].'">';
                break;
            }
          ?>
    <td class='recibo'>
        <p>
            <label>
                <input class='checklist ger-recibo' type='checkbox' id="recibo<?php echo $res['iddoacao'] ?>" />
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
    <td id='status<?php echo $res['iddoacao'] ?>'><?php echo $res['nomestatus'] ?></td>
    <td><?php echo $res['nomeoperador'] ?></td>
    <td class='receber'><a href='#recebe<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                class='material-icons green-text'>save_alt</i></a></td>
    <td class='editar'><a href='#edita<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i
                class='material-icons purple-text'>create</i></a></td>
</tr>
<?php
        }
        if($result->num_rows >= 100){
            ?>
            <tr id='carregar'>
                <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar mais...</a></td>
            </tr>
        <?php
        }else{
            
        }
        ?>
        ?>
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();
});

function carrega() {
    var inicio = $("tbody tr").length - 1;

    $.ajax({

        url: '../controller/carregaDoacoesOper.php?id='+ <?php echo $id ?> +'&stts=<?php echo $stts ?>',
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
</script>
<?php
  }
?>