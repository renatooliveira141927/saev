<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/relatorio/metasaprendizagem.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_escola.js'); ?>"></script>


    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Editar: Metas de Aprendizagem'?></h4>
                </p>
            </div>            
        </div>
    </div>
    
<?php
    echo validation_errors('<script type="text/javascript">mensagem_sucesso("error" ,"','");</script>');
if($msg == "success"){

    ?>

    <script type="text/javascript">
        mensagem_sucesso("success" , "Registro gravado com sucesso!");
    </script>

    <?php
}else if($msg == "registro_ja_existente"){
    ?>

    <script type="text/javascript">
        mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a turma já está cadastrada no banco de dados!");
    </script>

    <?php
}?>        

    <div id="img_carregando" style="display:none;">
        <img style="position: absolute; left: 50%; top: 50%;"
             src="<?php echo base_url('assets/images/carregando.gif')?>">
    </div>
    <div class="container card-box">
        <form action="<?php echo base_url('metasaprendizagem/metasaprendizagem/gravar/'.$meta); ?>" method="post" id="gravar" name="gravar">            
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        		<div class="col-lg-4">
                            <label>Estados *</label>
                            <select id="cd_estado"
                                    name="cd_estado"
                                    tabindex="1"
                                    class="form-control"
                                    onchange="populacidade(this.value);">
                                <?php echo $estado ?>
                            </select>
                 </div>
                 <div class="col-lg-4">
                            <div  class="form-group">
                                <label>Municípios *</label>
                                <select id="cd_cidade"
                                        name="cd_cidade"
                                        tabindex="2"
                                        class="form-control"
                                        onchange="populaescola(this.value,'');">
                                        <?php echo $cidade ?>
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
                                        class="form-control">
                                    <?php echo $anos ?>
                                </select>
                        </div>
                </div>
                         <div  class="col-lg-3">
                        <div class="form-group">
                            <label for="cd_disciplina">Disciplina *</label>                            
                            <select id="cd_disciplina" 
                                        name="cd_disciplina" 
                                        tabindex="3"
                                        class="form-control">
                                    <Option value=""></Option>
                                <?php
                                foreach ($disciplinas as $item) {
                                    ?>
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
         <div class="col-lg-3">
            <div class="form-group">
                <label for="cd_etapa">Etapa * </label>
                <select id="cd_etapa" name="cd_etapa" tabindex="1" class="form-control">
                    <Option value=""></Option>
                    <?php
                    foreach ($etapas as $item) {
                        ?>
                        <Option value="<?php echo $item->ci_etapa; ?>"
                            <?php if (($etapa == $item->ci_etapa)){
                                echo 'selected';
                            } ?> >
                            <?php echo $item->nm_etapa; ?>
                        </Option>

                    <?php } ?>
                </select>
         	</div>
        </div>
        <div class="col-lg-3">
                <div class="form-group">
                    <label for="cd_escola">Escola</label>
                    <select id="cd_escola" name="cd_escola" tabindex="4" class="form-control"
                        onchange="add_inep();">
                        <Option value="0" nr_inep="">Selecione a Escola</Option>
                        <?php
                            foreach ($escolas as $item) {
                                ?>
                                <Option value="<?php echo $item->ci_escola; ?>" nr_inep="<?php echo $item->nr_inep; ?>"
                                    <?php if ($cd_escola == $item->ci_escola){
                                        echo 'selected';
                                    } ?> >
                                    <?php echo $item->nr_inep .' - '.$item->nm_escola; ?>
                                </Option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="nr_percentual">% Aprendizagem *</label>
                    <input type="number"
                        name="nr_percentual"
                        id="nr_percentual"
                        min="1" max="100"
                        tabindex="2"
                        placeholder="Percentual"
                        class="form-control"
                        value="<?php echo $nr_percentual;?>">	
                </div>
            </div>       
                <div class="col-md-5">
                <div class="form-group">
                    <button type="button" id="btn_salvar"
                            tabindex="9"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Alterar
                    </button>
                    <button type="button" tabindex="25"
                    	onclick="window.location.href ='<?php echo base_url('metasaprendizagem/metasaprendizagem/metaslista')?>';"
                    	class="btn btn-custom waves-effect waves-light btn-micro active">Voltar
                    </button>
                </div>
                
            </div>      		                  
    </form>       
  </div>
  <script>
  $('#btn_salvar').click(function(event){
  	event.preventDefault();
  	//alert('btn_salvar');
  	var cd_estado=$('#cd_estado').val();
  	var cd_cidade=$('#cd_cidade').val();
  	var nr_anoletivo=$('#nr_anoletivo').val();
  	var cd_etapa=$('#cd_etapa').val();
  	var cd_escola=$('#cd_escola').val();
  	var nr_percentual=$('#nr_percentual').val();
  	var cd_disciplina=$('#cd_disciplina').val();
		if(cd_estado==''||cd_cidade==''||
				nr_anoletivo==''||cd_etapa==''||
				nr_percentual==''||cd_disciplina==''
			){
			alert('Verifique o preenchimento dos campos com asterísco (*)!');
			return false;
		}else{			
			$('#gravar').submit();
			return true;
		}
  });
  </script>