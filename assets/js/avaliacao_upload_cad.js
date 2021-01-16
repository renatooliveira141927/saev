var num_coluns = 0;

function renumera_questoes(){

  var i = 0;
  $("table#table-avalia_matriz tbody tr").each(function() {
      $(this).find('td').eq(0).text(++i+'ª');
  });
}


function remove(item) {  
    
    var tr = $(item).closest('tr');	
    
    tr.remove();    
    
    num_coluns = jQuery("#table-avalia_matriz tbody tr").length;
    renumera_questoes();    
}


function AddTableRow(nr_opcaocorreta, ds_codigo, cd_matriz) {	
    
    num_coluns++;

    $('#cel-numeracao_'+num_coluns).text(num_coluns + 'ª');

    var newRow = $('<tr>');
    var cols = "";
    cols += '<td style="vertical-align:middle; text-align: center;">'+num_coluns+'ª)</td>';

    cols += '<td>';
    cols += '<select id="nr_opcaocorreta"';
    cols += '            name="nr_opcaocorreta[]"';
    cols += '            tabindex="1"';
    cols += '            class="form-control">';
    if (nr_opcaocorreta == 1){
        cols += '        <Option value="1" selected>A</Option>';
    }else{
        cols += '        <Option value="1">A</Option>';
    }
    if (nr_opcaocorreta == 2){
        cols += '        <Option value="2" selected>B</Option>';
    }else{
        cols += '        <Option value="2">B</Option>';
    }
    if (nr_opcaocorreta == 3){
        cols += '        <Option value="3" selected>C</Option>';
    }else{
        cols += '        <Option value="3">C</Option>';
    }
    if (nr_opcaocorreta == 4){
        cols += '        <Option value="4" selected>D</Option>';
    }else{
        cols += '        <Option value="4">D</Option>';
    }
    cols += '    </select>';
    cols += '</td>';

    cols += '<td>';
    cols += '<input type="text"';
    cols += '       name="ds_codigo[]';
    cols += '       id="ds_codigo';
    cols += '       onblur="pesquisar_select(this, \'CODIGO\');"';
    cols += '       tabindex="2" ';
    cols += '       placeholder="Código"'; 
    cols += '       style="text-transform: uppercase;"';
    cols += '       class="form-control"'; 
    if (ds_codigo){
        cols += '       value="'+ds_codigo+'">';
    }else{
        cols += '       value="">';
    }
    
    cols += '</td>';
    cols += '<td id="tr_matriz_'+num_coluns+'"><div>';

    
        cols += '    <select id="cd_matriz"';
        cols += '            name="cd_matriz[]"';
        cols += '            tabindex="3"';
        cols += '            class="form-control"';
        cols += '            onchange="pesquisar_select(this, \'SELECT\')">';
        cols += '        <Option value="" ds_codigo=""></Option>';
        if (cd_matriz){
            cols += retorna_option(cd_matriz);
        }else{
            cols += options;
        }
        cols += '    </select>';
    cols += '</div></td>';
    cols += '<td style="vertical-align:middle; text-align: center;">';
    cols += '   <a type="button"  onclick="remove(this)" class="btn btn-danger waves-effect waves-light btn-micro active"> Remover </a>';
    cols += '</td>';

    
    newRow.append(cols);

    var linha = $("#table-avalia_matriz").append(newRow);

    //criar_select_cd_matriz();
    return linha;
}


var options = [];
function popula_option(dados_json){

    options = [];
    
    for (var i=0;i<dados_json.length;i++){
        options.push("<option value='"+dados_json[i].ci_matriz_descritor+"' ds_codigo='"+dados_json[i].ds_codigo+"'>"+dados_json[i].nm_matriz_descritor+"</option>");
    };
    
    //options = options.join("");
    //alert(options);
    
}
function retorna_option(value){
    if (value != ''){
        var sel = $('<select>');    
        sel.append(options);
    
        sel.children('option').each(function() {
            if ($(this).attr('value') == value){
                $( this ).attr("selected", true);
            }
        });
        
         return sel.html();;
    }
}
function nova_combo(linha){
 
    
    var tr = $(linha).closest('tr');
    combo = tr.find('select');
    
    combo.html(options);
        
}
// function nova_combo(linha){
 
 
//     var tr = $(linha).closest('tr');
//     combo = tr.find('select');
 
//     combo.html(options);

// // }
// function pesquisar(cd_matriz){

//     var sel = $('<select id="cd_matriz" name="cd_matriz[]" class="form-control">');
//     //sel.addClass( "form-control" );
    
//     sel.append(options);

//     sel.children('option').each(function() {

//       if ($(this).attr('value') == cd_matriz){
//           $( this ).attr("selected", true);
//       }
     
//     });
//     $('#dv_matriz').append(sel);
//     // });
// }
function gerar_matrizes(cd_disciplina, cd_etapa, nr_opcaocorreta, ds_codigo, cd_matriz){
    var href  = $('#base_url').val()+'/ajax/matriz/getMatrizes';

    $("#table-avalia_matriz tbody tr").remove();
    num_coluns = 0;
    $('#dv_matriz').hide();
    
    $.post(href, {
        cd_disciplina   : cd_disciplina,
        cd_etapa        : cd_etapa

    }, function (data) {

        var dados = JSON.parse(data);
        if (dados.length > 0){
            
            popula_option(dados);
            if (cd_matriz){
                cd_matriz       = cd_matriz.split('|');
                ds_codigo       = ds_codigo.split('|');
                nr_opcaocorreta = nr_opcaocorreta.split('|');

                for (i in cd_matriz){
                    
                    var linha = AddTableRow(nr_opcaocorreta[i], ds_codigo[i], cd_matriz[i]);
                    nova_combo(linha);
                }
                
            }else{
                var linha = AddTableRow();
                nova_combo(linha);
            }
            $('#dv_matriz').show();
        }
        
    });
}

function pesquisar_select(linha, tp_pesquisa){

    var tr = $(linha).closest('tr');

    var input   = tr.find('input');
    //alert(tr.find("select[id='cd_matriz']"));
    var combo  = tr.find("select[id='cd_matriz']");
    var option  = tr.find("select[id='cd_matriz'] option");

    var ds_codigo   = input.val();
    
    
    if (tp_pesquisa == 'CODIGO'){
        option.each(function () {
            var att_codigo = $(this).attr('ds_codigo');
                       
            if (att_codigo.toUpperCase() == ds_codigo.toUpperCase()) {            
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }          
        });

    }else{
        
        input.val(combo.find(':selected').attr('ds_codigo').toUpperCase());
    }

}

/** Daqui para baixo são Funções para aba municipio*/
    function adicionar(){
        var estado = $('#cd_estado option:selected').text();

        $('#cd_cidade option:selected').each(function() {
            var opt = $(this).clone(true).prop('selected',true);
            texto = estado + ' - ' + opt.text();
            opt.text(texto);           
            $('#cd_cidade_participante').append(opt);
            $(this).remove();
        });
        ordena_options($("#cd_cidade"));
        ordena_options($("#cd_cidade_participante"));
    }
    function remover(){

        $('#cd_cidade_participante option:selected').each(function() {
            var opt = $(this).clone(true).prop('selected',true);            
            $('#cd_cidade').append(opt);
            $(this).remove();
        });
        ordena_options($("#cd_cidade"));
        ordena_options($("#cd_cidade_participante"));
    }
    function removeAll(){

        $('#cd_cidade_participante option').each(function() {
            var opt = $(this).clone();
            $('#cd_cidade').append(opt);
            $(this).remove();
        });
        ordena_options($("#cd_cidade"));
        ordena_options($("#cd_cidade_participante"));
    }


    function ordena_options(combo) {   

        combo.html($("option", combo).sort(function(a,b){
            return a.text == b.text  ? 0 : a.text < b.text ? -1 : 1;
        }));
     }