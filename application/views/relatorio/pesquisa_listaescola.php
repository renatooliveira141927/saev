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
                    	<td>Escola</td>                        
                        <td align="center">JAN</td>
                        <td align="center">FEV</td>
                        <td align="center">MAR</td>
                        <td align="center">ABR</td>
                        <td align="center">MAI</td>
                        <td align="center">JUN</td>
                        <td align="center">JUL</td>
                        <td align="center">AGO</td>
                        <td align="center">SET</td>
                        <td align="center">OUT</td>
                        <td align="center">NOV</td>
                        <td align="center">DEZ</td>                                                                  
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>                                                                
                                <td ><?php echo $result->nm_escola; ?></td>                                
                                <td align="center"><?php echo $result->jan; ?></td>
                                <td align="center"><?php echo $result->fev; ?></td>
                                <td align="center"><?php echo $result->mar; ?></td>
                                <td align="center"><?php echo $result->abr; ?></td>
                                <td align="center"><?php echo $result->mai; ?></td>
                                <td align="center"><?php echo $result->jun; ?></td>
                                <td align="center"><?php echo $result->jul; ?></td>
                                <td align="center"><?php echo $result->ago; ?></td>
                                <td align="center"><?php echo $result->set; ?></td>
                                <td align="center"><?php echo $result->out; ?></td>
                                <td align="center"><?php echo $result->nov; ?></td>
                                <td align="center"><?php echo $result->dez; ?></td>
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