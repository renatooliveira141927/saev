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
                                                mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o registro já existe no banco de dados!");
                                            </script>

                                            <?php
                                        }
                                            echo form_open('avalia_origem/avalia_origens/salvar',array('id'=>'frm_avalia_origems','method'=>'post'))
                                        ?>
                                            
                                            <div class="col-lg-12">
                                                
                                                <div class="col-lg-7">
                                                    <div class="form-group">
                                                        <label id="nm_avalia_origem">Nome da origem</label>
                                                        <input id="nm_avalia_origem"
                                                               name="nm_avalia_origem"
                                                               type="text"
                                                               class="form-control"
                                                               tabindex="5"
                                                               placeholder="Digite o nome do conteúdo"
                                                               style="text-transform: uppercase;"
                                                               value="<?php if ($msg != 'success'){
                                                                           echo set_value('nm_avalia_origem');
                                                                       }?>">
                                                    </div>
                                                </div>
                                                
                                            </div>


           



                                            <div class="col-lg-12" align="right">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active" tabindex="10">
                                                    Cadastrar
                                                </button>&nbsp;&nbsp;
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