<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

    // Função para montar select de cidades baseado no que for selecionado na select estado
    var base_url = "<?php echo base_url() ?>";
    $(function(){
        $('#select-estado').change(function () {

            var id_estado = $('#select-estado').val();

            $('#select-municipio').attr('disabled', 'disabled');
            $('#select-municipio').html("<option>Carregando...</option>");

            $.post(base_url+'index.php/ajax/cidade/getCidades',{
                id_estado : id_estado
            }, function (data) {

                $('#select-municipio').html(data);
                $('#select-municipio').removeAttr('disabled');
            });
        })
    })
</script>
    <div class="card-box">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo 'Administrar '.$subtitulo ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <?php echo 'Alterar '.$subtitulo ?>

                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php 
                                        echo validation_errors('<div class="alert alert-danger">','</div>');
                                        echo form_open('escola/escolas/salvar');

                                        foreach ($escolas as $escola) {

                                    ?>

                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label id="txt-inep">Inep da escola</label>
                                                    <input id="txt-inep" name="txt-inep" type="text" class="form-control" placeholder="Digite o inep da escola" value="<?php echo $escola->nr_inep ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label id="txt-escola">Nome do Escola</label>
                                                    <input id="txt-escola" name="txt-escola" type="text" class="form-control" placeholder="Digite o nome da escola" value="<?php echo $escola->nm_escola ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    <select id="select-estado" name="select-estado" class="form-control">

                                                        <?php foreach ($estados as $estado) { ?>
                                                            <option value="<?php echo $estado->ci_estado?>"
                                                                <?php
                                                                if($estado->ci_estado == $estado_escola) {
                                                                    echo " selected ";
                                                                }
                                                                ?>
                                                            >
                                                                <?php echo $estado->nm_estado?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label>Município</label>
                                                    <select id="select-municipio" name="select-municipio" class="form-control">
                                                        <?php foreach ($municipios as $municipio) { ?>
                                                            <option value="<?php echo $municipio->ci_cidade?>"
                                                                <?php
                                                                    if($municipio->ci_cidade == $cidade_escola) {
                                                                        echo " selected ";
                                                                }
                                                                ?>
                                                            >
                                                                <?php echo $municipio->nm_cidade?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label id="txt-email">Email</label>
                                                    <input id="txt-email" name="txt-email" type="text" class="form-control" placeholder="Digite o email da escola" value="<?php echo $escola->ds_email ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <label id="txt-telefone">Telefone</label>
                                                    <input id="txt-telefone" name="txt-telefone" type="text" class="form-control" placeholder="Digite o telefone da escola" value="<?php echo $escola->ds_telefone ?>">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label id="txt-endereco">Endereço da escola</label>
                                                    <input id="txt-endereco" name="txt-endereco" type="text" class="form-control" placeholder="Digite o endereco da escola" value="<?php echo $escola->ds_endereco ?>">
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                            <input type="hidden" id="txt-id" name="txt-id" value="<?php echo $escola->ci_escola?>">
                                            <button type="submit" class="btn btn-default">Atualizar</button>

                                    <?php

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