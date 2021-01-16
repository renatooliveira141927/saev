
    <div class="container">
        <div class="page-title-box">
            <h4 class="page-title"><?php echo 'Administrar '.$titulo ?></h4>
        </div>
    </div>

    <div class="container">
        <div class="card-box">
            <form action="<?php echo base_url('turma/turmas'); ?>" method="post">
                <div class="row">
                    <div class="col-md-12" style="text-align: right">
                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                           href="<?php echo base_url('turma/turmas/novo'); ?>">Cadastrar</a>
                    </div>
                </div>
                <div class="container">



                        <section class="main row">
                            <div class="col-md-12 form-group">
                                <label for="txt-nm_turma">Nome da turma</label>
                                <input type="text"
                                       name="txt-nm_turma"
                                       id="txt-nm_turma"
                                       placeholder="Nome da Nível"
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
            <?php if (count($turmas) > 0) { ?>
                <h5>Foram encontrados <?php echo count($turmas) ?> registros!</h5>
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
                    foreach ($turmas as $result) {
                ?>
                    <tr>
                        <td>
                            <a type="button"
                               href="<?php echo base_url('turma/turmas/editar/'.$result->ci_turma); ?>"
                               style="width: 80px;height: 33px"
                               class="btn btn-custom waves-effect waves-light btn-micro active">Editar</a>

                        </td>
                        <td ><?php echo $result->ci_turma; ?></td>
                        <td><?php echo $result->nm_turma; ?></td>
                        <td align="right">

                            <button type="button"
                                    class="btn btn-danger waves-effect waves-light btn-micro active"
                                    data-toggle="modal"
                                    data-target=".excluir-modal-<?php echo $result->ci_turma ?>">
                                    <i class="fa fa-remove fa-fw"></i>
                                    Excluir
                            </button>



                        </td>
                    </tr>

                        <!-- Inicio Div oculta de confirmação do botão excluir -->

                        <div class="modal fade excluir-modal-<?php echo $result->ci_turma ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel2">Exclusão de Nível</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Deseja realmente excluir o nível "<?php echo $result->nm_turma ?>"?</h4>
                                        <p>Lembre-se que todos os itens relacionados ao nível em questão também serão afetados.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active"
                                           href="<?php echo base_url("turma/turmas/excluir/" . $result->ci_turma); ?>">
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
