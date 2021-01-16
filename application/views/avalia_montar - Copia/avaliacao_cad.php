<link href="<?=base_url('assets/css/cad_itens_avaliacoes.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>

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
    echo form_open('avaliacao/avaliacoes/salvar',array('id'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data'))
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
                            
                                <div>
                                    <div class="form-group  ">
                                        <label for="cd_dificuldade">Caderno</label>
                                        <input type="text"
                                            name="nm_caderno"
                                            id="nm_caderno"
                                            tabindex="2"
                                            placeholder="Caderno"
                                            style="text-transform: uppercase;"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_caderno');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="nr_ano">Ano</label>
                                        <input type="number"
                                            name="nr_ano"
                                            id="nr_ano"
                                            tabindex="2"
                                            placeholder="Ano"
                                            style="text-transform: uppercase;"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_ano');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cd_avalia_tipo">Tipo de avaliação</label>
                                        <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="2" class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($avalia_tipos as $item) {
                                                ?>
                                                <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                                    <?php if ((set_value('cd_avalia_tipo') == $item->ci_avalia_tipo) && ($msg != 'success')){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_avalia_tipo; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2" align="center">
                                        <label for="fl_ avalia_nominal">Sortear Itens</label><br/>
                                        <input type="checkbox" 
                                               id="fl_avalia_nominal"
                                               name="fl_avalia_nominal"
                                               value="1" 
                                               switch="info" checked/>
                                        <label for="fl_avalia_nominal" 
                                               data-on-label="Sim"
                                               data-off-label="Não">
                                        </label>
                                    </div> 
                                    <div class="form-group col-lg-2" align="center">
                                        <label for="fl_sortear_itens">Avaliação Nominal</label><br/>
                                        <input type="checkbox" 
                                               id="fl_sortear_itens"
                                               name="fl_sortear_itens"
                                               value="1" 
                                               switch="info" checked/>
                                        <label for="fl_sortear_itens" 
                                               data-on-label="Sim"
                                               data-off-label="Não">
                                        </label>
                                    </div>             
                                </div >
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-4">
                                        <label for="cd_disciplina">Disciplina</label>
                                        <select id="cd_disciplina" name="cd_disciplina" tabindex="2" class="form-control">
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
                                    <div class="form-group col-lg-4">
                                        <label for="cd_etapa">Etapa</label>
                                        <select id="cd_etapa" name="cd_etapa" tabindex="3" class="form-control">
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
                                    <div class="form-group col-lg-4">
                                        <label for="cd_edicao">Edicao</label>
                                        <select id="cd_edicao" name="cd_edicao" tabindex="7" class="form-control">
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
                                    <div class="form-group">
                                        <label for="ds_texto_abertura">Texto de abertura</label>
                                        <textarea   id="ds_texto_abertura"
                                                    tabindex="17"
                                                    name="ds_texto_abertura"
                                                    ><?php if ($msg != 'success'){
                                                        echo set_value('ds_texto_abertura');
                                                    }?></textarea> 
                                    </div>
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="24">
                                            Cadastrar
                                        </button>
                                        <button type="button" 
                                                tabindex="25"
                                                onclick="window.location.href ='<?php echo base_url('avalia_item/avalia_itens/index')?>';"
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
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.config.height = '8em';
    CKEDITOR.replace( 'ds_texto_abertura' );  
</script>
