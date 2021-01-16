<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/relatorio/relatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
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
            <h4 class="page-title"><?php echo 'Resultado por Estudante - Relação de Acertos e Erros por Item' ?></h4>
            </p>
        </div>
    </div>
    
    <div class="container card-box">
        <form action="" method="post" id="acertoerros" name="acertoserros">
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
                        <div  class="col-lg-2">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep da Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="3"
                                       placeholder="Inep escola"
                                       class="form-control"
                                       value="<?php echo set_value('nr_inep_escola'); ?>"
                                       onblur="pesquisa_inep();">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label for="cd_escola">Escola *</label>
                                <select id="cd_escola"
                                        name="cd_escola"
                                        tabindex="4"                                        
                                        class="form-control"
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
                        <div  class="col-lg-2">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="3"
                                       placeholder="Inep escola"
                                       class="form-control"
                                       value="<?php echo set_value('nr_inep_escola'); ?>"
                                       onblur="pesquisa_inep();">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label for="cd_escola">Escola *</label>
                                <select id="cd_escola"
                                        name="cd_escola"
                                        tabindex="4"                                        
                                        class="form-control"
                                        onchange="escola_selecionda(this.value);">
                                    <Option value="" nr_inep=""></Option>                                    
                                    <?php echo $escolas ?>

                                </select>
                            </div>
                        </div>
                    <?php }else{?> <!-- Fim grupo SME -->
                    <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
            		<input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                    <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo $ci_escola;?>">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep da Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="5"
                                       placeholder="INEP"
                                       class="form-control"
                                       value="<?php echo $nr_inep; ?>">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nm_escola">Nome da escola</label>
                                <input type="text"
                                       name="nm_escola"
                                       id="nm_escola"
                                       tabindex="6"
                                       placeholder="Nome"
                                       class="form-control"
                                       value="<?php echo $nm_escola;?>">
                            </div>
                        </div>
                    <?php }?> <!-- Fim grupo scola -->
                    <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa *</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
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
                    <?php }else{?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa *</label>
                                <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
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
                    <?php } ?>
                    <div  class="col-lg-4">
                        <div class="form-group">
                            <label for="nr_anoletivo">Ano Letivo *</label>
                            <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                            <select id="nr_anoletivo" 
                                        name="nr_anoletivo" 
                                        tabindex="3"
                                        class="form-control"                                    
                                        onchange="populaturmaescola($('#cd_etapa').val(),this.value)">
                                    <?php echo $anos ?>
                                </select>
                        </div>
                </div>            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_turma">Turma *</label>
                    <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control"
                            onchange="populadisciplina()">
                        <option value="">Selecione uma Turma</option>
                        <?php
                        foreach ($turmas as $item) {
                            ?>

                            <Option value="<?php echo $item->ci_turma; ?>"
                                <?php if (set_value('cd_turma') == $item->ci_turma){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nr_ano_letivo .' - '.$item->nm_turno .' - '. $item->nm_turma; ?>
                            </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control"
                            onchange="populaavalicao()">
                        <option value="">Selecione uma Disciplina</option>
                        <?php
                        foreach ($disciplinas as $item) {
                            ?><Option value="<?php echo $item->ci_disciplina; ?>"
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
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control"
                                onchange="buscaencerramentomunicipio()">
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
            <div  class="col-md-5">
            <div class="form-group">
                <label for="dataLimite">Liberação dos relatórios a partir de:</label>                 
                <input type="text" id="dataLimite" name="datalimite" class="form-control" readonly="true"
                value="<?=$dataLimite ?>">
            </div>                     
        </div>
        <div  class="col-md-12">
            <div class="form-group">
                <label for="bloqueia" style="color:#E60000 " >Os resultados só estarão disponíveis para consulta após o término da data de Liberação dos relátórios</label>
            </div>                     
        </div>

            <div class="col-md-5">
                <div class="form-group">
                    <button type="button" id="btn_consultaestudante"
                            tabindex="9" onclick="validaForm();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Gerar
                    </button>
                </div>
            </div>
      		<div class="col-md-5">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div>
          </form>   
        </div>    
  </div>      
    <div class="card-box table-responsive" id="listagem_resultado">                   
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Matrícula-Aluno</td>
                    <!-- Monta a tabale com as questões dinâmicamente -->
                    <?php $ultimaquestao=0; 
                    if (isset($avaliacao)) {
                        foreach ($avaliacao as $result) { ?>
                            <td align="center">
                                <?= $result->nr_questao?><br/>
                                <?= $result->descritor?> 
                            </td>
                        <?php }
                        $ultimaquestao=$result->nr_questao;
                    }?>
                       <td align="center">%</td>
                       <td align="center">Nível</td>
                    </tr>
                    <?php $alunoAtual=0;
                    $pacertos=0;
                    $nr_acertos=0;
                    $nr_erro=0;
                    $impresso=0;
                    $impressopercent=false;
                    if(isset($registrosDesc)){
                        $total=count(array_keys($registrosDesc))-1;                        
                        foreach ($registrosDesc as $resultado=>$valor) {
                            //IMPRIME ALUNO
                            if($alunoAtual!=$valor->ci_aluno){?>
                                <tr><td><?= $valor->ci_aluno; ?>-<?= $valor->nm_aluno; ?></td>
                            <?php $alunoAtual=$valor->ci_aluno;
                                $pacertos=0;$nr_acertos=0;$nr_erro=0;
                                $impressopercent=false;}?>                            
                            
                            <?php //IMPRIME ITENS
                            if($alunoAtual==$valor->ci_aluno){
                                if($valor->acertos==1 && $valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_acertos++;?>
                                    <td align="center">
                                    <?php //echo $valor->nr_questao;?>
                                        <img src="<?php echo base_url('assets/images/icons/certo.png')?>" alt="" height="20">                                        
                                        <span class="tooltip"><?=$valor->descritor?></span>
                                    </td>                                    
                           		<?php }else if($valor->nr_questao!=$item && $valor->nr_questao!=$impresso){
                                    $nr_erro++;?>
                                   <td align="center"> 
                                   <?php //echo $valor->nr_questao;?>
                                    <img src="<?php echo base_url('assets/images/icons/errado.png')?>" alt="" height="20">                                    
                                    <span class="tooltip"><?=$valor->descritor?></span>
                                   </td> 
                                <?php } $impresso=$valor->nr_questao;?>
                              <?php if($valor->nr_questao==$ultimaquestao && $valor->fl_ativo='t' && !$impressopercent){
                                  $pacertos =round(( ($nr_acertos*100)/($nr_acertos+$nr_erro)),2);?>
                                		<td align="center"><?=$pacertos?></td>
                                        <td align="center"><?php if($pacertos<=50){?><label style="color:#E60000">1</label><?php }else ?>
                                            <?php if($pacertos>50 && $pacertos<=70 ){?><label style="color:#FF9900">2</label><?php }else ?>
                                            <?php if($pacertos>70){?><label style="color:#006600">3</label><?php }?>
                                        </td>
                                    </tr>
                                                                
                              	<?php $impressopercent=true;
                              }else if($valor->nr_questao==$ultimaquestao && $valor->fl_ativo='f' && !$impressopercent){
                              			$pacertos =round(( ($nr_acertos*100)/($nr_acertos+$nr_erro)),2);?>
                                		<td align="center"><?=$pacertos?></td>
                                        <td align="center"><?php if($pacertos<=50){?><label style="color:#E60000">1</label><?php }else ?>
                                            <?php if($pacertos>50 && $pacertos<=70 ){?><label style="color:#FF9900">2</label><?php }else ?>
                                            <?php if($pacertos>70){?><label style="color:#006600">3</label><?php }?>
                                        </td>
                                    </tr>
                          <?php  $impressopercent=true;   }
                              	}else{?>
                              </tr>
                          <?php }
                        }
                    }?>
                </table>                    
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
    	var etapa=$('#cd_etapa').val();		
    	var turma=$('#cd_turma').val();
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		//var avaliacao=$('#cd_avaliacao').val();
		if(etapa==''||disciplina==''||avaliacao==''||turma==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#acertoerros').submit();
			return true;
		}
    }
</script>