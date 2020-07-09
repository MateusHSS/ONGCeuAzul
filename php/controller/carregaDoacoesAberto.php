<?php
  include '../config/conexao.php';
  session_start();

  $inicio = $_POST['inicio'];

  if($_SESSION['perfil'] == 1){
    //SELECIONA SEM DISTINGUIR OPERADOR
    $sql="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
    date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
        from tabdoacao 
    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
    WHERE tabdoacao.doacaostatus = 1
    ORDER BY tabdoacao.datavencimentodoacao LIMIT 100 OFFSET $inicio";
    $result=$connect->query($sql);
  }else if($_SESSION['perfil'] == 2){
    
    $idoper = $_SESSION['idoperador'];
    //SELECIONA APENAS AS DOACOES DO OPEADOR LOGADO
    $sql="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
    date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
        from tabdoacao 
    INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
    INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
    INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
    INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
    INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
    WHERE tabdoacao.doacaostatus = 1 AND taboperador.idoperador = $idoper
    ORDER BY tabdoacao.datavencimentodoacao LIMIT 100 OFFSET $inicio";
    $result=$connect->query($sql);
  }

    

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
    <?php
        if($_SESSION['perfil'] == 1){
            //APENAS ADM PODE ATRIBUIR MENSAGEIRO
    ?>
    <td class='atribui'>
        <p>
            <label>
                <input class='checklist' type='checkbox' id='<?php echo $res2['iddoacao'] ?>' />
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
<script type='text/javascript'>
$(document).ready(function() {
    $('.modal').modal();
});

function carrega() {
    var inicio = $("tbody tr").length - 1;

    $.ajax({

        url: '../controller/carregaDoacoesAberto.php',
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