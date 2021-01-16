<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/cep_endereco.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o usuário já está cadastrado no banco de dados!");
    </script>

    <?php
}
    echo form_open('usuario/usuarios/salvar',array('ci_usuario'=>'frm_usuarios','method'=>'post', 'enctype'=>'multipart/form-data', 'onsubmit'=>'javascript:seleciona_todos_itens($(\'#cd_escolas_selecionadas\')); '));

foreach ($registros as $result) {
?>
<script>
    function habilitamenu(combo){
        //alert(combo.val());

        if(combo.val() == 1){
            $('#menu_escola').hide();
            $('#dv_gruposme').hide();

        }else if(combo.val() == 2){
            $('#menu_escola').hide();
            $('#dv_gruposme').show();

        }else if(combo.val() == 3){
            $('#menu_escola').show();
            $('#dv_gruposme').hide();
        }

        // if (combo.find(':selected').attr('tp_administrador').toUpperCase() == 'S'){
            
        //     $('#menu_escola').hide();

        // }else if (combo.find(':selected').attr('tp_administrador').toUpperCase() == 'N'){

        //     $('#menu_escola').show();
        // }

    }
    
</script>
<div class="container"><!-- #container -->
    <div  class="card-group"><!-- #card-group -->
        <div id="page-wrapper" ><!-- #page-wrapper -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><?php echo $titulo ?></h3>
                </div>
            </div>

            <div class="row"><!-- #row - Inicio div linha conteúdo página -->
                <ul class="nav nav-tabs"><!-- Inicio menu cabecalho --> 
                    <li class="active">
                        <a href="#geral" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="fa fa-geral"></i></span>
                            <span class="hidden-xs">Geral</span>
                        </a>
                    </li>
                    <li class="" id="menu_escola" <?php if ($result->cd_grupo != '3'){ echo 'style="display:none"'; } ?>>
                        <a href="#escolas" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="fa fa-escola"></i></span>
                            <span class="hidden-xs">Escolas </span>
                        </a>
                    </li>
                </ul><!-- Fim menu cabecalho  -->
                    
                <div class="tab-content"><!-- Inicio div contendo divs avaliações, municipios e escolas -->
                        
                    <div class="tab-pane active" id="geral"> <!-- Inicio div menu geral-->
                        
                            <!-- Inicio div municipio sme -->                        
                            <div class="col-lg-12 form-group" id="dv_gruposme" <?php if ($result->cd_grupo != '2'){ echo 'style="display:none"'; } ?>> 


                            <div class="panel panel-default">
                                <div class="panel-heading" style="text-align:center;">
                                Município da SME
                                </div>
                                <div class="panel-body">
                                
                                    <div class="col-lg-6">                                                    
                                        <div >
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                            <label>Estado *</label>
                                            <select id="cd_estado_sme" 
                                                    name="cd_estado_sme" 
                                                    tabindex="16"
                                                    class="form-control" 
                                                    onchange="populacidade(this.value, '', '', true, $('#cd_cidade_sme'))">

                                                <?php echo $estados_sme ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div>
                                            <label>Município *</label>
                                            <select id="cd_cidade_sme" 
                                                    name="cd_cidade_sme" 
                                                    tabindex="17"                                                    
                                                    class="form-control">
                                                <option value="">Selecione o estado</option>
                                                <?php echo $municipios_sme ?>
                                            </select>
                                        </div>
                                    </div>

                                </div><!-- fim .panel-body -->
                            </div><!-- fim .panel panel-default -->   


                            </div>
                            <!-- Fim div municipio sme-->
                        <div class="col-lg-12"> <!-- Div inicio conteúdo menu geral -->
                            <div class="panel panel-default">
                                <div class="panel-heading">

                                Informações do usuário

                                </div>
                                <div class="panel-body">

                                    <div class="col-lg-2">
                                        <div class="col-md-12" >

                                            <div id="campo_imagem" style="display:none;" >
                                                <small class="text-info">
                                                    <i class="fa fa-info-circle"></i> 
                                                    Escolha um foto para o perfil do usuário. 
                                                </small>
                                                <input  type="file" 
                                                        id="img" 
                                                        name="img" 
                                                        class="form-control filestyle" 
                                                        data-buttonText="Adicionar imagem" 
                                                        data-iconName="fa fa-file-image-o"
                                                        accept="image/png, image/jpeg"
                                                        tabindex="11"
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
                                                                echo base_url('/assets/img/usuarios/'.$result->img);
                                                            }else{ 
                                                                echo base_url('assets/img/semFoto.png');
                                                            } ?>"
                                                        class="img-thumbnail"  
                                                        style="width:200px;height:200px;">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group col-lg-6">
                                            <label for="nm_usuario">Nome</label>
                                            <input type="text"
                                                name="nm_usuario"
                                                id="nm_usuario"
                                                tabindex="2"
                                                maxlength="150"
                                                placeholder="Nome"
                                                class="form-control"
                                                value="<?php echo $result->nm_usuario; ?>">
                                        </div>

                                        <div class="form-group col-lg-4">
                                            <div class="">
                                                <label id="">Sexo</label>
                                            </div>
                                            <div class="form-control">
                                                <input type="radio" name="rd_fl_sexo" id="sexo_m" value="M" tabindex="1"
                                                    <?php if($result->fl_sexo == 'M'){
                                                        echo 'checked'; }
                                                        ?>>
                                                <label class="form-check-label" for="sexo_m">Masculino &nbsp;&nbsp;&nbsp;</label>

                                                <input type="radio" name="rd_fl_sexo" id="sexo_f" value="F"  class="form-check-input" tabindex="2"
                                                    <?php if($result->fl_sexo == 'F'){
                                                        echo 'checked'; }
                                                        ?>>
                                                <label class="form-check-label" for="sexo_f">Feminino &nbsp;&nbsp;&nbsp;</label>

                                                <input type="radio" name="rd_fl_sexo" id="sexo_o" value="O"  class="form-check-input" tabindex="3"
                                                    <?php if($result->fl_sexo == 'O'){
                                                        echo 'checked'; }
                                                        ?>>
                                                <label class="form-check-label" for="sexo_o">Outros</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <div class="">
                                                <label id="">Reenviar e-mail</label>
                                            </div>
                                            <div class="form-control">

                                                <input type="radio" name="rd_reenviar_email" id="rd_reenviar_email_s" value="S" tabindex="1">
                                                <label class="form-check-label" for="rd_reenviar_email_s">Sim &nbsp;&nbsp;&nbsp;</label>

                                                <input type="radio" name="rd_reenviar_email" id="rd_reenviar_email_n" value="N" checked class="form-check-input" tabindex="2">
                                                <label class="form-check-label" for="rd_reenviar_email_n">Não</label>
                                                
                                            </div>
                                        </div>       
                                    </div >

                                    <div class="col-lg-10">
                                        <div class="form-group col-lg-4">
                                            <label for="nr_cpf">CPF:</label>
                                            <input type="text"
                                                name="nr_cpf"
                                                id="cpf"
                                                maxlength="14"
                                                tabindex="2"
                                                placeholder="CPF"
                                                class="form-control cpf"
                                                value="<?php echo $result->nr_cpf;?>">
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="ds_email">E-mail</label>
                                            <input type="text"
                                                name="ds_email"
                                                id="ds_email"
                                                maxlength="70"
                                                tabindex="2"
                                                placeholder="E-mail"
                                                class="form-control"
                                                value="<?php echo $result->ds_email;?>">
                                            
                                        </div>
                                                    
                                        <div class="form-group col-lg-4">
                                            <label for="ds_telefone">Telefone</label>
                                            <input type="text"
                                                name="ds_telefone"
                                                id="telefone"
                                                tabindex="2"
                                                maxlength="20"
                                                placeholder="Telefone"
                                                class="form-control telefone"
                                                value="<?php echo $result->ds_telefone;?>">
                                        </div>  
                                    </div >


                                    <div class="col-lg-10">
                                        <div class="form-group col-lg-4">
                                            <label for="nm_login">Usuário</label>
                                            <input type="text"
                                                name="nm_login"
                                                id="nm_login"
                                                tabindex="2"
                                                maxlength="20"
                                                placeholder="Usuário"
                                                class="form-control"
                                                value="<?php echo $result->nm_login;?>">
                                        </div>
                                        <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados -->
                                            <div class="form-group col-lg-8">
                                                <label for="cd_grupo">Grupo</label>
                                                <select id="cd_grupo" name="cd_grupo" tabindex="1" class="form-control" onchange="habilitamenu($(this));">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($grupos as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_grupousuario; ?>" tp_administrador="<?php echo $item->tp_administrador; ?>"
                                                            <?php if ($result->cd_grupo == $item->ci_grupousuario){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_grupo; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php }else{ ?>
                                            <input type="hidden" name="cd_grupo" id="cd_grupo" value="3">
                                        <?php } ?>
                                    </div > 

                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-2">
                                            <label for="nr_cep">CEP</label>
                                            <input type="text"
                                                name="nr_cep"
                                                id="nr_cep"
                                                maxlength="10"
                                                tabindex="15"
                                                placeholder="CEP"
                                                class="form-control cep"
                                                value="<?php echo $result->nr_cep ?>">
                                        </div>
                                        <div class="col-lg-4">
                                                
                                            <div >
                                                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                                <label>Estado *</label>
                                                <select id="cd_estado" 
                                                        name="cd_estado" 
                                                        tabindex="16"
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
                                                        tabindex="17"                                                    
                                                        class="form-control" >
                                                    <option value="">Selecione o estado</option>
                                                    <?php echo $municipios ?>
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
                                                tabindex="18"
                                                maxlength="50"
                                                placeholder="Rua"
                                                class="form-control"
                                                value="<?php echo $result->ds_rua?>">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="nr_residencia">Número</label>
                                            <input type="text"
                                                name="nr_residencia"
                                                id="nr_residencia"
                                                tabindex="19"
                                                maxlength="10"
                                                placeholder="Número"
                                                class="form-control"
                                                value="<?php echo $result->nr_residencia?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="ds_bairro">Bairro</label>
                                            <input type="text"
                                                name="ds_bairro"
                                                id="ds_bairro"
                                                tabindex="20"
                                                maxlength="50"
                                                placeholder="Bairro"
                                                class="form-control"
                                                value="<?php echo $result->ds_bairro?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="ds_complemento">Complemento</label>
                                            <input type="text"
                                                name="ds_complemento"
                                                id="ds_complemento"
                                                tabindex="21"
                                                maxlength="50"
                                                placeholder="Complemento"
                                                class="form-control"
                                                value="<?php echo $result->ds_complemento?>">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="ds_referencia">Ponto de referência</label>
                                            <input type="text"
                                                name="ds_referencia"
                                                id="ds_referencia"
                                                tabindex="22"
                                                maxlength="50"
                                                placeholder="Referência"
                                                class="form-control"
                                                value="<?php echo $result->ds_referencia?>">
                                        </div>
                                    </div>



                                </div>
                            </div>                                                       

                        </div><!-- Div fim conteúdo menu geral -->

                        
                    </div><!-- Fim div menu geral -->

                    <div class="tab-pane" id="escolas"><!-- Inicio div menu escolas --> 
                        
                        <div class="col-lg-12"><!-- Inicio div conteúdo escolas -->
                        
                        <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados abrir menu grupo SME-->
                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">
                                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                    <label>Estados </label>
                                    <select id="cd_estado_menu_esc" 
                                            name="cd_estado_menu_esc" 
                                            tabindex="14"
                                            class="form-control" 
                                            onchange="populacidade(this.value, '', '', false, $('#cd_cidade_menu_esc'), $('#cd_escolas_selecionadas'));">

                                        <?php echo $estados_sme ?>

                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <div  class="form-group">
                                        <label>Municípios </label>
                                        <select id="cd_cidade_menu_esc" 
                                                name="cd_cidade_menu_esc" 
                                                tabindex="15"      
                                                disabled                                
                                                onchange="populaescola(this.value,'', '', $('#cd_escolas_selecionadas'));"                                                
                                                class="form-control" >

                                                <?php echo $municipios_sme ?>

                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        <?php }else{?> <!-- Fim Se o usuário for administrados abrir menu grupo SME e inicio se for outro grupo-->

                            <div class="col-lg-12">
                                <div class="form-group col-lg-6">  
                                    <label>Estados </label>                                      
                                    <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                                </div>
                                <div class="col-lg-6">
                                    <div  class="form-group">
                                        <label>Municípios </label>
                                        <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                                    </div>
                                </div>
                                
                            </div>                               
                            

                        <?php }?> <!-- Fim grupo SME ou escola -->                        
                            <div class="col-lg-6">
                                <div  class="form-group">
                                    <label>Escolas </label>
                                    <!--  
                                    <select multiple id="cd_escola" 
                                            name="cd_escola" 
                                            tabindex="15"
                                            style="width:100%;height:300px;"                                       
                                            ondblclick="adicionar( $(this) , $('#cd_escolas_selecionadas'), $('#cd_cidade_menu_esc option:selected').text());"
                                            class="form-control" >
                                    </select>
                                    -->
                                    <select multiple id="cd_escola" 
                                            name="cd_escola" 
                                            tabindex="15"
                                            style="width:100%;height:300px;"                                       
                                            ondblclick="adicionar( $(this) , $('#cd_escolas_selecionadas'));"
                                            class="form-control" >
                                            <?php
                                                foreach ($escolas_municipio as $item) {
                                                    ?>
                                                    <Option value="<?php echo $item->ci_escola; ?>" selected>
                                                        <?php echo  $item->nr_inep .' - '. $item->nm_escola; ?>
                                                    </Option>

                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div  class="form-group">
                                    <label>Escolas com permissão </label>
                                    <select class="form-control" 
                                            id="cd_escolas_selecionadas" 
                                            name="cd_escolas_selecionadas[]" 
                                            ondblclick="remover( $(this) , $('#cd_escola') );"
                                            multiple 
                                            style="width:100%;height:300px;">
                                            <?php
                                                foreach ($usuarioescolas as $item) {
                                                    ?>
                                                    <Option value="<?php echo $item->cd_escola; ?>" selected>
                                                        <?php echo  $item->nr_inep .' - '. $item->nm_escola; ?>
                                                    </Option>

                                            <?php } ?>
                                    </select>
                                    <!--
                                    <a  type="button" 
                                        class="btn btn-success waves-effect waves-light btn-micro active"
                                        onclick="adicionar( $('#cd_escola') , $('#cd_escolas_selecionadas'), $('#cd_cidade_menu_esc option:selected').text());">Adicionar item
                                    </a>
                                    -->
                                                                        
                                    <a  type="button" 
                                        class="btn btn-success waves-effect waves-light btn-micro active"
                                        onclick="adicionar( $('#cd_escola') , $('#cd_escolas_selecionadas'));">Adicionar item
                                    </a>
                                    <a  type="button"
                                        class="btn btn-danger waves-effect waves-light btn-micro active"
                                        onclick="remover( $('#cd_escolas_selecionadas') , $('#cd_escola') );">Remover item
                                    </a>
                                    <a  type="button"
                                        class="btn btn-danger waves-effect waves-light btn-micro active"
                                        onclick="removeAll( $('#cd_escolas_selecionadas') , $('#cd_escola') );">Remover todos
                                        
                                    </a>
                                </div>
                            </div>
                        </div>  <!-- Fim div conteúdo escolas -->
                    </div><!-- Fim div menu escolas -->

                </div><!-- Fim div contendo divs avaliações, municipios e escolas -->
                <div class="col-lg-12">           
                    <div align="right">
                        <input type="hidden" id="ci_usuario" name="ci_usuario" value="<?php echo $result->ci_usuario?>">        

                        <button type="submit" 
                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                tabindex="24">
                            Atualizar
                        </button>
                        <button type="button" 
                                tabindex="25"
                                onclick="window.location.href ='<?php echo base_url('usuario/usuarios/index')?>';"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                                Voltar
                        </button>
                    </div>       
                
                </div>
            </div><!-- #row - Fim div linha conteúdo página -->
        </div><!-- #page-wrapper Fim -->
    </div><!-- #card-group Fim -->
</div><!-- #container Fim -->
<?php
}
    echo form_close();
?>
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
<script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>