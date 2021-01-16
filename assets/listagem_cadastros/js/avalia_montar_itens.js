$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        //document.getElementById("img_carregando").style.display = "block";

        var ds_codigo       = $('#ds_codigo').val();
        var cd_disciplina   = $('#cd_disciplina').val();
        var cd_dificuldade  = $('#cd_dificuldade').val();
      
        var url_listar     = $('#url_base').val()+'/listagem_montar_avaliacao';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ds_codigo       : ds_codigo,
            cd_disciplina   : cd_disciplina,
            cd_dificuldade  : cd_dificuldade

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }            
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                ds_codigo       : ds_codigo,
                cd_disciplina   : cd_disciplina,
                cd_dificuldade  : cd_dificuldade

            }, function (data) {                
                if (data == 'sessaooff'){
                    window.location.href = $('#url_base').val();
                }else{
                    $('#listagem_resultado').html(data);
                }
            });

        });
      //  document.getElementById("img_carregando").style.display = "none";
    });

});
