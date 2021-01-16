<script src="<?=base_url('assets/listagem_cadastros/js/avaliacoes.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
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
                       href="<?php echo base_url('avaliacao/avaliacoes/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="form-group col-lg-12">
                        
                        <div class="col-lg-2">
                            <label for="nm_caderno">Caderno</label>
                            <input type="text"
                                    name="nm_caderno"
                                    id="nm_caderno"
                                    tabindex="2"
                                    placeholder="Caderno"
                                    style="text-transform: uppercase;"
                                    class="form-control"
                                    value="<?php echo set_value('nm_caderno');?>">

                        </div>
                        <div class="col-lg-4">
                            <label for="cd_avalia_tipo">Tipo de avaliação</label>
                            <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="1" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_tiposs as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                        <?php if ((set_value('cd_avalia_tipo') == $item->ci_avalia_tipo)){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_avalia_tipo; ?>
                                    </Option>

                                <?php } ?>
                            </select>

                        </div>
                        <div class="col-md-3">
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                            <div class="form-group">
                                <label>Estado</label>
                                <select id="cd_estado" name="cd_estado" class="form-control" onchange="populacidade(this)">

                                    <?php echo $estado ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Município</label>
                                <select id="cd_cidade" name="cd_cidade" class="form-control" disabled>
                                    <option value="">Selecione o estado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="col-lg-2">
                            <label for="nr_ano">Ano</label>
                            <input type="text"
                                    name="nr_ano"
                                    id="nr_ano"
                                    tabindex="2"
                                    placeholder="Ano"
                                    style="text-transform: uppercase;"
                                    class="form-control"
                                    value="<?php echo set_value('nr_ano');?>">

                        </div>
                        <div class="col-lg-2">
                            <label for="cd_disciplina">Disciplina</label>
                            <select id="cd_disciplina" name="cd_disciplina" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($disciplinas as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_disciplina; ?>"
                                        <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_disciplina; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="cd_edicao">Edicao</label>
                            <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($edicoes as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_edicao; ?>"
                                        <?php if (set_value('cd_edicao') == $item->ci_edicao){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_edicao; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                                <label for="cd_etapa">Etapa</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="3" class="form-control">
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
                    </div>
                    

                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('avaliacao/avaliacoes/')?>">

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