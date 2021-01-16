<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabarito.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<div class="container">
    <div class="page-title-box">
        <div class="col-md-10" style="text-align: left">
            <p>
            <h4 class="page-title"><?php echo 'Relatório: Resultado por Escola' ?></h4>
            </p>
        </div>
    </div>
    <form action="" method="post">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        <div class="container-fluid col-md-10 card-box">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="nr_inep_escola">Inep da escola</label>
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
            <div class="col-md-5">
                <div class="form-group">
                    <label for="cd_etapa">Etapa </label>
                    <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control"
                            onchange="populaturma(this.value)">
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
                    <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control" >
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
        </div>
    </form>
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