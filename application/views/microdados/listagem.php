<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/metasaprendizagem.js'); ?>"></script>
<style>
.ScrollStyle
{
    max-height: 1500px;
    overflow-y: scroll;
}
</style>


    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>    
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Consultar Importação Microdados'?></h4>
                </p>
            </div>
        </div>
    </div>
    
    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container card-box">
        <form action="<?php echo base_url('microdados/microdados/relatorio'); ?>" method="get" id="consulta" name="consulta">            
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        		
                 <div  class="col-lg-4">
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
                <div  class="col-lg-6">
                        <div class="form-group">
                            <label for="cd_disciplina">Disciplina</label>                            
                            <select id="cd_disciplina" 
                                        name="cd_disciplina" 
                                        tabindex="3"
                                        class="form-control">
                                    <Option value=""></Option>
                                <?php
                                foreach ($disciplinas as $item) {?>
                                    <Option value="<?php echo $item->ci_disciplina; ?>"
                                    <?php if ($cd_disciplina == $item->ci_disciplina){
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
                    <button type="button" id="btn_consulta"
                            tabindex="9" onclick="validaForm();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Consultar
                    </button>
                </div>
            </div>
      		<div class="col-md-5">
                <a href="javascript:printPage();" class="pull-right hidden-print"><i class="fa fa-print"></i> Imprimir</a>
            </div>                   
    </form>       
  </div>  
  
  <div class="container card-box"> 
        <div class="ScrollStyle table-responsive" id="listagem_resultado">
        	Total de registros:<?= $totalregistros?>	
        	<div class="col-lg-12">                    
                <table class="table table-striped table-hover">
                	<thead>	
                    	<tr>
<td align="center">cd_projeto</td>
<td align="center">nm_projeto</td>
<td align="center">nu_ano</td>
<td align="center">cd_estado</td>
<td align="center">nm_estado</td>
<td align="center">cd_regional</td>
<td align="center">nm_regional</td>
<td align="center">cd_municipio</td>
<td align="center">nm_municipio</td>
<td align="center">cd_escola</td>
<td align="center">nm_escola</td>
<td align="center">cd_rede</td>
<td align="center">dc_rede</td>
<td align="center">cd_localizacao</td>
<td align="center">dc_localizacao</td>
<td align="center">cd_turma</td>
<td align="center">cd_turma_instituicao</td>
<td align="center">nm_turma</td>
<td align="center">cd_turno</td>
<td align="center">dc_turno</td>
<td align="center">fl_multi_turma</td>
<td align="center">fl_anexo_turma</td>
<td align="center">cd_ensino</td>
<td align="center">dc_ensino</td>
<td align="center">cd_aluno</td>
<td align="center">cd_aluno_institucional</td>
<td align="center">cd_aluno_inep</td>
<td align="center">cd_aluno_publicacao</td>
<td align="center">nm_aluno</td>
<td align="center">dt_nascimento</td>
<td align="center">cd_sexo</td>
<td align="center">filiacao</td>
<td align="center">dc_deficiencia</td>
<td align="center">nm_disciplina_caderno</td>
<td align="center">cd_disciplin</td>
<td align="center">nm_disciplina</td>
<td align="center">nm_disciplina_sigla</td>
<td align="center">cd_etapa_aplicacao</td>
<td align="center">dc_etapa_aplicacao</td>
<td align="center">cd_etapa_avaliada</td>
<td align="center">dc_etapa_avaliada</td>
<td align="center">cd_etapa</td>
<td align="center">cd_etapa_publicacao</td>
<td align="center">dc_etapa_publicacao</td>
<td align="center">cd_caderno</td>
<td align="center">dc_caderno</td>
<td align="center">nu_caderno</td>
<td align="center">cd_base_versao</td>
<td align="center">nu_sequencial</td>
<td align="center">fl_filtros</td>
<td align="center">dc_filtros</td>
<td align="center">fl_plan_extra</td>
<td align="center">fl_extra</td>
<td align="center">fl_aln_extra</td>
<td align="center">fl_publicacao</td>
<td align="center">dc_publicacao</td>
<td align="center">fl_excluido_planejada</td>
<td align="center">fl_excluido_sujeito</td>
<td align="center">fl_avaliado</td>
<td align="center">fl_preenchido</td>
<td align="center">vl_proficiencia</td>
<td align="center">vl_proficiencia_erro</td>
<td align="center">nu_pontos</td>
<td align="center">vl_perc_acertos</td>
<td align="center">id_mascara</td>
<td align="center">cd_lote</td>
<td align="center">nu_pacote</td>
<td align="center">dc_imagem_cartao</td>
<td align="center">dc_imagem_lista</td>
<td align="center">dc_imagem_ata</td>
<td align="center">dc_imagem_reserva</td>
<td align="center">nu_imagem</td>
<td align="center">id_instrumento</td>
<td align="center">tp_instrumento</td>
<td align="center">dc_desenho_instrumento</td>
<td align="center">tp_processamento</td>
<td align="center">rp</td>
<td align="center">rp_001</td>
<td align="center">rp_002</td>
<td align="center">rp_003</td>
<td align="center">rp_004</td>
<td align="center">rp_005</td>
<td align="center">rp_006</td>
<td align="center">rp_007</td>
<td align="center">rp_008</td>
<td align="center">rp_009</td>
<td align="center">rp_010</td>
<td align="center">rp_011</td>
<td align="center">rp_012</td>
<td align="center">rp_013</td>
<td align="center">rp_014</td>
<td align="center">rp_015</td>
<td align="center">rp_016</td>
<td align="center">rp_017</td>
<td align="center">rp_018</td>
<td align="center">rp_019</td>
<td align="center">rp_020</td>
<td align="center">rp_021</td>
<td align="center">rp_022</td>
<td align="center">rp_023</td>
<td align="center">rp_024</td>
<td align="center">rp_025</td>
<td align="center">rp_026</td>
<td align="center">rp_027</td>
<td align="center">rp_028</td>
<td align="center">rp_029</td>
<td align="center">rp_030</td>
<td align="center">rp_031</td>
<td align="center">rp_032</td>
<td align="center">rp_033</td>
<td align="center">rp_034</td>
<td align="center">rp_035</td>
<td align="center">rp_036</td>
<td align="center">rp_037</td>
<td align="center">rp_038</td>
<td align="center">rp_039</td>
<td align="center">rp_040</td>
<td align="center">rp_041</td>
<td align="center">rp_042</td>
<td align="center">rp_043</td>
<td align="center">rp_044</td>
<td align="center">rp_045</td>
<td align="center">rp_046</td>
<td align="center">rp_047</td>
<td align="center">rp_048</td>
<td align="center">rp_049</td>
<td align="center">rp_050</td>
<td align="center">rp_051</td>
<td align="center">rp_052</td>
<td align="center">rp_053</td>
<td align="center">rp_054</td>
<td align="center">rp_055</td>
<td align="center">rp_056</td>
<td align="center">rp_057</td>
<td align="center">rp_059</td>
<td align="center">rp_058</td>
<td align="center">rpa_001</td>
<td align="center">rpa_002</td>
<td align="center">rpa_003</td>
<td align="center">rpa_004</td>
<td align="center">rpa_005</td>
<td align="center">rpa_006</td>
<td align="center">rpa_007</td>
<td align="center">rpa_008</td>
<td align="center">rpa_009</td>
<td align="center">rpa_010</td>
<td align="center">rpa_011</td>
<td align="center">rpa_012</td>
<td align="center">rpa_013</td>
<td align="center">rpa_014</td>
<td align="center">rpa_015</td>
<td align="center">rpa_016</td>
<td align="center">rpa_017</td>
<td align="center">rpa_018</td>
<td align="center">rpa_019</td>
<td align="center">rpa_020</td>
<td align="center">rpa_021</td>
<td align="center">rpa_022</td>
<td align="center">rpa_023</td>
<td align="center">rpa_024</td>
<td align="center">rpa_025</td>
<td align="center">rpa_026</td>
<td align="center">rpa_027</td>
<td align="center">rpa_028</td>
<td align="center">rpa_029</td>
<td align="center">rpa_030</td>
<td align="center">rpa_031</td>
<td align="center">rpa_032</td>
<td align="center">rpa_033</td>
<td align="center">rpa_034</td>
<td align="center">rpa_035</td>
<td align="center">rpa_036</td>
<td align="center">rpa_037</td>
<td align="center">rpa_038</td>
<td align="center">rpa_039</td>
<td align="center">rpa_040</td>
<td align="center">rpa_041</td>
<td align="center">rpa_042</td>
<td align="center">rpa_043</td>
<td align="center">rpa_044</td>
<td align="center">rpa_045</td>
<td align="center">rpa_046</td>
<td align="center">rpa_047</td>
<td align="center">rpa_048</td>
<td align="center">rpa_049</td>
<td align="center">rpa_050</td>
<td align="center">rpa_051</td>
<td align="center">rpa_052</td>
<td align="center">rpa_053</td>
<td align="center">rpa_054</td>
<td align="center">rpa_055</td>
<td align="center">rpa_056</td>
<td align="center">rpa_057</td>
<td align="center">rpa_058</td>
<td align="center">rpa_059</td>
<td align="center">rpa_060</td>
<td align="center">rpa_061</td>
<td align="center">rpa_062</td>
<td align="center">rpa_063</td>
<td align="center">rpa_064</td>
<td align="center">rpa_065</td>
<td align="center">rpa_066</td>
<td align="center">rpa_067</td>
<td align="center">rpa_068</td>
<td align="center">rpa_069</td>
<td align="center">rpa_070</td>
<td align="center">rpa_071</td>
<td align="center">rpa_072</td>
<td align="center">rpa_073</td>
<td align="center">rpa_074</td>
<td align="center">rpa_075</td>
<td align="center">rpa_076</td>
<td align="center">rpa_077</td>
<td align="center">rpa_078</td>
<td align="center">rpa_079</td>
<td align="center">rpa_080</td>
<td align="center">rpa_081</td>
<td align="center">rpa_082</td>
<td align="center">rpa_083</td>
<td align="center">rpa_084</td>
<td align="center">rpa_085</td>
<td align="center">rpa_086</td>
<td align="center">rpa_087</td>
<td align="center">rpa_088</td>
<td align="center">rpa_089</td>
<td align="center">rpa_090</td>
<td align="center">rpa_091</td>
<td align="center">nu_posicao_lista</td>
<td align="center">rp_lista</td>
<td align="center">dc_turno_escola</td>
<td align="center">tipo</td>
<td align="center">fl_esc_tecnica</td>
<td align="center">fl_seama</td>
<td align="center">fl_saepe</td>
<td align="center">d001_acerto</td>
<td align="center">d001_total</td>
<td align="center">d002_acerto</td>
<td align="center">d002_total</td>
<td align="center">d003_acerto</td>
<td align="center">d003_total</td>
<td align="center">d004_acerto</td>
<td align="center">d004_total</td>
<td align="center">d005_acerto</td>
<td align="center">d005_total</td>
<td align="center">d007_acerto</td>
<td align="center">d007_total</td>
<td align="center">d008_acerto</td>
<td align="center">d008_total</td>
<td align="center">d009_acerto</td>
<td align="center">d009_total</td>
<td align="center">d010_acerto</td>
<td align="center">d010_total</td>
<td align="center">d011_acerto</td>
<td align="center">d011_total</td>
<td align="center">d012_acerto</td>
<td align="center">d012_total</td>
<td align="center">d013_acerto</td>
<td align="center">d013_total</td>
<td align="center">d014_acerto</td>
<td align="center">d014_total</td>
<td align="center">d015_acerto</td>
<td align="center">d015_total</td>
<td align="center">d016_acerto</td>
<td align="center">d016_total</td>
<td align="center">d017_acerto</td>
<td align="center">d017_total</td>
<td align="center">d018_acerto</td>
<td align="center">d018_total</td>
<td align="center">d019_acerto</td>
<td align="center">d019_total</td>
<td align="center">d020_acerto</td>
<td align="center">d020_total</td>
<td align="center">d021_acerto</td>
<td align="center">d021_total</td>
<td align="center">d022_acerto</td>
<td align="center">d022_total</td>
<td align="center">d023_acerto</td>
<td align="center">d023_total</td>
<td align="center">d024_acerto</td>
<td align="center">d024_total</td>
<td align="center">d025_acerto</td>
<td align="center">d025_total</td>
<td align="center">d026_acerto</td>
<td align="center">d026_total</td>
                    	</tr>
                 	</thead>
                 	<tbody>
                 	<?php $count=0; 
                 	if(!empty($microdados)){
                 	    foreach ($microdados as $result) {
                    	       $count++;?>
                 		<tr>
                 			<td align="center"><?= $result->cd_projeto; ?></td>
<td align="center"><?= $result->nm_projeto; ?></td>
<td align="center"><?= $result->nu_ano; ?></td>
<td align="center"><?= $result->cd_estado; ?></td>
<td align="center"><?= $result->nm_estado; ?></td>
<td align="center"><?= $result->cd_regional; ?></td>
<td align="center"><?= $result->nm_regional; ?></td>
<td align="center"><?= $result->cd_municipio; ?></td>
<td align="center"><?= $result->nm_municipio; ?></td>
<td align="center"><?= $result->cd_escola; ?></td>
<td align="center"><?= $result->nm_escola; ?></td>
<td align="center"><?= $result->cd_rede; ?></td>
<td align="center"><?= $result->dc_rede; ?></td>
<td align="center"><?= $result->cd_localizacao; ?></td>
<td align="center"><?= $result->dc_localizacao; ?></td>
<td align="center"><?= $result->cd_turma; ?></td>
<td align="center"><?= $result->cd_turma_instituicao; ?></td>
<td align="center"><?= $result->nm_turma; ?></td>
<td align="center"><?= $result->cd_turno; ?></td>
<td align="center"><?= $result->dc_turno; ?></td>
<td align="center"><?= $result->fl_multi_turma; ?></td>
<td align="center"><?= $result->fl_anexo_turma; ?></td>
<td align="center"><?= $result->cd_ensino; ?></td>
<td align="center"><?= $result->dc_ensino; ?></td>
<td align="center"><?= $result->cd_aluno; ?></td>
<td align="center"><?= $result->cd_aluno_institucional; ?></td>
<td align="center"><?= $result->cd_aluno_inep; ?></td>
<td align="center"><?= $result->cd_aluno_publicacao; ?></td>
<td align="center"><?= $result->nm_aluno; ?></td>
<td align="center"><?= $result->dt_nascimento; ?></td>
<td align="center"><?= $result->cd_sexo; ?></td>
<td align="center"><?= $result->filiacao; ?></td>
<td align="center"><?= $result->dc_deficiencia; ?></td>
<td align="center"><?= $result->nm_disciplina_caderno; ?></td>
<td align="center"><?= $result->cd_disciplin; ?></td>
<td align="center"><?= $result->nm_disciplina; ?></td>
<td align="center"><?= $result->nm_disciplina_sigla; ?></td>
<td align="center"><?= $result->cd_etapa_aplicacao; ?></td>
<td align="center"><?= $result->dc_etapa_aplicacao; ?></td>
<td align="center"><?= $result->cd_etapa_avaliada; ?></td>
<td align="center"><?= $result->dc_etapa_avaliada; ?></td>
<td align="center"><?= $result->cd_etapa; ?></td>
<td align="center"><?= $result->cd_etapa_publicacao; ?></td>
<td align="center"><?= $result->dc_etapa_publicacao; ?></td>
<td align="center"><?= $result->cd_caderno; ?></td>
<td align="center"><?= $result->dc_caderno; ?></td>
<td align="center"><?= $result->nu_caderno; ?></td>
<td align="center"><?= $result->cd_base_versao; ?></td>
<td align="center"><?= $result->nu_sequencial; ?></td>
<td align="center"><?= $result->fl_filtros; ?></td>
<td align="center"><?= $result->dc_filtros; ?></td>
<td align="center"><?= $result->fl_plan_extra; ?></td>
<td align="center"><?= $result->fl_extra; ?></td>
<td align="center"><?= $result->fl_aln_extra; ?></td>
<td align="center"><?= $result->fl_publicacao; ?></td>
<td align="center"><?= $result->dc_publicacao; ?></td>
<td align="center"><?= $result->fl_excluido_planejada; ?></td>
<td align="center"><?= $result->fl_excluido_sujeito; ?></td>
<td align="center"><?= $result->fl_avaliado; ?></td>
<td align="center"><?= $result->fl_preenchido; ?></td>
<td align="center"><?= $result->vl_proficiencia; ?></td>
<td align="center"><?= $result->vl_proficiencia_erro; ?></td>
<td align="center"><?= $result->nu_pontos; ?></td>
<td align="center"><?= $result->vl_perc_acertos; ?></td>
<td align="center"><?= $result->id_mascara; ?></td>
<td align="center"><?= $result->cd_lote; ?></td>
<td align="center"><?= $result->nu_pacote; ?></td>
<td align="center"><?= $result->dc_imagem_cartao; ?></td>
<td align="center"><?= $result->dc_imagem_lista; ?></td>
<td align="center"><?= $result->dc_imagem_ata; ?></td>
<td align="center"><?= $result->dc_imagem_reserva; ?></td>
<td align="center"><?= $result->nu_imagem; ?></td>
<td align="center"><?= $result->id_instrumento; ?></td>
<td align="center"><?= $result->tp_instrumento; ?></td>
<td align="center"><?= $result->dc_desenho_instrumento; ?></td>
<td align="center"><?= $result->tp_processamento; ?></td>
<td align="center"><?= $result->rp; ?></td>
<td align="center"><?= $result->rp_001; ?></td>
<td align="center"><?= $result->rp_002; ?></td>
<td align="center"><?= $result->rp_003; ?></td>
<td align="center"><?= $result->rp_004; ?></td>
<td align="center"><?= $result->rp_005; ?></td>
<td align="center"><?= $result->rp_006; ?></td>
<td align="center"><?= $result->rp_007; ?></td>
<td align="center"><?= $result->rp_008; ?></td>
<td align="center"><?= $result->rp_009; ?></td>
<td align="center"><?= $result->rp_010; ?></td>
<td align="center"><?= $result->rp_011; ?></td>
<td align="center"><?= $result->rp_012; ?></td>
<td align="center"><?= $result->rp_013; ?></td>
<td align="center"><?= $result->rp_014; ?></td>
<td align="center"><?= $result->rp_015; ?></td>
<td align="center"><?= $result->rp_016; ?></td>
<td align="center"><?= $result->rp_017; ?></td>
<td align="center"><?= $result->rp_018; ?></td>
<td align="center"><?= $result->rp_019; ?></td>
<td align="center"><?= $result->rp_020; ?></td>
<td align="center"><?= $result->rp_021; ?></td>
<td align="center"><?= $result->rp_022; ?></td>
<td align="center"><?= $result->rp_023; ?></td>
<td align="center"><?= $result->rp_024; ?></td>
<td align="center"><?= $result->rp_025; ?></td>
<td align="center"><?= $result->rp_026; ?></td>
<td align="center"><?= $result->rp_027; ?></td>
<td align="center"><?= $result->rp_028; ?></td>
<td align="center"><?= $result->rp_029; ?></td>
<td align="center"><?= $result->rp_030; ?></td>
<td align="center"><?= $result->rp_031; ?></td>
<td align="center"><?= $result->rp_032; ?></td>
<td align="center"><?= $result->rp_033; ?></td>
<td align="center"><?= $result->rp_034; ?></td>
<td align="center"><?= $result->rp_035; ?></td>
<td align="center"><?= $result->rp_036; ?></td>
<td align="center"><?= $result->rp_037; ?></td>
<td align="center"><?= $result->rp_038; ?></td>
<td align="center"><?= $result->rp_039; ?></td>
<td align="center"><?= $result->rp_040; ?></td>
<td align="center"><?= $result->rp_041; ?></td>
<td align="center"><?= $result->rp_042; ?></td>
<td align="center"><?= $result->rp_043; ?></td>
<td align="center"><?= $result->rp_044; ?></td>
<td align="center"><?= $result->rp_045; ?></td>
<td align="center"><?= $result->rp_046; ?></td>
<td align="center"><?= $result->rp_047; ?></td>
<td align="center"><?= $result->rp_048; ?></td>
<td align="center"><?= $result->rp_049; ?></td>
<td align="center"><?= $result->rp_050; ?></td>
<td align="center"><?= $result->rp_051; ?></td>
<td align="center"><?= $result->rp_052; ?></td>
<td align="center"><?= $result->rp_053; ?></td>
<td align="center"><?= $result->rp_054; ?></td>
<td align="center"><?= $result->rp_055; ?></td>
<td align="center"><?= $result->rp_056; ?></td>
<td align="center"><?= $result->rp_057; ?></td>
<td align="center"><?= $result->rp_059; ?></td>
<td align="center"><?= $result->rp_058; ?></td>
<td align="center"><?= $result->rpa_001; ?></td>
<td align="center"><?= $result->rpa_002; ?></td>
<td align="center"><?= $result->rpa_003; ?></td>
<td align="center"><?= $result->rpa_004; ?></td>
<td align="center"><?= $result->rpa_005; ?></td>
<td align="center"><?= $result->rpa_006; ?></td>
<td align="center"><?= $result->rpa_007; ?></td>
<td align="center"><?= $result->rpa_008; ?></td>
<td align="center"><?= $result->rpa_009; ?></td>
<td align="center"><?= $result->rpa_010; ?></td>
<td align="center"><?= $result->rpa_011; ?></td>
<td align="center"><?= $result->rpa_012; ?></td>
<td align="center"><?= $result->rpa_013; ?></td>
<td align="center"><?= $result->rpa_014; ?></td>
<td align="center"><?= $result->rpa_015; ?></td>
<td align="center"><?= $result->rpa_016; ?></td>
<td align="center"><?= $result->rpa_017; ?></td>
<td align="center"><?= $result->rpa_018; ?></td>
<td align="center"><?= $result->rpa_019; ?></td>
<td align="center"><?= $result->rpa_020; ?></td>
<td align="center"><?= $result->rpa_021; ?></td>
<td align="center"><?= $result->rpa_022; ?></td>
<td align="center"><?= $result->rpa_023; ?></td>
<td align="center"><?= $result->rpa_024; ?></td>
<td align="center"><?= $result->rpa_025; ?></td>
<td align="center"><?= $result->rpa_026; ?></td>
<td align="center"><?= $result->rpa_027; ?></td>
<td align="center"><?= $result->rpa_028; ?></td>
<td align="center"><?= $result->rpa_029; ?></td>
<td align="center"><?= $result->rpa_030; ?></td>
<td align="center"><?= $result->rpa_031; ?></td>
<td align="center"><?= $result->rpa_032; ?></td>
<td align="center"><?= $result->rpa_033; ?></td>
<td align="center"><?= $result->rpa_034; ?></td>
<td align="center"><?= $result->rpa_035; ?></td>
<td align="center"><?= $result->rpa_036; ?></td>
<td align="center"><?= $result->rpa_037; ?></td>
<td align="center"><?= $result->rpa_038; ?></td>
<td align="center"><?= $result->rpa_039; ?></td>
<td align="center"><?= $result->rpa_040; ?></td>
<td align="center"><?= $result->rpa_041; ?></td>
<td align="center"><?= $result->rpa_042; ?></td>
<td align="center"><?= $result->rpa_043; ?></td>
<td align="center"><?= $result->rpa_044; ?></td>
<td align="center"><?= $result->rpa_045; ?></td>
<td align="center"><?= $result->rpa_046; ?></td>
<td align="center"><?= $result->rpa_047; ?></td>
<td align="center"><?= $result->rpa_048; ?></td>
<td align="center"><?= $result->rpa_049; ?></td>
<td align="center"><?= $result->rpa_050; ?></td>
<td align="center"><?= $result->rpa_051; ?></td>
<td align="center"><?= $result->rpa_052; ?></td>
<td align="center"><?= $result->rpa_053; ?></td>
<td align="center"><?= $result->rpa_054; ?></td>
<td align="center"><?= $result->rpa_055; ?></td>
<td align="center"><?= $result->rpa_056; ?></td>
<td align="center"><?= $result->rpa_057; ?></td>
<td align="center"><?= $result->rpa_058; ?></td>
<td align="center"><?= $result->rpa_059; ?></td>
<td align="center"><?= $result->rpa_060; ?></td>
<td align="center"><?= $result->rpa_061; ?></td>
<td align="center"><?= $result->rpa_062; ?></td>
<td align="center"><?= $result->rpa_063; ?></td>
<td align="center"><?= $result->rpa_064; ?></td>
<td align="center"><?= $result->rpa_065; ?></td>
<td align="center"><?= $result->rpa_066; ?></td>
<td align="center"><?= $result->rpa_067; ?></td>
<td align="center"><?= $result->rpa_068; ?></td>
<td align="center"><?= $result->rpa_069; ?></td>
<td align="center"><?= $result->rpa_070; ?></td>
<td align="center"><?= $result->rpa_071; ?></td>
<td align="center"><?= $result->rpa_072; ?></td>
<td align="center"><?= $result->rpa_073; ?></td>
<td align="center"><?= $result->rpa_074; ?></td>
<td align="center"><?= $result->rpa_075; ?></td>
<td align="center"><?= $result->rpa_076; ?></td>
<td align="center"><?= $result->rpa_077; ?></td>
<td align="center"><?= $result->rpa_078; ?></td>
<td align="center"><?= $result->rpa_079; ?></td>
<td align="center"><?= $result->rpa_080; ?></td>
<td align="center"><?= $result->rpa_081; ?></td>
<td align="center"><?= $result->rpa_082; ?></td>
<td align="center"><?= $result->rpa_083; ?></td>
<td align="center"><?= $result->rpa_084; ?></td>
<td align="center"><?= $result->rpa_085; ?></td>
<td align="center"><?= $result->rpa_086; ?></td>
<td align="center"><?= $result->rpa_087; ?></td>
<td align="center"><?= $result->rpa_088; ?></td>
<td align="center"><?= $result->rpa_089; ?></td>
<td align="center"><?= $result->rpa_090; ?></td>
<td align="center"><?= $result->rpa_091; ?></td>
<td align="center"><?= $result->nu_posicao_lista; ?></td>
<td align="center"><?= $result->rp_lista; ?></td>
<td align="center"><?= $result->dc_turno_escola; ?></td>
<td align="center"><?= $result->tipo; ?></td>
<td align="center"><?= $result->fl_esc_tecnica; ?></td>
<td align="center"><?= $result->fl_seama; ?></td>
<td align="center"><?= $result->fl_saepe; ?></td>
<td align="center"><?= $result->d001_acerto; ?></td>
<td align="center"><?= $result->d001_total; ?></td>
<td align="center"><?= $result->d002_acerto; ?></td>
<td align="center"><?= $result->d002_total; ?></td>
<td align="center"><?= $result->d003_acerto; ?></td>
<td align="center"><?= $result->d003_total; ?></td>
<td align="center"><?= $result->d004_acerto; ?></td>
<td align="center"><?= $result->d004_total; ?></td>
<td align="center"><?= $result->d005_acerto; ?></td>
<td align="center"><?= $result->d005_total; ?></td>
<td align="center"><?= $result->d007_acerto; ?></td>
<td align="center"><?= $result->d007_total; ?></td>
<td align="center"><?= $result->d008_acerto; ?></td>
<td align="center"><?= $result->d008_total; ?></td>
<td align="center"><?= $result->d009_acerto; ?></td>
<td align="center"><?= $result->d009_total; ?></td>
<td align="center"><?= $result->d010_acerto; ?></td>
<td align="center"><?= $result->d010_total; ?></td>
<td align="center"><?= $result->d011_acerto; ?></td>
<td align="center"><?= $result->d011_total; ?></td>
<td align="center"><?= $result->d012_acerto; ?></td>
<td align="center"><?= $result->d012_total; ?></td>
<td align="center"><?= $result->d013_acerto; ?></td>
<td align="center"><?= $result->d013_total; ?></td>
<td align="center"><?= $result->d014_acerto; ?></td>
<td align="center"><?= $result->d014_total; ?></td>
<td align="center"><?= $result->d015_acerto; ?></td>
<td align="center"><?= $result->d015_total; ?></td>
<td align="center"><?= $result->d016_acerto; ?></td>
<td align="center"><?= $result->d016_total; ?></td>
<td align="center"><?= $result->d017_acerto; ?></td>
<td align="center"><?= $result->d017_total; ?></td>
<td align="center"><?= $result->d018_acerto; ?></td>
<td align="center"><?= $result->d018_total; ?></td>
<td align="center"><?= $result->d019_acerto; ?></td>
<td align="center"><?= $result->d019_total; ?></td>
<td align="center"><?= $result->d020_acerto; ?></td>
<td align="center"><?= $result->d020_total; ?></td>
<td align="center"><?= $result->d021_acerto; ?></td>
<td align="center"><?= $result->d021_total; ?></td>
<td align="center"><?= $result->d022_acerto; ?></td>
<td align="center"><?= $result->d022_total; ?></td>
<td align="center"><?= $result->d023_acerto; ?></td>
<td align="center"><?= $result->d023_total; ?></td>
<td align="center"><?= $result->d024_acerto; ?></td>
<td align="center"><?= $result->d024_total; ?></td>
<td align="center"><?= $result->d025_acerto; ?></td>
<td align="center"><?= $result->d025_total; ?></td>
<td align="center"><?= $result->d026_acerto; ?></td>
<td align="center"><?= $result->d026_total; ?></td>
                 		</tr>
                 	<?php } }else{?>
                 		<tr>
                 			<td colspan="8">Nenhum dado encontrado</td>
                 		</tr>	
                 	<?php }?>	
                 	</tbody>   
                </table>
                
                
                <div align="center">
                    <?php echo "<div id='dv_paginacao'>".$links_paginacao."</div>"?>
                </div>
                
                
            </div>
         </div>
   </div>         