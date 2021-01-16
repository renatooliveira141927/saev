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
<div class="card-box table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">        
        <div class="col-md-4">
                		<a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
        </div>
        <?php if ($total_registros > 0) { ?>            
            <div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                    <tr>
                    	<th>Nº Questão</th>                        
                        <th>Código</th>
                        <th>Descritor</th>                                                                                                                
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){                        
                        foreach ($registros as $result) {?>
                            <tr>                                
                                <td><?php echo $result->nr_questao; ?></td>                                                               
                                <td><?php echo $result->ds_codigo; ?></td>
                                <td><?php echo $result->nm_matriz_descritor; ?></td>                                                                                            
                            </tr>
                        <?php } ?>                                              
                <?php } ?>

                </table>
            </div>
        <?php }?>
        
    </div>
</div>
<?php
}
?>