<?php 
if (validation_errors()){
    //echo "Comparação=".(trim(validation_errors()) == trim("O campo nome da aluno é obrigatório."));
    $erro_qtdobrigatorio = "Alguns campos obrigatórios não foram preenchidos!";

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
                    <th>Inep</th>         
                    <th>Nome</th>
                    <th>Escola</th>                                 
                    <th>Etapa</th>
                    <th>Turma</th>
                    <th>Turno</th>
                    <th>Ano</th>
                    
                    <th style="width:50px;text-align:center;">Ações</th>
                </tr>
                </thead>
                <tbody>
                <!-- Inicio lista de alunos encontradas na consulta -->
                <?php
                    
                    foreach ($registros as $result) {
                        $id = $result->ci_aluno;

                        $titulo_modal = $result->nr_inep.' - '.$result->nm_aluno;
                        
                        $fl_ativo = $result->fl_ativo=='t'?'Ativo':'Excluído';

                        $nm_usuario_cad = $result->nm_usuario_cad;
                        $dt_cadastro    = ($result->dt_cadastro!=''?date('d/m/Y H:i:s',  strtotime($result->dt_cadastro)):'');
                        $nm_usuario_alt = $result->nm_usuario_alt;
                        $dt_alteracao   = ($result->dt_alteracao!=''?date('d/m/Y H:i:s',  strtotime($result->dt_alteracao)):'');
                        $nm_usuario_del = $result->nm_usuario_del;
                        $dt_exclusao   = ($result->dt_exclusao!=''?date('d/m/Y H:i:s',  strtotime($result->dt_exclusao)):'');
                        $nm_usuario_rea = $result->nm_usuario_rea;
                        $dt_reativacao  = ($result->dt_reativacao!=''?date('d/m/Y H:i:s',  strtotime($result->dt_reativacao)):'');
                       
                        ?>
                        <tr>
    
                            <td><?php echo $result->nr_inep; ?></td>
                            <td><?php echo $result->nm_aluno; ?></td>                            
                            <td><?php echo $result->escola;?></td>
                            <td><?php echo $result->nm_etapa; ?></td>
                            <td><?php echo $result->nm_turma; ?></td>
                            <td><?php echo $result->nm_turno; ?></td>
                            <td><?php echo $result->nr_ano_letivo; ?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td  style="width:30px;padding:0px 2px;">

                                            <div id="panel-modal-<?php echo $id;?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content p-0 b-0">
                                                        <div class="modal-header ">
                                                            <div class="panel-heading bg-dark">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h3 class="panel-title text-white">X</h3></button>
                                                                <h3 class="panel-title text-white"><?php echo $titulo_modal;?></h3>
                                                            </div>
                                                            <div class="panel-body">
                                                                <p>
                                                            
                                                                    <table  class="table table-striped" >

                                                                        <tr>
                                                                            <td style="width:20px;"><b>Situação</b></td>
                                                                            <td><?php echo $fl_ativo;?></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>                                                                            
                                                                            <td style="width:20px;"><b>Cadastro</b></td>
                                                                            <td><?php echo $nm_usuario_cad;?></td>
                                                                            <td><?php echo $dt_cadastro;?></td>
                                                                        </tr>
                                                                        <tr>                                                                            
                                                                            <td style="width:20px;"><b>Alteração</b></td>
                                                                            <td><?php echo $nm_usuario_alt;?></td>
                                                                            <td><?php echo $dt_alteracao;?></td>
                                                                        </tr>
                                                                        <tr>                                                                            
                                                                            <td style="width:20px;"><b>Exclusão</b></td>
                                                                            <td><?php echo $nm_usuario_del;?></td>
                                                                            <td><?php echo $dt_exclusao;?></td>
                                                                        </tr>
                                                                        <tr>                                                                            
                                                                            <td style="width:20px;"><b>Reativação</b></td>
                                                                            <td><?php echo $nm_usuario_rea;?></td>
                                                                            <td><?php echo $dt_reativacao;?></td>
                                                                        </tr>
                                                                    </table>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                            <a  type="button"
                                                title="Detalhes"
                                                class="btn btn-primary waves-effect waves-light btn-micro active glyphicon glyphicon-exclamation-sign"
                                                data-toggle="modal" data-target="#panel-modal-<?php echo $id;?>">
                                                
                                            </a>
                                        </td>
                                        <td  style="width:30px;padding:0px 2px;" >
                                        	<?php if($anoatual==$result->nr_ano_letivo){ ?>
                                                <?php if( ($this->session->userdata('ci_grupousuario') == 3)
                                                            && $result->ci_escola==$this->session->userdata('ci_escola')){ ?>
                                                    <a  type="button"
                                                        title="Editar"
                                                        href="<?php echo base_url('aluno/alunos/editar/'.$id.'/'.$result->nr_ano_letivo); ?>"
                                                        style="width: 50px;height: 33px"
                                                        class="btn btn-custom waves-effect waves-light btn-micro active glyphicon glyphicon-edit"></a>
                                                <?php } ?>        
                                            <?php } ?>    
                                        </td>
                                        
                                        <td  style="width:30px;padding:0px 2px;">
                                            <?php if ($fl_ativo == 'Ativo' && $anoatual==$result->nr_ano_letivo ){?>
                                                <?php if( ($this->session->userdata('ci_grupousuario') == 3)
                                                            && $result->ci_escola==$this->session->userdata('ci_escola')){ ?>                                                        
                                                <a  type="button"
                                                    title="Excluir"
                                                    class="btn btn-danger waves-effect waves-light btn-micro active glyphicon glyphicon-remove"
                                                    onclick="javascript:excluir('<?php echo $id;?>');">                                                    
                                                </a>
                                                <?php }?>
                                            <?php } else if($fl_ativo != 'Ativo' && $anoatual==$result->nr_ano_letivo){?>
                                                    <?php if( ($this->session->userdata('ci_grupousuario') == 3)
                                                            && $result->ci_escola==$this->session->userdata('ci_escola')){ ?>
                                                        <a  type="button"
                                                            title="Reativar"
                                                            class="btn btn-warning waves-effect waves-light btn-micro active glyphicon glyphicon-ok"
                                                            onclick="javascript:reativar('<?php echo $id;?>');">
                                                    <?php }?>
                                            <?php }?>
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
                            {
                                extend: 'copy',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4 ]
                                }
                            },
                            {
                                extend: 'csv',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4 ]
                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4 ]
                                }
                            },
                            {
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4 ]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3, 4 ]
                                }
                            }
                            
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

