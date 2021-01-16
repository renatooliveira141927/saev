<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/listagem_cadastros/js/alunos.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar alunos ' ?></h4>
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

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container card-box">
        <div class="col-md-2">
            <div class="form-group">
            <label for="nr_inep">Inep</label>
                        <input type="text"
                            name="nr_inep"
                            id="inep"
                            tabindex="2"
                            placeholder="Inep"
                            class="form-control"
                            value="<?php echo set_value('nr_inep'); ?>">
            </div>
        </div>
        <div class="col-lg-10">
            <div class="form-group">
                <label for="nm_aluno">Nome</label>
                <input type="text"
                        name="nm_aluno"
                        id="nm_aluno"
                        tabindex="1"
                        placeholder="Nome"
                        class="form-control"
                        value="<?php echo set_value('nm_aluno');?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                
                <div >
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <label>Estado</label>
                    <select id="cd_estado" 
                            name="cd_estado" 
                            tabindex="3"
                            class="form-control" 
                            onchange="populacidade(this.value)">

                        <?php echo $estado ?>

                    </select>
                </div>
            </div>

            <div class="col-md-9">
                <div >
                    <label>Município</label>
                    <select id="cd_cidade" 
                            name="cd_cidade" 
                            tabindex="4"
                            class="form-control" disabled>
                        <option value="">Selecione o estado</option>
                    </select>
                    <br/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3">
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
            <div class="col-lg-6">
                <label for="cd_etapa">Etapa </label>
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
            <div class="col-lg-3">
                <label for="cd_turno">Turno </label>
                <select id="cd_turno" name="cd_turno" tabindex="4" class="form-control">
                    <Option value=""></Option>
                    <?php
                    foreach ($turnos as $item) {
                        ?>

                        <Option value="<?php echo $item->ci_turno; ?>"
                            <?php if (set_value('cd_turno') == $item->ci_turno){
                                echo 'selected';
                            } ?> >
                            <?php echo $item->nm_turno; ?>
                        </Option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div align="right" class="col-lg-12">        
            <input type="hidden"
                    id="url_base"
                    value="<?php echo base_url('aluno/alunos')?>"><br/>
            <button type="button" id="btn_consulta"
                    tabindex="9"
                    class="btn btn-custom waves-effect waves-light btn-micro active">
                Consultar
            </button>
        </div>        
    </div>
    <!-- Div para listagem resultado da consulta-->
    <div id="listagem_resultado"></div>

    </form>
    <script src="<?=base_url('assets/js/mask.inep.js'); ?>"></script>