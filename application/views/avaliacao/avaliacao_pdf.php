
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
    $linhas = 0;
    $nova_pagina = false;
    $quebra_de_pagina = false;
    $caracteres_max_linha   = 110; // Máximo de caracteres até ser gerada nova linha.
    $qtdPixel_porLinha      = 28; // Define quantos pizels correspondem a uma linha
    $qtdMax_linhasPagina    = 50; // Define o maximo de linhas que devem ser escritos em cada página

    foreach ($reg_avalia_itens as $result) {
        $i += 1;

        /* 
            Contando os caracteres para saber quanto cabe na tela            
        */

        /* 
        Divide a quantidade de caracteres pela quantidade maxima que 
        cabe em uma linha para obter quantas linhas cada campo possue
        */
        $ln_questao  = 0;
        $ln_questao  = intval(strlen($nm_caderno)               / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_enunciado)     / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_codigo)        / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_enunciado)     / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_fonte_imagem)  / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_comando)       / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_primeiro_item) / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_segundo_item)  / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_terceiro_item) / $caracteres_max_linha ) + 1;
        $ln_questao += intval(strlen($result->ds_quarto_item)   / $caracteres_max_linha ) + 1;

        $img_height = 0;
        $tmp_ds_img_suporte = '';
        $tmp_ds_img_item_01 = '';
        $tmp_ds_img_item_02 = '';
        $tmp_ds_img_item_03 = '';
        $tmp_ds_img_item_04 = '';
        

        /* Caso o campo img esteja preechido verifica o height de cada imagem */
        $ln_img = 0;
        if ($result->ds_img_suporte){
            list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_suporte);
            $img_height += $height;
            $tmp_ds_img_suporte = $result->ds_img_suporte;
        }
        if ($result->tp_questao == 'I'){
            if ($result->ds_img_item_01){
                list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_01);
                $img_height += $height;
                $tmp_ds_img_item_01 = $result->ds_img_item_01;
            }
            if ($result->ds_img_item_02){
                list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_02);
                $img_height += $height;
                $tmp_ds_img_item_02 = $result->ds_img_item_02;
            }
            if ($result->ds_img_item_03){
                list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_01);
                $img_height += $height;
                $tmp_ds_img_item_03 = $result->ds_img_item_03;
            }
            if ($result->ds_img_item_04){
                list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_04);
                $img_height += $height;
                $tmp_ds_img_item_04 = $result->ds_img_item_04;
            }
        }
        // Se existir imagem divide o tamanho com a quantidade de pixel por linha e retira a parte inteira do resultado
        // $ln_img corresponde a quantidade de linhas que a imagem oculpa
        if ($img_height > 0){ 
            $ln_img = (intval($img_height / $qtdPixel_porLinha));
        }

        /* A cada volta no loop $lonhas recebe a quantidade de linhas dos capos e das imagens */
        $linhas +=  $ln_questao + $ln_img;

        $nova_pagina          = false;
        $quebra_de_pagina     = false;
        if ($i==1){// Primeira volta no loop - Criar primeiro body
            $nova_pagina      = true;
            $quebra_de_pagina = false;
        }
        if (($linhas >= $qtdMax_linhasPagina)){ // Se $linhas for maior que a quantidade de linhas que cabem na página            
            $quebra_de_pagina = true;
            $nova_pagina      = true;
            $linhas =  $ln_questao + $ln_img; // Quando quebrar a página inicie com a qtd de linhas do próximo registro
        }
        if ($quebra_de_pagina){ // Quebra de página
            
        ?>            
                            </div>
            			</div>
            		</div>
        
            		<div id="data_relatorio">
                        <?php $data = new DateTime();?> 
                        Gerado em: <?php $data->format('d/m/Y H:i:s'); ?>    
            		</div>
                    <div id="footer">
                        <p class="page"> 
                          Página 
                        </p>
                    </div><!----------------------------TERMINOU------------------------------------->
            	</div>
            </body>
        <?php
        }
        /* Fim
            Contando os caracteres para saber quanto cabe na tela
        */
        if ($nova_pagina){ // nova página
?>
<body>
    <style type="text/css">
       

       .nm_caderno{
           font-size: 12px;
           text-align: center;
           color: #000000;
           height: 50px;
       }
       .ds_enunciado{
           /* border: 1px solid black; */
           font-size: 15px;
           /* font-weight: bold; */
           text-align: left;
           vertical-align: top;
           color: #000000;
           border:none;
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
           font-size: 15px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           border:none;
           width: 80%;
       }
       .alternativas{
           /* border: 1px solid black; */
           font-size: 15px;
           /* font-weight: bold; */
           text-align: left;
           color: #000000;
           border:none;
           width: 80%;
       }
       
       </style>

    <div>

        <div><!----------------------------------------COMEÇOU---------------------------------->
			<div>
    			<div>
                    <div class="nm_caderno"><br/><br/>
				        <?php echo $nm_caderno ?>
				    </div> 
                    
                    <?php }//if ($nova_pagina){ --- Definindo quebra de página ?>
                    <table style="width:100%">                   
                        <tr>
                            <td style="width:25px">&nbsp;</td>
                            <td class="ds_enunciado" style="width:80px">
                            <?php 
            //  echo '<br>$linhas='.$linhas;
            //  echo '<br>$ln_questao='.$ln_questao;
            //  echo '<br>$ln_img='.$ln_img;
            //  echo '<br>$img_height='.$img_height;
            

            //  echo '<br>$tmp_ds_img_suporte='.$tmp_ds_img_suporte;
            //  echo '<br>$tmp_ds_img_item_01='.$tmp_ds_img_item_01;
            //  echo '<br>$tmp_ds_img_item_02='.$tmp_ds_img_item_02;
            //  echo '<br>$tmp_ds_img_item_03='.$tmp_ds_img_item_03;
            //  echo '<br>$tmp_ds_img_item_04='.$tmp_ds_img_item_04.'<br>';

    ?>
                                <?php echo $i.')&nbsp;('.$result->ds_codigo.')'; ?>
                            </td>
                            <td class="ds_enunciado" style="width:470px">
                                <?php echo $result->ds_enunciado; ?>
                            </td>
                            <td style="width:25px"></td>
                        </tr>
                    <?php if ($result->ds_img_suporte){?>
                            <tr>
                                <td class="ds_comando" colspan="4">
                                    
                                    <div style="text-align: center;">
                                        <!-- <img style="max-width:200px; max-height:200px;" src="<'?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_suporte ?>"> -->
                                        <img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_suporte ?>">
                                    </div>
                                    <div class="ds_fonte_imagem">         
                                        <?php echo $result->ds_fonte_imagem; ?>  
                                    </div>
                                </td>
                            </tr>
                    <?php }?>
                        <tr>
                            <td style="width:5%"></td>
                            <td class="ds_comando" colspan="2">
                                <?php echo $result->ds_comando; ?>
                            </td>
                            <td style="width:5%"></td>
                        </tr>
                        <tr>
                            <td style="width:5%"></td>
                            <td class="alternativas" colspan="2">
                                <!-- <p><legend>Alternativas</legend></p> -->
                                <?php if ($result->tp_questao == 'I'){ ?>
                                    <table cellspacing="10">
                                        <tr>
                                            <td><p>A)</p></td>
                                            <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_01 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><p>B)</p></td>
                                            <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_02 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><p>C)</p></td>
                                            <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_03 ?>"></td>
                                        </tr>
                                        <tr>
                                            <td><p>D)</p></td>
                                            <td><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/img/avalia_itens/'.$result->ds_img_item_04 ?>"></td>
                                        </tr>
                                    </table>
                                <?php }else{ ?>
                                    <table cellspacing="10">
                                        <tr>
                                            <td><p>A)</p></td>
                                            <td><?php echo $result->ds_primeiro_item; ?></td>
                                        </tr>
                                        <tr>
                                            <td><p>B)</p></td>
                                            <td><?php echo $result->ds_segundo_item; ?></td>
                                        </tr>
                                        <tr>
                                            <td><p>C)</p></td>
                                            <td><?php echo $result->ds_terceiro_item; ?></td>
                                        </tr>
                                        <tr>
                                            <td><p>D)</p></td>
                                            <td><?php echo $result->ds_quarto_item; ?></td>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </td>
                            <td style="width:5%"></td>
                        </tr>
                    </table>  
                    <!-- <'?php if ($quebra_de_pagina){ // Quebra de página
                        
                    ?>
                </div>
			</div>
		</div>
        
        <div id="data_relatorio">
            <'?php

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
     <'?php }//if ($quebra_de_pagina){  ?>  -->
<?php } ?>        
</html>

