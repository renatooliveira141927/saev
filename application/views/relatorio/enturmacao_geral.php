<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/monitoramento.js'); ?>"></script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            	<h4 class="page-title"><?php echo 'Monitoramento: Enturmacao Geral' ?></h4>
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
                    	<td> </td>
                    	<td>Estado</td>
                    	<td>Municipio</td>                        
                        <td align="center">Total de Alunos</td>
                        <td align="center">Enturmados</td>                                                                                                                
                        <td align="center">Não Enturmados</td>
                        <td align="center">% Enturmados</td>
                    </tr>
        	<?php $count=0; 
        	if(!empty($enturmacaomunicipio)){
        	   foreach ($enturmacaomunicipio as $result) {
        	       $count++;?>
                 <tr>
                 	<td><?php echo $count; ?></td>
                 	<td><?php echo $result->nm_uf; ?></td>
                 	<td><a href="<?php echo base_url('monitoramento/enturmacao_municipio?estado='.$result->ci_estado.'&cidade='.$result->ci_cidade.'&nr_anoletivo='.$anoatual) ?>"
                 			target="_blank">
                 			<?php echo $result->nm_cidade; ?>
                 		</a>
                 	</td>
                 	<td align="center"><?php echo $result->total; ?></td>                                     	                                                              
                    <td align="center"><?php echo $result->enturmacao; ?></td>
                    <td align="center"><?php echo $result->desenturmacao; ?></td>
                    <td align="center"><?php echo round($result->perc,2); ?></td>                                                                                            
                 </tr>                  
        	<?php } }?>
        	   
                    <tr>
                    	<th >Total</td>                    	
                    	<td align="center"></td>
                    	<td align="center"></td>
                    	<td align="center"><?php echo $totalalunos; ?></td>
                    	<td align="center"><?php echo $totalenturmados; ?></td>
                    	<td align="center"><?php echo $totaldesenturmados; ?></td>
                    	<td align="center"><?php echo $perctotalenturmados; ?></td>
                    </tr>
                </table>    	
            </div>
        	
        </div>        
    </div>
    
</div>   