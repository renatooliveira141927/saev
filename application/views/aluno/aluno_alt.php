
<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/cep_endereco.js'); ?>"></script>
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
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('inep').toUpperCase());
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
    echo form_open('aluno/alunos/salvar',array('ci_aluno'=>'frm_alunos','method'=>'post', 'onsubmit' => 'return valida_form();', 'enctype'=>'multipart/form-data'));

foreach ($registros as $result) {
    //if(isset($result->ci_ultimaenturmacao)){ ?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >


            <div class="row page-header">
                    <div class="col-lg-12">
                        <div class="col-lg-6" >
                            <div class="span9 offset1!important" style="padding: 0 !important;margin: 0 !important;">
                                <h3>Editar cadastro de aluno </h3>
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding: 0 !important;margin: 0 !important;">
                            <div class="span9 offset1!important" style="text-align:right; vertical-align: middle;">
                                <button type="submit" 
                                        class="btn btn-custom waves-effect waves-light btn-micro active" 
                                        tabindex="26">
                                    Atualizar
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

                            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador-->
                                
                                                 
                                <div class="col-lg-12 form-group"> 

                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align:left;">
                                        Dados escola
                                        </div>
                                        <div class="panel-body">
                                        
                                            <div class="col-lg-6">                                                    
                                                <div class="form-group">
                                                    
                                                    <label>Estado *</label>
                                                    <select id="cd_estado_sme" 
                                                            name="cd_estado_sme" 
                                                            tabindex="1"
                                                            class="form-control" 
                                                            onchange="populacidade(this.value, '', '', false, $('#cd_cidade_sme'))">

                                                        <?php echo $estados_sme ?>

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
                                                            onchange="populaescola(this.value,'');">
                                                        <option value="">Selecione o estado</option>
                                                        
                                                        <?php echo $municipios_sme ?>

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
                                                        placeholder="Inep escola"
                                                        class="form-control"
                                                        maxlength="32"
                                                        value="<?php echo $result->nr_inep_escola ?>"
                                                        onchange="pesquisa_inep();">
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label for="cd_escola">Escola</label>
                                                    <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                                                        onblur="add_inep();populaturma('', this.value, '');">
                                                        <Option value="" nr_inep=""></Option>
                                                        <?php
                                                            foreach ($escolas as $item) {
                                                                ?>
                                                                <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                                                    <?php if ($result->cd_escola == $item->ci_escola){
                                                                        echo 'selected';
                                                                    } ?> >
                                                                    <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                                                </Option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>                                     

                                            <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
                                                            tabindex="5"
                                                            class="form-control">

                                                        <?php echo $turmas ?>

                                                    </select>
                                                </div>
                                            </div>


                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>

                            <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

                                <div class="col-lg-12 form-group"> 

                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align:center;">
                                        Município da SME
                                        </div>
                                        <div class="panel-body">
                                        
                                            <div class="col-lg-6">                                                    
                                                <div class="form-group">
                                                    
                                                    <label>Estado *</label>
                                                    <input  type="text"
                                                            disabled
                                                            class="form-control"
                                                            value="<?php echo $result->nm_estado_sme ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Município *</label>

                                                    <input  type="text"
                                                            disabled
                                                            class="form-control"
                                                            value="<?php echo $result->nm_estado_sme ?>">
                                                    
                                                </div>
                                            </div>


                                            <div class="col-lg-2">                                                    
                                                <div class="form-group">
                                                    <label for="nr_inep_escola">Inep escola</label>
                                                    <input type="number"
                                                        name="nr_inep_escola"
                                                        id="nr_inep_escola"
                                                        tabindex="3"
                                                        placeholder="Inep escola"
                                                        class="form-control"
                                                        value="<?php echo $result->nr_inep_escola ?>"
                                                        onblur="pesquisa_inep();">
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label for="cd_escola">Escola</label>
                                                    <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                                                        onchange="add_inep();populaturma('', this.value, '');">
                                                        <Option value="" nr_inep=""></Option>
                                                        <?php
                                                            foreach ($escolas as $item) {
                                                                ?>
                                                                <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                                                    <?php if ($result->cd_escola == $item->ci_escola){
                                                                        echo 'selected';
                                                                    } ?> >
                                                                    <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                                                </Option>

                                                        <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
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
                                        <div class="panel-heading" style="text-align:center;">
                                        Enturmação
                                        </div>
                                        <div class="panel-body">
                                        <div class="form-group">
                                                <div class="col-lg-12"> 
                                                    <label>Turma</label>
                                                    <select id="cd_turma" 
                                                            name="cd_turma" 
                                                            tabindex="5"
                                                            class="form-control">

                                                        <?php echo $turmas ?>

                                                    </select>
                                                </div>
                                            </div>

                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>
                            <?php }?> <!-- Fim grupo SME ou escola -->

                            
                                

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Alterar cadastro ' ?>

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
                                                tabindex="5"
                                                onchange="readURL(this,'img_preview');"
                                                value="<?php if ($msg != 'success'){
                                                        echo set_value('img');}?>"/>
                                    </div>
                                    <input  type="hidden" 
                                                name="ds_img_hidden" 
                                                value="<?php echo $result->img ?>">  

                                        <a href="#" onclick="$('#img').click();">
                                            <img  type="button"  id="img_preview" 
                                                    src="
                                                        <?php if ($result->img) {
                                                            echo base_url('/assets/img/alunos/'.$result->img);
                                                        }else{ 
                                                            echo base_url('assets/img/semFoto.png');
                                                        } ?>"
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
                                            tabindex="6"
                                            placeholder="Inep"
                                            maxlength="32"
                                            class="form-control"
                                            value="<?php echo $result->nr_inep ?>">
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="nm_aluno">Nome *</label>
                                        <input type="text"
                                            name="nm_aluno"
                                            id="nm_aluno"
                                            tabindex="7"
                                            placeholder="Nome"
                                            maxlength="150"
                                            class="form-control"
                                            value="<?php echo $result->nm_aluno ?>">
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <div class="container">
                                            <label id="">Sexo *</label>
                                        </div>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="sexo_m">
                                                <input type="radio" name="fl_sexo" id="sexo_m" value="M" tabindex="8"
                                                    <?php if($result->fl_sexo == 'M'){  echo 'checked'; } ?>>Masculino</label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="sexo_f">
                                                <input type="radio" name="fl_sexo" id="sexo_f" value="F"  class="form-check-input" tabindex="9"
                                                    <?php if($result->fl_sexo == 'F'){  echo 'checked'; } ?>>Feminino</label>&nbsp;&nbsp;&nbsp;

                                            <label class="radio-inline control-label" for="sexo_o">
                                                <input type="radio" name="fl_sexo" id="sexo_o" value="O"  class="form-check-input" tabindex="10"
                                                    <?php if($result->fl_sexo == 'O'){  echo 'checked'; } ?>>Outros</label>
                                        </div>
                                    </div>     
                                </div >
                                <div class="col-lg-10">
                                    <div class="form-group col-lg-6">
                                        <label for="nm_mae">Nome da mãe *</label>
                                        <input type="text"
                                            name="nm_mae"
                                            id="nm_mae"
                                            tabindex="11"
                                            maxlength="150"
                                            placeholder="Nome da mãe"
                                            class="form-control"
                                            value="<?php echo $result->nm_mae; ?>">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="nm_pai">Nome do pai</label>
                                        <input type="text"
                                            name="nm_pai"
                                            id="nm_pai"
                                            tabindex="12"
                                            maxlength="150"
                                            placeholder="Nome do pai"
                                            class="form-control"
                                            value="<?php echo $result->nm_pai; ?>">
                                    </div>
                                </div >
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
                                            value="<?php echo $result->nm_responsavel; ?>">
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone1">Telefone 1 *</label>
                                        <input type="text"
                                            name="ds_telefone1"
                                            id="telefone"
                                            tabindex="14"
                                            maxlength="50"
                                            placeholder="Telefone 1"
                                            class="form-control telefone"
                                            value="<?php echo $result->ds_telefone1 ?>">
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone2">Telefone 2</label>
                                        <input type="text"
                                            name="ds_telefone2"
                                            id="telefone2"
                                            tabindex="15"
                                            maxlength="50"
                                            placeholder="Telefone 2"
                                            class="form-control telefone"
                                            value="<?php echo $result->ds_telefone1 ?>">
                                    </div> 

                                </div >
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
                                            tabindex="16"
                                            maxlength="100"
                                            placeholder="E-mail"
                                            class="form-control"
                                            value="<?php echo $result->ds_email ?>">
                                        
                                    </div>
                                                
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Data de nascimento *</label>
                                            <?php
                                                $dados['tabindex'] = '17';
                                                $dados['data'] = $result->dt_nascimento;
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
                                            tabindex="18"
                                            maxlength="10"
                                            placeholder="CEP"
                                            class="form-control cep"
                                            value="<?php echo $result->nr_cep; ?>">
                                    </div>

                                    <div class="col-lg-4 form-group">
                                        
                                        <div >
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                            <label>Estado *</label>
                                            <select id="cd_estado" 
                                                    name="cd_estado" 
                                                    tabindex="19"
                                                    class="form-control" 
                                                    onchange="populacidade(this)">

                                                <?php foreach ($estados as $estado) { ?>
                                                    <option value="<?php echo $estado->ci_estado?>"
                                                        <?php
                                                        if($estado->ci_estado == $result->cd_estado) {
                                                            echo " selected ";
                                                        }
                                                        ?>
                                                    >
                                                        <?php echo $estado->nm_estado?>
                                                    </option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 form-group">
                                        <div >
                                            <label>Município *</label>
                                            <select id="cd_cidade" 
                                                    name="cd_cidade" 
                                                    tabindex="20"
                                                    class="form-control">

                                                <?php foreach ($municipios as $municipio) { ?>
                                                    <option value="<?php echo $municipio->ci_cidade?>"
                                                        <?php
                                                            if($municipio->ci_cidade == $result->cd_cidade) {
                                                                echo " selected ";
                                                        }
                                                        ?>
                                                    >
                                                        <?php echo $municipio->nm_cidade?>
                                                    </option>
                                                <?php } ?>
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
                                            tabindex="21"
                                            maxlength="50"
                                            placeholder="Rua"
                                            class="form-control"
                                            value="<?php echo $result->ds_rua; ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="nr_residencia">Número</label>
                                        <input type="text"
                                            name="nr_residencia"
                                            id="nr_residencia"
                                            tabindex="22"
                                            maxlength="10"
                                            placeholder="Número"
                                            class="form-control"
                                            value="<?php echo $result->nr_residencia; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ds_bairro">Bairro</label>
                                        <input type="text"
                                            name="ds_bairro"
                                            id="ds_bairro"
                                            tabindex="23"
                                            maxlength="50"
                                            placeholder="Bairro"
                                            class="form-control"
                                            value="<?php echo $result->ds_bairro; ?>">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="ds_complemento">Complemento</label>
                                        <input type="text"
                                            name="ds_complemento"
                                            id="ds_complemento"
                                            tabindex="24"
                                            maxlength="50"
                                            placeholder="Complemento"
                                            class="form-control"
                                            value="<?php echo $result->ds_complemento; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ds_referencia">Ponto de referência</label>
                                        <input type="text"
                                            name="ds_referencia"
                                            id="ds_referencia"
                                            tabindex="25"
                                            maxlength="50"
                                            placeholder="Referência"
                                            class="form-control"
                                            value="<?php echo $result->ds_referencia; ?>">
                                    </div>
                                </div>                                

                                <div class="col-lg-12">
                                    <div class="col-lg-6" >
                                        <div class="span9 offset1!important">  
                                            <b>
                                            Cadastrado por: <?php echo $result->nm_usuario_cad; ?> em  <?php echo ($result->dt_cadastro!=''?date('d/m/Y H:i:s',  strtotime($result->dt_cadastro)):''); ?><br>
                                            <?php if ($result->nm_usuario_alt){ ?>
                                            Alterado por: <?php echo $result->nm_usuario_alt; ?> em  <?php echo ($result->dt_alteracao!=''?date('d/m/Y H:i:s',  strtotime($result->dt_alteracao)):''); ?><br>
                                            <?php }
                                                  if ($result->nm_usuario_del){ ?>
                                            Excluído por: <?php echo $result->nm_usuario_del; ?> em  <?php echo ($result->dt_exclusao!=''?date('d/m/Y H:i:s',  strtotime($result->dt_exclusao)):''); ?><br>
                                            <?php } ?>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div style="text-align:right">
                                            <input type="hidden" id="ci_aluno" name="ci_aluno" value="<?php echo $result->ci_aluno?>">
                                            <input type="hidden" id="ci_ultimaenturmacao" name="ci_ultimaenturmacao" value="<?php echo $result->ci_ultimaenturmacao?>">
                                            <button type="submit" 
                                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                    tabindex="26">
                                                Atualizar
                                            </button>
                                            <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                                                href="<?php echo base_url('aluno/alunos/novo'); ?>">Novo</a>
                                            <button type="button" 
                                                    tabindex="27"
                                                    onclick="window.location.href ='<?php echo base_url('aluno/alunos/index')?>';"
                                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                                    Voltar
                                            </button>
                                        </div>
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
    //} 
    }
    echo form_close();
?>
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
<script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>