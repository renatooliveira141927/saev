<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/relatorio/relatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
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
            <h4 class="page-title"><?php echo 'Inteligência Pedagógica: Turma' ?></h4>
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
                            onchange="populadisciplina()">
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
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control"
                            onchange="populaavalicao()">
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
                    <label for="cd_avaliacao">Avaliação *</label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control"
                                onchange="buscaencerramentomunicipio()">
                        <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        <?php
                        foreach ($avaliacoes as $item) {
                            ?>

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
            <div  class="col-md-5" hidden>
                <div class="form-group">
                    <label for="dataLimite">Liberação dos relatórios a partir de:</label>                 
                    <input type="text" id="dataLimite" name="datalimite" class="form-control" readonly="true"
                    value="<?=$dataLimite ?>">
                </div>                     
        	</div>
        	<div  class="col-md-12"  hidden>
            	<div class="form-group">
                	<label for="bloqueia" style="color:#E60000 " >Os resultados só estarão disponíveis para consulta após o término da data de Liberação dos relátórios</label>
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
                    <img src="http://localhost/saev/assets/images/icons/certo.png" alt="" height="20"> - Acertou </br>
                    </br>	
                    <img src="http://localhost/saev/assets/images/icons/errado.png" alt="" height="20"> - Errou
                </div>
            </div> 
	</div>
	<?php $estilo='style="color: white; background:#E60000"';?>
    <div class="card-box table-responsive" id="listagem_resultado"> 
    			<table class="table table-bordered">
    				<thead>
    					<tr> 
    						<th colspan="3">Médias</th>
    					</tr>
    					<tr>	
    						<th>Município</th>
    						<th>Escola</th>
    						<th>Turma</th>
    					</tr>	
    				</thead>    					
    				<tbody>
    					<tr>
    						<td><?=isset($pacertocidade)?round($pacertocidade[0]->pacertomunicipio,1):0 ?></td>
    						<td><?=isset($pacertoescola)?round($pacertoescola[0]->pacertoescola,1):0 ?></td>
    						<td><?=isset($pacertoturma)?round($pacertoturma[0]->pacertoturma,1):0 ?></td>
    					</tr>
    				</tbody>	
    			</table>                  
                
                <table class="table table-bordered">
                <?php $ultimaquestao=0;?>
                	<tr>
                        <td>TÓPICOS:</td>
                        <?php 
                        if (isset($topicos)) {
                            foreach ($topicos as $result) {?>
                            	<td align="center" colspan='<?=$result->colspan;?>'>
                            		<?=$result->nm_matriz_topico?>
                            	</td>	
                            <?php } 
                        }?>                        
                    </tr>
                        	
                    <tr>
                        <td>Estudante</td>
                    <!-- Monta a tabale com as questões dinâmicamente -->
                    <?php 
                    if (isset($avaliacao)) {
                        foreach ($avaliacao as $result) { ?>
                            <td align="center">
                                <?= $result->nr_questao?><br/>
                                <?= $result->descritor?> 
                            </td>
                        <?php }
                        $ultimaquestao=$result->nr_questao;                        
                    }?>
                       <td align="center">Total Aluno %</td>                       
                    </tr>
                    <?php $alunoAtual=0;
                    $pacertos=0;
                    $nr_acertos=0;
                    $nr_erro=0;
                    $impresso=0;
                    $impressopercent=false;
                    if(isset($registrosDesc)){
                        $total=count(array_keys($registrosDesc))-1;                        
                        foreach ($registrosDesc as $resultado=>$valor) {
                            //IMPRIME ALUNO
                            if($alunoAtual!=$valor->ci_aluno){?>
                                <tr>
                                <td><?= $valor->ci_aluno; ?>-<?= $valor->nm_aluno; ?>
                                	</br>
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" 
                                    		data-target="#collapseExample<?= $valor->ci_aluno; ?>" aria-expanded="false">
        									Frequencia
        							</button>
                                    	<div class="collapse" id="collapseExample<?= $valor->ci_aluno; ?>"
                                    			aria-labelledby="headingTwo" data-parent="#accordion">
                                          <div class="card card-body">                                      		                                      	
                                            <?php 
                                            foreach ($infrequencia as $freq){
                                          	    if($freq->ci_aluno==$valor->ci_aluno){?>
                                          	    	<table class="table table-striped table-hover">
                                          	    		<thead><tr>
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
                                            <?php } }?>                                        
                                          </div>
                                        </div>
                                        
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" 
                                    		data-target="#collapsefluencia<?= $valor->ci_aluno; ?>" aria-expanded="false">
        									Fluência
        								</button>
                                    	<div class="collapse" id="collapsefluencia<?= $valor->ci_aluno; ?>"
                                    			aria-labelledby="headingTwo" data-parent="#accordion">
                                          <div class="card card-body">                                      		                                      	                                                                                           
                                        		<table class="table table-striped table-hover">
                                          	    		<thead><tr>
                                          	    				<?php foreach ($fluencia as $flu){
                                                                 if($flu->cd_aluno==$valor->ci_aluno){?>
                                          	    					<td><?=$flu->nm_caderno;?></td>
                                          	    				<?php }}?>
                                          	    				</tr>	
                                          	    		</thead>
                                          	    		<tbody>
                                          	    		<tr>                                      	    	
                                              	    		<?php foreach ($fluencia as $flu){
                                                                 if($flu->cd_aluno==$valor->ci_aluno){
                                          	    					if($flu->nr_alternativa_escolhida==1){?>
                                              	    					<td style="background-color:#E60000">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-NÃO LEITOR'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }
                                          	    					if($flu->nr_alternativa_escolhida==2){?>
                                              	    					<td style="background-color:#E60000">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-LEITOR DE SÍLABAS'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }
                                          	    					if($flu->nr_alternativa_escolhida==3){?>
                                              	    					<td style="background-color:#FF9900">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-LEITOR DE PALAVRAS'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }
                                          	    					if($flu->nr_alternativa_escolhida==4){?>
                                              	    					<td style="background-color:#FF9900">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-LEITOR DE FRASES'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }
                                          	    					if($flu->nr_alternativa_escolhida==5){?>
                                              	    					<td style="background-color:#006600">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-LEITOR DE TEXTO SEM FLUÊNCIA'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }
                                          	    					if($flu->nr_alternativa_escolhida==6){?>
                                              	    					<td style="background-color:#006600">
                                              	    						<label style="color: white">
                                              	    						<?=$flu->nr_alternativa_escolhida.'-LEITOR DE TEXTO COM FLUÊNCIA'?>
                                              	    						</label>
                                              	    					</td>
                                          	    					<?php }?>
                                          	    				
                                          	    			<?php }}?>
                                              	    	</tr>	
                                          	    		</tbody>
                                          	    </table>                                                                                   
                                          </div>
                                        </div>
                                	
                                </td>
                            <?php $alunoAtual=$valor->ci_aluno;
                                $pacertos=0;$nr_acertos=0;$nr_erro=0;
                                $impressopercent=false;}?>                            
                            
                            <?php //IMPRIME ITENS
                            if($alunoAtual==$valor->ci_aluno){                                 
                                if($valor->acertos==1 && $valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_acertos++;?>
                                    <td align="center">
                                    <?php //echo $valor->nr_questao;?>
                                        <img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">                                        
                                        <span class="tooltip"><?=$valor->descritor?></span>
                                    </td>                                    
                           		<?php }else if($valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_erro++;?>
                                   <td align="center"> 
                                   <?php //echo $valor->nr_questao;?>
                                    <img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">                                    
                                    <span class="tooltip"><?=$valor->descritor?></span>
                                   </td> 
                                <?php } $impresso=$valor->nr_questao;?>
                                
                              	<?php if($impresso==$ultimaquestao && !$impressopercent){
                              			$pacertos =round(( ($nr_acertos*100)/($nr_acertos+$nr_erro)),1);
                              			
                              			if(($pacertos)<=25){$estilo='style="color: white; background:#E60000"';}
                              			if(($pacertos)>25 && ($pacertos)<=50){$estilo='style="color: white; background:#FF9900"';}
                              			if(($pacertos)>50 && ($pacertos)<=75){$estilo='style="color: white; background:#81c93a"';}
                              			if(($pacertos)>75){$estilo='style="color: white; background:#006600"';}                              			
                              			?>
                                		<td <?=$estilo;?>  align="center"><?=$pacertos?></td></tr>                                                                            
                          		<?php  $impressopercent=true;   }?>
                          <?php }
                        }
                    }?>
                </table>
               <table class="table table-bordered">
               		<tr><td>Total de acertos:</td>
               		<?php if(isset($totalacerto)){
               		    foreach ($totalacerto as $result) {
               		        $pacertos=round(( ($result->sum*100)/($result->nr)),1);
               		        if(($pacertos)<=25){$estilo='style="color: white; background:#E60000"';}
               		        if(($pacertos)>25 && ($pacertos)<=50){$estilo='style="color: white; background:#FF9900"';}
               		        if(($pacertos)>50 && ($pacertos)<=75){$estilo='style="color: white; background:#81c93a"';}
               		        if(($pacertos)>75){$estilo='style="color: white; background:#006600"';}?>
                    		<td <?=$estilo;?> align="center"><?=$pacertos;?> %</td>                    	                
                	<?php } }?>
                	</tr>	
               	<tr><td>Distrator mais marcado:</td> 
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?=$result->nr_alternativa_escolhida?></td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
                <tr><td>% Distrator mais marcado:</td>
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?= $result->count?> %</td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
            </table>                    
    </div>
   
     <div>
    	
    	<table class="table table-bordered">
                <?php $ultimaquestao=0;?>
                	<tr>
                        <td>MUNICÍPIO</td>
                    </tr>
                	<tr>
                        <td>TÓPICOS:</td>
                        <?php 
                        if (isset($topicos)) {
                            foreach ($topicos as $result) {?>
                            	<td align="center" colspan='<?=$result->colspan;?>'>
                            		<?=$result->nm_matriz_topico?>
                            	</td>	
                            <?php } 
                        }?>                        
                    </tr>
                        	
                    <tr>
                        <td>ESCOLA</td>
                    <!-- Monta a tabale com as questões dinâmicamente -->
                    <?php 
                    if (isset($avaliacao)) {
                        foreach ($avaliacao as $result) { ?>
                            <td align="center">
                                <?= $result->nr_questao?><br/>
                                <?= $result->descritor?> 
                            </td>
                        <?php }
                        $ultimaquestao=$result->nr_questao;                        
                    }?>
                       <td align="center">Total Aluno %</td>                       
                    </tr>
                    <?php $escolaAtual=0;
                    $pacertos=0;
                    $nr_acertos=0;
                    $nr_erro=0;
                    $impresso=0;
                    $impressopercent=false;
                    if(isset($registrosDescMunicipio)){
                        $total=count(array_keys($registrosDescMunicipio))-1;                        
                        foreach ($registrosDescMunicipio as $resultado=>$valor) {
                            //IMPRIME ALUNO
                            if($escolaAtual!=$valor->ci_escola){?>
                                <tr>
                                <td><?= $valor->ci_escola; ?>-<?= $valor->nm_escola; ?>
                                	</br>
                                    	<div class="collapse" id="collapseExample<?= $valor->ci_escola; ?>"
                                    			aria-labelledby="headingTwo" data-parent="#accordion">                                          
                                        </div>
                                </td>
                            <?php $escolaAtual=$valor->ci_escola;
                                $pacertos=0;$nr_acertos=0;
                                $fizeram=0;$nr_erro=0;
                                $impressopercent=false;}?>                            
                            
                            <?php //IMPRIME ITENS
                            if($escolaAtual==$valor->ci_escola){                                
                                if($valor->acertos==1 && $valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_acertos=$nr_acertos+$valor->acertos;
                                    $fizeram=$fizeram+$valor->fizeram;?>
                                    <td align="center">
                                    <?php echo round(($valor->acertos*100/$valor->fizeram),1);?>                                        
                                    </td>                                    
                           		<?php }else if($valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                           		    $nr_acertos=$nr_acertos+$valor->acertos;
                           		    $fizeram=$fizeram+$valor->fizeram;?>
                                   <td align="center"> 
                                   <?php echo round(($valor->acertos*100/$valor->fizeram),1);?>                                    
                                   </td> 
                                <?php } $impresso=$valor->nr_questao;?>
                                
                              	<?php if($impresso==$ultimaquestao && !$impressopercent){
                              	    $pacertos =round(( ($nr_acertos*100)/($fizeram)),1);
                              	    if(($pacertos)<=25){$estilo='style="color: white; background:#E60000"';}
                              	    if(($pacertos)>25 && ($pacertos)<=50){$estilo='style="color: white; background:#FF9900"';}
                              	    if(($pacertos)>50 && ($pacertos)<=75){$estilo='style="color: white; background:#81c93a"';}
                              	    if(($pacertos)>75){$estilo='style="color: white; background:#006600"';}
                              	    ?>
                                		<td <?=$estilo;?> align="center"><?=$pacertos?></td></tr>                                                                            
                          		<?php  $impressopercent=true;   }?>
                          <?php }
                        }
                    }?>
                </table>
               <table class="table table-bordered">
               		<tr><td>Total de acertos:</td>
               		<?php if(isset($totalacerto)){
               		    foreach ($totalacerto as $result) {
               		        $pacertos=round(( ($result->sum*100)/($result->nr)),1);
               		        if(($pacertos)<=25){$estilo='style="color: white; background:#E60000"';}
               		        if(($pacertos)>25 && ($pacertos)<=50){$estilo='style="color: white; background:#FF9900"';}
               		        if(($pacertos)>50 && ($pacertos)<=75){$estilo='style="color: white; background:#81c93a"';}
               		        if(($pacertos)>75){$estilo='style="color: white; background:#006600"';}
               		        ?>
                    		<td <?=$estilo;?> align="center"><?=$pacertos?> %</td>                    	                
                	<?php } }?>
                	</tr>	
               	<tr><td>Distrator mais marcado:</td> 
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?=$result->nr_alternativa_escolhida?></td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
                <tr><td>% Distrator mais marcado:</td>
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?= $result->count?> %</td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
            </table>
    	
    </div>
    
      <div>
    	
    	<table class="table table-bordered">
                <?php $ultimaquestao=0;?>
                	<tr>
                        <td>EPV</td>
                    </tr>
                	<tr>
                        <td>TÓPICOS:</td>
                        <?php 
                        if (isset($topicos)) {
                            foreach ($topicos as $result) {?>
                            	<td align="center" colspan='<?=$result->colspan;?>'>
                            		<?=$result->nm_matriz_topico?>
                            	</td>	
                            <?php } 
                        }?>                        
                    </tr>
                        	
                    <tr>
                        <td>MUNICÍPIO</td>
                    <!-- Monta a tabale com as questões dinâmicamente -->
                    <?php 
                    if (isset($avaliacao)) {
                        foreach ($avaliacao as $result) { ?>
                            <td align="center">
                                <?= $result->nr_questao?><br/>
                                <?= $result->descritor?> 
                            </td>
                        <?php }
                        $ultimaquestao=$result->nr_questao;                        
                    }?>
                       <td align="center">Total Aluno %</td>                       
                    </tr>
                    <?php $escolaAtual=0;
                    $pacertos=0;
                    $nr_acertos=0;
                    $nr_erro=0;
                    $impresso=0;
                    $impressopercent=false;
                    if(isset($registrosDescEpv)){
                        $total=count(array_keys($registrosDescEpv))-1;                        
                        foreach ($registrosDescEpv as $resultado=>$valor) {
                            //IMPRIME ALUNO
                            if($escolaAtual!=$valor->ci_cidade){?>
                                <tr>
                                <td><?= $valor->ci_cidade; ?>-<?= $valor->nm_cidade; ?>
                                	</br>
                                    	<div class="collapse" id="collapseExample<?= $valor->ci_cidade; ?>"
                                    			aria-labelledby="headingTwo" data-parent="#accordion">                                          
                                        </div>
                                </td>
                            <?php $escolaAtual=$valor->ci_cidade;
                                $pacertos=0;$nr_acertos=0;
                                $fizeram=0;$nr_erro=0;
                                $impressopercent=false;}?>                            
                            
                            <?php //IMPRIME ITENS
                            if($escolaAtual==$valor->ci_cidade){                                
                                if($valor->acertos==1 && $valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_acertos=$nr_acertos+$valor->acertos;
                                    $fizeram=$fizeram+$valor->fizeram;?>
                                    <td align="center">
                                    <?php echo round(($valor->acertos*100/$valor->fizeram),1);?>                                        
                                    </td>                                    
                           		<?php }else if($valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                           		    $nr_acertos=$nr_acertos+$valor->acertos;
                           		    $fizeram=$fizeram+$valor->fizeram;?>
                                   <td align="center"> 
                                   <?php echo round(($valor->acertos*100/$valor->fizeram),1);?>    
                                   </td> 
                                <?php } $impresso=$valor->nr_questao;?>
                                
                              	<?php if($impresso==$ultimaquestao && !$impressopercent){
                              	    $pacertos =round(( ($nr_acertos*100)/($fizeram)),1);
                              	    
                              	    if(($pacertos)<=25){$estilo='style="color: white; background:#E60000"';}
                              	    if(($pacertos)>25 && ($pacertos)<=50){$estilo='style="color: white; background:#FF9900"';}
                              	    if(($pacertos)>50 && ($pacertos)<=75){$estilo='style="color: white; background:#81c93a"';}
                              	    if(($pacertos)>75){$estilo='style="color: white; background:#006600"';}
                              	    ?>
                                		<td <?=$estilo?> align="center"><?=$pacertos?></td></tr>                                                                            
                          		<?php  $impressopercent=true;   }?>
                          <?php }
                        }
                    }?>
                </table>
               <table class="table table-bordered">
               		<tr><td>Total de acertos:</td>
               		<?php if(isset($totalacerto)){
               		    foreach ($totalacerto as $result) {
               		        $acertotal=round(( ($result->sum*100)/($result->nr)),1);
               		        
               		        if(($acertotal)<=25){$estilo='style="color: white; background:#E60000"';}
               		        if(($acertotal)>25 && ($acertotal)<=50){$estilo='style="color: white; background:#FF9900"';}
               		        if(($acertotal)>50 && ($acertotal)<=75){$estilo='style="color: white; background:#81c93a"';}
               		        if(($acertotal)>75){$estilo='style="color: white; background:#006600"';}
               		        ?>
               		        
                    		<td <?=$estilo?> align="center"><?=round(( ($result->sum*100)/($result->nr)),1);?> %</td>                    	                
                	<?php } }?>
                	</tr>	
               	<tr><td>Distrator mais marcado:</td> 
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?=$result->nr_alternativa_escolhida?></td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
                <tr><td>% Distrator mais marcado:</td>
                <?php $itemimpresso=0; 
                    if(isset($distratores)){
                    foreach ($distratores as $result) {
                        if($itemimpresso!=$result->nr_questao){?>
                    		<td align="center"><?= $result->count?> %</td>                    	                
                <?php } $itemimpresso=$result->nr_questao;}}?>
                </tr>
            </table>
    	
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
		
		if(etapa==''||disciplina==''||avaliacao==''||turma==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			$('#carregando').hide();
			return false;
		}else{
			$('#acertoerros').submit();
			return true;
		}
    }
</script>