
function populaavalicaodisponivel(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();


    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesDisponiveis',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function populaavalicao(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();


    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoes',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}
function populaavalicaoleituradisponivel(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();


    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesLeituraDisponiveis',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function populaavalicaoleitura(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();


    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesLeitura',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

