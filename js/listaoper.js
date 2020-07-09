function limpa_formulario_cep() {
    // Limpa valores do formulário de cep.
    $(".rua").val("");
    $(".bairro").val("");
    $(".cidade").val("");
}

//Quando o campo cep perde o foco.
$(".cep").blur(function() {
    var id = $(this).attr('data-id');

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua"+id).val("...");
            $("#bairro"+id).val("...");
            $("#cidade"+id).val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua"+id).select();
                    $("#rua"+id).val(dados.logradouro);
                    $("#bairro"+id).select();
                    $("#bairro"+id).val(dados.bairro);
                    $("#cidade"+id).select();
                    $("#cidade"+id).val(dados.localidade);
                    $("#num"+id).select();
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulario_cep();
                    alert("CEP não encontrado.");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulario_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulario_cep();
    }
});

$(document).ready(function(){
    $('select').formSelect();

    $('.val').mask('#.##0,00', {reverse: true});
            
    $('.venc').mask('00/00');
    
    $('.cep').mask("00000-000");

    $('.tel').mask('(00)00000-0000');
    $('.tel').blur(function(event) {
        if ($(this).val().length == 14) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            $('.tel').mask('(00)00000-0000');
        } else {
            $('.tel').mask('(00)0000-0000');
        }
    });

    $('.botao').click(function (){
                
        var id = $(this).attr('id');
        var user = $('#user'+id).val();
        var perfil = $('#perfil'+id).val();
        var url = '../controller/atualUser.php?id='+id+'&user='+user+'&perfil='+perfil;
        if($('#ativo'+id).is(':checked')){
            var ativo = 1;
        }else{
            var ativo = 0;
        }

        url += '&ativo='+ativo;

        if($('#operador'+id).is(':checked')){
            var operador = 1;
            var idoper = $('#idoper'+id).val();

            url += '&operador='+operador+'&idoper='+idoper;
        }else{
            var operador = 0;
            url += '&operador='+operador;
        }

        
        if($('#pass'+id).val() != ''){
            if($('#pass'+id).val() == $('#confirmPass'+id).val()){
                var senha = $('#pass'+id).val();
                url += '&senha='+senha;

                window.location.href = url;
            }else{
                alert('As senhas nao coincidem!!');
            }
        }else{
            window.location.href = url;
        }
        
        
    });

    $('#top').click(function(){
        //scroll suave
        $('html, body').animate({scrollTop:0}, 'medium'); //slow, medium, fast
    });

    $('.nova-doacao').hide();

    $('.exclui').hide();

    $('.altera').hide();

    $('.modal').modal();

    $('#novo-contr').click(function() {
        $('#contr-conteudo').load('cadastro/cadastroContr.php');
    });

    $('#nova-doacao').click(function() {
        $('.nova-doacao').toggle();
    });

    $('#excl-oper').click(function() {
        $('.exclui').toggle();
    });

    $('#alter-oper').click(function() {
        $('.altera').toggle();
    });

    $('.dropdown-trigger').dropdown({
        container: document.body
    });

    $("#operador").click(function(e) { 
        if($(this).is(':checked')) { //Retornar true ou false 
            $('#idOper').show(); // CheckBox marcado
            $('#idOp').attr('required', 'required');
        } else {
            $('#idOper').hide();
            $('#idOp').removeAttr('required');
        }
    }); 
});

function dale(id) {
    $('#form' + id).submit();
}

function confirmaExclu(id) {
    var apagar = confirm('Deseja realmente excluir este registro?');
    if (apagar) {
        window.location.href = "../controller/excluiOper.php?id=" + id;
    } else {
        event.preventDefault();
    }
}