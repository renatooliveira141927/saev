<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o professor já está cadastrada no banco de dados!");
    </script>

    <?php
}
    echo form_open('professor/professores/salvar',array('id'=>'frm_professores','method'=>'post', 'enctype'=>'multipart/form-data'))
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

                               <?php echo 'Cadastrar professor ' ?>

                            </div>
                            <div class="panel-body">
                                <div class="col-lg-2">

                                    <div id="campo_imagem" style="display:none;" >
                                        <small class="text-info">
                                            <i class="fa fa-info-circle"></i> 
                                            Escolha um foto para o perfil do professor. 
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
                                    <div class="form-group col-lg-5">
                                        <label for="nm_professor">Nome *</label>
                                        <input type="text"
                                            name="nm_professor"
                                            id="nm_professor"
                                            tabindex="1"
                                            placeholder="Nome"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nm_professor');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="nr_cpf">CPF *</label>
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
                                    
                                    <div class="form-group col-lg-4">
                                        <label for="ds_telefone">Telefone</label>
                                        <input type="text"
                                            name="ds_telefone"
                                            id="telefone"
                                            tabindex="6"
                                            placeholder="Telefone"
                                            class="form-control telefone"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_telefone');
                                                    }?>">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="ds_email">E-mail *</label>
                                        <input type="text"
                                            name="ds_email"
                                            id="ds_email"
                                            tabindex="7"
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
                                                $dados['tabindex'] = '8';
                                                $this->load->view('include/data_calendario', $dados);
                                            ?>
                                        </div>
                                    </div>
                                    
                                </div >
                                
                                <div class="col-lg-10">
                                      
                                    <div class="col-lg-12 form-group">
                                        <fieldset>
                                            <label type="label" >Formação *</label>
                                            <div class="form-control ">
                                                <label class="radio-inline control-label" for="formacao_p">
                                                    <input  type="radio" 
                                                            class="form-check-input"
                                                            name="fl_formacao" 
                                                            id="formacao_p" 
                                                            value="P" 
                                                            tabindex="9" 
                                                            onclick="controlar_divs('');"
                                                        <?php if(set_value('fl_formacao') == 'P'){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Pedagogia
                                                </label>

                                                <label class="radio-inline control-label" for="formacao_lo">
                                                    <input  type="radio" 
                                                            class="form-check-input"
                                                            name="fl_formacao" 
                                                            id="formacao_lo" 
                                                            value="LO" 
                                                            tabindex="11" 
                                                            onclick="controlar_divs('LO');"
                                                        <?php if(set_value('fl_formacao') == 'LO'){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Licenciatura em outras áreas
                                                </label>

                                                <label class="radio-inline control-label" for="formacao_m">
                                                    <input  type="radio" 
                                                            class="form-check-input"
                                                            name="fl_formacao" 
                                                            id="formacao_m" 
                                                            value="M" 
                                                            tabindex="12" 
                                                            onclick="controlar_divs('');"
                                                        <?php if(set_value('fl_formacao') == 'M'){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Magistério nível médio
                                                </label>

                                                <label class="radio-inline control-label" for="formacao_o" >
                                                    <input  type="radio" 
                                                            class="form-check-input"
                                                            name="fl_formacao" 
                                                            id="formacao_o" 
                                                            value="O" 
                                                            tabindex="13" 
                                                            onclick="controlar_divs('O');"
                                                        <?php if(set_value('fl_formacao') == 'O'){
                                                            echo 'checked'; }
                                                            ?>>
                                                    Outros
                                                </label>
                                        </fieldset>
                                        <script>
                                            function controlar_divs(opcao){
                                                if (opcao == 'LO'){
                                                    outra_formacao(true);
                                                    nm_formacao_letras(false);
                                                }
                                                else if (opcao == 'O'){
                                                    nm_formacao_letras(true);
                                                    outra_formacao(false);
                                                }else{
                                                    nm_formacao_letras(true);
                                                    outra_formacao(true);
                                                }
                                            }
                                            function outra_formacao(desabilitar){
                                                if (desabilitar){
                                                    $("#dv_outra_formacao").hide();
                                                }else{
                                                    $("#dv_outra_formacao").show();
                                                }

                                            }
                                            function nm_formacao_letras(desabilitar){
                                                if (desabilitar){
                                                    $("#dv_nm_formacao_letras").hide();
                                                }else{
                                                    $("#dv_nm_formacao_letras").show();
                                                }

                                            }                                           
                                        </script>
                                    </div>

                                </div>
                                <div class="form-group col-lg-12" id="dv_outra_formacao" 
                                
                                    <?php if(set_value('fl_formacao') != 'O'){ ?>
                                        style="display:none;"
                                    <?php } ?>>
                                    <label for="ds_outra_formacao">Nome da outra formação</label>
                                    <input type="text"
                                        name="ds_outra_formacao"
                                        id="ds_outra_formacao"
                                        tabindex="14"
                                        placeholder="Nome da outra formação"
                                        
                                        class="form-control"
                                        value="<?php if ($msg != 'success'){
                                                        echo set_value('ds_outra_formacao');
                                                }?>">
                                </div>
                                <div class="form-group col-lg-12" id="dv_nm_formacao_letras" 
                                
                                    <?php if(set_value('fl_formacao') != 'LO'){ ?>
                                        style="display:none;"
                                    <?php } ?>>
                                    <label for="nm_formacao_letras">Nome da formação em letras</label>
                                    <input type="text"
                                        name="nm_formacao_letras"
                                        id="nm_formacao_letras"
                                        tabindex="14"
                                        placeholder="Nome da formação em letras"
                                        
                                        class="form-control"
                                        value="<?php if ($msg != 'success'){
                                                        echo set_value('ds_outra_formacao');
                                                }?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <div class="col-lg-2">
                                        <label for="nr_cep">CEP</label>
                                        <input type="text"
                                            name="nr_cep"
                                            id="nr_cep"
                                            tabindex="15"
                                            placeholder="CEP"
                                            class="form-control cep"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('nr_cep');
                                                    }?>">
                                    </div>
                                    <div class="col-lg-4">
                                            
                                        <div >
                                            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                            <label>Estado *</label>
                                            <select id="cd_estado" 
                                                    name="cd_estado" 
                                                    tabindex="16"
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
                                                    tabindex="17"                                                    
                                                    class="form-control" disabled>
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
                                            tabindex="18"
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
                                            tabindex="19"
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
                                            tabindex="20"
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
                                            tabindex="21"
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
                                            tabindex="22"
                                            placeholder="Referência"
                                            class="form-control"
                                            value="<?php if ($msg != 'success'){
                                                            echo set_value('ds_referencia');
                                                    }?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    
                                    <div  align="right">
                                        <button type="submit" 
                                                class="btn btn-custom waves-effect waves-light btn-micro active" 
                                                tabindex="23">
                                            Cadastrar
                                        </button>
                                        <button type="button" 
                                                tabindex="24"
                                                onclick="window.location.href ='<?php echo base_url('professor/professores/index')?>';"
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