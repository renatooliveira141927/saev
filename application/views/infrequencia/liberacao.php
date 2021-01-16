<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/liberacaoinfrequencia.js'); ?>"></script>
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
	<div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar Liberação de Infrequ&ecirc;ncia ' ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('infrequencia/infrequencia/cadastraliberacao'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>
        <!-- Inicio Div Parametros -->
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        <div class="container card-box">
            <div class="col-md-12">
                <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados abrir menu grupo SME-->
                    <div class="col-lg-6"> 
                        <div class="form-group">
                            
                            <label>Estado *</label>
                            <select id="cd_estado" 
                                    name="cd_estado" 
                                    tabindex="1"
                                    class="form-control" 
                                    onchange="populacidade(this.value, '', '', false, $('#cd_cidade'))">

                                <?php echo $estado ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Município *</label>
                            <select id="cd_cidade" 
                                    name="cd_cidade" 
                                    tabindex="2"                                                    
                                    class="form-control" disabled>
                                <option value="">Selecione o estado</option>
                            </select>
                        </div>
                    </div>
                                    <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

                    <div class="col-lg-6">                                                    
                        <div class="form-group">
                            
                            <label>Estado *</label>
                            <input  type="text"
                            		tabindex="1"
                                    disabled
                                    class="form-control"
                                    value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Município *</label>

                            <input  type="text"
                            		tabindex="2"
                                    disabled
                                    class="form-control"
                                    value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">
                            
                        </div>
                    </div>    
                    <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="hidden" name="cd_cidade" id="cd_cidade" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">                   
                <?php }?> 
                
                 <div  class="col-lg-4">
                    <div class="form-group">
                        <label for="nr_mes">M&ecirc;s *</label>
                        <select id="cd_mes" name="cd_mes" tabindex="3" class="form-control">                        	
                                <?php echo $meses ?>
                        </select>
                     </div>   
                </div>
                 <div  class="col-lg-9">
                	<div>
                	<a href="https://youtu.be/Oklkan7Pqi4" target="_blank">Veja o vídeo explicativo sobre a infrequência </a>
                	</div>
                </div>	                
                <div align="right">        
                    <input type="hidden"
                            id="url_base"
                            value="<?php echo base_url('infrequencia/infrequencia')?>">
                        <a id="btn_consulta"></a>
                    <a type="button" id="btn_consulta_liberacao"
                            tabindex="4"                            
                            class="btn btn-custom waves-effect waves-light btn-micro active"
                            onclick="javascript:validaform();">
                        Consultar
                    </a>
                    <script type="text/javascript">
                    function validaform(){
                        var invalido = true;
                        
                        if ($('#cd_cidade').val()!=""){
                        	invalido = false;
                        }
                        
                        if ($('#cd_mes').val()!=""){
                        	invalido = false;
                        }else{
                        	invalido = true;
                        }
                       
                        if (invalido){
                            alert('Alguns campos obrigatórios não foram informados!');
                        }else{
                            $('#btn_consulta').click();
                        }
                    }
                    </script>
                </div>   
            </div>
        </div>    
        <!-- Fim Div Parametros -->
        <!-- Inicio Div Consulta -->       
        <div class="container card-box">
            <div class="col-md-12">
                <!-- Div para listagem resultado da consulta-->
                <div id="listagem_resultado"></div>
            </div>
        </div>
        <!-- Fim Div Consulta -->
    <?php echo form_close();?>