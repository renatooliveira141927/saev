
    <div class="container">
        <div class="page-title-box">
            <h4 class="page-title"><?php echo 'Administrar '.$titulo ?></h4>
        </div>
    </div>

    <div class="container">
        <div class="card-box">
            <form action="<?php echo base_url('etapa/etapas'); ?>" method="post">
                <div class="row">
                    <div class="col-md-12" style="text-align: right">
                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                           href="<?php echo base_url('etapa/etapas/novo'); ?>">Cadastrar</a>
                    </div>
                </div>
                <div class="container">



                        <section class="main row">
                            <div class="col-md-12 form-group">
                                <label for="txt-nm_etapa">Nome do etapa</label>
                                <input type="text"
                                       name="txt-nm_etapa"
                                       id="txt-nm_etapa"
                                       placeholder="Nome da Etapa"
                                       style="text-transform: uppercase;"
                                       class="form-control">

                            </div>
                        </section>


                </div>


                <div class="container" >
                    <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">
                        Consultar
                    </button>
                </div>
            </form>


    </div>

	<div class="card-box table-responsive ">
        <div class="table-responsive align-text-middle">
            <?php if (count($etapas) > 0) { ?>
                <h5>Foram encontrados <?php echo count($etapas) ?> registros!</h5>
            <?php } ?>
			<table class="table table-striped table-hover">
				<tr>
                    <th></th>
					<th>Código</th>
					<th>Nome</th>
                    <th></th>
				</tr>
                <!-- Inicio lista de Turmas encontradas na consulta -->
                <?php
                    foreach ($etapas as $result) {
                ?>
                    <tr>
                        <td>
                            <a type="button"
                               href="<?php echo base_url('etapa/etapas/editar/'.$result->ci_etapa); ?>"
                               style="width: 80px;height: 33px"
                               class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>

                        </td>
                        <td ><?php echo $result->ci_etapa; ?></td>
                        <td><?php echo $result->nm_etapa; ?></td>
                        <td align="right">

                            <button type="button"
                                    class="btn btn-danger waves-effect waves-light btn-micro active"
                                    data-toggle="modal"
                                    data-target=".excluir-modal-<?php echo $result->ci_etapa ?>">
                                    <i class="fa fa-remove fa-fw"></i>
                                    Excluir
                            </button>



                        </td>
                    </tr>

                        <!-- Inicio Div oculta de confirmação do botão excluir -->

                        <div class="modal fade excluir-modal-<?php echo $result->ci_etapa ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Exclusão de Etapa</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Deseja realmente excluir o etapa "<?php echo $result->nm_etapa ?>"?</h4>
                                        <p>Lembre-se que todos os itens relacionados ao etapa em questão também serão afetados.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active"
                                           href="<?php echo base_url("etapa/etapas/excluir/" . $result->ci_etapa); ?>">
                                            Excluir
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Fim Div oculta de confirmação do botão excluir -->


                    <?php } ?>

            </table>
        </div>


	</div>
