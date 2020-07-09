<?php
  include '../config/conexao.php';
  session_start();

  $nome = $_POST['doacao'];

    ?>
<table class="centered striped responsive-table card" style='max-height: 10px;'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Contribuinte</th>
            <th>Doação</th>
            <th>Operador</th>
            <th>Valor</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php
    $sql="SELECT tabbaixa.idtabbaixa, tabcontribuinte.nomecontribuinte, tabdoacao.iddoacao, taboperador.nomeoperador, REPLACE(tabbaixa.valorbaixa,'.',',') as valorbaixa, date_format(tabbaixa.databaixa, '%e/%m/%Y') as databaixa
            FROM tabbaixa
        INNER JOIN tabdoacao ON tabdoacao.iddoacao = tabbaixa.iddoacaobaixa
        INNER JOIN tabcontribuinte ON tabcontribuinte.idcontribuinte = tabdoacao.idcontribuintedoacao
        INNER JOIN taboperador ON taboperador.idoperador = tabbaixa.idoperadorbaixa
        AND tabcontribuinte.nomecontribuinte LIKE '%$nome%'";
      $result=$connect->query($sql);

      if(mysqli_num_rows($result)==0){
        ?>
        <tr>
            <td colspan='6'>Nenhum registro encontrado</td>
        </tr>
        <?php
      }else{
        while ($res = $result->fetch_array()) {
          ?>
        <tr>
            <td><?php echo $res['idtabbaixa'] ?></td>
            <td><?php echo $res['nomecontribuinte'] ?></td>
            <td><?php echo $res['iddoacao'] ?></td>
            <td><?php echo $res['nomeoperador'] ?></td>
            <td><?php echo $res['valorbaixa'] ?></td>
            <td><?php echo $res['databaixa'] ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();
});
</script>
<?php
  }
?>