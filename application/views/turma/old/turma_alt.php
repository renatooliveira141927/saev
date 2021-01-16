

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
                                            }else if($msg == "turma_ja_existente"){
                                            ?>

                                                <script type="text/javascript">
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois a turma já está cadastrado no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('turma/turmas/salvar',array('id'=>'frm_turmas','method'=>'post'));

                                                foreach ($turmas as $result) {
                                            ?>
                                                <div class="col-lg-12">
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label id="sel_cd_edicao">Edição</label>

                                                            <select id="sel-cd_edicao" name="sel-cd_edicao" class="form-control">
                                                                <Option value=""></Option>
                                                                <?php
                                                                foreach ($edicoes as $item) {
                                                                    ?>

                                                                    <Option value="<?php echo $item->ci_edicao; ?>"
                                                                        <?php if($item->ci_edicao == $result->cd_edicao){ echo 'selected'; } ?> >
                                                                        <?php echo $item->nm_edicao; ?>
                                                                    </Option>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="container">
                                                            <label id="rd_fl_sexo">Sexo</label>
                                                        </div>
                                                        <div class="form-control">
                                                            <input type="radio" name="rd_fl_sexo" id="sexo_m" value="M"  class="form-check-input"
                                                                <?php if($result->fl_sexo == 'M'){ echo 'checked'; } ?>>
                                                            <label class="form-check-label" for="sexo_m">Masculino</label>

                                                            <input type="radio" name="rd_fl_sexo" id="sexo_f" value="F"  class="form-check-input"
                                                                <?php if($result->fl_sexo == 'F'){ echo 'checked'; } ?>>
                                                            <label class="form-check-label" for="sexo_f">Feminino</label>

                                                            <input type="radio" name="rd_fl_sexo" id="sexo_o" value="O"  class="form-check-input"
                                                                <?php if($result->fl_sexo == 'O'){ echo 'checked'; } ?>>
                                                            <label class="form-check-label" for="sexo_o">Outros</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label id="txt-nr_inep">INEP</label>
                                                            <input id="txt-nr_inep"
                                                                   name="txt-nr_inep"
                                                                   type="number"
                                                                   class="form-control"
                                                                   placeholder="INEP"
                                                                   style="text-transform: uppercase;"
                                                                   onkeyup="somenteNumeros(this);"
                                                                   maxlength="8"
                                                                   value="<?php echo $result->nr_inep?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="form-group">
                                                            <label id="txt-nm_turma">Nome da turma</label>
                                                            <input id="txt-nm_turma"
                                                                   name="txt-nm_turma"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o nome da turma"
                                                                   style="text-transform: uppercase;"
                                                                   value="<?php echo $result->nm_turma?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Data de nascimento</label>
                                                            <?php
                                                            $dados['tabindex'] = '6';
                                                            $dados['data'] = $result->dt_nascimento;
                                                            $this->load->view('include/data_calendario', $dados);
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label id="txt-nm_mae">Nome da mãe</label>
                                                            <input id="txt-nm_mae"
                                                                   name="txt-nm_mae"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o nome da mãe"
                                                                   style="text-transform: uppercase;"
                                                                   value="<?php echo $result->nm_mae?>">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label id="sel-cd_etapa">Etapa/Ano </label>

                                                            <select id="sel-cd_etapa" name="sel-cd_etapa" class="form-control">
                                                                <Option value=""></Option>
                                                                <?php
                                                                foreach ($etapas as $item) {
                                                                    ?>

                                                                    <Option value="<?php echo $item->ci_etapa; ?>"
                                                                        <?php if($item->ci_etapa == $result->cd_etapa){ echo ' selected'; } ?> >
                                                                        <?php echo $item->nm_etapa; ?>
                                                                    </Option>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label id="sel-cd_turma">Turma </label>

                                                            <select id="sel-cd_turma" name="sel-cd_turma" class="form-control">
                                                                <Option value=""></Option>
                                                                <?php
                                                                foreach ($turmas as $item) {
                                                                    ?>

                                                                    <Option value="<?php echo $item->ci_turma; ?>"
                                                                        <?php if($item->ci_turma == $result->cd_turma){ echo 'selected'; } ?> >
                                                                        <?php echo $item->nm_turma; ?>
                                                                    </Option>

                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <input type="hidden" id="txt-id" name="txt-id" value="<?php echo $result->ci_turma?>">

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