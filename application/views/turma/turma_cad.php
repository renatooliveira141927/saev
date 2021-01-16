<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/turma.css'); ?>">
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_professor.js'); ?>"></script>
<script>
    function add_inep(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep').toUpperCase());
    }

    function pesquisa_inep(){

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
<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Cadastrar Turma</h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrador -->
                                
                                <!-- Inicio div municipio sme -->                        
                                <div class="col-lg-12 form-group" id="dv_gruposme"> 

                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="text-align:left;">
                                        Dados da Escola
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


                                        <div class="form-group">
                                            <div  class="col-lg-2">
                                                <label for="nr_inep_escola">Inep escola</label>
                                                <input type="text"
                                                    name="nr_inep_escola"
                                                    id="nr_inep_escola"
                                                    tabindex="3"
                                                    placeholder="Inep escola"
                                                    class="form-control"
                                                    value="<?php if ($msg != 'success'){
                                                                    echo set_value('nr_inep_escola');
                                                            }?>"
                                                    onblur="pesquisa_inep();">
                                                    
                                            </div>
                                            <div class="col-lg-10">
                                                <label for="cd_escola">Escola</label>
                                                <select id="cd_escola" 
                                                        name="cd_escola" 
                                                        tabindex="4" 
                                                        class="form-control"
                                                        onchange="add_inep();">
                                                    <Option value="" nr_inep=""></Option>
                                   
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                            <?php if (set_value('nr_inep_escola')) { echo "populaescola('',$('#nr_inep_escola').val());"; } ?>
                                        </script>




                                        </div><!-- fim .panel-body -->
                                    </div><!-- fim .panel panel-default -->   

                                </div>
                                <!-- Fim div municipio sme-->

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
                                                            value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Município *</label>

                                                    <input  type="text"
                                                            disabled
                                                            class="form-control"
                                                            value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">
                                                    
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div  class="col-lg-2">
                                                    <label for="nr_inep_escola">Inep escola</label>
                                                    <input type="text"
                                                        name="nr_inep_escola"
                                                        id="nr_inep_escola"
                                                        tabindex="3"
                                                        placeholder="Inep escola"
                                                        class="form-control"
                                                        value="<?php echo set_value('nr_inep_escola') ?>"
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
                                                                    <?php if (set_value('cd_escola') == $item->ci_escola){
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

                            <?php }?> <!-- Fim grupo Escola -->
                    <!-- Div Parametros -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Adicionar Turma'?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="nm_turma">Nome *</label>
                                            <input type="text"
                                                name="nm_turma"
                                                id="nm_turma"
                                                tabindex="2"
                                                placeholder="Nome"
                                                class="form-control"
                                                value="<?php if ($msg != 'success'){
                                                                echo set_value('nm_turma');
                                                        }?>">
                                        </div>
                                        
                                    </div >
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="cd_etapa">Etapa *</label>
                                            <select id="cd_etapa" name="cd_etapa" tabindex="1" class="form-control">
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
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="cd_turno">Turno *</label>
                                            <select id="cd_turno" name="cd_turno" tabindex="1" class="form-control">
                                                <Option value=""></Option>
                                                <?php
                                                foreach ($turnos as $item) {
                                                    ?>
                                                    <Option value="<?php echo $item->ci_turno; ?>"
                                                        <?php if ((set_value('cd_turno') == $item->ci_turno) && ($msg != 'success')){
                                                            echo 'selected';
                                                        } ?> >
                                                        <?php echo $item->nm_turno; ?>
                                                    </Option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1    ">
                                        <div class="form-group">
                                            <label for="cd_ano_letivo">Ano Letivo *</label>
                                            <input type="text"
                                                name="nr_ano_letivo"
                                                id="nr_ano_letivo"
                                                tabindex="2"
                                                placeholder="Ano letivo"
                                                class="form-control"
                                                value="<?php if ($msg != 'success'){
                                                                echo set_value('nr_ano_letivo');
                                                        }?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                        
                                            <label for="nr_cpf">CPF Professor</label>
                                            <input type="hidden" name="cd_professor" id="cd_professor" value="">
                                            <input type="text"
                                                name="nr_cpf"
                                                id="cpf"
                                                tabindex="2"
                                                placeholder="CPF"
                                                class="form-control cpf"
                                                value="<?php if ($msg != 'success'){
                                                                echo set_value('nr_cpf');
                                                        }?>">
                                                
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
                                            <label for="nm_professor">Nome professor</label>                                        
                                            <input type="text"
                                                name="nm_professor"
                                                id="nm_professor"
                                                tabindex="2"
                                                disabled
                                                placeholder="Nome professor"
                                                class="form-control"
                                                value="<?php if ($msg != 'success'){
                                                                echo set_value('nm_professor');
                                                        }?>">
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                        
                                            <label id="">Tipo de turma *</label>
                                            <div class="form-control">
                                                <label class="radio-inline control-label" for="tp_turma_r">
                                                    <input type="radio" name="tp_turma" id="tp_turma_r" value="R" tabindex="3"
                                                        <?php if(
                                                            
                                                            ((set_value('tp_turma') == 'R') && ($msg != 'success')) || 
                                                            (set_value('tp_turma') == '')
                                                        ){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Regular
                                                </label>&nbsp;&nbsp;&nbsp;
                                                
                                                <label class="radio-inline control-label" for="tp_turma_m">
                                                    <input type="radio" name="tp_turma" id="tp_turma_m" value="M"  class="form-check-input" tabindex="4"
                                                        <?php if((set_value('tp_turma') == 'M') && ($msg != 'success')){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Multisseriada
                                                </label>&nbsp;&nbsp;&nbsp;

                                            </div>
                                        </div>
                                    </div> 
                                    
                                </div>
                                <div class="col-lg-12">

                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="24">
                                            Cadastrar
                                        </button>
                                        <button type="button" 
                                                tabindex="25"
                                                onclick="window.location.href ='<?php echo base_url('turma/turmas/index')?>';"
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
<script src="<?=base_url('assets/js/mask.telefone.js'); ?>"></script>
<script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>
<script type="text/javascript">
    $('#consultaProfessor').click(function(){
        populaprofessor($('#cpf').val(), $('#cd_professor'), $('#nm_professor'));
    });
</script>