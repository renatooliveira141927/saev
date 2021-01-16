
<style type="text/css">
    /* Style para alterar o texto quando utilizado em dispositivos móveis */
    .desktop {
        display: block;
        /* ou inline, inline-block */
    }

    .mobile {
        display: none;
    }

    @media(max-width: 827px) {
        .desktop {
            display: none;
        }
        .mobile {
            display: block;
            /* ou inline, inline-block */
        }
    }
</style>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container ">

            <!-- Logo container DESKTOP-->
            <div class="logo desktop" align="center">
                <!-- Logomarca e titulo do projeto -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/indice.jpg') ?>" alt="" height="50">
                    &nbsp;&nbsp; SAEV - SISTEMA DE AVALIAÇÃO EDUCAR PRA VALER
                </a>
            </div>
            <!-- End Logo container DESKTOP-->

            <!-- Logo container MOBILE-->
            <div class="logo mobile" align="center">
                <!-- Logomarca e titulo do projeto -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/indice.jpg') ?>" alt="" height="50">
                    &nbsp;&nbsp; SAEV
                </a>
            </div>
            <!-- End Logo container MOBILE-->

            <div class="menu-extras">

                <ul class="nav navbar-nav navbar-right pull-right">

                    <li class="dropdown navbar-c-items">
                        <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true">
                        <?php if ($this->session->userdata('img')){?>                            
                            <img src="<?php echo base_url('assets/img/usuarios/'.$this->session->userdata('img'))?>" alt="user-img" class="img-circle"> 
                        <?php }else{?>
                            <?php if ($this->session->userdata('fl_sexo') == 'M'){?>
                                <img src="<?php echo base_url('assets/img/usuarios/semfoto_masculino.jpg')?>" alt="user-img" class="img-circle"> 
                            <?php }else{?>
                                <img src="<?php echo base_url('assets/img/usuarios/semfoto_feminino.jpg')?>" alt="user-img" class="img-circle"> 
                            <?php }?>
                        <?php }?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li class="text-center">
                                <h5>Olá, <?php echo $this->session->userdata('primeironome')?></h5>
                            </li>
                            <?PHP
                            if (!isset($habilitar_menu)){?>
                                <li class="text-center">
                                    <h5>ACESSO: <?php echo $this->session->userdata('nm_grupo')?></h5>
                                </li>
                                <li class="text-center">
                                    <h5><?php echo $this->session->userdata('nm_escola')?></h5>
                                </li>
                                <?php if ($this->session->userdata('troca_escola') == "S"){?>

                                    <li><a href="<?php echo base_url('usuario/autenticacoes/get_grupo_usuario') ?>"><i class="ti-power-off m-r-5"></i> Trocar acesso</a></li>
                                <?php }?>
                            <?PHP }?>
                            <li><a href="<?php echo base_url('usuario/autenticacoes/logout') ?>"><i class="ti-power-off m-r-5"></i> Sair</a></li>
                        </ul>

                    </li>
                </ul>
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>
            <!-- end menu-extras -->

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <?PHP
        if (!isset($habilitar_menu)){?>
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <?php if ($this->session->userdata('CADASTROS')) { ?>
                                <li class="has-submenu">
                                    <a href="#"><i class="mdi mdi-file-outline"></i>Cadastros</a>
                                    <ul class="submenu">
                                        <?php if ($this->session->userdata('AVALIACOES_OLD')) { ?>
                                            <li class="has-submenu">
                                                <a href="#">Avaliações</a>
                                                <ul class="submenu">
                                                    <?php if ($this->session->userdata('AVALIACAO')) { ?>
                                                        <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads') ?>">Avaliação para impressão</a></li>                                                        
                                                    <?php } ?>       
                                                    <?php if ($this->session->userdata('ITEM')) { ?>
                                                        <li><a href="<?php echo base_url('avalia_item/avalia_itens/novo') ?>">Itens</a></li>
                                                    <?php } ?> 
                                                    <?php if ($this->session->userdata('AVALIACAO TURMA')) { ?>
                                                        <li><a href="<?php echo base_url('avaliacao/Avalia_turmas') ?>">Definir turmas avaliadas</a></li>
                                                    <?php } ?> 
                                                </ul>
                                            </li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('AUXILIARES')) { ?>
                                            <li class="has-submenu">
                                                <a href="#">Auxiliares</a>
                                                <ul class="submenu">
                                                    <?php if ($this->session->userdata('ETAPA')) { ?>
                                                        <li><a href="<?php echo base_url('etapa/etapas/novo') ?>">Etapas</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('EDICAO')) { ?>
                                                        <li><a href="<?php echo base_url('edicao/edicoes/novo') ?>">Edições</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TIPODEAVALIACAO')) { ?>
                                                        <li><a href="<?php echo base_url('avalia_tipo/avalia_tipos/novo') ?>">Tipo de avaliações</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TURNO')) { ?>
                                                        <li><a href="<?php echo base_url('turno/turnos/novo') ?>">Turnos</a></li>
                                                    <?php } ?>
                                                    <!-- <'?php if ($this->session->userdata('CONTEUDO')) { ?>
                                                        <li><a href="<'?php echo base_url('avalia_conteudo/avalia_conteudos/novo') ?>">Conteúdos</a></li>
                                                    <'?php } ?>
                                                    <'?php if ($this->session->userdata('SUBCONTEUDO')) { ?>
                                                        <li><a href="<'?php echo base_url('avalia_subconteudo/avalia_subconteudos/novo') ?>">Sub-conteúdos</a></li>
                                                    <'?php } ?>
                                                    <'?php if ($this->session->userdata('ORIGEM')) { ?>
                                                        <li><a href="<'?php echo base_url('avalia_origem/avalia_origens/novo') ?>">Origens</a></li>
                                                    <'?php } ?>
                                                    <'?php if ($this->session->userdata('DIFICULDADE')) { ?>
                                                        <li><a href="<'?php echo base_url('avalia_dificuldade/avalia_dificuldades/novo') ?>">Dificuldades</a></li>
                                                    <'?php } ?> -->
                                                    <?php if ($this->session->userdata('GRUPO')) { ?>
                                                        <li><a href="<?php echo base_url('usuario/grupos/novo') ?>">Grupos</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TRANSACAO')) { ?>
                                                        <li><a href="<?php echo base_url('usuario/transacoes/novo') ?>">Transações</a></li>  
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('AVALIACOES')) { ?>
                                            <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads/novo') ?>">Avaliações</a></li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('ALUNO')) { ?>
                                            <li><a href="<?php echo base_url('aluno/alunos/novo') ?>">Alunos</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('ENTURMACAO')) { ?>
                                            <li><a href="<?php echo base_url('enturmacao/enturmacoes') ?>">Enturmação</a></li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('ESCOLA')) { ?>
                                            <li><a href="<?php echo base_url('escola/escolas/novo') ?>">Escolas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('TURMA')) { ?>
                                            <li><a href="<?php echo base_url('turma/turmas/novo') ?>">Turmas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('PROFESSOR')) { ?>
                                            <li><a href="<?php echo base_url('professor/professores/novo') ?>">Professores</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('DISCIPLINA')) { ?>
                                            <li><a href="<?php echo base_url('disciplina/disciplinas/novo') ?>">Disciplinas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                            <li><a href="<?php echo base_url('usuario/usuarios/novo') ?>">Usu&aacute;rios</a></li>
                                        <?php } ?> 
                                        
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-magnify"></i>Consultas</a>
                                <ul class="submenu">
                                    <?php if ($this->session->userdata('AVALIACOES_OLD')) { ?>
                                        <li class="has-submenu">
                                            <a href="#">Avaliações</a>
                                            <ul class="submenu">
                                                <li><a href="<?php echo base_url('avaliacao/avaliacoes') ?>">Avaliações</a></li>        
                                                <li><a href="<?php echo base_url('avalia_item/avalia_itens') ?>">Itens</a></li>
                                                <li><a href="<?php echo base_url('avaliacao/avalia_montar') ?>">Montar avaliações</a></li>
                                            </ul>
                                        </li>
                                    <?php } ?> 
                                    <?php if ($this->session->userdata('AUXILIARES')) { ?>
                                        <li class="has-submenu">
                                            <a href="#">Auxiliares</a>
                                            <ul class="submenu">
                                                <?php if ($this->session->userdata('ETAPA')) { ?>
                                                    <li><a href="<?php echo base_url('etapa/etapas') ?>">Etapas</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('EDICAO')) { ?>
                                                    <li><a href="<?php echo base_url('edicao/edicoes') ?>">Edições</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('TIPODEAVALIACAO')) { ?>
                                                    <li><a href="<?php echo base_url('avalia_tipo/avalia_tipos') ?>">Tipo de avaliações</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('TURNO')) { ?>
                                                        <li><a href="<?php echo base_url('turno/turnos/novo') ?>">Turnos</a></li>
                                                <?php } ?>
                                                <!-- <'?php if ($this->session->userdata('CONTEUDO')) { ?>
                                                    <li><a href="<'?php echo base_url('avalia_conteudo/avalia_conteudos') ?>">Conteúdos</a></li>
                                                <'?php } ?>
                                                <'?php if ($this->session->userdata('SUBCONTEUDO')) { ?>
                                                    <li><a href="<'?php echo base_url('avalia_subconteudo/avalia_subconteudos') ?>">Sub-conteúdos</a></li>
                                                <'?php } ?>
                                                <'?php if ($this->session->userdata('ORIGEM')) { ?>
                                                    <li><a href="<'?php echo base_url('avalia_origem/avalia_origens') ?>">Origens</a></li>
                                                <'?php } ?>
                                                <'?php if ($this->session->userdata('DIFICULDADE')) { ?>
                                                    <li><a href="<'?php echo base_url('avalia_dificuldade/avalia_dificuldades') ?>">Dificuldades</a></li>
                                                <'?php } ?> -->
                                                <?php if ($this->session->userdata('GRUPO')) { ?>
                                                    <li><a href="<?php echo base_url('usuario/grupos') ?>">Grupos</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('TRANSACAO')) { ?>
                                                    <li><a href="<?php echo base_url('usuario/transacoes') ?>">Transações</a></li>  
                                                <?php } ?> 
                                            </ul>
                                        </li>
                                    <?php } ?> 
                                        <?php if ($this->session->userdata('AVALIACOES')) { ?>
                                            <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads') ?>">Avaliações</a></li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('ALUNO')) { ?>
                                            <li><a href="<?php echo base_url('aluno/alunos') ?>">Alunos</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('ESCOLA')) { ?>
                                            <li><a href="<?php echo base_url('escola/escolas') ?>">Escolas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('TURMA')) { ?>
                                            <li><a href="<?php echo base_url('turma/turmas') ?>">Turmas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('PROFESSOR')) { ?>
                                            <li><a href="<?php echo base_url('professor/professores') ?>">Professores</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('DISCIPLINA')) { ?>
                                            <li><a href="<?php echo base_url('disciplina/disciplinas') ?>">Disciplinas</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                            <li><a href="<?php echo base_url('usuario/usuarios') ?>">Usu&aacute;rios</a></li>
                                        <?php } ?> 
                                    </li>
                                </ul>
                            </li>
                            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados -->
                                <li class="has-submenu">
                                    <a href="#"><i class="mdi mdi-pen"></i>Avaliações</a>
                                    <ul class="submenu">
                                        <li><a href="<?php echo base_url('matriz/matrizes') ?>">Matriz de referência</a></li>
                                        <li><a href="<?php echo base_url('nivel/niveis') ?>">Manual do aplicador</a></li>
                                        <li><a href="<?php echo base_url('modalidade/modalidades') ?>">Avaliação on-line</a></li>
                                        <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads') ?>">Avaliação para impressão</a></li>
                                        <li><a href="<?php echo base_url('avaliacao/lancar_gabarito') ?>">Lançar resultados</a></li>
                                    </ul>
                                </li>
                            <?php }?> <!-- Se o usuário for administrados -->

                            <?php if ($this->session->userdata('ci_grupousuario') == 1){?> <!-- Se o usuário for administrados -->
                                <li class="has-submenu">
                                    <a href="#"><i class="mdi mdi-chart-pie"></i>Relatórios</a>
                                    <ul class="submenu">
                                        <li><a href="<?php echo base_url('etapa/etapas') ?>">Por geral município</a></li>
                                        <li><a href="<?php echo base_url('nivel/niveis') ?>">Resultado por estudante</a></li>
                                        <li><a href="<?php echo base_url('modalidade/modalidades') ?>">Resultado por escola</a></li>
                                        <li><a href="<?php echo base_url('turno/turnos') ?>">Resultado por descritor</a></li>
                                        <li><a href="<?php echo base_url('turno/turnos') ?>">Linha evolutiva</a></li>
                                        <li><a href="<?php echo base_url('turno/turnos') ?>">%alunos com aprendizado adequado</a></li>
                                        <li><a href="<?php echo base_url('turno/turnos') ?>">Linha evolutiva</a></li>
                                    </ul>
                                </li>
                            <?php }?> <!-- Se o usuário for administrados -->
                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->

        <?php } ?>
</header>

<br/><br/><br/><br/><br/>
<!-- End Navigation Bar-->

