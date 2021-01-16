<script src="<?=base_url('assets/js/usuarios.js'); ?>"></script>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'ADMINISTRAR USUÁRIOS' ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('usuario/usuarios/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="form-group col-lg-12">
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nm_usuario">Nome</label>
                                <input type="text"
                                        name="nm_usuario"
                                        id="nm_usuario"
                                        tabindex="2"
                                        placeholder="Nome"
                                        class="form-control"
                                        value="<?php echo set_value('nm_usuario');?>">
                                </div>
                        </div>
                        <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados -->
                            <div class="form-group col-lg-6">
                                <label for="cd_grupo">Grupo *</label>
                                <select id="cd_grupo" name="cd_grupo" tabindex="1" class="form-control" onchange="habilitamenu($(this));">
                                    <Option value=""></Option>
                                    <?php
                                    foreach ($grupos as $item) {
                                        ?>
                                        <Option value="<?php echo $item->ci_grupousuario; ?>" tp_administrador="<?php echo $item->tp_administrador; ?>"
                                            <?php if ((set_value('cd_grupo') == $item->ci_grupousuario)){
                                                echo 'selected';
                                            } ?> >
                                            <?php echo $item->nm_grupo; ?>
                                        </Option>

                                    <?php } ?>
                                </select>
                            </div>                                                
                        <?php }else{ ?>
                            <input type="hidden" name="cd_grupo" id="cd_grupo" value="3">
                            <div class="form-group col-lg-6">
                                <label>Grupo *</label>
                                    <?php foreach ($grupos as $item) { ?>

                                            <?php if ($item->ci_grupousuario == 3){?>
                                                <input type="text"  class="form-control"  disabled value="<?php echo $item->nm_grupo; ?>">
                                            <?php } ?>

                                    <?php } ?>
                            </div>   
                        <?php } ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nm_login">Usuário</label>
                                <input type="text"
                                        name="nm_login"
                                        id="nm_login"
                                        tabindex="2"
                                        placeholder="Usuário"
                                        class="form-control"
                                        value="<?php echo set_value('nm_login');?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="nr_cpf">CPF:</label>
                                        <input type="text"
                                            name="nr_cpf"
                                            id="cpf"
                                            tabindex="2"
                                            placeholder="CPF"
                                            class="form-control cpf"
                                            value="<?php echo set_value('nr_cpf'); ?>">
                            </div>
                        </div>
                    </div>
                    

                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('usuario/usuarios')?>">
                    <div  align="right" class="main row">
                        <button type="button" id="btn_consulta"
                                tabindex="5"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Consultar
                        </button>
                                                
                    </div>
                </div>
    </div>
    <!-- Div para listagem resultado da consulta-->
    <div id="listagem_resultado"></div>
    </form>
    <script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
    <script src="<?=base_url('assets/js/mask.cpf.js'); ?>"></script>