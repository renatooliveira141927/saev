<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/escolas.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'ADMINISTRAR ESCOLAS' ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('escola/escolas/novo'); ?>">Cadastrar</a>
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
                            class="form-control" disabled>
                        <option value="">Selecione o estado</option>
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
                    <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">                            
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label>Município *</label>
                    <input  type="text"
                            disabled
                            class="form-control"
                            value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>"> 
            <input type="hidden" name="cd_cidade" id="cd_cidade" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">                            
                </div>
            </div>            
        <?php }else{?> <!-- Se o usuário for Escola-->

            <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
            <input type="hidden" name="cd_cidade" id="cd_cidade" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
            <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">

        <?php }?> <!-- Fim grupo Escola -->

        <div class="col-lg-6">
            <div class="form-group">
                <label for="nm_escola">Nome</label>
                <input type="text"
                        name="nm_escola"
                        id="nm_escola"
                        tabindex="1"
                        placeholder="Nome"
                        class="form-control"
                        value="<?php echo set_value('nm_escola');?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="nr_inep">INEP</label>
                        <input type="text"
                            name="nr_inep"
                            id="nr_inep"
                            tabindex="2"
                            placeholder="INEP"
                            class="form-control"
                            value="<?php echo set_value('nr_inep'); ?>">
            </div>
        </div>
        

        <div class="col-lg-12 form-group">
                                    <div class="col-md-4">
                                        <label id="">Tipo de Unidade</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="extencao_p">
                                                <input type="radio" name="fl_extencao" id="extencao_p" value="P" tabindex="3"
                                                    <?php if(set_value('fl_extencao') == 'P'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Polo
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="extencao_e">
                                                <input type="radio" name="fl_extencao" id="extencao_e" value="E"  class="form-check-input" tabindex="4"
                                                    <?php if(set_value('fl_extencao') == 'E'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Extensão
                                            </label>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label id="">Tipo de escola *</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="tp_unidader">
                                                <input type="radio" name="fl_tpunidade" id="tp_unidader" value="R" tabindex="3"
                                                    <?php if((set_value('fl_tpunidade') == 'R') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Regular
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="tp_unidadeq">
                                                <input type="radio" name="fl_tpunidade" id="tp_unidadeq" value="Q"  class="form-check-input" tabindex="4"
                                                    <?php if((set_value('fl_tpunidade') == 'Q') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Quilombola
                                            </label>&nbsp;&nbsp;&nbsp;
                                            <label class="radio-inline control-label" for="tp_unidadei">
                                                <input type="radio" name="fl_tpunidade" id="tp_unidadei" value="I"  class="form-check-input" tabindex="4"
                                                    <?php if((set_value('fl_tpunidade') == 'I') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Indígena
                                            </label>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                <div class="col-md-4">
                    <label id="">Localização da escola</label>
                    <div class="form-control">
                        <label class="radio-inline control-label" for="localizacao_u">
                            <input type="radio" name="fl_localizacao" id="localizacao_u" value="U" tabindex="3"
                                <?php if(set_value('fl_localizacao') == 'U'){
                                    echo 'checked'; }
                                    ?>>
                            Urbana
                        </label>&nbsp;&nbsp;&nbsp;
                        
                        <label class="radio-inline control-label" for="localizacao_r">
                            <input type="radio" name="fl_localizacao" id="localizacao_r" value="R"  class="form-check-input" tabindex="4"
                                <?php if(set_value('fl_localizacao') == 'R'){
                                    echo 'checked'; }
                                    ?>>
                            Rural
                        </label>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
        </div>    
        <div align="right" class="col-lg-12">        
            <input type="hidden"
                    id="url_base"
                    value="<?php echo base_url('escola/escolas')?>"><br/>
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
    <script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>