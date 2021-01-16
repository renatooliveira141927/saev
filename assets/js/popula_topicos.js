function populatopicos(){

    var base_url  = $('#base_url').val();
    var cd_avaliacao = $('#cd_avaliacao').val();

    $('#cd_topico').attr('disabled', 'disabled');
    $('#cd_topico').html("<option>Carregando.....</option>");

    $.post(base_url+'ajax/topicos/getTopicos',{
        cd_avaliacao : cd_avaliacao
    }, function (data) {
        $('#cd_topico').html(data);
        $('#cd_topico').removeAttr('disabled');
    });
}