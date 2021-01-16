
function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

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
        var nr_inep     = $('#nr_inep').val();
        var nm_aluno    = $('#nm_aluno').val();        
        var cd_cidade   = $('#cd_cidade').val();
        var cd_turma    = $('#cd_turma').val();
        var cd_etapa    = $('#cd_etapa').val();
        var cd_turno    = $('#cd_turno').val();
        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_aluno='+nm_aluno+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nr_inep:   nr_inep,
            nm_aluno:  nm_aluno,            
            cd_cidade: cd_cidade,
            cd_turma:  cd_turma,
            cd_etapa:  cd_etapa,
            cd_turno:  cd_turno

        }, function (data) {
            $('#listagem_resultado').html(data);
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                nr_inep:   nr_inep,
                nm_aluno:  nm_aluno,            
                cd_cidade: cd_cidade,
                cd_turma:  cd_turma,
                cd_etapa:  cd_etapa,
                cd_turno:  cd_turno

            }, function (data) {
                $('#listagem_resultado').html(data);
            });

        });
      //  document.getElementById("img_carregando").style.display = "none";
    });

});
