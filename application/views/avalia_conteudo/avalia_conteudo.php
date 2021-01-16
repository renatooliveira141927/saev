<script src="<?=base_url('assets/listagem_cadastros/js/avalia_conteudos.js'); ?>"></script>
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
                       href="<?php echo base_url('avalia_conteudo/avalia_conteudos/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <form action="<?php echo base_url('avalia_conteudo/avalia_conteudos/gerar_excel'); ?>" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="col-lg-12">
                        
                    <div class="col-lg-12">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="cd_disciplina">Disciplina </label>
                                    <select id="cd_disciplina" name="cd_disciplina" tabindex="1" class="form-control">
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
                            </section>
                        </div>
                        <div class="col-lg-12">
                            <section class="main row">
                                <div class="form-group">
                                    <label for="nm_avalia_conteudo">Nome do conteúdo</label>
                                    <input type="text"
                                           name="nm_avalia_conteudo"
                                           id="nm_avalia_conteudo"
                                           tabindex="2"
                                           placeholder="Nome do conteúdo"
                                           style="text-transform: uppercase;"
                                           class="form-control"
                                           value="<?php echo set_value('nm_avalia_conteudo');?>">

                                </div>
                            </section>
                        </div>
                        
                    </div>

                    <input type="hidden"
                           id="url_listar"
                           value="<?php echo base_url('avalia_conteudo/avalia_conteudos/listagem_consulta')?>">

                    <div align="right" class="main row">
                        <button type="button" id="btn_consulta"
                                tabindex="3"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Consultar
                        </button>
                    </div>
                </div>




    </div>
    <!-- Div para listagem resultado da consulta-->
    <div id="listagem_resultado"></div>

    </form>