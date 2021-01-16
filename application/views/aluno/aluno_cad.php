<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/cep_endereco.js'); ?>"></script>

<style>
select[readonly] {
  background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
  pointer-events: none;
  touch-action: none;
}
</style>

<script type='text/javascript'> 
    function valida_form(){
        var validacao = true;

        var cd_estado_sme   = $('#cd_estado_sme').val(); 
        var cd_cidade_sme   = $('#cd_cidade_sme').val();
        var cd_escola       = $('#cd_escola').val();
        var nm_aluno        = $('#nm_aluno').val()
        var sexo_m          = $('#sexo_m').is(':checked');
        var sexo_f          = $('#sexo_f').is(':checked');
        var sexo_o          = $('#sexo_o').is(':checked');
        var telefone1       = $('#telefone1').val();
        var nm_mae          = $('#nm_mae').val();
        var calendario      = $('#calendario').val();
        var cd_estado       = $('#cd_estado').val();
        var cd_cidade        = $('#cd_cidade').val();
        
        if ( (cd_estado_sme === '' || cd_estado_sme === null || cd_estado_sme === '0') ){

            validacao = false;            
            $('#cd_estado_sme').css('border', '1px solid orange');
        }else{
            $('#cd_estado_sme').css('border', '1px solid #E3E3E3');
        }
        if ( (cd_cidade_sme === '' || cd_cidade_sme === null || cd_cidade_sme === '0') ){

            validacao = false;
            $('#cd_cidade_sme').css('border', '1px solid orange');
        }else{
            $('#cd_cidade_sme').css('border', '1px solid #E3E3E3');
        }
        
        if ( (cd_escola === '' || cd_escola === null || cd_escola === '0') ){

            validacao = false;
            $('#cd_escola').css('border', '1px solid orange');
        }else{
            $('#cd_escola').css('border', '1px solid #E3E3E3');
        }
        if ( (nm_aluno === '' || nm_aluno === null ) ){
            
            validacao = false;
            $('#nm_aluno').css('border', '1px solid orange');
        }else{
            $('#nm_aluno').css('border', '1px solid #E3E3E3');
        }
        if ( (!sexo_m && !sexo_f && !sexo_o ) ){
            
            validacao = false;
            $('#sexo').css('border', '1px solid orange');
        }else{
            $('#sexo').css('border', '1px solid #E3E3E3');
        }
        if ( (telefone1 === '' || telefone1 === null ) ){
            
            validacao = false;
            $('#telefone1').css('border', '1px solid orange');
        }else{
            $('#telefone1').css('border', '1px solid #E3E3E3');
        }
        if ( (nm_mae === '' || nm_mae === null ) ){
            
            validacao = false;
            $('#nm_mae').css('border', '1px solid orange');
        }else{
            $('#nm_mae').css('border', '1px solid #E3E3E3');
        }
        if ( (calendario === '' || calendario === null ) ){
            
            validacao = false;
            $('#calendario').css('border', '1px solid orange');
        }else{
            $('#calendario').css('border', '1px solid #E3E3E3');
        }
        if ( (cd_estado === '' || cd_estado === null || cd_estado === '0') ){
            
            validacao = false;
            $('#cd_estado').css('border', '1px solid orange');
        }else{
            $('#cd_estado').css('border', '1px solid #E3E3E3');
        }
        if ( (cd_cidade === '' || cd_cidade === null || cd_cidade === '0') ){
            
            validacao = false;
            $('#cd_cidade').css('border', '1px solid orange');
        }else{
            $('#cd_cidade').css('border', '1px solid #E3E3E3');
        }
        if (!validacao){
            alert('Campo(s) obrigatório(s) não preenchido(s)!');
        }
        
        return validacao;
        
    }

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
    function bloqueia_titulo(){

        var base_url        = $('#base_url').val();
        var fl_bloqueado    = $('#fl_bloqueado').val();
        var validacao       = true;
        
        if (fl_bloqueado == 'S'){
            $('#img_cadeado').attr('src', base_url+'assets/images/icons/cadeado_aberto.png');
            $('#fl_bloqueado').val('N');

            $('#cd_estado_sme').attr('readonly', false);
            $('#cd_cidade_sme').attr('readonly', false);
            $('#nr_inep_escola').attr('readonly', false);
            $('#cd_escola').attr('readonly', false);
            $('#cd_turma').attr('readonly', false);

        }else{

            if ( ($('#cd_estado_sme').val() === '' || $('#cd_estado_sme').val() === null || $('#cd_estado_sme').val() === '0') ){
                validacao = false;
                $('#cd_estado_sme').css('border', '1px solid orange');
            }else{
                $('#cd_estado_sme').css('border', '1px solid #E3E3E3');
            }

            if ( ($('#cd_cidade_sme').val() === '' || $('#cd_cidade_sme').val() === null || $('#cd_cidade_sme').val() === '0') ){
                validacao = false;
                $('#cd_cidade_sme').css('border', '1px solid orange');
            }else{
                $('#cd_cidade_sme').css('border', '1px solid #E3E3E3');
            }

            if ( ($('#cd_escola').val() === '' || $('#cd_escola').val() === null || $('#cd_escola').val() === '0') ){
                validacao = false;
                $('#cd_escola').css('border', '1px solid orange');
            }else{
                $('#cd_escola').css('border', '1px solid #E3E3E3');
            }

            if (!validacao){
                alert('Existe(m) campo(s) que deve(m) ser preenchido(s) antes do bloqueio.');
                return false;
            }
            $('#img_cadeado').attr('src', base_url+'assets/images/icons/cadeado_fechado.png');
            $('#fl_bloqueado').val('S');

            $('#cd_estado_sme').attr('readonly', true);
            $('#cd_cidade_sme').attr('readonly', true);
            $('#nr_inep_escola').attr('readonly', true);
            $('#cd_escola').attr('readonly', true);
            $('#cd_turma').attr('readonly', true);
        }        
    }
</script>
<?php
    echo validation_errors('<script type="text/javascript">mensagem_sucesso("error" ,"','");</script>');
if($msg == "success"){

    ?>

    <script type="text/javascript">
        mensagem_sucesso("success" , "Registro gravado com sucesso!");
    </script>

    <?php
}else if($msg == "registro_ja_existente"){
    ?>

    <script type="text/javascript">
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o(a) aluno(a) já está cadastrado(a) no banco de dados!");
    </script>

    <?php
}
    echo form_open('aluno/alunos/salvar',array('id'=>'frm_alunos','method'=>'post', 'onsubmit' => 'return valida_form();','enctype'=>'multipart/form-data'))
?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            <div class="row page-header">
                    <div class="col-lg-12">
                        <div class="col-lg-6" >
                            <div class="span9 offset1!important" style="padding: 0 !important;margin: 0 !important;">
                                <h3>Cadastro de <?php echo $titulo ?></h3>
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding: 0 !important;margin: 0 !important;">
                            <div class="span9 offset1!important" style="text-align:right; vertical-align: middle;">
                                <button type="submit" 
                                        class="btn btn-custom waves-effect waves-light btn-micro active" 
                                        tabindex="26">
                                    Cadastrar
                                </button>
                                <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                                    href="<?php echo base_url('aluno/alunos/novo'); ?>">Novo</a>
                                <button type="button" 
                                        tabindex="27"
                                        onclick="window.location.href ='<?php echo base_url('aluno/alunos/index')?>';"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                        Voltar
                                </button>
                                

                                </button>
                        
                            </div>
                        </div>
                    </div>
            </div>


                <!-- /.row -->
                <div class="row">
                    <!-- Div Parametros -->


                            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados abrir menu grupo SME-->
                                
                                <!-- Inicio div municipio sme -->                        
                                <div class="col-lg-12 form-group" id="dv_gruposme"> 

                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="height:45px;">
                                            <div class="col-lg-11" style="text-align: left">
                                                Dados escola
                                            </div>
                                            <div class="col-lg-1" style="text-align: right">

                                                <input type="hidden" name="fl_bloqueado"  id="fl_bloqueado"  value="<?php echo $fl_bloqueado;?>">
                                                
                                                <a type="button" href="#" onclick="javascript:bloqueia_titulo();">
                                                    <?php if ($fl_bloqueado == 'S'){ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_fechado.png') ?>" alt="some text" width="25" height="20">
                                                    <?php }else{ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_aberto.png') ?>" alt="some text" width="25" height="20">
                                                    <?php } ?>
                                                </a>
                                            </div>  
                                        </div>
                                        <div class="panel-body">
                                        
                                            <div class="col-lg-6">                                                    
                                                <div class="form-group">
                                                    
                                                    <label>Estado *</label>
                                                        <select id="cd_estado_sme" 
                                                            name="cd_estado_sme" 
                                                            tabindex="1"
                                                            autofocus
                                                            class="form-control" 
                                                            <?php if ($fl_bloqueado == 'S'){ ?>
                                                                readonly
                                                            <?php } ?>
                                                            onchange="populacidade(this.value, '', '', false, $('#cd_cidade_sme'));">

                                                            <?php echo $estados ?>

                                                        </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Município *</label>
                                                        <select id="cd_cidade_sme" 
                                                                name="cd_cidade_sme" 
                                                                tabindex="2"                                                    
                                                                class="form-control" 
                                                                <?php if ($fl_bloqueado == 'S'){ ?>
                                                                    readonly
                                                                <?php }else{ ?>
                                                                    disabled
                                                                <?php } ?>
                                                                onchange="populaescola(this.value,''); $('#nr_inep_escola').prop('disabled', false);">
                                                            <option value="">Selecione o estado</option>
                                                            <?php echo $municipios ?>
                                                        </select>

                                                </div>
                                            </div>

                                            <div class="col-lg-2">                                                    
                                                <div class="form-group">
                                                    
                                                    <label for="nr_inep_escola">Inep escola</label>
                                                    <input type="number"
                                                        name="nr_inep_escola"
                                                        id="nr_inep_escola"
                                                        tabindex="3"
                                                        maxlength="32"
                                                        placeholder="Inep escola"
                                                        class="form-control"
                                                        <?php if ($fl_bloqueado == 'S'){ ?>
                                                            readonly
                                                        <?php }else{ ?>
                                                            disabled
                                                        <?php } ?>
                                                        value="<?php if (($msg != 'success') || ($fl_bloqueado == 'S')){
                                                                        if (set_value('nr_inep_escola')){
                                                                            echo set_value('nr_inep_escola');
                                                                        }else if ($fl_bloqueado == 'S'){
                                                                            echo $nr_inep_escola;
                                                                        }
                                                                }?>"
                                                        onblur="pesquisa_inep();">
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label for="cd_escola">Escola *</label>
                                                        <select id="cd_escola" 
                                                                name="cd_escola" 
                                                                tabindex="4" 
                                                                class="form-control" 
                                                                <?php if ($fl_bloqueado == 'S'){ ?>
                                                                    readonly
                                                                <?php }else{ ?>
                                                                    disabled
                                                                <?php } ?>
                                                                onchange="add_inep();populaturma('', this.value, '')">
                                                            <Option value="" nr_inep=""></Option>
                                                            <?php echo $escolas ?>
                                                        </select>
                                                </div>
                                            </div>
                                            
                                            <script>
                                                <?php if (set_value('nr_inep_escola')) { echo "populaescola('',$('#nr_inep_escola').val());"; } ?>
                                            </script>

                                            <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
                                                            tabindex="5"
                                                            <?php if ($fl_bloqueado == 'S'){ ?>
                                                                readonly
                                                            <?php }else{ ?>
                                                                disabled
                                                            <?php } ?>
                                                            class="form-control">

                                                        <?php echo $turmas ?>

                                                    </select>
                                                </div>
                                            </div>



                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>
                                <!-- Fim div municipio sme-->

                            <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

                                <div class="col-lg-12 form-group"> 

                                    <div class="panel panel-default">
                                       
                                        <div class="panel-heading" style="height:45px;">
                                            <div class="col-lg-11" style="text-align: left">
                                                Município da SME
                                            </div>
                                            <div class="col-lg-1" style="text-align: right">

                                                <input type="hidden" name="fl_bloqueado"  id="fl_bloqueado"  value="<?php echo $fl_bloqueado;?>">
                                                
                                                <a type="button" href="#" onclick="javascript:bloqueia_titulo();">
                                                    <?php if ($fl_bloqueado == 'S'){ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_fechado.png') ?>" alt="some text" width="25" height="20">
                                                    <?php }else{ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_aberto.png') ?>" alt="some text" width="25" height="20">
                                                    <?php } ?>
                                                </a>
                                            </div>  
                                        </div>

                                        <div class="panel-body">
                                        
                                            <div class="col-lg-6">                                                    
                                                <div class="form-group">
                                                    
                                                    <label>Estado *</label>
                                                    <input  type="text"
                                                            name="cd_estado_sme"
                                                            id="cd_estado_sme"
                                                            disabled
                                                            class="form-control"
                                                            value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Município *</label>

                                                    <input  type="text"
                                                            name="cd_cidade_sme"
                                                            id="cd_cidade_sme"
                                                            disabled
                                                            class="form-control"
                                                            value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">
                                                    
                                                </div>
                                            </div>



                                            <div class="col-lg-2">                                                    
                                                <div class="form-group">
                                                    
                                                    <label for="nr_inep_escola">Inep escola</label>
                                                    <input type="number"
                                                        name="nr_inep_escola"
                                                        id="nr_inep_escola"
                                                        tabindex="6"
                                                        maxlength="32"
                                                        placeholder="Inep escola"
                                                        autofocus
                                                        <?php if ($fl_bloqueado == 'S'){ ?>
                                                            readonly
                                                        <?php }?>
                                                        class="form-control"
                                                        value="<?php if (($msg != 'success') || ($fl_bloqueado == 'S')){
                                                                        if (set_value('nr_inep_escola')){
                                                                            echo set_value('nr_inep_escola');
                                                                        }else if ($fl_bloqueado == 'S'){
                                                                            echo $nr_inep_escola;
                                                                        }
                                                                }?> "
                                                        onblur="pesquisa_inep();">
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label  for="cd_escola">Escola *</label>
                                                    <select id="cd_escola" 
                                                            name="cd_escola" 
                                                            <?php if ($fl_bloqueado == 'S'){ ?>
                                                                readonly
                                                            <?php } ?>
                                                            tabindex="7" 
                                                            class="form-control"
                                                        onchange="add_inep();populaturma('', this.value, '');">
                                                        <Option value="" nr_inep=""></Option>
                                                        <?php echo $escolas ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
                                                            <?php if ($fl_bloqueado == 'S'){ ?>
                                                                readonly
                                                            <?php }else{ ?>
                                                                disabled
                                                            <?php } ?>
                                                            tabindex="5"
                                                            class="form-control">

                                                        <?php echo $turmas ?>

                                                    </select>
                                                </div>
                                            </div>

                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>

                            <?php }else{?> <!-- Se o usuário for Escola-->

                                <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                                <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                                <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">

                                <div class="col-lg-12 form-group"> 

                                    <div class="panel panel-default">

                                        <div class="panel-heading" style="height:45px;">
                                            <div class="col-lg-11" style="text-align: left">
                                                Enturmação
                                            </div>
                                            <div class="col-lg-1" style="text-align: right">

                                                <input type="hidden" name="fl_bloqueado"  id="fl_bloqueado"  value="<?php echo $fl_bloqueado;?>">
                                                
                                                <a type="button" href="#" onclick="javascript:bloqueia_titulo();">
                                                    <?php if ($fl_bloqueado == 'S'){ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_fechado.png') ?>" alt="some text" width="25" height="20">
                                                    <?php }else{ ?>
                                                        <img id="img_cadeado" src="<?php echo base_url('assets/images/icons/cadeado_aberto.png') ?>" alt="some text" width="25" height="20">
                                                    <?php } ?>
                                                </a>
                                            </div>  
                                        </div>

                                        <div class="panel-body">
                                        <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
                                                            tabindex="5"
                                                            <?php if ($fl_bloqueado == 'S'){ ?>
                                                                readonly
                                                            <?php }?>
                                                            class="form-control">

                                                        <?php echo $turmas ?>

                                                    </select>
                                                </div>
                                            </div>

                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>
                            <?php }?> <!-- Fim grupo Escola -->




                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Cadastrar aluno ' ?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-2">

                                    <div id="campo_imagem" style="display:none;" >
                                        <small class="text-info">
                                            <i class="fa fa-info-circle"></i> 
                                            Escolha um foto para o perfil do aluno. 
                                        </small>
                                        <input  type="file" 
                                                id="img" 
                                                name="img" 
                                                class="form-control filestyle" 
                                                data-buttonText="Adicionar imagem" 
                                                data-iconName="fa fa-file-image-o"
                                                accept="image/png, image/jpeg"
                                                tabindex="8"
                                                onchange="readURL(this,'img_preview');"
                                                value="<?php if ($msg != 'success'){
                                                        echo set_value('img');}?>"/>
                                    </div>
                                    <input type="hidden" id="hidden_img_preview" name="hidden_img_preview">
                                    <a href="#" onclick="$('#img').click();">
                                        <img  type="button"  id="img_preview" 
                                                src="
                                                    <?php 
                                                        if (set_value('hidden_img_preview')){ 
                                                            echo set_value('hidden_img_preview');
                                                        }else{ 
                                                            echo base_url("assets/img/semFoto.png");
                                                        }
                                                    ?>"
                                                class="img-thumbnail"  
                                                style="width:200px;height:200px;">
                                    </a>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-group col-lg-2">
                                        <label for="nr_inep">Inep</label>
                                        <input type="number"
                                            name="nr_inep"
                                            id="inep"
                                            tabindex="9"
                                            maxlength="32"
                                            placeholder="Inep"
                                            autofocus
                                            class="form-control inep"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_inep');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="nm_aluno">Nome *</label>
                                        <input type="text"
                                            name="nm_aluno"
                                            id="nm_aluno"
                                            tabindex="10"
                                            maxlength="150"
                                            placeholder="Nome"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_aluno');
                                                    }?>">
                                    </div>
                                    
                                    <div class="form-group col-lg-5">
                                    
                                        <label >Sexo *</label>
                                        <div class="form-control" id="sexo">
                                            <label class="radio-inline control-label" for="sexo_m">
                                                <input type="radio" name="fl_sexo" id="sexo_m" value="M" tabindex="11"
                                                    <?php if((set_value('fl_sexo') == 'M') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Masculino
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="sexo_f">
                                                <input type="radio" name="fl_sexo" id="sexo_f" value="F"  class="form-check-input" tabindex="12"
                                                    <?php if((set_value('fl_sexo') == 'F') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Feminino
                                            </label>&nbsp;&nbsp;&nbsp;

                                            <label class="radio-inline control-label" for="sexo_o">
                                                <input type="radio" name="fl_sexo" id="sexo_o" value="O"  class="form-check-input" tabindex="13"
                                                    <?php if((set_value('fl_sexo') == 'O')&& ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Outros
                                            </label>
                                        </div>
                                    </div>     
                                </div >
                                <div class="col-lg-10">

                                    <div class="form-group col-lg-6">
                                        <label for="nm_mae">Nome da mãe *</label>
                                        <input type="text"
                                            name="nm_mae"
                                            id="nm_mae"
                                            tabindex="14"
                                            maxlength="150"
                                            placeholder="Nome da mãe"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_mae');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="nm_pai">Nome do pai</label>
                                        <input type="text"
                                            name="nm_pai"
                                            id="nm_pai"
                                            tabindex="15"
                                            maxlength="150"
                                            placeholder="Nome do pai"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_pai');
                                                    }?>">
                                    </div>

                                </div>
                                <div class="col-lg-10">

                                    <div class="form-group col-lg-6">
                                        <label for="nm_responsavel">Nome do responsável</label>
                                        <input type="text"
                                            name="nm_responsavel"
                                            id="nm_responsavel"
                                            tabindex="13"
                                            maxlength="150"
                                            placeholder="Nome do responsável"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_responsavel');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone1">Telefone 1 *</label>
                                        <input type="text"
                                            name="ds_telefone1"
                                            id="telefone1"
                                            tabindex="16"
                                            maxlength="50"
                                            placeholder="Telefone 1"
                                            class="form-control telefone"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_telefone1');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone2">Telefone 2</label>
                                        <input type="text"
                                            name="ds_telefone2"
                                            id="telefone2"
                                            tabindex="17"
                                            maxlength="50"
                                            placeholder="Telefone 2"
                                            class="form-control telefone"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_telefone2');
                                                    }?>">
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-2">
                                        <label for="cd_tipodeficiencia">Deficiência</label>
                                        <select id="cd_tipodeficiencia" 
                                                name="cd_tipodeficiencia" 
                                                tabindex="5"
                                                class="form-control">

                                            <?php echo $deficiencia ?>

                                        </select>
                                        
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="ds_email">E-mail</label>
                                        <input type="text"
                                            name="ds_email"
                                            id="ds_email"
                                            tabindex="18"
                                            maxlength="100"
                                            placeholder="E-mail"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_email');
                                                    }?>">
                                        
                                    </div>
                                                
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Data de nascimento *</label>
                                            <?php

                                                $data = '';
                                                if ($msg != 'success'){
                                                    $data = set_value('txt_data');
                                                }

                                                $data1 = '';

                                                if ($data != '') {

                                                    $data = DateTime::createFromFormat('d/m/Y', $data);
                                                    $data1 = $data->format('m/d/Y');
                                                }
                                                $dados['data'] = $data1;
                                                $dados['tabindex'] = '19';

                                                $this->load->view('include/data_calendario', $dados);
                                            ?>

                                        </div>
                                    </div>
                                    
                                </div >
                                
                                
                                
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-2">
                                        <label for="nr_cep">CEP</label>
                                        <input type="text"
                                            name="nr_cep"
                                            id="nr_cep"
                                            tabindex="20"
                                            maxlength="10"
                                            placeholder="CEP"
                                            class="form-control cep"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_cep');
                                                    }?>"
                                                        >
                                    </div>
                                    <div class="col-lg-4">
                                            
                                        <div >
                                            
                                            <label>Estado *</label>
                                            <select id="cd_estado" 
                                                    name="cd_estado" 
                                                    tabindex="21"
                                                    class="form-control" 
                                                    onchange="populacidade(this.value)">

                                                <?php echo $estado ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div >
                                            <label>Município *</label>
                                            <select id="cd_cidade" 
                                                    name="cd_cidade" 
                                                    tabindex="22"                                                    
                                                    class="form-control" disabled>
                                                <option value="">Selecione o estado</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="ds_rua">Rua</label>
                                        <input type="text"
                                            name="ds_rua"
                                            id="ds_rua"
                                            tabindex="23"
                                            maxlength="50"
                                            placeholder="Rua"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_rua');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="nr_residencia">Número</label>
                                        <input type="text"
                                            name="nr_residencia"
                                            id="nr_residencia"
                                            tabindex="24"
                                            maxlength="10"
                                            placeholder="Número"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_residencia');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ds_bairro">Bairro</label>
                                        <input type="text"
                                            name="ds_bairro"
                                            id="ds_bairro"
                                            tabindex="25"
                                            maxlength="50"
                                            placeholder="Bairro"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_bairro');
                                                    }?>">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="ds_complemento">Complemento</label>
                                        <input type="text"
                                            name="ds_complemento"
                                            id="ds_complemento"
                                            tabindex="26"
                                            maxlength="50"
                                            placeholder="Complemento"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_complemento');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ds_referencia">Ponto de referência</label>
                                        <input type="text"
                                            name="ds_referencia"
                                            id="ds_referencia"
                                            tabindex="27"
                                            placeholder="Referência"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_referencia');
                                                    }?>">
                                    </div>
                                </div>                                

                                <!-- <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <1?php
                                            $this->load->view('include/gerar_lista_selecao_escola');
                                        ?>

                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="28">
                                            Cadastrar
                                        </button>
                                        <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                                            href="<?php echo base_url('aluno/alunos/novo'); ?>">Novo</a>
                                        <button type="button" 
                                                tabindex="29" 
                                                onclick="window.location.href ='<?php echo base_url('aluno/alunos/index')?>';"
                                                class="btn btn-custom waves-effect waves-light btn-micro active">
                                                Voltar
                                        </button>                                
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim div Parametros -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>
</div>

<?php
    echo form_close();
?>
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
