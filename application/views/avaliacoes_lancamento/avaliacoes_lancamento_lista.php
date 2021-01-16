

<link href="<?=base_url('assets/css/listbox.css'); ?>" rel="stylesheet">
<script src="<?=base_url('assets/js/listbox.js'); ?>"></script>
<script src="<?=base_url('assets/js/avaliacao_lancar_nota.js'); ?>"></script>
<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome da avalia_item é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome da questão é obrigatório.";

    // strpos -> Verifica se uma string está contida em outra e retorna true caso encontre
    $return_qtdobrigatorio = strpos( validation_errors(), $erro_qtdobrigatorio ); 
    //echo validation_errors();
    if ( $return_qtdobrigatorio !== false){
        echo '<script type="text/javascript">mensagem_sucesso("error" ,"Digite no minimo 3 caracteres");</script>';
    } 
        
}else{
?>

<input type="hidden" id="url_base" name="url_base" value="<?php echo base_url();?>">

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
    <!--            <button type="button"-->
    <!--                    class="btn btn-danger waves-effect waves-light btn-micro active"-->
    <!--                    data-toggle="modal"-->
    <!--                    data-target=".excluir-modal---><!--">-->
    <!--                <i class="fa fa-remove fa-fw"></i>-->
    <!--                Excluir-->
    <!--            </button>-->
                <!-- <script language="javascript">
                    function mudaAction(pagina){
        
                        document.forms[0].action=pagina;
                        document.forms[0].submit();
                    }
                </script> -->
    
            </div>
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <tr>
                        <th></th>
                        <th>INEP</th>
                        <th>Nome</th>
                        <th>Etapa</th>
                        <th>Turno</th>
                        <th>Turma</th>
                    </tr>
                    <!-- Inicio lista de avalia_itens encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>
                                    <a  type="button"
                                        id="<?php echo $result->ci_aluno; ?>"
                                        onclick="modal_veritem('<?php echo $result->ci_aluno; ?>','<?php echo $result->nm_aluno; ?>','<?php echo $result->ci_avaliacao_turma; ?>');"
                                        class="btn btn-primary btn-custom">
                                        <i class="glyphicon glyphicon-list-alt img-circle btn-icon"></i>
                                    </a>
                                </td>
                                <td ><?php echo $result->nr_inep; ?></td>
                                <td ><?php echo $result->nm_aluno; ?></td>
                                <td><?php echo $result->nm_etapa; ?></td>
                                <td><?php echo $result->nm_turno; ?></td>
                                <td><?php echo $result->nm_turma; ?></td>
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
<!-- Modal para ser utilizada na aplicação-->
<div id="modal_aplication">
</div>
<!-- Fim Modal para ser utilizada na aplicação-->


<?php
 }
?>

