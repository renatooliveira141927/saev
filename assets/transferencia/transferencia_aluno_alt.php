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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a solicitação de transferência já está cadastrada no banco de dados!");
    </script>

    <?php
}
    echo form_open('transferencia/transferencias/aprovarTransferencia',array('id'=>'frm_transferencias','method'=>'post', 'enctype'=>'multipart/form-data'));
    
    foreach ($transferencia as $resultado) {
?>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Transferências (Aprovar)</h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                   
                    <!-- Inicio div municipio sme -->                        
                    <div class="col-lg-12 form-group" id="dv_gruposme"> 

                        <div class="panel panel-default">
                            <div class="panel-heading" style="text-align:left;">
                            Administrar transferência
                            </div>
                            <div class="panel-body">
                             <fieldset>
                                 <legend>Dados da Escola de Origem</legend>
                             
                                <div class="col-lg-12">
                                    <input type="hidden" name="ci_transferencia" value="<?php echo $ci_transferencia?>">
                                    <input type="hidden" name="cd_escola_origem" value="<?php echo $resultado->cd_escola_origem?>">                                    
                                    <input type="hidden" name="cd_aluno" value="<?php echo $resultado->ci_aluno?>"> 

                                    <label for="nr_inep_escola">Inep escola: </label>&nbsp;&nbsp;<?php echo $resultado->nr_inep_origem?> &nbsp;&nbsp;&nbsp;  
                                    <label for="nr_inep_escola">Escola: </label>&nbsp;&nbsp;<?php echo $resultado->nm_escola_origem?><br/>

                                    <label for="nr_inep_escola">Nome: </label>&nbsp;&nbsp;<?php echo $resultado->nm_aluno?> &nbsp;&nbsp;&nbsp; <br/>
                                    <label for="nr_inep_escola">Mãe: </label>&nbsp;&nbsp;<?php echo $resultado->nm_mae?> &nbsp;&nbsp;&nbsp;<br/>
                                    <label for="nr_inep_escola">Data de nascimento: </label>&nbsp;&nbsp;<?php echo $resultado->dt_nascimento?><br/><br/>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="txt_solicitacao">Solicitação:</label>
                                        <label><?php echo $resultado->txt_solicitacao?></label>
                                    </div>
                                    
                                </div>
                            </fieldset>
                            <fieldset>
                                 <legend>Dados da Escola Destino</legend>    
                                    <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                                    <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                                    <input type="hidden" name="cd_escola" value="<?php echo $resultado->cd_escola_destino?>">
                                <label for="nr_inep_escola">Inep escola: </label>&nbsp;&nbsp;<?php echo $resultado->nr_inep_destino?> &nbsp;&nbsp;&nbsp;  
                                    <label for="nr_inep_escola">Escola: </label>&nbsp;&nbsp;<?php echo $resultado->nm_escola_destino?><br/>

                                <div  class="col-lg-4">
                                    <div class="form-group">
                                        <label for="cd_turma">Turma </label>
                                        <select id="cd_turma" name="cd_turma" tabindex="3"
                                        onchange="atualiza_combos_turma('cd_turma', 'cd_etapa', 'cd_turno');"
                                        class="form-control">
                                            <Option value="" cd_etapa="" cd_turno=""></Option>
                                            <?php
                                            foreach ($turmas as $item) {?>
                                                <Option value="<?php echo $item->ci_turma; ?>"  
                                                        cd_etapa="<?php echo $item->cd_etapa; ?>" 
                                                        cd_turno="<?php echo $item->cd_turno; ?>"
                                                    <?php if ($cd_turma == $item->ci_turma){
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
                                <div  class="col-lg-2">
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
                            </fieldset>                                  
                                <div class="col-lg-12">                                    
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="26">
                                            Aprovar
                                        </button>
                                        <button type="button" 
                                                tabindex="27"
                                                onclick="window.location.href ='<?php echo base_url('transferencia/transferencias/index')?>';"
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