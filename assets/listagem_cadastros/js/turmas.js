
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {
                
        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id  : id

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
        });
        document.getElementById("img_carregando").style.display = "none";

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        var ci_turma        = $('#ci_turma').val();
        var nm_turma        = $('#nm_turma').val();
        var cd_edicao       = $('#cd_edicao').val();
        var cd_etapa        = $('#cd_etapa').val();
        var cd_turno        = $('#cd_turno').val();
        var cd_professor    = $('#cd_professor').val();
        var dt_associa_prof = $('#dt_associa_prof').val();

        var url_listar              = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ci_turma        : ci_turma,
            nm_turma        : nm_turma,
            cd_edicao       : cd_edicao,
            cd_etapa        : cd_etapa,
            cd_turno        : cd_turno,
            cd_professor    : cd_professor,
            dt_associa_prof : dt_associa_prof

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }            
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                ci_turma        : ci_turma,
                nm_turma        : nm_turma,
                cd_edicao       : cd_edicao,
                cd_etapa        : cd_etapa,
                cd_turno        : cd_turno,
                cd_professor    : cd_professor,
                dt_associa_prof : dt_associa_prof

            }, function (data) {                
                if (data == 'sessaooff'){
                    window.location.href = $('#url_base').val();
                }else{
                    $('#listagem_resultado').html(data);
                }
            });

        });
      //  document.getElementById("img_carregando").style.display = "none";
    });

});
