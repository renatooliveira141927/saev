<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?=base_url('assets/consulta_escola/css/menu_flutuante_consulta_escola.css'); ?>">
<script src="<?=base_url('assets/consulta_escola/js/menu_flutuante_consulta_escola.js'); ?>"></script>
<script src="<?=base_url('assets/consulta_escola/js/consulta_escola.js'); ?>"></script>

<!-- Inicio - Componente de consulta de escola -->

    <section class="main row">
        <div class="col-md-2">

            <div class="form-group">
                <label  for="txt-inep">Inep Escola</label>
                <input type="hidden" name="txt-ci_escola" id="txt-ci_escola">
                <input type="text" name="txt-nr_inep" id="txt-nr_inep" placeholder="Código do Inep" class="form-control">
            </div>
        </div>
        <div class="col-md-10">

            <div class="form-group">
                <label for="txt-nm_escola">Nome Escola</label>
                <div class="input-group">
                    <input type="text" name="txt-nm_escola" id="txt-nm_escola" placeholder="Nome da escola" class="form-control">
                    <div class="input-group-btn">
                        <button class="form-control btn btn-outline-secondary btn-custom waves-effect waves-light btn-micro active"
                                id="btn-consulta_escola" href="#janela_menu_consulta_escola">
                            Consulta escola
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Inicio - Menu flutuante com lista de escolas resultado da consulta -->

    <div class="window" id="janela_menu_consulta_escola">
        <div id="div-pop_listaescola" class="form-group ">

            <div class="container">
                <section class="main row">
                    <div class="col-md-9">
                        <h5>Sua consulta retornou mais de uma escola, por favor escolha uma!</h5>
                    </div>
                    <div class="col-md-3" align="right" style="padding:8px">
                        <button id="btn-fechar_menu_escola"
                                type="button"
                                class="btn btn-custom btn-xs waves-effect waves-light active"
                                onclick="fechar_menu_select_escola();">
                            X
                        </button>

                    </div>
                </section>

            </div>

            <div class="container">
                <section class="main row">
                    <div class="col-md-12">
                        <!--Div contendo lista de escolas-->
                        <div class="list-group" id="sel-cd_escola_list">
                        </div>
                    </div>
                </section>
                <section class="main row">
                    <div class="col-md-12">
                        <!--Div paginacao lista de escolas-->
                        <div class="list-group" id="paginacao_escola_list">

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- mascara para cobrir o site -->
    <div id="mascara"></div>

    <!-- Fim - Menu flutuante com lista de escolas resultado da consulta -->
<!-- Fim - Componente de consulta de escola -->
