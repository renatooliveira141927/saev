<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/cep_endereco.js'); ?>"></script>

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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a escola já está cadastrada no banco de dados!");
    </script>

    <?php
}
    echo form_open('escola/escolas/salvar',array('ci_escola'=>'frm_escolas','method'=>'post', 'enctype'=>'multipart/form-data'));

foreach ($registros as $result) {
?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Editar cadastro de escola </h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- Div Parametros -->
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
                                            Escolha um foto para o perfil da escola. 
                                        </small>
                                        <input  type="file" 
                                                id="img" 
                                                name="img" 
                                                class="form-control filestyle" 
                                                data-buttonText="Adicionar imagem" 
                                                data-iconName="fa fa-file-image-o"
                                                accept="image/png, image/jpeg"
                                                tabindex="0"
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
                                                            echo base_url('/assets/img/escolas/'.$result->img);
                                                        }else{ 
                                                            echo base_url('assets/img/semFoto.png');
                                                        } ?>"
                                                    class="img-thumbnail"  
                                                    style="width:200px;height:200px;">
                                        </a>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-group col-lg-5">
                                        <label for="nm_escola">Nome *</label>
                                        <input type="text"
                                            name="nm_escola"
                                            id="nm_escola"
                                            tabindex="1"
                                            placeholder="Nome"
                                            class="form-control"
                                            value="<?php echo $result->nm_escola ?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="nr_inep">Inep *</label>
                                        <input type="text"
                                            name="nr_inep"
                                            id="inep"
                                            tabindex="2"
                                            placeholder="Inep"
                                            class="form-control inep"
                                            value="<?php echo $result->nr_inep ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label id="">Tipo de unidade *</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="extencao_p">
                                                <input type="radio" name="fl_extencao" id="extencao_p" value="P" tabindex="3"
                                                    <?php if($result->fl_extencao == 'P'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Polo
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="extencao_e">
                                                <input type="radio" name="fl_extencao" id="extencao_e" value="E"  class="form-check-input" tabindex="4"
                                                    <?php if($result->fl_extencao == 'E'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Extensão
                                            </label>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>     
                                </div >
                                <div class="col-lg-10">
                                    
                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone">Telefone *</label>
                                        <input type="text"
                                            name="ds_telefone"
                                            id="telefone"
                                            tabindex="6"
                                            placeholder="Telefone"
                                            class="form-control telefone"
                                            value="<?php echo $result->ds_telefone ?>">
                                    </div>  

                                    <div class="form-group col-lg-6">
                                        <label for="ds_email">E-mail *</label>
                                        <input type="text"
                                            name="ds_email"
                                            id="ds_email"
                                            tabindex="7"
                                            placeholder="E-mail"
                                            class="form-control"
                                            value="<?php echo $result->ds_email ?>">
                                        
                                    </div>

                                    <div class="col-lg-4">
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
                                                
                                    <div class="col-lg-3">
                                        <label id="">Localização da escola *</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="localizacao_u">
                                                <input type="radio" name="fl_localizacao" id="localizacao_u" value="U" tabindex="3"
                                                    <?php if($result->fl_localizacao == 'U'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Urbana
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="localizacao_r">
                                                <input type="radio" name="fl_localizacao" id="localizacao_r" value="R"  class="form-check-input" tabindex="4"
                                                    <?php if($result->fl_localizacao == 'R'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Rural
                                            </label>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div> 
                                    
                                </div >
                                
                                
                                <div class="form-group col-lg-10">

                                    <div class="col-lg-2">
                                        <label for="nr_cep">CEP</label>
                                        <input type="text"
                                            name="nr_cep"
                                            id="nr_cep"
                                            tabindex="15"
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
                                                    tabindex="16"
                                                    class="form-control" 
                                                    onchange="populacidade(this.value)">

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
                                                    tabindex="17"
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
                                            tabindex="18"
                                            placeholder="Rua"
                                            class="form-control"
                                            value="<?php echo $result->ds_rua; ?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="nr_residencia">Número</label>
                                        <input type="text"
                                            name="nr_residencia"
                                            id="nr_residencia"
                                            tabindex="19"
                                            placeholder="Número"
                                            class="form-control"
                                            value="<?php echo $result->nr_residencia; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ds_bairro">Bairro</label>
                                        <input type="text"
                                            name="ds_bairro"
                                            id="ds_bairro"
                                            tabindex="20"
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
                                            tabindex="21"
                                            placeholder="Complemento"
                                            class="form-control"
                                            value="<?php echo $result->ds_complemento; ?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ds_referencia">Ponto de referência</label>
                                        <input type="text"
                                            name="ds_referencia"
                                            id="ds_referencia"
                                            tabindex="22"
                                            placeholder="Referência"
                                            class="form-control"
                                            value="<?php echo $result->ds_referencia; ?>">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    
                                    <div  align="right">
                                        <input type="hidden" id="ci_escola" name="ci_escola" value="<?php echo $result->ci_escola?>">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="23">
                                            Atualizar
                                        </button>
                                        <button type="button" 
                                                tabindex="24"
                                                onclick="window.location.href ='<?php echo base_url('escola/escolas/index')?>';"
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
}
    echo form_close();
?>
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
<script src="<?=base_url('assets/js/mask.inep.js'); ?>"></script>