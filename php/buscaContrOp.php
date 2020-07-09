<?php
  include 'config/conexao.php';
  session_start();

  $nome = $_POST['doacao'];

    ?>
<table class="centered striped responsive-table card" style='max-height: 10px;'>
    <thead>
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
        </tr>
    </thead>
    <tbody>
        <?php

    $idoper = $_SESSION['idoperador'];

    $sql="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabcontribuinte.nomecontribuinte, tabdoacao.valordoacao, 
    DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabstatus.nomestatus, taboperador.nomeoperador
        FROM tabdoacao 
    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
    WHERE tabdoacao.idoperadordoacao = '$idoper' AND tabcontribuinte.nomecontribuinte LIKE '%$nome%' ORDER BY tabdoacao.datavencimentodoacao";
      $result=$connect->query($sql);

      if(mysqli_num_rows($result)==0){
        ?>
        <tr>
            <td>Nenhum registro encontrado</td>
        </tr>
        <?php
      }else{
        while ($res = $result->fetch_array()) {
          ?>
        <tr>
            <td><?php echo $res['iddoacao'] ?></td>
            <td><?php echo $res['cidade'] ?></td>
            <td><?php echo $res['bairro'] ?></td>
            <td><?php echo $res['nomecontribuinte'] ?></td>
            <td><?php echo $res['valordoacao'] ?></td>
            <td><?php echo $res['vencimento'] ?></td>
            <td><?php echo $res['nomemensageiro'] ?></td>
            <td><?php echo $res['nomestatus'] ?></td>
            <td><?php echo $res['nomeoperador'] ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<?php
  }
?>