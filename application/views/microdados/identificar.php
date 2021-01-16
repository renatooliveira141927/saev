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
                    <h4 class="page-title"><?php echo 'Identificar Aluno (Importação Microdados)'?></h4>
                </p>
            </div>
        </div>
    </div>
    
    
    <?php
    echo validation_errors('<script type="text/javascript">mensagem_sucesso("error" ,"','");</script>');
if($msg == "success"){?>

    <script type="text/javascript">
        mensagem_sucesso("success" , "Registro gravado com sucesso!");
    </script>

    <?php
}else if($msg == "registro_ja_existente"){
    ?>

    <script type="text/javascript">
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro!");
    </script>

    <?php
}   
?>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container card-box">
        <form action="<?php echo base_url('microdados/microdados/identificar'); ?>" method="get" id="consulta" name="consulta">            
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        		
                 <div  class="col-lg-4">
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
                <div  class="col-lg-6">
                        <div class="form-group">
                            <label for="cd_disciplina">Disciplina</label>                            
                            <select id="cd_disciplina" 
                                        name="cd_disciplina" 
                                        tabindex="3"
                                        class="form-control">
                                    <Option value=""></Option>
                                <?php
                                foreach ($disciplinas as $item) {?>
                                    <Option value="<?php echo $item->ci_disciplina; ?>"
                                    <?php if ($cd_disciplina == $item->ci_disciplina){
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
          <form action="<?php echo base_url('microdados/microdados/salvar'); ?>" method="post" id="salvar" name="salvar"> 
        <div class="table-responsive" id="listagem_resultado">
        	Total de registros:<?= $totalregistros?>	
        	<div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                	<thead>	
                    	<tr>
<td align="center">nm_estado</td>
<td align="center">nm_municipio</td>
<td align="center">nm_escola</td>
<td align="center">nm_turma</td>
<td align="center">nm_aluno</td>
<td align="center">dt_nascimento</td>
<td align="center">filiacao</td>
<td align="center">Aluno Saev</td>
                    	</tr>
                 	</thead>
                 	<tbody>
                 	<?php $count=0; 
                 	if(!empty($microdados)){
                 	    foreach ($microdados as $result) {
                    	       $count++;?>
                 		<tr>
                        <td align="center"><?= $result->nm_estado; ?>
                        	<input type="hidden" id="cd_disciplina" name="cd_disciplina[]" value="<?=$cd_disciplina; ?>"/>
                        	<input type="hidden" id="ci_microdados" name="ci_microdados[]" value="<?=$result->ci_microdados; ?>"/>
                        </td>
                        <td align="center"><?= $result->nm_municipio; ?></td>
                        <td align="center"><?= $result->nm_escola; ?></td>
                        <td align="center"><?= $result->nm_turma; ?></td>
                        <td align="center"><?= $result->nm_aluno; ?></td>
                        <td align="center"><?= $result->dt_nascimento; ?></td>
                        <td align="center"><?= $result->filiacao; ?></td>
                        <td align="center">
                        	<select id="cd_aluno" name="cd_aluno[]" tabindex="9" class="form-control">
                        		<?php echo $alunos?>
                        	</select>
                        </td>
                 		</tr>
                 	<?php } }else{?>
                 		<tr>
                 			<td colspan="8">Nenhum dado encontrado</td>
                 		</tr>	
                 	<?php }?>	
                 	</tbody>   
                </table>                              
                <?php if(!empty($microdados)){ ?>
				<div class="form-group">
                    <button type="submit" id="save"
                            tabindex="9" 
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Salvar
                    </button>
                </div>
                <?php }?>                               
            </div>
         </div>
         
	</form>
   </div>         