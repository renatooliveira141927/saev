
function populaturma(id, id_escola, cd_turma){

    var base_url  = $('#base_url').val();
    
    var cd_etapa = $('#cd_etapa_'+id).val();

    $('#cd_turma').attr('disabled', 'disabled');
    $('#cd_turma').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/turma/getTurmas',{
        cd_etapa  : cd_etapa,
        cd_escola : id_escola,
        cd_turma  : cd_turma

    }, function (data) {
        $('#cd_turma').html(data);
        $('#cd_turma').removeAttr('disabled');
    });
}

function populaturmaescola(id,ano){

    var base_url  = $('#base_url').val();

    var cd_etapa = id;
    var cd_escola = $('#cd_escola').val();
    var anoletivo = ano;
    $('#cd_turma').attr('disabled', 'disabled');
    $('#cd_turma').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/turma/getTurmasEscola',{
        cd_escola:cd_escola,cd_etapa : cd_etapa, nr_anoletivo: ano
    }, function (data) {
        $('#cd_turma').html(data);
        $('#cd_turma').removeAttr('disabled');
    });
}

function populaturmaescolaano(id){

    var base_url  = $('#base_url').val();

    var cd_etapa = id;
    var cd_escola = $('#cd_escola').val();

    $('#cd_turma').attr('disabled', 'disabled');
    $('#cd_turma').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/turma/getTurmasEscolaAnoLetivo',{
        cd_escola:cd_escola,cd_etapa : cd_etapa
    }, function (data) {
        $('#cd_turma').html(data);
        $('#cd_turma').removeAttr('disabled');
    });
}

function populaturmaescolaofertaano(id){

    var base_url  = $('#base_url').val();

    var cd_etapa = $('#cd_etapa').val();
    var cd_escola = $('#cd_escola').val();

    $('#cd_turma').attr('disabled', 'disabled');
    $('#cd_turma').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/turma/getTurmasEscolaAnoLetivo',{
        cd_escola:cd_escola,cd_etapa : cd_etapa
    }, function (data) {
        $('#cd_turma').html(data);
        $('#cd_turma').removeAttr('disabled');
    });
}

function populaturmaanoletivo(id, id_escola, cd_turma,nr_anoletivo){

    var base_url  = $('#base_url').val();
    
    var cd_etapa = $('#cd_etapa_'+id).val();

    $('#cd_turma').attr('disabled', 'disabled');
    $('#cd_turma').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/turma/getTurmasporAnoletivo',{
        cd_etapa  : cd_etapa,
        cd_escola : id_escola,
        cd_turma  : cd_turma,
        nr_anoletivo:nr_anoletivo

    }, function (data) {
        $('#cd_turma').html(data);
        $('#cd_turma').removeAttr('disabled');
    });
}