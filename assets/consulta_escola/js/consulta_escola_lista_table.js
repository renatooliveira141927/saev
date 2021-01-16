
$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        //document.getElementById("img_carregando").style.display = "block";

        var nr_inep     = $('#nr_inep').val();
        var nm_escola   = $('#nm_escola').val();                
        var cd_cidade   = $('#cd_cidade').val();

        var base_url  = $('#base_url').val()+'usuario/grupos/listagem_escolas';

        // Carrega as escolas no consulta inicial
        $.post(base_url, {
            nr_inep     : nr_inep,
            nm_escola   : nm_escola,
            cd_cidade   : cd_cidade
        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#base_url').val();
            }else{
                $('#listagem_resultado').html(data);
            }            
        });

    });

});
