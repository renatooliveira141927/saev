
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
        });

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        $('#carregando').show();
        var nm_edicao   = $('#nm_edicao').val();
        var url_listar  = $('#url_base').val()+'/listagem_consulta';

        $.post(url_listar, {
            nm_edicao       : nm_edicao

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
            $('#carregando').hide();
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                nm_edicao       : nm_edicao

            }, function (data) {                
                if (data == 'sessaooff'){
                    window.location.href = $('#url_base').val();
                }else{
                    $('#listagem_resultado').html(data);
                }
                $('#carregando').hide();
            });

        });
    });

});
