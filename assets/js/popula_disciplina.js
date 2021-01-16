
function populadisciplina(){

    var base_url  = $('#base_url').val();

    $('#cd_disciplina').attr('disabled', 'disabled');
    $('#cd_disciplina').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/disciplina/getDisciplinas',
        function (data) {
            $('#cd_disciplina').html(data);
            $('#cd_disciplina').removeAttr('disabled');
        }
    );
}
