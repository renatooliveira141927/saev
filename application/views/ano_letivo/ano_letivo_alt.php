<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>

<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Administrar <?php echo $titulo ?></h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               <?php echo 'Alterar '.$titulo ?>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">

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
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o ano letivo já está cadastrado no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('ano_letivo/anos_letivos/salvar',array('id'=>'frm_anos_letivos','method'=>'post', 'onsubmit'=>'javascript:seleciona_todos_itens($(\'#cd_escolas_selecionadas\')); '));

                                                foreach ($registros as $result) {
                                            ?>
                   
                                                    <div class="col-lg-12">
                                                        <div class="form-group col-lg-7">
                                                            <label id="nr_ano_letivo">Ano_letivo</label>
                                                            <input id="nr_ano_letivo"
                                                                   name="nr_ano_letivo"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o ano letivo"
                                                                   value="<?php echo $result->nr_ano_letivo?>">
                                                        </div>
                                                        <div class="form-group col-lg-5">                                        
                                                            <label id="">Situação *</label>
                                                            <div class="form-control">
                                                                <label class="radio-inline control-label" for="fl_ano_letivo_corrente_s">
                                                                    <input type="radio" name="fl_ano_letivo_corrente" id="fl_ano_letivo_corrente_s" value="S" tabindex="3"
                                                                        <?php if($result->fl_ano_letivo_corrente == 'S'){
                                                                            echo 'checked'; }
                                                                            ?>>
                                                                    Vigente
                                                                </label>&nbsp;&nbsp;&nbsp;
                                                                
                                                                <label class="radio-inline control-label" for="fl_ano_letivo_corrente_n">
                                                                    <input type="radio" name="fl_ano_letivo_corrente" id="fl_ano_letivo_corrente_n" value="N"  class="form-check-input" tabindex="4"
                                                                        <?php if($result->fl_ano_letivo_corrente == 'N'){
                                                                            echo 'checked'; }
                                                                            ?>>
                                                                    Inativo
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
               
                                                
                                                    <div class="col-lg-12"><!-- Inicio div conteúdo escolas -->
                                       
                                                        <div class="form-group col-lg-6">
                                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                                            <label>Estados </label>
                                                            <select id="cd_estado" 
                                                                    name="cd_estado" 
                                                                    tabindex="14"
                                                                    class="form-control" 
                                                                    onchange="populacidade(this.value, '', '', false, $('#cd_cidade_menu_esc'));">

                                                                <?php echo $estado ?>

                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div  class="form-group">
                                                                <label>Municípios </label>
                                                                <select id="cd_cidade_menu_esc" 
                                                                        name="cd_cidade_menu_esc" 
                                                                        tabindex="15"                                                                                                              
                                                                        onchange="populaescola(this.value,'');"
                                                                        class="form-control" >
                                                                        <?php echo $municipios ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                    
                                                    </div>      
                                                    <div class="col-lg-12">                   
                                                        <div class="col-lg-6">
                                                            <div  class="form-group">
                                                                <label>Escolas </label>

                                                                <select multiple id="cd_escola" 
                                                                        name="cd_escola" 
                                                                        tabindex="15"
                                                                        style="width:100%;height:300px;"                                       
                                                                        ondblclick="adicionar( $(this) , $('#cd_escolas_selecionadas'));"
                                                                        class="form-control" >

                                                                        <?php
                                                                        foreach ($escolas_municipios as $item) {
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
                                                                <label>Escolas no ano letivo </label>
                                                                <select class="form-control" 
                                                                        id="cd_escolas_selecionadas" 
                                                                        name="cd_escolas_selecionadas[]" 
                                                                        ondblclick="remover( $(this) , $('#cd_escola') );"
                                                                        multiple 
                                                                        style="width:100%;height:300px;">
                                                                    <?php
                                                                        foreach ($anoletivo_escolas as $item) {
                                                                            ?>
                                                                            <Option value="<?php echo $item->cd_escola; ?>" selected>
                                                                                <?php echo  $item->nr_inep .' - '. $item->nm_escola; ?>
                                                                            </Option>

                                                                    <?php } ?>
                                                                </select>
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


                                                <input type="hidden" id="ci_ano_letivo" name="ci_ano_letivo" value="<?php echo $result->ci_ano_letivo?>">

                                                <div class="row" align="right">

                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Atualizar</button>
                                                        <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('ano_letivo/anos_letivos/index')?>';"
                                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                                        Voltar</button>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                            echo form_close();

                                        ?>

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