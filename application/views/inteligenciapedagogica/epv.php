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
                <h4 class="page-title"><?php echo 'Inteligência Pedagógica: EPV' ?></h4>
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

                        <div hidden class="col-lg-3" >

                            <label>Estados *</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">

                                <?php echo $estado ?>

                            </select>
                        </div>
                       
                    <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                        <div class="form-group col-lg-3">
                            <label>Estados *</label>
                            <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                            <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
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
                    <img src="http://localhost/saev/assets/images/icons/certo.png" alt="" height="20" hidden></br>
                    </br>	
                    <img src="http://localhost/saev/assets/images/icons/errado.png" alt="" height="20" hidden>
                </div>
            </div> 
</div>      		
                <div class="card-box table-responsive" id="listagem_resultado">
  				<div class="col-xl-3 col-md-6 mb-4">  					
  						<table class="table table-bordered">
                          <thead>
                          	<tr><th scope="col" colspan="5"><label>EPV- SÍNTESE</label></th></tr>
  						<?php if(isset($registroPacertoM)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoM as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          	<?php 
                          	foreach ($registroPacertoM as $sintese){?>
                          			<td><label>Enturmados</label></td>
                          	    	<td><label>%Participação</label></td>                          	     	
                          	     	<td><label>%Acertos</label></td>                          	     	                          	        
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
                          	      foreach ($registroPacertoM as $sintese){
                          	          $meta=$sintese->nr_percentual;
                          	          $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $cont++;
                          	          if($primeirom==0){
                          	          $particapacaom=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertom=$sintese->pacerto;
                          	          $primeirom=1;
                          	      }?>
                          			<td><?=$sintese->enturmado;?></td>
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=$sintese->pacerto;?></td>                          	        
                          	    <?php $particapacaomu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertomu=$sintese->pacerto;}?>
                          	          
                          	    <td <?=$sintese->estilo?>>
                          	    	NÍVEL:<?=$sintese->ds_descricaofaixa?></BR>
                          	    	NOTA:<?=round($sintese->vl_proficiencia,1)?>
                          	    </td>
                          	    <td>%Participação:<?= round(($particapacaomu-$particapacaom),1);?></br>
                          	    	%Acerto:<?= round(($acertomu-$acertom),1);?></td>
                          	    <td><?=$meta?></td>	                          	    
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    
                    <?php if(isset($registroPacertoP)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoP as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          	<?php 
                          	foreach ($registroPacertoP as $sintese){?>
                          			<td><label>Enturmados</label></td>
                          	    	<td><label>%Participação</label></td>                          	     	
                          	     	<td><label>%Acertos</label></td>                       	        
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
                          	foreach ($registroPacertoP as $sintese){
                          	    $meta=$sintese->nr_percentual;
                          	    $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	    $cont++;
                          	    if($primeirop==0){
                          	         $particapacaop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $acertop=$sintese->pacerto;
                          	         $primeirop=1;                          	         
                          	    }?>
                          			<td><?=$sintese->enturmado;?></td>
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=$sintese->pacerto;?></td>                          	        
                          	    <?php $particapacaopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertopu=$sintese->pacerto;
                          	}?>
                          	
                          	    <td <?=$sintese->estilo?>>
                          	    	NÍVEL:<?=$sintese->ds_descricaofaixa?></BR>
                          	    	NOTA:<?=round($sintese->vl_proficiencia,1)?>
                          	    </td>
                          	    <td>%Participação:<?=round(($particapacaopu-$particapacaop),1);?></br>
                          	    	%Acerto:<?=round(($acertopu-$acertop),1);?></td>
                          	    <td><?=$meta?></td>                           	                             	   
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    
                    <?php if(isset($fluenciaepv)){?>
                          	<tr>
                          		<?php foreach ($fluenciaepv as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>	
                          
                          <tbody> <tr>
                          	<?php 
                          	foreach ($fluenciaepv as $sintese){?>
                          			<td><label>Enturmados</label></td>
                          	    	<td><label>%Participação</label></td>                          	     	
                          	     	<td><label>%Acertos</label></td>                       	        
                          	    <?php }?>
                          	    <td><label> Fluência</label></td>
                          	    <td><label> Crescimento</label></td>
                          	    <td><label> Meta</label></td>                          	    
                          	</tr>
                          	<tr>
                          	<?php $primeirop=0; $particapacaop=0; $particapacaopu=0;
                          	      $acertop=0; $acertopu=0;
                          	      $cont=0; $somapacerto=0;
                          	      $meta=0;
                          	      foreach ($fluenciaepv as $sintese){
                          	          $meta=$sintese->meta;
                          	    $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	    $cont++;
                          	    if($primeirop==0){
                          	         $particapacaop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $acertop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $primeirop=1;                          	         
                          	    }?>
                          			<td><?=$sintese->enturmado;?></td>
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=round(($sintese->fizeram*100/$sintese->enturmado),1);?></td>                          	        
                          	    <?php $particapacaopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	             $acertopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	}?>
                          	
                          	    <td><?=round(($somapacerto)/$cont,1)?></td>
                          	    <td>%Participação:<?=($particapacaopu-$particapacaop);?></br>
                          	    	%Acerto:<?=($acertopu-$acertop);?></td>
                          	    <td><?=$meta?></td>                          	                         	    
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    </table>
                     </div>
                </div>
                
                
 			<?php if(isset($registroEscola)){?>
                <div class="card-box table-responsive" id="listagem_resultado">
                	<div class="col-xl-3 col-md-6 mb-4">
                	<table class="table table-bordered">
                		<?php $headimpressom=0; $headimpressop=0;
                		      $primeiraMt=[]; $primeiraPT=[];
                		      $partMt=[]; $partPt=[];
                		      $nr_maxcadernos=0;
                		      $cont=0;
                	       foreach ($registroEscola as $turma){
                	           ($turma->cd_disciplina==1)?$primeiraMt=explode(',',$turma->pacerto):$primeiraMt;
                	           ($turma->cd_disciplina==2)?$primeiraPT=explode(',',$turma->pacerto):$primeiraPT;
                	           ($turma->cd_disciplina==1)?$partMt=explode(',',$turma->nrpart):$partMt;
                	           ($turma->cd_disciplina==2)?$partPt=explode(',',$turma->nrpart):$partPt;
                	           
                	           if($turma->cd_disciplina==1 && $headimpressom==0){                	                               	               
                	               $nr_maxcadernos=$turma->nrcadernos;?>
                        	       	<thead>
                        	       	<tr><th scope="col" colspan="5"><label>EPV- OBJETIVA - Matemática - POR ESTADO</label></th></tr>
                        	       		<tr>
                        	       			<th scope="col"><label>Estado</label></th>                        	       			
                        	       			<?=str_replace('"','',str_replace(',','',$turma->nm_caderno))?>
                        	       			<th scope="col"><label>Proficiência</label></th>
                        	       			<th scope="col"><label>Crescimento</label></th>                        	       			
                        	       			</tr>
                        	       	</thead>
                        	       	<tbody>
                	       	<?php $headimpressom=1;}
                	       	if($turma->cd_disciplina==2 && $headimpressop==0){
                	       	    $nr_maxcadernos=$turma->nrcadernos;?>
                        	       	<thead>
                        	       		<tr><th scope="col" colspan="5"><label>EPV- OBJETIVA - Português - POR ESTADO</label></th></tr>
                        	       		<tr>
                        	       			<th scope="col"><label>Estado</label></th>
                        	       			<?=str_replace('"','',str_replace(',','',$turma->nm_caderno))?>
                        	       			<th scope="col"><label>Proficiência</label></th>
                        	       			<th scope="col"><label>Crescimento</label></th>                        	       			
                        	       		</tr>	
                        	       	</thead>
                        	       	<tbody>
                	       	<?php $headimpressop=1;}?>                              	
                              		<tr>
                              			<td><?=$turma->nm_estado?></td>
                              				<?=$turma->participacao?>
                              			<?php $cont=($nr_maxcadernos-$turma->nrcadernos);
                              			   while ($cont>0){
                              			   $cont--;?>
                              				<td></td>
                              			<?php }?>	
                              			<td <?=$turma->estilo?>>
                              				NÍVEL:<?=$turma->ds_descricaofaixa?> </br>
                              				NOTA:<?=round($turma->vl_proficiencia,1)?></td>
                              			<td> 
                              			%Participação:<?=($turma->cd_disciplina==1)?
                              			number_format(array_pop($partMt))-number_format($partMt[0]):
                              			number_format(array_pop($partPt))-number_format($partPt[0]);?>
                              			</br>
                              			%Acerto:<?=($turma->cd_disciplina==1)?
                              			number_format(array_pop($primeiraMt))-number_format($primeiraMt[0]):
                              			number_format(array_pop($primeiraPT))-number_format($primeiraPT[0]);?>
                              			</td>                       				
                              		</tr>                              	  							                              
  							<?php } ?>
  							</tbody>	
  					</table>
  					</div>
                </div>
                <?php }?>
                
                <?php if(isset($registroCidade)){?>
                <div class="card-box table-responsive" id="listagem_resultado">
                	<div class="col-xl-3 col-md-6 mb-4">                	
                		<?php $headimpressom=0; $headimpressop=0;
                		      $primeiraMt=[]; $primeiraPT=[];
                		      $partMt=[]; $partPt=[];
                		      $nr_maxcadernos=0;
                		      $cont=0;
                	       foreach ($registroCidade as $turma){                	           
                	           ($turma->cd_disciplina==1)?$primeiraMt=explode(',',$turma->pacerto):$primeiraMt;
                	           ($turma->cd_disciplina==2)?$primeiraPT=explode(',',$turma->pacerto):$primeiraPT;
                	           ($turma->cd_disciplina==1)?$partMt=explode(',',$turma->nrpart):$partMt;
                	           ($turma->cd_disciplina==2)?$partPt=explode(',',$turma->nrpart):$partPt;
                	           
                	           if($turma->cd_disciplina==1 && $headimpressom==0){
                	               $nr_maxcadernos=$turma->nr_cadernos;?>
                	             <table class="table table-bordered">  
                        	       	<thead>
                        	       	<tr><th scope="col" colspan="5"><label>EPV- OBJETIVA - Matemática - POR MUNICÍPIO</label></th></tr>
                        	       		<tr>
                        	       			<th scope="col"><label>Município</label></th>
                        	       			<?=str_replace('"','',str_replace(',','',$turma->nm_caderno))?>
                        	       			<th scope="col"><label>Proficiência</label></th>
                        	       			<th scope="col"><label>Crescimento</label></th>                        	       			
                        	       			</tr>
                        	       	</thead>
                        	       	<tbody>	
                	       	<?php $headimpressom=1;}
                	       	if($turma->cd_disciplina==2 && $headimpressop==0){
                	       	    $nr_maxcadernos=$turma->nr_cadernos;?>
                	       	<table class="table table-bordered">
                        	       	<thead>
                        	       		<tr><th scope="col" colspan="5"><label>EPV- OBJETIVA - Português - POR MUNICÍPIO</label></th></tr>
                        	       		<tr>
                        	       			<th scope="col"><label>Município</label></th>
                        	       			<?=str_replace('"','',str_replace(',','',$turma->nm_caderno))?>
                        	       			<th scope="col"><label>Proficiência</label></th>
                        	       			<th scope="col"><label>Crescimento</label></th>                        	       			
                        	       		</tr>	
                        	       	</thead>
                        	       	<tbody>
                	       	<?php $headimpressop=1;} ?>
                              	
                              		<tr>
                              			<td><?=$turma->nm_cidade?></td>
                              				<?=$turma->participacao?>
                              			<?php $cont=($nr_maxcadernos-$turma->nr_cadernos);
                              			   while ($cont>0){
                              			   $cont--;?>
                              			<td></td>
                              			<?php }?>	
                              			<td <?=$turma->estilo?>>
                              				NÍVEL:<?=$turma->ds_descricaofaixa?> </br>
                              				NOTA:<?=round($turma->vl_proficiencia,1)?></td>
                              			<td> 
                              			%Participação:<?=($turma->cd_disciplina==1)?
                              			number_format(array_pop($partMt))-number_format($partMt[0]):
                              			number_format(array_pop($partPt))-number_format($partPt[0]);?>
                              			</br>
                              			%Acerto:<?=($turma->cd_disciplina==1)?
                              			number_format(array_pop($primeiraMt))-number_format($primeiraMt[0]):
                              			number_format(array_pop($primeiraPT))-number_format($primeiraPT[0]);?>
                              			</td>                                			               			
                              		</tr>
                              	  							
  							<?php } ?>
  							</tbody>	
  					</table>
  					</div>
                </div>
                <?php }?>
               
                <?php if(isset($fluenciaepvmunicipio)){?>
                <div class="card-box table-responsive" id="listagem_resultado">
                	<div class="col-xl-3 col-md-6 mb-4">
                	<table class="table table-bordered">
                		<?php $headimpressop=0;
                		      $primeiraPT=[];$partPt=[];
                		      $nr_maxcadernos=0;
                		      $cont=0;
                	       foreach ($fluenciaepvmunicipio as $turma){                  	           
                	           $primeiraPT=explode(',',$turma->pacerto);                	           
                	           $partPt=explode(',',$turma->particiapacao);
                	                           	           
                	       	if($headimpressop==0){
                	       	    $nr_maxcadernos=$turma->nr_cadernos;?>
                        	       	<thead>
                        	       		<tr><th scope="col" colspan="5"><label>EPV - FLUÊNCIA  - POR MUNICÍPIOS</label></th></tr>
                        	       		<tr>
                        	       			<th scope="col"><label>Município</label></th>
                        	       			<?=str_replace('"','',str_replace(',','',$turma->caderno))?>
                        	       			<th scope="col"><label>Crescimento</label></th>                        	       			                       	       		
                        	       		</tr>	
                        	       	</thead>
                	       	<?php $headimpressop=1;} ?>
                              	<tbody>
                              		<tr>
                              			<td><?=$turma->nm_cidade?></td>                              				
                              			<?php $cont=($nr_maxcadernos-$turma->nr_cadernos);
                              			   while ($cont>0){
                              			   $cont--;?>
                              				<td></td>
                              			<?php }?>
										<?=str_replace('"','',str_replace(',','',$turma->participacao))?>
										<td> 
                              			%Participação:<?=number_format(array_pop($partPt))-number_format($partPt[0]);?></br>                              			
                              			%Fluentes:<?=number_format(array_pop($primeiraPT))-number_format($primeiraPT[0]);?>
                              			</td>                              			                              				
                              		</tr>
                              	</tbody>	  							
  							<?php } ?>
  					</table>
  					</div>
                </div>
                <?php }?>

                    <div class="card-box table-responsive" id="listagem_resultado">                                   
                	       <?php //print_r($registrosDescMat); 
                	       if(isset($registrosDescMat)){
                	           $avaliacaoDM='';
                	           $avaliacaoatualDM='';
                	           $headimpresso=0;
                	           $colunas=0;
                	           foreach ($registrosDescMat as $resultado=>$valor) {
                	               $avaliacaoatualDM=$valor->nm_caderno;                                   
                                   $colunas=explode('&',$valor->colunas);
                                   $provas=explode(',',$valor->provas);                                   
                                   if(($headimpresso==0 ||($avaliacaoatualDM!=$avaliacaoDM) )){
                                       ?>                               
                               <table class="table table-striped table-hover">
                    	           	<thead>
                    	           		<tr><td colspan="3">
                    	           			<span>
                    	           				<label for="cd_aluno">DESCRITORES - MATEMÁTICA</label>
                    	           			</span>
                    	           			</td>
                    	           		</tr>
                    	           		<tr>
                    	           			<td>Tópico</td>
                    	           			<td>Descritores</td>
                    	           			<?=str_replace('@','</td>',str_replace('&','</td><td>',str_replace('$','<td>',$valor->colunas) ))."<td>CAED</td>";?>
                    	           		</tr>
                    	           	</thead>
                    	           	<tbody>
                    	       <?php $headimpresso=1;}
                    	             $avaliacaoDM=$valor->nm_caderno;?>
                    	           	                               
                               <tr>                                
                                 	  <td><?=$valor->nm_matriz_topico;?></td>
                                 	  <td><label data-toggle="tooltip" title="<?=$valor->ds_descritor.'-'.$valor->nm_descritor;?>" ><?=$valor->ds_descritor;?></label></td>                                 	                                        
                                      <?php if(count($colunas)>0){
                                          for($i=0;$i<count($colunas);$i++){
                                              $caderno=$provas[$i];?>
                                          <td><?php if($valor->$caderno!=999){?>
                            					<label> <?=$valor->$caderno?></label>
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                        			  
                            			  </td> 
                                	<?php } 
                                      }
                                	$avaliacaoDM=$valor->nm_caderno;} ?>
                                </tr>    
                           			</tbody>
                           	  </table> 
                           <?php }?>                                                   
                    </div>
                    
    			<div class="card-box table-responsive" id="listagem_resultado">                                   
                	       <?php //print_r($registrosDescMat); 
                	       if(isset($registrosDescPort)){
                	           $avaliacaoDM='';
                	           $avaliacaoatualDM='';
                	           $headimpresso=0;
                	           $colunas=0;
                	           foreach ($registrosDescPort as $resultado=>$valor) {
                	               $avaliacaoatualDM=$valor->nm_caderno;                                   
                                   $colunas=explode('&',$valor->colunas);
                                   $provas=explode(',',$valor->provas);                                   
                                   if(($headimpresso==0 ||($avaliacaoatualDM!=$avaliacaoDM) )){
                                       ?>                               
                               <table class="table table-striped table-hover">
                    	           	<thead>
                    	           		<tr><td colspan="3">
                    	           			<span>
                    	           				<label for="cd_aluno">DESCRITORES - PORTUGUÊS</label>
                    	           			</span>
                    	           			</td>
                    	           		</tr>
                    	           		<tr>
                    	           			<td>Tópico</td>
                    	           			<td>Descritores</td>
                    	           			<?=str_replace('@','</td>',str_replace('&','</td><td>',str_replace('$','<td>',$valor->colunas) ))."<td>CAED</td>";?>
                    	           		</tr>
                    	           	</thead>
                    	           	<tbody>
                    	       <?php $headimpresso=1;}
                    	             $avaliacaoDM=$valor->nm_caderno;?>
                    	           	                               
                               <tr>                                
                                 	  <td><?=$valor->nm_matriz_topico;?></td>
                                 	  <td><label data-toggle="tooltip" title="<?=$valor->ds_descritor.'-'.$valor->nm_descritor;?>" ><?=$valor->ds_descritor;?></label></td>                                 	                                        
                                      <?php if(count($colunas)>0){
                                          for($i=0;$i<count($colunas);$i++){
                                              $caderno=$provas[$i];?>
                                          <td><?php if($valor->$caderno!=999){?>
                            					<label> <?=$valor->$caderno?></label>
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                        			  
                            			  </td> 
                                	<?php } 
                                      }
                                	$avaliacaoDM=$valor->nm_caderno;} ?>
                                </tr>    
                           			</tbody>
                           	  </table> 
                           <?php }?>                                                   
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
    	var ano=$('#nr_anoletivo').val();
		$('#carregando').show();
		//var avaliacao=$('#cd_avaliacao').val();
		if(etapa==''||ano==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			$('#carregando').hide();
			return false;
		}else{
			$('#acertoerros').submit();
			return true;
		}
    }
</script>