<?php
include 'config/conexao.php';

$sql3="SELECT d.*, date_format(datavencimento, '%d/%m/%Y') as vencimento, REPLACE(valor,'.',',') as 
            valor, c.*, o.*, e.*, s.*, cont.* FROM tabdoacao d, taboperador o, tabcontribuinte c, tabendereco e, tabstatus s, tabcontato cont WHERE 
            d.idcontribuintedoacao = c.idcontribuinte AND d.idoperadordoacao = o.idoperador AND 
            d.idcontribuintedoacao = e.idcontribuinteendereco AND d.doacaostatus = s.idtabstatus AND d.doacaostatus = 1 AND c.idcontribuinte = cont.idcontribuintecontato ORDER BY d.datavencimentodoacao";
            $result3=$connect->query($sql3);

            
echo "<html>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js' integrity='sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs' crossorigin='anonymous'></script>
<script type='text/javascript'>
        var doc = new jsPDF({unit: 'cm'});
            doc.setFontSize(10);";

            while($res3 = $result3->fetch_array()){
                echo"
            doc.text(0.5, 4, 'Nome: MATEUS HENRIQUE SOUZA SILVA');
            doc.text(0.5, 4.5, 'Endereço: RUA MONTE LIBANO, 121');
            doc.text(0.5, 5, 'Bairro: MANOEL VALINHAS');
            doc.text(0.5, 5.5, 'Observação: POSTE AZUL');
            doc.text(8, 4, 'Nome: MATEUS HENRIQUE SOUZA SILVA');
            doc.text(8, 4.5, 'Endereço: RUA MONTE LIBANO, 121');
            doc.text(8, 5, 'Referência: POSTE AZUL');
            doc.text(8, 5.5, 'Observação: BUSCAR DE MANHÂ');
            doc.text(9, 8, 'CONTRIBUINTE');
            doc.text(13, 8, 'MENSAGEIRO');
            doc.text(17, 8, 'USUARIO RESP.');";
            }
            echo"
            window.open(doc.output('bloburl'))
            </script>
            </html>
            ";

            ?>