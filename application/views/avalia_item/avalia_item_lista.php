

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
                        <?php if($origem_acesso=='avaliacao'){ ?>
                            <th></th>
                            <th></th>
                            <th>Código</th>
                            <th>Edicao</th>
                            <th>Titulo</th>                            
                        <?php }else{ ?>
                            <th></th>
                            <th>Código</th>
                            <th>Edicao</th>
                            <th>Disciplina</th>
                             <th>Origem</th>  
                            <th>Titulo</th>
                            <th>Etapa</th>
                            <td align="right">
                            <?php 
                            if($total_registros>0){
                            ?>
                                <i onclick="mudaAction('<?php echo base_url('avalia_item/avalia_itens/gerar_excel'); ?>');" style="cursor: pointer;">
                                    <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/excel.png');?>"/>
                                </i>
                                <i onclick="mudaAction('<?php echo base_url('avalia_item/avalia_itens/gerar_pdf'); ?>');" style="cursor: pointer;">
                                    <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/pdf.png');?>"/>
                                </i>
                            <?php }?>
                            </td>
                        <?php } ?>
                        
                    </tr>
                    <!-- Inicio lista de avalia_itens encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>
                                    <?php if($origem_acesso=='avaliacao'){ ?>

                                        <a  type="button"
                                            id="<?php echo $result->ci_avalia_item; ?>"
                                            onclick="add_select('<?php echo $result->ci_avalia_item; ?>', document.getElementById('<?php echo $result->ci_avalia_item.'_codigo'; ?>'), document.getElementById('<?php echo $result->ci_avalia_item.'_titulo'; ?>'));"
                                            class="btn btn-primary btn-custom">
                                            <i class="glyphicon glyphicon-plus img-circle btn-icon"></i>
                                            <input type="hidden" id="<?php echo $result->ci_avalia_item.'_codigo'; ?>" value="<?php echo str_replace("\"", "",$result->ds_codigo); ?>">
                                            <input type="hidden" id="<?php echo $result->ci_avalia_item.'_titulo'; ?>" value="<?php echo str_replace("\"", "",$result->ds_titulo); ?>">
                                        </a>
                                        <td>
                                            <a  type="button"
                                                id="<?php echo $result->ci_avalia_item; ?>"
                                                onclick="modal_veritem('<?php echo $result->ci_avalia_item; ?>');"
                                                class="btn btn-primary btn-custom">
                                                <i class="glyphicon glyphicon-list-alt img-circle btn-icon"></i>
                                            </a>
                                        </td>
                                        <td ><?php echo $result->ds_codigo; ?></td>
                                        <td><?php echo $result->nm_edicao; ?></td>
                                        <td><?php echo $result->ds_titulo; ?></td>

                                    <?php }else{ ?>
                                        <a type="button"
                                        href="<?php echo base_url('avalia_item/avalia_itens/editar/'.$result->ci_avalia_item); ?>"
                                        style="width: 80px;height: 33px"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>
                                   
                                        </td>
                                        <td ><?php echo $result->ds_codigo; ?></td>
                                        <td><?php echo $result->nm_edicao; ?></td>
                                        <td><?php echo $result->nm_disciplina; ?></td>
                                        <td><?php echo $result->nm_avalia_origem; ?></td>
                                        <td><?php echo $result->ds_titulo; ?></td>
                                        <td><?php echo $result->nm_etapa; ?></td>
                                        <td align="right">
                                            <button type="button"
                                                    class="btn btn-danger waves-effect waves-light btn-micro active"
                                                    onclick="javascript:excluir('<?php echo $result->ci_avalia_item;?>');">
                                                Excluir
                                            </button>
                                        </td>
                                <?php } ?> 

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

