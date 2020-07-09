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

    $('.botao').click(function() {
        var id = $(this).attr('id');
        var categoria = $('#tipo-contr'+id).val();
        var action = $("#gera-doacao"+id).attr('action');

        action += '&tipo-contribuinte='+categoria;

        $("#gera-doacao"+id).attr('action', action);


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

    $('#excl-contr').click(function() {
        $('.exclui').toggle();
    });

    $('#alter-contr').click(function() {
        $('.altera').toggle();
    });

    $('.dropdown-trigger').dropdown({
        container: document.body
    });
});

function dale(id) {
    $('#form' + id).submit();
}

function confirmaExclu(id) {
    var apagar = confirm('Deseja realmente excluir este registro?');
    if (apagar) {
        window.location.href = "../controller/excluiContr.php?id=" + id;
    } else {
        event.preventDefault();
    }
}

function carregado(){
    $('#loader').css('display', 'none');
    $('#list').css('display', '');
}