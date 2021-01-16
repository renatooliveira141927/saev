
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

        var nm_usuario      = $('#nm_usuario').val();
        var nm_login        = $('#nm_login').val();
        var nr_cpf          = $('#cpf').val();
        var cd_grupo        = $('#cd_grupo').val();

        var url_listar              = $('#url_base').val()+'/listagem_consulta';

        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            nm_usuario  : nm_usuario,
            nm_login    : nm_login,
            nr_cpf      : nr_cpf,
            cd_grupo    : cd_grupo

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
                nm_usuario  : nm_usuario,
                nm_login    : nm_login,
                nr_cpf      : nr_cpf,
                cd_grupo    : cd_grupo

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
