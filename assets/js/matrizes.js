var num_coluns = 0;
var num_titulos = 0;


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
    // renumera_questoes();    
}
function renumera_titulos(){

    var i = 1;
    $("div#dv_matriz fieldset").each(function() {
        $(this).find('legend').text('Tópico '+algarismoRomano(i++));
    });
}
function renumera_campos(){

    var tamanho_str     = '';
    var parte_nm_inicial= '';
    var parte_nm_final  = '';        
    var novo_name       = '';
    var numero_topico   = 0;
    var numero_table    = 0;
    var numero_button   = 0;

    $("div#dv_matriz input").each(function() {

        tamanho_str     = '';
        parte_nm_inicial= '';
        parte_nm_final  = '';        
        novo_name       = '';
        
        if ($(this).attr("id") == 'nm_matriz_topico'){
            numero_topico++;
        }else if ($(this).attr("name").substring(0, 10) == 'ds_codigo-'){

            tamanho_str     = $(this).attr("name").length;
            parte_nm_inicial= $(this).attr("name").substring(0, 10);
            parte_nm_final  = $(this).attr("name").substring(tamanho_str-2, tamanho_str);            
            novo_name       = parte_nm_inicial + numero_topico + parte_nm_final;                        
            $(this).attr("name", novo_name);

        }else if ($(this).attr("name").substring(0, 20) == 'nm_matriz_descritor-'){

            tamanho_str     = $(this).attr("name").length;
            parte_nm_inicial= $(this).attr("name").substring(0, 20);
            parte_nm_final  = $(this).attr("name").substring(tamanho_str-2, tamanho_str);
            novo_name       = parte_nm_inicial + numero_topico + parte_nm_final;
            $(this).attr("name", novo_name);

        }
    });
    $("div#dv_matriz table").each(function() {
        tamanho_str     = '';
        parte_nm_inicial= '';
        parte_nm_final  = '';        
        novo_name       = '';
        

        if ($(this).attr("id").substring(0, 20) == 'table-avalia_matriz-'){
            numero_table++;
            parte_nm_inicial= $(this).attr("id").substring(0, 20);
            novo_name       = parte_nm_inicial + numero_table;
            $(this).attr("id", novo_name);

        }
    });
    $("div#dv_matriz a").each(function() {
        tamanho_str     = '';
        parte_nm_inicial= '';
        parte_nm_final  = '';        
        novo_name       = '';

        if ($(this).attr("onclick").substring(0, 12) == 'AddTableRow('){

            numero_button++;
            tamanho_str     = $(this).attr("onclick").length;
            parte_nm_inicial= $(this).attr("onclick").substring(0, 12);
            parte_nm_final  = $(this).attr("onclick").substring(tamanho_str-2, tamanho_str);
            novo_name       = parte_nm_inicial + numero_button + parte_nm_final;
            $(this).attr("onclick", novo_name);

        }
    });  
}

function removeTableTitulo(item) {  
    
    var tr = $(item).closest('div');	
    
    tr.remove();    
    
    num_titulos--;
    renumera_titulos();
    renumera_campos();
}

function algarismoRomano (num) {
    if (!+num)
        return false;
    var digits = String(+num).split(""),
        key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
               "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
               "","I","II","III","IV","V","VI","VII","VIII","IX"],
        roman = "",
        i = 3;
    while (i--)
        roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    return Array(+digits.join("") + 1).join("M") + roman;
}

function AddTableTitulo(nm_titulo) {
 
    num_titulos++;
    var cols = "";
    cols += '    <div style="width:100%">';
    cols += '        <br/>';
    cols += '        <fieldset class="field-body">';
    cols += '            <legend>Tópico '+algarismoRomano(num_titulos)+'</legend>';
    cols += '            <table class="table table-striped table-hover"  id="table-matriz_topico">';
    cols += '                <tbody id="tbody_topico">';
    cols += '                    <tr style="width: 100%;">';
    cols += '                        <td colspan="2" >';
    cols += '                            <input  type="text"';
    cols += '                                name="nm_matriz_topico[]"';
    cols += '                                id="nm_matriz_topico"';
    cols += '                                tabindex="2"';
    cols += '                                placeholder="Nome do tópico"';
    cols += '                                class="form-control"';
    cols += '                                value="'+ nm_titulo +'">';
    cols += '                        </td>';
    cols += '                    </tr>';
    cols += '                    <tr style="width: 100%;">';
    cols += '                            <table class="table table-striped table-hover"  id="table-avalia_matriz-'+num_titulos+'">';
    cols += '                                <thead>';
    cols += '                                   <tr>';
    cols += '                                        <th colspan="2" style="width: 60px; vertical-align:middle; text-align: center;">Descritores</th>';
    cols += '                                        <th style="width: 30px; vertical-align:middle; text-align: center;">CAED</th>';
    cols += '                                        <th colspan="2" style="width: 60px; vertical-align:middle; text-align: center;">Ação</th>';
    cols += '                                    </tr>';
    cols += '                                </thead>';
    cols += '                                <tbody id="tbody_descritor">';
    // cols += '                                    <tr>';
    // cols += '                                       <td style="width: 100px;">';
    // cols += '                                           <input type="text"';
    // cols += '                                               name="ds_codigo-'+num_titulos+'[]"';
    // cols += '                                               id="ds_codigo"';
    // cols += '                                               tabindex="2"';
    // cols += '                                               placeholder="Código"';
    // cols += '                                               class="form-control"';  

    // if (ds_codigo){
    //     cols += '                                           value="'+ds_codigo+'">';
    // }else{
    //     cols += '                                           value="">';
    // }    
    
    // cols += '                                       </td>';
    // cols += '                                       <td>';
    // cols += '                                           <input type="text"';
    // cols += '                                               name="nm_matriz_descritor-'+num_titulos+'[]"';
    // cols += '                                               id="nm_matriz_descritor"';
    // cols += '                                               tabindex="2"';
    // cols += '                                               placeholder="Nome do descritor"';
    // cols += '                                               class="form-control"';

    // if (nm_matriz_descritor){
    //     cols += '                                           value="'+nm_matriz_descritor+'">';
    // }else{
    //     cols += '                                           value="">';
    // }

    // cols += '                                       </td>';
    // cols += '                                       <td style="vertical-align:middle; text-align: center; width:20px;">';
    // cols += '                                           <a  type="button"  class="btn btn-success waves-effect waves-light btn-micro active" onclick="AddTableRow('+num_titulos+');">Add</a>';
    // cols += '                                       </td>';
    // cols += '                                       <td style="vertical-align:middle; text-align: center; width:20px;">';
    // cols += '                                           <a type="button"  onclick="remove(this)" class="btn btn-danger waves-effect waves-light btn-micro active"> Rem</a>';
    // cols += '                                       </td>';
    // cols += '                                   </tr>';
    cols += '                                </tbody>';
    cols += '                                <tfoot>'; 
    cols += '                                    <tr>';
    cols += '                                        <td colspan="4" style="text-align: left;">';
    cols += '                                        </td>';
    cols += '                                    </tr>';
    cols += '                                </tfoot>';
    cols += '                            </table>';
    cols += '                    </tr>';
    cols += '                </tbody>';
    cols += '                <tfoot>';
    cols += '                    <tr style="width: 100%;">';
    cols += '                        <td style="text-align: left;">';
    cols += '                            <a  type="button"';
    cols += '                                class="btn btn-success waves-effect waves-light btn-micro active"';
    cols += '                                tabindex="21"';
    cols += '                                onclick="AddTableTitulo(\'\');">';
    cols += '                                    Add tópico';
    cols += '                            </a>';
    cols += '                        </td>';
    cols += '                        <td style="text-align: left;">';
    cols += '                            <a type="button"  onclick="removeTableTitulo(this);" class="btn btn-danger waves-effect waves-light btn-micro active"> Remover tópico</a>';
    cols += '                        </td>';
    cols += '                    </tr>';
    cols += '                </tfoot>';
    cols += '            </table>';
    cols += '        </fieldset>';
    cols += '    </div>';
    
    $("#dv_matriz").append(cols);
    
    if (!nm_titulo){
        AddTableRow(num_titulos);
    }
}



function AddTableRow(num_tabela, ds_codigo, nm_matriz_descritor,caed,id) {
    
    num_coluns++;

    var newRow = $('<tr>');
    var cols = "";

    cols += '                                </tr>';
    cols += '                                    <td style="width: 100px;">';
    cols += '                                        <input type="text"';
    cols += '                                            name="ds_codigo-'+num_tabela+'[]"';
    cols += '                                            id="ds_codigo"';
    cols += '                                            tabindex="2"';
    cols += '                                            placeholder="Código"';
    cols += '                                            class="form-control"';  

    if (ds_codigo){
        cols += '                                       value="'+ds_codigo+'">';
    }else{
        cols += '                                       value="">';
    }    
    
    cols += '                                    </td>';
    cols += '                                    <td>';
    cols += '                                        <input type="text"';
    cols += '                                            name="nm_matriz_descritor-'+num_tabela+'[]"';
    cols += '                                            id="nm_matriz_descritor"';
    cols += '                                            tabindex="2"';
    cols += '                                            placeholder="Nome do descritor"';
    cols += '                                            class="form-control"';

    if (nm_matriz_descritor){
        cols += '                                       value="'+nm_matriz_descritor+'">';
    }else{
        cols += '                                       value="">';
    }

    cols += '                                    </td>';
    cols += '                                    <td style="width: 100px;">';
    cols += '										 <input type="text" name="ds_descritorcaed'+id+'" placeholder="Código de Descritor do Caed" id="ds_descritorcaed'+id+'" ';
    cols += '	                                             class="form-control" ';
    if (caed){
        cols += '                                       value="'+caed+'">';
    }else{
        cols += '                                       value="" >';
    }
    
    cols += '	                                 <input type="hidden" id="id" name="id" value="'+id+'"></td>';
    cols += '                                    <td style="vertical-align:middle; text-align: center; width:20px;">';
    cols += '                                        <a  type="button"  class="btn btn-success waves-effect waves-light btn-micro active" onclick="submitdescritorcaed('+id+');">Desc</a>';
    cols += '                                    </td>';
    cols += '                                    <td style="vertical-align:middle; text-align: center; width:20px;">';
    cols += '                                        <a  type="button"  class="btn btn-success waves-effect waves-light btn-micro active" onclick="AddTableRow('+num_tabela+');">Add</a>';
    cols += '                                    </td>';
    cols += '                                    <td style="vertical-align:middle; text-align: center; width:20px;">';
    cols += '                                        <a type="button"  onclick="remove(this)" class="btn btn-danger waves-effect waves-light btn-micro active"> Rem</a>';
    cols += '                                    </td>';
    cols += '                                </tr>';
    
    newRow.append(cols);

    var linha = $("#table-avalia_matriz-"+num_tabela).append(newRow);

    // alert($(obj));
    // var tbody = $(obj).closest('#table-avalia_matriz tbody');
    // var linha = $(obj).closest('#table-avalia_matriz tbody').html();

    // tbody.html(linha+cols);
    // //var linha = tbody.append(newRow);

    // //criar_select_cd_matriz_descritor();
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
// function pesquisar(cd_matriz_descritor){

//     var sel = $('<select id="cd_matriz_descritor" name="cd_matriz_descritor[]" class="form-control">');
//     //sel.addClass( "form-control" );
    
//     sel.append(options);

//     sel.children('option').each(function() {

//       if ($(this).attr('value') == cd_matriz_descritor){
//           $( this ).attr("selected", true);
//       }
     
//     });
//     $('#dv_matriz').append(sel);
//     // });
// }
function gerar_matrizes(cd_disciplina, cd_etapa, ds_codigo, nm_matriz_descritor){
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
            //popula_option(dados);
            if (nm_matriz_descritor){
                nm_matriz_descritor = nm_matriz_descritor.split('|');
                ds_codigo           = ds_codigo.split('|');

                for (i in nm_matriz_descritor){
                    var linha = AddTableRow(ds_codigo[i], nm_matriz_descritor[i]);
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
    //alert(tr.find("select[id='cd_matriz_descritor']"));
    var combo  = tr.find("select[id='cd_matriz_descritor']");
    var option  = tr.find("select[id='cd_matriz_descritor'] option");

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

     



function excluir(id){
    if (confirm('Deseja realmente excluir o registro?')) {

        var url_excluir = $('#url_base').val()+'/excluir/';

        $.post(url_excluir, {
            id: id

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
        });
        document.getElementById("img_carregando").style.display = "none";

    }
}

$(document).ready(function () {

    $("#btn_consulta").click(function (ev) {
        ev.preventDefault();

        $('#carregando').show();

        var ds_codigo     = $('#ds_codigo').val();
        var nm_matriz     = $('#nm_matriz').val();
        var cd_disciplina = $('#cd_disciplina').val();
        var cd_etapa      = $('#cd_etapa').val();

        var url_listar        = $('#url_base').val()+'/listagem_consulta';

        // alert('nm_matriz='+nm_matriz+' nr_inep='+nr_inep+' cd_turma='+cd_turma+' cd_etapa='+cd_etapa);
        // Carrega as escolas no consulta inicial
        $.post(url_listar, {
            ds_codigo       : ds_codigo,
            nm_matriz       : nm_matriz,
            cd_disciplina   : cd_disciplina,
            cd_etapa        : cd_etapa

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#listagem_resultado').html(data);
            }
            $('#carregando').hide();
        });

        // Carrega as escolas após clicar nos itens das paginações
        $(document).on("click", "#dv_paginacao li a", function(e){
            e.preventDefault();
            var href = $(this).attr("href");


            $.post(href, {
                ds_codigo       : ds_codigo,
                nm_matriz       : nm_matriz,
                cd_disciplina   : cd_disciplina,
                cd_etapa        : cd_etapa

            }, function (data) {                
                if (data == 'sessaooff'){
                    window.location.href = $('#url_base').val();
                }else{
                    $('#listagem_resultado').html(data);
                }
                $('#carregando').hide();
            });

        });
    });

});

function submitdescritorcaed(id){
    //alert(id);
    //alert(descritorcaed.value);	
	var href  = $('#base_url').val()+'ajax/matriz/atualizaDescritorCaed';
    num_coluns = 0;
    var name='ds_descritorcaed'+id;
    var descritor     = document.getElementById(name);
        
    $('#carregando').show();

    $.post(href, {
    	id   : id,
    	descritorcaed  : descritor.value

    }, function (data) {
        if(data==1){
            alert('Descritor do Caed registrado com sucesso!');
        }else{
            alert('Ocorreu um erro ao salvar o dado!');
        }            
        $('#carregando').hide();        
    });
}
