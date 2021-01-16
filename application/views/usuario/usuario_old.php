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
                           <?php echo 'Adicionar novo '.$subtitulo ?>

                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php 
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                        echo form_open('usuario/usuarios/inserir');
                                    ?>
                                        <div class="form-group">
                                            <label id="txt-nome">Nome do Usuário</label>
                                            <input id="txt-nome" name="txt-nome" type="text" class="form-control" placeholder="Digite o nome do usuário" value="<?php echo set_value('txt-nome')?>">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-email">Email</label>
                                            <input id="txt-email" name="txt-email" type="text" class="form-control" placeholder="Digite o email do usuário" value="<?php echo set_value('txt-email')?>">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-cpf">CPF</label>
                                            <input id="txt-cpf" name="txt-cpf" type="text" class="form-control" placeholder="Digite o cpf do usuário" value="<?php echo set_value('txt-cpf')?>">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-telefone">Telefone</label>
                                            <input id="txt-telefone" name="txt-telefone" type="text" class="form-control" placeholder="Digite o telefone do usuário" value="<?php echo set_value('txt-telefone')?>">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-user">Login do usuário</label>
                                            <input id="txt-user" name="txt-user" type="text" class="form-control" placeholder="Digite o user do usuário" value="<?php echo set_value('txt-user')?>">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-senha">Senha</label>
                                            <input id="txt-senha" name="txt-senha" type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label id="txt-confir-senha">Confirmar Senha</label>
                                            <input id="txt-confir-senha" name="txt-confir-senha" type="password" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-default">Cadastrar</button>

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
                           <?php echo 'Alterar '.$subtitulo.' existente' ?>

                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <style>
                                        img{
                                            width:50px; 
                                        }
                                    </style>
                                    <?php 
                                        $this->table->set_heading("Foto","Nome do Usuário","Alterar","Excluir");
                                        foreach ($usuarios as $usuario) {
                                            $nomeuser= $usuario->nm_usuario;
                                    
                                            if($usuario->img == 1){ 
                                                $fotouser = img('./assets/frontend/img/usuarios/'.md5($usuario->ci_usuario).'.jpg');
                                            }else{
                                                $fotouser = img('./assets/frontend/img/semFoto2.png');    
                                            }
                                          


                                            $alterar= anchor(base_url('usuario/usuarios/alterar/'.md5($usuario->ci_usuario)), '<i class="fa fa-refresh fa-fw">Alterar');



                                        $excluir= '<button type="button" class="btn btn-link" data-toggle="modal" data-target=".excluir-modal-'.$usuario->ci_usuario.'"><i class="fa fa-remove fa-fw"></i> Excluir</button>';

                                        echo $modal= ' <div class="modal fade excluir-modal-'.$usuario->ci_usuario.'" tabindex="-1" role="dialog" aria-hidden="true">
                                                                            <div class="modal-dialog modal-sm">
                                                                                <div class="modal-content">

                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                                                        </button>
                                                                                        <h4 class="modal-title" id="myModalLabel2">Exclusão de Usuario</h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <h4>Deseja Excluir o Usuario '.$usuario->nm_usuario.'?</h4>
                                                                                        <p>Após Excluido o usuario <b>'.$usuario->nm_usuario.'</b> não ficara mais disponível no Sistema.</p>
                                                                                        <p>Todos os itens relacionados ao usuario <b>'.$usuario->nm_usuario.'</b> serão afetados e não aparecerão no site até que sejam editados.</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                                                        <a type="button" class="btn btn-primary" href="'.base_url("usuario/usuarios/excluir/".md5($usuario->ci_usuario)).'">Excluir</a>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>';

                                            $this->table->add_row($fotouser,$nomeuser,$alterar,$excluir);

                                            
                                        }

                                        $this->table->set_template(array(
                                            'table_open' => '<table class="table table-striped">'
                                        ));
                                        echo $this->table->generate();
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


<!--
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Titulo</label>
                                            <input class="form-control" placeholder="Entre com o texto">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Destaque</label>
                                            <input type="file">
                                        </div>
                                        <div class="form-group">
                                            <label>Conteúdo</label>
                                            <textarea class="form-control" rows="3"></textarea>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Selects</label>
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Cadastrar</button>
                                        <button type="reset" class="btn btn-default">Limpar</button>
                                    </form>

    -->