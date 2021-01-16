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
    echo form_open('avaliacao/avaliacoes/salvar',array('ci_avaliacao'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data'));

foreach ($registros as $result) {
?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Editar avaliação </h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- Div Parametros -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Editar avaliação ' ?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-2">
                                        <label for="cd_dificuldade">Caderno</label>
                                        <input type="text"
                                            name="nm_caderno"
                                            id="nm_caderno"
                                            tabindex="2"
                                            placeholder="Caderno"
                                            style="text-transform: uppercase;"
                                            class="form-control"
                                            value="<?php echo $result->nm_caderno; ?>">
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
                                            value="<?php echo $result->nr_ano;?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="cd_avalia_tipo">Tipo de avaliação</label>
                                        <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="2" class="form-control">
                                            <Option value=""></Option>
                                            <?php
                                            foreach ($avalia_tipos as $item) {
                                                ?>
                                                <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                                    <?php if ($result->cd_avalia_tipo == $item->ci_avalia_tipo){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_avalia_tipo; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2" align="center">
                                        <label for="fl_avalia_nominal">Sortear Itens</label><br/>
                                        <input type="checkbox" 
                                               id="fl_avalia_nominal"
                                               name="fl_avalia_nominal"
                                               switch="info"
                                               value="1" 
                                                
                                               <?php if ($result->fl_avalia_nominal == "t") {
                                                        echo 'checked';
                                                }?>
                                               />                                       
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
                                                
                                               <?php if ($result->fl_sortear_itens == "t") {
                                                        echo ' checked';
                                                }?> 
                                               switch="info"/>
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
                                                    <?php if ($result->cd_disciplina == $item->ci_disciplina){
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
                                                    <?php if ($result->cd_etapa == $item->ci_etapa){
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
                                                    <?php if ($result->cd_edicao == $item->ci_edicao){
                                                        echo 'selected';
                                                    } ?> >
                                                    <?php echo $item->nm_edicao; ?>
                                                </Option>

                                            <?php } ?>
                                        </select>
                                        
                                    </div>
                                    
                                </div>
                                <input type="hidden" id="ci_avaliacao" name="ci_avaliacao" value="<?php echo $result->ci_avaliacao?>">        
                                <div class="form-group col-lg-12" align="right">
                                    <button type="submit" 
                                            class="btn btn-custom waves-effect waves-light btn-micro active" 
                                            tabindex="24">
                                        Atualizar
                                    </button>
                                    <button type="button" 
                                            tabindex="25"
                                            onclick="window.location.href ='<?php echo base_url('avaliacao/avaliacoes/index')?>';"
                                            class="btn btn-custom waves-effect waves-light btn-micro active">
                                            Voltar
                                    </button>
                                    
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
    
    
</script>
