

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
                               <?php echo 'Alterar '.$titulo ?>

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
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a transação já está cadastrado no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('usuario/transacoes/salvar',array('id'=>'frm_transacoes','method'=>'post'));

                                                foreach ($registros as $result) {
                                            ?>
                   
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label id="nm_transacao">Nome da transação</label>
                                                            <input id="nm_transacao"
                                                                   name="nm_transacao"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o nome da transação"
                                                                   style="text-transform: uppercase;"
                                                                   value="<?php echo $result->nm_transacao?>">
                                                        </div>
                                                    </div>
               
                                                



                                                <input type="hidden" id="ci_transacao" name="ci_transacao" value="<?php echo $result->ci_transacao?>">

                                                <div class="row" align="right">

                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Atualizar</button>
                                                        <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('usuario/transacoes/index')?>';"
                                                        class="btn btn-custom waves-effect waves-light btn-micro active">
                                                        Voltar</button>
                                                    </div>
                                                </div>

                                        <?php
                                            }
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