<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/transferencias.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script>
    function add_inep_escola(){
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
    function pesquisa_cd_escola(id){

        var option  = $( "select[name^='cd_escola'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');

            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }

    function escola_selecionda(id_escola, cd_turma){
        add_inep_escola();
        populaturma('',id_escola, '', cd_turma);
    }

    function atualiza_combos_turma(nm_cd_turma, nm_cd_etapa, nm_cd_turno){


        var cd_etapa = $('#'+nm_cd_turma).find(':selected').attr('cd_etapa');
        var cd_turno = $('#'+nm_cd_turma).find(':selected').attr('cd_turno');
        
        atualiza_etapa(nm_cd_etapa, cd_etapa);
        atualiza_turno(nm_cd_turno, cd_turno)
    }

    function atualiza_turno(nm_cd_turno, id){

        var option  = $( "select[name^='"+nm_cd_turno+"'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');

            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }

    function atualiza_etapa(nm_cd_etapa, id){

        var option  = $( "select[name^='"+nm_cd_etapa+"'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');
            // alert('atualiza_etapa=>  attr_value='+attr_value+'  id='+id);
            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }
    function zerar_turma(nm_cd_turma){
        $('#'+nm_cd_turma).val("");
    }
</script>
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar transferências ' ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('transferencia/transferencias/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <div class="container card-box">        
        <div class="form-group">
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
                            onchange="add_inep_escola();">
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
                    <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">        
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
                        onchange="add_inep_escola();">
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

        </div>
        <div class="form-group">
            <div  class="col-lg-4">
                <div class="form-group">
                    <label for="cd_turma">Turma </label>
                    <select id="cd_turma" name="cd_turma" tabindex="3" 
                    <?php if ($this->session->userdata('ci_grupousuario') != 3){ echo 'disabled'; }?>
                    onchange="atualiza_combos_turma('cd_turma', 'cd_etapa', 'cd_turno');"
                    class="form-control">
                        <Option value="" cd_etapa="" cd_turno=""></Option>
                        <?php
                        foreach ($turmas as $item) {
                            ?>
                            <Option value="<?php echo $item->ci_turma; ?>"  
                                    cd_etapa="<?php echo $item->cd_etapa; ?>" 
                                    cd_turno="<?php echo $item->cd_turno; ?>"
                                <?php if (set_value('cd_turma') == $item->ci_turma){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_turma; ?>
                            </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div  class="col-lg-5">
                <div class="form-group">
                    <label for="cd_etapa">Etapa </label>
                    <select id="cd_etapa" name="cd_etapa" tabindex="4" class="form-control" onchange="zerar_turma('cd_turma');">
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
            <div  class="col-lg-3">
                <div class="form-group">
                    <label for="cd_turno">Turno </label>
                    <select id="cd_turno" name="cd_turno" tabindex="4" class="form-control" onchange="zerar_turma('cd_turma');">
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
        </div>
            <div class="col-md-5">
                <div class="form-group">
                        <label for="tbtrans">Tipo da Transferência </label>
                        <input type="radio" name="tptrans" id="tpe" value="E" tabindex="1" checked>
                        <label class="form-check-label" for="tpe">Escola Origem</label>
                        <input type="radio" name="tptrans" id="tpr" value="R" tabindex="2">
                        <label class="form-check-label" for="tpr">Escola Destino</label>
                </div>
            </div>            
             <div class="col-md-5">
                <div class="form-group">
                        <label for="tbtrans">Situação </label>
                        <input type="radio" name="fl_status" id="flt" value="T" tabindex="3">
                        <label class="form-check-label" for="tpe">Aprovada</label>
                        <input type="radio" name="fl_status" id="flf" value="F" tabindex="4"  checked>
                        <label class="form-check-label" for="tpr">Aguardando Aprovação</label>
                </div>
            </div> 
        <div align="right" class="col-lg-12">        
            <input type="hidden"
                    id="url_base"
                    value="<?php echo base_url('transferencia/transferencias')?>"><br/>
            <button type="button" id="btn_consulta"
                    tabindex="9"
                    class="btn btn-custom waves-effect waves-light btn-micro active">
                Consultar
            </button>
        </div>        
    </div>
    <!-- Div para listagem resultado da consulta-->
    <div class="container">
        <div id="listagem_resultado"></div>
    </div>
    </form>