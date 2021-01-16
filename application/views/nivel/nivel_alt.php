

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
                                            echo validation_errors('<div class="alert alert-danger">','</div>');
                                            if($msg == "success"){ ?>

                                            <div id="div_alert" class="alert alert-success">Registro gravado com sucesso!</div>
                                            <script type="text/javascript">
                                                // Iniciará quando todo o corpo do documento HTML estiver pronto.
                                                $().ready(function() {
                                                    setTimeout(function () {
                                                        $('#div_alert').hide(); // "foo" é o id do elemento que seja manipular.
                                                    }, 800); // O valor é representado em milisegundos.
                                                });
                                            </script>
                                                <?php
                                            }
                                            echo form_open('nivel/niveis/salvar',array('id'=>'frm_niveis','method'=>'post'));

                                            foreach ($niveis as $result) {

                                        ?>



                                                <table width="100%">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <label id="txt-nm_nivel">Nome do Nível</label>
                                                                    <input id="txt-nm_nivel"
                                                                           name="txt-nm_nivel"
                                                                           type="text"
                                                                           class="form-control"
                                                                           style="text-transform: uppercase;"
                                                                           placeholder="Digite o nome do nível"
                                                                           value="<?php echo $result->nm_nivel ?>">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <input type="hidden" id="txt-id" name="txt-id" value="<?php echo $result->ci_nivel?>">

                                                <div class="row" align="right">

                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Atualizar</button>
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