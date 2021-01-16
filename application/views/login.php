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
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Entrar no sistema</h3>
                    </div>
                    <div class="panel-body">
                        <?php 
                            echo validation_errors('<div class="alert alert-danger">','</div>');
                            if ($this->uri->segment(4) == '4375648ed0d522f0d04e4883a35e427b'){
                                echo '<div class="alert alert-danger">Usuário ou senha inválido!</div>';
                            }else if ($this->uri->segment(4) == 'bb01d9de17b965d04a2dc0b4171a85d4'){
                                echo '<div class="alert alert-success">Senha cadastrada com sucesso!</div>';
                            }else if ($this->uri->segment(4) == '0bf02e6c3b431160512e677053714c85'){
                                echo '<div class="alert alert-danger">Usuário sem escola definida no sistema!</div>';
                            }

                            echo form_open('usuario/autenticacoes/login');
                        ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuário" name="txt-user" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Senha" name="txt-senha" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <a href="<?php echo base_url('usuario/autenticacoes/telaalterarsenha');?>" class="text-sucess">Esqueceu a senha?</a>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Entrar</button>
                            </fieldset>
                        <?php
                            echo form_close();
                        ?>
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
               © 2018. ASSOCIACAO BEM COMUM.
               </div>
           </div>
       </div>
   </footer>
   <!-- End Footer -->

   </div>
   </div>
   </body>
   </html>