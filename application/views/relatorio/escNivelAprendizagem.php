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
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep'));
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep.toUpperCase() == attr_inep.toUpperCase()) {
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

    function carregamodal(id) { 
            var cd_turma=$('#cd_turma').val();
            var cd_avaliacao=$('#cd_avaliacao').val();            
            var textnode ='';         
            $.ajax({
            url:"partials/niveldesempenhoalunos/",
            type: 'POST',
            data: {cd_nivel:id,cd_turma:cd_turma,cd_avaliacao:cd_avaliacao},
            dataType:"json",
            success: function(resp1) {                                              
                $("#nivel"+id).html('');
                for(var res in resp1){
                    textnode+='<div>Matrícula:'+resp1[res].ci_aluno+' Nome:'+resp1[res].nm_aluno+'</div>';
                }
                  textnode+='<div><input type="hidden" id="cd_etapa" value="'+cd_turma+'"/></div>'+
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
            <h4 class="page-title"><?php echo 'Escola:Nível de Aprendizado' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->

                <div class="col-lg-3">

                    <label>Estados</label>
                    <select id="cd_estado"
                            name="cd_estado"
                            tabindex="14"
                            class="form-control"
                            onchange="populacidade(this.value);">
                        <?php echo $estado ?>
                    </select>
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios </label>
                        <select id="cd_cidade"
                                name="cd_cidade"
                                tabindex="15"                                
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
                        <label for="cd_escola">Escola</label>
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

            <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->
                <div class="form-group col-lg-3">
                    <label>Estados</label>
                    <input type="text" class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                </div>
                <div class="col-lg-9">
                    <div  class="form-group">
                        <label>Municípios </label>
                        <input type="text" class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
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
                        <label for="cd_escola">Escolas</label>
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
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa</label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control"
                                onchange="populaturmaescola(this.value)">
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
            <?php }?>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_turma">Turma </label>
                    <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control"
                            onchange="populadisciplina()">
                        <option value="">Selecione uma Turma</option>
                        <?php foreach ($turmas as $item) {?>
                            <Option value="<?php echo $item->ci_turma; ?>"
                                <?php if (set_value('cd_turma') == $item->ci_turma){
                                    echo 'selected';
                                } ?> >
                                <?php echo $item->nm_turma; ?>
                            </Option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina </label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control"
                            onchange="populaavalicao()">
                        <option value="">Selecione uma Disciplina</option>
                        <?php foreach ($disciplinas as $item) {?>
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
                    <label for="cd_avaliacao">Avaliação </label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control"
                            onchange="populatopicos();ativaConsulta();">
                        <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        <?php foreach ($avaliacoes as $item) {?>
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

            <div class="col-md-10">
                <div class="form-group">
                    <label for="cd_topico">Topico:</label>
                    <select id="cd_topico" name="cd_topico[]" tabindex="10" class="form-control"
                            multiple="multiple">
                        <option value="">Selecione um Tópico</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-lg-8">
                    <label >Legenda de Cores </label>
                    <input type="text" id="n1" class="form-control" value="Nível 1: menor ou igual a 50% de acerto no teste"
                           style="color: white; background:#E60000"/>
                    <input type="text" id="n2" class="form-control" value="Nível 2: no intervalo maior que 50% e menor ou igual a 70% de acerto no teste"
                           style="color: white; background:#FF9900"/>
                    <input type="text" id="n3" class="form-control" value="Nível 3: maior do que 70% de acerto no teste"
                           style="color: white; background:#006600"/>
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <button type="submit" id="btn_consulta"
                            tabindex="9"
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
    <div class="card-box table-responsive" id="listagem_resultado">
        <div class="table-responsive align-text-middle">
            <?php if(!isset($registrosDesc)){?>
                <div class="col-md-4" id="tabs-3">
                    <input type="text" id="n3" class="form-control"
                           value="Nível 3"
                           style="color: white; background:#006600"/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #006600">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 3</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>                

                <div class="col-md-4" id="tabs-2">
                    <input type="text" id="n2" class="form-control"
                           value="Nível 2"
                           style="color: white; background:#FF9900 "/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #FF9900 ">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 2</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>

                <div class="col-md-4" id="tabs-1">
                    <input type="text" id="n1" class="form-control" value="Nível 1"
                           style="color: white; background:#E60000 "/>
                    <div class="col-xs-12 text-center">
                        <label style="font-size: 25px" style="color: #E60000">0,0</label>
                        <label> Dos Alunos encontram-se no Nível 1</label>
                        <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                    </div>
                </div>
            <?php }else{ ?>
                <?php  foreach($registrosDesc as $nivel){?>

                    <?php if($nivel->cd_nivel_desempenho=="3"){?>
                        <div class="col-md-4" id="tabs-3">
                            <input type="text" id="n3" class="form-control"
                                   value="Nível 3"
                                   style="color: white; background:#006600"/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 25px; color: #006600"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 3</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 25px;color: #006600"><?=$nivel->pdesemp?>%</label><label style="color: #006600"> de acerto na avaliação</label>
                                <?php if($nivel->pdesemp==0){?>
                                    <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>0 && $nivel->pdesemp<=10){?>
                                    <img src="<?php echo base_url('assets/images/icons/10porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>10 && $nivel->pdesemp<=20){?>
                                    <img src="<?php echo base_url('assets/images/icons/20porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>20 && $nivel->pdesemp<=30){?>
                                    <img src="<?php echo base_url('assets/images/icons/30porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>30 && $nivel->pdesemp<=40){?>
                                    <img src="<?php echo base_url('assets/images/icons/40porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>40 && $nivel->pdesemp<=50){?>
                                    <img src="<?php echo base_url('assets/images/icons/50porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>50 && $nivel->pdesemp<=60){?>
                                    <img src="<?php echo base_url('assets/images/icons/60porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>60 && $nivel->pdesemp<=70){?>
                                    <img src="<?php echo base_url('assets/images/icons/70porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>70 && $nivel->pdesemp<=80){?>
                                    <img src="<?php echo base_url('assets/images/icons/80porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>80 && $nivel->pdesemp<=99){?>
                                    <img src="<?php echo base_url('assets/images/icons/90porcentonivel_verde.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp==100){?>
                                    <img src="<?php echo base_url('assets/images/icons/100porcentonivel_verde.png')?>">
                                <?php }?>
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
                                      <div class="modal-body" id="divDescritores<?=$nivel->cd_nivel_desempenho?>" >
                                            
                                      </div>
                                </div>
                          </div>
                        </div> 
                    </div>    
                    <?php } else ?>
                    <?php  if($nivel->cd_nivel_desempenho=="2"){?>
                        <div class="col-md-4" id="tabs-2">
                            <input type="text" id="n2" class="form-control"
                                   value="Nível 2"
                                   style="color: white; background:#FF9900 "/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 25px; color: #FF9900"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 2</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 25px;color: #FF9900"><?=$nivel->pdesemp?>%</label>
                                <label style="color: #FF9900">de acerto na avaliação</label>
                                <?php if($nivel->pdesemp==0){?>
                                    <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>0 && $nivel->pdesemp<=10){?>
                                    <img src="<?php echo base_url('assets/images/icons/10porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>10 && $nivel->pdesemp<=20){?>
                                    <img src="<?php echo base_url('assets/images/icons/20porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>20 && $nivel->pdesemp<=30){?>
                                    <img src="<?php echo base_url('assets/images/icons/30porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>30 && $nivel->pdesemp<=40){?>
                                    <img src="<?php echo base_url('assets/images/icons/40porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>40 && $nivel->pdesemp<=50){?>
                                    <img src="<?php echo base_url('assets/images/icons/50porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>50 && $nivel->pdesemp<=60){?>
                                    <img src="<?php echo base_url('assets/images/icons/60porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>60 && $nivel->pdesemp<=70){?>
                                    <img src="<?php echo base_url('assets/images/icons/70porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>70 && $nivel->pdesemp<=80){?>
                                    <img src="<?php echo base_url('assets/images/icons/80porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>80 && $nivel->pdesemp<=99){?>
                                    <img src="<?php echo base_url('assets/images/icons/90porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp==100){?>
                                    <img src="<?php echo base_url('assets/images/icons/100porcentonivel_amarelo.png')?>">
                                <?php }?>
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
                                          <div class="modal-body" id="divDescritores<?=$nivel->cd_nivel_desempenho?>" >
                                                
                                          </div>
                                    </div>
                              </div>
                            </div> 
                     </div>       
                    <?php }else ?>

                    <?php  if($nivel->cd_nivel_desempenho=="1"){?>
                        <div class="col-md-4" id="tabs-1">
                            <input type="text" id="n1" class="form-control" value="Nível 1"
                                   style="color: white; background:#E60000 "/>
                            <div class="col-xs-12 text-center">
                                <label style="font-size: 25px; color: #E60000"><?=$nivel->alunos?></label>
                                <label> Dos Alunos encontram-se no Nível 1</label></br>
                                <label> Tendo Obtido:</label>
                                <label style="font-size: 25px; color: #E60000"><?=$nivel->pdesemp?>%</label> 
                                <label style="color: #E60000">de acerto na avaliação</label>
                                <?php if($nivel->pdesemp==0){?>
                                    <img src="<?php echo base_url('assets/images/icons/0porcentonivel.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>0 && $nivel->pdesemp<=10){?>
                                    <img src="<?php echo base_url('assets/images/icons/10porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>10 && $nivel->pdesemp<=20){?>
                                    <img src="<?php echo base_url('assets/images/icons/20porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>20 && $nivel->pdesemp<=30){?>
                                    <img src="<?php echo base_url('assets/images/icons/30porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>30 && $nivel->pdesemp<=40){?>
                                    <img src="<?php echo base_url('assets/images/icons/40porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>40 && $nivel->pdesemp<=50){?>
                                    <img src="<?php echo base_url('assets/images/icons/50porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>50 && $nivel->pdesemp<=60){?>
                                    <img src="<?php echo base_url('assets/images/icons/60porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>60 && $nivel->pdesemp<=70){?>
                                    <img src="<?php echo base_url('assets/images/icons/70porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>70 && $nivel->pdesemp<=80){?>
                                    <img src="<?php echo base_url('assets/images/icons/80porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp>80 && $nivel->pdesemp<=99){?>
                                    <img src="<?php echo base_url('assets/images/icons/90porcentonivel_amarelo.png')?>">
                                <?php }?>
                                <?php if($nivel->pdesemp==100){?>
                                    <img src="<?php echo base_url('assets/images/icons/100porcentonivel_amarelo.png')?>">
                                <?php }?>
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
        parametros=cd_nivel+"/"+$("#cd_turma").val()+"/"+$("#cd_avaliacao").val();            
    var url ='<?=base_url("relatorio/relatorio/excelniveldesempenho/")?>'+parametros;    
    window.open(url, '_parent');    
    }   
</script>