
<link href="<?=base_url('assets/css/listbox.css'); ?>" rel="stylesheet">
<script src="<?=base_url('assets/js/listbox.js'); ?>"></script>
<script src="<?=base_url('assets/js/avalia_item.js'); ?>"></script>
<script src="<?=base_url('assets/listagem_cadastros/js/avalia_itens.js'); ?>"></script>
<?php 
    if (!isset($origem_acesso)){
        $origem_acesso = '';
    }
?>

    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title">Consulta itens para avaliação</h4>
                </p>
            </div>
            <?php 
                if (!isset($origem_acesso)){
                    $origem_acesso = '';
                }

                if($origem_acesso!='avaliacao'){ ?>
                    <div class="col-md-2" style="text-align: right">
                        <p>
                            <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                            href="<?php echo base_url('avalia_item/avalia_itens/novo'); ?>">Cadastrar</a>
                        </p>
                    </div>
                <?php 
                }
                ?>

        </div>
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <?php if($origem_acesso=='avaliacao'){ ?>
        <div class="container-fluid">
    <?php } else { ?>
        <div class="container">
    <?php } ?>
        <div class="card-box">
                <div >
                    <div class="form-group col-lg-12">
                    
                    <input type="hidden"
                                    name="origem_acesso"
                                    id="origem_acesso"
                                    value="<?php echo $origem_acesso?>">
                        <div class="col-lg-2">
                            <label for="ds_codigo">Código da questão</label>
                            <input type="text"
                                    name="ds_codigo"
                                    id="ds_codigo"
                                    tabindex="2"
                                    placeholder="Cod."
                                    maxlength   ="10"
                                    style="text-transform: uppercase;"
                                    class="form-control"
                                    value="<?php echo set_value('ds_codigo');?>">

                        </div>
                        <div class="col-lg-8">
                            <label for="nm_avalia_item">Titulo da questão</label>
                            <input type="text"
                                    name="ds_titulo"
                                    id="ds_titulo"
                                    tabindex="2"
                                    placeholder="Nome da questão"
                                    class="form-control"
                                    value="<?php echo set_value('ds_titulo');?>">

                        </div>
                        <div class="col-lg-2">
                            <label for="cd_edicao">Edicao</label>
                            <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($edicoes as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_edicao; ?>"
                                        <?php if (set_value('cd_edicao') == $item->ci_edicao){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_edicao; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="col-lg-3">
                            <label for="cd_avalia_dificuldade">Dificuldade</label>
                            <select id="cd_avalia_dificuldade" name="cd_avalia_dificuldade" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_dificuldades as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_avalia_dificuldade; ?>"
                                        <?php if (set_value('cd_avalia_dificuldade') == $item->ci_avalia_dificuldade){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_avalia_dificuldade; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="cd_disciplina">Disciplina</label>
                            <select id="cd_disciplina" name="cd_disciplina" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($disciplinas as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_disciplina; ?>"
                                        <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_disciplina; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="cd_avalia_origem">Origem</label>
                            <select id="cd_avalia_origem" name="cd_avalia_origem" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_origens as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_avalia_origem; ?>"
                                        <?php if (set_value('cd_avalia_origem') == $item->ci_avalia_origem){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_avalia_origem; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="cd_etapa">Etapa</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($etapas as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_etapa; ?>"
                                        <?php if (set_value('cd_etapa') == $item->ci_etapa){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_etapa; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <div class="col-lg-6">
                            <label for="cd_avalia_conteudo">Conteúdo</label>
                            <select id="cd_avalia_conteudo" name="cd_avalia_conteudo" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_conteudos as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_avalia_conteudo; ?>"
                                        <?php if (set_value('cd_avalia_conteudo') == $item->ci_avalia_conteudo){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_avalia_conteudo; ?>
                                    </Option>

                                <?php } ?>
                            </select>               
                        </div>
                        <div class="col-lg-6">
                            <label for="cd_avalia_subconteudo">Sub conteúdo</label>
                            <select id="cd_avalia_subconteudo" name="cd_avalia_subconteudo" tabindex="3" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($avalia_subconteudos as $item) {
                                    ?>
                                    <Option value="<?php echo $item->ci_avalia_subconteudo; ?>"
                                        <?php if (set_value('cd_avalia_subconteudo') == $item->ci_avalia_subconteudo){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_avalia_subconteudo; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('avalia_item/avalia_itens/')?>">

                    <div  align="right" class="main row">
                        <button type="button" id="btn_consulta"
                                tabindex="5"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Consultar
                        </button>
                                                
                    </div>
                </div>




    </div>
    <!-- Div para listagem resultado da consulta-->
    <?php if($origem_acesso=='avaliacao'){ ?>
        <div class="col-lg-8" id="listagem_resultado"></div>
        <div class="col-lg-4">
            <select class="form-control" 
                    id="sel_avalia_item" 
                    name="arr_avalia_item[]" 
                    multiple 
                    style="width:100%;height:400px;">

                    <?php
                    if (isset($avaliacao_itens)) {
                        foreach ($avaliacao_itens as $item) {
                            ?>
                            <Option value="<?php echo $item->ci_avalia_item; ?>"
                                <?php if (set_value('sel_avalia_item') == $item->ci_avalia_item){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->ds_codigo.' - '.$item->ds_titulo; ?>
                            </Option>

                    <?php 
                        } 
                    }?>
            </select>
            <button type="button"
                    onclick="removeOption()">Remover item
            </button>
            <button type="button"
                    onclick="removeAllOptions()">Remover todos
            </button>
        </div>
    <?php }else{ ?>
    <div id="listagem_resultado"></div>
    <?php }?>
    </form>