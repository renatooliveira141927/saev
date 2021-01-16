<script src="<?=base_url('assets/js/turmas.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_professor.js'); ?>"></script>
<script>
    function add_inep(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep').toUpperCase());
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );       
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep.toUpperCase() == attr_inep.toUpperCase()) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }
</script>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'ADMINISTRAR TURMAS' ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('turma/turmas/novo'); ?>">Cadastrar</a>
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

        <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador -->
                                
            <!-- Inicio div municipio sme -->
            <div class="col-lg-6">                                                    
                <div class="form-group">

                    <label>Estado *</label>
                    <select id="cd_estado_sme" 
                            name="cd_estado_sme" 
                            tabindex="1"
                            class="form-control" 
                            onchange="populacidade(this.value, '', '', false, $('#cd_cidade_sme'))">

                        <?php echo $estado ?>

                    </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Município *</label>
                    <select id="cd_cidade_sme" 
                            name="cd_cidade_sme" 
                            tabindex="2"                                                    
                            class="form-control" disabled
                            onchange="populaescola(this.value,'');">
                        <option value="">Selecione o estado</option>
                    </select>
                </div>
            </div>
            <div  class="col-lg-2">
                <div class="form-group">
                    <label for="nr_inep_escola">Inep escola</label>
                    <input type="text"
                        name="nr_inep_escola"
                        id="nr_inep_escola"
                        tabindex="3"
                        placeholder="Inep escola"
                        class="form-control"
                        value="<?php echo set_value('nr_inep_escola'); ?>"
                        onblur="pesquisa_inep();">
                </div>
            </div>
            <div class="col-lg-10">
                <div class="form-group">
                    <label for="cd_escola">Escola</label>
                    <select id="cd_escola" 
                            name="cd_escola" 
                            tabindex="4" 
                            disabled
                            class="form-control"
                            onchange="add_inep();">
                        <Option value="" nr_inep=""></Option>
    
                    </select>
                </div>
            </div>
            <!-- Fim div municipio sme-->

        <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

            <div class="col-lg-6">                                                    
                <div class="form-group">

                    <label>Estado *</label>
                    <input  type="text"
                            disabled
                            class="form-control"
                            value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Município *</label>

                    <input  type="text"
                            disabled
                            class="form-control"
                            value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">
                    
                </div>
            </div>
            <div  class="col-lg-2">
                <div class="form-group">
                    <label for="nr_inep_escola">Inep escola</label>
                    <input type="text"
                        name="nr_inep_escola"
                        id="nr_inep_escola"
                        tabindex="3"
                        placeholder="Inep escola"
                        class="form-control"
                        value="<?php echo set_value('nr_inep_escola') ?>"
                        onblur="pesquisa_inep();">
                </div>   
            </div>
            <div class="col-lg-10">
                <div class="form-group">
                    <label for="cd_escola">Escola</label>
                    <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                        onchange="add_inep();">
                        <Option value="" nr_inep=""></Option>
                        <?php
                            foreach ($escolas as $item) {
                                ?>
                                <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                    <?php if (set_value('cd_escola') == $item->ci_escola){
                                        echo 'selected';
                                    } ?> >
                                    <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>


        <?php }else{?> <!-- Se o usuário for Escola-->

            <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
            <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
            <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">

        <?php }?> <!-- Fim grupo Escola -->

        <div class="col-lg-6">
            <div class="form-group">
                <label for="nm_turma">Nome</label>
                <input type="text"
                        name="nm_turma"
                        id="nm_turma"
                        tabindex="2"
                        placeholder="Nome"
                        class="form-control"
                        value="<?php echo set_value('nm_turma');?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="cd_ano_letivo">Ano Letivo *</label>
                <input type="text"
                    name="nr_ano_letivo"
                    id="nr_ano_letivo"
                    tabindex="2"
                    placeholder="Ano letivo"
                    class="form-control"
                    value="<?php echo set_value('nr_ano_letivo');?>">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="cd_etapa">Etapa</label>
                <select id="cd_etapa" name="cd_etapa" tabindex="1" class="form-control">
                    <Option value=""></Option>
                    <?php
                    foreach ($etapas as $item) {
                        ?>
                        <Option value="<?php echo $item->ci_etapa; ?>"
                            <?php if ((set_value('cd_etapa') == $item->ci_etapa)){
                                echo 'selected';
                            } ?> >
                            <?php echo $item->nm_etapa; ?>
                        </Option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="cd_turno">Turno</label>
                <select id="cd_turno" name="cd_turno" tabindex="1" class="form-control">
                    <Option value=""></Option>
                    <?php
                    foreach ($turnos as $item) {
                        ?>
                        <Option value="<?php echo $item->ci_turno; ?>"
                            <?php if ((set_value('cd_turno') == $item->ci_turno)){
                                echo 'selected';
                            } ?> >
                            <?php echo $item->nm_turno; ?>
                        </Option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- <div class="col-lg-12">
            <div class="form-group">
                <label for="cd_professor">Professor</label>
                <select id="cd_professor" name="cd_professor" tabindex="1" class="form-control">
                    <Option value=""></Option>
                    <'?php
                    foreach ($professores as $item) {
                        ?>
                        <Option value="<'?php echo $item->ci_professor; ?>"
                            <'?php if ((set_value('cd_professor') == $item->ci_professor)){
                                echo 'selected';
                            } ?> >
                            <'?php echo $item->nm_professor; ?>
                        </Option>

                    <'?php } ?>
                </select>
            </div>
        </div>     -->
        <div align="right" class="col-lg-12">
            <input type="hidden"
                    id="url_base"
                    value="<?php echo base_url('turma/turmas')?>"><br/>
            <button type="button" id="btn_consulta"
                    tabindex="5"
                    class="btn btn-custom waves-effect waves-light btn-micro active">
                Consultar
            </button>
        </div>        
    </div>
    <!-- Div para listagem resultado da consulta-->
    
    <div id="listagem_resultado"></div>
    
    </form>
    <script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>