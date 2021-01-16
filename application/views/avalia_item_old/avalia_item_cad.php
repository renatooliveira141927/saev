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
                                        }else if($msg == "aluno_ja_existente"){
                                            ?>

                                            <script type="text/javascript">
                                                mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o aluno já está cadastrado no banco de dados!");
                                            </script>

                                            <?php
                                        }
                                            echo form_open('aluno/alunos/salvar',array('id'=>'frm_alunos','method'=>'post'))
                                        ?>
                                            <div class="col-lg-12">
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label id="sel_cd_edicao">Edição</label>

                                                        <select id="cd_edicao" name="cd_edicao" class="form-control" tabindex="0" autofocus>
                                                            <Option value=""></Option>
                                                            <?php
                                                            foreach ($edicoes as $result) {
                                                                ?>
                                                                <Option value="<?php echo $result->ci_edicao; ?>"
                                                                    <?php if ((set_value('cd_edicao') == $result->ci_edicao) && ($msg != 'success')){ echo 'selected'; } ?> >
                                                                    <?php echo $result->nm_edicao; ?>
                                                                </Option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="container">
                                                        <label id="">Sexo</label>
                                                    </div>
                                                    <div class="form-control">
                                                        <input type="radio" name="rd_fl_sexo" id="sexo_m" value="M" tabindex="1"
                                                            <?php if((set_value('rd_fl_sexo') == 'M') && ($msg != 'success')){
                                                                echo 'checked'; }
                                                                ?>>
                                                        <label class="form-check-label" for="sexo_m">Masculino</label>

                                                        <input type="radio" name="rd_fl_sexo" id="sexo_f" value="F"  class="form-check-input" tabindex="2"
                                                            <?php if((set_value('rd_fl_sexo') == 'F') && ($msg != 'success')){
                                                                echo 'checked'; }
                                                                ?>>
                                                        <label class="form-check-label" for="sexo_f">Feminino</label>

                                                        <input type="radio" name="rd_fl_sexo" id="sexo_o" value="O"  class="form-check-input" tabindex="3"
                                                            <?php if((set_value('rd_fl_sexo') == 'O')&& ($msg != 'success')){
                                                                echo 'checked'; }
                                                                ?>>
                                                        <label class="form-check-label" for="sexo_o">Outros</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <label id="nr_inep">INEP</label>
                                                        <input id="nr_inep"
                                                               name="nr_inep"
                                                               type="number"
                                                               class="form-control"
                                                               tabindex="4"
                                                               placeholder="INEP"
                                                               style="text-transform: uppercase;"
                                                               onkeyup="somenteNumeros(this);"
                                                               maxlength="8"
                                                               value="<?php if ($msg != 'success'){
                                                                            echo set_value('nr_inep');
                                                                      }?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="form-group">
                                                        <label id="nm_aluno">Nome do aluno</label>
                                                        <input id="nm_aluno"
                                                               name="nm_aluno"
                                                               type="text"
                                                               class="form-control"
                                                               tabindex="5"
                                                               placeholder="Digite o nome do aluno"
                                                               style="text-transform: uppercase;"
                                                               value="<?php if ($msg != 'success'){
                                                                           echo set_value('nm_aluno');
                                                                       }?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Data de nascimento</label>
                                                        <?php

                                                            $data = '';
                                                            if ($msg != 'success'){
                                                                $data = set_value('txt_data');
                                                            }

                                                            $data1 = '';

                                                            if ($data != '') {

                                                                $data = DateTime::createFromFormat('d/m/Y', $data);
                                                                $data1 = $data->format('m/d/Y');
                                                            }
                                                            $dados['data'] = $data1;
                                                            $dados['tabindex'] = '6';

                                                            $this->load->view('include/data_calendario', $dados);
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label id="nm_mae">Nome da mãe</label>
                                                        <input id="nm_mae"
                                                               name="nm_mae"
                                                               type="text"
                                                               class="form-control"
                                                               tabindex="7"
                                                               placeholder="Digite o nome da mãe"
                                                               style="text-transform: uppercase;"
                                                               value="<?php if ($msg != 'success'){
                                                                   echo set_value('nm_mae');
                                                               }?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label id="cd_etapa">Etapa/Ano </label>

                                                        <select id="cd_etapa" name="cd_etapa" class="form-control" tabindex="8">
                                                            <Option value=""></Option>
                                                            <?php
                                                            foreach ($etapas as $result) {
                                                                ?>
                                                                <Option value="<?php echo $result->ci_etapa; ?>"
                                                                    <?php if((set_value('cd_etapa') == $result->ci_etapa)&& ($msg != 'success')){
                                                                        echo 'selected';
                                                                    } ?> >
                                                                    <?php echo $result->nm_etapa; ?>
                                                                </Option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label id="cd_turma">Turma </label>

                                                        <select id="cd_turma" name="cd_turma" class="form-control" tabindex="9">
                                                            <Option value=""></Option>
                                                            <?php
                                                            foreach ($turmas as $result) {

                                                                ?>
                                                                <Option value="<?php echo $result->ci_turma; ?>"
                                                                    <?php if((set_value('cd_turma') == $result->ci_turma)&& ($msg != 'success')){
                                                                        echo 'selected';
                                                                    } ?> >
                                                                    <?php echo $result->nm_turma; ?>
                                                                </Option>
                                                            <?php } ?>

                                                        </select>
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