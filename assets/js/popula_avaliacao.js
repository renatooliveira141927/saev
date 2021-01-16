
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
    var cd_cidade = $('#cd_cidade').val();
    var nr_anoletivo = $('#nr_anoletivo').val();
    
    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoes',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina,cd_cidade:cd_cidade, nr_anoletivo: nr_anoletivo
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function populaavalicaoescola(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();
    var cd_escola = $('#cd_escola').val();

    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesDisponiveis',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina,cd_escola:cd_escola
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

function populaavalicaoleituradisponivelcidade(){
	var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();
    var cd_cidade = $('#cd_cidade').val(); 
    var nr_anoletivo = $('#nr_anoletivo').val();

    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesLeituraDisponiveisCidade',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina,cd_cidade:cd_cidade
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function populaavalicaoleitura(){

    var base_url  = $('#base_url').val();
    var cd_etapa = $('#cd_etapa').val();
    var cd_disciplina = $('#cd_disciplina').val();
    var cd_cidade = $('#cd_cidade').val();
    var nr_anoletivo = $('#nr_anoletivo').val();    
    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesLeitura',{
        cd_etapa : cd_etapa,cd_disciplina : cd_disciplina,cd_cidade:cd_cidade, nr_anoletivo:nr_anoletivo
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function populaavalicaoano(){
		var base_url  = $('#base_url').val();
	    var ano = $('#cd_ano').val();
	    
	    $('#cd_avaliacao').attr('disabled', 'disabled');
	    $('#cd_avaliacao').html("<option>Carregando.....</option>");

	    $.post(base_url+'ajax/avaliacao/getAvaliacoesAno',{
	        ano : ano
	    }, function (data) {
	        $('#cd_avaliacao').html(data);
	        $('#cd_avaliacao').removeAttr('disabled');
	    });
}

function populaavalicaoleituraano(){
	var base_url  = $('#base_url').val();
    var ano = $('#cd_ano').val();
    
    $('#cd_avaliacao').attr('disabled', 'disabled');
    $('#cd_avaliacao').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/avaliacao/getAvaliacoesLeituraAno',{
        ano : ano
    }, function (data) {
        $('#cd_avaliacao').html(data);
        $('#cd_avaliacao').removeAttr('disabled');
    });
}

function buscaencerramentomunicipio(){
    var base_url  = $('#base_url').val();
    var municipio = $('#cd_cidade').val();
    var avaliacao = $('#cd_avaliacao').val();
    $('.btn').attr('disabled','disabled');
    $('#dataLimite').val('');

    $.post(base_url+'ajax/avaliacao/getDataAvaliacaoMunicipio',{
        municipio : municipio,
        avaliacao:avaliacao
    }, function (data) {
        for(var i=0; i<data.length; i++){                        
            $('#dataLimite').val(data[i].final);            
            if(data[i].bloqueia=='t'){
                $('.btn').attr('disabled','disabled');
            }else{
                $('.btn').removeAttr('disabled');
            }            
        }    
    });

}
