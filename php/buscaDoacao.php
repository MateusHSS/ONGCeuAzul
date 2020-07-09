<?php
  include '../config/conexao.php';
  session_start();

  $nome = $_POST['doacao'];

    ?>
<table class="centered striped responsive-table card" style='max-height: 10px;'>
    <thead>
        <tr>
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
        </tr>
    </thead>
    <tbody>
        <?php
    $sql="SELECT d.*, date_format(datavencimentodoacao, '%d/%m/%Y') as vencimento, REPLACE(valordoacao,'.',',') as 
    valor, c.*, o.*, e.*, s.*, m.* FROM tabdoacao d, taboperador o, tabcontribuinte c, tabendereco e, tabstatus s, tabmensageiro m WHERE 
    CONCAT(c.nomecontribuinte, ' ', d.iddoacao) LIKE '%$nome%' AND d.idcontribuintedoacao = c.idcontribuinte AND d.idoperadordoacao = o.idoperador AND 
    d.idcontribuintedoacao = e.idcontribuinteendereco AND d.doacaostatus = s.idtabstatus AND m.idmensageiro = d.idmensageirodoacao ORDER BY d.datavencimentodoacao";
      $result=$connect->query($sql);

      if(mysqli_num_rows($result)==0){
        ?>
        <tr>
            <td>Nenhum registro encontrado</td>
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
        <td class='receber'><a href='#recebeB<?php echo $res['iddoacao'] ?>' class='modal-trigger'><i class='material-icons green-text'>save_alt</i></a></td>
        </tr>

        <div class='modal' id='recebeB<?php echo $res['iddoacao'] ?>'>
            <div class='modal-content'>
                <div class='row right'><i class='material-icons modal-close'>close</i></div>
                <h4>Receber</h4>
                <div class='divider'></div>
                <div class='row'>
                    <div class='col l6 left'>
                        <p><strong>Ref: </strong><?php echo $res['iddoacao'] ?></p>
                        <p><strong>Contribuinte: </strong><?php echo $res['nomecontribuinte'] ?></p>
                        <p><strong>Valor: </strong><?php echo $res['valor'] ?></p>
                        <p><strong>Vencimento: </strong><?php echo $res['vencimento'] ?></p>
                    </div>
                    <div class='col l6 left'>
                        <p><strong>Endereco: </strong><?php echo $res['rua'].', '.$res['numero']?></p>
                        <p><strong>Bairro: </strong><?php echo $res['bairro'] ?></p>
                        <p><strong>Cidade: </strong><?php echo $res['cidade'] ?></p>
                        <div class='divider'></div>
                        <p><strong>Operador: </strong><?php echo $res['nomeoperador'] ?></p>
                        <p><strong>Mensageiro: </strong><?php echo $res['nomemensageiro'] ?></p>
                    </div>
                </div>
                <div class='center'>
                    <button class='btn blue lighten-2' type='submit' name='action'
                        onclick='confirmaBaixa(<?php echo $res["iddoacao"] ?>)'>Confirmar
                        <i class='material-icons right'>check</i>
                    </button>
                </div>
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
});

function confirmaBaixa(id) {
    window.location.href = 'controller/confirmaBaixa.php?id=' + id;
}
</script>
<?php
  }
?>