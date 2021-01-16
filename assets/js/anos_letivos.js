
function set_anovigente(id, ano){
    if (confirm('Deseja realmente tornar o ano de '+ano+' vigente?')) {

        var url_excluir = $('#url_base').val()+'/set_anovigente/';

        $.post(url_excluir, {
            id: id,
            consulta : 'true'

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
        $('#carregando').show();

        var nr_ano_letivo = $('#nr_ano_letivo').val();
        var consulta      = $('#consulta').val();
        var nm_escola     = $('#nm_escola').val();
        var cd_estado     = $('#cd_estado').val();
        var cd_cidade     = $('#cd_cidade').val();
        var nm_escola     = $('#nm_escola').val();
        var ci_escola     = $('#cd_escola').val();
        
        
        var url_listar    = $('#url_base').val()+'listagem_consulta';

        $.post(url_listar, {
            nr_ano_letivo : nr_ano_letivo,
            consulta      : consulta,
            cd_estado     : cd_estado,
            cd_cidade     : cd_cidade,
            ci_escola     : ci_escola,
            nm_escola     : nm_escola

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
            $('#carregando').hide();      
        });

    });

});
