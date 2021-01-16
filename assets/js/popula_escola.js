function populaescola(cd_cidade, nr_inep, cd_escola, obj_apagar_options){

    var base_url  = $('#base_url').val();  
    
    $('#cd_escola').attr('disabled', 'disabled');
    $('#cd_escola').html("<option>Carregando...</option>");

    if (obj_apagar_options){
        obj_apagar_options.html("");
    }

    $.post(base_url+'ajax/escola/getEscolas',{
        cd_cidade : cd_cidade,
        nr_inep   : nr_inep,
        cd_escola : cd_escola
    }, function (data) {
        
        $('#cd_escola').html(data);
        $('#cd_escola').removeAttr('disabled');
    });
}

function pesquisar_select(nr_inep, tp_pesquisa){

    var combo  = $('#cd_escola');

    
    if (tp_pesquisa == 'NR_INEP'){

        combo.children('option').each(function() {
            if ($( this ).attr('nr_inep') == nr_inep){
                $( this ).attr("selected", true);
            }
        });

    }else{
        
        $('#nr_inep_escola').val(combo.find(':selected').attr('nr_inep').toUpperCase());
    }

}