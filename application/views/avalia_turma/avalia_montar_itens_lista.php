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
<div class="card-box table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">
        <div class="col-lg-10">
            <?php
            if ($total_registros == 0) { ?>
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
                        <th>Código</th>
                        <th>Edicao</th>
                        <th>Disciplina</th>
                        <th>Titulo</th>
                        <td align="right"></td>
                    </tr>
                    <!-- Inicio lista de avalia_itens encontradas na consulta -->
                    <?php
                    if($total_registros>0){
                        foreach ($registros as $result) {
                            ?>
                            <tr>
                                <td >
                                    <input type="checkbox" 
                                            id="ci_avaliacao_<?php echo $result->ci_avalia_item ?>"
                                            name="ci_avalia_item"
                                            value="<?php echo $result->ci_avalia_item ?>" 
                                            <?php if ($result->ci_avaliacao) {
                                                    echo ' checked';
                                            }?> 
                                            switch="info"/>
                                    <label for="ci_avaliacao_<?php echo $result->ci_avalia_item ?>"
                                            data-on-label="Sim"
                                            data-off-label="Não">
                                    </label>
                                </td>
                                <td ><?php echo $result->ds_codigo; ?></td>
                                <td><?php echo $result->nm_edicao; ?></td>
                                <td><?php echo $result->nm_disciplina; ?></td>
                                <td><?php echo $result->ds_titulo; ?></td>
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

