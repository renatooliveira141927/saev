<script src="<?=base_url('assets/js/avaliacao_upload.js'); ?>"></script>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'ADMINISTRAR AVALIAÇÃO'?></h4>
                </p>
            </div>

            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador -->
                <div class="col-md-2" style="text-align: right">
                    <p>
                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                        href="<?php echo base_url('avaliacao_upload/avaliacao_uploads/novo'); ?>">Cadastrar</a>
                    </p>
                </div>
            <?php }?> <!-- Fim Se o usuário for administrador -->

        </div>
    </div>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="form-group col-lg-12">
                        
                        <div class="col-lg-2">
                            <label for="nm_caderno">Nome do Caderno</label>
                            <input type="text"
                                    name="nm_caderno"
                                    id="nm_caderno"
                                    tabindex="2"
                                    placeholder="Caderno"
                                    style="text-transform: uppercase;"
                                    class="form-control"
                                    value="<?php echo set_value('nm_caderno');?>">

                        </div>
                        <div class="col-lg-5">
                            <label for="cd_avalia_tipo">Tipo de avaliação</label>
                            <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="1" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_tipos as $item) {
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
                        <div class="col-lg-5">
                            <label for="cd_edicao">Edição</label>
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
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="col-lg-6">
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
                        
                        <div class="col-lg-6">
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
                           value="<?php echo base_url('avaliacao_upload/avaliacao_uploads/')?>">

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