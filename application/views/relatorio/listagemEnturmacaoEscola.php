<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome do aluno é obrigatório."));
    $erro_qtdobrigatorio = "O campo turma é obrigatório!";
    // strpos -> Verifica se uma string está contida em outra e retorna true caso encontre
    $return_qtdobrigatorio = strpos( validation_errors(), $erro_qtdobrigatorio ); 
    //echo validation_errors();
    if ( $return_qtdobrigatorio !== false){
        echo '<script type="text/javascript">mensagem_sucesso("error" ,"Digite no minimo 3 caracteres");</script>';
    }         
}else{
?>
<div class="card-box table-responsive" id="listagem_enturmacao">
    <div class="table-responsive align-text-middle">
        <div class="col-lg-8">        		
            <?php
            if ($total_registros > 0) { ?>
                <h5>Foram encontrados <?php echo $total_registros ?> registros!</h5>
            <?php }else{?>
                <h5>A consulta não retornou registros!</h5>
            <?php } ?>
        </div>
        <div class="col-md-4">
           <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
        </div>
        <?php if ($total_registros > 0) { ?>            
        	<div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                    <tr>
                    	<th>Turma</th>                        
                        <th>Total de Alunos</th>
                        <th>Enturmados</th>                                                                                                                                        
                    </tr>
        	<?php if(!empty($registros)){ 
        	   foreach ($registros as $result) {
        	       $totalalunos=$totalalunos+$result->enturmacao;
        	       $totalenturmados=$totalalunos;?>
                 <tr>
                 	<td><?php echo $result->nm_turma; ?></td>
                 	<td align="center"><?php echo $result->enturmacao; ?></td>                                     	                                                              
                    <td align="center"><?php echo $result->enturmacao; ?></td>
                                                                                                                
                 </tr>                  
        	<?php } }?>
        	        <tr>
                    	<td >Total</td>                    	
                    	<td align="center"><?php echo $totalalunos; ?></td>
                    	<td align="center"><?php echo $totalenturmados; ?></td>
                    </tr>
                </table>
            </div>
        <?php }?>
        
    </div>
</div>
<?php
}
?>