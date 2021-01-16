<link href="<?=base_url('assets/css/cad_itens_avaliacoes.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/js/preview_imagens.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>

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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o nome da questão já está cadastrado no banco de dados!");
    </script>

    <?php
}
    echo form_open('avaliacao/avaliacoes/salvar',array('id'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data', 'onsubmit' => "selecionarAllOptions()"))
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
                    <!-- Div Cabecalho Menu -->                     
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#capa" data-toggle="tab" aria-expanded="false">
                                <span class="visible-xs"><i class="fa fa-capa"></i></span>
                                <span class="hidden-xs">Capa</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#itens" data-toggle="tab" aria-expanded="true">
                                <span class="visible-xs"><i class="fa fa-user"></i></span>
                                <span class="hidden-xs">Itens</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Fim Div Cabecalho Menu --> 
                    <div class="tab-content">
                        <!-- Div Menu CAPA--> 
                        <div class="tab-pane active" id="capa">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">

                                    <?php echo 'Capa ' ?>

                                    </div>
                                    <div class="panel-body">
                                        




                                        <div class="form-group col-lg-12">
                                            
                                            <div class="col-lg-2">
                                                <label for="nm_caderno">Caderno</label>
                                                <input type="text"
                                                        name="nm_caderno"
                                                        id="nm_caderno"
                                                        tabindex="1"
                                                        placeholder="Caderno"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php echo set_value('nm_caderno');?>">

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_avalia_tipo">Tipo de avaliação</label>
                                                <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="2" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($avalia_tiposs as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                                            <?php if ((set_value('cd_avalia_tipo') == $item->ci_avalia_tipo)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_avalia_tipo; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_edicao">Edicao</label>
                                                <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($edicoes as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_edicao; ?>"
                                                            <?php if (set_value('cd_edicao') == $item->ci_edicao){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_edicao; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <div class="col-lg-2">
                                                <label for="nr_ano">Ano</label>
                                                <input type="text"
                                                        name="nr_ano"
                                                        id="nr_ano"
                                                        tabindex="4"
                                                        placeholder="Ano"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php echo set_value('nr_ano');?>">

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_disciplina">Disciplina</label>
                                                <select id="cd_disciplina" name="cd_disciplina" tabindex="5" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($disciplinas as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_disciplina; ?>"
                                                            <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_disciplina; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-5">
                                                    <label for="cd_etapa">Etapa</label>
                                                <select id="cd_etapa" name="cd_etapa" tabindex="6" class="form-control">
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

                                        <div class="col-lg-12">
                                            <div class="col-lg-6">

                                                <div id="campo_imagem" >
                                                    <small class="text-info">
                                                        <i class="fa fa-info-circle"></i> 
                                                        Selecione o pdf da avaliação. 
                                                    </small>
                                                    <input  type="file"
                                                            id="ds_caminhoarquivo" 
                                                            name="ds_caminhoarquivo" 
                                                            class="form-control filestyle" 
                                                            data-buttonText="Adicionar pdf" 
                                                            data-iconName="fa fa-file-image-o"
                                                            accept="application/pdf"
                                                            tabindex="0"/>
                                                </div>                                        
                                            </div>

                                            <div class="col-lg-6">

                                                <div id="campo_imagem" >
                                                    <small class="text-info">
                                                        <i class="fa fa-info-circle"></i> 
                                                        Selecione o pdf do manual do aplicador. 
                                                    </small>
                                                    <input  type="file"
                                                            id="ds_arqvuio_aplicador" 
                                                            name="ds_arqvuio_aplicador" 
                                                            class="form-control filestyle" 
                                                            data-buttonText="Adicionar pdf" 
                                                            data-iconName="fa fa-file-image-o"
                                                            accept="application/pdf"
                                                            tabindex="0"/>
                                                </div>                                        
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <br/>
                                            <fieldset>
                                                <legend>Detalhamento das questões:</legend>                  
                                                <table class="table table-striped table-hover"  id="cols-avalia_matriz">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 60px;">Questão</th>
                                                            <th style="width: 150px;">Código</th>
                                                            <th>Descrição</th>
                                                            <th style="width: 60px;">Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align:middle; text-align: center;" id="cel-numeracao_1">
                                                                1ª)
                                                            </td>
                                                            <td><input type="text" name="ds_codigo_1"
                                                                                id="ds_codigo_1"
                                                                                tabindex="2"
                                                                                placeholder="Código"
                                                                                style="text-transform: uppercase;"
                                                                                class="form-control"
                                                                                onblur="atualiza_matriz(this.value, '', this, $('#cd_matriz_1'));"
                                                                                value="<?php echo set_value('ds_codigo');?>">
                                                            </td>
                                                            <td>
                                                                <select id="cd_matriz_1" 
                                                                        name="cd_matriz_1" 
                                                                        tabindex="1" 
                                                                        class="form-control"
                                                                        onchange="atualiza_matriz('', this.value, $('#ds_codigo_1'), this);"
                                                                        >
                                                                    <Option value=""></Option>
                                                                    <?php
                                                                    foreach ($matrizes as $item) {
                                                                    ?>
                                                                    <Option value="<?php echo $item->ci_matriz; ?>"
                                                                        <?php if ((set_value('cd_matriz') == $item->ci_matriz)){
                                                                            echo 'selected';
                                                                        } ?> >
                                                                        <?php echo $item->nm_matriz; ?>
                                                                    </Option>

                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td style="vertical-align:middle; text-align: center;">	     
                                                                <a  type="button" id="btn_remover_1"
                                                                    onclick="remove(this, 1)"
                                                                    class="btn btn-danger waves-effect waves-light btn-micro active" >
                                                                        Remover
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>	 
                                                        <tr>	   
                                                            <td colspan="5" style="text-align: left;">	    
                                                                <a  type="button" 
                                                                    class="btn btn-success waves-effect waves-light btn-micro active" 
                                                                    tabindex="21"
                                                                    onclick="AddTableRow();">
                                                                        Add questão
                                                                </a>   
                                                            </td>	 
                                                        </tr>	
                                                    </tfoot>
                                                </table>
                                                
                                            </fieldset>
                                        </div>





                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim div menu capa -->
                        <!-- div menu itens -->   
                        <div class="tab-pane" id="itens">
                                
                            <div class="col-lg-12">
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
                        </div>
                        <!-- Fim div menu itens -->

                        <div  align="right">
                            <button type="submit" 
                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                    tabindex="21">
                                Cadastrar
                            </button>
                            <button type="button" 
                                    tabindex="22"
                                    onclick="window.location.href ='<?php echo base_url('avaliacao_upload/avaliacao_uploads/index')?>';"
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


<?php
    echo form_close();
?>

<script>
var num_coluns = 1;

function renumera_questoes(numero_recebido){

if (numero_recebido == 1){
            
    num_coluns = 0;
}else{
    var proximo_numero = 1;
    for (i = 1; i < (num_coluns+1); i++) { 
        var linha_vez = i;
        var proximo_numero = i;

        if (i > numero_recebido){

            proximo_numero = i-1;
            alert('#cel-numeracao_'+linha_vez+' valor='+proximo_numero+' #btn_remover_'+linha_vez+' valor='+proximo_numero+' num_coluns='+num_coluns+' linha_vez='+linha_vez);
            
            var obj_td = $('#cel-numeracao_'+linha_vez);
            
            obj_td.text(proximo_numero + 'ª)');
            obj_td.prop('id', '#cel-numeracao_'+proximo_numero);

            var obj_btn_remover = $('#btn_remover_'+linha_vez);

            obj_btn_remover.attr("onclick","remove(this, "+proximo_numero+");");
            
        }
        

    }
    num_coluns = proximo_numero;
}
}

(function($) {	  
    remove = function(item, coluna_atual) {

        var tr = $(item).closest('tr');	
        
        tr.remove();
        renumera_questoes(coluna_atual);
        return false;
    }	
})(jQuery);

(function($) {	  


    AddTableRow = function() {	
        num_coluns++;
        $('#cel-numeracao_'+num_coluns).text(num_coluns + 'ª)');
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td style="vertical-align:middle; text-align: center;" id="cel-numeracao_'+num_coluns+'">'+num_coluns+'ª)</td>';
        cols += '<td><input type="text" name="ds_codigo" id="ds_codigo" tabindex="2" placeholder="Código" style="text-transform: uppercase;" class="form-control" value="<?php echo set_value('ds_codigo');?>"></td>';
        cols += '<td>';
        cols += '    <select id="cd_matriz" name="cd_matriz" tabindex="1" class="form-control">';
        cols += '        <Option value=""></Option>';

        cols += '    </select>';
        cols += '</td>';
        cols += '<td style="vertical-align:middle; text-align: center;">';
        cols += '   <a id="btn_remover_'+num_coluns+'" type="button"  onclick="remove(this, '+num_coluns+')" class="btn btn-danger waves-effect waves-light btn-micro active"> Remover </a>';
        cols += '</td>';

        newRow.append(cols);
        $("#cols-avalia_matriz").append(newRow);
            return false;	  
        };	
    }        
)(jQuery);


function atualiza_matriz(ds_codigo, cd_matriz, obj_codigo, obj_cd_matriz){
    var url_submeter  = $('#base_url').val()+'/ajax/matriz/getMatrizes';

    //alert('ds_codigo='+ds_codigo+'  cd_matriz='+cd_matriz);
    $.post(url_submeter, {
        ds_codigo  : ds_codigo,
        cd_matriz  : cd_matriz

        }, function (data) {
            if(ds_codigo != ''){
                obj_cd_matriz.html(data);
            }else{
                obj_codigo.val(data);
            }
        });

}


</script>