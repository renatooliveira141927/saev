<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/transferencias.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep').toUpperCase());
    }

    function pesquisa_inep_escola(){

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
    function pesquisa_cd_escola(id){

        var option  = $( "select[name^='cd_escola'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');

            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }

    function escola_selecionda(id_escola, cd_turma){
        add_inep_escola();
        populaturma('',id_escola, '', cd_turma);
    }

    function atualiza_combos_turma(nm_cd_turma, nm_cd_etapa, nm_cd_turno){


        var cd_etapa = $('#'+nm_cd_turma).find(':selected').attr('cd_etapa');
        var cd_turno = $('#'+nm_cd_turma).find(':selected').attr('cd_turno');
        
        atualiza_etapa(nm_cd_etapa, cd_etapa);
        atualiza_turno(nm_cd_turno, cd_turno)
    }

    function atualiza_turno(nm_cd_turno, id){

        var option  = $( "select[name^='"+nm_cd_turno+"'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');

            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }

    function atualiza_etapa(nm_cd_etapa, id){

        var option  = $( "select[name^='"+nm_cd_etapa+"'] option" );

        option.each(function () {

            var attr_value = $(this).attr('value');
            // alert('atualiza_etapa=>  attr_value='+attr_value+'  id='+id);
            if (attr_value == id) {
                $(this).prop("selected", true);
                encontrou = true;
            }else{
                $(this).prop("selected", false);
            }
        });
    }
    function zerar_turma(nm_cd_turma){
        $('#'+nm_cd_turma).val("");
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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a turma já está cadastrada no banco de dados!");
    </script>

    <?php
}
    echo form_open('turma/turmas/salvar',array('id'=>'frm_turmas','method'=>'post', 'enctype'=>'multipart/form-data'))
?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">

<div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
    <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
</div>
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
                   
                    <!-- Inicio div municipio sme -->                        
                    <div class="col-lg-12 form-group" id="dv_gruposme"> 

                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align:left;">
                            Pesquisar aluno
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

                                            <?php echo $estado ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Município *</label>
                                        <select id="cd_cidade_sme" 
                                                name="cd_cidade_sme" 
                                                tabindex="2"                                                    
                                                class="form-control" disabled
                                                onchange="populaescola(this.value,'');">
                                            <option value="">Selecione o estado</option>
                                        </select>
                                    </div>
                                </div>


                            <div  class="col-lg-2">
                                <div class="form-group">
                                    <label for="nr_inep_escola">Inep escola</label>
                                    <input type="text"
                                        name="nr_inep_escola"
                                        id="nr_inep_escola"
                                        tabindex="3"
                                        placeholder="Inep escola"
                                        class="form-control"
                                        value="<?php echo set_value('nr_inep_escola'); ?>"
                                        onblur="pesquisa_inep();">
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label for="cd_escola">Escola</label>
                                    <select id="cd_escola" 
                                            name="cd_escola" 
                                            tabindex="4" 
                                            disabled
                                            class="form-control"
                                            onchange="escola_selecionda(this.value);">
                                        <Option value="" nr_inep=""></Option>
                    
                                    </select>
                                </div>
                            </div>
                                                    <div  class="col-lg-4">
                            <div class="form-group">
                                <label for="cd_turma">Turma </label>
                                <select id="cd_turma" name="cd_turma" tabindex="3" 
                                <?php if ($this->session->userdata('ci_grupousuario') != 3){ echo 'disabled'; }?>
                                onchange="atualiza_combos_turma('cd_turma', 'cd_etapa', 'cd_turno');"
                                class="form-control">
                                    <Option value="" cd_etapa="" cd_turno=""></Option>
                                    <?php
                                    foreach ($turmas as $item) {
                                        ?>
                                        <Option value="<?php echo $item->ci_turma; ?>"  
                                                cd_etapa="<?php echo $item->cd_etapa; ?>" 
                                                cd_turno="<?php echo $item->cd_turno; ?>"
                                            <?php if (set_value('cd_turma') == $item->ci_turma){
                                                echo 'selected';
                                            } ?> >
                                            <?php echo $item->nm_turma; ?>
                                        </Option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div  class="col-lg-5">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa </label>
                                <select id="cd_etapa" name="cd_etapa" tabindex="4" class="form-control" onchange="zerar_turma('cd_turma');">
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
                        <div  class="col-lg-3">
                            <div class="form-group">
                                <label for="cd_turno">Turno </label>
                                <select id="cd_turno" name="cd_turno" tabindex="4" class="form-control" onchange="zerar_turma('cd_turma');">
                                    <Option value=""></Option>
                                    <?php
                                    foreach ($turnos as $item) {
                                        ?>

                                        <Option value="<?php echo $item->ci_turno; ?>"
                                            <?php if (set_value('cd_turno') == $item->ci_turno){
                                                echo 'selected';
                                            } ?> >
                                            <?php echo $item->nm_turno; ?>
                                        </Option>

                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="nr_inep">Inep</label>
                                            <input type="text"
                                                name="nr_inep"
                                                id="nr_inep"
                                                tabindex="2"
                                                placeholder="Inep"
                                                class="form-control"
                                                value="<?php echo set_value('nr_inep'); ?>">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label for="nm_aluno">Nome</label>
                                <input type="text"
                                        name="nm_aluno"
                                        id="nm_aluno"
                                        tabindex="1"
                                        placeholder="Nome"
                                        class="form-control"
                                        value="<?php echo set_value('nm_aluno');?>">
                            </div>
                        </div>



                            </div><!-- fim .panel-body -->
                        </div><!-- fim .panel panel-default -->   
                        <div class="col-lg-12">

                        <div  align="right">
                            <input type="hidden"
                                    id="url_base"
                                    value="<?php echo base_url('transferencia/transferencias')?>">

                            <button type="button" id="btn_consulta_aluno"
                                        tabindex="9"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                    Consultar
                            </button>
                            <button type="button" 
                                    tabindex="25"
                                    onclick="window.location.href ='<?php echo base_url('transferencia/transferencias/index')?>';"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                    Voltar
                            </button>

                        </div>

                        </div>
                    </div>
                    <!-- Fim div municipio sme-->

                    <!-- Div Parametros -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Listagem de Alunos'?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    
                                    <div id="listagem_resultado"></div>

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
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
<script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>