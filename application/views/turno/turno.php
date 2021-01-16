<script src="<?=base_url('assets/js/turnos.js'); ?>"></script>
    <div style="position:absolute; top:280px; left:40%; z-index:1; display:none;" id="carregando">
        <img src="<?php echo base_url('assets/images/load.gif');?>" width="250" height="180">
    </div>
    <div class="container">
        <div class="page-title-box">
            <div class="col-md-10" style="text-align: left">
                <p>
                    <h4 class="page-title"><?php echo $titulo ?></h4>
                </p>
            </div>
            <div class="col-md-2" style="text-align: right">
                <p>
                    <a type="button" class="btn btn-custom waves-effect waves-light btn-micro active    "
                       href="<?php echo base_url('turno/turnos/novo'); ?>">Cadastrar</a>
                </p>
            </div>
        </div>
    </div>

    <form action="javascript:btn_consulta.click();" method="post">
    <div class="container">
        <div class="card-box">
                <div >
                    <div class="col-lg-12">
                        
                        <section class="main row">
                            <div class="form-group col-lg-12">
                                <label for="nm_turno">Nome da turno</label>
                                <input type="text"
                                        name="nm_turno"
                                        id="nm_turno"
                                        tabindex="2"
                                        placeholder="Nome da turno"
                                        class="form-control"
                                        value="<?php echo set_value('nm_turno');?>">

                            </div>
                        </section>
                    </div>

                    <input type="hidden"
                           id="url_base"
                           value="<?php echo base_url('turno/turnos/')?>">

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