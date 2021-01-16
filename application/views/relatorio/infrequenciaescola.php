<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/bootstrap.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/infrequenciarelatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/highcharts/code/highcharts.js');?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/data.js');?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/drilldown.js');?>"></script>
<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep'));
    }

    function pesquisa_inep_escola(){

        var option  = $( "select[name^='cd_escola'] option" );       
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep.toUpperCase() == attr_inep.toUpperCase()) {
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
        populaturma('',id_escola, '', cd_turma);
    }

    function atualiza_combos_turma(nm_cd_turma, nm_cd_etapa, nm_cd_turno){


        var cd_etapa = $('#'+nm_cd_turma).find(':selected').attr('cd_etapa');
        
        atualiza_etapa(nm_cd_etapa, cd_etapa);
    }

    function atualiza_etapa(nm_cd_etapa, id){

        var option  = $( "select[name^='"+nm_cd_etapa+"'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');
            // alert('atualiza_etapa=>  attr_value='+attr_value+'  id='+id);
            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }
    function zerar_turma(nm_cd_turma){
        $('#'+nm_cd_turma).val("");
    }
</script>
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
	<div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Relatório de Evolução de Infrequ&ecirc;ncia por Escola' ?></h4>
                </p>
            </div>
        </div>
    </div>
        <!-- Inicio Div Parametros -->
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        <div class="container card-box">
        	<form action="" method="post" id="infreqescola" name="infreqescola">
            <div class="col-md-12">
                <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados abrir menu grupo SME-->
                    <div class="col-lg-6"> 
                        <div class="form-group">
                            
                            <label>Estado *</label>
                            <select id="cd_estado" 
                                    name="cd_estado" 
                                    tabindex="3"
                                    class="form-control" 
                                    onchange="populacidade(this.value, '', '', false, $('#cd_cidade'))">

                                <?php echo $estado ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Município *</label>
                            <select id="cd_cidade" 
                                    name="cd_cidade" 
                                    tabindex="2"                                                    
                                    class="form-control" disabled
                                    onchange="populaescola(this.value,'');">
                                <option value="">Selecione o estado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div  class="col-lg-2">
                        <div class="form-group">
                            <label for="nr_inep_escola">Inep escola</label>
                            <input type="text"
                                name="nr_inep_escola"
                                id="nr_inep_escola"
                                tabindex="3"
                                placeholder="Inep escola"
                                class="form-control"
                                value="<?php echo set_value('nr_inep_escola');?>"
                                onblur="pesquisa_inep_escola();">
                        </div>
                    </div>

                    <div class="col-lg-10">
                        <div class="form-group">
                            <label for="cd_escola">Escola</label>
                            <select id="cd_escola" 
                                    name="cd_escola" 
                                    tabindex="4" 
                                    class="form-control"
                                    disabled
                                    onchange="escola_selecionda(this.value);">
                                <Option value="" nr_inep=""></Option>
                
                            </select>
                        </div>
                    </div>
                <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

                    <div class="col-lg-6">                                                    
                        <div class="form-group">
                            
                            <label>Estado *</label>
                            <input  type="text"
                                    disabled
                                    class="form-control"
                                    value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Município *</label>

                            <input  type="text"
                                    disabled
                                    class="form-control"
                                    value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">
                            
                        </div>
                    </div>                    
                    <div  class="col-lg-2">
                        <div class="form-group">
                            <label for="nr_inep_escola">Inep escola</label>
                            <input type="text"
                                name="nr_inep_escola"
                                id="nr_inep_escola"
                                tabindex="3"
                                placeholder="Inep escola"
                                class="form-control"
                                value="<?php echo set_value('nr_inep_escola') ?>"
                                onblur="pesquisa_inep_escola();">
                                
                        </div>
                    </div>                    
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label for="cd_escola">Escola</label>
                            <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                                onchange="escola_selecionda(this.value);">
                                <Option value="" nr_inep=""></Option>
                                <?php
                                    foreach ($escolas as $item) {
                                        ?>
                                        <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                            <?php if (set_value('cd_escola') == $item->ci_escola){
                                                echo 'selected';
                                            } ?> >
                                            <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                        </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php }else{?> <!-- Se o usuário for Escola-->

                    <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                    <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">

                <?php }?> <!-- Fim grupo Escola -->
                <div class="col-lg-10">
                        <div class="form-group">
                            <label>Ano Letivo *</label>
                            <select id="cd_ano" 
                                    name="cd_ano" 
                                    tabindex="3"
                                    class="form-control">
                                <?php echo $anos ?>

                            </select>
                        </div>
                </div>               
                <div align="right">        
                    <input type="hidden"
                            id="url_base"
                            value="<?php echo base_url('relatorio')?>">
                        <a id="btn_consultaescola"></a>
                    <a type="button" id="btn_consulta_infrequencia"
                            tabindex="9"                            
                            class="btn btn-custom waves-effect waves-light btn-micro active"
                            onclick="javascript:validaform();">
                        Consultar
                    </a>
                    <script type="text/javascript">
                    function validaform(){
                        var invalido = true;                        
                        var estado=$('#cd_estado').val();
                    	var cidade=$('#cd_cidade').val();
                        var cd_ano=$('#cd_ano').val();
                    	if(estado==''||cidade==''||cd_ano==''){
                    		alert('Verifique o preenchimento dos campos com asterísco (*)!');
                    		return false;
                    	}else{
                    		$('#btn_consultaescola').click();
                    		return true;
                    	}
                    }
                    </script>                     
                </div>                   	
            </div>
        </form>    
        </div>    
        <!-- Fim Div Parametros -->
        <!-- Inicio Div Consulta -->       
        <div class="container card-box">
            <div class="col-md-12">
                <!-- Div para listagem resultado da consulta-->
                <div id="listagem_resultado"></div>
            </div>
        </div>
        <!-- Fim Div Consulta -->
    <?php echo form_close();?>