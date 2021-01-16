
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
        document.getElementById("img_carregando").style.display = "none";

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        var ci_escola      = $('#ci_escola').val();
        var nm_escola      = $('#nm_escola').val();
        var cd_cidade         = $('#cd_cidade').val();
        var nr_inep            = $('#nr_inep').val();
        var ds_email          = $('#ds_email').val();
        var fl_extencao       = '';
        var fl_localizacao    = '';

        if ($('#extencao_p').prop("checked")){
            fl_extencao = $('#extencao_p').val();
        }
        if ($('#extencao_e').prop("checked")){
            fl_extencao = $('#extencao_e').val();
        }
        if ($('#localizacao_u').prop("checked")){
            fl_localizacao = $('#localizacao_u').val();
        }
        if ($('#localizacao_r').prop("checked")){
            fl_localizacao = $('#localizacao_r').val();
        }

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ci_escola        : ci_escola,
            nm_escola        : nm_escola,
            cd_cidade        : cd_cidade,
            nr_inep          : nr_inep,
            ds_email         : ds_email,
            fl_extencao      : fl_extencao,
            fl_localizacao   : fl_localizacao
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
                ci_escola        : ci_escola,
                nm_escola        : nm_escola,
                cd_cidade        : cd_cidade,
                nr_inep          : nr_inep,
                ds_email         : ds_email,
                fl_extencao      : fl_extencao,
                fl_localizacao   : fl_localizacao

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
