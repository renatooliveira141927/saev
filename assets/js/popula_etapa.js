function populaetapaedicaodisciplina(){

    var base_url = $('#base_url').val();  
    var cd_disciplina = $('#cd_disciplina').val();
    var cd_edicao = $('#cd_edicao').val();

    $('#cd_etapa').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/etapa/getEtapaEdicaoDisciplina',{
    	cd_disciplina : cd_disciplina,
    	cd_edicao : cd_edicao
    }, function (data) {
        $('#cd_etapa').html(data);
    });
}