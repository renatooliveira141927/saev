<link href="<?=base_url('assets/css/cad_itens_avaliacoes.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/datas_comparar.js'); ?>"></script>
<link href="<?=base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" media="screen">

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
    echo form_open('avaliacao_upload/avaliacao_uploads/salvar',array('id'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data'))
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
                                <span class="hidden-xs">Avaliação</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#itens" data-toggle="tab" aria-expanded="true">
                                <span class="visible-xs"><i class="fa fa-user"></i></span>
                                <span class="hidden-xs">Municípios</span>
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
                                                <label for="nm_caderno">Nome do Caderno *</label>
                                                <input type="text"
                                                        name="nm_caderno"
                                                        id="nm_caderno"
                                                        tabindex="1"
                                                        placeholder="Caderno"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php if ($msg != 'success'){ echo set_value('nm_caderno'); }?>">

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_avalia_tipo">Tipo de avaliação *</label>
                                                <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="2" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($avalia_tipos as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                                            <?php if (($msg != 'success') && (set_value('cd_avalia_tipo') == $item->ci_avalia_tipo)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_avalia_tipo; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_edicao">Edição *</label>
                                                <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($edicoes as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_edicao; ?>"
                                                            <?php if (($msg != 'success') && (set_value('cd_edicao') == $item->ci_edicao)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_edicao; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <!-- <div class="col-lg-2">
                                                <label for="nr_ano">Ano *</label>
                                                <input type="text"
                                                        name="nr_ano"
                                                        id="nr_ano"
                                                        tabindex="4"
                                                        placeholder="Ano"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php echo set_value('nr_ano');?>">

                                            </div> -->
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
                                                        class="form-control" 
                                                        onchange="carrega_matriz($('#cd_disciplina').val(),this.value,$('#ci_matriz').val(),$('#cd_avalia_tipo').val());">
                                                    <Option value=""></Option>
                                                    <?php foreach ($etapas as $item) {
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

                                            <div class="col-lg-6">
                                                <label for="ci_matriz">Matriz *</label>
                                                	<select id="ci_matriz" name="ci_matriz" tabindex="8" class="form-control" disabled
                                                        onchange="gerar_matrizes($('#cd_disciplina').val(),$('#cd_etapa').val(),'','',this.value,'',$('#cd_avalia_tipo').val())">                                                        						
                                                        <option value="0">Selecione a Matriz</option>                                                    </select>
                                            </div>                        
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-lg-6">

                                                <div id="campo_imagem" >
                                                    <small class="text-info">
                                                        <i class="fa fa-info-circle"></i> 
                                                        Selecione o pdf da avaliação.  *
                                                    </small>
                                                    <input  type="file"
                                                            id="ds_arquivo_avaliacao" 
                                                            name="ds_arquivo_avaliacao" 
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
                                                        Selecione o pdf do manual do aplicador.  *
                                                    </small>
                                                    <input  type="file"
                                                            id="ds_arquivo_aplicador" 
                                                            name="ds_arquivo_aplicador" 
                                                            class="form-control filestyle" 
                                                            data-buttonText="Adicionar pdf" 
                                                            data-iconName="fa fa-file-image-o"
                                                            accept="application/pdf"
                                                            tabindex="0"/>
                                                </div>                                        
                                            </div>
                                        </div>
                                        <div class="col-lg-12" id="dv_matriz" style="display:none;">
                                            <br/>
                                            <fieldset>
                                                <legend>Detalhamento das questões:</legend>                  
                                                <table class="table table-striped table-hover"  id="table-avalia_matriz">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 60px;">Questão</th>
                                                            <th style="width: 100px;">Correta</th>
                                                            <th style="width: 150px;">Código</th>
                                                            <th>Descrição</th>
                                                            <th style="width: 60px;">Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- <tr>
                                                            <td style="vertical-align:middle; text-align: center;" id="cel-numeracao_1">
                                                                1ª
                                                            </td>
                                                            <td><input type="text" name="ds_codigo_1"
                                                                                id="ds_codigo_1"
                                                                                tabindex="2"
                                                                                placeholder="Código"
                                                                                style="text-transform: uppercase;"
                                                                                class="form-control"
                                                                                onblur="atualiza_matriz(this, 'CODIGO');"
                                                                                value="<1?php echo set_value('ds_codigo');?>">
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <select id="cd_matriz_1" 
                                                                            name="cd_matriz_1" 
                                                                            tabindex="1" 
                                                                            class="form-control"
                                                                            onchange="atualiza_matriz(this, 'COMBO');"
                                                                            >
                                                                        <Option value=""></Option>
                                                                     
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align:middle; text-align: center;">	     
                                                                <a  type="button" id="btn_remover_1"
                                                                    onclick="remove(this)"
                                                                    class="btn btn-danger waves-effect waves-light btn-micro active" >
                                                                        Remover
                                                                </a>
                                                            </td>
                                                        </tr> -->
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
                            <div >                                
                                <div class="col-lg-12">                                
                                        <div class="col-lg-2">                                            
                                            <div class="form-group">
                                                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                                                <label>Estados </label>
                                                <select id="cd_estado" 
                                                        name="cd_estado" 
                                                        tabindex="14"
                                                        class="form-control" 
                                                        onchange="populacidade(this.value, '', '', false)">
                                                    <?php echo $estado ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div  class="form-group">
                                                <label>Municípios </label>
                                                <select id="cd_cidade" 
                                                        name="cd_cidade" 
                                                        tabindex="15"
                                                        class="form-control" >
                                                </select>
                                            </div>
                                        </div>                                    
                                        <div class='col-lg-2'>
                                            <div class="form-group">
                                                <label>Liberar Caderno em: </label>
                                                <div class='input-group date' id='div_dt_caderno'>
                                                    <input  type='text' 
                                                                class="form-control" 
                                                                id='dt_caderno'
                                                                name='dt_caderno'/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>                    
                                        <div class='col-lg-2'>
                                            <div class="form-group">
                                                <label>(Início)Lançar gabarito inicia:</label>
                                                    <div class='input-group date' id='div_dt_inicio'>
                                                        <input  type='text' 
                                                                class="form-control" 
                                                                id='dt_inicio'
                                                                name='dt_inicio'/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class='col-lg-2'>
                                            <div class="form-group">
                                                <label>(Fim)Lançar gabarito termina: </label>
                                                    <div class='input-group date' id='div_dt_final'>
                                                        <input  type='text' 
                                                                class="form-control" 
                                                                id='dt_final'
                                                                name='dt_final'/>

                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class='col-lg-2'>
                                            <div class="form-group">
                                                <a  type="button" 
                                                    class="btn btn-success waves-effect waves-light btn-micro active"
                                                    onclick="addItemTabela()">Adicionar
                                                </a>           
                                            </div>
                                        </div>                                                                                                     
                                </div>                          
                            <!-- Fim div menu itens -->
                                <div class="col-lg-12">
                                    <table id="datasMunicipios"  class="table table-striped table-hover">
                                    <tr>                 
                                            <th>Estado</th>
                                            <th>Município</th>
                                            <th>Liberar Caderno</th>
                                            <th>(Início)Lançar gabarito</th>
                                            <th>(Fim)Lançar gabarito</th>
                                            <th></th>
                                    </tr>                                  
                                    </table>
                                </div>
                            </div>                                    
                        </div>
                    </div>
                    <div>                                              
                        <!-- Submit e voltar gera da página -->
                        <div  align="right">
                            <a type="button" 
                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                    tabindex="21"
                                    onclick="validar_form();">
                                Cadastrar
                            </a>
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
<script type="text/javascript" src="<?=base_url('assets/js/bootstrap-datetimepicker.js'); ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url('assets/js/locales/bootstrap-datetimepicker.pt-BR.js'); ?>" charset="UTF-8"></script>

<script src="<?=base_url('assets/js/avaliacao_upload.js'); ?>"></script>

<script type="text/javascript">
    function validar_form(){
                
        var caderno = $('#nm_caderno').val();
        var tipoAvaliacao  = $('#cd_avalia_tipo').val();
        var edicao  = $('#cd_edicao').val();
        var disciplina  = $('#cd_disciplina').val();    
        var etapa  = $('#cd_etapa').val();            
        var matriz  = $('#ci_matriz').val();


        if ( ((caderno!="") && (tipoAvaliacao!="")  && (disciplina!="")  && (etapa!="")&& (edicao!="")&& ( matriz!="")) ){            
                $('#frm_avaliacoes').submit();            
        }else{
                alert("Verifique o preenchimento dos campos com (*) asterísco!");
        }
    }
    $(function () {
        $("#dt_inicio").mask("99/99/9999", {
            completed: function () {
                console.log('complete')
                var value = $(this).val().split('/');
                var maximos = [31, 12, 2100];
                var novoValor = value.map(function (parcela, i) {
                    if (parseInt(parcela, 10) > maximos[i]) return maximos[i];
                    return parcela;
                });
                if (novoValor.toString() != value.toString()) $(this).val(novoValor.join('/')).focus();
            }
        });
        $("#dt_final").mask("99/99/9999", {
            completed: function () {
                console.log('complete')
                var value = $(this).val().split('/');
                var maximos = [31, 12, 2100];
                var novoValor = value.map(function (parcela, i) {
                    if (parseInt(parcela, 10) > maximos[i]) return maximos[i];
                    return parcela;
                });
                if (novoValor.toString() != value.toString()) $(this).val(novoValor.join('/')).focus();
            }
        });

        $('#div_dt_caderno').datetimepicker({
            language:  'pt-BR',
            format:  'dd/mm/yyyy',        
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });

        $('#div_dt_inicio').datetimepicker({
            language:  'pt-BR',
            format:  'dd/mm/yyyy',        
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        $('#div_dt_final').datetimepicker({
            language:  'pt-BR',
            format:  'dd/mm/yyyy',        
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            useCurrent: false //Important! See issue #1075
        });
    });
</script>
<?php
    if (($msg != 'success') && (set_value('cd_matriz')) ){
        $cd_diciplina = set_value('cd_diciplina');
        $cd_etapa     = set_value('cd_etapa');        
        $cd_matriz       = implode('|', set_value('cd_matriz'));
        $ds_codigo       = implode('|', set_value('ds_codigo'));
        $nr_opcaocorreta = implode('|', set_value('nr_opcaocorreta'));
        
?>
        <script>
            carrega_matriz('<?php echo $cd_diciplina ?>', '<?php echo $cd_etapa ?>', '<?php echo $nr_opcaocorreta ?>', '<?php echo $ds_codigo ?>', '<?php echo $ci_matriz ?>','<?php echo $cd_avalia_tipo?>');
            gerar_matrizes('<?php echo $cd_diciplina ?>', '<?php echo $cd_etapa ?>', '<?php echo $nr_opcaocorreta ?>', '<?php echo $ds_codigo ?>', '<?php echo $cd_matriz ?>','<?php echo $cd_avalia_tipo?>');
        </script>
<?php
    }
    echo form_close();    
?>
