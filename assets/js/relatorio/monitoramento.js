    function printPage(){
        var $panels = $('.panel');
        var $panelBodys = $('.panel-body');
        var $tables = $('.table-responsive');
        $panels.removeClass('panel');
        $panelBodys.removeClass('panel-body');
        $tables.removeClass('table-responsive');
        $('#content').css('font-size', '75%');
        window.print();
        $('#content').css('font-size', '100%');
        $panels.addClass('panel');
        $panelBodys.addClass('panel-body');
        $tables.addClass('table-responsive');
    }
    function validaForm(){    	
    	var cd_ano=$('#cd_ano').val();		
    	//var municipio=$('#cd_municipio').val();
		
		//var avaliacao=$('#cd_avaliacao').val();
		if(cd_ano==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			//alert('submit');
			$('#leituraescola').submit();
			return true;
		}
    }
    
    function populaavalicaoleituraano(){
    	var base_url  = $('#base_url').val();
        var ano = $('#cd_ano').val();
        
        $('#cd_avaliacao').attr('disabled', 'disabled');
        $('#cd_avaliacao').html("<option>Carregando.....</option>");

        $.post(base_url+'ajax/avaliacao/getAvaliacoesLeituraAno',{
            ano : ano
        }, function (data) {
            $('#cd_avaliacao').html(data);
            $('#cd_avaliacao').removeAttr('disabled');
        });
    }
