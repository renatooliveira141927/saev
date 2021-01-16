function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var nm_disciplina = $('#nm_deficiencia').val();
        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
        	nm_deficiencia: nm_deficiencia,
            ci_deficiencia: id

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

        var nm_deficiencia     = $('#nm_deficiencia').val();

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        $.post(url_listar, {
        	nm_deficiencia: nm_deficiencia

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
            	nm_deficiencia: nm_deficiencia

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