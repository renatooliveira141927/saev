<link href="<?=base_url('assets/css/cad_itens_avaliacoes.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/datas_comparar.js'); ?>"></script>
<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<link href="<?=base_url('assets/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" media="screen">
<style>
.containerbotao {
  height: 80px;
  position: relative;
}

.vertical-centerbotao {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
.red {
	color: red;
}
</style>
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
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o nome do caderno já está cadastrado no banco de dados!");
    </script>

    <?php
}else if($msg == "alteracao_nao_realizada"){
    ?>

    <script type="text/javascript">
        mensagem_sucesso("error" , "Não foi possível realizar a alteração, pois, os dados necessários não foram declarados!");
    </script>

    <?php
}
    echo form_open('avaliacao_upload/avaliacao_uploads/salvar',array('id'=>'frm_avaliacoes','method'=>'post', 'enctype'=>'multipart/form-data'));
    foreach ($registros as $result) {        
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

                                        <input type="hidden" id="ci_avaliacao_upload" name="ci_avaliacao_upload" value="<?php echo $result->ci_avaliacao_upload?>">

                                            <div class="col-lg-2">
                                                <label for="nm_caderno">Caderno *</label>
                                                <input type="text"
                                                        name="nm_caderno"
                                                        id="nm_caderno"
                                                        tabindex="1"
                                                        placeholder="Caderno"
                                                        style="text-transform: uppercase;"
                                                        class="form-control"
                                                        value="<?php echo $result->nm_caderno?>">

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_avalia_tipo">Tipo de avaliação *</label>
                                                <select id="cd_avalia_tipo" name="cd_avalia_tipo" tabindex="2" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($avalia_tipos as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_avalia_tipo; ?>"
                                                            <?php if (($result->cd_avalia_tipo == $item->ci_avalia_tipo)){
                                                                echo 'selected';
                                                            } ?> >
                                                            <?php echo $item->nm_avalia_tipo; ?>
                                                        </Option>

                                                    <?php } ?>
                                                </select>

                                            </div>
                                            <div class="col-lg-5">
                                                <label for="cd_edicao">Edicao *</label>
                                                <select id="cd_edicao" name="cd_edicao" tabindex="3" class="form-control">
                                                    <Option value=""></Option>
                                                    <?php
                                                    foreach ($edicoes as $item) {
                                                        ?>
                                                        <Option value="<?php echo $item->ci_edicao; ?>"
                                                            <?php if ($result->cd_edicao == $item->ci_edicao){
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
                                                        value="<'?php echo set_value('nr_ano');?>">

                                            </div> -->
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
                                                        class="form-control" 
                                                        onchange="gerar_matrizes($('#cd_disciplina').val(), this.value);">
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

                                            <div class="col-lg-6">
                                                <label for="ci_matriz">Matriz *</label>
                                                <select id="ci_matriz" name="ci_matriz" tabindex="8" class="form-control" disabled
                                                        onchange="gerar_matrizes($('#cd_disciplina').val(),$('#cd_etapa').val(),'','',this.value,'',$('cd_avalia_tipo').val())">
                                                        <option value="<?=$result->ci_matriz?>"><?=$result->nm_matriz?></option>                                                        
                                                    </select>
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                            <div class="col-lg-6">
                                                <table>
                                                    <tr style="width: 100%;">
                                                    <tr style="width: 100%;">
                                                        <td style="width: 100%;">
                                                            <small class="text-info">
                                                                <i class="fa fa-info-circle"></i> 
                                                                Selecione o pdf da avaliação.  *
                                                            </small>
                                                        </td>
                                                        <td style="vertical-align: center; width: 31px;">
                                                        </td>
                                                    </tr>
                                                    <tr style="width: 100%;">
                                                        <td style="width: 100%;">
                                                            <input  type="hidden" 
                                                                    name="pdf_arquivo_avaliacao_hidden" 
                                                                    value="<?php echo $result->ds_arquivo_avaliacao ?>">  

                                                            <div id="campo_imagem" >
                                                                <input  type="file"
                                                                        id="ds_arquivo_avaliacao" 
                                                                        name="ds_arquivo_avaliacao" 
                                                                        class="form-control filestyle" 
                                                                        data-buttonText="Adicionar pdf" 
                                                                        data-iconName="fa fa-file-image-o"
                                                                        accept="application/pdf"
                                                                        tabindex="0"/>
                                                            </div>
                                                        </td>
                                                        <?php if ($result->ds_arquivo_avaliacao){ ?>

                                                            <td style="vertical-align: center; width: 31px;">

                                                                <a target="_blank" href="<?php echo base_url('assets/pdf/avaliacao_uploads/'.$result->ds_arquivo_avaliacao)?>">
                                                                    <img src="<?php echo base_url('assets/images/pdf.png');?>" 
                                                                         alt="Avaliação" height="30px" width="30px">
                                                                </a>
                                                                
                                                            </td>
                                                            
                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-lg-6">
                                                <table>
                                                    <tr style="width: 100%;">
                                                    <tr style="width: 100%;">
                                                        <td style="width: 100%;">
                                                            <small class="text-info">
                                                                <i class="fa fa-info-circle"></i> 
                                                                Selecione o pdf do manual do aplicador.  *
                                                            </small>
                                                        </td>
                                                        <td style="vertical-align: center; width: 31px;">
                                                        </td>
                                                    </tr>
                                                    <tr style="width: 100%;">
                                                        <td style="width: 100%;">
                                                            <input  type="hidden" 
                                                                    name="pdf_arquivo_aplicador_hidden" 
                                                                    value="<?php echo $result->ds_arquivo_aplicador ?>"> 

                                                            <div id="campo_imagem" >
                                                                
                                                                <input  type="file"
                                                                        id="ds_arquivo_aplicador" 
                                                                        name="ds_arquivo_aplicador" 
                                                                        class="form-control filestyle" 
                                                                        data-buttonText="Adicionar pdf" 
                                                                        data-iconName="fa fa-file-image-o"
                                                                        accept="application/pdf"
                                                                        tabindex="0"/>
                                                            </div>                                                          
                                                        </td>
                                                        <?php if ($result->ds_arquivo_aplicador){ ?>

                                                            <td style="vertical-align: center; width: 31px;">
                                                                <a target="_blank" href="<?php echo base_url('assets/pdf/avaliacao_uploads/'.$result->ds_arquivo_aplicador)?>">
                                                                    <img src="<?php echo base_url('assets/images/pdf.png');?>" 
                                                                        alt="Avaliação" height="30px" width="30px" h>
                                                                </a>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                                                                      
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
                                                    </tbody>                                                    
                                                    <tfoot>	 
                                                        <tr>	   
                                                            <td colspan="5" style="text-align: left;">
                                                            	<?php if($result->editamatriz!='BLOQUEIA'){?>
                                                            		<input type="hidden" name="editarmatriz" id="editarmatriz" value='<?php echo $result->editamatriz?>'>	    
                                                                    <a  type="button" 
                                                                        class="btn btn-success waves-effect waves-light btn-micro active" 
                                                                        tabindex="21"
                                                                        onclick="AddTableRow();">
                                                                            Add questão
                                                                    </a>   
                                                                <?php }else{?>
                                                                		<input type="hidden" name="editarmatriz" id="editarmatriz" value='<?php echo $result->editamatriz?>'>
                                                                		<label class="red" >Adição de Item Bloqueada</font></label>
                                                                <?php }?>    
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
                            <div class="col-md-12">
                                <div>
                                    <div class="col-md-2">                                            
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
                                        <div class="col-md-2">
                                            <div  class="form-group">
                                                <label>Municípios </label>
                                                <select id="cd_cidade" 
                                                        name="cd_cidade" 
                                                        tabindex="15"
                                                        class="form-control" >
                                                </select>
                                            </div>
                                        </div>                                    
                                        <div class='col-md-2'>
                                            <div class="form-group">
                                                <label>Liberar Caderno em: </label>
                                                <div class='input-group date' id='div_dt_caderno'>
                                                    <input  type='text' 
                                                                class="form-control data" 
                                                                id='dt_caderno'
                                                                name='dt_caderno'/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>                    
                                        <div class='col-md-2'>
                                            <div class="form-group">
                                                <label>Lançar gabarito(Início):</label>
                                                    <div class='input-group date' id='div_dt_inicio'>
                                                        <input  type='text' 
                                                                class="form-control data" 
                                                                id='dt_inicio'
                                                                name='dt_inicio'/><span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class="form-group">
                                                <label>Lançar gabarito(Fim): </label>
                                                    <div class='input-group date' id='div_dt_final'>
                                                        <input  type='text' 
                                                                class="form-control data" 
                                                                id='dt_final'
                                                                name='dt_final'/>

                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class='col-md-2'>
                                            <div class="form-group containerbotao">
                                                <div class="vertical-centerbotao">
                                            <?php if($result->editamatriz!='BLOQUEIA'){?>
                                                <a  type="button" 
                                                    class="btn btn-success waves-effect waves-light btn-micro active"
                                                    onclick="addItemTabela()">Adicionar
                                                </a>
                                            <?php }else{?>                                                                                                    
                                                	<label class="red" >Adição de Item Bloqueada</font></label>
                                            <?php }?>
                                                </div>               
                                            </div>
                                        </div>                                                                                                                                                                         
                                </div>                            
                                    <table id="datasMunicipios"  class="table table-striped table-hover">
                                        <thead>
                                            <tr>                 
                                                <th>Estado</th>
                                                <th>Município</th>
                                                <th>Liberar Caderno</th>
                                                <th>(Início)Lançar gabarito</th>
                                                <th>(Fim)Lançar gabarito</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>                                                                            
                                        <?php foreach($municipios as $key=>$value){?>
                                            <tr id="tr<?=$value->ci_avaliacao_cidade?>">
                                                <td><?=$value->nm_estado?></td>
                                                <td><?=$value->nm_cidade?></td>
                                                <td><?=$value->dt_caderno?></td>
                                                <td id="inicio<?=$value->ci_avaliacao_cidade?>"><?=$value->dt_inicio?></td>
                                                <td id="fim<?=$value->ci_avaliacao_cidade?>"><?=$value->dt_final?></td>
                                                <td><button type="button" 
                                                    onclick="carregaModal(<?=$value->ci_avaliacao_cidade?>,<?=$value->cd_avaliacao_upload?>,<?=$result->editamatriz!='BLOQUEIA'?'false':'true'?>);"
                                                    class="btn btn-custom waves-effect waves-light btn-micro active"
                                                    data-toggle="modal" data-target="#exampleModal">
                                                    Alterar                                                    
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }?>                                        
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <!-- Fim div menu itens -->

                        <div  align="right">
                        	<?php if($result->editamatriz!='BLOQUEIA'){?>
                            <a type="button" 
                                    class="btn btn-custom waves-effect waves-light btn-micro active" 
                                    tabindex="21"
                                    onclick="validar_form();">
                                Cadastrar
                            </a>
                            <?php }?>
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


    if ( ((caderno!="") && (tipoAvaliacao!="")  && (disciplina!="")  && (etapa!="")&& (edicao!="") ) ){            
            $('#frm_avaliacoes').submit();            
    }else{
            alert("Verifique o preenchimento dos campos com (*) asterísco!");
    }
}

    $(function () {
        $(".data").mask("99/99/9999", {
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
        $('#div_modal_inicio').datetimepicker({
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
        $('#div_modal_fim').datetimepicker({
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
    });

$('#alteradatas').click(function(ev){
    ev.preventDefault();
    var dt_inicial=$('#dt_inicial').val();
    var dt_fim=$('#dt_fim').val();
    var cd_cidade_avaliacao=$('#cd_cidade_avaliacao').val();
    var cd_avaliacao_upload=$('#cd_avaliacao_upload').val();

    $('#alteradatas').attr('disabled');
    $('#carregando').show();

    var retorno =validaModal(inicio,fim);            
    if(retorno){        
        $('#formalteraDatas').submit();        
    }    
    $('#carregando').hide();    
});

function validaModal(inicio,fim){
    if(inicio==''||fim==''){    
        if(inicio==''){
            alert('Verifique o preenchimento da Data Início do painel Datas a Serem Alteradas');            
        }
        if(fim==''){
            alert('Verifique o preenchimento da Data Fim do painel Datas a Serem Alteradas');
            
        }   
        return false; 
    }else{
        return true;
    }    
}

function carregaModal(id,avaliacao,bloqueia){    
    var inicio=$('#inicio'+id);
    var fim=$('#fim'+id);
    $('#md_inicio').text(inicio.text());
    if(bloqueia){
        $('#dt_inicial').attr('disabled','disabled');
    }
    $('#md_fim').text(fim.text());
    $('#dt_inicial').val(inicio.text());
    $('#dt_fim').val(fim.text());
    $('#cd_avaliacao_upload').val(avaliacao);
    $('#cd_cidade_avaliacao').val(id);
}

</script>
<?php
    $cd_matriz = '';
    $ds_codigo = '';
    $nr_opcaocorreta = '';
    
    foreach ($matrizes as $matriz) {
        
        if ($cd_matriz){

            $cd_matriz       = $cd_matriz.'|'.$matriz->cd_matriz_descritor;
            $ds_codigo       = $ds_codigo.'|'.$matriz->ds_codigo;
            $nr_opcaocorreta = $nr_opcaocorreta.'|'.$matriz->nr_opcaocorreta;            
            
        }else{
            $cd_matriz = $matriz->cd_matriz_descritor;
            $ds_codigo = $matriz->ds_codigo;
            $nr_opcaocorreta = $matriz->nr_opcaocorreta;
        }
    }
    
    if ($cd_matriz){
        $cd_disciplina = $result->cd_disciplina;
        $cd_etapa      = $result->cd_etapa;
        $editamatriz   =$result->editamatriz;

?>
        <script>
            gerar_matrizes('<?php echo $cd_disciplina ?>', '<?php echo $cd_etapa ?>', '<?php echo $nr_opcaocorreta ?>', '<?php echo $ds_codigo ?>', '<?php echo $cd_matriz ?>','<?php echo $editamatriz?>');
        </script>
<?php
    }
}
    echo form_close();    
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">                                                    
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Altera dados de Avaliação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>          
                    </button>
                </div>
                <form action="<?=base_url("avaliacao_upload/avaliacao_uploads/alteraDatas")?>" id="formalteraDatas" method="post" enctype="multipart/form-data">
                    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
                                    <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
                    </div>
                
                    <div class="modal-body">                                            
                        <input type="hidden" id="cd_avaliacao_upload" name="cd_avaliacao_upload" value=""/>
                        <input type="hidden" id="cd_cidade_avaliacao" name="cd_cidade_avaliacao" value=""/>                                                         
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr> 
                                    <th colspan="2">Datas Originais</th>                       
                                </tr>                          
                                <tr>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                </tr>                          
                            </thead>
                            <tbody>
                                <tr>
                                    <th><label id="md_inicio"></label></th>                                                        
                                    <th><label id="md_fim"></label></th>                        
                                </tr>                          
                            </tbody>                              
                        </table>                                                                        
                        </br>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr> 
                                    <th colspan="2">Datas a Serem Alteradas</th>                       
                                </tr>                         
                                <tr>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                </tr>                          
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <div class='input-group date' id='div_modal_inicio'>
                                            <input  type='text'
                                                    class="form-control data"
                                                    id='dt_inicial'
                                                    name='dt_inicial'/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>                                            
                                    </th>                                                        
                                    <th>
                                        <div class='input-group date' id='div_modal_fim'>
                                            <input  type='text'
                                                    class="form-control data"
                                                    id='dt_fim'
                                                    name='dt_fim'/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                        </div>                                            
                                    </th>                        
                                </tr>                          
                            </tbody>                              
                        </table>                                         
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="alteradatas" class="btn btn-primary">Gravar</button>        
                    </div>
                </form>    
        </div>
    </div>
</div>
