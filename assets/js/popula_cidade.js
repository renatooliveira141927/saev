
function populacidade(cd_estado, nm_cidade, sg_estado, exibir_cabecario, obj_cidade, obj_apagar_options){

    var base_url  = $('#base_url').val();  
    var id_estado = cd_estado;
    if (obj_apagar_options){
        obj_apagar_options.html("");
    }

    if (!obj_cidade){
        obj_cidade = $('#cd_cidade');
    }

    obj_cidade.attr('disabled', 'disabled');
    obj_cidade.html("<option>Carregando...</option>");

    $.post(base_url+'ajax/cidade/getCidades',{
        nm_cidade : nm_cidade,
        sg_estado : sg_estado,
        id_estado : id_estado,
        exibir_cabecario   : exibir_cabecario
    }, function (data) {

        obj_cidade.html(data);
        obj_cidade.removeAttr('disabled');
        obj_cidade.change();
    });
}
