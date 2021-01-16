
<!-- Caixa de texto e Botao junto bootstrap 4-->
<!--
<div class="container">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Button</button>
        </div>
    </div>
</div>
-->



    <div class="container">
        <div class="page-title-box">
            <h4 class="page-title">Turmas por escola</h4>
        </div>
    </div>

    <div class="container">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12" style="text-align: right">
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('turma/turmas/novo'); ?>">Cadastrar</a>
                </div>
            </div>
            <div class="container">
                <form action="<?php echo base_url('turma/turmas'); ?>"
                      method="post">
                    <!-- Inicio - Componente de consulta de escola -->
                    <?php if ($this->session->userdata('ci_grupousuario') == 1){

                        $this->load->view('include/gerar_lista_selecao_escola');
                    } ?>
                    <!-- Fim - Componente de consulta de escola -->


                    <section class="main row">
                        <div class="col-md-12 form-group">
                            <label for="txt-nm_turma">Nome da turma</label>
                            <input type="text" name="txt-nm_turma" id="txt-nm_turma" placeholder="Nome da turma" class="form-control">

                        </div>
                    </section>
                    <section class="main row">

                        <div class="col-md-3 form-group">
                            <label for="select-cd_etapa">Etapa</label>
                            <select id="select-cd_etapa" name="select-cd_etapa" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($etapas as $result) {
                                    ?>

                                    <Option value="<?php echo $result->ci_etapa; ?>">
                                        <?php echo $result->nm_etapa; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="select-cd_nivel">Nível</label>
                            <select id="select-cd_nivel" name="select-cd_nivel" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($niveis as $result) {
                                    ?>

                                    <Option value="<?php echo $result->ci_nivel; ?>">
                                        <?php echo $result->nm_nivel; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="select-cd_modalidade">Modalidade</label>
                            <select id="select-cd_modalidade" name="select-cd_modalidade" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($modalidades as $result) {
                                    ?>

                                    <Option value="<?php echo $result->ci_modalidade; ?>">
                                        <?php echo $result->nm_modalidade; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>


                        <div class="col-md-3 form-group">
                            <label for="select-cd_turno">Turno</label>
                            <select id="select-cd_turno" name="select-cd_turno" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($turnos as $result) {
                                    ?>

                                    <Option value="<?php echo $result->ci_turno; ?>">
                                        <?php echo $result->nm_turno; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </section>
                </form>
            </div>


            <div class="container">
                <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-search">
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
                    <th></th>
				</tr>
                <!-- Inicio lista de Turmas encontradas na consulta -->
                <?php
                    foreach ($turmas as $result) {
                ?>
                    <tr>
                        <td>
                            <button class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-pencil"
                                    href="<?php echo base_url('turma/turmas/editar/'.$result->ci_turma); ?>">
                                Editar
                            </button>
                        </td>
                        <td ><?php echo $result->ci_turma; ?></td>
                        <td><?php echo $result->nm_turma; ?></td>
                        <td>
                            <button class="btn btn-danger waves-effect waves-light btn-micro active glyphicon glyphicon-trash"
                                    href="<?php echo base_url("turma/turmas/excluir/" . $result->ci_turma); ?>">
                                Remover
                            </button>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>


	</div>
