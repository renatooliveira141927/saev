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
                    <h4 class="page-title"><?php echo 'Adicionar: Proficiência'?></h4>
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
        <form action="<?php echo base_url('proficiencia/proficiencia/gravar'); ?>" method="post" id="gravar" name="gravar">            
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        		<!--  <div class="col-lg-4">
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
                                        <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->nm_disciplina; ?>
                                    </Option>

                                <?php } ?>                                
                            </select>
                      </div>
                </div>       -->
                
                <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_etapa">Etapa *</label>
                            <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cd_etapa">Etapa *</label>
                                <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control">
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
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cd_descricaofaixa">Nível *</label>
                            <select id="cd_descricaofaixa" name="cd_descricaofaixa" tabindex="7" class="form-control">
                                <Option value=""></Option>
                                <?php
                                foreach ($descricaofaixa as $item) {
                                    ?>

                                    <Option value="<?php echo $item->ci_descricaofaixa; ?>"
                                    <?php if ($cd_descricaofaixa == $item->ci_descricaofaixa){
                                            echo 'selected';
                                        } ?> >
                                        <?php echo $item->ds_descricaofaixa; ?>
                                    </Option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                
                
                
         <div class="col-lg-2">
                <div class="form-group">
                    <label for="nr_inicio">Início *</label>
                    <input type="number"
                        name="nr_inicio"
                        id="nr_inicio"
                        min="1" max="100"
                        tabindex="2"
                        placeholder="Limite Inicial da Faixa"
                        class="form-control"/>	
                </div>
            </div>
            
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="nr_fim">Fim *</label>
                    <input type="number"
                        name="nr_fim"
                        id="nr_fim"
                        min="1" max="100"
                        tabindex="2"
                        placeholder="Limite Final da Faixa"
                        class="form-control"/>	
                </div>
            </div>    
               
            <div class="col-md-5">
                <div class="form-group">
                    <button type="button" id="btn_salvar"
                            tabindex="9" onclick="gravar();"
                            class="btn btn-custom waves-effect waves-light btn-micro active">
                        Salvar
                    </button>
					<button type="button" tabindex="25"
                    	onclick="window.location.href ='<?php echo base_url('proficiencia/proficiencia/listar')?>';"
                    	class="btn btn-custom waves-effect waves-light btn-micro active">Voltar
                    </button>                    
                </div>
            </div>      		                  
    </form>       
  </div>
  <script>
  $('#btn_salvar').click(function(event){
	  	event.preventDefault();
	  	var cd_etapa=$('#cd_etapa').val();
	  	var nr_inicio=$('#nr_inicio').val();
	  	var nr_fim=$('#nr_fim').val();
	  	var descricaofaixa=$('#cd_descricaofaixa').val();
	  	
	  		if(Number(nr_fim)<=Number(nr_inicio)){
	  			alert('O valor do campo Fim deve ser Maior que o do campo Início!');
				return false;
	  		}else if(cd_etapa==''||
					nr_inicio==''||nr_fim==''||descricaofaixa==''
				){
				alert('Verifique o preenchimento dos campos com asterísco (*)!');
				return false;
			}else{			
				$('#gravar').submit();
				return true;
			}
	  });
  </script>