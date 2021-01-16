<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
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
    	var cidade=$('#cd_cidade').val();
    	var etapa=$('#cd_etapa').val();		
		var disciplina=$('#cd_disciplina').val();
		var avaliacao=$('#cd_avaliacao').val();
		//var avaliacao=$('#cd_avaliacao').val();
		if(estado==''||cidade==''||etapa==''||disciplina==''||avaliacao==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#estadoleitura').submit();
			return true;
		}
    }

    function geraExcel(){
        if(validaForm()){
    		parametros=$("#cd_estado").val()+"/"+$("#cd_cidade").val()+"/"+$("#cd_etapa").val()+"/"+$("#cd_disciplina").val()+"/"+$("#cd_avaliacao").val();            
    		var url ='<?=base_url("relatorio/estadoleituraexcel/")?>'+parametros;    
    		window.open(url);
        }    
    }
</script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Município Leitura' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container card-box">
        <form action="" method="post" id="estadoleitura" name="estadoleitura" >
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
                                class="form-control" >
                                 <?php echo $cidade ?>
                        </select>
                    </div>
                </div>
                
            <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                <div class="form-group col-lg-3">
                    <label>Estados</label>
                    <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios </label>
                        <input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                        <input type="text"  class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                    </div>
                </div>
            <?php }?> <!-- Fim grupo SME -->
            <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa *</label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="3" class="form-control" 
                                onchange="populadisciplina()">
                            <Option value=""></Option>
                            <?php
                            foreach ($etapas as $item) {?>
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
    		 <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="4" class="form-control">
                        <option value="">Selecione uma Disciplina</option>
                        <?php if(isset($disciplinas)){ foreach ($disciplinas as $item) {?>
                            <Option value="<?php echo $item->ci_disciplina; ?>"
                                <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_disciplina; ?>
                            </Option>
                        <?php } }?>
                    </select>            
                </div>
            </div>
            <div  class="col-lg-4">
                    <div class="form-group">
                        <label for="nr_anoletivo">Ano Letivo *</label>
                        <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                        <select id="nr_anoletivo" 
                                    name="nr_anoletivo" 
                                    tabindex="3"
                                    class="form-control"                                    
                                    onchange="populaavalicaoleitura()">
                                <?php echo $anos ?>
                            </select>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_avaliacao">Avaliação *</label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="5" class="form-control"
                            onchange="buscaencerramentomunicipio()">
                        <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        <?php if(isset($avaliacoes)){
                            foreach ($avaliacoes as $item) {?>
                            <Option value="<?php echo $item->ci_avaliacao_upload; ?>"
                                <?php if (set_value('cd_avaliacao') == $item->ci_avaliacao_upload){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_caderno; ?>
                            </Option>
                        <?php } }?>
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
        	<div class="col-md-2">
                <div class="form-group">
					<button type="button" id="btnExcel"
							class="btn btn-custom waves-effect waves-light btn-micro active"
							onclick="javascript:geraExcel();">
							Exportar Dados
					</button>
				</div>
			</div>	    
            
            <div class="col-md-5" style="display: none;">
                        <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
                    </div> 
                </form>
            </div>
            
            <div class="container card-box"> 
                <div class="table-responsive" id="listagem_resultado">
                <table class="table table-striped table-hover">
                    <tr>
                        <th> Escola</th>
                        <th> </th>
                        <th> Leitor Fluente</th>
                        <th> Leitor Sem Fluência</th>
                        <th> Leitor Frase</th>
                        <th> Leitor Palavra</th>
                        <th> Leitor Sílaba</th>
                        <th> Não Leitor</th>
                        <th> Não Avaliado</th>
                        <th> Total</th>
                     </tr>                       
                    <?php $total_escolas=0; 
                        if(isset($registros)){
                	    $tt_leitor_fluente=0;
                	    $tt_leitor_sfluente=0;
                	    $tt_leitor_frase=0;
                	    $tt_leitor_palavra=0;
                	    $tt_leitor_silaba=0;
                	    $tt_nao_leitor=0;
                	    $tt_nao_avaliado=0;
                	    $somatorio=0;                	    
                	    foreach ($registros as $result){
                            $total_escolas++;
                	        $tt_leitor_fluente+=$result->leitor_fluente;
                	        $tt_leitor_sfluente+=$result->leitor_sfluente;
                	        $tt_leitor_frase+=$result->leitor_frase;
                	        $tt_leitor_palavra+=$result->leitor_palavra;
                	        $tt_leitor_silaba+=$result->leitor_silaba;
                	        $tt_nao_leitor+=$result->nao_leitor;                	        
                	        $tt_nao_avaliado+=$result->nao_avaliado;
                	    ?>
                	       <tr>
                	        <td >
                                <?= $result->nm_escola?>
                            </td>
                            <td align="center">Qtd<br/>%                                
                            </td>     
                            <td align="center">
                                <?= $result->leitor_fluente?><br/>
                                <?=round( ($result->leitor_fluente*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)                                   
                               ,2)
                                    
                               ?>
                            </td>
                            <td align="center">
                                <?= $result->leitor_sfluente?><br/>
                                <?=round( ($result->leitor_sfluente*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>
                            <td align="center">
                                <?= $result->leitor_frase?><br/>
                                <?=round( ($result->leitor_frase*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>
                            <td align="center">
                                <?= $result->leitor_palavra?><br/>
                                <?=round( ($result->leitor_palavra*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>
                            <td align="center">
                                <?= $result->leitor_silaba?><br/>
                                <?=round( ($result->leitor_silaba*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>                     	       	
                            <td align="center">
                                <?= $result->nao_leitor?><br/>
                                <?=round( ($result->nao_leitor*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>
                            <td align="center">
                                <?= $result->nao_avaliado?><br/>
                                <?=round( ($result->nao_avaliado*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2)
                               ?>
                            </td>
                            <td align="center">
                            <?=($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado) ?>
                            	<br/>
                            <?= round( (
                                ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)*100/
                                (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                    ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)                                
                                       ),2)
                            ?>
                            </td>
                		<?php }
                		$somatorio=$tt_leitor_fluente+$tt_leitor_sfluente+$tt_leitor_frase+$tt_leitor_palavra+$tt_leitor_silaba+$tt_nao_leitor+$tt_nao_avaliado;
                		echo '</tr>';
                		echo '<tr><td >TOTAL</td><td align="center">QTD-Σ<br/>%-Σ</td>                                
                                <td align="center">'.$tt_leitor_fluente.'<br/>'.round((($tt_leitor_fluente*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_sfluente.'<br/>'.round((($tt_leitor_sfluente*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_frase.'<br/>'.round((($tt_leitor_frase*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_palavra.'<br/>'.round((($tt_leitor_palavra*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_silaba.'<br/>'.round((($tt_leitor_silaba*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_nao_leitor.'<br/>'.round((($tt_nao_leitor*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_nao_avaliado.'<br/>'.round((($tt_nao_avaliado*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$somatorio.'<br/>'.round((($somatorio*100)/($somatorio>0?$somatorio:1)),2).'</td></tr>';
                	} echo '<strong>Total de Escolas:</strong>'.$total_escolas?> 
                	</table>
           		</div>        
           </div>                
         </div>
	</div>	    