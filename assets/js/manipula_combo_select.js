/** Daqui para baixo são Funções para aba municipio*/
function adicionar(combo_origem, combo_destino, txt_anterior){

    combo_origem.children('option:selected').each(function() {
        
        var opt = $(this).clone(true).prop('selected',true);

        var add_item = true;

        combo_destino.children('option').each(function() {
            // alert('opt.prop(value)='+opt.prop('value')+' - $(this).prop(value)='+$(this).prop('value'));

            if (opt.prop('value') == $(this).prop('value')){

                add_item = false;
            }
        });
        if (add_item){
            if (txt_anterior){
                texto = txt_anterior + ' - ' + opt.text();
            }else{
                texto = opt.text();
            }
            opt.text(texto);           
            combo_destino.append(opt);
            $(this).remove();
        }
    });
    ordena_options(combo_origem);
    ordena_options(combo_destino);
}
function remover(combo_origem, combo_destino){

    combo_origem.children('option:selected').each(function() {
        var opt = $(this).clone(true).prop('selected',true);            
        combo_destino.append(opt);
        $(this).remove();
    });
    ordena_options(combo_destino);
    ordena_options(combo_origem);
}
function removeAll(combo_origem, combo_destino){

    combo_origem.children('option').each(function() {
        var opt = $(this).clone();
        combo_destino.append(opt);
        $(this).remove();
    });
    ordena_options(combo_destino);
    ordena_options(combo_origem);
}


function ordena_options(combo) {   

    combo.html($("option", combo).sort(function(a,b){
        return a.text == b.text  ? 0 : a.text < b.text ? -1 : 1;
    }));
 }

 function seleciona_todos_itens(combo) {   
    
    combo.children('option').each(function() {
        
        $(this).prop('selected',true);
    });

    //return true;

 }