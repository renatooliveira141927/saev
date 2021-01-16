<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome do avaliacao_upload é obrigatório."));
    $erro_qtdobrigatorio = "Campo obrigatório não foi preenchido!";

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
                        <th>CADERNO</th>
                        <th>EDIÇÃO</th>
                        <th>DISCIPLINA</th>
                        <th>ETAPA</th>                        
                        <th>TIPO</th>
                        <td style="width:30px;"></td>
                        <td style="width:30px;"></td>
                        <td align="right"></td>
                    </tr>
                    <!-- Inicio lista de avaliacao_uploads encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td>
                                    <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador -->
                                        <a type="button"
                                        href="<?php echo base_url('avaliacao_upload/avaliacao_uploads/editar/'.$result->ci_avaliacao_upload); ?>"
                                        style="width: 80px;height: 33px"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>
                                    <?php }?> <!-- Fim Se o usuário for administrador -->

                                </td>
                                <td ><?php echo strtoupper ($result->nm_caderno); ?></td>
                                <td ><?php echo $result->nm_edicao; ?></td>
                                <td><?php echo $result->nm_disciplina; ?></td>
                                <td><?php echo $result->nm_etapa; ?></td>                                    
                                <td><?php echo $result->nm_avalia_tipo; ?></td>
                                <td  style="width:30px;" title="Avaliação">
                                    <?php if ($result->ds_arquivo_avaliacao){?>

                                        <a  target="_blank" 
                                            href="<?php echo base_url('assets/pdf/avaliacao_uploads/'.$result->ds_arquivo_avaliacao)?>" 
                                            alt="Avaliação">

                                            <img src="<?php echo base_url('assets/images/pdf.png');?>" 
                                                height="30px" 
                                                width="30px"
                                                alt="Avaliação">
                                        </a>

                                    <?php }?>
                                </td>
                                <td style="width:30px;" title="Caderno do aplicador">

                                    <?php if ($result->ds_arquivo_aplicador){?>

                                        <a  target="_blank" 
                                            href="<?php echo base_url('assets/pdf/avaliacao_uploads/'.$result->ds_arquivo_aplicador)?>" 
                                            alt="Caderno do aplicador">

                                            <img src="<?php echo base_url('assets/images/pdf.png');?>" 
                                                height="30px" 
                                                width="30px" 
                                                alt="Caderno do aplicador">
                                        </a>

                                    <?php }?>
                                </td>
                                <td align="right">
                                        <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador -->
                                        <button type="button"
                                                class="btn btn-danger waves-effect waves-light btn-micro active"
                                                onclick="javascript:excluir('<?php echo $result->ci_avaliacao_upload;?>');">
                                            Excluir
                                        </button>
                                    <?php }?> <!-- Fim Se o usuário for administrador -->


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

