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
    echo form_open('matriz/matrizes/salvar',array('id'=>'frm_matrizes','method'=>'post', 'enctype'=>'multipart/form-data'));
    foreach ($matrizes as $result) {
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

    <div id="carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Administrar matrizes</h3>

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

                                    Cadstro de matriz de referência

                                    </div>
                                    <div class="panel-body">                                      
                                        <div class="form-group col-lg-12">

                                            <div class="col-lg-12">
                                                <input  type="hidden" 
                                                        name="ci_matriz"
                                                        id="ci_matriz"
                                                        value="<?php echo $result->ci_matriz ?>">

                                                <label for="nm_matriz">Nome *</label>
                                                <input  type="text"
                                                        name="nm_matriz"
                                                        id="nm_matriz"
                                                        tabindex="2"
                                                        placeholder="Nome da matriz"
                                                        class="form-control"
                                                        value="<?php echo $result->nm_matriz ?>">
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
                                                            <?php if ($result->cd_disciplina == $item->ci_disciplina){
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
                                                            <?php if ($result->cd_etapa == $item->ci_etapa){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_etapa; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        
                                        <div class="col-lg-12" id="dv_matriz"></div>
                                                                                
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <!-- Fim div menu capa -->
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                        <div  align="right">                            
                            <?php foreach ($matrizavaliacao as $value) {
                                if ($value->id>=1){?>
                                 <label class="btn btn-success waves-effect waves-light btn-micro active">
                                     Esta Matriz está sendo usada por uma Avaliação portanto não
                                     poderá ser Alterada
                                 </label>
                            <?php }else{?>
                                <button type="submit" 
                                    class="btn btn-custom waves-effect waves-light btn-micro active" 

                                    tabindex="21">
                                Atualizar
                            </button>
                            <?php }
                            }?>
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

<?php if (count($descritores) > 0){ ?>

<script>
<?php

    $nm_matriz_topico = '';
    $cd_matriz_topico = '';
    $num_topicos = 0;

    foreach ($descritores as $i => $descritor){
    
        if ($cd_matriz_topico != $descritor->ci_matriz_topico){
            
            $cd_matriz_topico = $descritor->ci_matriz_topico;
            $nm_matriz_topico = $descritor->nm_matriz_topico;

            echo "AddTableTitulo('".$nm_matriz_topico."');";
            $num_topicos++;
        }
        $ds_codigo = $descritor->ds_codigo;
        $nm_matriz_descritor = $descritor->nm_matriz_descritor;
        $caed = $descritor->ds_descritorcaed;
        $id = $descritor->ci_matriz_descritor;

        echo "AddTableRow('".$num_topicos."', '".$ds_codigo."', '".$nm_matriz_descritor."', '".$caed."', '".$id."');";

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
}
    echo form_close();    
?>
