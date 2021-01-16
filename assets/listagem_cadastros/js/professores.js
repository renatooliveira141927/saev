
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

        var ci_professor      = $('#ci_professor').val();
        var nm_professor      = $('#nm_professor').val();
        var cd_cidade         = $('#cd_cidade').val();
        var nr_cpf            = $('#nr_cpf').val();
        var dt_nascimento     = $('#dt_nascimento').val();
        var ds_email          = $('#ds_email').val();
        var fl_formacao       = '';
        var ds_outra_formacao = $('#ds_outra_formacao').val();

        if ($('#formacao_p').prop("checked")){
            fl_formacao = $('#formacao_p').val();
        }
        if ($('#formacao_ll').prop("checked")){
            fl_formacao = $('#formacao_ll').val();
        }
        if ($('#formacao_lo').prop("checked")){
            fl_formacao = $('#formacao_lo').val();
        }
        if ($('#formacao_m').prop("checked")){
            fl_formacao = $('#formacao_m').val();
        }
        if ($('#formacao_o').prop("checked")){
            fl_formacao = $('#formacao_o').val();
        }

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ci_professor        : ci_professor,
            nm_professor        : nm_professor,
            cd_cidade           : cd_cidade,
            nr_cpf              : nr_cpf,
            dt_nascimento       : dt_nascimento,
            ds_email            : ds_email,
            fl_formacao         : fl_formacao,
            ds_outra_formacao   : ds_outra_formacao
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
                ci_professor        : ci_professor,
                nm_professor        : nm_professor,
                cd_cidade           : cd_cidade,
                nr_cpf              : nr_cpf,
                dt_nascimento       : dt_nascimento,
                ds_email            : ds_email,
                fl_formacao         : fl_formacao,
                ds_outra_formacao   : ds_outra_formacao

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
