<script src="<?=base_url('assets/listagem_cadastros/js/alunos.js'); ?>"></script>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Administrar '.$titulo ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('aluno/alunos/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <form action="<?php echo base_url('aluno/alunos/gerar_excel'); ?>" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="col-lg-12">
                        <div class="col-lg-2">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="nr_inep">INEP</label>
                                    <input id="nr_inep"
                                           name="nr_inep"
                                           type="number"
                                           class="form-control"
                                           tabindex="1"
                                           autofocus
                                           placeholder="INEP"
                                           style="text-transform: uppercase;"
                                           onkeyup="somenteNumeros(this);"
                                           maxlength="8"
                                           value="<?php echo set_value('nr_inep');?>">
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-10">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="nm_aluno">Nome do aluno</label>
                                    <input type="text"
                                           name="nm_aluno"
                                           id="nm_aluno"
                                           tabindex="2"
                                           placeholder="Nome do aluno"
                                           style="text-transform: uppercase;"
                                           class="form-control"
                                           value="<?php echo set_value('nm_aluno');?>">

                                </div>
                            </section>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="cd_turma">Turma </label>
                                    <select id="cd_turma" name="cd_turma" tabindex="3" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($turmas as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_turma; ?>"
                                                <?php if (set_value('cd_turma') == $item->ci_turma){
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
                                    <label for="cd_etapa">Etapa/Ano </label>

                                    <select id="cd_etapa" name="cd_etapa" tabindex="4" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($etapas as $item) {
                                            ?>

                                            <Option value="<?php echo $item->ci_etapa; ?>"
                                                <?php if (set_value('cd_etapa') == $item->ci_etapa){
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
                    <input type="hidden"
                           id="url_listar"
                           value="<?php echo base_url('aluno/alunos/listagem_consulta')?>">

                    <div  align="right" class="main row">
                        <button type="button" id="btn_consulta"
                                tabindex="5"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Consultar
                        </button>
                    </div>
                </div>




    </div>
    <!-- Div para listagem resultado da consulta-->
    <div id="listagem_resultado"></div>

    </form>