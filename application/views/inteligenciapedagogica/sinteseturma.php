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
                <h4 class="page-title"><?php echo 'Inteligência Pedagógica: Síntese Turma' ?></h4>
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
                            <legend>SÍNTESE</legend>	
  						<table class="table table-bordered">
                          <thead>                          
  						<?php $impressoenturmacao='NAO';
  						if(isset($registroPacertoM)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoM as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          		<td><label>Enturmados</label></td>
                          	<?php 
                          	foreach ($registroPacertoM as $sintese){?>
                          			
                          	    	<td><label>%Participação</label></td>                          	     	
                          	     	<td><label>%Acertos</label></td>                          	     	                          	        
                          	    <?php }?>
                          	    <td><label> Proficiência</label></td>
                          	    <td colspan="4"><label> QT. DE ALUNOS POR NÍVEL</label></td>                          	    
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
                          		<?php if($impressoenturmacao!='SIM'){?>
                          			<td><?=$sintese->enturmado;?></td> <!-- enturmacao -->
                          		<?php }?>
                          		
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=$sintese->pacerto;?></td>                          	        
                          	    <?php $particapacaomu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertomu=$sintese->pacerto;
                          	          $impressoenturmacao='SIM';}?>
                          	                                    	    
                                <td <?=$sintese->estilo?>>
                          	    		<?=!empty($sintese->ds_descricaofaixa)?$sintese->ds_descricaofaixa:NULL?></br>
                          	    		<?=!empty($sintese->proficiencia)?round($sintese->proficiencia,1):NULL?>
                          	    </td>
                          	    <td>ABAIXO DO BÁSICO</br><?=round($sintese->ds_abaixo_basico,1);?></td>	
                          	    <td>BÁSICO</br><?=round($sintese->ds_basico,1);?></td>
                          	    <td>INTERMEDIÁRIO</br><?=round($sintese->ds_intermediario,1);?></td>	
                          	    <td>ADEQUADO</br><?=round($sintese->ds_adequado,1);?></td>
                          	    
                          	    <td>%Part.<?= $particapacaomu-$particapacaom;?></br>
                          	    	%Acerto.<?= $acertomu-$acertom;?></td>
                          	    <td><?=$meta?></td>	
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    <?php $impressoenturmacao='NAO';
                        if(isset($registroPacertoP)){?>
  						  	<tr>
                          		<?php foreach ($registroPacertoP as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          		<td><label>Enturmados</label></td>
                          	<?php                           	 
                          	foreach ($registroPacertoP as $sintese){?>
                          			
                          	    	<td><label>%Participação</label></td>                          	     	
                          	     	<td><label>%Acertos</label></td>                       	        
                          	    <?php }?>
                          	    <td><label> Proficiência</label></td>
                          	    <td colspan="4"><label> QT. DE ALUNOS POR NÍVEL</label></td>
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
                          		<?php if($impressoenturmacao!='SIM'){?>
                          			<td><?=$sintese->enturmado;?></td> <!-- enturmacao -->
                          		<?php }?>
                          		
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=$sintese->pacerto;?></td>                          	        
                          	    <?php $particapacaopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	          $acertopu=$sintese->pacerto;
                          	          $impressoenturmacao='SIM';
                          	}?>
                          	
                          	    <td <?=$sintese->estilo?>>
                          	    		<?=!empty($sintese->ds_descricaofaixa)?$sintese->ds_descricaofaixa:NULL?></br>
                          	    		<?=!empty($sintese->proficiencia)?round($sintese->proficiencia,1):NULL?>
                          	    </td>
                          	    <td>ABAIXO DO BÁSICO</br><?=round($sintese->ds_abaixo_basico,1);?></td>	
                          	    <td>BÁSICO</br><?=round($sintese->ds_basico,1);?></td>
                          	    <td>INTERMEDIÁRIO</br><?=round($sintese->ds_intermediario,1);?></td>	
                          	    <td>ADEQUADO</br><?=round($sintese->ds_adequado,1);?></td>
                          	    
                          	    
                          	    <td>%Part.<?=($particapacaopu-$particapacaop);?></br>
                          	    	%Acerto.<?=($acertopu-$acertop);?></td>
                          	    <td><?=$meta?></td>                          	    
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    <?php if(isset($fluencia)){?>
  						  	<tr>
                          		<?php foreach ($fluencia as $sintese){?>
                          	        <td colspan="3"><label><?=$sintese->nm_caderno;?></label></td>                          	                                  	        
                          	    <?php } ?>
                          	</tr>
                          </thead>
                          <tbody>
                          	<tr>
                          		<td><label>Enturmados</label></td>
                          	<?php 
                          	foreach ($fluencia as $sintese){?>
                          	                          			
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
                          	      foreach ($fluencia as $sintese){
                          	          $meta=$sintese->nr_percentual;
                          	    $somapacerto=$somapacerto+round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	    $cont++;
                          	    if($primeirop==0){
                          	         $particapacaop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $acertop=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	         $primeirop=1;                          	         
                          	    }?>
                          			
                          		<?php if($impressoenturmacao!='SIM'){?>
                          			<td><?=$sintese->enturmado;?></td> <!-- enturmacao -->
                          		<?php }?>
                          	    	<td><?=round(($sintese->fizeram*100/$sintese->enturmado),1)?></td>                          	                                  	  
                          	        <td><?=round(($sintese->fizeram*100/$sintese->enturmado),1);?></td>                          	        
                          	    <?php $particapacaopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	             $acertopu=round(($sintese->fizeram*100/$sintese->enturmado),1);
                          	}?>
                          	
                          	    <td><?=($somapacerto)/$cont?></td>
                          	    <td>%Part.<?=($particapacaopu-$particapacaop);?></br>
                          	    	%Acerto.<?=($acertopu-$acertop);?></td>
                          	    <td><?=$meta?></td>                          	    
                          	</tr>
                          </tbody>                    		
                    <?php }?>
                    </table>
                     </div>
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
                	       <?php 
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
                               <fieldset>
                            		<legend>DESCRITORES - MATEMÁTICA</legend>                         
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
                                          <td><?php if($valor->$caderno!=999){?>
                            					<label> <?=$valor->$caderno?></label>
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                        			  
                            			  </td> 
                                	<?php } ; 
                                      }
                                      if(isset($microcadosCaedMat)){
                                          ($valor->ds_descritor=='D01')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d001)?round($microcadosCaedMat[0]->d001,1):0))):NULL;
                                          ($valor->ds_descritor=='D02')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d002)?round($microcadosCaedMat[0]->d002,1):0))):NULL;
                                          ($valor->ds_descritor=='D03')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d003)?round($microcadosCaedMat[0]->d003,1):0))):NULL;
                                          ($valor->ds_descritor=='D04')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d004)?round($microcadosCaedMat[0]->d004,1):0))):NULL;
                                          ($valor->ds_descritor=='D05')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d005)?round($microcadosCaedMat[0]->d005,1):0))):NULL;
                                          ($valor->ds_descritor=='D06')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d006)?round($microcadosCaedMat[0]->d006,1):0))):NULL;
                                          ($valor->ds_descritor=='D07')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d007)?round($microcadosCaedMat[0]->d007,1):0))):NULL;
                                          ($valor->ds_descritor=='D08')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d008)?round($microcadosCaedMat[0]->d008,1):0))):NULL;
                                          ($valor->ds_descritor=='D09')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d009)?round($microcadosCaedMat[0]->d009,1):0))):NULL;
                                          
                                          ($valor->ds_descritor=='D10')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d010)?round($microcadosCaedMat[0]->d010,1):0))):NULL;
                                          ($valor->ds_descritor=='D11')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d011)?round($microcadosCaedMat[0]->d011,1):0))):NULL;
                                          ($valor->ds_descritor=='D12')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d012)?round($microcadosCaedMat[0]->d012,1):0))):NULL;
                                          ($valor->ds_descritor=='D13')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d013)?round($microcadosCaedMat[0]->d013,1):0))):NULL;
                                          ($valor->ds_descritor=='D14')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d014)?round($microcadosCaedMat[0]->d014,1):0))):NULL;
                                          ($valor->ds_descritor=='D15')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d015)?round($microcadosCaedMat[0]->d015,1):0))):NULL;
                                          ($valor->ds_descritor=='D16')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d016)?round($microcadosCaedMat[0]->d016,1):0))):NULL;
                                          ($valor->ds_descritor=='D17')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d017)?round($microcadosCaedMat[0]->d017,1):0))):NULL;
                                          ($valor->ds_descritor=='D18')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d018)?round($microcadosCaedMat[0]->d018,1):0))):NULL;
                                          ($valor->ds_descritor=='D19')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d019)?round($microcadosCaedMat[0]->d019,1):0))):NULL;
                                          ($valor->ds_descritor=='D20')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d020)?round($microcadosCaedMat[0]->d020,1):0))):NULL;
                                          ($valor->ds_descritor=='D21')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d021)?round($microcadosCaedMat[0]->d021,1):0))):NULL;
                                          ($valor->ds_descritor=='D22')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d022)?round($microcadosCaedMat[0]->d022,1):0))):NULL;
                                          ($valor->ds_descritor=='D23')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d023)?round($microcadosCaedMat[0]->d023,1):0))):NULL;
                                          ($valor->ds_descritor=='D24')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d024)?round($microcadosCaedMat[0]->d024,1):0))):NULL;
                                          ($valor->ds_descritor=='D25')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d025)?round($microcadosCaedMat[0]->d025,1):0))):NULL;
                                          ($valor->ds_descritor=='D26')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedMat[0]->d026)?round($microcadosCaedMat[0]->d026,1):0))):NULL;
                                      }
                                } ?>
                                      
                                    
                                    </tr>
                           			</tbody>

                           	  </table> 
                           	 </fieldset> 
                           <?php }?>                                                   
                    </div>   
                    
                                                
					<div class="card-box table-responsive" id="listagem_resultado">                                   
                	       <?php 
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
                               <fieldset>
                            		<legend>DESCRITORES - PORTUGUÊS</legend>                                  
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
                                          <td><?php if($valor->$caderno!=999){?>
                            					<label> <?=$valor->$caderno?></label>
                            					<?php }else{?>
                            					<label> N/A</label>
                            					<?php }?>                        			  
                            			  </td> 
                                	  <?php } 
                                      }             
                                      if(isset($microcadosCaedPort)){
                                          
                                          ($valor->ds_descritor=='D01')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d001)?round($microcadosCaedPort[0]->d001,1):0))):NULL;
                                          ($valor->ds_descritor=='D02')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d002)?round($microcadosCaedPort[0]->d002,1):0))):NULL;
                                          ($valor->ds_descritor=='D03')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d003)?round($microcadosCaedPort[0]->d003,1):0))):NULL;
                                          ($valor->ds_descritor=='D04')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d004)?round($microcadosCaedPort[0]->d004,1):0))):NULL;
                                          ($valor->ds_descritor=='D05')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d005)?round($microcadosCaedPort[0]->d005,1):0))):NULL;
                                          ($valor->ds_descritor=='D06')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d006)?round($microcadosCaedPort[0]->d006,1):0))):NULL;
                                          ($valor->ds_descritor=='D07')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d007)?round($microcadosCaedPort[0]->d007,1):0))):NULL;
                                          ($valor->ds_descritor=='D08')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d008)?round($microcadosCaedPort[0]->d008,1):0))):NULL;
                                          ($valor->ds_descritor=='D09')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d009)?round($microcadosCaedPort[0]->d009,1):0))):NULL;
                                          
                                          ($valor->ds_descritor=='D10')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d010)?round($microcadosCaedPort[0]->d010,1):0))):NULL;
                                          ($valor->ds_descritor=='D11')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d011)?round($microcadosCaedPort[0]->d011,1):0))):NULL;
                                          ($valor->ds_descritor=='D12')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d012)?round($microcadosCaedPort[0]->d012,1):0))):NULL;
                                          ($valor->ds_descritor=='D13')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d013)?round($microcadosCaedPort[0]->d013,1):0))):NULL;
                                          ($valor->ds_descritor=='D14')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d014)?round($microcadosCaedPort[0]->d014,1):0))):NULL;
                                          ($valor->ds_descritor=='D15')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d015)?round($microcadosCaedPort[0]->d015,1):0))):NULL;
                                          ($valor->ds_descritor=='D16')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d016)?round($microcadosCaedPort[0]->d016,1):0))):NULL;
                                          ($valor->ds_descritor=='D17')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d017)?round($microcadosCaedPort[0]->d017,1):0))):NULL;
                                          ($valor->ds_descritor=='D18')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d018)?round($microcadosCaedPort[0]->d018,1):0))):NULL;
                                          ($valor->ds_descritor=='D19')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d019)?round($microcadosCaedPort[0]->d019,1):0))):NULL;
                                          ($valor->ds_descritor=='D20')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d020)?round($microcadosCaedPort[0]->d020,1):0))):NULL;
                                          ($valor->ds_descritor=='D21')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d021)?round($microcadosCaedPort[0]->d021,1):0))):NULL;
                                          ($valor->ds_descritor=='D22')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d022)?round($microcadosCaedPort[0]->d022,1):0))):NULL;
                                          ($valor->ds_descritor=='D23')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d023)?round($microcadosCaedPort[0]->d023,1):0))):NULL;
                                          ($valor->ds_descritor=='D24')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d024)?round($microcadosCaedPort[0]->d024,1):0))):NULL;
                                          ($valor->ds_descritor=='D25')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d025)?round($microcadosCaedPort[0]->d025,1):0))):NULL;
                                          ($valor->ds_descritor=='D26')?print_r(str_replace('&','</label></td>',str_replace('@','<td><label>',!empty($microcadosCaedPort[0]->d026)?round($microcadosCaedPort[0]->d026,1):0))):NULL;
                                          
                                      }
                                	} ?>
                                    <td></td>
                                </tr>    
                           			</tbody>
                           	  </table> 
                           	  </fieldset>
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
    	var turma=$('#cd_turma').val();
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		$('#carregando').show();
		//var avaliacao=$('#cd_avaliacao').val();
		if(etapa==''||disciplina==''||avaliacao==''||turma==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			$('#carregando').hide();
			return false;
		}else{
			$('#acertoerros').submit();
			return true;
		}
    }
    $(function () {
  	  $('[data-toggle="tooltip"]').tooltip()
  	})
</script>