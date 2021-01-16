
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

<br/><br/><br/><br/><br/><br/>
<?php 
    echo form_open('usuario/autenticacoes/email_alterarsenha');
?>
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Entrar no sistema</h3>
                    </div>
                    <div class="panel-body">
                            <fieldset>
                                <?php
                                    echo validation_errors('<script type="text/javascript">mensagem_sucesso("error" ,"','");</script>');
                                    if ($this->uri->segment(4) == '4375648ed0d522f0d04e4883a35e427b'){
                                        echo '<div class="alert alert-danger">Usuário não encontrado, verifique o CPF e o email informado!</div>';
                                    }
                                ?>
                                <div class="form-group">
                                        <input type="text"
                                            name="nr_cpf"
                                            id="cpf"
                                            tabindex="2"
                                            placeholder="CPF"
                                            class="form-control cpf"
                                            value="<?php echo set_value('nr_cpf');?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text"
                                            name="ds_email"
                                            id="ds_email"
                                            tabindex="2"
                                            placeholder="E-mail"
                                            class="form-control"
                                            value="<?php echo set_value('ds_email');?>">
                                        
                                    </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block">Enviar</button>
                            </fieldset>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    echo form_close();
?>


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
    <script src="<?=base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>
</html>