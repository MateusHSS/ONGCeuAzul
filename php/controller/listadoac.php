<?php
    session_start();
    if($_SESSION['perfil']!=1){
        header('location:../index.php');
    }else{
        include_once 'config/conexao.php';
        $sql2="SELECT tabdoacao.iddoacao, tabendereco.cidade, tabendereco.bairro, tabendereco.rua, tabendereco.numero, tabcontribuinte.nomecontribuinte, REPLACE(tabdoacao.valordoacao,'.',',') AS valor, 
        date_format(tabdoacao.datavencimentodoacao, '%d/%m/%Y') AS vencimento, tabmensageiro.nomemensageiro, tabmensageiro.idmensageiro, tabstatus.nomestatus, taboperador.nomeoperador
            from tabdoacao 
        INNER JOIN taboperador ON tabdoacao.idoperadordoacao = taboperador.idoperador
        INNER JOIN tabcontribuinte ON tabdoacao.idcontribuintedoacao = tabcontribuinte.idcontribuinte
        INNER JOIN tabendereco ON tabendereco.idcontribuinteendereco = tabcontribuinte.idcontribuinte
        INNER JOIN tabmensageiro ON tabdoacao.idmensageirodoacao = tabmensageiro.idmensageiro
        INNER JOIN tabstatus ON tabstatus.idtabstatus = tabdoacao.doacaostatus
        WHERE tabdoacao.doacaostatus != 3
        ORDER BY tabdoacao.datavencimentodoacao LIMIT 100";
        $result2=$connect->query($sql2);
?>
<html>

<head>
    <title>ONG Céu Azul - Administrador</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Compiled and minified CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" integrity="sha256-U/cHDMTIHCeMcvehBv1xQ052bPSbJtbuiw4QA9cTKz0=" crossorigin="anonymous"></script>

    <!-- Compiled and minified JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" integrity="sha256-OweaP/Ic6rsV+lysfyS4h+LM6sRwuO3euTYfr6M124g=" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        .recibo{
            display: none;
        }
        .atribui{
            display: none;
        }
        .receber{
            display: none;
        }
        .editar{
            display: none;
        }
    </style>
    <script>
            $(document).ready(function() {
                //BUSCA DE DOADORES PELO NOME
                $('#doacao').keyup(function() {

                    $('#buscaContr').submit(function() {

                        var dados = $(this).serialize();

                        $.ajax({

                            url: 'controller/buscaDoacao.php',
                            type: 'POST',
                            dataType: 'html',
                            data: dados,
                            success: function(data) {

                                $('#lista-doacoes').empty().html(data);
                                $('.atribui').hide();
                                $('.receber').hide();
                                $('.recibo').hide();
                            }
                        });

                        return false;

                    });

                    $('#buscaContr').trigger('submit');

                });

            })
        </script>
</head>

<body onload='carregado()'>
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
                        <div class="col l6">
                            <form action="#" id='buscaContr'>
                                <div class="input-field col l6">
                                    <input id="doacao" type="text" class="validate" name='doacao'>
                                    <label for="doacao">Busca</label>
                                </div>
                                <div class="input-field col l6">
                                    <select id='filtroStat'>
                                    
                                    <optgroup label="Status">
                                        <option class='filtro' value="aberto">Em aberto</option>
                                        <option class='filtro' value="indeferido">Indeferido</option>
                                        <option class='filtro' value="naocontr">Não contribuiu</option>
                                        <option class='filtro' value="cobranca">Em cobrança</option>
                                        <option class='filtro' value="quitado">Quitado</option>
                                    </optgroup>
                                    
                                    <optgroup label='Mensageiro'>
                                        <?php
                                        include 'config/conexao.php';
                                        $sql = 'SELECT * FROM tabmensageiro WHERE idmensageiro != 0';
                                        $result=$connect->query($sql);
                                        while($res = $result->fetch_array()){
                                            ?>
                                            <option class='filtro' id='filtroMens' value='mens<?php echo $res['idmensageiro'] ?>'><?php echo $res['nomemensageiro'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </optgroup>
                                    
                                        <option value="todos" selected>Todos</option>
                                    </select>
                                    <label>Filtrar por:</label>
                                </div>
                            </form>
                        </div>
                        <div class="col l4 atribui">
                            <select id='mensageiro'>
                                <option value="" disabled selected>Mensageiro</option>
                                <?php
                                include 'config/conexao.php';
                                $sql = 'SELECT * FROM tabmensageiro WHERE idmensageiro != 0';
                                $result=$connect->query($sql);
                                while($res = $result->fetch_array()){
                                    ?>
                                    <option value='<?php echo $res['idmensageiro'] ?>'><?php echo $res['nomemensageiro'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <label>Materialize Select</label>
                        </div>
                        <div class="col l2 recibo">
                            <button class='btn blue lighten-2' id='gerar-recibo'>Imprimir</button>
                        </div>
                        <a class="btn blue lighten-2 card atribui" href="#" id='atribuir-mens'>Salvar</a>
                    </div>
                    <div class="row">
                        <div class="col l12 center" id='lista-doacoes'>
                            <div id="loader">
                                <div class="progress">
                                    <div class="indeterminate" style="width: 70%"></div>
                                </div>
                                <span>Carregando registros...</span>
                            </div>
                            <table class="centered striped responsive-table card" id='list' style='display: none;'>
                                <thead>
                                    <tr>
                                        <th class='recibo'>Recibo</th>
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
                                        <th class='editar'>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                while($res2 = $result2->fetch_array()){
                                    switch($res2['nomestatus']){
                                        case "<p style='color: green'>Quitado</p>":
                                            echo '<tr class="filtro quitado mens'.$res2['idmensageiro'].'">';
                                        break;
                                        case "<p style='color: orange'>Em cobrança</p>":
                                            echo '<tr class="filtro cobranca mens'.$res2['idmensageiro'].'">';
                                        break;
                                        case "<p style='color: red'>Em aberto</p>":
                                            echo '<tr class="filtro aberto mens'.$res2['idmensageiro'].'">';
                                        break;
                                        case "<p style='color: brow'>Não contribuiu</p>":
                                            echo '<tr class="filtro naocontr mens'.$res2['idmensageiro'].'">';
                                        break;
                                        case "<p style='color: grey'>Indeferido</p>":
                                            echo '<tr class="filtro indeferido mens'.$res2['idmensageiro'].'">';
                                        break;
                                    }
                                    ?>
                                        <td class='recibo'>
                                            <p>
                                                <label>
                                                    <input class='checklist ger-recibo' type='checkbox' id="recibo<?php echo $res2['iddoacao'] ?>"/>
                                                    <span></span>
                                                </label>
                                            </p>
                                        </td>
                                        <td class='atribui'>
                                            <p>
                                                <label>
                                                    <input class='checklist' type='checkbox' id='<?php echo $res2['iddoacao'] ?>'/>
                                                    <span></span>
                                                </label>
                                            </p>
                                        </td>
                                        <td><?php echo $res2['iddoacao'] ?></td>
                                        <td><?php echo $res2['cidade'] ?></td>
                                        <td><?php echo $res2['bairro'] ?></td>
                                        <td><?php echo $res2['nomecontribuinte'] ?></td>
                                        <td><?php echo $res2['valor'] ?></td>
                                        <td><?php echo $res2['vencimento'] ?></td>
                                        <td><?php echo $res2['nomemensageiro'] ?></td>
                                        <td id='status<?php echo $res2['iddoacao'] ?>'><?php echo $res2['nomestatus'] ?></td>
                                        <td><?php echo $res2['nomeoperador'] ?></td>
                                        <td class='receber'><a href='#recebe<?php echo $res2['iddoacao'] ?>' class='modal-trigger'><i class='material-icons green-text'>save_alt</i></a></td>
                                        <td class='editar'><a href='#edita<?php echo $res2['iddoacao'] ?>'
                                        class='modal-trigger'><i class='material-icons purple-text'>create</i></a></td>
                                    </tr>

                                    <div class='modal' id='recebe<?php echo $res2['iddoacao'] ?>'>
                                        <div class='modal-content'>
                                            <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                            <h4>Receber</h4>
                                            <div class='divider'></div>
                                            <div class='row'>
                                                <div class='col l6 left'>
                                                    <p><strong>Ref: </strong><?php echo $res2['iddoacao'] ?></p>
                                                    <p><strong>Contribuinte: </strong><?php echo $res2['nomecontribuinte'] ?></p>
                                                    <p><strong>Valor: </strong><?php echo $res2['valor'] ?></p>
                                                    <p><strong>Vencimento: </strong><?php echo $res2['vencimento'] ?></p>
                                                </div>
                                                <div class='col l6 left'>
                                                    <p><strong>Endereco: </strong><?php echo $res2['rua'].', '.$res2['numero'] ?></p>
                                                    <p><strong>Bairro: </strong><?php echo $res2['bairro'] ?></p>
                                                    <p><strong>Cidade: </strong><?php echo $res2['cidade'] ?></p>
                                                    <div class='divider'></div>
                                                    <p><strong>Operador: </strong><?php echo $res2['nomeoperador'] ?></p>
                                                    <p><strong>Mensageiro: </strong><?php echo $res2['nomemensageiro'] ?></p>
                                                </div>
                                            </div>
                                            <div class='center'>
                                                <div class='btn blue lighten-2 oi' type='submit' name='action' id='<?php echo $res2['iddoacao'] ?>'>Confirmar
                                                    <i class='material-icons right'>check</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='modal' id='edita<?php echo $res2['iddoacao'] ?>'>
                                        <div class='modal-content'>
                                            <div class='row right'><i class='material-icons modal-close'>close</i></div>
                                            <h4>Editar doação</h4>
                                            <div class='divider'></div>
                                            <form action="controller/editaDoacao.php?iddoacao=<?php echo $res2['iddoacao'] ?>" method="post" id='form-edita<?php echo $res2['iddoacao'] ?>'>
                                                <div class='row'>
                                                    <div class="input-field col l3">
                                                        <input id="val<?php echo $res2['iddoacao'] ?>" type="text" class="validate" name='val' value='<?php echo $res2['valor'] ?>' required>
                                                        <label for="val<?php echo $res2['iddoacao'] ?>">Valor</label>
                                                    </div>
                                                    <div class="input-field col l3">
                                                        <input id="venc<?php echo $res2['iddoacao'] ?>" type="text" class="validate" name='venc' value='<?php echo $res2['vencimento'] ?>' required>
                                                        <label for="venc<?php echo $res2['iddoacao'] ?>">Valor</label>
                                                    </div>
                                                    <div class="input-field col l6">
                                                        <select id='statusdoacao<?php echo $res2['iddoacao'] ?>'>
                                                        <option value="<?php echo $res2['doacaostatus'] ?>" selected><?php echo $res2['nomestatus'] ?></option>
                                                        <?php

                                                            include_once '../config/conexao.php';

                                                            $sql = $connect->prepare("SELECT * FROM tabstatus ORDER BY nomestatus ASC");
                                                            $sql->execute();

                                                            $result = $sql->get_result();

                                                            while($row = $result->fetch_assoc()) {
                                                        ?>

                                                        <option value="<?php echo $row['idtabstatus'] ?>"><?php echo $row['nomestatus'] ?></option>
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                                        </select>
                                                        <label>Status</label>
                                                    </div>
                                                </div>
                                                <div class='center'>
                                                    <button class='btn blue lighten-2 botao' data-id='<?php echo $res2['iddoacao'] ?>' type='submit'>Confirmar
                                                        <i class='material-icons right'>check</i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
				<tr id='carregar'>
                                    <td colspan='13'><a href='#!' class='mais' onclick="carrega()">Carregar mais...</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col l2">
                    <a class="btn blue lighten-2 card" href="#" id='atrib-mens' style='width: 90%;'>Atribui mens.</a>
                    <a class="btn blue lighten-2 card" href="#" id='gera-recib' style='width: 90%;' >Gerar recibo</a>
                    <a class="btn blue lighten-2 card" href="#" id='receb-doac' style='width: 90%;'>Receber</a>
                    <a class="btn blue lighten-2 card" href="#" id='edita-doac' style='width: 90%;'>Editar</a>
                </div>
            </div>

            <div class="modal" id="modal-mens">
                <div class="modal-content">
                    <div class="row right"><i class="material-icons modal-close">close</i></div>
                    <h4>Novo mensageiro</h4>
                    <div id="mens-conteudo">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script type='text/javascript'>
        function geraPDF(ids){
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
    <script>
        $(document).ready(function(){
            $('.oi').click(function(){
                var id = $(this).attr('id');

                $.ajax({

                    url: 'controller/confirmaBaixa.php?id='+id,
                    type: 'POST',
                    dataType: 'html',
                    success: function(data) {
                        alert('Baixa confirmada!');

                        $('#status'+id).text('Quitado');
                    }
                });

                return false;
            })
        })

	function carrega(){
            var inicio = $("tbody tr").length-1;

            $.ajax({

                url: 'php/controller/carregaDoacoes.php',
                type: 'POST',
                dataType: 'html',
                data: {inicio : inicio},
                success: function(data) {
                    $('#list').append(data);
                    $('#carregar').remove();
                    $('#list').append("<tr id='carregar'><td colspan='13'><a href='#!' class='mais' onclick='carrega()'>Carregar mais...</a></td></tr>");
                
                    
                }
            });

            return false;
	}
    </script>
</body>

</html>
<?php
    }
?>