<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_professor.js'); ?>"></script>
<script>
    function add_inep(){
        $('#nr_inep').val($('#cd_escola').find(':selected').attr('inep').toUpperCase());
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );       
        var nr_inep = $('#nr_inep').val();

        
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
    echo form_open('turma/turmas/salvar',array('ci_turma'=>'frm_turmas','method'=>'post', 'enctype'=>'multipart/form-data'));

foreach ($registros as $result) {  
?>
<div class="container">
    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Editar turma </h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador-->
                        
                                            
                        <div class="col-lg-12 form-group"> 

                            <div class="panel panel-default">
                                <div class="panel-heading" style="text-align:left;">
                                Dados escola
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

                                                <?php echo $estados_sme ?>

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
                                                
                                                <?php echo $municipios_sme ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div  class="col-lg-2">
                                            <label for="nr_inep">Inep escola</label>
                                            <input type="text"
                                                name="nr_inep"
                                                id="nr_inep"
                                                tabindex="3"
                                                placeholder="Inep escola"
                                                class="form-control"
                                                value="<?php echo $result->nr_inep ?>"
                                                onchange="pesquisa_inep();">
                                                
                                        </div>
                                        <div class="col-lg-10">
                                            <label for="cd_escola">Escola</label>
                                            <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                                                onblur="add_inep();">
                                                <Option value="" nr_inep=""></Option>
                                                <?php
                                                    foreach ($escolas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                                            <?php if ($result->cd_escola == $item->ci_escola){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                                        </Option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                




                                </div><!-- fim .panel-body -->
                            </div><!-- fim .panel panel-default -->   

                        </div>

                    <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

                        <div class="col-lg-12 form-group"> 

                            <div class="panel panel-default">
                                <div class="panel-heading" style="text-align:center;">
                                Município da SME
                                </div>
                                <div class="panel-body">
                                
                                    <div class="col-lg-6">                                                    
                                        <div class="form-group">
                                            
                                            <label>Estado *</label>
                                            <input  type="text"
                                                    disabled
                                                    class="form-control"
                                                    value="<?php echo $result->nm_estado_sme ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Município *</label>

                                            <input  type="text"
                                                    disabled
                                                    class="form-control"
                                                    value="<?php echo $result->nm_cidade ?>">
                                            
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div  class="col-lg-2">
                                            <label for="nr_inep">Inep escola</label>
                                            <input type="text"
                                                name="nr_inep"
                                                id="nr_inep"
                                                tabindex="3"
                                                placeholder="Inep escola"
                                                class="form-control"
                                                value="<?php echo $result->nr_inep ?>"
                                                onblur="pesquisa_inep();">
                                                
                                        </div>
                                        <div class="col-lg-10">
                                            <label for="cd_escola">Escola</label>
                                            <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                                                onchange="add_inep();">
                                                <Option value="" nr_inep=""></Option>
                                                <?php
                                                    foreach ($escolas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                                            <?php if ($result->cd_escola == $item->ci_escola){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                                        </Option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                </div><!-- fim .panel-body -->
                            </div><!-- fim .panel panel-default -->   

                        </div>

                    <?php }else{?> <!-- Se o usuário for Escola-->

                        <input type="hidden" name="cd_estado_sme" id="cd_estado_sme" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                        <input type="hidden" name="cd_cidade_sme" id="cd_cidade_sme" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                        <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">
                    <?php }?> <!-- Fim grupo SME ou escola -->

                    <!-- Div Parametros -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Editar avaliação ' ?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">        
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="nm_turma">Nome *</label>
                                            <input type="text"
                                                name="nm_turma"
                                                id="nm_turma"
                                                tabindex="1"
                                                placeholder="Nome"
                                                class="form-control"
                                                value="<?php echo $result->nm_turma;?>">
                                        </div>                                        
                                    </div >                                                                                  
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="cd_etapa">Etapa *</label>
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
                                    </div> 
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="cd_turno">Turno *</label>
                                            <select id="cd_turno" name="cd_turno" tabindex="4" class="form-control">
                                                <Option value=""></Option>
                                                <?php
                                                foreach ($turnos as $item) {
                                                    ?>
                                                    <Option value="<?php echo $item->ci_turno; ?>"
                                                        <?php if ($result->cd_turno == $item->ci_turno){
                                                            echo 'selected';
                                                        } ?> >
                                                        <?php echo $item->nm_turno; ?>
                                                    </Option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label for="cd_ano_letivo">Ano Letivo *</label>
                                            <input type="text"
                                                    name="nr_ano_letivo"
                                                    id="nr_ano_letivo"
                                                    tabindex="2"
                                                    placeholder="Ano letivo"
                                                    class="form-control"
                                                    value="<?php echo $result->nr_ano_letivo?>">
                                        </div>
                                    </div>  
                                </div >
                                <div class="col-lg-12">        
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="nr_cpf">CPF Professor *</label>
                                            <input type="hidden" name="cd_professor" id="cd_professor" value="<?php echo $result->ci_professor?>">
                                            <input type="text"
                                                name="nr_cpf"
                                                id="cpf"
                                                tabindex="2"
                                                placeholder="CPF"
                                                class="form-control cpf"
                                                value="<?php echo $result->nr_cpf?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group">                                        
                                            <label for="consultaProfessor">Consultar</label>
                                            <button  type="button"
                                            class="btn btn-custom waves-effect waves-light btn-micro active"
                                                id="consultaProfessor">
                                                    <i class="fa fa-search"></i>
                                            </button>
                                        </div>    
                                    </div>   
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nm_professor">Nome professor *</label>
                                            <input type="text"
                                                    name="nm_professor"
                                                    id="nm_professor"
                                                    tabindex="2"
                                                    disabled
                                                    placeholder="Nome professor"
                                                    class="form-control"
                                                    value="<?php echo $result->nm_professor?>">
                                        </div>
                                    </div> 
                                    <div class="form-group col-lg-3">
                                        
                                        <label id="">Tipo de turma *</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="tp_turma_r">
                                                <input type="radio" name="tp_turma" id="tp_turma_r" value="R" tabindex="3"
                                                    <?php if($result->tp_turma == 'R'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Regular
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="tp_turma_m">
                                                <input type="radio" name="tp_turma" id="tp_turma_m" value="M"  class="form-check-input" tabindex="4"
                                                    <?php if($result->tp_turma == 'M'){
                                                        echo 'checked'; }
                                                        ?>>
                                                Multisseriada
                                            </label>&nbsp;&nbsp;&nbsp;

                                        </div>
                                    </div>                                     
                                    
                                </div >                                
                                

                                <div class="col-lg-12">             
                                        <div align="right">
                                            <input type="hidden" id="ci_turma" name="ci_turma" value="<?php echo $result->ci_turma?>">        
                
                                            <button type="submit" 
                                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                    tabindex="7">
                                                Atualizar
                                            </button>
                                            <button type="button" 
                                                    tabindex="8"
                                                    onclick="window.location.href ='<?php echo base_url('turma/turmas/index')?>';"
                                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                                    Voltar
                                            </button>
                                        </div>
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
<script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>
<script type="text/javascript">
    $('#consultaProfessor').click(function(){
        populaprofessor($('#cpf').val(), $('#cd_professor'), $('#nm_professor'));
    });
</script>