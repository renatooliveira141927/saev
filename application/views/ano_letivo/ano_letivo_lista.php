<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome da ano_letivo é obrigatório."));
    $erro_qtdobrigatorio = "O campo nome da ano_letivo é obrigatório.";

    // strpos -> Verifica se uma string está contida em outra e retorna true caso encontre
    $return_qtdobrigatorio = strpos( validation_errors(), $erro_qtdobrigatorio ); 

    if ( $return_qtdobrigatorio !== false){
        echo '<script type="text/javascript">mensagem_sucesso("error" ,"Digite no minimo 3 caracteres");</script>';
    } 
        
}else{
?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/buttons.dataTables.min.css'); ?>">
    
    <script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/dataTables.buttons.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/buttons.flash.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/jszip.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/pdfmake.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/vfs_fonts.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/buttons.html5.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/buttons.print.min.js'); ?>" type="text/javascript"></script>

    
<div class="card-box table-responsive" id="listagem_resultado">
    <div class="table-responsive align-text-middle">
  
        <div class="col-lg-2" align="right">

            <script language="javascript">
                function mudaAction(pagina, target){
    
                    document.forms[0].action=pagina;
                    document.forms[0].target=target;
                    document.forms[0].submit();
                }
            </script>

        </div>
        <div class="col-lg-12">
            <table id="tblistagem" class="display table table-striped table-hover">
            <thead>
                <tr>  
                    <th>UF</th>         
                    <th>Município</th>             
                    <th>Escola</th>
                    <th>Ano</th>
                    
                    <th style="width:50px;text-align:center;">Ações</th>
                </tr>
                </thead>
                <tbody>
                <!-- Inicio lista de anos_letivos encontradas na consulta -->
                <?php
                    
                    foreach ($registros as $result) {
                        ?>
                        <tr>
                            <td><?php echo $result->nm_uf; ?></td>
                            <td><?php echo $result->nm_cidade; ?></td>
                            <td><?php echo $result->nm_escola; ?></td>
                            <td><?php echo $result->nr_ano_letivo; ?></td>
                            
                            <td>
                                <table>
                                    <tr>
                                        <!-- <td style="width:30px;padding:0px 2px;">
                                            <a  type="button"
                                                title="Tornar vigente"
                                                style="width: 50px;height: 33px"
                                                class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-hand-left"
                                                onclick="javascript:set_anovigente('<'?php echo $result->ci_ano_letivo;?>', '<'?php echo $result->nr_ano_letivo;?>');"></a>
                                            
                                        </td> -->
                                        <td  style="width:30px;padding:0px 2px;">
                                            <a  type="button"
                                                title="Editar"
                                                href="<?php echo base_url('ano_letivo/anos_letivos/editar/'.$result->ci_ano_letivo); ?>"
                                                style="width: 50px;height: 33px"
                                                class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-edit"></a>
                                                
                                        </td>
                                        <td  style="width:30px;padding:0px 2px;">
                                            <a  type="button"
                                                title="Excluir"
                                                class="btn btn-danger waves-effect waves-light btn-micro active glyphicon glyphicon-remove"
                                                onclick="javascript:excluir('<?php echo $result->ci_ano_letivo;?>');">
                                                
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                

                            </td>
                        </tr>

                    <?php
                    } 
                ?>
            </tbody>
            </table>
            <script type="text/javascript">
    
                $(document).ready(function() {
                    $('#tblistagem').DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        "language": {
                            "sEmptyTable": "Nenhum registro encontrado",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sInfoThousands": ".",
                            "sLengthMenu": "_MENU_ resultados por página",
                            "sLoadingRecords": "Carregando...",
                            "sProcessing": "Processando...",
                            "sZeroRecords": "Nenhum registro encontrado",
                            "sSearch": "Pesquisar",
                            "oPaginate": {
                                "sNext": "Próximo",
                                "sPrevious": "Anterior",
                                "sFirst": "Primeiro",
                                "sLast": "Último"
                            },
                            "oAria": {
                                "sSortAscending": ": Ordenar colunas de forma ascendente",
                                "sSortDescending": ": Ordenar colunas de forma descendente"
                            }
                        }
                    } );
                } );
            </script>
        </div>
    </div>
</div>
<?php
 }
?>

