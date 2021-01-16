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
                                            echo form_open('turma/turmas/salvar',array('id'=>'frm_turmas','method'=>'post'))
                                        ?>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label id="sel_cd_edicao">Edição</label>

                                                    <select id="sel-cd_edicao" name="sel-cd_edicao" class="form-control">
                                                        <Option value=""></Option>
                                                        <?php
                                                        foreach ($edicoes as $result) {
                                                            ?>

                                                            <Option value="<?php echo $result->ci_edicao; ?>">
                                                                <?php echo $result->nm_edicao; ?>
                                                            </Option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label id="txt-nm_turma">Nome da Turma</label>
                                                    <input id="txt-nm_turma"
                                                           name="txt-nm_turma"
                                                           type="text"
                                                           class="form-control"
                                                           placeholder="Digite o nome da turma"
                                                           style="text-transform: uppercase;"
                                                           value="<?php echo set_value('txt-nm_turma')?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label id="sel-cd_etapa">Etapa/Ano </label>

                                                    <select id="sel-cd_etapa" name="sel-cd_etapa" class="form-control">
                                                        <Option value=""></Option>
                                                        <?php
                                                        foreach ($etapas as $result) {
                                                            ?>

                                                            <Option value="<?php echo $result->ci_etapa; ?>">
                                                                <?php echo $result->nm_etapa; ?>
                                                            </Option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label id="sel-cd_turno">Turno </label>

                                                    <select id="sel-cd_turno" name="sel-cd_turno" class="form-control">
                                                        <Option value=""></Option>
                                                        <?php
                                                        foreach ($turnos as $result) {
                                                            ?>

                                                            <Option value="<?php echo $result->ci_turno; ?>">
                                                                <?php echo $result->nm_turno; ?>
                                                            </Option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label id="sel-cd_professor">Professor Alfabetizador </label>

                                                    <select id="sel-cd_professor" name="sel-cd_professor" class="form-control">
                                                        <Option value=""></Option>
                                                        <?php
                                                        foreach ($professores as $result) {
                                                            ?>

                                                            <Option value="<?php echo $result->ci_professor; ?>">
                                                                <?php echo $result->nm_professor; ?>
                                                            </Option>

                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" align="right">
                                                <button type="submit" class="btn btn-custom waves-effect waves-light btn-micro active">Cadastrar</button>
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