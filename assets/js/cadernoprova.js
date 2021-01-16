$(function () {
    $('#btSearch').click(function(ev){
        ev.preventDefault();
        $('#carregando').show();        
        if(validaForm()){
            parametros=$("#cd_estado").val()+"/"+$("#cd_cidade").val()+"/"+$("#cd_avaliacao").val();            
            $.post({
                url:"partials/cadernoProva/"+parametros,
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
    var avaliacao=$('#cd_avaliacao').val();	
    if(estado==''||cidade==''||avaliacao==''){    
		alert('Verifique o preenchimento dos campos com asterísco (*)!');
		return false;
	}else{
		$('#avaliacaoleitura').submit();
		return true;
	}
}