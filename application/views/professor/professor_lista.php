<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome do professor é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome da professor é obrigatório.";

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
                        <th></th>
                        <th>Professor</th>
                        <th>Estado</th>
                        <th>Município</th>
                        <td align="right">
                        <?php 
                        if($total_registros>0){
                        ?>
                            <!-- <i onclick="mudaAction('<'?php echo base_url('professor/professores/gerar_excel'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<'?php  echo base_url('/assets/images/excel.png');?>"/>
                            </i>
                            <i onclick="mudaAction('<'?php echo base_url('professor/professores/gerar_pdf'); ?>');" style="cursor: pointer;">
                                <img width="30px" height="30px"  src="<'?php  echo base_url('/assets/images/pdf.png');?>"/>
                            </i> -->
                        <?php }?>
                        </td>
                    </tr>
                    <!-- Inicio lista de professores encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>
                                    <a type="button"
                                    href="<?php echo base_url('professor/professores/editar/'.$result->ci_professor.'/'.$result->cd_estado); ?>"
                                    style="width: 80px;height: 33px"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>

                                    </td>
                                    <td ><?php echo strtoupper ($result->nm_professor); ?></td>
                                    <td><?php echo $result->nm_estado; ?></td>
                                    <td><?php echo $result->nm_cidade; ?></td>
                                    <td align="right">

                                    <button type="button"
                                            class="btn btn-danger waves-effect waves-light btn-micro active"
                                            onclick="javascript:excluir('<?php echo $result->ci_professor;?>');">
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

