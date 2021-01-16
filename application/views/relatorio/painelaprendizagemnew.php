<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/js/bootstrap.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_etapa.js'); ?>"></script>
<style type="text/css" media="all">
.label_1{width:125px;float:left;display:block;}
</style>
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
    function carregamodal(id) { 
            var edicao=$('#cd_edicao').val();
            var cd_disciplina=$('#cd_disciplina').val();
            var cidade =$('#cd_cidade').val();
            var rd_rel=$('#rd_rel').val();
            var textnode ='';         
            $.ajax({
            url:"partials/topicodescritor/",
            type: 'POST',
            data: {cd_edicao:edicao,cd_disciplina:cd_disciplina,rd_rel:rd_rel,ci_matriz_topico: id,cd_cidade:cidade},
            dataType:"json",
            success: function(resp1) {                                              
                $("#divDescritores"+id).html('');
                for(var res in resp1){
                    textnode='<div>'+resp1[res].descritor+'</div>';
                             ;
                    if(resp1[res].pacerto<10){
                        textnode=textnode+
                        	 '<div><label style="color:#DF155F">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/10porcento.PNG')?>" alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>10 && resp1[res].pacerto<=20){
                        textnode=textnode+         
                        	 '<div><label style="color:#DF155F">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+
                             '<div><img src="<?php echo base_url('assets/images/icons/20porcento.PNG')?>"  alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>20 && resp1[res].pacerto<=30){
                        textnode=textnode+
                        	 '<div><label style="color:#DF155F">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/30porcento.PNG')?>"  alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>30 && resp1[res].pacerto<=40){
                        textnode=textnode+
                        '<div><label style="color:#FECD04">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/40porcento.PNG')?>"  alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>40 && resp1[res].pacerto<=50){
                        textnode=textnode+
                             '<div><label style="color:#FECD04">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/50porcento.PNG')?>"  alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>50 && resp1[res].pacerto<=60){
                        textnode=textnode+
                             '<div><label style="color:#55C4B1">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/60porcento.PNG')?>" alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>60 && resp1[res].pacerto<=70){
                        textnode=textnode+
                        '<div><label style="color:#55C4B1">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/70porcento.PNG')?>" alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>70 && resp1[res].pacerto<=80){
                        textnode=textnode+
                        '<div><label style="color:#55C4B1">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/80porcento.PNG')?>" alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>80 && resp1[res].pacerto<=90){
                        textnode=textnode+
                        '<div><label style="color:#518DCA">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+         
                             '<div><img src="<?php echo base_url('assets/images/icons/90porcento.PNG')?>" alt="" height="20"></div>';
                    }
                    if(resp1[res].pacerto>90 && resp1[res].pacerto<=100){
                        textnode=textnode+      
                        '<div><label style="color:#518DCA">Percentual de Acerto: '+resp1[res].pacerto+'% </label></div>'+   
                             '<div><img src="<?php echo base_url('assets/images/icons/100porcento.PNG')?>" alt="" height="20"></div>';
                    }         
                    
                    $("#divDescritores"+id).append(textnode);                
                }
              }  
            });            
            $('#modalDescritores'+id).modal('show');        
    }
    
</script>
<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Painel de Aprendizagem' ?></h4>
            </p>
        </div>
    </div>
	<div class="container card-box">
        <form action="" method="post" id="painelaprendizagemnew" name="painelaprendizagemnew">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->
                        <div class="col-lg-3">
                            <label>Estados *</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">
                                <?php echo $estado ?>
                            </select>
                        </div>
                        <div class="col-lg-9">
                            <div  class="form-group">
                                <label>Municípios *</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="2"                                        
                                        class="form-control" >
                                        <?php echo $cidade ?>
                                </select>
                            </div>
                        </div>                     
                    <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                        <div class="form-group col-lg-3">
                            <label>Estados *</label>
                            <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                        </div>
                        <div class="col-lg-9">
                            <div  class="form-group">
                                <label>Municípios *</label>
                                <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                            </div>
                        </div>
                        
                    <?php }else{?> <!-- Fim grupo SME -->
                        <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo $ci_escola;?>">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep da Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="3"
                                       placeholder="INEP"
                                       class="form-control"
                                       value="<?php echo $nr_inep; ?>">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nm_escola">Nome da escola</label>
                                <input type="text"
                                       name="nm_escola"
                                       id="nm_escola"
                                       tabindex="4"
                                       placeholder="Nome"
                                       class="form-control"
                                       value="<?php echo $nm_escola;?>">
                            </div>
                        </div>
                    <?php }?> <!-- Fim grupo scola -->
                    <div class="col-md-3">
                        <div class="form-group">                            
                            <label for="cd_edicao">Edição *</label>
                            <select id="cd_edicao" name="cd_edicao" tabindex="5" class="form-control"
                                    onchange="populadisciplina();">
                                <?php echo $edicoes ?>
                            </select>
                        </div>
                    </div>  
                    
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cd_disciplina">Disciplina </label>
                        <select id="cd_disciplina" name="cd_disciplina" tabindex="6" class="form-control">
                            <option value="">Selecione uma Disciplina</option>
                            <?php
                            foreach ($disciplinas as $item) {
                                ?><Option value="<?php echo $item->ci_disciplina; ?>"
                                <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_disciplina; ?>
                                </Option>
        
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa *</label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
                            <Option value=""></Option>
                            <?php foreach ($etapas as $item) { ?>
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
        
          <div class="col-md-5">
            <div class="form-group">
                <button type="button" id="btn_consultaestudante"
                        tabindex="8" onclick="validaForm();"
                        class="btn btn-custom waves-effect waves-light btn-micro active">
                    Gerar
                </button>
            </div>
        </div>          
         <div class="col-md-4" style="display: none;">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div> 
</form>
</div>
<div class="card-box " id="listagem_resultado">
    <div class="table-responsive align-text-middle">
        <?php if(isset($registrosDesc)){?>
            <?php foreach ($registrosDesc as $value) { ?>

            <div class="col-md-4 card-box" id="tabs-3">
                    <label >Tópico</label></br>
                    <label ><?=$value->topico?></label>
                    </br>
                    <label style="font-size: 50px"><?=$value->pacerto?>% </label></br>
                    <label>de acerto de itens neste tópico</label></br>
                    <?php if($value->pacerto<=10){?>
                            <img src="<?php echo base_url('assets/images/icons/10porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>10 &&$value->pacerto<=20 ){?>
                        <img src="<?php echo base_url('assets/images/icons/20porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>20 &&$value->pacerto<=30 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/30porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>30 &&$value->pacerto<=40 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/40porcento.PNG')?>" alt="" height="20">    
                    <?php } else  if($value->pacerto>40 &&$value->pacerto<=50 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/50porcento.PNG')?>" alt="" height="20">        
                    <?php } else  if($value->pacerto>50 &&$value->pacerto<=60 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/60porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>60 &&$value->pacerto<=70 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/70porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>70 &&$value->pacerto<=80 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/80porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto>80 &&$value->pacerto<=90 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/90porcento.PNG')?>" alt="" height="20">
                    <?php } else  if($value->pacerto==100 ){?>    
                        <img src="<?php echo base_url('assets/images/icons/100porcento.PNG')?>" alt="" height="20">
                    <?php }?>
                    <button type="button" id="btn_modal"
                        tabindex="9"
                        class="btn btn-custom waves-effect waves-light btn-micro active
                        btn_modal"
                        onclick="carregamodal(<?=$value->ci_matriz_topico?>);">Descritores
                    </button>

                     <div class="modal fade bs-example-modal-lg" id="modalDescritores<?=$value->ci_matriz_topico?>" >
                          <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                        <h4 class="modal-title"><?=$value->topico?></h4>
                                      </div>
                                      <div class="modal-body" id="divDescritores<?=$value->ci_matriz_topico?>" >
                                            
                                      </div>
                                </div>
                          </div>
                    </div> 
            </div>  
        <?php }?>
    <?php }?>    
    </div>
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

    function validaForm(){
    	var estado=$('#cd_estado').val();
    	var cidade=$('#cd_cidade').val();
    	var etapa=$('#cd_etapa').val();
		var edicao=$('#cd_edicao').val();
		var disciplina=$('#cd_disciplina').val();
		//var avaliacao=$('#cd_avaliacao').val();
		if(estado==''||cidade==''||etapa==''||edicao==''||disciplina==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#painelaprendizagemnew').submit();
			return true;
		}
    }
</script>