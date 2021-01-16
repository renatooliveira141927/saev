<script src="<?=base_url('assets/js/anos_letivos.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar '.$titulo ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('ano_letivo/anos_letivos/novo'); ?>">Cadastrar</a>
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
                <section class="main row">
                    <div class="form-group col-lg-6">
                        <label for="nr_ano_letivo">Ano letivo</label>
                        <input type="hidden" id="consulta" value="true">
                        <input type="number"
                                name="nr_ano_letivo"
                                id="nr_ano_letivo"
                                tabindex="1"
                                placeholder="Ano letivo"
                                class="form-control"
                                value="<?php echo set_value('nr_ano_letivo');?>">

                    </div>
                    <div class="form-group col-lg-6">
                        <label for="nm_escola">Nome da escola</label>
                        <input type="text"
                                name="nm_escola"
                                id="nm_escola"
                                tabindex="2"
                                placeholder="Nome da escola"
                                class="form-control"
                                value="<?php echo set_value('nm_escola');?>">

                    </div>          
                    <div class="form-group col-lg-6">
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                        <label>Estados </label>
                        <select id="cd_estado" 
                                name="cd_estado" 
                                tabindex="3"
                                class="form-control" 
                                onchange="populacidade(this.value, '', '', 'true', $('#cd_cidade'));">

                            <?php echo $estado ?>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <div  class="form-group">
                            <label>Municípios </label>
                            <select id="cd_cidade" 
                                    name="cd_cidade" 
                                    tabindex="4"      
                                    disabled                                
                                    onchange="populaescola(this.value,'');"
                                    class="form-control" >
                            </select>
                        </div>
                    </div>     
                    <div class="col-lg-12">
                        <div  class="form-group">
                            <label>Escolas </label>

                            <select id="cd_escola" 
                                    name="cd_escola" 
                                    disabled
                                    tabindex="5"
                                    class="form-control" >
                            </select>
                        </div>
                    </div>
                </section>
                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('ano_letivo/anos_letivos/')?>">

                    <div  align="right" class="main row">
                        <button type="button" id="btn_consulta"
                                tabindex="6"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Consultar
                        </button>
                                                
                    </div>
                </div>




    </div>
    <!-- Div para listagem resultado da consulta-->
    <div id="listagem_resultado"></div>

    </form>