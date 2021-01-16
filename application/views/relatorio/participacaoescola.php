<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabaritoleitura.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_topicos.js'); ?>"></script>
<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep'));
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep.toUpperCase() == attr_inep) {
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
        $('#cd_etapa').removeAttr('disabled');
        //populaturma('',id_escola, '', cd_turma);
    }
</script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Participacao:Escrita por Escola' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post" id="munescritaescola" name="munescritaescola">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->
                <div class="col-lg-3">
                    <label>Estados *</label>
                    <select id="cd_estado"
                            name="cd_estado"
                            tabindex="1"
                            class="form-control"
                            onchange="populacidade(this.value);">
                        <?php echo $estado ?>
                    </select>
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios *</label>
                        <select id="cd_cidade"
                                name="cd_cidade"
                                tabindex="2"
                                onchange="populaescola(this.value);"
                                class="form-control" >
                                 <?php echo $cidade ?>
                        </select>
                    </div>
                </div>                
                <div class="col-lg-10">
                    <div class="form-group">
                        <label for="cd_escola">Escola *</label>
                        <select id="cd_escola"
                                name="cd_escola[]"
                                tabindex="3"                                
                                class="form-control"
                                multiple="multiple"
                                onchange="escola_selecionda(this.value);">                            
                                <?php echo $escolas ?>
                        </select>
                    </div>
                </div>

            <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                <div class="form-group col-lg-3">
                    <label>Estados *</label>
                    <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios *</label>
                        <input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                        <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                    </div>
                </div>                
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="cd_escola">Escolas *</label>
                        <select id="cd_escola"
                                name="cd_escola[]"
                                tabindex="4"
                                class="form-control"
                                multiple="multiple"
                                onchange="escola_selecionda(this.value);">                            
                            <?php echo $escolas ?>
                        </select>
                    </div>
                </div>
            <?php }?> <!-- Fim grupo SME -->
            <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa *</label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="5" class="form-control"
                                onchange="populadisciplina()">
                            <Option value=""></Option>
                            <?php foreach ($etapas as $item) { ?>
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
            <?php }?>            
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="6" class="form-control" 
                            onchange="populaavalicao()">
                        <option value="">Selecione uma Disciplina</option>
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
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_avaliacao">Avaliação *</label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="7" class="form-control" 
                            onchange="populatopicos();ativaConsulta();">
                        <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        <?php
                        foreach ($avaliacoes as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_avaliacao_upload; ?>"
                                <?php if (set_value('cd_avaliacao') == $item->ci_avaliacao_upload){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_caderno; ?>
                            </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group col-lg-8">
                    <label >Legenda de Cores </label>
                    <input type="text" id="n1" class="form-control" value="% Acerto: menor ou igual a 50% de acerto no teste"
                           style="color: white; background:#E60000"/>
                    <input type="text" id="n2" class="form-control" value="% Acerto: no intervalo maior que 50% e menor ou igual a 70% de acerto no teste"
                           style="color: white; background:#FF9900"/>
                    <input type="text" id="n3" class="form-control" value="% Acerto: maior do que 70% de acerto no teste"
                           style="color: white; background:#006600"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="button" id="btn_consulta" 
                            tabindex="8" onclick="validaForm();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Gerar
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                	<button type="button" id="btnExcel"
                            class="btn btn-custom waves-effect waves-light btn-micro active"
                            onclick="javascript:geraExcel();">Exportar Lista
                    </button>
                </div>
            </div>
            <div class="col-md-4" style="display: none;">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div> 
        </form>
    </div>
    <div class="card-box table-responsive" id="listagem_resultado">
        <div class="table-responsive align-text-middle">
            <div class="col-lg-12">
            	<table class="table table-striped table-hover">            		
            	    <tr>
                        <!-- <td>% <br/> Qtd</td> -->                        
                        <td>%</td>
                        <?php if( isset($avaliacao) && isset($totalDesc) ){
                            foreach($avaliacao as $item){ ?>
                                <td align="center">&nbsp;&nbsp;<?=$item->ds_codigo;?></td>
                        <?php }
                        }?>
                        <td align="center"> % Total</td>
                    </tr>
                    <tr>                    
                    		<td>%</td>
                    <?php $pttacertos=0;$qtdacertos=0;
                            $qttotal=0;
                        if( isset($avaliacao) && isset($totalDesc)){
                            foreach ($totalDesc as $resultado=>$ttdescritor){
                                $pttacertos+=$ttdescritor->pacerto;
                                $qtdacertos+=$ttdescritor->acertos;
                                $qttotal+=$ttdescritor->questoes
                            ?>                            
                            <td align="center"> <?=$ttdescritor->pacerto; ?></td>
                            <?php }?>
                            <td align="center"><?= round(($qtdacertos*100)/$qttotal,2); ?></td>
                    <?php }?>
                   </tr>         
            	</table>
            	<br/>
            	<br/>
                <table class="table table-striped table-hover">
                    <tr>                    	
                        <td>Escola</td>
                        <td>% <br/> Qtd</td>                        
                        <?php if( isset($avaliacao)){
                            $descritores=0;
                            foreach($avaliacao as $item){
                                $descritores++;
                            ?>
                                <td align="center">&nbsp;&nbsp;<?=$item->ds_codigo;?></td>                                
                        <?php }
                        }?>                 
                        <td align="center"> % Acerto</td>                               
                    </tr>

                        <?php if( isset($registrosDesc) ){
                            //print_r($registrosDesc);die;
                            $escolaAtual="";
                            $acertos=0;
                            $total=0;
                            $contagem=count(array_keys($registrosDesc))-1;
                            foreach($registrosDesc as $resultado =>$item){
                                $chaveAtual=$resultado;
                                if($escolaAtual!="" && $escolaAtual!=$item->nm_escola){
                                    $pacertos =round(( ($nr_acertos*100)/$total),2);?>                                    
                                    <td align="center" valign="middle"
                                        <?php if($pacertos<=50){?>
                                            style="color: white; background:#E60000"
                                        <?php }?> 
                                        <?php if($pacertos>50 && $pacertos<=70){?>                                        
                                            style="color: white; background:#FF9900"
                                        <?php }?> 
                                        <?php if($pacertos>70){?>
                                            style="color: white; background:#006600"
                                        <?php }?>     
                                        ><br/><?=$pacertos?></td>
                                    <?php $pacertos=0;
                                        $nr_acertos=0;
                                        $total=0; }

                                if($item->nm_escola!=$escolaAtual){
                                        $nr_acertos=0;
                                        $total=0;?>
                                    <tr>
                                        <td><?= $item->nm_escola; ?></td>
                                        <td>% <br/> Qtd</td>
                                <?php }

                                        $nr_acertos=$nr_acertos+$item->acertos;
                                        $total+=$item->questoes;
                                        $escolaAtual=$item->nm_escola ?>                                        
                                        <td align="center"> <?= $item->pacerto; ?><br/><?= $item->acertos; ?></td>                                

                                    <?php if ($escolaAtual != "" && $chaveAtual==$contagem) {
                                        $pacertos =round(( ($nr_acertos*100)/($total)),2);?>                                    
                                        <td align="center" 
                                        <?php if($pacertos<=50){?>
                                            style="color: white; background:#E60000"
                                        <?php }?> 
                                        <?php if($pacertos>50 && $pacertos<=70){?>                                        
                                            style="color: white; background:#FF9900"
                                        <?php }?> 
                                        <?php if($pacertos>70){?>
                                            style="color: white; background:#006600"
                                        <?php }?>     
                                        valign="middle" ><br/><?=$pacertos?></td>
                                    <?php $pacertos=0;$nr_acertos=0;$total=0;
                                }                                
                            }
                            echo '</tr>';
                        }?>                    
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function printPage(){
        var $panels = $('.panel');
        var $panelBodys = $('.panel-body');
        var $tables = $('.table-responsive');
        $panels.removeClass('panel');
        $panelBodys.removeClass('panel-body');
        $tables.removeClass('table-responsive');
        $('#content').css('font-size', '75%');
        window.print();
        $('#content').css('font-size', '100%');
        $panels.addClass('panel');
        $panelBodys.addClass('panel-body');
        $tables.addClass('table-responsive');
    }
    function validaForm(){
    	var estado=$('#cd_estado').val();
    	var cd_cidade=$('#cd_cidade').val();
		var etapa=$('#cd_etapa').val();
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		if(estado==''||cd_cidade==''||etapa==''||disciplina==''||avaliacao==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#munescritaescola').submit();
			return true;
		}
    }
    function geraExcel(){
    	cd_cidade =$('#cd_cidade').val();
        cd_etapa = $('#cd_etapa').val();       
        cd_disciplina = $('#cd_disciplina').val();
        cd_avaliacao = $('#cd_avaliacao').val();
                
        parametros=cd_cidade+"/"+cd_etapa+"/"+cd_disciplina+"/"+cd_avaliacao;            
    	var url ='<?=base_url("relatorio/munescritaescolaexcel/")?>'+parametros;    
    	window.open(url);    
    }
</script>