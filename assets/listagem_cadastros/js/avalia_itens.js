
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var ci_avalia_item          = $('#ci_avalia_item').val();
        var ds_codigo               = $('#ds_codigo').val();
        var cd_avalia_dificuldade   = $('#cd_avalia_dificuldade').val();
        var cd_avalia_dificuldade   = $('#cd_avalia_dificuldade').val();
        var cd_etapa                = $('#cd_etapa').val();
        var cd_disciplina           = $('#cd_disciplina').val();
        var cd_avalia_conteudo      = $('#cd_avalia_conteudo').val();
        var cd_avalia_subconteudo   = $('#cd_avalia_subconteudo').val();
        var cd_avalia_origem        = $('#cd_avalia_origem').val();
        var cd_edicao               = $('#cd_edicao').val();
        var ds_titulo               = $('#ds_titulo').val();

        var url_excluir = $('#url_base').val()+'/excluir/';
        
        $.post(url_excluir, {
            id                      : id,
            ci_avalia_item          : ci_avalia_item,
            ds_codigo               : ds_codigo,
            cd_avalia_dificuldade   : cd_avalia_dificuldade,
            cd_etapa                : cd_etapa,
            cd_disciplina           : cd_disciplina,
            cd_avalia_conteudo      : cd_avalia_conteudo,
            cd_avalia_subconteudo   : cd_avalia_subconteudo,
            cd_avalia_origem        : cd_avalia_origem,
            cd_edicao               : cd_edicao,
            ds_titulo               : ds_titulo

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

        //document.getElementById("img_carregando").style.display = "block";
        
        var ci_avalia_item          = $('#ci_avalia_item').val();
        var ds_codigo               = $('#ds_codigo').val();
        var cd_avalia_dificuldade   = $('#cd_avalia_dificuldade').val();                
        var cd_etapa                = $('#cd_etapa').val();
        var cd_disciplina           = $('#cd_disciplina').val();
        var cd_avalia_conteudo      = $('#cd_avalia_conteudo').val();
        var cd_avalia_subconteudo   = $('#cd_avalia_subconteudo').val();
        var cd_avalia_origem        = $('#cd_avalia_origem').val();
        var cd_edicao               = $('#cd_edicao').val();
        var ds_titulo               = $('#ds_titulo').val();
        var origem_acesso           = $('#origem_acesso').val();

        var url_listar              = $('#url_base').val()+'/listagem_consulta';

       // alert('origem_acesso='+origem_acesso);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ci_avalia_item          : ci_avalia_item,
            ds_codigo               : ds_codigo,
            cd_avalia_dificuldade   : cd_avalia_dificuldade,
            cd_etapa                : cd_etapa,
            cd_disciplina           : cd_disciplina,
            cd_avalia_conteudo      : cd_avalia_conteudo,
            cd_avalia_subconteudo   : cd_avalia_subconteudo,
            cd_avalia_origem        : cd_avalia_origem,
            cd_edicao               : cd_edicao,
            ds_titulo               : ds_titulo,
            origem_acesso           : origem_acesso

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
                ci_avalia_item          : ci_avalia_item,
                ds_codigo               : ds_codigo,
                cd_avalia_dificuldade   : cd_avalia_dificuldade,
                cd_etapa                : cd_etapa,
                cd_disciplina           : cd_disciplina,
                cd_avalia_conteudo      : cd_avalia_conteudo,
                cd_avalia_subconteudo   : cd_avalia_subconteudo,
                cd_avalia_origem        : cd_avalia_origem,
                cd_edicao               : cd_edicao,
                ds_titulo               : ds_titulo,
                origem_acesso           : origem_acesso

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
