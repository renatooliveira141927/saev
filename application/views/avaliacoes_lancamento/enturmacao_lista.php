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
    echo form_open('enturmacao/enturmacoes/salvar',array('id'=>'frm_enturmacoes','method'=>'post', 'enctype'=>'multipart/form-data'))
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
                        
                        <th>Inep</th>
                        <th>Nome</th>
                        <th>Etapa</th>                        
                        <th>Turno</th>
                        <th>Turma</th>                        
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    $arr_ci_alunos = "";
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                
                                <td ><?php echo $result->nr_inep; ?></td>
                                <td ><?php echo $result->nm_aluno; ?></td>
                                <td>                                                           
                                    <select id="cd_etapa_<?php echo $result->ci_aluno?>" name="cd_etapa_<?php echo $result->ci_aluno?>" tabindex="4" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($etapas as $item) {
                                            ?>

                                            <Option value="<?php echo $item->ci_etapa; ?>"
                                                <?php if ($result->cd_etapa == $item->ci_etapa){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_etapa; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </td>
                                <td> 
                                    <select id="cd_turno_<?php echo $result->ci_aluno?>" 
                                            name="cd_turno_<?php echo $result->ci_aluno?>" 
                                            tabindex="4" 
                                            class="form-control"
                                            onchange="populaturma('<?php echo $result->ci_aluno?>')">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($turnos as $item) {
                                            ?>

                                            <Option value="<?php echo $item->ci_turno; ?>"
                                                <?php if ($result->ci_turno == $item->ci_turno){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_turno; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                
                                    <?php if ($result->cd_turma){?>
                                        <select id="cd_turma_<?php echo $result->ci_aluno?>" 
                                                name="cd_turma_<?php echo $result->ci_aluno?>" 
                                                tabindex="4" 
                                                class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($turmas as $item) {
                                                ?>

                                                <Option value="<?php echo $item->ci_turma; ?>"
                                                    <?php if ($result->cd_turma == $item->ci_turma){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_turma; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                        
                                    <?php }else{?>
                                        <select id="cd_turma_<?php echo $result->ci_aluno?>" 
                                                name="cd_turma_<?php echo $result->ci_aluno?>" 
                                                tabindex="4"
                                                class="form-control" disabled>
                                            <option value=""></option>
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
                        }  ?>
                    <input type="hidden" name="arr_ci_alunos" value="<?php echo $arr_ci_alunos; ?>">
                    <?php
                    } ?>

                </table>
                <?php if($total_registros>0){ ?>
                <div align="center">
                    <?php echo "<div id='dv_paginacao'>".$links_paginacao."</div>"?>
                </div>
                <?php } ?>

            </div>
        <?php }?>
        
    </div>
    <div class="container-fluid">
            <div align="right">
                <button type="submit" id="btn_consulta"
                        tabindex="9"
                        class="btn btn-custom waves-effect waves-light btn-micro active">
                    Gravar
                </button>
            </div> 
        </div>
</div>
<?php
    echo form_close();
}
?>