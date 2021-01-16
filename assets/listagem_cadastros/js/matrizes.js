
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

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

        var ds_codigo     = $('#ds_codigo').val();
        var nm_matriz     = $('#nm_matriz').val();
        var cd_disciplina = $('#cd_disciplina').val();
        var cd_etapa      = $('#cd_etapa').val();

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_matriz='+nm_matriz+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ds_codigo       : ds_codigo,
            nm_matriz       : nm_matriz,
            cd_disciplina   : cd_disciplina,
            cd_etapa        : cd_etapa

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
                nm_matriz       : nm_matriz,
                cd_disciplina   : cd_disciplina,
                cd_etapa        : cd_etapa

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
