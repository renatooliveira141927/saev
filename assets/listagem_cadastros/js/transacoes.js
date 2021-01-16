
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var nm_transacao = $('#nm_transacao').val();
        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            nm_transacao: nm_transacao,
            ci_transacao: id

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

        var nm_transacao     = $('#nm_transacao').val();

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_transacao='+nm_transacao+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_transacao: nm_transacao

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
                nm_transacao: nm_transacao

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
