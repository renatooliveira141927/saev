<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabaritoleitura.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script src="<?=base_url('assets/highcharts/code/highcharts.js');?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/exporting.js');?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/export-data.js');?>"></script>

<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep'));
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep.toUpperCase() == attr_inep) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }
    function pesquisa_cd_escola(id){

        var option  = $( "select[name^='cd_escola'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');

            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }

    function escola_selecionda(id_escola, cd_turma){
        add_inep_escola();
        $('#cd_etapa').removeAttr('disabled');
        //populaturma('',id_escola, '', cd_turma);
    }

    $(function () {
        $('input[name=rd_rel]').change(function(){
            Highcharts.setOptions({
                lang: {
                    contextButtonTitle: 'Menu de exportação',
                    downloadPNG: "Baixar em PNG",
                    downloadSVG: "Baixar vetor em SVG",
                    downloadPDF: "Baixar em PDF",
                    downloadJPEG: "Baixar Imagem JPG",
                    printChart: "Imprimir o gráfico",
                    decimalPoint: ',',
                    thousandsSep: '.',
                    numericSymbols: ['.000', '.000.000', '', '', '']
                }
            });
            
            if($('input[name=rd_rel]:checked').val()=='M') {
                parametros=$("#cd_etapa").val()+"/"+$("#cd_turma").val()+"/"+$("#cd_disciplina").val();
                $.ajax({
                    url:"partials/munleituraescola/"+parametros,
                    type:'post',                
                    success: function (data){
                        var meses=[];
                        var certos=[];
                        var leitor_fluente=[];
                        var leitor_sfluente=[];
                        var leitor_frase=[];
                        var leitor_palavra=[];
                        var leitor_silaba=[];
                        var nao_leitor=[];
                        var nao_avaliado=[];
                        var str = JSON.stringify(data);
                        var jason = JSON.parse(str);
                        for(var i=0; i<jason.length; i++){
                            meses[i]=jason[i].mes;
                                        leitor_fluente[i]=parseInt(jason[i].leitor_fluente);
                                        leitor_sfluente[i]=parseInt(jason[i].leitor_sfluente);    
                                        leitor_frase[i]=parseInt(jason[i].leitor_frase);
                                        leitor_palavra[i]=parseInt(jason[i].leitor_palavra);
                                        leitor_silaba[i]=parseInt(jason[i].leitor_silaba);
                                        nao_leitor[i]=parseInt(jason[i].nao_leitor);        
                                        nao_avaliado[i]=parseInt(jason[i].nao_avaliado);
                        }
                            var obj1={
                                  name:('Leitor Fluente'),
                                  data:leitor_fluente
                                };
                            var obj2={
                                  name:('Leitor Sem Fluência'),
                                  data:leitor_sfluente
                                };
                            var obj3={
                                  name:('Leitor de Frase'),
                                  data:leitor_frase
                                };    
                            var obj4={
                                  name:('Leitor de Palavra'),
                                  data:leitor_palavra
                                };    
                            var obj5={
                                  name:('Leitor de Sílaba'),
                                  data:leitor_silaba
                                };    
                            var obj6={
                                  name:('Não Leitor'),
                                  data:nao_leitor
                                };    
                            var obj7={
                                    name:('Não Avaliado'),
                                    data:nao_avaliado
                                  }; 
                            certos.push(obj1);
                            certos.push(obj2);
                            certos.push(obj3);
                            certos.push(obj4);
                            certos.push(obj5);
                            certos.push(obj6);
                            certos.push(obj7);
                            
                            var divC=document.createElement("div");
                                divC.setAttribute("id","charts");
                                divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                            $('#listagem_resultado').append(divC);                        

                            $('#charts').highcharts({
                            chart: {
                                type: 'line'
                            },
                            colors: ['#006600','#B3E6B3','#FFFF00', '#FF9900','#FF8080','#E60000'],

                            title: {
                                text: jason[0].nm_escola
                            },
                            subtitle: {
                                text: 'Situação de Leitura da Escola por Mês'
                            },
                            xAxis: {
                                categories: meses
                            },
                            yAxis: {
                                title: {
                                    text: 'Qtd de Estudantes'
                                }

                            },
                            plotOptions: {
                                line: {
                                    dataLabels: {
                                        enabled: true
                                    },
                                    enableMouseTracking: false
                                }
                            },
                            series: certos
                        });
                    }
                });
            }
            if($('input[name=rd_rel]:checked').val()=='A') {
                
                parametros=$("#cd_etapa").val()+"/"+$("#cd_turma").val()+"/"+$("#cd_disciplina").val();
                $.ajax({
                    url:"partials/munleituraescolaano/"+parametros,
                    type:'post',                
                    success: function (data){
                        var anos=[];
                        var certos=[];
                        var leitor_fluente=[];
                        var leitor_sfluente=[];
                        var leitor_frase=[];
                        var leitor_palavra=[];
                        var leitor_silaba=[];
                        var nao_leitor=[];
                        var nao_avaliado=[];
                        var str = JSON.stringify(data);
                        var jason = JSON.parse(str);
                        for(var i=0; i<jason.length; i++){
                            anos[i]=jason[i].ano;

                                        leitor_fluente[i]=parseInt(jason[i].leitor_fluente);
                                        leitor_sfluente[i]=parseInt(jason[i].leitor_sfluente);    
                                        leitor_frase[i]=parseInt(jason[i].leitor_frase);
                                        leitor_palavra[i]=parseInt(jason[i].leitor_palavra);
                                        leitor_silaba[i]=parseInt(jason[i].leitor_silaba);
                                        nao_leitor[i]=parseInt(jason[i].nao_leitor);  
                                        nao_avaliado[i]=parseInt(jason[i].nao_avaliado);
                        }
                        //console.log(meses);
                        //console.log(leitor_fluente);
                            var obj1={
                                  name:('Leitor Fluente'),
                                  data:leitor_fluente
                                };
                            var obj2={
                                  name:('Leitor Sem Fluência'),
                                  data:leitor_sfluente
                                };
                            var obj3={
                                  name:('Leitor de Frase'),
                                  data:leitor_frase
                                };    
                            var obj4={
                                  name:('Leitor de Palavra'),
                                  data:leitor_palavra
                                };    
                            var obj5={
                                  name:('Leitor de Sílaba'),
                                  data:leitor_silaba
                                };    
                            var obj6={
                                  name:('Não Leitor'),
                                  data:nao_leitor
                                };
                            var obj7={
                                    name:('Não Avaliado'),
                                    data:nao_avaliado
                                  }; 
                            certos.push(obj1);
                            certos.push(obj2);
                            certos.push(obj3);
                            certos.push(obj4);
                            certos.push(obj5);
                            certos.push(obj6);
                            certos.push(obj7);

                            var divC=document.createElement("div");
                                divC.setAttribute("id","charts");
                                divC.setAttribute("style","min-width: 310px; height: 400px; margin: 0 auto");
                            $('#listagem_resultado').append(divC);                        

                            $('#charts').highcharts({
                            chart: {
                                type: 'line'
                            },
                            colors: ['#006600','#B3E6B3','#FFFF00', '#FF9900','#FF8080','#E60000'],

                            title: {
                                text: jason[0].nm_escola
                            },
                            subtitle: {
                                text: 'Situação de Leitura da Escola por Ano'
                            },
                            xAxis: {
                                categories: anos
                            },
                            yAxis: {
                                title: {
                                    text: 'Qtd de Estudantes'
                                }

                            },
                            plotOptions: {
                                line: {
                                    dataLabels: {
                                        enabled: true
                                    },
                                    enableMouseTracking: false
                                }
                            },
                            series: certos
                        });
                    }
                });
            }
        });
     });    
        
    
</script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Municipio:Leitura' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->
                <div class="col-lg-3">
                    <label>Estados</label>
                    <select id="cd_estado"
                            name="cd_estado"
                            tabindex="14"
                            class="form-control"
                            onchange="populacidade(this.value);">
                        <?php echo $estado ?>
                    </select>
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios </label>
                        <select id="cd_cidade"
                                name="cd_cidade"
                                tabindex="15"                                
                                onchange="populaescola(this.value);"
                                class="form-control" >
                                 <?php echo $cidade ?>
                        </select>
                    </div>
                </div>
                <div  class="col-lg-2">
                    <div class="form-group">
                        <label for="nr_inep_escola">Inep da Escola</label>
                        <input type="text"
                               name="nr_inep_escola"
                               id="nr_inep_escola"
                               tabindex="3"
                               placeholder="Inep escola"
                               class="form-control"
                               value="<?php echo set_value('nr_inep_escola'); ?>"
                               onblur="pesquisa_inep();">
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="form-group">
                        <label for="cd_escola">Escola</label>
                        <select id="cd_escola"
                                name="cd_escola"
                                tabindex="4"                                
                                class="form-control"
                                onchange="escola_selecionda(this.value);">
                            <?php echo $escolas ?>
                        </select>
                    </div>
                </div>

            <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                <div class="form-group col-lg-3">
                    <label>Estados</label>
                    <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios </label>
                        <input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                        <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                    </div>
                </div>
                
                <div class="col-lg-10">
                    <div class="form-group">
                        <label for="cd_escola">Escola</label>
                        <select id="cd_escola"
                                name="cd_escola"
                                tabindex="4"
                                class="form-control"                                
                                onchange="escola_selecionda(this.value);">                            
                            <?php echo $escolas ?>
                        </select>
                    </div>
                </div>
            <?php }?> <!-- Fim grupo SME -->
            <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa</label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control" 
                                onchange="populaturmaescola(this.value)">
                            <Option value=""></Option>
                            <?php
                            foreach ($etapas as $item) {?>
                                <Option value="<?php echo $item->ci_etapa; ?>"
                                    <?php if (set_value('cd_etapa') == $item->ci_etapa){
                                        echo 'selected';
                                    } ?> >
                                    <?php echo $item->nm_etapa; ?>
                                </Option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
            <?php }?>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_turma">Turma </label>
                    <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control" 
                            onchange="populadisciplina()">
                        <option value="">Selecione uma Turma</option>
                        <?php
                        foreach ($turmas as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_turma; ?>"
                                <?php if (set_value('cd_turma') == $item->ci_turma){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_turma; ?>
                            </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina </label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control" 
                            onchange="populaavalicaoleituradisponivel()">
                        <option value="">Selecione uma Disciplina</option>
                        <?php
                        foreach ($disciplinas as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_disciplina; ?>"
                                <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_disciplina; ?>
                            </Option>

                        <?php } ?>
                    </select>            
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                        <label for="cd_disciplina">Tipo do Relatório </label>
                        <input type="radio" name="rd_rel" id="rel_m" value="M" tabindex="1">
                        <label class="form-check-label" for="sexo_m">M&ecirc;s &nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" name="rd_rel" id="rel_a" value="A" tabindex="1">
                        <label class="form-check-label" for="sexo_m">Ano &nbsp;&nbsp;&nbsp;</label>
                </div>
            </div>
            <div class="col-md-5">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div> 
        </form>
    </div>
    
    <div class="container card-box"> 
        <div class="table-responsive" id="listagem_resultado"></div>
    </div>    
</div>
<script>
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
</script>