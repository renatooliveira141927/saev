$(document).ready(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
    	$("#nr_cep").val("");
        $("#ds_rua").val("");
        $("#ds_bairro").val("");
        $("#cd_estado").attr('selectedIndex', '-1');
        $("#cd_cidade").attr('selectedIndex', '-1');
    }
    
    function set_option_select(texto, nm_campo){
        //var cat = 'RIO DE JANEIRO';
        var $campo      = $('#'+nm_campo);
        var $options    = $('option', $campo);
        $options.each(function() {

        if ($(this).text() == texto){
            var valor = $(this).val();
            $('#cidadeEntrega option[value="' + valor + '"]').attr({ selected : "selected" });
            $(this).select(); // This is where my problem is
          }
        });
    }

    //Quando o campo cep perde o foco.
    $("#nr_cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#ds_rua").val("...");
                $("#ds_bairro").val("...");
                $("#cd_estado").attr('selectedIndex', '-1');
                $('#cd_cidade').removeAttr('disabled');
                $("#cd_cidade").attr('selectedIndex', '-1');
                $('#cd_cidade').attr('disabled', 'disabled');

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#ds_rua").val(dados.logradouro);
                        $("#ds_bairro").val(dados.bairro);
                        //$("#cidade").val(dados.localidade);
                        //set_option_select(dados.uf, 'cd_estado');
                        //set_option_select(dados.localidade, 'cd_cidade');
                        var sg_estado = dados.uf;
                        var nm_cidade = dados.localidade;
                        
                        $('#cd_estado').removeAttr('onchange');
                        populaestado(sg_estado);
                        populacidade('', nm_cidade, sg_estado);

                        $("#cd_estado").unbind("change").bind("change", function() {
                            populacidade(this.value);
                          });


                        //$("#uf").val(dados.uf);
                        //$("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});