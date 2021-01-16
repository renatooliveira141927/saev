<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/relatoriolancamentos.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Lançamento Avaliacao: Turma' ?></h4>
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
        		<div class="col-lg-6">
                            <label>Estados</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">
                                <?php echo $estado ?>
                            </select>
                 </div>
                 <div class="col-lg-6">
                            <div  class="form-group">
                                <label>Municípios</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="2"                                        
                            			onchange="populaescola(this.value);"
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
                                foreach ($edicoes as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_edicao; ?>"
                                        <?php if ($cd_edicao == $item->ci_edicao){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_edicao; ?>
                                    </Option>

                                <?php } ?>
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
                        <div class="col-lg-4">
                            <label for="cd_etapa">Etapa </label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($etapas as $item) {?>
                                    <Option value="<?php echo $item->ci_etapa; ?>"
                                        <?php if ($cd_etapa == $item->ci_etapa){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_etapa; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        
             <div class="col-md-12"><div class="form-group"></div></div>
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
                        <th>Etapa</th>
                        <th align="center">Turma</th>
                        <th align="center">Aluno</th>                                                                                                                
                        <th align="center">Leitura</th>
                        <th align="center">Português</th>
                        <th align="center">Matemática</th>
                    </tr>
        	<?php if(!empty($lancamento)){ 
        	    foreach ($lancamento as $result) {?>
                 <tr>                 	
                 	<td ><?php echo $result->nm_etapa;?></td>
                 	<td ><?php echo $result->nm_turma;?></td>
                 	<td ><?php echo $result->nm_aluno;?></td>                                     	                                                                                  
                    <td><?php if($result->leitura==1){?>
							<img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">
                        <?php }elseif($result->leitura==0){?>
                            <img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">
                        <?php }?>
                    </td>
                    <td><?php if($result->escrita==1){?>
							<img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">
                        <?php }elseif($result->escritap==0){?>
                           <img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">
                        <?php }?>
                    </td>
                    <td><?php if($result->escritam==1){?>
							<img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">
                        <?php }elseif($result->escritam==0){?>
                           <img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">
                        <?php }?>
                    </td>                                                                                            
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