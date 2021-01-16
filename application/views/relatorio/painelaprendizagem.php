<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/relatorio/relatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_topicos.js'); ?>"></script>
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
        $('#cd_etapa').removeAttr('disabled');
        //populaturma('',id_escola, '', cd_turma);
    }
</script>
<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Situação de Aprendizagem' ?></h4>
            </p>
        </div>
    </div>
	<div class="container card-box">
        <form action="" method="post" id="painelaprendizagem" name="painelaprendizagem">
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
                            <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                            <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                        </div>
                        <div class="col-lg-9">
                            <div  class="form-group">
                                <label>Municípios *</label>
                                <input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
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
                                <label for="nm_escola">Nome da escola *</label>
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
                    <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa *</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="5" class="form-control"
                                    onchange="populadisciplina()">
                                <Option value=""></Option>
                                <?php foreach ($etapas as $item) {?>
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
                    <?php }else{?>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa *</label>
                                <select id="cd_etapa" name="cd_etapa" tabindex="5" class="form-control"
                                        onchange="populadisciplina()">
                                    <Option value=""></Option>
                                    <?php foreach ($etapas as $item) {?>
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
                    <?php } ?>
        
        <div class="col-md-5">
            <div class="form-group">
                <label for="cd_disciplina">Disciplina *</label>
                <select id="cd_disciplina" name="cd_disciplina" tabindex="6" class="form-control">
                    <option value="">Selecione uma Disciplina</option>
                    <?php foreach ($disciplinas as $item) {
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
        <div  class="col-lg-4">
                    <div class="form-group">
                        <label for="nr_anoletivo">Ano Letivo *</label>
                        <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                        <select id="nr_anoletivo" 
                                    name="nr_anoletivo" 
                                    tabindex="3"
                                    class="form-control"                                    
                                    onchange="populaavalicao()">
                                <?php echo $anos ?>
                            </select>
                    </div>
                </div>

        <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_avaliacao">Avaliação *</label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="7" class="form-control"
                            onchange="buscaencerramentomunicipio();" >
                        <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        <?php foreach ($avaliacoes as $item) { ?>
                            <Option value="<?php echo $item->ci_avaliacao_upload; ?>"
                                <?php if (set_value('cd_avaliacao') == $item->ci_avaliacao_upload){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_caderno; ?>
                            </Option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <div  class="col-md-4">
            <div class="form-group">
                <label for="dataLimite">Liberação dos relatórios a partir de:</label>                 
                <input type="text" id="dataLimite" name="datalimite" class="form-control" readonly="true"
                value="<?=$dataLimite ?>">
            </div>                     
        </div>
        <div  class="col-md-12">
            <div class="form-group">
                <label for="bloqueia" style="color:#E60000 " >Os resultados só estarão disponíveis para consulta após o término da data de Liberação dos relátórios</label>
            </div>                     
        </div>


        <div class="col-md-12">
            <div class="form-group col-lg-12" style="display: none;">
                <label >Legenda de Cores </label>
                <input type="text" id="n1" class="form-control" value="Menor Desempenho: menor ou igual a 25% de acerto no teste"style="color: white; background:#E60000"/>
                <input type="text" id="n2" class="form-control" value="Desempenho Mediano: no intervalo maior que 25% e menor ou igual a 50% de acerto no teste"
                       style="color: white; background:#FF9900 "/>
                <input type="text" id="n2" class="form-control" value="Desempenho Mediano para Baixo: no intervalo maior que 50% e menor ou igual a 75% de acerto no teste"
                       style="color: white; background:#81c93a "/>       
                <input type="text" id="n3" class="form-control" value="Melhor Desempenho: maior do que 75% de acerto no teste"
                       style="color: white; background:#006600"/>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <button type="button" id="btn_consultaestudante"
                        tabindex="9" onclick="validaForm();"
                        class="btn btn-custom waves-effect waves-light btn-micro active">
                    Gerar
                </button>
            </div>
        </div>    
         <div class="col-md-5" style="display: none;">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div> 
</form>
</div>
<div class="card-box " id="listagem_resultado">
    <div class="table-responsive align-text-middle">
    	 <div class="col-md-3" id="tabs-4">
                <input type="text" id="n4" class="form-control"
                        value="Melhor Desempenho"
                       style="color: white; background:#006600"/>
                <div class="col-xs-12 text-center">                  
                    <?php if(isset($registrosDesc)){?>
                    <?php  foreach($registrosDesc as $nivel){?>
                    <?php if($nivel->ci_nivel_desempenho=="4"){?>                        
                                <label style="color: #006600;"
                                    ><?=$nivel->escola?></label>
                                <label><?=$nivel->pacerto?>% de acerto</label>                            
                    <?php } }}?>
                </div>
            </div>	
         <div class="col-md-3" id="tabs-3">
                <input type="text" id="n3" class="form-control"
                        value="Desempenho Mediano"
                       style="color: white; background:#81c93a"/>
                <div class="col-xs-12 text-center">                  
                    <?php if(isset($registrosDesc)){?>
                    <?php  foreach($registrosDesc as $nivel){?>
                    <?php if($nivel->ci_nivel_desempenho=="3"){?>                        
                                <label style="color: #81c93a;"
                                    ><?=$nivel->escola?></label>
                                <label><?=$nivel->pacerto?>% de acerto</label>                            
                    <?php } }}?>
                </div>
            </div>                
            <div class="col-md-3" id="tabs-2">
                <input type="text" id="n2" class="form-control"
                       value="Desempenho Mediano para Baixo"
                       style="color: white; background:#FF9900 "/>
                <div class="col-xs-12 text-center">
                    <?php if(isset($registrosDesc)){?>
                <?php  foreach($registrosDesc as $nivel){?>                
                <?php  if($nivel->ci_nivel_desempenho=="2"){?>                                           
                        <div class="col-xs-12 text-center">
                            <label style="color: #FF9900;"
                             ><?=$nivel->escola?></label>
                            <label><?=$nivel->pacerto?>% de acerto</label>
                        </div>
                <?php }}}?>
                </div>
            </div> 
            <div class="col-md-3" id="tabs-1">
                <input type="text" id="n1" class="form-control" 
                		value="Menor Desempenho"
                       style="color: white; background:#E60000 "/>
                <div class="col-xs-12 text-center">
                    <?php if(isset($registrosDesc)){?>
                <?php  foreach($registrosDesc as $nivel){?>
                <?php  if($nivel->ci_nivel_desempenho=="1"){?>                                            
                        <div class="col-xs-12 text-center">
                            <label style="color: #E60000"
                            ><?=$nivel->escola?></label>
                            <label><?=$nivel->pacerto?>% de acerto </label>
                        </div>
                    
                <?php }}}?>
                </div>
            </div>                                     
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
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		var escola=$('#cd_escola').val();
		//var avaliacao=$('#cd_avaliacao').val();
		if(estado==''||cidade==''||etapa==''||disciplina==''||avaliacao==''||escola==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#painelaprendizagem').submit();
			return true;
		}
    }
    
</script>