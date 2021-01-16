<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header"><?php echo 'Administrar '.$titulo ?></h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Cadastro de '.$titulo ?>

                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">

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
                                                mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o nome da edição já está cadastrado no banco de dados!");
                                            </script>

                                            <?php
                                        }
                                            echo form_open('edicao/edicoes/salvar',array('id'=>'frm_edicoes','method'=>'post'))
                                        ?>
                                            
                                            <div class="col-lg-12">
                                                
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label id="nm_edicao">Nome da edição</label>
                                                        <input id="nm_edicao"
                                                               name="nm_edicao"
                                                               type="text"
                                                               class="form-control"
                                                               tabindex="5"
                                                               placeholder="Digite o nome da edição"
                                                               style="text-transform: uppercase;"
                                                               value="<?php if ($msg != 'success'){
                                                                           echo set_value('nm_edicao');
                                                                       }?>">
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="col-lg-12" align="right">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active" tabindex="10">
                                                    Cadastrar
                                                </button>
                                                <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('edicao/edicoes/index')?>';"
                                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                                        Voltar
                                                </button>
                                                &nbsp;&nbsp;
                                            </div>

                                        <?php
                                            echo form_close();
                                        ?>
                                    </div>

                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
    </div>
</div>