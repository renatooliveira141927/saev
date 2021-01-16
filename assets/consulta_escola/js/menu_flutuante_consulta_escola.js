
function abrir_select_consulta_escola() {

    //popula_consulta_escola();
    var id = $('#janela_menu_consulta_escola');

    var alturaTela = $(document).height();
    var larguraTela = $(window).width();

    //colocando o fundo preto
    $('#mascara').css({'width': larguraTela, 'height': alturaTela});
    $('#mascara').fadeIn(1000);
    $('#mascara').fadeTo("slow", 0.8);

    var left = ($(window).width() / 2) - ($(id).width() / 2);
    var top = ($(window).height() / 2) - ($(id).height() / 2);

    $(id).css({'top': top, 'left': left});
    $(id).show();
};

function fechar_menu_select_escola(){
    $("#mascara").hide();
    $(".window").hide();
};

function escolher_escola(ci_escola, nm_escola, nr_inep){

    $("#txt-ci_escola").val(ci_escola);
    $("#txt-nm_escola").val(nm_escola);
    $("#txt-nr_inep").val(nr_inep);
    fechar_menu_select_escola();
}
