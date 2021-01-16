
function populaestado(sg_estado){

    var base_url = $('#base_url').val();  
    var id_estado = $('#cd_estado').val();

    $('#cd_estado').html("<option>Carregando...</option>");

    $.post(base_url+'ajax/estado/getEstados',{
        sg_estado : sg_estado,
        id_estado : id_estado
    }, function (data) {
        $('#cd_estado').html(data);
    });
}
