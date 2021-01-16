
<link href="<?=base_url('assets/css/cad_itens_avaliacoes.css'); ?>" rel="stylesheet" type="text/css" />

<script src="<?=base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/tipo_alternativas_questoes.js'); ?>"></script>


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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o nome da questão já está cadastrado no banco de dados!");
    </script>

    <?php
}
    echo form_open('avalia_item/avalia_itens/salvar',array('id'=>'frm_avalia_items','method'=>'post', 'enctype'=>'multipart/form-data'))
?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header"><?php echo 'Administrar '.$titulo ?></h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- Div Parametros -->
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Parametos ' ?>

                            </div>
                            <div class="panel-body">
                            <div > 
                                <div class="form-group">
                                    <label for="ds_codigo">Código do item</label>
                                    <input id="ds_codigo"
                                                    name="ds_codigo"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="1"
                                                    maxlength   ="10"
                                                    placeholder="Código do item"
                                                    style="text-transform: uppercase;"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_codigo');
                                        }?>">
                                </div>
                                <div class="form-group">
                                    <label for="cd_dificuldade">Dificuldade</label>
                                    <select id="cd_dificuldade" name="cd_dificuldade" tabindex="2" class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($avalia_dificuldades as $item) {
                                                ?>
                                                <Option value="<?php echo $item->ci_avalia_dificuldade; ?>"
                                                    <?php if ((set_value('cd_dificuldade') == $item->ci_avalia_dificuldade) && ($msg != 'success')){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_avalia_dificuldade; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="cd_disciplina">Disciplina</label>
                                    <select id="cd_disciplina" name="cd_disciplina" tabindex="3" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($disciplinas as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_disciplina; ?>"
                                                <?php if ((set_value('cd_disciplina') == $item->ci_disciplina) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_disciplina; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cd_etapa">Etapa</label>
                                    <select id="cd_etapa" name="cd_etapa" tabindex="4" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($etapas as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_etapa; ?>"
                                                <?php if ((set_value('cd_etapa') == $item->ci_etapa) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_etapa; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cd_avalia_conteudo">Conteúdo</label>
                                    <select id="cd_avalia_conteudo" name="cd_avalia_conteudo" tabindex="5" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($avalia_conteudos as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_avalia_conteudo; ?>"
                                                <?php if ((set_value('cd_avalia_conteudo') == $item->ci_avalia_conteudo) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_avalia_conteudo; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>   
                                <div class="form-group">
                                    <label for="cd_avalia_subconteudo">Sub conteúdo</label>
                                    <select id="cd_avalia_subconteudo" name="cd_avalia_subconteudo" tabindex="6" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($avalia_subconteudos as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_avalia_subconteudo; ?>"
                                                <?php if ((set_value('cd_avalia_subconteudo') == $item->ci_avalia_subconteudo) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_avalia_subconteudo; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cd_avalia_origem">Origem</label>
                                    <select id="cd_avalia_origem" name="cd_avalia_origem" tabindex="7" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($avalia_origens as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_avalia_origem; ?>"
                                                <?php if ((set_value('cd_avalia_origem') == $item->ci_avalia_origem) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_avalia_origem; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>                                                                                                       
                                <div class="form-group">
                                    <label for="cd_edicao">Edicao</label>
                                    <select id="cd_edicao" name="cd_edicao" tabindex="8" class="form-control">
                                        <Option value=""></Option>
                                        <?php
                                        foreach ($edicoes as $item) {
                                            ?>
                                            <Option value="<?php echo $item->ci_edicao; ?>"
                                                <?php if ((set_value('cd_edicao') == $item->ci_edicao) && ($msg != 'success')){
                                                    echo 'selected';
                                                } ?> >
                                                <?php echo $item->nm_edicao; ?>
                                            </Option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim div Parametros -->

                    <!-- Div corpo -->
                    <div class="col-lg-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo $titulo ?>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                <div class="form-group">
                                        <label for="ds_titulo">Titulo  </label>
                                        <input id="ds_titulo"
                                                    name="ds_titulo"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="9"
                                                    placeholder="Digite um titulo"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_titulo');
                                        }?>">                                                     
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="ds_enunciado">Enunciado</label>

                                        <textarea   id="ds_enunciado"
                                                    name="ds_enunciado" 
                                                    tabindex="10"
                                                    placeholder="Digite o enunciado da questão">
                                            <?php if ($msg != 'success'){
                                                        echo set_value('ds_enunciado');
                                            }?>
                                        </textarea>    
                                                                                          
                                    </div>
                                    <div class="form-group">
                                        <label for="ds_texto_suporte">Texto de suporte</label>

                                        <textarea   id="ds_texto_suporte"
                                                    name="ds_texto_suporte" 
                                                    tabindex="10"
                                                    placeholder="Digite o texto">
                                            <?php if ($msg != 'success'){
                                                        echo set_value('ds_texto_suporte');
                                            }?>
                                        </textarea>   
                                        <input  type="text" 
                                                        class="form-control" 
                                                        name="ds_fonte_texto" 
                                                        placeholder="Referência bibliográfica do texto." 
                                                        tabindex="12"
                                                        value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_fonte_texto');
                                                            }?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group " id="campo_imagem">
                                                <small class="text-info">
                                                    <i class="fa fa-info-circle"></i> 
                                                    As imagens inseridas são de responsabilidade do autor do item. 
                                                </small>
                                                <input  type="file" 
                                                        id="img_suporte" 
                                                        name="ds_img_suporte" 
                                                        class="form-control filestyle" 
                                                        data-buttonText="Adicionar imagem" 
                                                        data-iconName="fa fa-file-image-o"
                                                        accept="image/png, image/jpeg"
                                                        tabindex="11"
                                                        onchange="readURL(this,'img_suporte_preview');"
                                                        value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_img_suporte');}?>"/>
                                                        
                                                <input  type="text" 
                                                        class="form-control" 
                                                        name="ds_fonte_imagem" 
                                                        placeholder="Referência bibliográfica da imagem." 
                                                        tabindex="12"
                                                        value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_fonte_imagem');
                                                            }?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img    id="img_suporte_preview" 
                                                    class="img-thumbnail" 
                                                    width="200" 
                                                    height="200" 
                                                    style="display:none"
                                                    src="
                                            <?php if ($msg != 'success'){
                                                        echo set_value('ds_img_suporte');
                                            }?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ds_comando">Comando</label>

                                        <textarea   id="ds_comando"
                                                    name="ds_comando" 
                                                    placeholder="Digite uma pequena explicação sobre a questão"
                                                    rows="4" 
                                                    tabindex="13"
                                                    cols="80">
                                            <?php if ($msg != 'success'){
                                                        echo set_value('ds_comando');
                                            }?>
                                        </textarea>                                                        
                                    </div>

                                    <div class="form-group">
                                        <label>Tipo de alternativas:</label>
                                        <div class="form-control">                                            
                                            <input  type="radio" 
                                                    name="fl_tipo_itens" 
                                                    id="fl_tp_texto" 
                                                    value="T" 
                                                    tabindex="14"
                                                    onclick="javascript:ocultarAlternativas(this);"
                                                    <?php 
                                                        if((set_value('fl_tipo_itens') != 'I')){
                                                            echo 'checked'; 
                                                        }
                                                    ?>> 
                                            <label for="fl_tp_texto">Texto</label>                                            
                                            <input  type="radio" 
                                                    name="fl_tipo_itens" 
                                                    id="fl_tp_imagem" 
                                                    value="I" 
                                                    tabindex="15"
                                                    onclick="javascript:ocultarAlternativas(this);"
                                                    <?php 
                                                        if((set_value('fl_tipo_itens') == 'I') && ($msg != 'success')){
                                                            echo 'checked';
                                                        }?>>
                                                     
                                            <label for="fl_tp_imagem">Imagem</label>
                                         </div>
                                    </div>
                                     <div class="form-group" >  <!-- DIV Alternativa 01 -->

                                        <label for="ds_primeiro_item">Alternativa 01</label>
                                        <div class="input-group itens_questoes">
                                            <span class="input-group-addon">
                                                <input  type="radio"
                                                        name="nr_alternativa_correta" 
                                                        id="nr_alternativa_correta_1" 
                                                        value="1" 
                                                        tabindex="16"
                                                    <?php if((set_value('nr_alternativa_correta') == '1') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                    ?>>
                                            </span>
                                            <div>                                                
                                                <div id="div_ds_primeiro_item_img" style="display:none;">
                                                    <div class="col-md-9">
                                                        <div class="form-group " id="campo_imagem">
                                                            <input  type="file" 
                                                                    id="img_suporte" 
                                                                    name="ds_img_item_01" 
                                                                    class="form-control filestyle file_itens_questoes" 
                                                                    data-buttonText="Adicionar imagem" 
                                                                    data-iconName="fa fa-file-image-o"
                                                                    accept="image/png, image/jpeg"
                                                                    tabindex="17"
                                                                    onchange="readURL(this,'ds_img_item_01_preview');"
                                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_img_item_01');}?>"/>                                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img    id="ds_img_item_01_preview" 
                                                                    class="img-thumbnail" 
                                                                    width="200" 
                                                                    height="200" 
                                                                    style="display:none"
                                                                    src="
                                                            <?php if ($msg != 'success'){
                                                                        echo set_value('ds_img_item_01');
                                                            }?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div_ds_primeiro_item_texto">
                                                    <textarea   id="ds_primeiro_item"
                                                                tabindex="18"
                                                                name="ds_primeiro_item"
                                                                ><?php if ($msg != 'success'){
                                                                echo set_value('ds_primeiro_item');
                                                    }?></textarea> 
                                                </div>
                                            </div>
                                        </div>
                                        <input id="ds_justificativa_01"
                                                    name="ds_justificativa_01"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="19"
                                                    placeholder="Digite uma justificativa"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_justificativa_01');
                                        }?>">         
                                        
                                        
                                    </div> <!-- Fim DIV Alternativa 01 -->
                                    <div class="form-group">
                                        <label for="ds_segundo_item">Alternativa 02</label>
                                        <div class="input-group itens_questoes">
                                            <span class="input-group-addon">
                                                <input  type="radio" 
                                                        name="nr_alternativa_correta" 
                                                        id="nr_alternativa_correta_2" 
                                                        value="2" 
                                                        tabindex="20"
                                                    <?php if((set_value('nr_alternativa_correta') == '2') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                    ?>>
                                            </span>
                                            <div>                                                
                                                <div id="div_ds_segundo_item_img" style="display:none;">
                                                    <div class="col-md-9">
                                                        <div class="form-group " id="campo_imagem">
                                                            <input  type="file" 
                                                                    id="img_suporte" 
                                                                    name="ds_img_item_02" 
                                                                    class="form-control filestyle file_itens_questoes" 
                                                                    data-buttonText="Adicionar imagem" 
                                                                    data-iconName="fa fa-file-image-o"
                                                                    accept="image/png, image/jpeg"
                                                                    tabindex="21"
                                                                    onchange="readURL(this,'ds_img_item_02_preview');"
                                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_img_item_02');}?>"/>                                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img    id="ds_img_item_02_preview" 
                                                                    class="img-thumbnail" 
                                                                    width="200" 
                                                                    height="200" 
                                                                    style="display:none"
                                                                    src="
                                                            <?php if ($msg != 'success'){
                                                                        echo set_value('ds_img_item_02');
                                                            }?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div_ds_segundo_item_texto">
                                                    <textarea   id="ds_segundo_item"
                                                                tabindex="22"
                                                                name="ds_segundo_item"
                                                                ><?php if ($msg != 'success'){
                                                                    echo set_value('ds_segundo_item');
                                                        }?></textarea>  
                                                </div>
                                            </div>                                          
                                        </div>
                                        <input id="ds_justificativa_02"
                                                    name="ds_justificativa_02"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="23"
                                                    placeholder="Digite uma justificativa"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_justificativa_02');
                                        }?>">                                                      
                                    </div>
                                    <div class="form-group">
                                        <label for="ds_terceiro_item">Alternativa 03</label>
                                        <div class="input-group itens_questoes">
                                            <span class="input-group-addon">
                                                <input  type="radio" 
                                                        name="nr_alternativa_correta" 
                                                        id="nr_alternativa_correta_3" 
                                                        value="3" 
                                                        tabindex="24"
                                                    <?php if((set_value('nr_alternativa_correta') == '3') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                    ?>>
                                            </span>
                                            <div>                                                
                                                <div id="div_ds_terceiro_item_img" style="display:none;">
                                                    <div class="col-md-9">
                                                        <div class="form-group " id="campo_imagem">
                                                            <input  type="file" 
                                                                    id="img_suporte" 
                                                                    name="ds_img_item_03" 
                                                                    class="form-control filestyle file_itens_questoes" 
                                                                    data-buttonText="Adicionar imagem" 
                                                                    data-iconName="fa fa-file-image-o"
                                                                    accept="image/png, image/jpeg"
                                                                    tabindex="25"
                                                                    onchange="readURL(this,'ds_img_item_03_preview');"
                                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_img_item_03');}?>"/>                                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img    id="ds_img_item_03_preview" 
                                                                    class="img-thumbnail" 
                                                                    width="200" 
                                                                    height="200" 
                                                                    style="display:none"
                                                                    src="
                                                            <?php if ($msg != 'success'){
                                                                        echo set_value('ds_img_item_03');
                                                            }?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div_ds_terceiro_item_texto">
                                                    <textarea   id="ds_terceiro_item"
                                                                tabindex="26"
                                                                name="ds_terceiro_item"
                                                                ><?php if ($msg != 'success'){
                                                                    echo set_value('ds_terceiro_item');
                                                        }?></textarea>
                                                </div>
                                            </div>
                                        </div>        
                                        <input id="ds_justificativa_03"
                                                    name="ds_justificativa_03"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="27"
                                                    placeholder="Digite uma justificativa"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_justificativa_03');
                                        }?>">                                                  
                                    </div>
                                    <div class="form-group">
                                        <label for="ds_quarto_item">Alternativa 04</label>
                                        <div class="input-group itens_questoes">
                                            <span class="input-group-addon">    
                                                <input  type="radio" 
                                                        name="nr_alternativa_correta" 
                                                        id="nr_alternativa_correta_4" 
                                                        value="4" 
                                                        tabindex="28"
                                                    <?php if((set_value('nr_alternativa_correta') == '4') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                    ?>>                         
                                            </span>
                                            <div>                                                
                                                <div id="div_ds_quarto_item_img" style="display:none;">
                                                    <div class="col-md-9">
                                                        <div class="form-group " id="campo_imagem">
                                                            <input  type="file" 
                                                                    id="img_suporte" 
                                                                    name="ds_img_item_04" 
                                                                    class="form-control filestyle file_itens_questoes" 
                                                                    data-buttonText="Adicionar imagem" 
                                                                    data-iconName="fa fa-file-image-o"
                                                                    accept="image/png, image/jpeg"
                                                                    tabindex="29"
                                                                    onchange="readURL(this,'ds_img_item_04_preview');"
                                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_img_item_04');}?>"/>                                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <img    id="ds_img_item_04_preview" 
                                                                    class="img-thumbnail" 
                                                                    width="200" 
                                                                    height="200" 
                                                                    style="display:none"
                                                                    src="
                                                            <?php if ($msg != 'success'){
                                                                        echo set_value('ds_img_item_04');
                                                            }?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div_ds_quarto_item_texto">
                                                    <textarea id="ds_quarto_item"
                                                            tabindex="30"
                                                            name="ds_quarto_item"
                                                            ><?php if ($msg != 'success'){
                                                                    echo set_value('ds_quarto_item');
                                                        }?></textarea>
                                                </div>
                                            </div>                                        
                                        </div>  
                                        <input id="ds_justificativa_04"
                                                    name="ds_justificativa_04"
                                                    type="text"
                                                    class="form-control"
                                                    tabindex="31"
                                                    placeholder="Digite uma justificativa"
                                                    value="<?php if ($msg != 'success'){
                                                                echo set_value('ds_justificativa_04');
                                        }?>">                                                        
                                    </div>
                                            
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="32">
                                            Cadastrar
                                        </button>
                                        <button type="button" 
                                                tabindex="33"
                                                onclick="window.location.href ='<?php echo base_url('avalia_item/avalia_itens/index')?>';"
                                                class="btn btn-custom waves-effect waves-light btn-micro active">
                                                Voltar
                                        </button>
                                        
                                    </div>

                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

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
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.config.height = '8em';
    CKEDITOR.replace( 'ds_enunciado' );
    CKEDITOR.replace( 'ds_comando' );
    CKEDITOR.replace( 'ds_primeiro_item' );
    CKEDITOR.replace( 'ds_segundo_item' );
    CKEDITOR.replace( 'ds_terceiro_item' );
    CKEDITOR.replace( 'ds_quarto_item' );
    CKEDITOR.replace( 'ds_texto_suporte' );
</script>
