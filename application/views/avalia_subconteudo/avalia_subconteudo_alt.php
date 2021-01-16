

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
                                                    mensagem_sucesso("error" , "Não foi possível realizar o cadastro, pois o subconteúdo já está cadastrado no banco de dados!");
                                                </script>

                                                <?php
                                            }
                                            echo form_open('avalia_subconteudo/avalia_subconteudos/salvar',array('id'=>'frm_avalia_subconteudos','method'=>'post'));

                                                foreach ($registros as $result) {
                                            ?>
                                            <div class="col-lg-12">
                                                        <section class="main row">
                                                            <div class="form-group">
                                                                <label for="cd_avalia_conteudo">Conteúdo </label>
                                                                <select id="cd_avalia_conteudo" name="cd_avalia_conteudo" tabindex="3" class="form-control">
                                                                    <Option value=""></Option>
                                                                    <?php
                                                                    foreach ($avalia_conteudos as $item) {
                                                                        ?>
                                                                        <Option value="<?php echo $item->ci_avalia_conteudo; ?>"
                                                                            <?php if ($item->ci_avalia_conteudo == $result->cd_avalia_conteudo){
                                                                                echo 'selected';
                                                                            } ?> >
                                                                            <?php echo $item->nm_avalia_conteudo; ?>
                                                                        </Option>

                                                                    <?php } ?>
                                                                </select>


                                                            </div>
                                                        </section>
                                                    </div>
                                                    
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <section class="main row">
                                                            <label id="nm_avalia_subconteudo">Nome do sub-conteúdo</label>
                                                            <input id="nm_avalia_subconteudo"
                                                                   name="nm_avalia_subconteudo"
                                                                   type="text"
                                                                   class="form-control"
                                                                   placeholder="Digite o nome do conteudo"
                                                                   style="text-transform: uppercase;"
                                                                   value="<?php echo $result->nm_avalia_subconteudo?>">
                                                            </section>
                                                        </div>
                                                    </div>
               
                                                    



                                                <input type="hidden" id="ci_avalia_subconteudo" name="ci_avalia_subconteudo" value="<?php echo $result->ci_avalia_subconteudo?>">

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