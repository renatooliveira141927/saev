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
                                                mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o conteúdo já está cadastrado no banco de dados!");
                                            </script>

                                            <?php
                                        }
                                            echo form_open('avalia_conteudo/avalia_conteudos/salvar',array('id'=>'frm_avalia_conteudos','method'=>'post'))
                                        ?>
                                        <div class="col-lg-12">
                                                <section class="main row">
                                                    <div class="form-group">
                                                        <label for="cd_disciplina">Disciplina </label>
                                                        <select id="cd_disciplina" name="cd_disciplina" tabindex="3" class="form-control">
                                                            <Option value=""></Option>
                                                            <?php
                                                            foreach ($disciplinas as $item) {
                                                                ?>
                                                                <Option value="<?php echo $item->ci_disciplina; ?>"
                                                                    <?php if (set_value('cd_disciplina') == $item->ci_disciplina){
                                                                        echo 'selected';
                                                                    } ?> >
                                                                    <?php echo $item->nm_disciplina; ?>
                                                                </Option>

                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </section>
                                            </div>
                                            
                                            <div class="col-lg-12">
                                                
                                                <section class="main row">
                                                    <div class="form-group">
                                                        <label id="nm_avalia_conteudo">Nome do conteúdo</label>
                                                        <input id="nm_avalia_conteudo"
                                                                name="nm_avalia_conteudo"
                                                                type="text"
                                                                class="form-control"
                                                                tabindex="5"
                                                                placeholder="Digite o nome do conteúdo"
                                                                style="text-transform: uppercase;"
                                                                value="<?php if ($msg != 'success'){
                                                                            echo set_value('nm_avalia_conteudo');
                                                                        }?>">
                                                    </div>
                                                </section>
                                                
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