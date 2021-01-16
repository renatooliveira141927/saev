$(function () {
    $('#btSearch').click(function(ev){
        ev.preventDefault();
        $('#carregando').show();        
        if(validaForm()){
            parametros=$("#cd_estado").val()+"/"+$("#cd_cidade").val()+"/"+$("#cd_escola").val();
            $.post({
                url:"partials/conferenciaEnturmacaoEscola/"+parametros,
                type:'post',                
                success: function (data){
                            $('#listagem_enturmacao').html(data);
                            $('#carregando').hide();                                                          
                }
            });            
            $.post({
                url:"partials/conferenciaEnturmacao/"+parametros,
                type:'post',                
                success: function (data){
                    $('#listagem_resultado').html(data);
                    $('#carregando').hide();                                                          
                }
            });
    	}   
    });
 });   


function validaForm(){
	var estado=$('#cd_estado').val();
    var cidade=$('#cd_cidade').val();
    var escola=$('#cd_escola').val();
    if(estado==''||cidade==''||escola==''){    
		alert('Verifique o preenchimento dos campos com asterísco (*)!');
		return false;
	}else{
		$('#avaliacaoleitura').submit();
		return true;
	}
}