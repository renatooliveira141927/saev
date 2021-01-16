$(function(){

    // Toda vez que algum button for clicado
    $('button.bt_form').on('click', function (event) {
        event.preventDefault(); // Cancela submit padrão do button
        // Usa .closest para pegar o form do button
        var data1 = $(this).closest('form');
        var aluno=0;
        var tag='';
        var form = data1.find('form');

        data1.each( function(){
            tag=$('.cd_aluno');
            aluno = data1.find(tag);
        })
        
        $.post("lancar_gabarito/salvar", data1.serialize(),
        function (response) {
        	$('#inserido'+aluno.val()).attr('hidden');
        	alert("Salvo com sucesso!");
            $('#inserido'+aluno.val()).removeAttr('hidden');
            
        });
    });
});

function ativaConsulta(){
    $('#btn_consulta').removeAttr('disabled');
}