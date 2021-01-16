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
<script src="<?=base_url('assets/highcharts/code/highcharts.js'); ?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/series-label.js'); ?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/exporting.js'); ?>"></script>
<script src="<?=base_url('assets/highcharts/code/modules/export-data.js'); ?>"></script>

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
    }
</script>
<div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'LeituraXEscrita por Município' ?></h4>
            </p>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container card-box">
        <form action="" method="post" id="evolucaomunicipio" name="evolucaomunicipio">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados-->

                        <div class="col-lg-3">

                            <label>Estados *</label>
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
                                <label>Municípios *</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="15"
                                        
                                        onchange="populaescola(this.value);"
                                        class="form-control" >
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
                    <?php }?> <!-- Fim grupo scola -->
                    <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa *</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control" 
                                    onchange="populadisciplina()">
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
           <div class="col-md-4">
                <div class="form-group">
                    <label for="cd_disciplina">Disciplina *</label>
                    <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control">
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
            <div class="col-md-4">
                    <div class="form-group">
                        <label for="nr_anoletivo">Ano Letivo *</label>
                        <input type="hidden" id="anoatual" name="anoatual" value="<?=$anoatual?>"/>
                        <select id="nr_anoletivo" 
                                    name="nr_anoletivo" 
                                    tabindex="3"
                                    class="form-control">
                                <?php echo $anos ?>
                            </select>
                    </div>
                </div>
            <div class="col-md-5">
                <div class="form-group">
                        <label for="cd_disciplina">Tipo do Relatório *</label>
                        <input type="radio" name="rd_rel" id="rel_m" value="M" tabindex="1">
                        <label class="form-check-label" for="sexo_m">M&ecirc;s &nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" name="rd_rel" id="rel_a" value="A" tabindex="1">
                        <label class="form-check-label" for="sexo_m">Ano &nbsp;&nbsp;&nbsp;</label>
                </div>
            </div>
            <div class="col-md-5" style="display: none;">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div> 
        </form>
    </div>
   <div class="container card-box"> 
        <div class="table-responsive" id="listagem_resultado"></div>
    </div>    
</div>
<script src="<?=base_url('assets/js/evolucaomunicipio.js'); ?>"></script>
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