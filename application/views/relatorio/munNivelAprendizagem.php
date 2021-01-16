<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabaritoleitura.js'); ?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/bootstrap.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_topicos.js'); ?>"></script>
<script>

    function carregamodal(id) { 
            var cd_topico=$('#cd_topico').val();
            var cd_avaliacao=$('#cd_avaliacao').val();            
            var cd_cidade=$('#cd_cidade').val();
            var textnode ='';         
            $.ajax({
            url:"partials/niveldesempenhomunicipioalunos/",
            type: 'POST',
            data: {cd_nivel:id,cd_avaliacao:cd_avaliacao,cd_cidade:cd_cidade,cd_topico:cd_topico},
            dataType:"json",
            success: function(resp1) {                                              
                $("#nivel"+id).html('');                
                for(var res in resp1){
                    console.log(resp1[res].cd_nivel_desempenho);
                    if(resp1[res].cd_nivel_desempenho==id){
                        console.log(resp1[res].alunos);
                    	textnode+='<div>'+resp1[res].alunos+'</div>';
                    }	
                }
                  textnode+='<div><input type="hidden" id="cd_topico" value="'+cd_topico+'"/></div>'+
                             '<div><input type="hidden" id="cd_nivel" value="'+id+'"/></div>'+
                             '<div><input type="hidden" id="cd_avaliacao" value="'+cd_avaliacao+'"/></div>';
                 $("#nivel"+id).append(textnode);            
              }  
            });            
            $('#modalNivel'+id).modal('show');        
    }
</script>

<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            	<h4 class="page-title"><?php echo 'Município:Nível de Aprendizado' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post" id="niveaprendizagem">
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
                    <label>Estados *</label>
                    <input type="hidden" class="form-control" id="cd_estado" name="cd_estado" 
                    		value="<?php echo $this->session->userdata('cd_estado_sme');?>">
                    <input type="text" class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios *</label>                        
                        <input type="hidden" class="form-control" id="cd_cidade" 
                        		name="cd_cidade" tabindex="2" 
                        	   value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                    </div>
                </div>
            <?php }?> <!-- Fim grupo SME -->
            <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                <div class="col-md-5">
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
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="4" class="form-control">
                        <option value="">Selecione uma Disciplina</option>
                        <?php if(isset($disciplinas)){
                            foreach ($disciplinas as $item) {?>
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
                                    onchange="populaavalicao()">
                                <?php echo $anos ?>
                            </select>
                    </div>
                </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_avaliacao">Avaliação *</label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="5" class="form-control"
                            onchange="populatopicos();ativaConsulta();buscaencerramentomunicipio();">
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

            <div class="col-md-10">
                <div class="form-group">
                    <label for="cd_topico">Topico:</label>
                    <select id="cd_topico" name="cd_topico" tabindex="6" class="form-control">
                    		<option value='0'> Todos </option>
                        <?php if(isset($topicos)){                            
                            foreach ($topicos as $item) {?>
                            <Option value="<?php echo $item->ci_matriz_topico; ?>"
                            <?php if (set_value('cd_topico') == $item->ci_matriz_topico){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_matriz_topico; ?>
                            </Option>
                        <?php } }?>
                    </select>
                </div>
            </div>

        <div  class="col-md-12">
            <div class="form-group">
                <label for="bloqueia" style="color:#E60000 " >Os resultados só estarão disponíveis para consulta após o término da data de Liberação dos relátórios</label>
            </div>                     
        </div>


            <div class="col-md-12">
                <div class="form-group col-lg-8">
                    <label >Legenda de Cores </label>
                    <input type="text" id="n1" class="form-control" value="Nível 1:% Acerto: menor ou igual a 25% de acerto no teste"
                           style="color: white; background:#E60000"/>
                    <input type="text" id="n2" class="form-control" value="Nível 2:% Acerto: no intervalo maior que 25% e menor ou igual a 50% de acerto no teste"
                           style="color: white; background:#FF9900"/>
                    <input type="text" id="n3" class="form-control" value="Nível 3:% Acerto: maior do que 50% e menor ou igual a 75% de acerto no teste"
                           style="color: white; background:#81c93a"/>       
                    <input type="text" id="n3" class="form-control" value="Nível 4:% Acerto: maior do que 75% de acerto no teste"
                           style="color: white; background:#006600"/>      
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <button type="button" id="btn_consulta"
                            tabindex="7"
                            onclick="javascript:validaform();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Gerar
                    </button>
                </div>
            </div>
            <div class="col-md-5" style="display: none;">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div>    
        </form>
    </div>
    <div class="card-box table-responsive" id="listagem_resultado">
        <div class="table-responsive align-text-middle">
            <?php if(!isset($registrosDesc) || empty($registrosDesc)){?>
            	<div class="col-md-3" id="tabs-4">
                    <input type="text" id="n4" class="form-control"
                           value="Nível 4"  readonly="true"
                           style="color: white; background:#006600"/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #006600">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 4</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>                
            
                <div class="col-md-3" id="tabs-3">
                    <input type="text" id="n3" class="form-control"
                           value="Nível 3"  readonly="true"
                           style="color: white; background:#81c93a"/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #81c93a">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 3</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>                

                <div class="col-md-3" id="tabs-2">
                    <input type="text" id="n2" class="form-control"
                           value="Nível 2"  readonly="true"
                           style="color: white; background:#FF9900 "/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #FF9900 ">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 2</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>

                <div class="col-md-3" id="tabs-1">
                    <input type="text" id="n1" class="form-control" value="Nível 1"
                          readonly="true" style="color: white; background:#E60000 "/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #E60000">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 1</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>
            <?php }else{ ?>
                <?php  foreach($registrosDesc as $nivel){?>
					<?php if($nivel->cd_nivel_desempenho=="4"){?>
                        <div class="col-md-3" id="tabs-4">
                            <input type="text" id="n4" class="form-control"
                                   value="Nível 4"  readonly="true"
                                   style="color: white; background:#006600"/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 23px; color: #006600"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 4</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 15px;color: #81c93a">Mais que 75%</label><label style="color: #81c93a"> de acerto na avaliação</label>                                
                                    <img src="<?php echo base_url('assets/images/icons/70porcentonivel_verde.png')?>">
                                </div>   
                            <div class="col-xs-12 text-center"> 
                             <?php if($nivel->alunos>0){?>
                                <button type="button" id="btn_modal"
                                    tabindex="9"
                                    class="btn btn-custom waves-effect waves-light btn-micro active
                                    btn_modal"
                                    onclick="carregamodal(<?=$nivel->cd_nivel_desempenho?>);">
                                Veja os Alunos
                                </button>
                                            <button type="button" id="btnExcel"
                                                class="btn btn-custom waves-effect waves-light btn-micro active"
                                                onclick="javascript:geraExcel(<?=$nivel->cd_nivel_desempenho?>);">
                                                Exportar Lista de Alunos
                                            </button> 
                              <?php }?>              
                            </div>
                        
                        <div class="modal fade bs-example-modal-lg" id="modalNivel<?=$nivel->cd_nivel_desempenho?>" >
                          <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                        <h4 class="modal-title">Lista de Alunos do Nível:<?=$nivel->cd_nivel_desempenho?></h4>
                                      </div>
                                      <div class="modal-body" id="nivel<?=$nivel->cd_nivel_desempenho?>" >
                                            
                                      </div>
                                </div>
                          </div>
                        </div> 
                    </div>                        
                    <?php }else if($nivel->cd_nivel_desempenho=="3"){?>
                        <div class="col-md-3" id="tabs-3">
                            <input type="text" id="n3" class="form-control"
                                   value="Nível 3"  readonly="true"
                                   style="color: white; background:#81c93a"/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 23px; color: #81c93a"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 3</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 15px;color: #81c93a">Mais que 50% menos que 75%</label><label style="color: #81c93a"> de acerto na avaliação</label>                                
                                    <img src="<?php echo base_url('assets/images/icons/70porcentonivel_verde.png')?>">
                                </div>   
                            <div class="col-xs-12 text-center"> 
                             <?php if($nivel->alunos>0){?>
                                <button type="button" id="btn_modal"
                                    tabindex="9"
                                    class="btn btn-custom waves-effect waves-light btn-micro active
                                    btn_modal"
                                    onclick="carregamodal(<?=$nivel->cd_nivel_desempenho?>);">
                                Veja os Alunos
                                </button>
                                            <button type="button" id="btnExcel"
                                                class="btn btn-custom waves-effect waves-light btn-micro active"
                                                onclick="javascript:geraExcel(<?=$nivel->cd_nivel_desempenho?>);">
                                                Exportar Lista de Alunos
                                            </button> 
                              <?php }?>              
                            </div>
                        
                        <div class="modal fade bs-example-modal-lg" id="modalNivel<?=$nivel->cd_nivel_desempenho?>" >
                          <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                        <h4 class="modal-title">Lista de Alunos do Nível:<?=$nivel->cd_nivel_desempenho?></h4>
                                      </div>
                                      <div class="modal-body" id="nivel<?=$nivel->cd_nivel_desempenho?>" >
                                            
                                      </div>
                                </div>
                          </div>
                        </div> 
                    </div>    
                    <?php } else ?>
                    <?php  if($nivel->cd_nivel_desempenho=="2"){?>
                        <div class="col-md-3" id="tabs-2">
                            <input type="text" id="n2" class="form-control"
                                   value="Nível 2"  readonly="true"
                                   style="color: white; background:#FF9900 "/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 23px; color: #FF9900"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 2</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 15px;color: #FF9900">Mais que 25% e menos que 50%</label>
                                <label style="color: #FF9900">de acerto na avaliação</label>                                
                                    <img src="<?php echo base_url('assets/images/icons/50porcentonivel_amarelo.png')?>">                                
                                </div>   
                            <div class="col-xs-12 text-center">
                            	<?php if($nivel->alunos>0){?> 
                                <button type="button" id="btn_modal"
                                    tabindex="9"
                                    class="btn btn-custom waves-effect waves-light btn-micro active
                                    btn_modal"
                                    onclick="carregamodal(<?=$nivel->cd_nivel_desempenho?>);">
                                Veja os Alunos
                                </button>
                                            <button type="button" id="btnExcel"
                                                class="btn btn-custom waves-effect waves-light btn-micro active"
                                                onclick="javascript:geraExcel(<?=$nivel->cd_nivel_desempenho?>);">
                                                Exportar Lista de Alunos
                                            </button> 
                               <?php }?>               
                            </div>                                                  
                            <div class="modal fade bs-example-modal-lg" id="modalNivel<?=$nivel->cd_nivel_desempenho?>" >
                              <div class="modal-dialog">
                                    <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                            <h4 class="modal-title">Lista de Alunos do Nível:<?=$nivel->cd_nivel_desempenho?></h4>
                                          </div>
                                          <div class="modal-body" id="nivel<?=$nivel->cd_nivel_desempenho?>" >
                                                
                                          </div>
                                    </div>
                              </div>
                            </div> 
                     </div>       
                    <?php }else ?>

                    <?php  if($nivel->cd_nivel_desempenho=="1"){?>
                        <div class="col-md-3" id="tabs-1">
                            <input type="text" id="n1" class="form-control" value="Nível 1"
                                   readonly="true" style="color: white; background:#E60000 "/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 23px; color: #E60000"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 1</label></br>
                                <label>Obtendo:</label>
                                <label style="font-size: 15px; color: #E60000">Menos ou igual a 25%</label> 
                                <label style="color: #E60000">de acerto na avaliação</label>
                                    <img src="<?php echo base_url('assets/images/icons/50porcentonivel_amarelo.png')?>">                                
                            </div>   
                            <div class="col-xs-12 text-center"> 
                            	<?php if($nivel->alunos>0){?> 
                                <button type="button" id="btn_modal"
                                    tabindex="9"
                                    class="btn btn-custom waves-effect waves-light btn-micro active
                                    btn_modal"
                                    onclick="carregamodal(<?=$nivel->cd_nivel_desempenho?>);">
                                Veja os Alunos
                                </button>
                                            <button type="button" id="btnExcel"
                                                class="btn btn-custom waves-effect waves-light btn-micro active"
                                                onclick="javascript:geraExcel(<?=$nivel->cd_nivel_desempenho?>);">
                                                Exportar Lista de Alunos
                                            </button>
                                <?php }?>               
                            </div>
                        
                        <div class="modal fade bs-example-modal-lg" id="modalNivel<?=$nivel->cd_nivel_desempenho?>" >
                          <div class="modal-dialog">
                                <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                                        <h4 class="modal-title">Lista de Alunos do Nível:<?=$nivel->cd_nivel_desempenho?></h4>
                                      </div>
                                      <div class="modal-body" id="nivel<?=$nivel->cd_nivel_desempenho?>" ></div>
                                </div> 
                          </div>                          
                        </div> 
                    </div>
                    <?php }?>
                <?php }?>
            <?php }?>
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
    function geraExcel(id){
        var cd_nivel=id;
        parametros=cd_nivel+"/"+$("#cd_avaliacao").val()+"/"+$("#cd_topico").val()+"/"+$("#cd_cidade").val();            
    	var url ='<?=base_url("relatorio/excelniveldesempenhomunicipio/")?>'+parametros;    
    	window.open(url);    
    }
    function validaform(){
        var invalido = true;
        var estado=$('#cd_estado').val();
        var cidade=$('#cd_cidade').val();
        var etapa=$('#cd_etapa').val();
        var disciplina=$('#cd_disciplina').val();
        var avaliacao=$('#cd_avaliacao').val();
        
        if (estado==''||cidade==''||etapa==''||disciplina==''||avaliacao==''){
        	alert('Verifique o preenchimento de todos os campos com asterisco (*)!');
        	return false;
        }else{
            $('#niveaprendizagem').submit();
        	return true;
        }            
    }   
</script>