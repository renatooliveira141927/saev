
    <div class="container">
        <div class="page-title-box">
            <h4 class="page-title"><?php echo 'Administrar '.$titulo ?></h4>
        </div>
    </div>

    <form action="<?php echo base_url('turma/turmas'); ?>" method="post">
    <div class="container">
        <div class="card-box">
                <div class="row">
                    <div class="col-md-12" style="text-align: right">
                        <a type="button" clas   s="btn btn-custom waves-effect waves-light btn-micro active    "
                           href="<?php echo base_url('turma/turmas/novo'); ?>">Cadastrar</a>
                    </div>
                </div>
                <div class="container">
                    <div class="col-lg-12">
                        <div class="col-lg-2">
                            <section class="main row">
                                <div class="form-group">
                                    <label id="txt-nr_inep">INEP</label>
                                    <input id="txt-nr_inep"
                                           name="txt-nr_inep"
                                           type="number"
                                           class="form-control"
                                           tabindex="4"
                                           placeholder="INEP"
                                           style="text-transform: uppercase;"
                                           onkeyup="somenteNumeros(this);"
                                           maxlength="8"
                                           value="<?php echo set_value('txt-nr_inep');?>">
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-10">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="txt-nm_turma">Nome da turma</label>
                                    <input type="text"
                                           name="txt-nm_turma"
                                           id="txt-nm_turma"
                                           placeholder="Nome da turma"
                                           style="text-transform: uppercase;"
                                           class="form-control"
                                           value="<?php echo set_value('txt-nm_turma');?>">

                                </div>
                            </section>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <section class="main row">
                                <div class="form-group">
                                    <label id="sel-cd_turma">Turma </label>
                                    <select id="sel-cd_turma" name="sel-cd_turma" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($turmas as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_turma; ?>"
                                                <?php if (set_value('sel-cd_turma') == $item->ci_turma){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_turma; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-8">
                            <section class="main row">
                                <div class="form-group">
                                    <label id="sel-cd_etapa">Etapa/Ano </label>

                                    <select id="sel-cd_etapa" name="sel-cd_etapa" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($etapas as $item) {
                                            ?>

                                            <Option value="<?php echo $item->ci_etapa; ?>"
                                                <?php if (set_value('sel-cd_etapa') == $item->ci_etapa){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_etapa; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>


                <div class="container" >
                    <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">
                        Consultar
                    </button>
                </div>

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
                    <th>Mãe</th>
                    <th></th>
				</tr>
                <!-- Inicio lista de turmas encontradas na consulta -->
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
                        <td ><?php echo $result->nr_inep; ?></td>
                        <td><?php echo $result->nm_turma; ?></td>
                        <td><?php echo $result->nm_mae; ?></td>
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
                                        <h4 class="modal-title" id="myModalLabel2">Exclusão da turma</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4>Deseja realmente excluir a turma "<?php echo $result->nm_turma ?>"?</h4>
                                        <p>Lembre-se que todos os itens relacionados a turma em questão também serão afetados.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <a type="submit" class="btn btn-custom waves-effect waves-light btn-micro active"
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
    </form>