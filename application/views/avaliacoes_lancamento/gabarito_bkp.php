<script src="<?=base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
<script src="<?=base_url('assets/js/lancar_gabarito/lancar_gabarito.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_cidade.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_turma.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_disciplina.js'); ?>"></script>
<script src="<?=base_url('assets/js/popula_avaliacao.js'); ?>"></script>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo 'Gabarito - Aluno' ?></h4>
                </p>
            </div>
         </div>
        <form action="javascript:btn_consulta.click();" method="post" class="theForm">
            <div class="container-fluid col-md-10 card-box">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                        <label>Estado</label>
                        <select id="cd_estado"
                                name="cd_estado"
                                tabindex="3"
                                class="form-control"
                                onchange="populacidade(this.value)">

                            <?php echo $estado ?>

                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Município</label>
                        <select id="cd_cidade"
                                name="cd_cidade"
                                tabindex="4"
                                class="form-control" disabled>
                            <option value="">Selecione o Município</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nr_inep_escola">Inep da escola</label>
                        <input type="text"
                               name="nr_inep_escola"
                               id="nr_inep_escola"
                               tabindex="5"
                               placeholder="INEP"
                               class="form-control"
                               value="<?php echo set_value('nr_inep_escola'); ?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="nm_escola">Nome da escola</label>
                        <input type="text"
                               name="nm_escola"
                               id="nm_escola"
                               tabindex="6"
                               placeholder="Nome"
                               class="form-control"
                               value="<?php echo set_value('nm_escola');?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_etapa">Etapa </label>
                        <select id="cd_etapa" name="cd_etapa" tabindex="7" class="form-control"
                                onchange="populaturma(this.value)">
                            <Option value=""></Option>
                            <?php
                            foreach ($etapas as $item) {
                                ?>

                                <Option value="<?php echo $item->ci_etapa; ?>"
                                    <?php if (set_value('cd_etapa') == $item->ci_etapa){
                                        echo 'selected';
                                    } ?> >
                                    <?php echo $item->nm_etapa; ?>
                                </Option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_turma">Turma </label>
                        <select id="cd_turma" name="cd_turma" tabindex="8" class="form-control" disabled
                                onchange="populadisciplina()">
                            <option value="">Selecione uma Turma</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_disciplina">Disciplina </label>
                        <select id="cd_disciplina" name="cd_disciplina" tabindex="9" class="form-control" disabled
                                onchange="populaavalicao()">
                            <option value="">Selecione uma Disciplina</option>
                        </select>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cd_avaliacao">Avaliação </label>
                        <select id="cd_avaliacao" name="cd_avaliacao" tabindex="10" class="form-control" disabled>
                                <option value="">Selecione uma Avalia&ccedil;&atilde;o</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="hidden"
                               id="url_base"
                               value="<?php echo base_url('avaliacao/lancar_gabarito/buscaEnturmacao')?>">
                        <input type="hidden"
                               id="url_questoes"
                               value="<?php echo base_url('avaliacao/avaliacoes/buscaQuestoes')?>">
                        <button type="button" id="btn_consulta"
                                tabindex="9"
                                class="btn btn-custom waves-effect waves-light btn-micro active">
                            Gerar
                        </button>
                    </div>
                </div>

            </div>

            <!-- Inicio Div Gabarito -->
            <div class="container-fluid col-md-12 " id="gabarito" hidden>
                <div class="row" id="dadosgabaritoAdd" name="dadosgabaritoAdd">

            <div class="container-fluid col-md-10 card-box">
                    <form id="formInsertEdit_4" method="post" class="form theForm">
                        <div class="row text-uppercase " style="background-color:grey">
                            <input type="hidden" id="cd_aluno" name="cd_aluno" value="4"><br>
                            <div class="col-md-6 form-group"><label style="color: white">
                                    Bruna Caroline de Sousa Matos</label></div>
                            <div class="col-md-3 form-group">
                                    <select id="cd_participou_4" name="cd_participou+4" tabindex="10" class="form-control" onchange="changeSituacao(this,4)">
                                        <option value="">Selecione uma Alternativa</option>
                                        <option value="1">1 - REALIZOU A ATIVIDADE</option>
                                        <option value="2">2 - RECUSOU-SE A PARTICIPAR</option>
                                        <option value="3">3 - FALTOU MAS ESTA FREQUENTANDO A ESCOLA</option>
                                        <option value="4">4 - ABANDONOU A ESCOLA</option><option value="5">5 - FOI TRANSFERIDO PARA OUTRA ESCOLA</option>
                                        <option value="6">6 - NAO PARTICIPOU - OUTRAS SITUACOES</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group" id="divGabarito_4">
                            </div>
                        </div><br />
                        <br><div class="col-md-10"><div class="form-group">
                                <button type="submit" id="btn_cadastrar" class="btn btn-custom waves-effect waves-light btn-micro active botao">Salvar</button>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="container-fluid col-md-10 card-box">
                <form id="formInsertEdit_3" method="post" class="form theForm">
                    <div class="row text-uppercase" style="background-color:grey">
                        <input type="hidden" id="cd_aluno" name="cd_aluno" value="3"><br>
                        <div class="col-md-6 form-group"><label style="color: white">
                                        Luis Gustavo do Nascimento</label></div>
                        <div class="col-md-3 form-group">
                            <select id="cd_participou_3" name="cd_participou+3" tabindex="10" class="form-control" onchange="changeSituacao(this,3)">
                                <option value="">Selecione uma Alternativa</option>
                                <option value="1">1 - REALIZOU A ATIVIDADE</option>
                                <option value="2">2 - RECUSOU-SE A PARTICIPAR</option>
                                <option value="3">3 - FALTOU MAS ESTA FREQUENTANDO A ESCOLA</option>
                                <option value="4">4 - ABANDONOU A ESCOLA</option><option value="5">5 - FOI TRANSFERIDO PARA OUTRA ESCOLA</option>
                                <option value="6">6 - NAO PARTICIPOU - OUTRAS SITUACOES</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group" id="divGabarito_3">
                        </div>
                    </div><br />
                    <br><div class="col-md-10"><div class="form-group">
                            <button type="submit" id="btn_cadastrar" class="btn btn-custom waves-effect waves-light btn-micro active botao">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </form>
    </div>

</div>
</div>
<!-- Fim Div Consulta -->