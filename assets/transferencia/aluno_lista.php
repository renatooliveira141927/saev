<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome do aluno é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome do(a) aluno(a) é obrigatório.";

    // strpos -> Verifica se uma string está contida em outra e retorna true caso encontre
    $return_qtdobrigatorio = strpos( validation_errors(), $erro_qtdobrigatorio ); 
    //echo validation_errors();
    if ( $return_qtdobrigatorio !== false){
        echo '<script type="text/javascript">mensagem_sucesso("error" ,"Digite no minimo 3 caracteres");</script>';
    } 
        
}else{
?>
<div class="table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">
        <div>
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
            <div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th></th>
                        <th>Inep</th>
                        <th>Nome</th>
                        <th>Mãe</th>
                        <th>Data de nascimento</th>
                        <th>Etapa</th>
                        <th>Turma</th>
                        <th>Turno</th>
                        <td align="right">
                        <?php 
                        if($total_registros>0){
                        ?>
                            <!-- <i onclick="mudaAction('<'?php echo base_url('aluno/alunos/gerar_excel'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<'?php  echo base_url('/assets/images/excel.png');?>"/>
                            </i>
                            <i onclick="mudaAction('<'?php echo base_url('aluno/alunos/gerar_pdf'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<'?php  echo base_url('/assets/images/pdf.png');?>"/>
                            </i> -->
                        <?php }?>
                        </td>
                    </tr>
                    <!-- Inicio lista de alunos encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>

                                    </td>
                                    <td ><?php echo $result->nr_inep; ?></td>
                                    <td ><?php echo $result->nm_aluno; ?></td>
                                    <td ><?php echo $result->nm_mae; ?></td>
                                    <td ><?php echo $result->dt_nascimento; ?></td>
                                    <td><?php echo $result->nm_etapa; ?></td>
                                    <td><?php echo $result->nm_turma; ?></td>
                                    <td><?php echo $result->nm_turno; ?></td>
                                    <td align="right">

                                    <a type="button" 
                                        class="btn btn-custom waves-effect waves-light btn-micro active"
                                        href="<?php echo base_url('transferencia/transferencias/nova_transferencia/'.$result->ci_aluno); ?>">
                                        Solicitar
                                    </a>

                                </td>
                            </tr>

                        <?php
                        } 
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
</div>
<?php
 }
?>

