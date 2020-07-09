<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        
?>
<html>

<head>
<title>ONG Céu Azul - Administrador</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
  </head>
</head>

<body>
    <div class="navbar-fixed">
        <nav class='blue lighten-2'>
            <div class="nav-wrapper">
                <div class='container'>
                    <a href="#" class="brand-logo"><img src="../img/ceuAzulLogo.png" style='width: 13%;'></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="row">
        <div class='col s2 sidenav sidenav-fixed z-depth-2 no-padding' style="height: 100vh;top: 11%;">
            <ul class="center">
                <li>
                    <div>
                        <ul>
                            <li>
                                <div class='row center'>
                                    <a href="listausers.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='user'>Usuário</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listaopers.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='oper'>Operador</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listamens.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='mens'>Mensageiro</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listacontrs.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='contr'>Contribuinte</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="listadoac.php" class="btn blue lighten-2" style="width:55%;height:5%"
                                        id='doac'>Doações</a>
                                </div>
                            </li>
                            <li>
                                <div class='row center'>
                                    <a href="relatorioComissao.php" class="btn blue lighten-2"
                                        style="width:55%;height:5%" id='relat'>Relatório</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class='col l10 offset-l2' id='conteudo'>
            <div class="row">
                <div class="col l10">
                    <div class="row">
                        <div class="col l12" id='lista-operadores'>
                            <table class="centered striped responsive-table card">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th class="gerar">Gerar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    include_once 'config/conexao.php';

                                $sql2="SELECT o.*, e.*, cont.* FROM taboperador o, tabendereco e, tabcontato cont WHERE 
                                e.idoperadorendereco = o.idoperador AND cont.idoperadorcontato = o.idoperador ";
                                $result2=$connect->query($sql2);
                                while($res2 = $result2->fetch_array()){
                                    ?>
                                        <td><?php echo $res2['idoperador'] ?></td>
                                        <td><?php echo $res2['nomeoperador'] ?></td>
                                        <td><?php echo $res2['emailoperador'] ?></td>
                                        <td><?php echo $res2['telefone'] ?></td>
                                        <td class='gerar'><a href='#relatorio<?php echo $res2['idoperador'] ?>' class='modal-trigger'><i class='material-icons green-text'>picture_as_pdf</i></a></td>
                                    </tr>

                                    <div class='modal' id='relatorio<?php echo $res2['idoperador'] ?>'>
                                        <div class='modal-content'>
                                            <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                            <h4>Selecionar período</h4>
                                            <div class='divider'></div>
                                            <div class='row'>
                                                <div class="container center">
                                                    <form action="#" class='col l12 center'>
                                                        <div class="input-field col l6">
                                                            <i class="material-icons prefix">event</i>
                                                            <label for="data-inicio<?php echo $res2['idoperador'] ?>">Inicio:</label>
                                                            <input id="data-inicio<?php echo $res2['idoperador'] ?>" name="data-inicio" type="text" class="datepicker">
                                                        </div>
                                                        <div class="input-field col l6">
                                                            <i class="material-icons prefix">event</i>
                                                            <label for="data-fim<?php echo $res2['idoperador'] ?>">Fim:</label>
                                                            <input id="data-fim<?php echo $res2['idoperador'] ?>" name="data-fim" type="text" class="datepicker">
                                                        </div>
                                                        <div class='btn blue lighten-2 botao' type='submit' name='action' onclick='geraRelatorio(<?php echo $res2["idoperador"] ?>)'>Confirmar
                                                            <i class='material-icons right'>check</i>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').material_select();
            $('.modal').modal();
            $('.datepicker').datepicker({
                i18n: {
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                        'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                    ],
                    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out',
                        'Nov', 'Dez'
                    ],
                    weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
                    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                    today: 'Hoje',
                    clear: 'Limpar',
                    cancel: 'Sair',
                    done: 'Confirmar',
                    labelMonthNext: 'Próximo mês',
                    labelMonthPrev: 'Mês anterior',
                    labelMonthSelect: 'Selecione um mês',
                    labelYearSelect: 'Selecione um ano',
                    selectMonths: true,
                    selectYears: 15,
                },
                format: 'dd/mm/yyyy',
                container: 'body',
                maxDate: new Date(),
            });
        });

        function geraRelatorio(id){
            var dt_in = $('#data-inicio'+id).val();
            var dt_fim = $('#data-fim'+id).val();
            window.location.href = 'geraRelatorio.php?id='+id+'&dtin='+dt_in+'&dtfim='+dt_fim;
        }

        function geraPDF(id){
            var qtd = ids.length;
            var doc = new jsPDF({unit: 'cm'});
            doc.setFontSize(10);
            var i = 0;
            var dist1 = 4;
            var dist2 = 4.5;
            var dist3 = 5;
            var dist4 = 5.5;
            var dist5 = 8;
            var dist6 = 6;
            var dist7 = 6.5;
            var dist8 = 7;
            var qt = 1;
            while(i < qtd){
                if(qt==4){
                    doc.addPage('a4');
                    dist1 = 4;
                    dist2 = 4.5;
                    dist3 = 5;
                    dist4 = 5.5;
                    dist5 = 8;
                    dist6 = 6;
                    qt=1;
                }
                <?php
            $id = "<script>ids[i]</script>";
            $sql3="SELECT d.*, date_format(datavencimentodoacao, '%d/%m/%Y') as vencimento, REPLACE(valordoacao,'.',',') as 
            valor, c.*, o.*, e.*, s.*, cont.*, m.*, SUBSTRING_INDEX(SUBSTRING_INDEX(nomemensageiro, ' ', 1), ' ', -1)  AS nomemensageiro, SUBSTRING_INDEX(SUBSTRING_INDEX(nomecontribuinte, ' ', 1), ' ', -1)  AS pnomecontribuinte FROM tabdoacao d, taboperador o, tabcontribuinte c, tabendereco e, tabstatus s, tabcontato cont, tabmensageiro m WHERE 
            d.idcontribuintedoacao = c.idcontribuinte AND d.idoperadordoacao = o.idoperador AND 
            d.idcontribuintedoacao = e.idcontribuinteendereco AND d.doacaostatus = s.idtabstatus AND d.doacaostatus = '$id' AND c.idcontribuinte = cont.idcontribuintecontato AND m.idmensageiro = d.idmensageirodoacao ORDER BY d.datavencimentodoacao";
            $result3=$connect->query($sql3);
            while($res3 = $result3->fetch_array()){
               ?>
                doc.text(1, dist1, 'Nome: <?php echo $res3['nomecontribuinte'] ?>');
                doc.text(1, dist2, 'Endereço: <?php echo $res3['rua'].", ".$res3['numero'] ?>');
                doc.text(1, dist3, 'Bairro: <?php echo $res3['bairro'] ?>');
                doc.text(1, dist4, 'Observação: <?php echo $res3['obs'] ?>');
                doc.text(1, dist6, 'Telefone: <?php echo $res3['telefone'] ?>');
                doc.text(1, dist7, 'Valor: <?php echo $res3['valor'] ?>');
                doc.text(1, dist8, 'Vencimento: <?php echo $res3['vencimento'] ?>');
                doc.text(9, dist1, 'Nome: <?php echo $res3['nomecontribuinte'] ?>');
                doc.text(9, dist2, 'Endereço: <?php echo $res3['rua'].", ".$res3['numero'] ?> ');
                doc.text(9, dist3, 'Referência: <?php echo $res3['referencia'] ?>');
                doc.text(9, dist4, 'Observação: <?php echo $res3['obs'] ?>');
                doc.text(9, dist6, 'Telefone: <?php echo $res3['telefone'] ?>');
                doc.text(9, dist7, 'Valor: <?php echo $res3['valor'] ?>');
                doc.text(9, dist8, 'Vencimento: <?php echo $res3['vencimento'] ?>');
                doc.text(10.5, dist5, '<?php echo $res3['pnomecontribuinte'] ?>');
                doc.text(13.5, dist5, '<?php echo $res3['nomemensageiro'] ?>');
                doc.text(16, dist5, 'USUARIO RESP.');
                
                <?php
                
            }
            ?>
                qt += 1;
                dist1 += 9.5;
                dist2 += 9.5;
                dist3 += 9.5;
                dist4 += 9.5;
                dist5 += 9.5;
                dist6 += 9.5;
                dist7 += 9.5;
                dist8 += 9.5;
                i++;
            }

            window.open(doc.output('bloburl'))
            
        }
    </script>
    <script src='../js/listadoac.js'></script>
</body>

</html>
<?php
    }
?>