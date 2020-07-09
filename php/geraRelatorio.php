<?php 
include_once 'config/conexao.php';
    $url = $_SERVER['REQUEST_URI'];
    $id = $_GET['id'];

    $converte1 = explode('/', $_GET['dtin']);
    $dtin = $converte1[2].'-'.$converte1[1].'-'.($converte1[0]);
    $converte2 = explode('/', $_GET['dtfim']);
    $dtfim = $converte2[2].'-'.$converte2[1].'-'.($converte2[0]);
    $dados = [];
    $totalComissao = 0;
    $totalArrecadado = 0;
    

    

?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body onload='geraRelatorio()'>

    <table id='tabela' style='display: none;'>
        <tr>
            <th>ID</th>
            <th>CONTRIBUINTE</th>
            <th>BAIRRO</th>
            <th>CIDADE</th>
            <th>RECEBIMENTO</th>
            <th>VALOR</th>
            <th>COMISSÃO</th>
        </tr>
    

    <?php

        $sql = $connect->prepare("select tabbaixa.idoperadorbaixa, taboperador.nomeoperador, taboperador.comissaoporcent, taboperador.comissaofix, tabbaixa.iddoacaobaixa,
        tabcontribuinte.nomecontribuinte, tabbaixa.valorbaixa, tabbaixa.databaixa, tabendereco.bairro, tabendereco.cidade, date_format(tabbaixa.databaixa, '%d/%m/%y') as databaixa
            from tabbaixa 
        inner join taboperador on taboperador.idoperador = tabbaixa.idoperadorbaixa 
        inner join tabdoacao on tabdoacao.iddoacao = tabbaixa.iddoacaobaixa
        inner join tabcontribuinte on tabcontribuinte.idcontribuinte = tabdoacao.idcontribuintedoacao
        inner join tabendereco on tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
        where tabbaixa.idoperadorbaixa = '$id' and tabbaixa.databaixa >= '$dtin' and tabbaixa.databaixa <= '$dtfim' order by tabbaixa.databaixa");
        $sql->execute();
        $result = $sql->get_result();

        if($sql->affected_rows == 0){
            echo "<script type='text/javascript'>alert('Nenhuma contribuição encontrada no período selecionado!');window.location.href = 'admin.php'</script>";
        }else{
            while($res = $result->fetch_assoc()){
                array_push($dados, [
                    "ID"=>$res['idoperadorbaixa'],
                    "Nome"=>$res['nomeoperador'],
                    "Nome contribuinte" => $res['nomecontribuinte'],
                    "ComissaoPorc"=>$res['comissaoporcent'],
                    "ComissaoFix"=>$res['comissaofix'],
                    "IDDoacao"=>$res['iddoacaobaixa'],
                    "Data"=>$res['databaixa'],
                    "Valor"=>$res['valorbaixa']
                    ]);
    
                    if($res['valorbaixa']>= 50){
                        $totalComissao += ($res['valorbaixa']*$res['comissaoporcent'])/100;
                        $comissao = ($res['valorbaixa']*$res['comissaoporcent'])/100;
                    }else{
                        $totalComissao += $res['comissaofix'];
                        $comissao = $res['comissaofix'];
                    }
                    $totalArrecadado += $res['valorbaixa'];
                    ?>
                    <tr>
                        <td><?php echo $res['iddoacaobaixa'] ?></td>
                        <td><?php echo $res['nomecontribuinte'] ?></td>
                        <td><?php echo $res['bairro'] ?></td>
                        <td><?php echo $res['cidade'] ?></td>
                        <td><?php echo $res['databaixa'] ?></td>
                        <td><?php echo $res['valorbaixa'] ?></td>
                        <td><?php echo $comissao ?>,00</td>
                    </tr>
    
                    <?php
            }
        }
        
        ?>
        </table>
        <?php

        for($i=0; $i < $result->num_rows; $i++){
            $dados[$i] = implode('|', $dados[$i]);
        }

        $string_dados = implode('|', $dados);
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js"></script>
    <script type='text/javascript'>
        function geraRelatorio(){
            var doc2 = new jsPDF({unit: 'cm'});
            doc2.setFontSize(15);

            var dtin = "<?php echo $_GET['dtin'] ?>";
            var dtfim = "<?php echo $_GET['dtfim'] ?>";
            var string_dados = "<?php echo $string_dados ?>";
            var dados = string_dados.split('|');
            var comissao = "<?php echo $totalComissao ?>";
            var arrecadado = "<?php echo $totalArrecadado ?>";


            doc2.text(7, 2, 'RELATÓRIO DE COMISSÃO');
            doc2.text(2, 3, 'Nome: '+dados[1]);
            doc2.text(2,4, 'Período: '+dtin+' a '+dtfim);
            doc2.text(2,5, 'Total arrecadado: R$'+arrecadado+',00');
            doc2.text(2,6, 'Total comissão: R$'+comissao+',00');



            doc2.autoTable({
                html: '#tabela',
                theme: 'grid',
                bodyStyles: {
                    fontSize: 7,
                    halign: 'center',
                    minCellWidth: 1,
                },
                margin: {top: 7},
            });

            window.open(doc2.output('bloburl'));

            window.location.href = 'admin.php';

            
            
        }

        
    </script>
</body>
</html>
