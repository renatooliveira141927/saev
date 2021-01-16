<div class="container">
    <div  class="card-group">
        <div id="page-wrapper" >
                <div class="row">
                    <div class="col-lg-12">
                                <h3 class="page-header">Administrar TURNOS</h3>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                               <?php echo 'Cadastro de Turnos'?>

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
                                                mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o turno já está cadastrado no banco de dados!");
                                            </script>

                                            <?php
                                        }
                                            echo form_open('turno/turnos/salvar',array('id'=>'frm_turnos','method'=>'post'))
                                        ?>
                                            
                                            <div class="col-lg-12">
                                                
                                                <div class="form-group col-lg-12">
                                                    <label for="nm_turno">Nome - Turno</label>
                                                    <input id="nm_turno"
                                                            name="nm_turno"
                                                            type="text"
                                                            class="form-control"
                                                            tabindex="2"
                                                            placeholder="Digite o nome do turno"
                                                            value="<?php if ($msg != 'success'){
                                                                        echo set_value('nm_turno');
                                                                    }?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-12" align="right">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active" tabindex="10">
                                                    Cadastrar
                                                </button>
                                                <button type="button" 
                                                        onclick="window.location.href ='<?php echo base_url('turno/turnos/index')?>';"
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