

//function popula_consulta_escola(){
$(document).ready(function(){
    $("#container").load("http://localhost/teste_paginacao/welcome/lista");
    $(document).on("click", "#pagination-digg li a", function(e){
        e.preventDefault();
        var href = $(this).attr("href");
        $("#container").load(href);
    });
});

$(document).ready(function () {
    $("#btn-consulta_escola").click(function (ev) {
        ev.preventDefault();

        var nm_escola    = $('#txt-nm_escola').val();
        var nr_inep      = $('#txt-inep').val();
        var ci_escola    = $('#txt-ci_escola').val();

        var cur_pag      = '';


        if (nm_escola != '') {
            // Carrega as escolas no consulta inicial
            $.post('http://localhost/codeigniter/ajax/escola/getEscolaListaOpcoes', {
                nm_escola: nm_escola,
                nr_inep: nr_inep,
                ci_escola: ci_escola

            }, function (data) {
                $('#sel-cd_escola_list').html(data);
            });

            // Carrega as escolas após clicar nos itens das paginações
            $(document).on("click", "#pagination-digg li a", function(e){
                e.preventDefault();
                var href = $(this).attr("href");

                $.post(href, {
                    nm_escola: nm_escola,
                    nr_inep: nr_inep,
                    ci_escola: ci_escola

                }, function (data) {
                    $('#sel-cd_escola_list').html(data);
                });

            });

            abrir_select_consulta_escola();
        }
        else {
            alert('Digite o nome ou parte do nome da escola que deseja consulta!');
            $('#txt-nm_escola').focus();
            return false;

        }
    });


    $("#txt-inep").blur(function (ev) {
        ev.preventDefault();

        var nr_inep      = $('#txt-inep').val();

        if (nr_inep != '') {

            $('#txt-nm_escola').attr('disabled', 'disabled');
            $('#txt-nm_escola').val("Carregando...");

            $.post('http://localhost/codeigniter/ajax/escola/getEscolaInep', {
                nr_inep: nr_inep

            }, function (data) {
                if (data != ''){
                    $('#txt-nm_escola').val(data);
                }else{
                    $('#txt-nm_escola').val("");
                }

                $('#txt-nm_escola').removeAttr('disabled');
            });
        }
    });

});
