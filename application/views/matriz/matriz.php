<script src="<?=base_url('assets/js/matrizes.js'); ?>"></script>
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo $titulo ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('matriz/matrizes/novo'); ?>">Cadastrar</a>
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
                    <div class="col-lg-12">
                        
                        <section class="main row">
                            
                            <div class="form-group col-lg-12">
                                <label for="nm_matriz">Nome da matriz</label>
                                <input type="text"
                                        name="nm_matriz"
                                        id="nm_matriz"
                                        tabindex="2"
                                        placeholder="Nome da matriz"
                                        class="form-control"
                                        value="<?php echo set_value('nm_matriz');?>">

                            </div>
                            <div class="form-group col-lg-6">
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
                            <div class="form-group col-lg-6">
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
                        </section>
                    </div>

                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('matriz/matrizes/')?>">

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