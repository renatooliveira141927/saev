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
<!-- grupos 
2	SME
1	ADMINSTRADOR
3	ESCOLA
 -->

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container DESKTOP-->
            <div class="logo desktop" align="center">
                <!-- Logomarca e titulo do projeto -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <img src="<?php echo base_url('assets/images/indice.jpg') ?>" alt="" height="50">
                    &nbsp;&nbsp; SAEV - SISTEMA DE AVALIAÇÃO EDUCAR PRA VALER

                    <?php 
                        if($_SERVER['HTTP_HOST']=='127.0.0.1') {
                            echo ' - LOCALHOST';
                        }elseif(strtoupper( trim($_SERVER['HTTP_HOST'])) == 'LOCALHOST'){
                            echo ' - LOCALHOST';
                        }elseif(strtoupper( trim($_SERVER['HTTP_HOST'])) == 'WWW.SAEVTREINA.EDUCACAO.WS'){
                            //$config['base_url'] = 'http://www.saev.educacao.ws/';
                            echo ' - TREINAMENTO';
                        }elseif( strtoupper( trim($_SERVER['HTTP_HOST'])) == 'WWW.EDUCARPRAVALER.ORG'){
                            echo '';
                        }
                    ?>
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
                            <?php }else if ($this->session->userdata('fl_sexo') == 'F'){?>
                                <img src="<?php echo base_url('assets/img/usuarios/semfoto_feminino.jpg')?>" alt="user-img" class="img-circle">                             
                            <?php }else{?>
                                <img src="<?php echo base_url('assets/img/usuarios/semfoto_anonimo.png')?>" alt="user-img" class="img-circle"> 
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
        <!-- div exibir nome e escola -->
<!-- <div class="topbar-main">
    <div class="menu-extras">
        <div  class="navbar-custom">
            <div class="navigation"> -->
                <!-- <div class="navigation-menu"  style="background-color:	#F5F5F5;"> -->
                <!-- <div class="navigation-menu"  style="background-color:#36404E">
                    <div class="container">
                        <div class="col-lg-6" style="text-align:left;color: #FFFFFF;">
                            Usuário: <'?php echo $this->session->userdata('primeironome')?>
                        </div>
                        <div class="col-lg-6" style="text-align:right;color: #FFFFFF;">
                            &nbsp;&nbsp;

                            <'?php 
                                echo $this->session->userdata('nm_grupo');
                                if ($this->session->userdata('nr_inep')){
                                    echo ' - '.$this->session->userdata('nr_inep').' - '.$this->session->userdata('nm_escola');
                                }
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  -->
    <!-- Fim div exibir nome e escola -->
    </div>
    <!-- end topbar-main -->

    <?PHP
        if (!isset($habilitar_menu)){?>
            <div class="navbar-custom">
                <div class="container-fluid">
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
                                                    <?php if (($this->session->userdata('ANOLETIVO')) ||($this->session->userdata('ci_usuario')==1)) { ?>
                                                        <li><a href="<?php echo base_url('ano_letivo/anos_letivos') ?>">Ano letivo</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('DEFICIENCIA')) { ?>
                                                        <li><a href="<?php echo base_url('deficiencia/deficiencia') ?>">Deficiência</a></li>
                                                    <?php } ?> 
                                                    <?php if ($this->session->userdata('DISCIPLINA')) { ?>
                                                        <li><a href="<?php echo base_url('disciplina/disciplinas') ?>">Disciplinas</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('EDICAO')) { ?>
                                                        <li><a href="<?php echo base_url('edicao/edicoes') ?>">Edições</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('ETAPA')) { ?>
                                                        <li><a href="<?php echo base_url('etapa/etapas') ?>">Etapas</a></li>
                                                    <?php } ?>                                                                                                                                                          
                                                    <?php if ($this->session->userdata('GRUPO') && ($this->session->userdata('ci_usuario') ==1)) { ?>
                                                        <li><a href="<?php echo base_url('usuario/grupos') ?>">Grupos</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TRANSACAO') && ($this->session->userdata('ci_usuario') ==1)) { ?>
                                                        <li><a href="<?php echo base_url('usuario/transacoes') ?>">Transações</a></li>  
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TIPODEAVALIACAO')) { ?>
                                                        <li><a href="<?php echo base_url('avalia_tipo/avalia_tipos') ?>">Tipo de avaliações</a></li>
                                                    <?php } ?>
                                                    <?php if ($this->session->userdata('TURNO')) { ?>
                                                        <li><a href="<?php echo base_url('turno/turnos') ?>">Turnos</a></li>
                                                    <?php } ?>                                                    
                                                </ul>
                                            </li>
                                        <?php } ?>                                         
                                        <?php if ($this->session->userdata('ALUNO')) { ?>
                                            <li><a href="<?php echo base_url('aluno/alunos') ?>">Alunos</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('ENTURMACAO')) { ?>
                                            <li><a href="<?php echo base_url('enturmacao/enturmacoes') ?>">Enturmação</a></li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('ESCOLA')) { ?>
                                            <li><a href="<?php echo base_url('escola/escolas') ?>">Escolas</a></li>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('PROFESSOR')) { ?>
                                            <li><a href="<?php echo base_url('professor/professores') ?>">Professores</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('TURMA')) { ?>
                                            <li><a href="<?php echo base_url('turma/turmas') ?>">Turmas</a></li>
                                        <?php } ?>                                                                                
                                        <?php if ($this->session->userdata('INFREQUENCIA')) { ?>
                                            <li class="has-submenu">
                                                <a href="#">Infrequência</a>
                                                <ul class="submenu">
                                                    <?php if ($this->session->userdata('CADASTRO DE INFREQUENCIA')) { ?>
                                                        <li><a href="<?php echo base_url('infrequencia/infrequencia') ?>">Infrequência</a></li>
                                                    <?php } ?> 
                                                    <?php if ($this->session->userdata('LIBERACAO DE INFREQUENCIA')) { ?>
                                                        <li><a href="<?php echo base_url('infrequencia/infrequencia/pesquisaliberacao') ?>">Liberação de Infrequência</a></li>
                                                    <?php } ?>
                                               </ul>
                                            </li>            
                                        <?php } ?>                                           
                                        <?php if ($this->session->userdata('TRANSFERENCIA')) { ?>
                                            <li><a href="<?php echo base_url('transferencia/transferencias') ?>">Transfência</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                            <li><a href="<?php echo base_url('usuario/usuarios') ?>">Usu&aacute;rios</a></li>
                                        <?php } ?> 
                                        
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if ($this->session->userdata('AVALIACOES_OLD')) { ?>
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
                                                <?php if ($this->session->userdata('ANOLETIVO')) { ?>
                                                    <li><a href="<?php echo base_url('ano_letivo/anos_letivos') ?>">Ano letivo</a></li>
                                                <?php } ?> 
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
                                                        <li><a href="<?php echo base_url('turno/turnos') ?>">Turnos</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('DISCIPLINA')) { ?>
                                                    <li><a href="<?php echo base_url('disciplina/disciplinas') ?>">Disciplinas</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('GRUPO') && ($this->session->userdata('ci_usuario') ==1)) { ?>
                                                    <li><a href="<?php echo base_url('usuario/grupos') ?>">Grupos</a></li>
                                                <?php } ?>
                                                <?php if ($this->session->userdata('TRANSACAO') && ($this->session->userdata('ci_usuario') ==1)) { ?>
                                                    <li><a href="<?php echo base_url('usuario/transacoes') ?>">Transações</a></li>  
                                                <?php } ?> 
                                            </ul>
                                        </li>
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
                                        <?php if ($this->session->userdata('TRANSFERENCIA')) { ?>
                                            <li><a href="<?php echo base_url('transferencia/transferencias') ?>">Transfência</a></li>
                                        <?php } ?> 
                                        <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                            <li><a href="<?php echo base_url('usuario/usuarios') ?>">Usu&aacute;rios</a></li>
                                        <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>                            
                            <li class="has-submenu">
                                <a href="#"><i class="mdi mdi-pen"></i>Avaliações</a>
                                <ul class="submenu">
                                	<?php if ($this->session->userdata('AVALIACOES')) { ?>
                                            <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads') ?>">Cadastrar</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                        <li><a href="<?php echo base_url('matriz/matrizes') ?>">Matriz de referência</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                        <li><a href="<?php echo base_url('metasaprendizagem/metasaprendizagem/metaslista') ?>">Metas de Aprendizagem</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('USUARIO ADMIN') || $this->session->userdata('USUARIO SME')) { ?>
                                        <li><a href="<?php echo base_url('proficiencia/proficiencia/listar') ?>">Proficiência</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('APLICAR AVALIAÇÃO') || $this->session->userdata('AVALIACOES')) { ?>
                                        <li><a href="<?php echo base_url('avaliacao_upload/avaliacao_uploads') ?>">Avaliações</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('LANÇAR GABARITO')) { ?>
                                        <li><a href="<?php echo base_url('avaliacao/lancar_gabarito') ?>">Lançar resultados-Escrita</a></li>
                                        <li><a href="<?php echo base_url('avaliacao/lancar_gabaritoleitura') ?>">Lançar resultados-Leitura</a></li>
                                    <?php } ?>
                                </ul>
                            </li>

			                <?php if ($this->session->userdata('ci_grupousuario') == 1
                                    || $this->session->userdata('ci_grupousuario')== 2
                                    || $this->session->userdata('ci_grupousuario')== 3){?> <!-- Se o usuário for administrados -->
                                    
                                <li class="has-submenu">
                                    <a href="#"><i class="mdi mdi-chart-pie"></i>Relatórios</a>
                                    <ul class="submenu">
                                        <?php if ($this->session->userdata('ci_grupousuario') == 1
                                            || $this->session->userdata('ci_grupousuario')== 2){ ?>
                                            <li class="has-submenu">
                                                <a href="#"></i>Por município</a>
                                                    <ul class="submenu">
														<li><a href="<?php echo base_url('relatorio/munNivelAprendizagem') ?>">Nível de Aprendizagem</a></li>                                                                                                            
                                                        <li><a href="<?php echo base_url('relatorio/munEscritaEscola') ?>">Escrita por Escola</a></li>
                                                        <li><a href="<?php echo base_url('relatorio/munLeitura') ?>">Consolidado: Município Leitura</a></li>                                                        
                                                        <li><a href="<?php echo base_url('relatorio/estadoleitura') ?>">Município Leitura</a></li>
                                                        <li><a href="<?php echo base_url('relatorio/painelAprendizagemnew') ?>">Painel de Aprendizagem</a></li>
                                                        <li><a href="<?php echo base_url('relatorio/painelAprendizagem') ?>">Situação de Aprendizagem</a></li>
                                                        <li><a href="<?php echo base_url('relatorio/leituraescritaMunicipio') ?>">LeituraXEscrita Município</a></li>
                                                    </ul>
                                            </li>
                                        <?php }?>
                                            <li class="has-submenu">
                                                <a href="#"></i>Por Escola</a>
                                                <ul class="submenu">
                                                <!--<li><a href="<?php //echo base_url('relatorio/escNivelAprendizagem') ?>">Nível de Aprendizagem</a></li> -->                                                    
                                                    <li><a href="<?php echo base_url('relatorio/pesquisaPorNivelDesempenho') ?>">Nível de Aprendizagem</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/leituraEscola') ?>">Leitura por Escola</a></li>
                                                </ul>
                                            </li>
                                            <li class="has-submenu">           
                                                <a href="#"></i>Por Turma</a>
                                                <ul class="submenu">                                                    
                                                    <li><a href="<?php echo base_url('relatorio/pesquisaErrosAcertosnew') ?>">Escrita:Resultado por estudante</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/percAcertoHabilidadeAvaliada') ?>">Escrita:Percentual de Acerto por habilidade avaliada</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/pesquisaAvaliacaoLeituraAluno') ?>">Leitura:Resultado por estudante</a></li>
                                                </ul>
                                            </li>
                                            <li class="has-submenu">
                                                <a href="#"></i>Linha Evolutiva</a>
                                                <ul class="submenu">
                                                    <?php if ($this->session->userdata('ci_grupousuario') == 1
                                                        || $this->session->userdata('ci_grupousuario')== 2){?>
                                                    <li><a href="<?php echo base_url('relatorio/evolucaoMunicipio') ?>">Evolução do Município</a></li>
                                                   <?php }?> 
                                                    <li><a href="<?php echo base_url('relatorio/evolucaoEscola') ?>">Evolução da Escola</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/evolucaoTurma') ?>">Evolução da Turma</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/evolucaoAluno') ?>">Evolução do Aluno</a></li>
                                                </ul>
                                            </li> 
                                            <?php if ($this->session->userdata('INFREQUENCIA')) { ?>
                                            <li class="has-submenu">
                                                <a href="#">Infrequência</a>
                                                <ul class="submenu"> 
                                                <?php if ($this->session->userdata('ci_grupousuario') == 1
                                                        || $this->session->userdata('ci_grupousuario')== 2){?>                                                   
                                                    <li><a href="<?php echo base_url('relatorio/infrEscola') ?>">Evolução por Escola</a></li>
                                                <?php }?>                                                       
                                                    <li><a href="<?php echo base_url('relatorio/infrTurma') ?>">Evolução por Turma</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/infrAluno') ?>">Evolução por Aluno</a></li>                                                   
                                               </ul>
                                            </li>            
                                        	<?php } ?>
                                        	
                                        	<?php if ($this->session->userdata('PARTICIPACAO')) { ?>
<!--                                             <li class="has-submenu"> -->
<!--                                                 <a href="#">Participação</a> -->
<!--                                                 <ul class="submenu">  -->
                                                <?php if ($this->session->userdata('ci_grupousuario') == 1
                                                        || $this->session->userdata('ci_grupousuario')== 2){?>                                                   
<!--                                                 <li><a href="<?php echo base_url('relatorio/participacaoMun') ?>">Participação por Município</a></li>-->
                                                <?php }?>                                                       
<!--                                                    <li><a href="<?php echo base_url('relatorio/participacaoEsc') ?>">Participação por Escola</a></li>-->
<!--                                                    <li><a href="<?php echo base_url('relatorio/participacaoTur') ?>">Participação por Turma</a></li> -->                                                  
<!--                                                </ul> -->
<!--                                             </li>             -->
                                        	<?php } ?>
                                        	
                                        	<?php if ($this->session->userdata('ci_grupousuario') == 1
                                                        || $this->session->userdata('ci_grupousuario')== 2){ ?>
                                        	<li class="has-submenu">
                                                <a href="#">Exportar Dados</a>
                                                <ul class="submenu">
                                                	<li><a href="<?php echo base_url('exportadados/exportadados/escrita') ?>">Avaliações Escritas</a></li>
                                                	<li><a href="<?php echo base_url('exportadados/exportadados/leitura') ?>">Avaliações de Leitura</a></li>
                                                </ul>                        
                                            </li>
                                            <?php }?>
                                            
                                            <?php if ($this->session->userdata('ENTURMACAO')) { ?>
                                            <li class="has-submenu hidden">
                                                <a href="#">Enturmação</a>
                                                <ul class="submenu"> 
                                                <?php if ($this->session->userdata('ci_grupousuario') == 1
                                                        || $this->session->userdata('ci_grupousuario')== 2){?>                                                                                                       
                                                <?php }?>                                                       
                                                                                                                                                
                                               </ul>
                                            </li>            
                                        	<?php } ?>                   

                                            
                                            <li class="has-submenu">
                                                <a href="#">Caderno de Prova</a>
                                                <ul class="submenu"> 
                                                    <li><a href="<?php echo base_url('relatorio/cadernoProva') ?>">Descritores da Avaliação</a></li>                                                                                            
                                               </ul>
                                            </li>                                                    	
                                           <?php if ($this->session->userdata('ci_grupousuario') == 1){ ?> 
                                            <li class="has-submenu">
                                                <a href="#">Monitormanto</a>
                                                <ul class="submenu"> 
                                                	<li><a href="<?php echo base_url('monitoramento/enturmacao_geral') ?>">Enturmação Geral</a></li>
                                                    <li><a href="<?php echo base_url('monitoramento/enturmacao_municipio') ?>">Enturmação por Município</a></li>
                                                    <li><a href="<?php echo base_url('monitoramento/enturmacao_escola') ?>">Enturmacao por Escola</a></li>
                                                    <li><a href="<?php echo base_url('monitoramento/enturmacao_turma') ?>">Enturmacao por Turma</a></li>
                                                    <li><a href="<?php echo base_url('relatorio/relatorioConferenciaEnturmacao') ?>">Desenturmacao por Escola</a></li>
                                                    <li><a href="<?php echo base_url('lancamento/lancamentoGeral') ?>">Lancamento: Geral</a></li>
                                                    <li><a href="<?php echo base_url('lancamento/lancamentoMunicipio') ?>">Lancamento: Município</a></li>
                                                    <li><a href="<?php echo base_url('lancamento/lancamentoescola') ?>">Lancamento: Escola</a></li>
                                                    <li><a href="<?php echo base_url('lancamento/lancamentoturma') ?>">Lancamento: Turma</a></li>                                                                                            
                                               </ul>
                                            </li>
                                            
                                            <li class="has-submenu">
                                                <a href="#" >Int. Pedagógica</a>
                                                <ul class="submenu"> 
                                                	<li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/epv') ?>">EPV</a></li>
                                                	<li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/estado') ?>">Estado</a></li>
                                                	<li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/municipio') ?>">Município</a></li>
                                                	<li ><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/escola') ?>">Escola</a></li>                                                    
                                                    <li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/sinteseturma') ?>">Síntese Turma</a></li>
                                                    <li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/turma') ?>">Turma</a></li>
                                                    <li><a href="<?php echo base_url('inteligenciapedagogica/inteligenciaPedagogica/aluno') ?>">Aluno</a></li>                                                                                            
                                               </ul>
                                            </li>
                                            <li class="has-submenu">
                                                <a href="#">Imp.Microdados</a>
                                                <ul class="submenu"> 
                                                	<li><a href="<?php echo base_url('microdados/microdados/relatorio') ?>">Relatório do Importador</a></li>
                                                	<li><a href="<?php echo base_url('microdados/microdados/identificar') ?>">Identificar Aluno</a></li>
                                                </ul>
                                            </li>
                                           <?php }?>     	
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="<?php echo base_url('arquivos/manual_versao1.pdf') ?>"
                                       target="_blank" ><i class="mdi mdi-chart-pie"></i>Manual do Sistema</a>
                                </li>
                                <?php if ($this->session->userdata('ci_grupousuario') == 1 ||$this->session->userdata('ci_grupousuario') == 2){?>
                                <li class="has-submenu">
                                    <a href="#"></i>Downloads</a>
                                    		<?php if(strtoupper( trim($_SERVER['HTTP_HOST'])) == 'WWW.SAEVTREINA.EDUCACAO.WS'){
                                    		      $applicativo="TreinaImportaDadosExcel.jar";
                                                }elseif( strtoupper( trim($_SERVER['HTTP_HOST'])) == 'WWW.EDUCARPRAVALER.ORG'){
                                                    $applicativo="ImportaDadosExcel.jar";
                                                }else{ $applicativo="ImportaDadosExcel.jar";}?>                                                                        
                                        <ul class="submenu">
                                            <li><a href="http://www.java.com/pt_BR/download/"
                                                target="_blank"><i class="mdi mdi-chart-pie"></i>Baixe o Java</a>                                                
                                             <li><a href="<?php echo base_url('arquivos/'.$applicativo) ?>"
                                                  ><i class="mdi mdi-chart-pie"></i>Programa Importar Arquivo</a>
                                             </li>
                                             <li><a href="<?php echo base_url('arquivos/manual_importarquivo.pdf') ?>"
                                                            target="_blank" ><i class="mdi mdi-chart-pie"></i>Manual do Importa Arquivo</a>
                                            </li>
                                        </ul>    
                                </li>    
                                <?php }?>
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
<br>
