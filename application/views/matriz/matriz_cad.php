
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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o nome da matriz já está cadastrado no banco de dados!");
    </script>

    <?php
}
    echo form_open('matriz/matrizes/salvar',array('id'=>'frm_matrizes','method'=>'post', 'enctype'=>'multipart/form-data'))
?>
<style>
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
    legend
    {
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 100px; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #ffffff;
    }
</style>

<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">MATRIZ DE REFERÊNCIA</h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">

                    <div class="tab-content">
                        <!-- Div Menu CAPA--> 
                        <div class="tab-pane active" id="capa">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                    Cadastro de matriz de referência

                                    </div>
                                    <div class="panel-body">                                      
                                        <div class="form-group col-lg-12">

                                            <div class="col-lg-12">
                                                <label for="nm_matriz">Nome *</label>
                                                <input  type="text"
                                                        name="nm_matriz"
                                                        id="nm_matriz"
                                                        tabindex="2"
                                                        placeholder="Nome da matriz"
                                                        class="form-control"
                                                        value="<?php    if (($msg != 'success') && (set_value('nm_matriz'))){
                                                                            echo set_value('nm_matriz');
                                                                        }
                                                                    ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">

                                            <div class="col-lg-6">
                                                <label for="cd_disciplina">Disciplina *</label>
                                                <select id="cd_disciplina" name="cd_disciplina" tabindex="5" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($disciplinas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_disciplina; ?>"
                                                            <?php if (($msg != 'success') && (set_value('cd_disciplina') == $item->ci_disciplina)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_disciplina; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                    <label for="cd_etapa">Etapa *</label>
                                                <select id="cd_etapa" 
                                                        name="cd_etapa" 
                                                        tabindex="6" 
                                                        class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($etapas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_etapa; ?>"
                                                            <?php if (($msg != 'success') && (set_value('cd_etapa') == $item->ci_etapa)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_etapa; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        
                                        <div class="col-lg-12" id="dv_matriz">
                                            <!-- <div>
                                                <br/>
                                                <fieldset class="field-body">
                                                    <legend>Tópico I</legend>
                                                    <table class="table table-striped table-hover"  id="table-matriz_topico">                                                  
                                                        <tbody>
                                                            <tr style="width: 100%;">                                                            
                                                                <td colspan="2" >
                                                                    <input  type="text"
                                                                        name="nm_matriz_topico[]"
                                                                        id="nm_matriz_topico"
                                                                        tabindex="2"
                                                                        placeholder="Nome do tópico"
                                                                        class="form-control"
                                                                        value="">
                                                                </td>
                                                            </tr>
                                                            <tr style="width: 100%;">
                                                                    <table class="table table-striped table-hover"  id="table-avalia_matriz-1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th colspan="2" style="width: 60px; vertical-align:middle; text-align: center;">Descritores</th>
                                                                                
                                                                                <th colspan="2" style="width: 60px; vertical-align:middle; text-align: center;">Ação</th>                                                                            
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="teste">
                                                                             <tr>
                                                                                <td style="width: 100px;">
                                                                                    <input type="text"
                                                                                        name="ds_codigo-1[]"
                                                                                        id="ds_codigo"
                                                                                        tabindex="2"
                                                                                        placeholder="Código"
                                                                                        class="form-control"    
                                                                                        value="">   
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="nm_matriz_descritor-1[]"
                                                                                        id="nm_matriz_descritor"
                                                                                        tabindex="2"
                                                                                        placeholder="Nome do descritor"
                                                                                        class="form-control"
                                                                                        value="">
                                                                                </td>
                                                                                <td style="vertical-align:middle; text-align: center; width:20px;">
                                                                                    <a  type="button"  class="btn btn-success waves-effect waves-light btn-micro active" onclick="AddTableRow('1');">Add</a>
                                                                                </td>
                                                                                <td style="vertical-align:middle; text-align: center; width:20px;">
                                                                                    <a type="button"  onclick="remove(this)" class="btn btn-danger waves-effect waves-light btn-micro active"> Rem</a>
                                                                                </td>
                                                                            </tr> 
                                                                        </tbody>
                                                                        <tfoot>	 
                                                                            <tr>	   
                                                                                <td colspan="4" style="text-align: left;">	    
                                                                                        
                                                                                </td>	 
                                                                            </tr>	
                                                                        </tfoot>
                                                                    </table>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>	 
                                                            <tr style="width: 100%;">	   
                                                                <td style="text-align: left;">	    
                                                                    <a  type="button" 
                                                                        class="btn btn-success waves-effect waves-light btn-micro active" 
                                                                        tabindex="21"
                                                                        onclick="AddTableTitulo('');">
                                                                            Add tópico
                                                                    </a>   
                                                                </td>	
                                                                <td style="text-align: left;">	    
                                                                    <a type="button"  onclick="remove(this)" class="btn btn-danger waves-effect waves-light btn-micro active"> Remover tópico</a>   
                                                                </td> 
                                                            </tr>	
                                                        </tfoot>
                                                    </table>
                                                </fieldset>
                                            </div> -->

                                        </div>                                        
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <!-- Fim div menu capa -->
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                        <div  align="right">
                            <button type="submit" 
                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                    tabindex="21">
                                Cadastrar
                            </button>
                            <button type="button" 
                                    tabindex="22"
                                    onclick="window.location.href ='<?php echo base_url('matriz/matrizes/index')?>';"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                    Voltar
                            </button>
                    
                        </div>
                            
                    </div>
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>
</div>

<script src="<?=base_url('assets/js/matrizes.js'); ?>"></script>

<?php if (($msg != 'success') && (set_value('nm_matriz_topico'))){ ?>

<script>
<?php

    $arr_topicos     = set_value('nm_matriz_topico');
    $str_descritores = '';
    $x = 0;

    foreach ($arr_topicos as $i => $value){ 

        $arr_codigo = set_value('ds_codigo-'.($i+1));
        $arr_nome   = set_value('nm_matriz_descritor-'.($i+1)); 

        // echo 'alert("topico='.$value.'");';
        echo "AddTableTitulo('".$value."');";

        foreach ($arr_codigo as $y => $vl_codigo){ // Criando array descritores
            $x++;
            // echo 'alert("$arr_nome[$y]='.$arr_nome[$y].'");';
            echo "AddTableRow('".($i+1)."', '".$vl_codigo."', '".$arr_nome[$y]."');";

        }
    }

    ?>
    </script>
    <?php
}else{
    ?>
    <script>
        AddTableTitulo('');
        //AddTableRow(1);
    </script>
<?php
}   
    echo form_close();    
?>
