<?php
  include '../config/conexao.php';
  session_start();

  $inicio = $_POST['inicio'];

    $sql="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
    date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
        from tabdoacao 
    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
    WHERE tabdoacao.doacaostatus = 3
    ORDER BY tabdoacao.datavencimentodoacao LIMIT 100 OFFSET $inicio";
    $result=$connect->query($sql);

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
        ?>
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();
});
</script>
<?php
  }
?>