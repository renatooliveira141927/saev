
function populaprofessor(id, obj_id, obj_nome){

    var base_url  = $('#base_url').val();

    obj_id.val('');
    obj_nome.val("Carregando...");

    $.post(base_url+'ajax/professor/getProfessores',{
        nr_cpf : id

    }, function (data) {
        professor = data.split('|');
        obj_id.val(professor[0]);
        obj_nome.val(professor[1]);
    });
}
