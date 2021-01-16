<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/liberacaoinfrequencia.js'); ?>"></script>
<div
	style="position: absolute; top: 280px; left: 40%; z-index: 1; display: none;"
	id="carregando">
	<img src="<?php echo base_url('assets/images/load.gif');?>" width="250"
		height="180">
</div>
<?php
        echo validation_errors('<script type="text/javascript">mensagem_sucesso("error" ,"','");</script>');
        if($msg == "success"){
    ?>
            <script type="text/javascript">
                mensagem_sucesso("success" , "Registro gravado com sucesso!");
            </script>
    <?php
        }elseif($msg == "nenhuma_turma_escolhida"){
    ?>
            <script type="text/javascript">
                mensagem_sucesso("info" , "Nenhuma turma selecionada!");
            </script>
    <?php }?>
<div class="container">
	<div class="page-title-box">
		<div class="col-md-10" style="text-align: left">
			<p>
			
			
			<h4 class="page-title"><?php echo 'Cadastrar Liberação de Infrequ&ecirc;ncia ' ?></h4>
			</p>
		</div>
	</div>
</div>

<?php     
echo form_open('infrequencia/infrequencia/salvarLiberacao', array(
    'id' => 'frm_infrequencia',
    'method' => 'post',
    'enctype' => 'multipart/form-data'
));
?>

<!-- Inicio Div Parametros -->
<input type="hidden" name="base_url" id="base_url"
	value="<?php echo base_url();?>">
<div class="container card-box">
	<div class="col-md-12">
                <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados abrir menu grupo SME-->
		<div class="col-lg-6">
			<div class="form-group">

				<label>Estado *</label> <select id="cd_estado" name="cd_estado"
					tabindex="3" class="form-control"
					onchange="populacidade(this.value, '', '', false, $('#cd_cidade'))">

                                <?php echo $estado ?>

                            </select>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label>Município *</label> <select id="cd_cidade" name="cd_cidade"
					tabindex="2" class="form-control" disabled">
					<option value="">Selecione o estado</option>
				</select>
			</div>
		</div>                    
                <?php }elseif ($this->session->userdata('ci_grupousuario') == 2){?> <!-- Se o usuário for SME-->

		<div class="col-lg-6">
			<div class="form-group">

				<label>Estado *</label> <input type="text" disabled
					class="form-control"
					value="<?php echo $this->session->userdata('nm_estado_sme'); ?>">
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label>Município *</label> <input type="text" disabled
					class="form-control"
					value="<?php echo $this->session->userdata('nm_cidade_sme'); ?>">

			</div>
		</div>                    
                    <?php }?>
                    <div class="col-lg-4">
			<div class="form-group">
				<label for="nr_mes">M&ecirc;s *</label> <select id="cd_mes"
					name="cd_mes" tabindex="7" class="form-control">                        	
                                    <?php echo $meses ?>
                            </select>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label for="nr_mes">Situação *</label> <select id="fl_situacao"
					name="fl_situacao" tabindex="7" class="form-control">
					<option>Selecione a situação</option>
					<option value="true">Ativo</option>
					<option value="false">Desativado</option>
				</select>
			</div>
		</div>
		<div  class="col-lg-9">
                	<div>
                	<a href="https://youtu.be/Oklkan7Pqi4" target="_blank">Veja o vídeo explicativo sobre a infrequência </a>
                	</div>
                </div>	
		<div class="col-lg-12" align="right">
			<button type="button" onclick="validaform();"
				class="btn btn-custom waves-effect waves-light btn-micro active"
				tabindex="10">Cadastrar</button>
			<button type="button"
				onclick="window.location.href ='<?php echo base_url('infrequencia/infrequencia/pesquisaliberacao')?>';"
				class="btn btn-custom waves-effect waves-light btn-micro active">
				Voltar</button>
			&nbsp;&nbsp;
		</div>
	</div>
</div>
<?php echo form_close();?>
<script>
function validaform(){
    var invalido = true;
    var estado=$('#cd_estado').val();
    var cidade=$('#cd_cidade').val();
    var mes=$('#cd_mes').val();
    var situacao=$('#fl_situacao').val();   
    
    if (estado==''||cidade==''||mes==''||situacao==''){
    	alert('Verifique o preenchimento de todos os campos com asterisco (*)!');
    	return false;
    }else{
        $('#frm_infrequencia').submit();
    	return true;
    }            
}
</script>