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
    echo form_open('avaliacao/avaliacoes/salvar',array('ci_avaliacao'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data', 'onsubmit' => "selecionarAllOptions()"));

foreach ($registros as $result) {
?>
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header"><?php echo $titulo ?></h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <!-- Div Cabecalho Menu -->                     
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#capa" data-toggle="tab" aria-expanded="false">
                                <span class="visible-xs"><i class="fa fa-capa"></i></span>
                                <span class="hidden-xs">Capa</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#itens" data-toggle="tab" aria-expanded="true">
                                <span class="visible-xs"><i class="fa fa-user"></i></span>
                                <span class="hidden-xs">Itens</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Fim Div Cabecalho Menu --> 
                    <div class="tab-content">
                        <!-- Div Menu CAPA--> 
                        <div class="tab-pane active" id="capa">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                    <?php echo 'Capa ' ?>

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
                                                <label for="cd_disciplina_ava">Disciplina</label>
                                                <select id="cd_disciplina_ava" name="cd_disciplina_ava" tabindex="2" class="form-control">
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
                                                <label for="cd_etapa_ava">Etapa</label>
                                                <select id="cd_etapa_ava" name="cd_etapa_ava" tabindex="3" class="form-control">
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
                                                <label for="cd_edicao_ava">Edicao</label>
                                                <select id="cd_edicao_ava" name="cd_edicao_ava" tabindex="7" class="form-control">
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
                                            <div class="form-group">
                                                <label for="ds_texto_abertura">Texto de abertura</label>
                                                <textarea   id="ds_texto_abertura"
                                                            tabindex="17"
                                                            name="ds_texto_abertura">
                                                            <?php echo $result->ds_texto_abertura; ?>
                                                </textarea> 
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim div menu capa -->
                        <!-- div menu itens -->   
                        <div class="tab-pane" id="itens">
                            <p> 

                            <?php 
                                    $dados['origem_acesso']    = 'avaliacao';
                                    $dados['avaliacao_itens']  = $avaliacao_itens;                                    
                                    $this->load->view('avalia_item/avalia_item', $dados);
                            ?>
                                
                            </p>
                        </div>
                        <!-- Fim div menu itens -->                                        
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
    CKEDITOR.replace( 'ds_texto_abertura' );  
</script>
