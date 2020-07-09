$(document).ready(function(){
    $('select').formSelect();

    $('.dropdown-trigger').dropdown({
        container: document.body
    });

    $('.modal').modal();

    $('.cep').mask("00000-000");

    $('.tel').mask('(00)00000-0000');
    $('.tel').blur(function(event) {
        if ($(this).val().length == 14) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            $('.tel').mask('(00)00000-0000');
        } else {
            $('.tel').mask('(00)0000-0000');
        }
    });

    $('.exclui').hide();

    $('.altera').hide();

    $('#excl-mens').click(function() {
        $('.exclui').toggle();
    });

    $('#alter-mens').click(function() {
        $('.altera').toggle();
    });
});

function confirmaExclu(id) {
    var apagar = confirm('Deseja realmente excluir este registro?');
    if (apagar) {
        window.location.href = "../controller/excluiMens.php?id=" + id;
    } else {
        event.preventDefault();
    }
}