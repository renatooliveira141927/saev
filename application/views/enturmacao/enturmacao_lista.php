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
    ini_set("max_execution_time", 920);
    ini_set("memory_limit", '828M');
    ini_set("max_input_time", 460);
?>
<div class="card-box table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">
        <div class="col-lg-10">
            <?php
            if ($total_registros > 0) { ?>
                
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
                        
                        <th>Id-Inep</th>
                        <th>Nome</th>
                        <th>Turma</th>                        
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $alunoatual=0;
                    $arr_ci_alunos = "";
                    if($total_registros>0){                        
                        foreach ($registros as $result) {
                            if($result->ci_aluno!=$alunoatual){?>
                            <tr>                                
                                <td ><?php echo $result->ci_aluno;?> - 
                                	<?php echo $result->nr_inep; ?>
                                	<input type="hidden" id="arr_ci_alunos[]" name="arr_ci_alunos[]" value="<?=$result->ci_aluno; ?>"/>
                                	<input type="hidden" id="enturmacao[]" name="enturmacao[]" value="<?=$result->ci_enturmacao; ?>"/>
                                	<input type="hidden" id="ultimaenturmacao[]" name="ultimaenturmacao[]" value="<?=$result->ci_ultimaenturmacao; ?>"/>
                                	</td>
                                <td ><?php echo $result->nm_aluno; ?></td>                                
                                <td>
                                    <?php if ($result->cd_turma){?>
                                        <select id="cd_turma[]" 
                                                name="cd_turma[]" 
                                                tabindex="4" 
                                                class="form-control"
                                                onchange="atualiza_combos_turma('cd_turma_<?php echo $result->ci_aluno?>', 'cd_etapa_<?php echo $result->ci_aluno?>', 'cd_turno_<?php echo $result->ci_aluno?>');"
                                                >
                                            <Option value="" cd_etapa="" cd_turno=""></Option>
                                            <?php
                                            foreach ($turmas as $item) {?>
                                                <Option value="<?php echo $item->ci_turma; ?>"
                                                        cd_etapa="<?php echo $item->cd_etapa; ?>"
                                                        cd_turno="<?php echo $item->cd_turno; ?>"
                                                    <?php if ($result->cd_turma == $item->ci_turma){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nr_ano_letivo . ' - ' . $item->nm_etapa . ' - ' . $item->nm_turno . ' - ' . $item->nm_turma ?>
                                                </Option>
                                            <?php } ?>
                                        </select>
                                        
                                    <?php }else{?>
                                        <select id="cd_turma[]" 
                                                name="cd_turma[]" 
                                                tabindex="4"
                                                class="form-control" 
                                                onchange="atualiza_combos_turma('cd_turma_<?php echo $result->ci_aluno?>', 'cd_etapa_<?php echo $result->ci_aluno?>', 'cd_turno_<?php echo $result->ci_aluno?>');"
                                                >
                                            <option value="" cd_etapa="" cd_turno=""></option>
                                            <?php
                                            foreach ($turmas as $item) {?>
                                                <Option value="<?php echo $item->ci_turma; ?>"
                                                        cd_etapa="<?php echo $item->cd_etapa; ?>"
                                                        cd_turno="<?php echo $item->cd_turno; ?>"
                                                    <?php if ($result->cd_turma == $item->ci_turma){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nr_ano_letivo . ' - ' . $item->nm_etapa . ' - ' . $item->nm_turno . ' - ' . $item->nm_turma ?>
                                                </Option>
                                            <?php } ?>
                                        </select>
                                    <?php }?>
                                 
                                </td>
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
                        }  
                        $alunoatual=$result->ci_aluno; //atualiza o aluno para o atual do laço
                        }  ?>                    
                    <?php } ?>

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
            <input type="hidden" id="anoatual" value="<?=$anoatual?>"/>
            <input type="hidden" id="anopesquisa" value="<?=$desativasalvar?>"/>  
              
                <div align="right">
                    <button type="submit" id="btn_consulta"
                            tabindex="9"                        
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Salvar
                    </button>
                </div> 
                 
        </div>
      <?php }?>  
</div>
<?php
}
?>