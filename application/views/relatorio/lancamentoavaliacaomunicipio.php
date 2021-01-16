<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/relatoriolancamentos.js'); ?>"></script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Lançamento Avaliacao: Município' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post" id="lancamento" name="lancamento">
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
                 <div class="col-lg-4">
                            <label for="cd_edicao">Edição *</label>
                            <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($edicoes as $item) {?>
                                    <Option value="<?php echo $item->ci_edicao; ?>"
                                        <?php if ($cd_edicao == $item->ci_edicao){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_edicao; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>

                <div class="col-md-6">
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
                    	<th>Escola</th>                        
                        <th align="center">Enturmados</th>                                                                                                                
                        <th align="center">% Leitura</th>
                        <th align="center">% Português</th>
                        <th align="center">% Matemática</th>
                    </tr>
        	<?php if(!empty($lancamento)){ 
        	    foreach ($lancamento as $result) {?>
                 <tr>                 	
                 	<td > <a href="<?php echo base_url('lancamento/lancamentoescola?estado='.$result->ci_estado.'&cidade='.$result->ci_cidade.'&escola='.$result->ci_escola.'&edicao='.$result->cd_edicao) ?>"
                 			target="_blank">
                 		<?php echo $result->nm_escola;?></a>
                 	</td>                                	                                                              
                    <td align="center"><?php echo $result->enturmacao;?></td>
                    <td align="center"><?php echo round((($result->leitura*100)/$result->enturmacao),2);?></td>
                    <td align="center"><?php echo round((($result->escritap*100)/$result->enturmacao),2);?></td>
                    <td align="center"><?php echo round((($result->escritam*100)/$result->enturmacao),2);?></td>                                                                                            
                 </tr>                  
        	<?php } }?>
        			<tr>
                    	<th >Total</td>                    	             	
                    	<td align="center"><?php echo $totalalunos; ?></td>
                    	<td align="center"><?php echo $leitura; ?></td>
                    	<td align="center"><?php echo $lportuguesa; ?></td>
                    	<td align="center"><?php echo $matematica; ?></td>
                    </tr>         	        
                </table>
            </div>        	
        </div>        
    </div>    
</div>   