
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

        }, function (data) {
            $('#listagem_resultado').html(data);
        });

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        $('#carregando').show();
        var nr_inep_aluno   = $('#nr_inep_aluno').val();
        var nm_aluno        = $('#nm_aluno').val();
        var cd_escola       = $('#cd_escola').val();
        var nr_inep_escola  = $('#nr_inep_escola').val();
        var nm_escola       = $('#nm_escola').val();
        var cd_cidade       = $('#cd_cidade').val();
        var cd_turma        = $('#cd_turma').val();
        var cd_etapa        = $('#cd_etapa').val();
        var cd_turno        = $('#cd_turno').val();
        var nr_anoletivo    = $('#nr_anoletivo').val();

        var url_listar      = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_aluno='+nm_aluno+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nr_inep_aluno   : nr_inep_aluno,
            nm_aluno        : nm_aluno,
            cd_escola       : cd_escola,
            nr_inep_escola  : nr_inep_escola,
            nm_escola       : nm_escola,
            cd_cidade       : cd_cidade,
            cd_turma        : cd_turma,
            cd_etapa        : cd_etapa,
            cd_turno        : cd_turno,
            nr_anoletivo    : nr_anoletivo

        }, function (data) {
            $('#listagem_resultado').html(data);
            $('#carregando').hide();
        });

        
    });

});
