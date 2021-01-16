<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/relatorio/relatorio.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
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
</script>
<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Relatório: Resultado por Estudante' ?></h4>
            </p>
        </div>
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
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_avaliacao">Avaliação </label>
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control">
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
                    <button type="submit" id="btn_consultaestudante"
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
    <div class="card-box" id="listagem_resultado">
        <div class="table-responsive align-text-middle" id="tabs">
            <ul>
                <li><a href="#tabs-1">Agrupado por Tópico</a></li>
                <li><a href="#tabs-2">Agrupado por Descritor</a></li>
            </ul>

            <div class="col-md-12" id="tabs-1">
                    <?php $alunoAtual=0;
                    if(isset($registros)){
                        foreach ($registros as $result) {
                            if($alunoAtual!=$result->ci_aluno){?>
                                <div class='container-fluid col-md-10'>
                                    <input type='hidden' id='cd_aluno' name='cd_aluno' value='<?=$result->ci_aluno?>'>
                                        <div class='col-md-12 form-group' style="background-color:#1c7430">
                                            <div class='col-md-12'>
                                                <label style="color:white">Aluno:<?=$result->nm_aluno?></label>
                                            </div>
                                        </div>
                                </div>
                                <div class='col-md-6 form-group' style="background-color:#c9cccf">
                                    <div class='col-md-6'>
                                        <label><?=$result->topico?></label>
                                    </div>
                                    <div class='col-md-3'>
                                        <label> % Acerto:<?=$result->pacerto?></label>
                                    </div>
                                </div>
                        <?php }else{ ?>
                                <div class='col-md-6 form-group' style="background-color:#c9cccf">
                                    <div class='col-md-6'>
                                        <label><?=$result->topico?></label>
                                    </div>
                                    <div class='col-md-3'>
                                        <label> % Acerto:<?=$result->pacerto?></label>
                                    </div>
                                </div>
                        <?php }$alunoAtual=$result->ci_aluno;}
                        }?>
            </div>

            <div class="col-md-12" id="tabs-2">
                <?php $alunoAtual=0;
                if(isset($registrosDesc)){
                    foreach ($registrosDesc as $result) {
                        if($alunoAtual!=$result->ci_aluno){?>
                            <div class='container-fluid col-md-10'>
                                <input type='hidden' id='cd_aluno' name='cd_aluno' value='<?=$result->ci_aluno?>'>
                                <div class='col-md-12 form-group' style="background-color:#1c7430">
                                    <div class='col-md-12'>
                                        <label style="color:white">Aluno:<?=$result->nm_aluno?></label>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6 form-group' style="background-color:#c9cccf">
                                <div class='col-md-6'>
                                    <label><?=$result->descritor?></label>
                                </div>
                                <div class='col-md-3'>
                                    <label> % Acerto:<?=$result->pacerto?></label>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class='col-md-6 form-group' style="background-color:#c9cccf">
                                <div class='col-md-6'>
                                    <label><?=$result->descritor?></label>
                                </div>
                                <div class='col-md-3'>
                                    <label> % Acerto:<?=$result->pacerto?></label>
                                </div>
                            </div>
                        <?php }$alunoAtual=$result->ci_aluno;}
                }?>
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
</script>