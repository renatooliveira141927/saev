
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var nm_avalia_conteudo = $('#nm_avalia_conteudo').val();
        var url_excluir = $('#url_excluir').val();

        $.post(url_excluir, {
            nm_avalia_conteudo: nm_avalia_conteudo,
            ci_avalia_conteudo: id

        }, function (data) {
            $('#listagem_resultado').html(data);
        });
        document.getElementById("img_carregando").style.display = "none";

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        //document.getElementById("img_carregando").style.display = "block";

        var nm_avalia_conteudo  = $('#nm_avalia_conteudo').val();
        var cd_disciplina       = $('#cd_disciplina').val();

        var url_listar  = $('#url_listar').val();

        // alert('nm_avalia_conteudo='+nm_avalia_conteudo+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_avalia_conteudo: nm_avalia_conteudo,
            cd_disciplina: cd_disciplina

        }, function (data) {
            $('#listagem_resultado').html(data);
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                nm_avalia_conteudo: nm_avalia_conteudo,
                cd_disciplina: cd_disciplina

            }, function (data) {
                $('#listagem_resultado').html(data);
            });

        });
      //  document.getElementById("img_carregando").style.display = "none";
    });

});
