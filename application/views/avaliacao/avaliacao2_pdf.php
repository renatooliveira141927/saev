
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
        *{
            margin: 0;
            padding: 0;
        }
        .cabecalho{
            position: relative;
            width: 100%;
            height: 200px;
            background: #BEBEBE;
        }
        .tipo_avaliacao{
            width: 100%;
            font-size: 35px;
            /* font-weight: bold; */
            text-align: left;
            color: #000000;  
        }
        .municipio{
            width: 100%;
            font-size: 28px;
            /* font-weight: bold; */
            text-align: left;
            color: #000000;  
        }
        .div_pai{ 
            display: table;
        }
        .ano{
            width: 92%;
            float: left; 
            font-size: 32px;
            text-align: right;
            color: #000000;
        }        
        .fundo_preto{ 
            float: left; 
            width: 8%; 
            height: 32px;
            background: #000000; 
        }
        .disciplina{
            width: 100%; 
            height: 50px;
            font-size: 25px;
            text-align: center;
            color: #000000;
        }
        .etapa{
            width: 50%; 
            height: 50px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: #000000;
            word-break: break-all;
        }
        .caderno{
            width: 50%; 
            height: 50px;
            font-size: 25px;
            text-align: center;
            color: #000000;
        }
        .linha_preta{
            background: #000000; 
        }
        .nm_aluno{
            border: 1px solid black;
            width: 100%;
            height: 50px;
        }
        .texto_abertura{
            font-size: 15px;
            text-align: left;
            color: #000000;
            height: 400px;
        }
        </style>

        
</head>
<?php
    $nm_caderno = "";
    foreach ($registros as $result) {
        $nm_caderno = $result->nm_caderno;
?>
<body>
    <div class="cabecalho"> 
        <div> 
            <div class="tipo_avaliacao col-lg-11">
                <br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result->nm_avalia_tipo; ?>
            </div>
            <div class="municipio">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'CONDE - PB' ?>
            </div>
            <br/>
            <div class="div_pai" >
                <div class="ano">
                    <?php echo $result->nr_ano;  ?>&nbsp;&nbsp;
                </div>     
            </div>
            <div class="div_pai">
                <div class="fundo_preto"><br/>&nbsp;&nbsp;</div>
            </div>
            
        </div>
        
    </div>
    <div class="disciplina"> 
        <br/><?php echo $result->nm_disciplina;  ?><br/>
    </div>
    <div>
        <br/>
        <br/>
        <table style="width: 100%;">
            <tr>
                <td class="etapa">
                    &nbsp;&nbsp;&nbsp;<?php echo $result->nm_etapa;  ?>
                </td>
                <td class="linha_preta">
                    
                </td>
                <td class="caderno">
                Caderno<br><strong><?php echo $result->nm_caderno;  ?></strong>
                </td>
            </tr>
        </table>
       <br/><br/><br/>
    </div>
    <table style="width: 100%;">
        <tr>
            <td>
            </td>
            <td style="width: 90%;">
                <div class="nm_aluno"> 
                &nbsp;&nbsp;Nome do estudante
                </div>
            </td>
            <td>
            </td>
        </tr>
    </table>
        
    </div>
    <div> 
    <table style="width: 100%;">
        <tr>
            <td>
            </td>
            <td style="width: 90%;">
                <div class="texto_abertura"> 
                    <br/><br/><br/><br/><br/>
                    <?php echo $result->ds_texto_abertura;  ?>
                </div>
            </td>
            <td>
            </td>
        </tr>
    </table>
        
    </div>
    <div align="center">
        <img class="img-responsive img-thumbnail" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/indice_pdf.jpg' ?>">   
    </div>
</body>
    
<?php
    }
?>
<?php
    $i = 0;
    foreach ($reg_avalia_itens as $result) {
        $i += 1;
?>
    <style type="text/css">
       

       .nm_caderno{
           font-size: 12px;
           text-align: center;
           color: #000000;
           height: 50px;
       }
       .questoes{
           /* border: 1px solid black; */
           font-size: 15px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           background: #BEBEBE;
           border:none;
           width: 80%;
           height: 50px;
       }   
       .ds_codigo{
           /* border: 1px solid black; */
           font-size: 12px;
           text-align: right;
           color: #000000;
           background: #BEBEBE;
           border:none;
           width: 10%;
           height: 50px;
       }
       .ds_enunciado{
           /* border: 1px solid black; */
           font-size: 22px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           border:none;
           width: 80%;
           height: 50px;
       }      
       .ds_fonte_imagem{
           font-size: 12px;
           text-align: center;
           color: #000000;
           border:none;
           width: 100%;
       }
       
       .ds_comando{
           /* border: 1px solid black; */
           font-size: 22px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           border:none;
           width: 80%;
           height: 50px;
       }
       .alternativas{
           /* border: 1px solid black; */
           font-size: 22px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           border:none;
           width: 80%;
       }
       
       </style>
<body>

    <div>
        <div >
			<div>
    			<div>
                    <div class="nm_caderno"><br/><br/>
				        <?php echo $nm_caderno ?>
				    </div>
                    <table border="0" cellspacing="0" rules="none"  style="width:100%">
                        <tr>
                            <td style="width:5%"></td>
                            <td class="questoes">
                                &nbsp;&nbsp;<strong>Questão <?php echo $i; ?><strong>
                            </td>
                            <td class="ds_codigo"><?php echo $result->ds_codigo; ?>&nbsp;&nbsp;</td>
                            <td style="width:5%"></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td style="width:5%"></td>
                            <td class="ds_enunciado" colspan="2">
                                <br/>
                                <?php echo $result->ds_enunciado; ?>
                            </td>
                            <td style="width:5%"></td>
                        </tr>
                    </table>

				    <div>
	                    <div align="center">
                            <br/>
                            <br/>                            
			                <img width="150" height="150" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_suporte ?>">           
			            </div>
                        <div class="ds_fonte_imagem">         
			                <?php echo $result->ds_fonte_imagem; ?>  
			            </div>
		            </div>

				    <div>
                        <table style="width:100%">
                            <tr>
                                <td style="width:5%"></td>
                                <td class="ds_comando" colspan="2">
                                    <br/>
                                    <?php echo $result->ds_comando; ?>
                                </td>
                                <td style="width:5%"></td>
                            </tr>
                        </table>
				        
				    </div>

					<div>
                        <table style="width:100%">
                            <tr>
                                <td style="width:5%"></td>
                                <td class="alternativas" colspan="2">
                                    <br/>
                                    <!-- <p><legend>Alternativas</legend></p> -->
                                    <br/>
                                    <br/>
                                    <table cellspacing="10">
                                        <tr>
                                            <?php if ($result->nr_alternativa_correta == 1){ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa_correta.jpg' ?>"></p></td>
                                                <td><strong id="alteranativa_certa"><?php echo '&nbsp;&nbsp;'.$result->ds_primeiro_item; ?></strong> </td>
                                            <?php }else{ ?>
                                                <td><p>&nbsp;&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa.jpg' ?>"></p></td>\
                                                <td><?php echo '&nbsp;&nbsp;'.$result->ds_primeiro_item; ?></td>
                                            <?php } ?>
                                            <td><br/><br/></td>
                                        </tr>
                                        <tr>
                                            <?php if ($result->nr_alternativa_correta == 2){ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa_correta.jpg' ?>"></p></td>
                                                <td><strong id="alteranativa_certa">&nbsp;&nbsp;<?php echo '&nbsp;&nbsp;'.$result->ds_segundo_item; ?></strong> </td>
                                            <?php }else{ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa.jpg' ?>"></p></td>
                                                <td>&nbsp;&nbsp;<?php echo $result->ds_segundo_item; ?></td>
                                            <?php } ?>
                                            <td><br/><br/></td>
                                        </tr>
                                        <tr>
                                            <?php if ($result->nr_alternativa_correta == 3){ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa_correta.jpg' ?>"></p></td>
                                                <td><strong id="alteranativa_certa">&nbsp;&nbsp;<?php echo $result->ds_terceiro_item; ?></strong> </td>
                                            <?php }else{ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa.jpg' ?>"></p></td>
                                                <td>&nbsp;&nbsp;<?php echo $result->ds_terceiro_item; ?></td>
                                            <?php } ?>
                                            <td><br/><br/></td>
                                        </tr>
                                        <tr>
                                            <?php if ($result->nr_alternativa_correta == 4){ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa_correta.jpg' ?>"></p></td>
                                                <td><strong id="alteranativa_certa">&nbsp;&nbsp;<?php echo $result->ds_quarto_item; ?></strong> </td>
                                            <?php }else{ ?>
                                                <td><p>&nbsp;<img width="31" height="32" src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/quadro_alternativa.jpg' ?>"></p></td>
                                                <td>&nbsp;&nbsp;<?php echo $result->ds_quarto_item; ?></td>
                                            <?php } ?>
                                            <td><br/><br/></td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width:5%"></td>
                            </tr>
                        </table>
                        
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

 