<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/relatorio/relatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_aluno.js'); ?>"></script>
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
</script>

	<div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>

	<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Inteligência Pedagógica: Aluno' ?></h4>
            </p>
        </div>
    </div>
    </div>
    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container">
    <div class="container card-box">
        <form action="" method="post" id="acertoerros" name="acertoserros">
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
                                <label for="cd_escola">Escola *</label>
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
                        <div  class="col-lg-2">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep Escola</label>
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
                                <label for="cd_escola">Escola *</label>
                                <select id="cd_escola"
                                        name="cd_escola"
                                        tabindex="4"                                        
                                        class="form-control"
                                        onchange="escola_selecionda(this.value);">
                                    <Option value="" nr_inep=""></Option>                                    
                                    <?php echo $escolas ?>

                                </select>
                            </div>
                        </div>
                    <?php }else{?> <!-- Fim grupo SME -->
                    <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
            		<input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                    <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo $ci_escola;?>">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep da Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="5"
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
                                       tabindex="6"
                                       placeholder="Nome"
                                       class="form-control"
                                       value="<?php echo $nm_escola;?>">
                            </div>
                        </div>
                    <?php }?> <!-- Fim grupo scola -->
                    <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa *</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($etapas as $item) {
                                    ?>

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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa *</label>
                                <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
                                    <Option value=""></Option>
                                    <?php
                                    foreach ($etapas as $item) {
                                        ?>

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
                    <div  class="col-lg-4">
                        <div class="form-group">
                            <label for="nr_anoletivo">Ano Letivo *</label>
                            <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                            <select id="nr_anoletivo" 
                                        name="nr_anoletivo" 
                                        tabindex="3"
                                        class="form-control"                                    
                                        onchange="populaturmaescola($('#cd_etapa').val(),this.value)">
                                    <?php echo $anos ?>
                                </select>
                        </div>
                </div>            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_turma">Turma *</label>
                    <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control"                    		
                            onchange="populaaluno()">
                        <option value="">Selecione uma Turma</option>
                        <?php
                        foreach ($turmas as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_turma; ?>"
                                <?php if (set_value('cd_turma') == $item->ci_turma){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nr_ano_letivo .' - '.$item->nm_turno .' - '. $item->nm_turma; ?>
                            </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="cd_aluno">Aluno *</label>
                    <select id="cd_aluno" name="cd_aluno" tabindex="9" class="form-control"
                            onchange="populadisciplina()">
                        <option value="">Selecione um Aluno</option>
                        <?php
                        foreach ($alunos as $item) {
                            ?><Option value="<?php echo $item->cd_aluno; ?>"
                                <?php if (set_value('cd_aluno') == $item->cd_aluno){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_aluno; ?>
                            </Option>

                        <?php } ?>
                    </select>                    
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
      		<div class="col-md-5">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div>
          </form>   
        </div>    
  </div>
    
    				<div class="card-box table-responsive" id="listagem_resultado">
  					<div class="col-xl-3 col-md-6 mb-4">
  					<fieldset>
                            <legend>FLUÊNCIA</legend>
  						<table class="table table-bordered">
                                          	    		<thead>                                          	    			
                                          	    			<tr>
                                          	    			<?php if(isset($fluencia)){
                                          	    				foreach ($fluencia as $flu){?>
                                          	    					<td><?=$flu->nm_caderno;?></td>
                                          	    				<?php } }?>
                                          	    				</tr>	
                                          	    		</thead>
                                          	    		<tbody>
                                          	    		<tr>                           
                                          	    			<?php if(isset($fluencia)){
                                                                  $estilo='background-color:#E60000';           	    	
                                                                  $valor;
                                              	    		        foreach ($fluencia as $flu){
                                              	    		            if($flu->nr_alternativa_escolhida==1){$estilo='background-color:#E60000';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-NÃO LEITOR';}
                                              	    		            if($flu->nr_alternativa_escolhida==2){$estilo='background-color:#E60000';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-LEITOR DE SÍLABAS';}
                                              	    		            if($flu->nr_alternativa_escolhida==3){$estilo='background-color:#FF9900';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-LEITOR DE PALAVRAS';}
                                              	    		            if($flu->nr_alternativa_escolhida==4){$estilo='background-color:#FF9900';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-LEITOR DE FRASES';}
                                              	    		            if($flu->nr_alternativa_escolhida==5){$estilo='background-color:#006600';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-LEITOR DE TEXTO SEM FLUÊNCIA';}
                                              	    		            if($flu->nr_alternativa_escolhida==6){$estilo='background-color:#006600';
                                              	    		                       $valor=$flu->nr_alternativa_escolhida.'-LEITOR DE TEXTO COM FLUÊNCIA';}                                              	    		            
                                              	    		            ?>                                              	    		        
                                          	    					<td <?='style="'.$estilo.'"'?> >
                                          	    						<label style="color: white">
                                          	    							<?=$valor;?>
                                          	    						</label>
                                          	    					</td>
                                          	    			<?php } }?>
                                              	    	</tr>	
                                          	    		</tbody>
                                          	    </table>
                               </fieldset>           	    
                   </div>
                </div>                          	    	
      		
              <div class="card-box table-responsive" id="listagem_resultado">
              		<fieldset>
                            <legend>INFREQUÊNCIA</legend>
  							<?php if(isset($infrequencia)){
  							       foreach ($infrequencia as $freq){?>   							    
                	      						 <div class="col-xl-3 col-md-6 mb-4">
  													<table class="table table-bordered">
                                          	    		<thead>
                                          	    			<tr>
                                          	    				<td colspan="12">
                                          	    					<label>Número de Faltas por Mês</label>
                                          	    				</td>
                                          	    			</tr>	
                                          	    			<tr>
                                          	    				<td>Jan</td>
                                          	    				<td>Fev</td>
                                          	    				<td>Mar</td>
                                          	    				<td>Abr</td>
                                          	    				<td>Mai</td>
                                          	    				<td>Jun</td>
                                          	    				<td>Jul</td>
                                          	    				<td>Ago</td>
                                          	    				<td>Set</td>
                                          	    				<td>Out</td>
                                          	    				<td>Nov</td>
                                          	    				<td>Dez</td>
                                          	    			</tr>	
                                          	    		</thead>
                                          	    		<tbody>
                                          	    		<tr>                                      	    	
                                              	    		<td><?=$freq->jan?></td>                                      	    	
                                              	    		<td><?=$freq->fev?></td>
                                              	    		<td><?=$freq->mar?></td>
                                              	    		<td><?=$freq->abr?></td>
                                              	    		<td><?=$freq->mai?></td>
                                              	    		<td><?=$freq->jun?></td>
                                              	    		<td><?=$freq->jul?></td>
                                              	    		<td><?=$freq->ago?></td>
                                              	    		<td><?=$freq->set?></td>
                                              	    		<td><?=$freq->out?></td>
                                              	    		<td><?=$freq->nov?></td>
                                              	    		<td><?=$freq->dez?></td>
                                              	    	</tr>	
                                          	    		</tbody>
                                          	    </table>
                                          	  </div>  
                	  	   <?php } } ?>
                	 </fieldset> 	   
  				</div>
  				
<div class="card-box table-responsive" id="listagem_resultado">
  		<div class="col-md-6">
                <div class="form-group col-lg-8">
                    <label >Legenda de Cores </label>
                    <input type="text" id="n1" class="form-control" value="% Acerto: menor ou igual a 25% de acerto no teste"
                           style="color: white; background:#E60000"/>
                    <input type="text" id="n2" class="form-control" value="% Acerto: no intervalo maior que 25% e menor ou igual a 50% de acerto no teste"
                           style="color: white; background:#FF9900"/>
                    <input type="text" id="n3" class="form-control" value="% Acerto: maior do que 50% e menor ou igual a 75% de acerto no teste"
                           style="color: white; background:#81c93a"/>       
                    <input type="text" id="n3" class="form-control" value="% Acerto: maior do que 75% de acerto no teste"
                           style="color: white; background:#006600"/>
                </div>
            </div>
           <div class="col-md-5">
                <div class="form-group col-lg-8">
                    <label >Legenda de Símbolos </label>
                    <input type="text" id="n1" class="form-control" value="N/A - Não existe na Avaliação"/>
                    </br>
                    <img src="http://localhost/saev/assets/images/icons/certo.png" alt="" height="20"> - Acertou </br>
                    </br>	
                    <img src="http://localhost/saev/assets/images/icons/errado.png" alt="" height="20"> - Errou
                </div>
            </div> 
</div>
  				
  				<div class="card-box table-responsive" id="listagem_resultado">
  					<div class="col-xl-3 col-md-6 mb-4 hidden">  					
  						<table class="table table-bordered">
                          <thead>                          	
                          	<tr>
                          	<?php if(isset($registroPacerto)){
                          	    foreach ($registroPacerto as $sintese){?>
                          	        <td><label><?=$sintese->nm_caderno;?></label></td>
                          	        <td><label>Meta</label></td>
                          	    <?php }
                          	}?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          	<?php if(isset($registroPacerto)){
                          	    foreach ($registroPacerto as $sintese){?>
                          	     	<td><label>% Acertos</label></td>
                          	     	<td><label> </label></td>                          	        
                          	    <?php }
                          	}?>
                          	</tr>
                          	<tr>
                          	<?php if(isset($registroPacerto)){
                          	    foreach ($registroPacerto as $sintese){?>                          	   
                          	        <td><?=$sintese->pacerto;?></td>
                          	        <td><?=$sintese->nr_percentual;?></td>
                          	    <?php }
                          	}?>
                          	</tr>
                          </tbody>
                    </table>	
                 </div> 
                </div>               
  				<div class="card-box table-responsive" id="listagem_resultado"> 
  				<fieldset>
                            <legend>SÍNTESE</legend> 					
  						<table class="table table-bordered">
                          <thead>                          	
  						<?php $impressoenturmacao='NAO';
  						    if(isset($registroPacertoM)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoM as $sintese){
                          		        $enturmacao=$sintese->enturmado;
                          		    ?>
                          	        <td colspan="2"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          		<td><label>Enturmação</label></td>
                          	<?php 
                          	foreach ($registroPacertoM as $sintese){?>                          			
                          	    	<td hidden><label>% Participacao</label></td>                          	     	
                          	     	<td><label>% Acertos</label></td>                          	     	                          	        
                          	    <?php }?>
                          	    <td><label> Proficiência</label></td>
                          	    <td><label> Crescimento</label></td>
                          	    <td><label> Meta</label></td>                          	    
                          	</tr>
                          	<tr>
                          	<?php $primeirom=0; $particapacaom=0; $particapacaomu=0;
                          	      $acertom=0; $acertomu=0;
                          	      $cont=0; $somapacerto=0;
                          	      $meta=0;
                          	      $estilo='style="color: white; background:#E60000"';
                          	      foreach ($registroPacertoM as $sintese){
                          	          $meta=$sintese->nr_percentual;
                          	          $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $cont++;
                          	          if($primeirom==0){
                          	          $particapacaom=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertom=round($sintese->pacerto,1);
                          	          $primeirom=1;
                          	          if(round($sintese->pacerto,1)<=25){$estilo='style="color: white; background:#E60000"';}
                          	          if(round($sintese->pacerto,1)>25 && round($sintese->pacerto,1)<=50){$estilo='style="color: white; background:#FF9900"';}
                          	          if(round($sintese->pacerto,1)>50 && round($sintese->pacerto,1)<=75){$estilo='style="color: white; background:#81c93a"';}
                          	          if(round($sintese->pacerto,1)>75){$estilo='style="color: white; background:#006600"';}
                          	      }?>
                          	      <?php if($impressoenturmacao!='SIM'){?>
                          			<td><?=$sintese->enturmado;?></td> <!-- enturmacao -->
                          		  <?php }?>	
                          	    	<td hidden><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td> <!-- participacao -->
                          	    
                          	    	                          	                                  	  
                          	        <td <?=$estilo;?> ><?=round($sintese->pacerto,1);?></td> <!-- acerto -->       
                          	                           	        
                          	    <?php $particapacaomu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertomu=round($sintese->pacerto,1);
                          	          $impressoenturmacao='SIM';
                          	      } ?>                          	                                    	   
                          	    <td
                          	    	<?=(isset($microcadosCaedMat)&&!empty($microcadosCaedMat))?($microcadosCaedMat[0]->estilo):NULL;?> 
                          	    > 
                          	    	<?=(isset($microcadosCaedMat)&&!empty($microcadosCaedMat))?($microcadosCaedMat[0]->ds_descricaofaixa):NULL;?></br>
                          	    	<?=(isset($microcadosCaedMat)&&!empty($microcadosCaedMat))?round($microcadosCaedMat[0]->vl_proficiencia,1):0;?>
                          	    	
                          	    </td>
                          	    <td>%Acerto.<?=round($acertomu-$acertom,1);?></td>
                          	    <td><?=round($meta,1)?></td>	
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    <?php $impressoenturmacao='NAO';
                            if(isset($registroPacertoP)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoP as $sintese){?>
                          	        <td colspan="2"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          	<td><label>Enturmação</label></td>
                          	<?php 
                          	foreach ($registroPacertoP as $sintese){?>                          			
                          	    	<td hidden><label>% Participacao</label></td>                          	     	
                          	     	<td><label>% Acertos</label></td>                       	        
                          	    <?php }?>
                          	    <td><label> Proficiência</label></td>
                          	    <td><label> Crescimento</label></td>
                          	    <td><label> Meta</label></td>
                          	</tr>
                          	<tr>
                          	<?php $primeirop=0; $particapacaop=0; $particapacaopu=0;
                          	      $acertop=0; $acertopu=0;
                          	      $cont=0; $somapacerto=0;
                          	      $meta=0;
                          	      $estilo='style="color: white; background:#E60000"';
                          	foreach ($registroPacertoP as $sintese){
                          	    $meta=$sintese->nr_percentual;
                          	    $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	    $cont++;
                          	    if($primeirop==0){
                          	         $particapacaop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $acertop=$sintese->pacerto;
                          	         $primeirop=1;
                          	         if(round($sintese->pacerto,1)<=25){$estilo='style="color: white; background:#E60000"';}
                          	         if(round($sintese->pacerto,1)>25 && round($sintese->pacerto,1)<=50){$estilo='style="color: white; background:#FF9900"';}
                          	         if(round($sintese->pacerto,1)>50 && round($sintese->pacerto,1)<=75){$estilo='style="color: white; background:#81c93a"';}
                          	         if(round($sintese->pacerto,1)>75){$estilo='style="color: white; background:#006600"';}
                          	    }?>
                          		<?php if($impressoenturmacao!='SIM'){?>
                          			<td><?=$sintese->enturmado;?></td> <!-- enturmacao -->
                          		<?php }?>
                          	    	<td hidden><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td <?=$estilo;?>><?=round($sintese->pacerto,1);?></td>                          	        
                          	    <?php $particapacaopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	    $acertopu=round($sintese->pacerto,1);
                          	    $impressoenturmacao='SIM';
                              }?>                                                              
                                <td <?=(isset($microcadosCaedPort)&&!empty($microcadosCaedPort))?($microcadosCaedPort[0]->estilo):NULL;?> > 
                          	    	<?=(isset($microcadosCaedPort)&&!empty($microcadosCaedPort))?($microcadosCaedPort[0]->ds_descricaofaixa):NULL;?></br>
                          	    	<?=(isset($microcadosCaedPort)&&!empty($microcadosCaedPort))?round($microcadosCaedPort[0]->vl_proficiencia,1):0;?>
                          	    	
                          	    </td>
                          	    <td>%Acerto.<?=round(($acertopu-$acertop),1);?></td>
                          	    <td><?=round($meta,1)?></td>                          	    
                          	</tr>
                          </tbody>                    		
                    <?php }?>                   
                    </table>
                    </fieldset>
                </div>
                        
                                 	    			
  				
    			<div class="card-box table-responsive" id="listagem_resultado">
    			<fieldset>
                            <legend>DESCRITORES - MATEMÁTICA</legend>                                   
                	       <?php //print_r($registrosDescMat); 
                	       if(isset($registrosDescMat)){
                	           $avaliacaoDM='';
                	           $avaliacaoatualDM='';
                	           $headimpresso=0;
                               $colunas=0;
                               $contador=0;
                	           foreach ($registrosDescMat as $resultado=>$valor) {
                                   $contador++;                                                                      
                                   $colunas=explode('&',$valor->colunas);
                                   $provas=explode(',',$valor->provas);                                   
                                   if(($headimpresso==0 )){
                                       ?>                               
                               <table class="table table-striped table-hover">
                    	           	<thead>
                    	           		<tr>
                    	           			<td>Tópico</td>
                    	           			<td>Descritores</td>
                    	           			<?=str_replace('@','</td>',str_replace('&','</td><td>',str_replace('$','<td>',$valor->colunas) ))."<td>CAED</td>";?>

                    	           		</tr>
                    	           	</thead>
                    	           	<tbody>
                    	       <?php $headimpresso=1;}?>
                    	           	                               
                                    <tr>                                
                                 	  <td><?=$valor->nm_matriz_topico;?></td>                                 	  
                                 	  <td><label data-toggle="tooltip" title="<?=$valor->ds_descritor.'-'.$valor->nm_descritor;?>" ><?=$valor->ds_descritor;?></label></td>                             	                                        
                                      <?php if(count($colunas)>0){
                                          for($i=0;$i<count($colunas);$i++){
                                              $caderno=$provas[$i];?>
                                          <td><?php if($valor->$caderno==1){?>
                            					<img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">
                            					<?php }elseif($valor->$caderno==0){?>
                            					<img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                   
                            			  </td> 
                                	<?php } ; 
                                      }
                                    if(isset($microcadosCaedMat)){
                                          ($valor->ds_descritor=='D01')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d001)?$microcadosCaedMat[0]->d001:0))):NULL;
                                          ($valor->ds_descritor=='D02')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d002)?$microcadosCaedMat[0]->d002:0))):NULL;
                                          ($valor->ds_descritor=='D03')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d003)?$microcadosCaedMat[0]->d003:0))):NULL;
                                          ($valor->ds_descritor=='D04')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d004)?$microcadosCaedMat[0]->d004:0))):NULL;
                                          ($valor->ds_descritor=='D05')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d005)?$microcadosCaedMat[0]->d005:0))):NULL;
                                          ($valor->ds_descritor=='D06')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d006)?$microcadosCaedMat[0]->d006:0))):NULL;
                                          ($valor->ds_descritor=='D07')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d007)?$microcadosCaedMat[0]->d007:0))):NULL;
                                          ($valor->ds_descritor=='D08')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d008)?$microcadosCaedMat[0]->d008:0))):NULL;
                                          ($valor->ds_descritor=='D09')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d009)?$microcadosCaedMat[0]->d009:0))):NULL;
                                        
                                          ($valor->ds_descritor=='D10')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d010)?$microcadosCaedMat[0]->d010:0))):NULL;
                                          ($valor->ds_descritor=='D11')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d011)?$microcadosCaedMat[0]->d011:0))):NULL;
                                          ($valor->ds_descritor=='D12')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d012)?$microcadosCaedMat[0]->d012:0))):NULL;
                                          ($valor->ds_descritor=='D13')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d013)?$microcadosCaedMat[0]->d013:0))):NULL;
                                          ($valor->ds_descritor=='D14')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d014)?$microcadosCaedMat[0]->d014:0))):NULL;
                                          ($valor->ds_descritor=='D15')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d015)?$microcadosCaedMat[0]->d015:0))):NULL;
                                          ($valor->ds_descritor=='D16')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d016)?$microcadosCaedMat[0]->d016:0))):NULL;
                                          ($valor->ds_descritor=='D17')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d017)?$microcadosCaedMat[0]->d017:0))):NULL;
                                          ($valor->ds_descritor=='D18')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d018)?$microcadosCaedMat[0]->d018:0))):NULL;
                                          ($valor->ds_descritor=='D19')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d019)?$microcadosCaedMat[0]->d019:0))):NULL;
                                          ($valor->ds_descritor=='D20')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d020)?$microcadosCaedMat[0]->d020:0))):NULL;
                                          ($valor->ds_descritor=='D21')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d021)?$microcadosCaedMat[0]->d021:0))):NULL;
                                          ($valor->ds_descritor=='D22')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d022)?$microcadosCaedMat[0]->d022:0))):NULL;
                                          ($valor->ds_descritor=='D23')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d023)?$microcadosCaedMat[0]->d023:0))):NULL;
                                          ($valor->ds_descritor=='D24')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d024)?$microcadosCaedMat[0]->d024:0))):NULL;
                                          ($valor->ds_descritor=='D25')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d025)?$microcadosCaedMat[0]->d025:0))):NULL;
                                          ($valor->ds_descritor=='D26')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d026)?$microcadosCaedMat[0]->d026:0))):NULL;                                                                                  
                                    }
                                } ?>
                                      
                                    
                                    </tr>
                           			</tbody>

                           	  </table> 
                           <?php }?>
                        </fieldset>                                                      
                    </div>   
                    
                                                
					<div class="card-box table-responsive" id="listagem_resultado">
					<fieldset>
                            <legend>DESCRITORES - PORTUGUÊS</legend>                                   
                	       <?php //print_r($registrosDescMat); 
                	       if(isset($registrosDescPort)){
                	           $avaliacaoDM='';
                	           $avaliacaoatualDM='';
                	           $headimpresso=0;
                	           $colunas=0;
                	           foreach ($registrosDescPort as $resultado=>$valor) {                	                                                
                                   $colunas=explode('&',$valor->colunas);
                                   $provas=explode(',',$valor->provas);                                   
                                   if(($headimpresso==0 )){
                                       ?>                               
                               <table class="table table-striped table-hover">
                    	           	<thead>                    	           		
                    	           		<tr>
                    	           			<td>Tópico</td>
                    	           			<td>Descritores</td>
                    	           			<?=str_replace('@','</td>',str_replace('&','</td><td>',str_replace('$','<td>',$valor->colunas) ))."<td>CAED</td>";?>
                    	           		</tr>
                    	           	</thead>
                    	           	<tbody>
                    	       <?php $headimpresso=1;}?>
                    	           	                               
                               <tr>                                
                                 	  <td><?=$valor->nm_matriz_topico;?></td>
                                 	  <td><label data-toggle="tooltip" title="<?=$valor->ds_descritor.'-'.$valor->nm_descritor;?>" ><?=$valor->ds_descritor;?></label></td>                                 	                                        
                                      <?php if(count($colunas)>0){
                                          for($i=0;$i<count($colunas);$i++){
                                              $caderno=$provas[$i];?>
                                          <td><?php if($valor->$caderno==1){?>
                            					<img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">
                            					<?php }elseif($valor->$caderno==0){?>
                            					<img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                        			  
                            			</td> 
                                	  <?php } 
                                      }             
                                    if(isset($microcadosCaedPort)){
                                                                                                                                
                                          ($valor->ds_descritor=='D01')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d001)?$microcadosCaedPort[0]->d001:0))):NULL;
                                          ($valor->ds_descritor=='D02')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d002)?$microcadosCaedPort[0]->d002:0))):NULL;
                                          ($valor->ds_descritor=='D03')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d003)?$microcadosCaedPort[0]->d003:0))):NULL;
                                          ($valor->ds_descritor=='D04')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d004)?$microcadosCaedPort[0]->d004:0))):NULL;
                                          ($valor->ds_descritor=='D05')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d005)?$microcadosCaedPort[0]->d005:0))):NULL;
                                          ($valor->ds_descritor=='D06')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d006)?$microcadosCaedPort[0]->d006:0))):NULL;
                                          ($valor->ds_descritor=='D07')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d007)?$microcadosCaedPort[0]->d007:0))):NULL;
                                          ($valor->ds_descritor=='D08')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d008)?$microcadosCaedPort[0]->d008:0))):NULL;
                                          ($valor->ds_descritor=='D09')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d009)?$microcadosCaedPort[0]->d009:0))):NULL;
                                        
                                          ($valor->ds_descritor=='D10')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d010)?$microcadosCaedPort[0]->d010:0))):NULL;
                                          ($valor->ds_descritor=='D11')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d011)?$microcadosCaedPort[0]->d011:0))):NULL;
                                          ($valor->ds_descritor=='D12')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d012)?$microcadosCaedPort[0]->d012:0))):NULL;
                                          ($valor->ds_descritor=='D13')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d013)?$microcadosCaedPort[0]->d013:0))):NULL;
                                          ($valor->ds_descritor=='D14')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d014)?$microcadosCaedPort[0]->d014:0))):NULL;
                                          ($valor->ds_descritor=='D15')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d015)?$microcadosCaedPort[0]->d015:0))):NULL;
                                          ($valor->ds_descritor=='D16')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d016)?$microcadosCaedPort[0]->d016:0))):NULL;
                                          ($valor->ds_descritor=='D17')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d017)?$microcadosCaedPort[0]->d017:0))):NULL;
                                          ($valor->ds_descritor=='D18')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d018)?$microcadosCaedPort[0]->d018:0))):NULL;
                                          ($valor->ds_descritor=='D19')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d019)?$microcadosCaedPort[0]->d019:0))):NULL;
                                          ($valor->ds_descritor=='D20')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d020)?$microcadosCaedPort[0]->d020:0))):NULL;
                                          ($valor->ds_descritor=='D21')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d021)?$microcadosCaedPort[0]->d021:0))):NULL;
                                          ($valor->ds_descritor=='D22')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d022)?$microcadosCaedPort[0]->d022:0))):NULL;
                                          ($valor->ds_descritor=='D23')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d023)?$microcadosCaedPort[0]->d023:0))):NULL;
                                          ($valor->ds_descritor=='D24')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d024)?$microcadosCaedPort[0]->d024:0))):NULL;
                                          ($valor->ds_descritor=='D25')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d025)?$microcadosCaedPort[0]->d025:0))):NULL;
                                          ($valor->ds_descritor=='D26')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d026)?$microcadosCaedPort[0]->d026:0))):NULL;
                                                                                                                     
                                    }                           
                                	} ?>
                                    <td></td>
                                </tr>    
                           			</tbody>
                           	  </table> 
                           <?php }?>
                        </fieldset>                                                      
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
    	var etapa=$('#cd_etapa').val();		
    	var turma=$('#cd_turma').val();
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		var aluno=$('#cd_aluno').val();
		$('#carregando').show();
		
		if(etapa==''||disciplina==''||avaliacao==''||turma==''||aluno==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			$('#carregando').hide();
			return false;
		}else{
			$('#acertoerros').submit();
			return true;
		}
    }
</script>