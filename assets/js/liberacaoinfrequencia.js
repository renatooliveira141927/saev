$(document).ready(function () {
    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();
        $('#carregando').show();
        var cd_cidade       = $('#cd_cidade').val();
        var cd_mes  = $('#cd_mes').val();
        var url_listar      = $('#url_base').val()+'/listagem_liberacao';
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {            
            cd_cidade       : cd_cidade,
            cd_mes  : cd_mes

        }, function (data) {
            $('#listagem_resultado').html(data);
            $('#carregando').hide();
        });
    });
});
