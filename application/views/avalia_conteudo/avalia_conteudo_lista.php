
<div class="card-box table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">
        <div class="col-lg-10">
            <?php if ($total_registros > 0) { ?>
                <h5>Foram encontrados <?php echo $total_registros ?> registros!</h5>
            <?php }else{?>
                <h5>A consulta não retornou registros!</h5>
            <?php } ?>
        </div>
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
            </head>
            <button type="button" onclick="mudaAction('<?php echo base_url('avalia_conteudo/avalia_conteudos/gerar_excel'); ?>');">
                <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/excel.png');?>"/>
            </button>
            <button type="button" onclick="mudaAction('<?php echo base_url('avalia_conteudo/avalia_conteudos/gerar_pdf'); ?>');">
                <img width="30px" height="30px"  src="<?php  echo base_url('/assets/images/pdf.png');?>"/>
            </button>
        </div>
        <div class="col-lg-12">
            <table class="table table-striped table-hover">
                <tr>
                    <th></th>
                    <th>Código</th>
                    <th>Nome</th>
                    <td align="right">

                    </td>
                </tr>
                <!-- Inicio lista de avalia_conteudos encontradas na consulta -->
                <?php
                foreach ($registros as $result) {
                    ?>
                    <tr>
                        <td>
                            <a type="button"
                               href="<?php echo base_url('avalia_conteudo/avalia_conteudos/editar/'.$result->ci_avalia_conteudo); ?>"
                               style="width: 80px;height: 33px"
                               class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>

                        </td>
                        <td ><?php echo $result->ci_avalia_conteudo; ?></td>
                        <td><?php echo $result->nm_avalia_conteudo; ?></td>
                        <td align="right">
                            <input type="hidden" id="url_excluir"
                                   value="<?php echo base_url('avalia_conteudo/avalia_conteudos/excluir/')?>">

                            <button type="button"
                                    class="btn btn-danger waves-effect waves-light btn-micro active"
                                    onclick="javascript:excluir('<?php echo $result->ci_avalia_conteudo;?>');">
                                Excluir
                            </button>



                        </td>
                    </tr>

                <?php } ?>

            </table>
            <div align="center">
                <?php echo "<div id='dv_paginacao'>".$links_paginacao."</div>"?>
            </div>

        </div>
    </div>
</div>
<!-- Fim Div oculta de confirmação do botão excluir -->
