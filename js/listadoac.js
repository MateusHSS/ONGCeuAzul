$(document).ready(function(){
    $('.dropdown-trigger').dropdown({
        container: document.body
    });

    $('select').formSelect();

    $(".editar").hide();

    $('#edita-doac').click(function(){
        $('.editar').toggle();
    });

    $('.recibo').hide();

    $('.atribui').hide();

    $('.receber').hide();

    $('.modal').modal();

    $('#top').click(function(){
        //scroll suave
        $('html, body').animate({scrollTop:0}, 'medium'); //slow, medium, fast
    })

    $('#buscar').click(function(){
        $('#loader').css('display', '');
        $('#list').css('display', 'none');
    });

    $('#novo-mens').click(function(){
        $('#mens-conteudo').load('cadastroMens.php');
    });

    $('#receb-doac').click(function(){
        $('.receber').toggle();
    });

    $('#atrib-mens').click(function(){
        $('.atribui').toggle();
    });

    $('#gera-recib').click(function(){
        $('.recibo').toggle();
    });

    $('#atribuir-mens').click(function(){
        var mens = $('#mensageiro').val();
        var url = '../controller/atribuiMens.php?mens='+mens;

        $('.checklist:checked').each(function(){
            url += '&id='+$(this).attr('id');
        });
        
        if(mens == null){
            alert('Selecione um mensageiro!');
        }else{
            window.location.href= url;
        }
    });
    
    $('#gerar-recibo').click(function(){
        var url = '../geraPDF.php?';
        $('.checklist:checked.ger-recibo').each(function(){
            url += '&id='+$(this).attr('id').replace('recibo', '');
        });
        
        window.location.href= url;
    });

    

    $(".botao").click(function(){
        var id = $(this).attr('data-id');
        var stat = $("#statusdoacao"+id).val();
        var action = $("#form-edita"+id).attr('action') +'&stat='+stat;
        $("#form-edita"+id).attr('action', action);


    });

    
});

function confirmaBaixa(id){
    window.location.href = 'controller/confirmaBaixa.php?id='+id;
}

function carregado(){
    $('#loader').css('display', 'none');
    $('#list').css('display', '');
}

