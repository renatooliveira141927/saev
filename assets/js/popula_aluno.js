function populaaluno(cd_turma){

    var base_url  = $('#base_url').val();
    
    var cd_turma = $('#cd_turma').val();
    
    $('#cd_aluno').attr('disabled', 'disabled');
    $('#cd_aluno').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/aluno/getAlunos',{        
        cd_turma  : cd_turma

    }, function (data) {
        $('#cd_aluno').html(data);
        $('#cd_aluno').removeAttr('disabled');
    });
}