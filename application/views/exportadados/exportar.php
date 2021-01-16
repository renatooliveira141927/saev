<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_estado.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>
<script src="<?=base_url('assets/js/manipula_combo_select.js'); ?>"></script>
<script>
    function add_inep_escola(){
        $('#nr_inep_escola').val($('#cd_escola').find(':selected').attr('nr_inep'));
    }

    function pesquisa_inep(){

        var option  = $( "select[name^='cd_escola'] option" );
        var nr_inep = $('#nr_inep_escola').val();

        option.each(function () {

            var attr_inep = $(this).attr('nr_inep');

            if (nr_inep == attr_inep) {
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

    function validaForm(){
    	var estado=$('#cd_estado').val();
    	var cidade=$('#cd_cidade').val();
    	//var escola=$('#cd_escola').val();		
    	var ano=$('#cd_ano').val();		
		var avaliacao=$('#cd_avaliacao').val();
		//var avaliacao=$('#cd_avaliacao').val();
		//if(estado==''||cidade==''||escola==''||ano==''||avaliacao==''){
        if(estado==''||cidade==''||ano==''||avaliacao==''){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{
			$('#exportaescrita').submit();
			return true;
		}
    }
    
    
</script>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo $titulo ?></h4>
                </p>
            </div>
        </div>
    </div>

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>

    <div class="container-fluid">

        <div class="container-fluid card-box">
            <form action="" method="post" id="exportaescrita">
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
                                        disabled
                                        onchange="populaescola(this.value);"
                                        class="form-control" >
                                        <?php echo @$municipios ?>
                                </select>
                            </div>
                        </div>                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="cd_escola">Escola </label>
                                <select id="cd_escola"
                                        name="cd_escola"
                                        tabindex="4"
                                        disabled
                                        class="form-control"
                                        onchange="escola_selecionda(this.value);">
                                    <Option value="" nr_inep=""></Option>
									<?php echo @$escolas ?>
                                </select>
                            </div>
                        </div>

                    <?php }else if ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Fim(admin) Início se o usuário for SME-->

                        <div class="form-group col-lg-3">
                            <label>Estados </label>
                            <input type="hidden" id="cd_estado" name="cd_estado" class="form-control" value="<?php echo $this->session->userdata('cd_estado_sme');?>">                    	
                            <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_estado_sme');?>">
                        </div>
                        <div class="col-lg-9">
                            <div  class="form-group">
                                <label>Municípios *</label>
                                <input type="hidden" id="cd_cidade" name="cd_cidade" class="form-control" value="<?php echo $this->session->userdata('cd_cidade_sme');?>">
                                <input type="text" disabled class="form-control" value="<?php echo $this->session->userdata('nm_cidade_sme');?>">
                            </div>
                        </div>                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="cd_escola">Escola *</label>
                                <select id="cd_escola"
                                        name="cd_escola"
                                        tabindex="4"                                        
                                        class="form-control"
                                        onchange="escola_selecionda(this.value);">
                                    <Option value="" nr_inep=""></Option>                                    
                                    <?php echo @$escolas ?>

                                </select>
                            </div>
                        </div>
                    <?php }else{?> <!-- Fim grupo SME -->                    
                        <input type="hidden" name="cd_escola" id="cd_escola" value="<?php echo @$ci_escola;?>">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nr_inep_escola">Inep da Escola</label>
                                <input type="text"
                                       name="nr_inep_escola"
                                       id="nr_inep_escola"
                                       tabindex="5"
                                       placeholder="INEP"
                                       class="form-control"
                                       value="<?php echo @$nr_inep; ?>">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nm_escola">Nome da escola</label>
                                <input type="text"
                                       name="nm_escola"
                                       id="nm_escola"
                                       tabindex="6"
                                       placeholder="Nome"
                                       class="form-control"
                                       value="<?php echo @$nm_escola;?>">
                            </div>
                        </div>
                    <?php }?> <!-- Fim grupo scola -->
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="cd_ano">Ano *</label>
                            <select id="cd_ano" name="cd_ano" tabindex="10" class="form-control" onchange="populaavalicaoano()">
                                <?php echo $anos ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cd_avaliacao">Avaliação *</label>
                            <select id="cd_avaliacao" name="cd_avaliacao[]" tabindex="10" class="form-control" disabled>
                                    <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                                <?php foreach (@$avaliacoes as $item) { ?>
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
                        <div class="form-group"  style="text-align:right">
                            <button type="button" id="btn_consulta" 
                                    tabindex="9" onclick="validaForm();"
                                    class="btn btn-custom waves-effect waves-light btn-micro active">
                                Exportar
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>    