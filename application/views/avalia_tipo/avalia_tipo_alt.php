

<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Administrar <?php echo $titulo ?></h3>
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
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o tipo de avaliação já está cadastrada no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('avalia_tipo/avalia_tipos/salvar',array('id'=>'frm_avalia_tipos','method'=>'post'));

                                                foreach ($registros as $result) {
                                            ?>
                   
                                                    <div class="col-lg-12">
                                                        <div class="form-group col-lg-12">
                                                            <label id="nm_avalia_tipo">Nome do tipo de avaliação</label>
                                                            <input id="nm_avalia_tipo"
                                                                   name="nm_avalia_tipo"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o nome do tipo de avaliação"
                                                                   value="<?php echo $result->nm_avalia_tipo?>">
                                                        </div>

                                                    </div>
               
                                                



                                                <input type="hidden" id="ci_avalia_tipo" name="ci_avalia_tipo" value="<?php echo $result->ci_avalia_tipo?>">

                                                <div class="row" align="right">

                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Atualizar</button>
                                                        <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('avalia_tipo/avalia_tipos/index')?>';"
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