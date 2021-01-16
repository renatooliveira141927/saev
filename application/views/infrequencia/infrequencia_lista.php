<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
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
            <div class="col-lg-2" align="right">
                <script language="javascript">
                    function mudaAction(pagina){
        
                        document.forms[0].action=pagina;
                        document.forms[0].submit();
                    }
                </script>
    
            </div>
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <tr>
                        
                        <th>INEP</th>
                        <th>NOME</th>
                        <th>M&Ecirc;S</th>   
                        <th>FALTAS</th>                     
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>                                
                                <td><?php echo $result->nr_inep; ?>
                                	<input type="hidden" class="form-control"
                                			id="infrequencia_<?php echo $result->ci_aluno?>" 
                                			name="infrequencia_<?php echo $result->ci_aluno?>"
                                			value="<?php echo $result->ci_infrequencia; ?>">
                                </td>
                                <td><?php echo $result->nm_aluno; ?>
                                	<input type="hidden" class="form-control"
                                			id="cdaluno_<?php echo $result->ci_aluno?>"
                                			 name="cdaluno_<?php echo $result->ci_aluno?>"
                                			value="<?php echo $result->ci_aluno; ?>">
                                </td>                                
                                <td><?php echo $result->nr_mes; ?></td>
                                <td><input type="number" class="form-control"
                                	min="0" max="999"
                                	maxlength="3" size="3"
                                	id="nrfaltas_<?php echo $result->ci_aluno?>"	
                                	name="nrfaltas_<?php echo $result->ci_aluno?>"
                                	value="<?php echo $result->nr_faltas; ?>"></td>
                            </tr>
                                                <?php
                            if($total_registros>1){

                                if ($arr_ci_alunos == ""){
                                    $arr_ci_alunos = $result->ci_aluno; 
                                }else{
                                    $arr_ci_alunos .= ','.$result->ci_aluno; 
                                }
                                
                            }else{
                                $arr_ci_alunos = $result->ci_aluno; 
                            }
                        }  ?>
                    <input type="hidden" name="arr_ci_alunos" value="<?php echo $arr_ci_alunos; ?>">
                    <?php
                    } ?>

                </table>
                <?php if($total_registros>0){ ?>
                <!-- <div align="center">
                    <'?php echo "<div id='dv_paginacao'>".$links_paginacao."</div>"?>
                </div> -->
                <?php } ?>

            </div>
        <?php }?>
        
    </div>
     <?php
            if ($total_registros > 0) { ?>
        <div class="container-fluid">
            <div align="right">
                <button type="submit" id="btn_consulta"
                        tabindex="9"
                        class="btn btn-custom waves-effect waves-light btn-micro active">
                    Gravar
                </button>
            </div> 
        </div>
      <?php }?>  
</div>
<?php
}
?>