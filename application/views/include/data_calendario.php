<?php

$date_oct = '';
$data_comum = '';
$data_extenso =  '';





if ($data !=''){
    
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

    $date_oct = new DateTime($data);
    $data_comum = $date_oct->format('d/m/Y');
    $data_extenso =  utf8_encode(strftime('%d', strtotime($data)).' '.ucwords(strftime('%B', strtotime($data))).' '.strftime('%Y', strtotime($data)));
}


?>



<link href="<?=base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" media="screen">


<div class="input-group date form_date" data-date="<?php echo $data_comum?>" data-date-format="dd MM yyyy" data-link-field="txt_data" data-link-format="dd/mm/yyyy" >
    <input class="form-control" size="16" type="text" tabindex="<?php echo $tabindex ?>" value="<?php echo $data_comum?>" id="calendario">
    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
</div>
<input type="hidden" id="txt_data" name="txt_data" value="<?php echo $data_comum?>" />
<!--<button onclick="alert('txt_data='+txt_data.value+' calendario='+calendario.value);return false;">ver data</button>-->


<script type="text/javascript" src="<?=base_url('assets/js/bootstrap-datetimepicker.js'); ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url('assets/js/locales/bootstrap-datetimepicker.pt-BR.js'); ?>" charset="UTF-8"></script>
<script type="text/javascript">

    $('.form_date').datetimepicker({
        language:  'pt-BR',
        format:  'dd/mm/yyyy',        
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

    $("#calendario").mask("99/99/9999", {
        completed: function () {
            console.log('complete')
            var value = $(this).val().split('/');
            var maximos = [31, 12, 2100];
            var novoValor = value.map(function (parcela, i) {
                if (parseInt(parcela, 10) > maximos[i]) return maximos[i];
                return parcela;
            });
            if (novoValor.toString() != value.toString()) $(this).val(novoValor.join('/')).focus();
        }
    });
    $("#calendario").blur(function(){        
        $("#txt_data").val($("#calendario").val());
    });
</script>
