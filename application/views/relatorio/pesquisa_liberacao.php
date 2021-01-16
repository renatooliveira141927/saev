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
        <div class="col-lg-10">
            <?php
            if ($total_registros > 0) { ?>
                <h5>Foram encontrados <?php echo $total_registros ?> registros!</h5>
            <?php }else{?>
                <h5>A consulta não retornou registros!</h5>
            <?php } ?>
        </div>
        <?php if ($total_registros > 0) { ?>            
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <tr>
                    	<th>Município</th>                        
                        <th>Mês</th>
                        <th>Situação</th>                                        
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>                                
                                <td><?php echo $result->nm_cidade; ?></td>
                                <td><?php echo $result->mes; ?></td>                                
                                <td><?php if($result->fl_ativo=='t'){ echo 'Ativo';}else{ echo 'Desativado';}?></td>                                
                            </tr>
                        <?php }  
                    } ?>
                </table>
            </div>
        <?php }?>
        
    </div>
</div>
<?php
}
?>