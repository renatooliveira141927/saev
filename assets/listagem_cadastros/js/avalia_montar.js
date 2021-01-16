$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        //document.getElementById("img_carregando").style.display = "block";

        var nm_caderno     = $('#nm_caderno').val();
        var cd_disciplina  = $('#cd_disciplina').val();
        var cd_avalia_tipo = $('#cd_avalia_tipo').val();
      
        var url_listar     = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_caderno      : nm_caderno,
            cd_disciplina   : cd_disciplina,
            cd_avalia_tipo  : cd_avalia_tipo

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
                nm_caderno      : nm_caderno,
                cd_disciplina   : cd_disciplina,
                cd_avalia_tipo  : cd_avalia_tipo

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
