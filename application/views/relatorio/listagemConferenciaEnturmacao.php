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
        <div class="col-lg-8">
        		<h4 class="page-title"><?php echo 'Alunos não enturmados de um ano para o outro' ?></h4>
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
                    	<th>Escola</th>                        
                        <th>Turma</th>
                        <th>Ano Letivo</th>
                        <th>Matrícula</th>
                        <th>Nome</th>
                        <th>Nascimento</th>                                                                                            
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){                        
                        foreach ($registros as $result) {?>
                            <tr>                                
                                <td><?php echo $result->nm_escola; ?></td>                                                               
                                <td><?php echo $result->nm_turma; ?></td>
                                <td><?php echo $result->nr_ano_letivo; ?></td>
                                <td><?php echo $result->ci_aluno; ?></td>
                                <td><?php echo $result->nm_aluno; ?></td>
                                <td><?php echo $result->dt_nascimento; ?></td>                                                                
                            </tr>
                        <?php } ?>  
                        
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Atualmente Enturmados</th>                        
                                <th>Não Enturmados</th>
                                <th>% Não Enturmados</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><?php echo $result->enturmacao;?></th>                        
                                    <th><?php echo $total_registros;?></th>
                                    <th><?php echo round(($total_registros*100)/$result->enturmacao,2);?></th>
                                </tr>
                            </tbody>
                        </table>
                <?php } ?>

                </table>
            </div>
        <?php }?>
        
    </div>
</div>
<?php
}
?>