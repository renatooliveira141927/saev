<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="<?=base_url('assets/images/indice.jpg'); ?>">

    <title>Saev - Sistema de avaliação educar pra valer</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="<?=base_url('plugins/morris/morris.css'); ?>">

    <!-- App css -->
    <!-- <link href="<'?=base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />-->
    <link href="<?=base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/css/core.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/css/components.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/css/pages.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/css/menu.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url('plugins/switchery/switchery.min.css'); ?>">

<style type="text/css">
    /* Style para alterar o texto quando utilizado em dispositivos móveis */
    .desktop {
        display: block;
        /* ou inline, inline-block */
    }

    .mobile {
        display: none;
    }

    @media(max-width: 827px) {
        .desktop {
            display: none;
        }
        .mobile {
            display: block;
            /* ou inline, inline-block */
        }
    }
</style>
</head>


<body>


<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container ">

              <!-- Logo container DESKTOP-->
              <div class="logo desktop" align="center">
                <!-- Logomarca e titulo do projeto -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/indice.jpg') ?>" alt="" height="50">
                    &nbsp;&nbsp; SAEV - SISTEMA DE AVALIAÇÃO EDUCAR PRA VALER
                </a>
            </div>
            <!-- End Logo container DESKTOP-->

            <!-- Logo container MOBILE-->
            <div class="logo mobile" align="center">
                <!-- Logomarca e titulo do projeto -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/indice.jpg') ?>" alt="" height="50">
                    &nbsp;&nbsp; SAEV
                </a>
            </div>
            <!-- End Logo container MOBILE-->
  
        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

</header>
<br/><br/><br/><br/><br/><br/>
<div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-body">
                            <fieldset>
                                Enviamos um e-mail para você com um link para alterar sua senha! <br>
                                <a  href="<?php echo base_url('usuario/autenticacoes/login');?>" 
                                    class="text-sucess">
                                    ir para página de login
                                </a>
                            </fieldset>                    
                       
                    </div>
                </div>
            </div>
        </div>
    </div>



   <!-- Footer -->
   <footer class="footer text-right">
       <div class="container">
           <div class="row">
               <div class="col-xs-12 text-center">
               <?php 
                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                    date_default_timezone_set('America/Sao_Paulo');

                    $date_oct = new DateTime();
                    $data_comum = $date_oct->format('Y');
                
                ?>
                © <?php echo $data_comum ?>. ASSOCIACAO BEM COMUM.
               </div>
           </div>
       </div>
   </footer>
   <!-- End Footer -->

   </div>
   </div>
   </body>
   </html>