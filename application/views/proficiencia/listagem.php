<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/metasaprendizagem.js'); ?>"></script>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar cadastros de Proficiência'?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('proficiencia/proficiencia/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container card-box">
        <form action="<?php echo base_url('proficiencia/proficiencia/listar'); ?>" method="post" id="consulta" name="consulta">            
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        	<!-- 
        		<div class="col-lg-3">
                            <label>Estados</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">
                                <?php echo $estado ?>
                            </select>
                 </div>
                 <div class="col-lg-3">
                            <div  class="form-group">
                                <label>Municípios</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="2"
                                        class="form-control" >
                                        <?php echo $cidade ?>
                                </select>
                            </div>
                 </div>
                 <div  class="col-lg-3">
                        <div class="form-group">
                            <label for="nr_anoletivo">Ano Letivo *</label>
                            <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                            <select id="nr_anoletivo" 
                                        name="nr_anoletivo" 
                                        tabindex="3"
                                        class="form-control">
                                    <?php echo $anos ?>
                                </select>
                        </div>
                </div>
                <div  class="col-lg-3">
                        <div class="form-group">
                            <label for="cd_disciplina">Disciplina</label>                            
                            <select id="cd_disciplina" 
                                        name="cd_disciplina" 
                                        tabindex="3"
                                        class="form-control">
                                    <Option value=""></Option>
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
                                <Option value="99">LEITURA</Option>
                            </select>
                      </div>
                </div>
                 -->
                 <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa </label>
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa </label>
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
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_descricaofaixa">Nível </label>
                            <select id="cd_descricaofaixa" name="cd_descricaofaixa" tabindex="7" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($descricaofaixa as $item) {
                                    ?>

                                    <Option value="<?php echo $item->ci_descricaofaixa; ?>"
                                    <?php if (set_value('cd_descricaofaixa') == $item->ci_descricaofaixa){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->ds_descricaofaixa; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                 
                <div class="col-md-5">
                <div class="form-group">
                    <button type="button" id="btn_consulta"
                            tabindex="9" onclick="validaForm();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Consultar
                    </button>
                </div>
            </div>
      		<div class="col-md-5">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div>                   
    </form>       
  </div>  
  
  <div class="container card-box"> 
        <div class="table-responsive" id="listagem_resultado">
        	<div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                	<thead>	
                    	<tr>
                    		<td> </td>
                    		<td>Etapa</td>                    		                        
                    		<td>Nivel</td>
                        	<td align="center">Início</td>
                        	<td align="center">Fim</td>                                                                                                                
                        	<td align="center"></td>
                    	</tr>
                 	</thead>
                 	<tbody>
                 	<?php $count=0; 
                 	if(!empty($proficiencias)){
                 	    foreach ($proficiencias as $result) {
                    	       $count++;?>
                 		<tr>
                 			<td><?php echo $count; ?></td>
                 			<td><?php echo $result->nm_etapa; ?></td>
                 			<td><?php echo $result->ds_descricaofaixa; ?></td>
                 			<td align="center"><?php echo $result->nr_inicio; ?></td>
                 			<td align="center"><?php echo $result->nr_fim; ?></td>                 			                 			
                 			<td style="width:30px;padding:0px 2px;" ><a  type="button" title="Editar"
                 				href="<?php echo base_url('proficiencia/proficiencia/editar/'.$result->ci_faixa_proficiencia) ?>"
                 				style="width: 50px;height: 33px"
                 				class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-edit"></a>
                 			</td>
                 		</tr>
                 	<?php } }else{?>
                 		<tr>
                 			<td colspan="8">Nenhum dado encontrado</td>
                 		</tr>	
                 	<?php }?>	
                 	</tbody>   
                </table>
            </div>
         </div>
   </div>         