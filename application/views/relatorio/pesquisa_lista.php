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
                    	<th>Inep</th>
                        <th>Nome</th>
                        <th>JAN</th>
                        <th>FEV</th>
                        <th>MAR</th>
                        <th>ABR</th>
                        <th>MAI</th>
                        <th>JUN</th>
                        <th>JUL</th>
                        <th>AGO</th>
                        <th>SET</th>
                        <th>OUT</th>
                        <th>NOV</th>
                        <th>DEZ</th>
                        <th></th>                                                
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>                                
                                <td><?php echo $result->nr_inep; ?></td>
                                <td><?php echo $result->nm_aluno; ?></td>                                
                                <td><?php echo $result->jan; ?></td>
                                <td><?php echo $result->fev; ?></td>
                                <td><?php echo $result->mar; ?></td>
                                <td><?php echo $result->abr; ?></td>
                                <td><?php echo $result->mai; ?></td>
                                <td><?php echo $result->jun; ?></td>
                                <td><?php echo $result->jul; ?></td>
                                <td><?php echo $result->ago; ?></td>
                                <td><?php echo $result->set; ?></td>
                                <td><?php echo $result->out; ?></td>
                                <td><?php echo $result->nov; ?></td>
                                <td><?php echo $result->dez; ?></td>
                                <td>
                                <button type="button" id="btn_modal" tabindex="12"
                        				class="btn btn-custom waves-effect waves-light btn-micro active btn_modal"
                        				onclick="carregamodal(<?=$result->ci_aluno?>);">Evolução
                    			</button>
                                	<div class="modal fade" role="dialog" id="modalFalta<?=$result->ci_aluno?>">
                          				<div class="modal-dialog modal-lg">
                                        	<div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                                    <h4 class="modal-title"><?=$result->nm_aluno?></h4>
                                                  </div>
                                                  <div class="modal-body" id="divFalta<?=$result->ci_aluno?>" >
                                                  </div>
                                        	</div>
                          				</div>
                    				</div> 
                                </td>
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