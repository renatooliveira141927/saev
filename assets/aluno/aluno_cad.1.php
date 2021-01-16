<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/cep_endereco.js'); ?>"></script>

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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o(a) aluno(a) já está cadastrado(a) no banco de dados!");
    </script>

    <?php
}
    echo form_open('aluno/alunos/salvar',array('id'=>'frm_alunos','method'=>'post', 'enctype'=>'multipart/form-data'))
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
                    <!-- Div Parametros -->
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Cadastrar aluno ' ?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-2">

                                    <div id="campo_imagem" style="display:none;" >
                                        <small class="text-info">
                                            <i class="fa fa-info-circle"></i> 
                                            Escolha um foto para o perfil do aluno. 
                                        </small>
                                        <input  type="file" 
                                                id="img" 
                                                name="img" 
                                                class="form-control filestyle" 
                                                data-buttonText="Adicionar imagem" 
                                                data-iconName="fa fa-file-image-o"
                                                accept="image/png, image/jpeg"
                                                tabindex="0"
                                                onchange="readURL(this,'img_preview');"
                                                value="<?php if ($msg != 'success'){
                                                        echo set_value('img');}?>"/>
                                    </div>
                                    <input type="hidden" id="hidden_img_preview" name="hidden_img_preview">
                                    <a href="#" onclick="$('#img').click();">
                                        <img  type="button"  id="img_preview" 
                                                src="
                                                    <?php 
                                                        if (set_value('hidden_img_preview')){ 
                                                            echo set_value('hidden_img_preview');
                                                        }else{ 
                                                            echo base_url("assets/img/semFoto.png");
                                                        }
                                                    ?>"
                                                class="img-thumbnail"  
                                                style="width:200px;height:200px;">
                                    </a>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-group col-lg-2">
                                        <label for="nr_inep">Inep</label>
                                        <input type="text"
                                            name="nr_inep"
                                            id="inep"
                                            tabindex="1"
                                            placeholder="Inep"
                                            class="form-control inep"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_inep');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="nm_aluno">Nome *</label>
                                        <input type="text"
                                            name="nm_aluno"
                                            id="nm_aluno"
                                            tabindex="2"
                                            placeholder="Nome"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_aluno');
                                                    }?>">
                                    </div>
                                    
                                    <div class="form-group col-lg-5">
                                        
                                        <label id="">Sexo *</label>
                                        <div class="form-control">
                                            <label class="radio-inline control-label" for="sexo_m">
                                                <input type="radio" name="fl_sexo" id="sexo_m" value="M" tabindex="3"
                                                    <?php if((set_value('fl_sexo') == 'M') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Masculino
                                            </label>&nbsp;&nbsp;&nbsp;
                                            
                                            <label class="radio-inline control-label" for="sexo_f">
                                                <input type="radio" name="fl_sexo" id="sexo_f" value="F"  class="form-check-input" tabindex="4"
                                                    <?php if((set_value('fl_sexo') == 'F') && ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Feminino
                                            </label>&nbsp;&nbsp;&nbsp;

                                            <label class="radio-inline control-label" for="sexo_o">
                                                <input type="radio" name="fl_sexo" id="sexo_o" value="O"  class="form-check-input" tabindex="5"
                                                    <?php if((set_value('fl_sexo') == 'O')&& ($msg != 'success')){
                                                        echo 'checked'; }
                                                        ?>>
                                                Outros
                                            </label>
                                        </div>
                                    </div>     
                                </div >
                                <div class="col-lg-10">

                                    <div class="form-group col-lg-6">
                                        <label for="nm_mae">Nome da mãe *</label>
                                        <input type="text"
                                            name="nm_mae"
                                            id="nm_mae"
                                            tabindex="6"
                                            placeholder="Nome da mãe"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_mae');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="nm_pai">Nome do pai</label>
                                        <input type="text"
                                            name="nm_pai"
                                            id="nm_pai"
                                            tabindex="7"
                                            placeholder="Nome do pai"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_pai');
                                                    }?>">
                                    </div>

                                </div>
                                <div class="col-lg-10">

                                    <div class="form-group col-lg-6">
                                        <label for="nm_responsavel">Nome do responsável</label>
                                        <input type="text"
                                            name="nm_responsavel"
                                            id="nm_responsavel"
                                            tabindex="8"
                                            placeholder="Nome do responsável"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_responsavel');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone1">Telefone 1 *</label>
                                        <input type="text"
                                            name="ds_telefone1"
                                            id="telefone1"
                                            tabindex="9"
                                            placeholder="Telefone 1"
                                            class="form-control telefone"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_telefone1');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <label for="ds_telefone2">Telefone 2</label>
                                        <input type="text"
                                            name="ds_telefone2"
                                            id="telefone2"
                                            tabindex="10"
                                            placeholder="Telefone 2"
                                            class="form-control telefone"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_telefone2');
                                                    }?>">
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group col-lg-8">
                                        <label for="ds_email">E-mail</label>
                                        <input type="text"
                                            name="ds_email"
                                            id="ds_email"
                                            tabindex="11"
                                            placeholder="E-mail"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_email');
                                                    }?>">
                                        
                                    </div>
                                                
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Data de nascimento *</label>
                                            <?php

                                                $data = '';
                                                if ($msg != 'success'){
                                                    $data = set_value('txt_data');
                                                }

                                                $data1 = '';

                                                if ($data != '') {

                                                    $data = DateTime::createFromFormat('d/m/Y', $data);
                                                    $data1 = $data->format('m/d/Y');
                                                }
                                                $dados['data'] = $data1;
                                                $dados['tabindex'] = '12';

                                                $this->load->view('include/data_calendario', $dados);
                                            ?>

                                        </div>
                                    </div>
                                    
                                </div >
                                
                                
                                
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-2">
                                        <label for="nr_cep">CEP</label>
                                        <input type="text"
                                            name="nr_cep"
                                            id="nr_cep"
                                            tabindex="13"
                                            placeholder="CEP"
                                            class="form-control cep"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_cep');
                                                    }?>"
                                                    onchange="populaescola('','');">
                                    </div>
                                    <div class="col-lg-4">
                                            
                                        <div >
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                            <label>Estado *</label>
                                            <select id="cd_estado" 
                                                    name="cd_estado" 
                                                    tabindex="14"
                                                    class="form-control" 
                                                    onchange="populacidade(this.value)">

                                                <?php echo $estado ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div >
                                            <label>Município *</label>
                                            <select id="cd_cidade" 
                                                    name="cd_cidade" 
                                                    tabindex="15"                                                    
                                                    class="form-control" disabled
                                                    onchange="populaescola(this.value,$('#nr_inep').val());">
                                                <option value="">Selecione o estado</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="ds_rua">Rua</label>
                                        <input type="text"
                                            name="ds_rua"
                                            id="ds_rua"
                                            tabindex="16"
                                            placeholder="Rua"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_rua');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="nr_residencia">Número</label>
                                        <input type="text"
                                            name="nr_residencia"
                                            id="nr_residencia"
                                            tabindex="17"
                                            placeholder="Número"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_residencia');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="ds_bairro">Bairro</label>
                                        <input type="text"
                                            name="ds_bairro"
                                            id="ds_bairro"
                                            tabindex="18"
                                            placeholder="Bairro"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_bairro');
                                                    }?>">
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="ds_complemento">Complemento</label>
                                        <input type="text"
                                            name="ds_complemento"
                                            id="ds_complemento"
                                            tabindex="19"
                                            placeholder="Complemento"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_complemento');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ds_referencia">Ponto de referência</label>
                                        <input type="text"
                                            name="ds_referencia"
                                            id="ds_referencia"
                                            tabindex="20"
                                            placeholder="Referência"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_referencia');
                                                    }?>">
                                    </div>
                                </div>                                
                                    <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados -->
                                        <div class="form-group col-lg-12">
                                            <div  class="col-lg-2">
                                                <label for="nr_inep_escola">Inep escola</label>
                                                <input type="text"
                                                    name="nr_inep_escola"
                                                    id="nr_inep_escola"
                                                    tabindex="21"
                                                    placeholder="Inep escola"
                                                    class="form-control"
                                                    value="<?php if ($msg != 'success'){
                                                                    echo set_value('nr_inep_escola');
                                                            }?>"
                                                    onchange="populaescola($('#cd_cidade').val(),this.value);">
                                                    
                                            </div>
                                            <div class="col-lg-10">
                                                <label for="cd_escola">Escola</label>
                                                <select id="cd_escola" name="cd_escola" tabindex="1" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($escolas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_escola; ?>"
                                                            <?php if ((set_value('cd_escola') == $item->ci_escola) && ($msg != 'success')){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_escola; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }else{?> <!-- Se o usuário for administrados -->
                                        <input type="hidden" name="cd_escola" value="<?php echo $this->session->userdata('ci_escola')?>">
                                    <?php }?> <!-- Se o usuário for administrados -->

                                </div>
                                <!-- <div class="col-lg-12">
                                    <div class="form-group">
                                        
                                        <1?php
                                            $this->load->view('include/gerar_lista_selecao_escola');
                                        ?>

                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="21">
                                            Cadastrar
                                        </button>
                                        <button type="button" 
                                                tabindex="22"
                                                onclick="window.location.href ='<?php echo base_url('aluno/alunos/index')?>';"
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