
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var nm_disciplina = $('#nm_disciplina').val();
        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            nm_disciplina: nm_disciplina,
            ci_disciplina: id

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

        var nm_disciplina     = $('#nm_disciplina').val();

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_disciplina='+nm_disciplina+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_disciplina: nm_disciplina

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
                nm_disciplina: nm_disciplina

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
