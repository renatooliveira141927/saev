
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';
        
        $.post(url_excluir, {
            id  : id

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
        });

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        var nm_caderno               = $('#nm_caderno').val();
        var cd_avalia_tipo          = $('#cd_avalia_tipo').val();                
        var cd_etapa                = $('#cd_etapa').val();
        var cd_disciplina           = $('#cd_disciplina').val();
        var cd_edicao               = $('#cd_edicao').val();

        var url_listar              = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_caderno              : nm_caderno,
            cd_avalia_tipo          : cd_avalia_tipo,
            cd_etapa                : cd_etapa,
            cd_disciplina           : cd_disciplina,
            cd_edicao               : cd_edicao

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
                nm_caderno              : nm_caderno,
                cd_avalia_tipo          : cd_avalia_tipo,
                cd_etapa                : cd_etapa,
                cd_disciplina           : cd_disciplina,
                cd_edicao               : cd_edicao

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
