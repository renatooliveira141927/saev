<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome da avaliacao é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome da questão é obrigatório.";

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
            if (!($total_registros > 0)) { ?>   
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
                        <th>Caderno</th>
                        <th>Tipo de avaliação</th>
                        <th>Disciplina</th>
                        <th>Edição</th>
                        <td align="right"></td>
                    </tr>
                    <!-- Inicio lista de avaliacoes encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                    <td ><?php echo $result->nm_caderno; ?></td>
                                    <td><?php echo $result->nm_avalia_tipo; ?></td>
                                    <td><?php echo $result->nm_disciplina; ?></td>
                                    <td><?php echo $result->nm_edicao; ?></td>
                                    <td align="right">
                                    <form action="<?php echo base_url('avaliacao/avalia_montar/montar_avaliacao');?>" method="post">
                                        <input type="hidden" name="ci_avaliacao" value="<?php echo $result->ci_avaliacao;?>">
                                        <input type="hidden" name="nm_caderno" value="<?php echo $result->nm_caderno;?>">
                                        <button type="submit"
                                                class="btn btn-custom waves-effect waves-light btn-micro active">
                                            Montar
                                        </button>
                                    </form>
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

