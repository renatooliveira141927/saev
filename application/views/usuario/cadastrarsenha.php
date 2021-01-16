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

    <script src="<?=base_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/complexidade.senha.js'); ?>"></script>

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
                        <h3 class="panel-title">Cadastrar senha</h3>
                    </div>
                    <div class="panel-body">

                        <?php 
                            echo validation_errors('<div class="alert alert-danger">','</div>');
                        ?>
                        <form id="frmalterarsenha" action="<?php echo base_url('usuario/autenticacoes/cadastrarsenha');?>" 
                                method="post">
                            <script>
                                function validaform(){
                                    var senha    = $('#senha').val();
                                    var confirma = $('#ds_confirmarsenha').val();
                                    var qtd_caracteres = parseInt(senha.length);
                                    $('#msgqtd').hide();
                                    $('#msgseg').hide();
                                    $('#msgcon').hide();

                                    if ((qtd_caracteres < 6) || (qtd_caracteres > 12)){
                                        $('#msgqtd').show();
                                    }else if (senha != confirma){
                                        $('#msgseg').show();
                                    }else if (forcaSenha(senha) <= 40){
                                        $('#msgcon').show();
                                    }else{
                                        $('#frmalterarsenha').submit();
                                        
                                    }
                                }
                            </script>
                            <fieldset>
                                <div>
                                    <div id="msgqtd" class="alert alert-danger" style="display:none;">A senha deve ter no minimo 6 caracteres!</div>
                                    <div id="msgseg" class="alert alert-danger" style="display:none;">A senha não atende aos requisitos mínimos de segurança!</div>
                                    <div id="msgcon" class="alert alert-danger" style="display:none;">O campo senha e confirmação de senha devem ser iguais!</div>
                                </div>
                                <div class="form-group">
                                    <label for="ds_senha">Senha</label>                                   
                                    <input type="password"
                                        name="ds_senha"
                                        id="senha"
                                        tabindex="2"
                                        placeholder="Senha"
                                        class="form-control">
                                    <input  type="hidden" 
                                            name="id"
                                            value="<?php echo $this->uri->segment(4) ?>">
                                    <div id="senhaBarra" class="progress" style="display: none;">
                                        <div id="senhaForca" 
                                                class="progress-bar progress-bar-success" 
                                                role="progressbar" 
                                                aria-valuenow="60" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100" 
                                                style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ds_confirmarsenha">Confirmar senha</label>
                                    <input type="password"
                                        name="ds_confirmarsenha"
                                        id="ds_confirmarsenha"
                                        tabindex="2"
                                        placeholder="Confirmar Senha"
                                        class="form-control"
                                        value="">
                                </div> 
                                <div>
                                    <p><strong class="text-warning">Atenção:</strong> 
                                    
                                    A senha deverá ter complexidade no mínimo média,                                     
                                    para isso deverá atender a no mínimo 3 condições abaixo:<br/>
                                    <ul class="disc">
                                        <li>Possuir entre 6 e 12 posições;</li>
                                        <li>Conter letras maiúsculas e minúsculas; </li>
                                        <li>Conter Números;</li>
                                        <li>Ter complixidade no mínimo média.;</li>
                                    </ul> 
                                    </p>
                                <div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a  type="button" src="#"
                                    class="btn btn-lg btn-success btn-block"
                                    onclick="javascript:validaform();">
                                    Cadastrar
                                </a>
                            </fieldset>
                            
                        </form>
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