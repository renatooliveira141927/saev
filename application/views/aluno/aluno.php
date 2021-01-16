<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/alunos.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>


<link href="<?=base_url('assets/css/bootstrap-toggle.min.css'); ?>" rel="stylesheet">
<script src="<?=base_url('assets/js/bootstrap-toggle.min.js'); ?>"></script>

<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep').toUpperCase());
    }

    function pesquisa_inep_escola(inep){

        if (inep != ''){
        
            var option  = $( "select[name^='cd_escola'] option" );

            option.each(function () {

                var attr_value = $(this).attr('nr_inep');

                if (attr_value == inep) {
                    $(this).prop("selected", true);
                    encontrou = true;

                    $("#cd_escola").change();
                }else{
                    $(this).prop("selected", false);
                }
            });
        }
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
</script>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar '.$titulo ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('aluno/alunos/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    
    <div class="container-fluid">
        <div class="card-box">
            <div class="container-fluid">

                <section class="main row"> 
                    
                        <div class="form-group">

                            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->
                            

                                <div class="row">
                                
                                    <div class="col-md-3">
                                        
                                        <label>Estados * </label>
                                        <select id="cd_estado" 
                                                name="cd_estado" 
                                                tabindex="1"
                                                class="form-control" 
                                                autofocus
                                                onchange="populacidade(this.value);">

                                            <?php echo $estado ?>

                                        </select>
                                    </div>
                                    <div class="col-md-9">
                                     
                                        
                                            <table style="width:100%;">
                                                <tr><td><label>Municípios * </label></td><td><label>Situação </label></td></tr>
                                                <tr>
                                                    <td style="width:90%; padding-right: 10px;">
                                                        <select id="cd_cidade" 
                                                                name="cd_cidade" 
                                                                tabindex="2"  
                                                            <?php if (!$cd_cidade){ ?>
                                                                disabled
                                                            <?php }?>
                                                                onchange="populaescola(this.value); $('#nr_inep_escola').prop('disabled', false);"
                                                                class="form-control" >
                                                                <?php echo $cidades ?>
                                                                
                                                        </select>
                                                    </td>
                                                    <td style="width:10%;">                                                
                                                        <input  name="fl_ativo" id="fl_ativo" type="checkbox" value="true"
                                                            data-toggle="toggle" data-on="Ativos " 
                                                            data-off="Excluídos " data-onstyle="default" data-offstyle="danger"
                                                        <?php if (($fl_ativo == 't') || (!$fl_ativo)){ ?>
                                                            checked
                                                        <?php }?> >
                                                    </td>
                                                </tr>
                                            
                                            </table>
                                        </div>
                                    </div>
                                    <!-- style="width:10%; border:1px solid red; float:left;" -->
                                </div>
                                <div class="row">
                                    <div  class="col-md-2">
                                        <div class="form-group">
                                            <label for="nr_inep_escola">Inep escola</label>
                                            <input type="number"
                                                name="nr_inep_escola"
                                                id="nr_inep_escola"
                                                tabindex="3"
                                                <?php if (!$nr_inep_escola){ ?>
                                                    disabled
                                                <?php }?>
                                                placeholder="Inep escola"
                                                class="form-control"
                                                value="<?php echo $nr_inep_escola; ?>"
                                                onblur="pesquisa_inep_escola(this.value);">
                                                
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label>Escola </label>
                                            <select id="cd_escola" 
                                                    name="cd_escola"                                             
                                                    tabindex="4" 
                                                <?php if (!$cd_escola){ ?>
                                                    disabled
                                                <?php }?>
                                                    class="form-control"
                                                    onchange="escola_selecionda(this.value);">
                                                <Option value="" nr_inep=""></Option>
                                                <?php echo $escolas ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nr_inep_aluno">Inep</label>
                                                        <input type="number"
                                                            name="nr_inep_aluno"
                                                            id="nr_inep_aluno"
                                                            tabindex="8"
                                                            placeholder="Inep"
                                                            class="form-control"
                                                            maxlength="32"
                                                            value="<?php echo $nr_inep_aluno; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="nm_aluno">Nome</label>
                                            <input type="text"
                                                    name="nm_aluno"
                                                    id="nm_aluno"
                                                    tabindex="9"
                                                    placeholder="Nome"                                        
                                                    class="form-control"
                                                    maxlength="150"
                                                    value="<?php echo $nm_aluno;?>">
                                        </div>
                                    </div>
                                </div>
                            <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim Se o usuário for SME-->
                                <div class="row">
                                    <div class="form-group col-md-3">  
                                        <label>Estados </label>                                      
                                        <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                                        <input type="hidden" name="cd_estado" id="cd_estado" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                                    </div>
                                    <div class="col-md-9">
                                        <table style="width:100%;">
                                            <tr><td><label>Municípios * </label></td><td><label>Situação </label></td></tr>
                                            <tr>
                                                <td style="width:90%; padding-right: 10px;">
                                                    <select id="cd_cidade" 
                                                            name="cd_cidade" 
                                                            tabindex="2"  
                                                        <?php if (!$cd_cidade){ ?>
                                                            disabled
                                                        <?php }?>
                                                            onchange="populaescola(this.value); $('#nr_inep_escola').prop('disabled', false);"
                                                            class="form-control" >
                                                            <?php echo $cidades ?>
                                                            
                                                    </select>
                                                </td>
                                                <td style="width:10%;">                                                
                                                    <input  name="fl_ativo" id="fl_ativo" type="checkbox" value="true"
                                                        data-toggle="toggle" data-on="Ativos " 
                                                        data-off="Excluídos " data-onstyle="default" data-offstyle="danger"
                                                    <?php if ($fl_ativo == 't' || $fl_ativo == ''){ ?>
                                                        checked
                                                    <?php }?> >
                                                </td>
                                            </tr>
                                        
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div  class="col-md-2">
                                        <div class="form-group">
                                            <label for="nr_inep_escola">Inep escola</label>
                                            <input type="number"
                                                name="nr_inep_escola"
                                                id="nr_inep_escola"
                                                tabindex="1"
                                                placeholder="Inep escola"
                                                class="form-control"
                                                autofocus
                                                value="<?php echo $nr_inep_escola; ?>"
                                                onblur="pesquisa_inep();">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="cd_escola">Escola </label>
                                            <select id="cd_escola" 
                                                    name="cd_escola" 
                                                    tabindex="2"                                 
                                                    class="form-control"
                                                    onchange="escola_selecionda(this.value);">
                                                <?php echo $escolas ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nr_inep_aluno">Inep</label>
                                                        <input type="number"
                                                            name="nr_inep_aluno"
                                                            id="nr_inep_aluno"
                                                            tabindex="8"
                                                            placeholder="Inep"
                                                            class="form-control"
                                                            maxlength="32"
                                                            value="<?php echo $nr_inep_aluno; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="nm_aluno">Nome</label>
                                            <input type="text"
                                                    name="nm_aluno"
                                                    id="nm_aluno"
                                                    tabindex="9"
                                                    placeholder="Nome"                                        
                                                    class="form-control"
                                                    maxlength="150"
                                                    value="<?php echo $nm_aluno;?>">
                                        </div>
                                    </div>
                                </div>
                            <?php }else{?> <!-- Fim grupo SME -->
                                <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo $cd_escola;?>">
                                <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                                <input type="hidden" name="cd_cidade" id="cd_cidade" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                                <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">


                                <div class="row">
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nr_inep_aluno">Inep</label>
                                            <input type="number"
                                                name="nr_inep_aluno"
                                                id="nr_inep_aluno"
                                                tabindex="8"
                                                placeholder="Inep"
                                                class="form-control"
                                                maxlength="32"
                                                value="<?php echo $nr_inep_aluno; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <table style="width:100%;">
                                            <tr><td><label>Nome </label></td><td><label>Situação </label></td></tr>
                                            <tr>
                                                <td style="width:90%; padding-right: 10px;">
                                                    <input type="text"
                                                            name="nm_aluno"
                                                            id="nm_aluno"
                                                            tabindex="9"
                                                            placeholder="Nome"                                        
                                                            class="form-control"
                                                            maxlength="150"
                                                            value="<?php echo $nm_aluno;?>">
                                                            
                                                    </select>
                                                </td>
                                                <td style="width:10%;">                                                
                                                    <input  name="fl_ativo" id="fl_ativo" type="checkbox" value="true"
                                                        data-toggle="toggle" data-on="Ativos " 
                                                        data-off="Excluídos " data-onstyle="default" data-offstyle="danger"
                                                    <?php if ($fl_ativo == 't' || $fl_ativo == ''){ ?>
                                                        checked
                                                    <?php }?> >
                                                </td>
                                            </tr>
                                        
                                        </table>
                                    </div>
                                </div>
                            <?php }?> <!-- Fim grupo scola -->

                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cd_turma">Turma </label>
                                        <select id="cd_turma" 
                                                name="cd_turma" 
                                                tabindex="5" 
                                                autofocus
                                                class="form-control" 
                                                <?php if (!$cd_escola){ ?>
                                                        disabled
                                                <?php }?>>
                                            <Option value=""></Option>
                                            <?php echo $turmas ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="cd_etapa">Etapa </label>
                                        <select id="cd_etapa" name="cd_etapa" tabindex="6" class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($etapas as $item) {
                                                ?>

                                                <Option value="<?php echo $item->ci_etapa; ?>"
                                                    <?php if ($cd_etapa == $item->ci_etapa){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_etapa; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cd_turno">Turno </label>
                                        <select id="cd_turno" name="cd_turno" tabindex="7" class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($turnos as $item) {
                                                ?>

                                                <Option value="<?php echo $item->ci_turno; ?>"
                                                    <?php if ($cd_turno == $item->ci_turno){
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
                                        <label for="cd_ano_letivo">Ano letivo</label>
                                        <select id="cd_ano_letivo" name="cd_ano_letivo" tabindex="10" class="form-control">                                             
                                            <?php echo $anos ?>
                                        </select>
                                    </div>
                                </div>
                                                                
                            </div>
                            <div>
                            	<div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fl_rede">Ver alunos da:</label>
                            					<td style="width:10%;">                                                
                                                        <input  name="fl_rede" id="fl_rede" type="checkbox" value="true"
                                                            data-toggle="toggle" data-on="Escola " 
                                                            data-off="Rede Muncipal " data-onstyle="default" data-offstyle="danger"
                                                        <?php if (($fl_ativo == 't') || (!$fl_ativo)){ ?>
                                                            checked
                                                        <?php }?> >
                                                    </td>
                                     </div>
                                 </div>                   
                            </div>
                        </div>

                </section>
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                <input type="hidden" name="url_base" id="url_base" value="<?php echo base_url('aluno/alunos/')?>">

                <div  style="text-align:right" class="main row">
                    <button type="button" id="btn_consulta"
                            tabindex="10"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Consultar
                    </button>
                                            
                </div>
            </div>
        </div>
    </div>
    <!-- Div para listagem resultado da consulta-->
    <div class="container-fluid" id="listagem_resultado"></div>

    </form>