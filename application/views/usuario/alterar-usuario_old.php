        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo 'Administrar '.$subtitulo ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php echo 'Alterar '.$subtitulo ?>

                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php 
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                        echo form_open('usuario/usuarios/salvar_alteracoes');

                                        foreach ($usuarios as $usuario) {
                                        
                                    ?>
                                            <div class="form-group">
                                                <label id="txt-nome">Nome do Usuário</label>
                                                <input id="txt-nome" name="txt-nome" type="text" class="form-control" placeholder="Digite o nome do usuário" value="<?php echo $usuario->nm_usuario?>">
                                            </div>
                                            <div class="form-group">
                                                <label id="txt-email">Email</label>
                                                <input id="txt-email" name="txt-email" type="text" class="form-control" placeholder="Digite o email do usuário" value="<?php echo $usuario->ds_email?>">
                                            </div>


                                    <div class="form-group">
                                        <label id="txt-cpf">CPF</label>
                                        <input id="txt-cpf" name="txt-cpf" type="text" class="form-control" placeholder="Digite o cpf do usuário" value="<?php echo $usuario->nr_cpf?>">
                                    </div>
                                    <div class="form-group">
                                        <label id="txt-telefone">Telefone</label>
                                        <input id="txt-telefone" name="txt-telefone" type="text" class="form-control" placeholder="Digite o telefone do usuário" value="<?php echo $usuario->ds_telefone?>">
                                    </div>


                                            <div class="form-group">
                                                <label id="txt-user">User</label>
                                                <input id="txt-user" name="txt-user" type="text" class="form-control" placeholder="Digite o user do usuário" value="<?php echo $usuario->nm_login?>">
                                            </div>
                                            <div class="form-group">
                                                <label id="txt-senha">Senha</label>
                                                <input id="txt-senha" name="txt-senha" type="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label id="txt-confir-senha">Confirmar Senha</label>
                                                <input id="txt-confir-senha" name="txt-confir-senha" type="password" class="form-control">
                                            </div>
                                            <input type="hidden" id="txt-id" name="txt-id" value="<?php echo $usuario->ci_usuario?>">
                                            <button type="submit" class="btn btn-default">Atualizar</button>

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
                
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php echo 'Imagem de destaque do '.$subtitulo.' usuário' ?>

                        </div>
                        <div class="panel-body">
                                    <?php
                                        if($usuario->img == 1){ 
                                            echo img('./assets/frontend/img/usuarios/'.md5($usuario->ci_usuario).'.jpg');
                                        }else{
                                            echo img('./assets/frontend/img/semFoto.png');    
                                        } 
                                    ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php 
                                        $divopen = '<div class="form-group">';
                                        $divclose= '</div>';
                                        echo form_open_multipart('usuario/usuarios/nova_foto');
                                        echo form_hidden('id', md5($usuario->ci_usuario));
                                        echo $divopen;
                                        $imagem= array('name' => 'userfile','id' => 'userfile','class' => 'form-control');
                                        echo form_upload($imagem);
                                        echo $divclose;
                                        echo $divopen;
                                        $botao= array('name' => 'btn_adicionar','id' => 'btn_adicionar','class' => 'btn btn-default','value' => 'Adicionar nova imagem');
                                        echo form_submit($botao);
                                        echo $divclose;
                                        echo form_close();

                                        }

                                    ?>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
