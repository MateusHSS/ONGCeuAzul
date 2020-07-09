<?php 
include_once 'config/conexao.php';
include_once "geraCodigoBarra.php";
    $url = $_SERVER['REQUEST_URI'];
    $ids = explode('&id=', $url);

    $i=1;
    $qtd = count($ids)-1;
    $dados = [];
    $dadosRelatorio = [];
    $total = 0;
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
    table{
        width: 100%;
    }
</style>
</head>
<body onload='geraPDF()'>
    <table id='tabela' >
        <tr>
            <th>ID</th>
            <th>Nome contribuinte</th>
            <th>Mensageiro</th>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>Operador</th>
            <th>Valor</th>
        </tr>
<?php
    for($i=1; $i<=$qtd; $i++){
        $id = $ids[$i];
        
        $sql3 = $connect->prepare("SELECT DISTINCT tabdoacao.iddoacao, replace(tabdoacao.valordoacao,'.',',') AS valor, DATE_FORMAT(tabdoacao.datavencimentodoacao, '%d/%m/%y') AS vencimento, 
        tabcontribuinte.nomecontribuinte, substring_index(substring_index(tabcontribuinte.nomecontribuinte, ' ', 1), ' ', -1)  AS pnomecontribuinte, 
        tabmensageiro.nomemensageiro, substring_index(substring_index(tabmensageiro.nomemensageiro, ' ', 1), ' ', -1)  AS pnomemensageiro, 
        substring_index(substring_index(taboperador.nomeoperador, ' ', 1), ' ', -1)  AS pnomeoperador, tabendereco.rua, tabendereco.numero, 
        tabendereco.bairro, tabendereco.cidade, tabendereco.referencia, tabendereco.obs, tabcontato.telefone, tabmensageiro.idmensageiro
                FROM tabdoacao 
            INNER JOIN tabcontribuinte ON tabcontribuinte.idcontribuinte = tabdoacao.idcontribuintedoacao
            INNER JOIN tabmensageiro ON tabmensageiro.idmensageiro = tabdoacao.idmensageirodoacao
            INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
            INNER JOIN tabcontato ON tabcontato.idcontribuintecontato = tabcontribuinte.idcontribuinte
            INNER JOIN taboperador ON taboperador.idoperador = tabdoacao.idoperadordoacao 
        WHERE tabdoacao.iddoacao = $id");

        $sql3->execute();
        $result3 = $sql3->get_result();
        while($res3 = $result3->fetch_assoc()){
            ?>
            <tr>
                <td><?php echo geraCodigoBarra($res3['iddoacao']) ?></td>
                <td><?php echo $res3['nomecontribuinte'] ?></td>
                <td><?php echo $res3['nomemensageiro'] ?></td>
                <td><?php echo $res3['bairro'] ?></td>
                <td><?php echo $res3['cidade'] ?></td>
                <td><?php echo $res3['pnomeoperador'] ?></td>
                <td><?php echo $res3['valor'] ?></td>
            </tr>
            <?php
            array_push($dados, [
                "ID"=>geraCodigoBarra($res3['iddoacao']),
                "Nome"=>$res3['nomecontribuinte'],
                "Rua"=>$res3['rua'],
                "Numero"=>$res3['numero'],
                "Bairro"=>$res3['bairro'],
                "Obs"=>$res3['obs'],
                "Referencia"=>$res3['referencia'],
                "Telefone"=>$res3['telefone'],
                "Valor"=>$res3['valor'],
                "Vencimento"=>$res3['vencimento'],
                "Pnomecontr"=>$res3['pnomecontribuinte'],
                "Pnomemens"=>$res3['pnomemensageiro'],
                "Cidade"=>$res3['cidade'],
                "Operador"=>$res3['pnomeoperador']
                ]);
            
            $valor = str_replace (',', '.', str_replace ('.', '', $res3['valor']));

            array_push($dadosRelatorio, $res3['idmensageiro']);
            
            $total += $valor;
        }
        
    }

    ?>
        <tr>
            <td></td>
            <td></td>
            <td>TOTAL DE FICHAS</td>
            <td><?php echo $qtd ?></td>
            <td>VALOR TOTAL</td>
            <td><?php echo $total.',00' ?></td>
            <td ></td>
        </tr>
        <?php

    $idsMens = array_unique($dadosRelatorio);
    $string_idsMens = implode("|", $idsMens);

    echo $string_idsMens;
    
    $string_ids = implode("|", $ids);

    for($i=0; $i<$qtd; $i++){
        $dados[$i] = implode('|', $dados[$i]);
    }
    
    $string_dados = implode('|', $dados);

?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js"></script>
    <script type='text/javascript'>
        function geraPDF(){
            var total = <?php echo $total ?>;
            var qtd = <?php echo $qtd ?>;
            var string_ids = "<?php echo $string_ids ?>";
            var ids = string_ids.split('|');
            var string_dados = "<?php echo $string_dados ?>";
            var dados = string_dados.split('|');
            var doc = new jsPDF({unit: 'cm'});
            doc.setFontSize(10);
            var i = 0;
            var borda1 = 1;
            var borda2 = 10;
            var dist1 = 4;
            var dist2 = 4.5;
            var dist3 = 5;
            var dist4 = 5.5;
            var dist5 = 8;
            var dist6 = 6;
            var dist7 = 6.5;
            var dist8 = 7;
            var dist9 = 7.5;
            var qt = 1;

            var id = 0;
            var nome = 1;
            var rua = 2;
            var numero = 3;
            var bairro = 4;
            var obs = 5;
            var ref = 6;
            var telefone = 7;
            var valor = 8;
            var vencimento = 9;
            var nomemens = 10;
            var nomecontr = 11;
            var cidade = 12;
            var operador = 13;

            while(i < qtd){
                if(qt==4){
                    doc.addPage('a4');
                    dist1 = 4;
                    dist2 = 4.5;
                    dist3 = 5;
                    dist4 = 5.5;
                    dist5 = 8;
                    dist6 = 6;
                    dist7 = 6.5;
                    dist8 = 7;
                    dist9 = 7.5;
                    qt=1;
                }
                doc.text(borda1, dist1, 'Nome: '+dados[nome]);
                doc.text(borda1, dist2, 'Endereço: '+dados[rua]+', '+dados[numero]);
                doc.text(borda1, dist3, 'Bairro: '+dados[bairro]);
                doc.text(borda1, dist4, 'Cidade: '+dados[cidade]);
                doc.text(borda1, dist6, 'Observação: '+dados[obs]);
                doc.text(borda1, dist7, 'Telefone: '+dados[telefone]);
                doc.text(borda1, dist8, 'Valor: '+dados[valor]);
                doc.text(borda1, dist9, 'Vencimento: '+dados[vencimento]);
                doc.text(borda2, dist1, 'Nome: '+dados[nome]);
                doc.text(borda2, dist2, 'Endereço:  '+dados[rua]+', '+dados[numero]);
                doc.text(borda2, dist3, 'Referência: '+dados[ref]);
                doc.text(borda2, dist4, 'Observação: '+dados[obs]);
                doc.text(borda2, dist6, 'Telefone: '+dados[telefone]);
                doc.text(borda2, dist7, 'Valor: '+dados[valor]);
                doc.text(borda2, dist8, 'Vencimento: '+dados[vencimento]);
                doc.text(18, dist1, 'ID: '+dados[id]);
                doc.text(10.5, dist5, dados[nomemens]);
                doc.text(13.5, dist5, dados[nomecontr]);
                doc.text(17, dist5, dados[operador]);
                
                //quantidade de recibos por pagina
                qt += 1;

                //distancia entre os recibos
                dist1 += 9.5;
                dist2 += 9.5;
                dist3 += 9.5;
                dist4 += 9.5;
                dist5 += 9.5;
                dist6 += 9.5;
                dist7 += 9.5;
                dist8 += 9.5;
                dist9 += 9.5

                //posicao da informacao no vetor
                id += 14;
                nome += 14;
                rua += 14;
                numero += 14;
                bairro += 14;
                obs += 14;
                ref += 14;
                telefone += 14;
                valor += 14;
                vencimento += 14; 
                nomemens += 14;
                nomecontr += 14;
                operador += 14;

                //quantidade de recibos total
                i++;
            }

            window.open(doc.output('bloburl'));

            var doc2 = new jsPDF({unit: 'cm'});
            doc2.setFontSize(20);

            var source = window.document.getElementById("tabela");

            doc2.text(6, 2, 'Relatório de saída de fichas');

            doc2.autoTable({
                html: '#tabela',
                theme: 'grid',
                bodyStyles: {
                    fontSize: 7,
                    halign: 'center',
                    minCellWidth: 1,
                },
                margin: {top: 3},
            });

            window.open(doc2.output('bloburl'));

            
            //window.location.href = 'consulta/doacoesCobranca.php';
            
        }

        
    </script>
</body>
</html>
