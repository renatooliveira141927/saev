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
		if(cd_ano==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			//alert('submit');
			$('#consulta').submit();
			return true;
		}
    }
    
    