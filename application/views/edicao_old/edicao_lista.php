<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome da edicao é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome do tipo de avaliação é obrigatório.";

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
            <?php if ($total_registros > 0) { ?>
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
                        <th></th>
                        <th>Código</th>
                        <th>Nome</th>
                        <td align="right">
                        <?php 
                        if($total_registros>0){
                        ?>
                            <i onclick="mudaAction('<?php echo base_url('edicao/edicoes/gerar_excel'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/excel.png');?>"/>
                            </i>
                            <i onclick="mudaAction('<?php echo base_url('edicao/edicoes/gerar_pdf'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/pdf.png');?>"/>
                            </i>
                        <?php }?>
                        </td>
                    </tr>
                    <!-- Inicio lista de edicoes encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>
                                    <a type="button"
                                    href="<?php echo base_url('edicao/edicoes/editar/'.$result->ci_edicao); ?>"
                                    style="width: 80px;height: 33px"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>

                                </td>
                                <td ><?php echo $result->ci_edicao; ?></td>
                                <td><?php echo $result->nm_edicao; ?></td>
                                <td align="right">

                                    <button type="button"
                                            class="btn btn-danger waves-effect waves-light btn-micro active"
                                            onclick="javascript:excluir('<?php echo $result->ci_edicao;?>');">
                                        Excluir
                                    </button>



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

