
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/indice.jpg' ?> ">

    <title>Saev - Sistema de avaliação educar pra valer</title>

    
    <link href="<?php echo base_url('assets/css/base.min.css'); ?>" rel="stylesheet" type="text/css" />

    
    
    <head>
        <style type="text/css">
       /*
       @page {
            margin: 120px 50px 80px 50px;
        }
        #head{
            background-repeat: no-repeat;
            font-size: 25px;
            text-align: center;
            height: 110px;
            width: 100%;
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            margin: auto;
        } */
        #alteranativa_certa {
            color: #3498DB;            
        }       
        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            border-top: 1px solid gray;
        }
        #footer .page:after{ 
            content: counter(page); 
        }
        #data_relatorio{
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            font-style: italic;
            text-align: left;
        }
        
        </style>

        
</head>

<?php
    foreach ($registros as $result) {
?>
<body>

    <div>
        <div >
			<h3><center><i class="fa fa-eye"></i> Item de avaliação de nº. <?php echo $result->ci_avaliacao; ?></center></h3>


			<div>
    			<div>

					<div>
					    <p><legend>Parâmetros</legend></p>
					    <strong>Edicao:</strong> <?php echo $result->nm_edicao; ?>
					    <strong>Origem:</strong> <?php echo $result->nm_avalia_origem; ?> - 
					    <strong>Disciplina:</strong> <?php echo $result->nm_disciplina; ?>  -
					    <strong>Dificuldade:</strong> <?php echo $result->nm_avalia_dificuldade; ?> <br>
					    <strong>Etapa:</strong> <?php echo $result->nm_etapa; ?>
					    <strong>Conteúdo:</strong> <?php echo $result->nm_avalia_conteudo; ?>
					    <strong>Sub conteúdo:</strong> <?php echo $result->nm_avalia_subconteudo; ?>
<!--					<strong>Competência:</strong> Vivenciando as medidas. <br>
					    <strong>Habilidade:</strong> Calcular o volume de prismas, pirâmides, cilindros e cones em situação-problema. <br>
-->
					    
					</div>

				    <div>
				        <p><legend>Enunciado</legend></p>
				        <?php echo $result->ds_enunciado; ?>
				    </div>

				    <div>
                        <p><legend>Suporte</legend></p>

	                    <div align="center">
			                <img class="img-responsive img-thumbnail" width="150" height="150" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avaliacoes/'.$result->ds_img_suporte ?>">   
			            </div>
		            </div>

				    <div>
                        <p><legend>Comando</legend></p>
				        <?php echo $result->ds_comando; ?>
				    </div>

					<div>
                        <p><legend>Alternativas</legend></p>
                        <?php if ($result->nr_alternativa_correta == 1){ ?>
                            <strong id="alteranativa_certa">A) <?php echo $result->ds_primeiro_item; ?></strong> 
                        <?php }else{ ?>
                            A) <?php echo $result->ds_primeiro_item; ?> 
                        <?php } ?>

                        <?php if ($result->nr_alternativa_correta == 2){ ?>
                            <strong id="alteranativa_certa">B)</strong> <?php echo $result->ds_segundo_item; ?>
                        <?php }else{ ?>
                            B) <?php echo $result->ds_segundo_item; ?> 
                        <?php } ?>

                        <?php if ($result->nr_alternativa_correta == 3){ ?>
                            <strong id="alteranativa_certa">C)</strong> <?php echo $result->ds_terceiro_item; ?>
                        <?php }else{ ?>
                            C) <?php echo $result->ds_terceiro_item; ?> 
                        <?php } ?>

                        <?php if ($result->nr_alternativa_correta == 4){ ?>
                            <strong id="alteranativa_certa">D)</strong> <?php echo $result->ds_quarto_item; ?>
                        <?php }else{ ?>
                            D) <?php echo $result->ds_quarto_item; ?>
                        <?php } ?>

					</div>
                </div>
			</div>
		</div>
        <div id="data_relatorio">
            <?php

                  $data = new DateTime();
                 echo "Gerado em: ".$data->format('d/m/Y H:i:s'); 
            ?>
        </div>
        <div id="footer">
            <p class="page"> 
                Página 
            </p>
        </div>        
	</div>
     
</body> 
<?php } ?>        
</html>

 