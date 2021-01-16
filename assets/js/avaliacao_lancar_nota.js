    function add_select(valor, campo_codigo, campo_titulo){

        
        var codigo = campo_codigo.value;
        var titulo = campo_titulo.value;
        titulo = titulo.replace(/[\\"]/g, '');
        var texto = titulo + ' - ' + codigo;

        if (checkOption(valor)){
            alert('Opção já adicionada!');
        }
        else{
            var x = document.getElementById("sel_avalia_item");
            var option = document.createElement("option");
            option.value = valor;
            option.text = texto;

            var sel = x.options[x.selectedIndex]; 
            x.add(option, sel);
        }        
    }

    function checkOption(valor){
        var select = document.getElementById("sel_avalia_item");
        var result = [];
        var options = select && select.options;
        var opt;
        for(var i = 0; i < options.length; i++){
            opt = options[i];
            if (opt.value == valor) {
                return true;
            }
        }
        return false;        
    }

    function selecionarAllOptions(){
        var select = document.getElementById("sel_avalia_item");
        var result = [];
        var options = select && select.options;
        var opt;
        for(var i = 0; i < options.length; i++){
            opt = options[i];
            opt.selected = true;
        }
        return true;
    }

    function addOption(){
        var select = document.getElementById("sel_avalia_item");
        select.options[select.options.length] = new Option('New Element', '0', false, false);
    }

    function removeOption(){
        var select = document.getElementById("sel_avalia_item");
        select.options[select.selectedIndex] = null;
    }

    function removeAllOptions(){
        var select = document.getElementById("sel_avalia_item");
        select.options.length = 0;
    }

    function modal_veritem(id, nm_aluno, ci_avaliacao_turma) {
        
        var url_listar     = $('#url_base').val()+'/popula_modal_verItem';

        // Carrega dados para modal itens        

       //alert('id='+id+'nm_aluno='+nm_aluno+'ci_avaliacao_turma='+ci_avaliacao_turma);

        $.post(url_listar, {
            id                  : id,
            nm_aluno            : nm_aluno,
            ci_avaliacao_turma  : ci_avaliacao_turma            

        }, function (data) {
            if (data == 'sessaooff'){
                window.location.href = $('#url_base').val();
            }else{
                $('#modal_aplication').html(data);
            }            
        });


    }
    