<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/indice.jpg' ?> ">

    <title>Saev - Sistema de avaliação educar pra valer</title>

    <!-- App css -->
    <!-- <link href="<'?=base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />

    
    
    <head>
        <style type="text/css">
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


<body>

<div >
    <div id="head">
        <?php echo $titulo; ?>
    </div>
    <div align="center"Relatório gerado no dia></div>

    </div>   
         
<div >
     <div>

         <table class="table">
           <tr style="background-color: #233A5D; color: #FFFFFF; font-family: sans-serif; ">
            <th>Código</th>
            <th>Nome</th>
        </tr>
        <!-- Inicio lista de alunos encontradas na consulta -->
        <?php
        foreach ($registros as $result) {
            ?>
            <tr>
                <td ><?php echo $result->ci_avalia_conteudo; ?></td>
                <td><?php echo $result->nm_avalia_conteudo; ?></td>
            </tr>

        <?php } ?>        
        </table>    
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
<!--    <img src="<1?php echo $_SERVER['DOCUMENT_ROOT'].'/codeigniter/assets/images/indice.jpg' ?>"/>-->

</div>
</body>
</html>