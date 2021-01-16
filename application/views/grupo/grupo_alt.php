<link href="<?=base_url('assets/css/listbox.css'); ?>" rel="stylesheet">
<script src="<?=base_url('assets/js/listbox.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/consulta_escola/js/consulta_escola_lista_table.js'); ?>"></script>

 <style>
    .cover {
        font-size:    12px;
        font-family:  sans-serif;
    }

</style>
<script>
    $(function () {
        $('select#ci_transacao').listbox();
        $('select#ci_escola').listbox();
    });
    function add_select_escolas(valor, texto){
        if (checkOption(valor)){
            alert('Escola já adicionada!');
        }
        else{
            var x = document.getElementById("escolas");
            var option = document.createElement("option");
            option.value = valor;
            option.text = texto;

            var sel = x.options[x.selectedIndex]; 
            x.add(option, sel);
        }        
    }
    function exibir_escolas(){
        if(document.getElementById('fl_tpacesso').checked) {
            $("#div_consulta_escola").hide();
        } else {
            $("#div_consulta_escola").show();
        }                                       
    }
    function checkOption(valor){
        var select = document.getElementById("escolas");
        var result = [];
        var options = select && select.options;
        var opt;
        for(var i = 0; i < options.length; i++){
            opt = options[i];
            if (opt.value == valor) {
                return true;
            }
        }
        return false;        
    }

    function selecionarAllOptions(){
        var select = document.getElementById("escolas");
        var result = [];
        var options = select && select.options;
        var opt;
        for(var i = 0; i < options.length; i++){
            opt = options[i];
            opt.selected = true;
        }
        return true;
    }

    function addOption(){
        var select = document.getElementById("escolas");
        select.options[select.options.length] = new Option('New Element', '0', false, false);
    }

    function removeOption(){
        var select = document.getElementById("escolas");
        select.options[select.selectedIndex] = null;
    }

    function removeAllOptions(){
        var select = document.getElementById("escolas");
        select.options.length = 0;
    }
</script>
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
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o grupo já está cadastrado no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('usuario/grupos/salvar',array('id'=>'frm_grupos','method'=>'post', 'onsubmit' => "selecionarAllOptions()"));

                                                foreach ($registros as $result) {
                                            ?>

                                                <div class="col-lg-12">
                                                    <div>
                                                        <div class="form-group col-lg-10">
                                                            <label for="nm_grupo">Nome do grupo</label>
                                                            <input id="nm_grupo"
                                                                name="nm_grupo"
                                                                type="text"
                                                                class="form-control"
                                                                tabindex="5"
                                                                placeholder="Digite o nome do grupo"
                                                                style="text-transform: uppercase;"
                                                                value="<?php echo $result->nm_grupo ?>">
                                                        </div>
                                                        <div class="form-group col-lg-2">
                                                            <label id="">Administrador? *</label>
                                                            <div class="form-control">
                                                                <label class="radio-inline control-label" for="tp_administrador_s">
                                                                    <input type="radio" name="tp_administrador" id="tp_administrador_s" value="S" tabindex="3"
                                                                        <?php if ($result->tp_administrador == 'S'){
                                                                            echo 'checked'; }
                                                                            ?>>
                                                                    Sim
                                                                </label>&nbsp;&nbsp;&nbsp;
                                                                
                                                                <label class="radio-inline control-label" for="tp_administrador_n">
                                                                    <input type="radio" name="tp_administrador" id="tp_administrador_n" value="N"  class="form-check-input" tabindex="4"
                                                                        <?php if ($result->tp_administrador == 'N'){
                                                                            echo 'checked'; }
                                                                            ?>>
                                                                    Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class='span12'>
                                                    <h3>Permissões</h3>
                                                </div>
                                                <div class="cover">
                                                    <select id="ci_transacao" name="arr_transacoes[]" multiple>
                                                        <?php
                                                        foreach ($grupotransacoes as $item) {
                                                            ?>
                                                            <Option value="<?php echo $item->ci_transacao; ?>"
                                                                <?php if ($item->cd_grupo){
                                                                    echo 'selected';
                                                                } ?> >
                                                                <?php echo $item->nm_transacao; ?>
                                                            </Option>

                                                        <?php } ?>
                                                    </select><br/>

                                                </div>



                                                <input type="hidden" id="ci_grupousuario" name="ci_grupousuario" value="<?php echo $result->ci_grupousuario?>">

                                                <div class="row" align="right">

                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Atualizar</button>
                                                        <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('usuario/grupos/index')?>';"
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