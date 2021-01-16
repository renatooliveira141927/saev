<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabarito.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep').toUpperCase());
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
    function habilitaGabarito(combo,aluno){
        if(combo.value==1){
            $('#divGabarito_aluno_'+aluno).removeAttr('style');    
            $('#button'+aluno).removeAttr('style');    
        }else if(combo.value!=0){
            $('#divGabarito_aluno_'+aluno).attr("style", "display: none;");
            $('#button'+aluno).removeAttr('style');
        }else{
            $('#divGabarito_aluno_'+aluno).attr("style", "display: none;");
            $('#button'+aluno).attr("style", "display: none;");
        }       
    }
</script>

    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Lançar Resultados-Escrita' ?></h4>
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

                            <label>Estados </label>
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
                                        disabled
                                        onchange="populaescola(this.value);"
                                        class="form-control" >
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
                                        disabled
                                        class="form-control"
                                        onchange="escola_selecionda(this.value);">
                                    <Option value="" nr_inep=""></Option>

                                </select>
                            </div>
                        </div>

                    <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                        <div class="form-group col-lg-3">
                            <label>Estados </label>
                            <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                        </div>
                        <div class="col-lg-9">
                            <div  class="form-group">
                                <label>Municípios </label>
                                <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
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
                            <label for="cd_etapa">Etapa </label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control" disabled
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
                    <?php }else{?>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa </label>
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
                    <?php } ?>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cd_turma">Turma </label>
                            <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control" disabled
                                    onchange="populadisciplina()">
                                <option value="">Selecione uma Turma</option>
                                <?php
                                foreach ($turmas as $item) {
                                    ?>

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
                            <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control" disabled
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
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cd_avaliacao">Avaliação </label>
                            <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control" disabled
                                    onchange="ativaConsulta()">
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
                    <div class="col-md-5">
                        <div class="form-group">
                            <button type="submit" id="btn_consulta" disabled="disabled"
                                    tabindex="9"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                Gerar
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    <!-- Inicio Div Gabarito -->
            <div id="dadosgabaritoAdd" name="dadosgabaritoAdd">
                <?php
                $alunoAtual = 0;
                if(isset($registros)){
                    foreach ($registros as $result) { $inserido=$result->cd_situacao_aluno?$result->cd_situacao_aluno:0; ?>
                        <div class='container-fluid card-box'>
                            <form id='formInsertEdit_aluno<?=$result->ci_aluno?>' method='post' class='form'>
                                <div  class='col-md-12'>
                                    <div class='col-md-12 form-group'style="background-color:#c9cccf" >
                                        <div class='col-md-8'>
                                            <label >Matrícula:<?=$result->ci_aluno?></label>
                                            <input type='hidden' id='cd_aluno' name='cd_aluno' class="cd_aluno" value='<?=$result->ci_aluno?>'>
                                            <label >Nome:<?=$result->nm_aluno?></label>
                                        </div>
                                        <div class='col-md-4'>
                                            <select id='cd_participou' name='cd_participou' tabindex='10'
                                                    class='form-control'
                                                    onchange="habilitaGabarito(this,<?=$result->ci_aluno?>);">
                                                <option value='0'>Selecione uma Alternativa</option>
                                                <option value='1' <?php if($result->cd_situacao_aluno==1){echo 'selected';}else{echo '';} ?> >1 - REALIZOU A ATIVIDADE</option>
                                                <option value='2' <?php if($result->cd_situacao_aluno==2){echo 'selected';}else{echo '';} ?> >2 - RECUSOU-SE A PARTICIPAR</option>
                                                <option value='3' <?php if($result->cd_situacao_aluno==3){echo 'selected';}else{echo '';} ?> >3 - FALTOU MAS ESTA FREQUENTANDO A ESCOLA</option>
                                                <option value='4' <?php if($result->cd_situacao_aluno==4){echo 'selected';}else{echo '';} ?> >4 - ABANDONOU A ESCOLA</option>
                                                <option value='5' <?php if($result->cd_situacao_aluno==5){echo 'selected';}else{echo '';} ?> >5 - FOI TRANSFERIDO PARA OUTRA ESCOLA</option>
                                                <option value='6' <?php if($result->cd_situacao_aluno==6){echo 'selected';}else{echo '';} ?> >6 - NAO PARTICIPOU - OUTRAS SITUACOES</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                        <div id='divGabarito_aluno_<?=$result->ci_aluno?>' 
                                            style="display: none;">
                                            <?php
                                            foreach ($itens as $resul) {                 
                                                //if($result->cd_situacao_aluno!=1){
                                                    ?>
                                                    <div class='col-md-2' >
                                                        <label><?=$resul->nr_questao?></label>
                                                        <input type='hidden' name='itens[]' value='<?=$resul->ci_avaliacao_matriz?>'>
                                                        <select id='cd_item' name='cd_item[]' class='form-control' >
                                                            <option value=''>Selecione</option>
                                                            <option value='1' >A</option>
                                                            <option value='2' >B</option>
                                                            <option value='3' >C</option>
                                                            <option value='4' >D</option>
                                                        </select>
                                                    </div>
                                               <?php }?>
                                        </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='col-md-4' id="inserido<?=$result->ci_aluno?>" 
                                        <?php if($inserido=='0'){ echo 'hidden';}?> >
                                        <div id ="divGravado" style="background-color:#00cc66">
                                            <label style="color:white"> 
                                                <?php if($inserido!='0'){ echo 'Resultado Já Inserido';}else{
                                             echo 'Resultado Gravado com sucesso!';
                                            }?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class='col-md-12'>
                                    <div class='form-group' id="button<?=$result->ci_aluno?>"
                                       style="display: none;" >
                                        <button class="btn btn-primary bt_form waves-effect waves-light btn-micro">Salvar</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    <?php  } }?>
            </div>
    </div>