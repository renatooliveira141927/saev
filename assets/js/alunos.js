

function reativar(id){
    if (confirm('Deseja realmente reativar o registro?')) {

        var url_base = $('#url_base').val()+'/reativar/';

        $.post(url_base, {
            id: id

        }, function (data) {
            $('#listagem_resultado').html(data);
        });
    }
}

function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

        }, function (data) {
            $('#listagem_resultado').html(data);
        });
    }
}

function valida_form(){
    var validacao = true;

    var cd_cidade       = $('#cd_cidade').val();
    var cd_estado       = $('#cd_estado').val();
    var cd_escola       = $('#cd_escola').val();
    var nm_aluno        = $('#nm_aluno').val();
    var cd_etapa        = $('#cd_etapa').val();         

    if ( (cd_estado === '' || cd_estado === null || cd_estado === '0') ){

        validacao = false;
        $('#cd_estado').css('border', '1px solid orange');
    }else{
        $('#cd_estado').css('border', '1px solid #E3E3E3');

    }

    if(!$('#fl_rede').prop("checked") && (cd_etapa=== '' ||cd_etapa=== null || cd_etapa==='0' ) ){
        validacao = false;
        $('#cd_etapa').css('border', '1px solid orange');
    }

    if ( (cd_cidade === '' || cd_cidade === null || cd_cidade === '0') ){

        validacao = false;
        $('#cd_cidade').css('border', '1px solid orange');
    }else{
        $('#cd_cidade').css('border', '1px solid #E3E3E3');

    }

    if ( (cd_escola === '' || cd_escola === null || cd_escola === '0') && (nm_aluno === '' || nm_aluno === null || nm_aluno === '0')){

        validacao = false;
        $('#cd_escola').css('border', '1px solid orange');
    }else{
        $('#cd_escola').css('border', '1px solid #E3E3E3');

    }

    if (!validacao){
        alert('Campo(s) obrigatório(s) não preenchido(s)!');
        if(!$('#fl_rede').prop("checked")){
            alert('Para visualizar alunos da Rede Muncipal é obrigatório selecionar a Etapa de Ensino!');
        }
        
    }

    return validacao;
}
$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();        
        if (valida_form()){

            var cd_estado       = $('#cd_estado').val(); 
            var cd_cidade       = $('#cd_cidade').val();        
            var nr_inep_escola  = $('#nr_inep_escola').val();
            var cd_escola       = $('#cd_escola').val();
            var nr_inep_aluno   = $('#nr_inep_aluno').val();
            var nm_aluno        = $('#nm_aluno').val();
            var cd_turma        = $('#cd_turma').val();
            var cd_etapa        = $('#cd_etapa').val();
            var cd_turno        = $('#cd_turno').val();
            var cd_ano_letivo   = $('#cd_ano_letivo').val();
            var url_listar      = $('#url_base').val()+'/listagem_consulta';
            var fl_ativo = '';
            if ($('#fl_ativo').prop("checked")){
                fl_ativo = true;
            }else{
                fl_ativo = false;
            }

            var fl_rede = '';
            if ($('#fl_rede').prop("checked")){
                fl_rede = true;
            }else{
                fl_rede = false;
            }

            $('#carregando').show();

             //alert('nr_inep_escola='+nr_inep_escola+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
            // Carrega as escolas no consulta inicial
            $.post(url_listar, {
                cd_estado:      cd_estado,
                nr_inep_aluno:  nr_inep_aluno,
                nm_aluno:       nm_aluno,            
                cd_cidade:      cd_cidade,
                nr_inep_escola: nr_inep_escola,
                cd_escola:      cd_escola,
                cd_turma:       cd_turma,
                cd_etapa:       cd_etapa,
                cd_turno:       cd_turno,
                cd_cidade:      cd_cidade,
                fl_ativo:       fl_ativo,
                cd_ano_letivo:  cd_ano_letivo,
                fl_rede:       fl_rede

            }, function (data) {
                $('#listagem_resultado').html(data);
                $('#carregando').hide();
            });

        }
    });

});
