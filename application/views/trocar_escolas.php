
    <div class="row" align="center">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Verificamos que você possui mais de uma forma de acesso, por favor escolha uma!</h4>
            </div>
        </div>
    </div>

<!-- end page title end breadcrumb -->

<div class="card-box">



    <?php if (count($grupo_usuarios) > 0) { ?>
    <h5>Foram encontrados <?php echo count($grupo_usuarios) ?> escolas!</h5>

    <div class="table-responsive">
        <table class="table table-hover m-0">
            <thead>
            <tr>

                    <th style="width: 5%"></th>
                <th style="width: 23%">INEP</th>
                <th style="width: 20%">UF</th>
                <th style="width: 20%">MUNICÍPIO</th>
                <th style="width: 23%">ESCOLA</th>
                <th style="width: 23%">GRUPO</th>

                    <th style="width: 5%"></th>

            </tr>
            </thead>
            <?php
                $i = 0;
                foreach ($grupo_usuarios as $result) {
                    $class = "";
                    $class2 = "#FFFFFF";
                    if ($i % 2 == 0) {
                        $class2 = "#FFFFFF";
                    } else {
                        $class2 = "#eaeaea";
                    }
                    $i = $i + 1;
                ?>
                <tr style="border: #eaeaea; border-color: #a3afb7; background-color: <?= $class2; ?>">
                        <td>
                            <form action="<?php echo base_url('usuario/autenticacoes/escolher_acesso/'); ?>"
                                  method="post">
                                <input type="hidden" id="txt-campo01" name="txt-campo01" value="<?php echo $this->encrypt->encode($result->ci_escola, 'Chave de criptografia sistema01')?>">
                                <input type="hidden" id="txt-campo02" name="txt-campo02" value="<?php echo $this->encrypt->encode($result->ci_grupousuario, 'Chave de criptografia sistema01')?>">
                                <input type="hidden" id="txt-campo03" name="txt-campo03" value="<?php echo $this->encrypt->encode($result->nm_escola, 'Chave de criptografia sistema01')?>">
                                <input type="hidden" id="txt-campo04" name="txt-campo04" value="<?php echo $this->encrypt->encode($result->nm_grupo, 'Chave de criptografia sistema01')?>">

                                <button type="submit"
                                        style="width: 80px;height: 33px"
                                        class="btn btn-custom waves-effect waves-light btn-micro active">Acessar</button>
                            </form>

                        </td>
                    <td><?php echo $result->nr_inep; ?></td>
                    <td><?php echo $result->nm_uf; ?></td>
                    <td><?php echo $result->nm_cidade; ?></td>
                    <td><?php echo $result->nm_escola; ?></td>
                    <td><?php echo $result->nm_grupo; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } else { ?>
    <h5>Nenhum resultado encontrado para sua consulta!</h5>
<?php } ?>


</div>
<!-- end row -->