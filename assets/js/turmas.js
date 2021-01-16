
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

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();
        $('#carregando').show();
        
        var ci_turma        = $('#ci_turma').val();
        var nm_turma        = $('#nm_turma').val();
        var nr_ano_letivo   = $('#nr_ano_letivo').val();
        
        var cd_etapa        = $('#cd_etapa').val();
        var cd_turno        = $('#cd_turno').val();
        var cd_professor    = $('#cd_professor').val();
        var dt_associa_prof = $('#dt_associa_prof').val();
        var cd_escola       = $('#cd_escola').val();
        var cd_cidade_sme   = $('#cd_cidade_sme').val();

        var url_listar              = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ci_turma        : ci_turma,
            nm_turma        : nm_turma,
            nr_ano_letivo   : nr_ano_letivo,
            cd_etapa        : cd_etapa,
            cd_turno        : cd_turno,
            cd_professor    : cd_professor,
            dt_associa_prof : dt_associa_prof,
            cd_escola       : cd_escola,
            cd_cidade_sme   :cd_cidade_sme

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
                ci_turma        : ci_turma,
                nm_turma        : nm_turma,
                nr_ano_letivo   : nr_ano_letivo,
                cd_etapa        : cd_etapa,
                cd_turno        : cd_turno,
                cd_professor    : cd_professor,
                dt_associa_prof : dt_associa_prof,
                cd_escola       : cd_escola

            }, function (data) {                
                if (data == 'sessaooff'){
                    window.location.href = $('#url_base').val();
                }else{
                    $('#listagem_resultado').html(data);
                }
                $('#carregando').hide();
            });

        });
      //  document.getElementById("img_carregando").style.display = "none";
    });

});
