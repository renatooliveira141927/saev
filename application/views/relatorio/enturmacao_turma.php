<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/monitoramento.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Monitoramento: Enturmacao por Turma' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post" id="leituraescola" name="leituraescola">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        		<div class="col-lg-4">
                            <label>Estados</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">
                                <?php echo $estado ?>
                            </select>
                 </div>
                 <div class="col-lg-4">                            
                                <label>Municípios</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="2"
                                        class="form-control" >
                                        <?php echo $cidade ?>
                                </select>
                 </div>
                 <div class="col-lg-4">
                            <label for="cd_escola">Escola </label>
                            <select id="cd_escola" name="cd_escola" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php 
                                foreach ($escolas as $item) {?>
                                    <Option value="<?php echo $item->ci_escola; ?>"
                                        <?php if ($cd_escola == $item->ci_escola){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_escola; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                 <div  class="col-lg-4">                        
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
                
                <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_turma">Turma *</label>
                    <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control">
                        <option value="">Selecione uma Turma</option>
                        <?php
                        foreach ($turmas as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_turma; ?>"
                                <?php if ($cd_turma == $item->ci_turma){
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
    
    <div class="container card-box"> 
        <div class="table-responsive" id="listagem_resultado">
        	<div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                    <tr>
                    	<th>Turmas</th>                        
                        <th>Aluno</th>
                        <th>Mãe</th>
                        <th>Nascimento</th>                                                                                                                                                                                      
                    </tr>
        	<?php if(!empty($enturmacao)){ 
        	   foreach ($enturmacao as $result) {?>
                 <tr>                 	
                 	<td><?php echo $result->nm_turma; ?></td>
                 	<td><?php echo $result->ci_aluno.'-'.$result->nm_aluno; ?></td>                                     	                                                                                                                                                                             
                 	<td><?php echo $result->nm_mae; ?></td>
                 	<td><?php echo $result->dt_nascimento; ?></td>
                 </tr>                  
        	<?php } }?>
        	        <tr>
                    	<td >Total</td>                    	
                    	<td ><?php echo $totalalunos; ?></td>                    	                    	                    
                    </tr>
                </table>
            </div>
        	
        </div>        
    </div>
    
</div>   