<script src="<?=base_url('assets/listagem_cadastros/js/avalia_montar_itens.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container">
        <div  class="card-group">
            <div id="page-wrapper" >
                    <div class="row">
                        <div class="col-lg-12">
                                    <h3 class="page-header">Caderno: <?php echo $nm_caderno?> - Escolha os itens para avaliação</h3>

                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <!-- Div Parametros -->
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div class="panel-heading">Parametros de consulta</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div>
                                                <label for="ds_codigo">Código do item</label>
                                                <input type="text"
                                                        name="ds_codigo"
                                                        id="ds_codigo"
                                                        tabindex="2"
                                                        placeholder="Código do item"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php echo set_value('ds_codigo');?>">

                                            </div>
                                            <div>
                                                <label for="cd_dificuldade">Dificuldade</label>
                                                <select id="cd_dificuldade" name="cd_dificuldade" tabindex="2" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($avalia_dificuldades as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_avalia_dificuldade; ?>"
                                                            <?php if ((set_value('cd_dificuldade') == $item->ci_avalia_dificuldade) && ($msg != 'success')){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_avalia_dificuldade; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div>                           
                                        </div>
                                        <div class="form-group">
                                            <div>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div  align="right" class="main row">
                                <button type="button" id="btn_consulta"
                                        tabindex="5"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                    Consultar
                                </button>
                                <input  type="hidden"
                                    id="url_base"
                                    value="<?php echo base_url('avaliacao/avalia_montar')?>">
                        
                            </div>
                        </div>  
                        <div class="col-lg-9">
                            <div class="panel panel-default">
                                <div class="panel-heading">Escolha os itens</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <!-- Div para listagem resultado da consulta-->
                                            <div id="listagem_resultado"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    </form>