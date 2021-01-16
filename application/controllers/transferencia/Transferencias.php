<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferencias extends CI_Controller
{
    protected $titulo = 'transferência';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('transferencias_model', 'modeltransferencia');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('cidade_model', 'modelcidade');
        $this->load->model('alunos_model', 'modelaluno');
        
    }
    public function verifica_sessao($acao = null){
        if(!$this->session->userdata('logado')){
            if ($acao == 'rotina_ajax'){
                return 'sessaooff';                
            }else{
                redirect(base_url('usuario/autenticacoes/login'));
            }
            
        }

    }
    public function index($offset=null){
        $this->verifica_sessao();

        // $dados['turmas']       = $this->modelturma->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();

        $cd_estado_sme   = '';
        $cd_cidade_sme   = '';

        if ($this->session->userdata('ci_grupousuario') == 2){
            $cd_estado_sme   = $this->session->userdata('cd_estado_sme');
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $cd_cidade=$this->session->userdata('cd_cidade_sme');       
            $dados['escolas']   = $this->modelescola->buscar(
                                    $ci_escola      = null,
                                    $nr_inep        = null,
                                    $nm_escola      = null,
                                    $ds_telefone    = null,
                                    $ds_email       = null,
                                    $fl_extencao    = null,
                                    $fl_tpunidade   = null,
                                    $fl_localizacao = null,
                                    $cd_cidade,
                                    $nr_cep         = null,
                                    $ds_rua         = null,
                                    $nr_residencia  = null,
                                    $ds_bairro      = null,
                                    $ds_complemento = null,
                                    $ds_referencia  = null);
            
        }else if ($this->session->userdata('ci_grupousuario') == 3){
            $cd_escola          = $this->session->userdata('ci_escola');
            $dados['cd_escola'] = $cd_escola;
            $dados['turmas']    = $this->modelturma->get_turmas_combo($cd_escola);
        }       
        $dados['titulo']        = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transferencia/transferencia', $dados);
        $this->load->view('template/html-footer');
    }
    
    public function pesquisaaluno($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_aluno      = $this->input->post('ci_aluno');
            $nr_inep       = $this->input->post('nr_inep');
            $nm_aluno      = $this->input->post('nm_aluno');
            $cd_cidade     = $this->input->post('cd_cidade');
            $cd_estado     = $this->input->post('cd_estado');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            $cd_turno     = $this->input->post('cd_turno');
            $cd_escola    = $this->input->post('cd_escola');            
            //echo '<br><br><br>$cd_turno='.$cd_turno;
            //return false;

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelaluno->buscar_aluno_transferencia($ci_aluno,
                                                                                $nr_inep,
                                                                                $nm_aluno,
                                                                                $cd_cidade,
                                                                                $cd_turma,
                                                                                $cd_etapa,
                                                                                $cd_turno,
                                                                                $cd_escola,
                                                                                '', $limit, $offset);
            //$dados['total_registros'] = 10;
            $dados['total_registros'] = $this->modelaluno->count_buscar_aluno_transferencia($ci_aluno,
                                                                                            $nr_inep,
                                                                                            $nm_aluno,
                                                                                            $cd_cidade,
                                                                                            $cd_turma,
                                                                                            $cd_etapa,
                                                                                            $cd_turno,
                                                                                            $cd_escola);
            $config['base_url']    = base_url("transferencia/transferencias/pesquisaaluno");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('transferencia/aluno_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $id                = null;
            $cd_turma          = $this->input->post('cd_turma');
            $cd_aluno          = $this->input->post('cd_aluno');
            $nm_aluno          = $this->input->post('nm_aluno');
            $cd_etapa          = $this->input->post('cd_etapa');
            $cd_turno          = $this->input->post('cd_turno');
            $nr_ano_letivo     = $this->input->post('nr_ano_letivo');
            $cd_escola_origem  = $this->input->post('cd_escola_origem');
            $cd_escola_destino = $this->input->post('cd_escola_destino');
            $fl_autorizado     = $this->input->post('fl_autorizado');
            $fl_tipo           = $this->input->post('fl_tipo');
            $tpconsulta        = $this->input->post('tpconsulta');
            $flstatus        = $this->input->post('flstatus');
            $cd_cidade        = $this->input->post('cd_cidade');
            $cd_escola_consulta= $this->input->post('cd_escola');
            
            $dados['titulo'] = $this->titulo;

            $limit = '10';

            $dados['registros'] = $this->modeltransferencia->buscar($id,
                                                                    $cd_turma,
                                                                    $cd_aluno,
                                                                    $nm_aluno,
                                                                    $cd_etapa,
                                                                    $cd_turno,
                                                                    $nr_ano_letivo,
                                                                    $cd_escola_origem,
                                                                    $cd_escola_destino,
                                                                    $fl_autorizado,
                                                                    $fl_tipo,
                                                                    $tpconsulta,
                                                                    $flstatus,
                                                                    $cd_escola_consulta,
                                                                    $cd_cidade,
                                                                    '', $limit, $offset);
            //print($this->db->last_query());die;
                                                                    
            $dados['total_registros'] = $this->modeltransferencia->count_buscar($id,
                                                                                $cd_turma,
                                                                                $cd_aluno,
                                                                                $nm_aluno,
                                                                                $cd_etapa,
                                                                                $cd_turno,
                                                                                $nr_ano_letivo,
                                                                                $cd_escola_origem,
                                                                                $cd_escola_destino,
                                                                                $fl_autorizado,
                                                                                $fl_tipo,
                                                                                $tpconsulta,
                                                                                $flstatus,
                                                                                $cd_escola_consulta,
                                                                                $cd_cidade);

//echo $this->db->last_query();die; //Exibeo comando SQL
            $config['base_url']    = base_url("transferencia/transferencias/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('transferencia/transferencia_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $cd_turma          = $this->input->post('cd_turma');
        $cd_aluno          = $this->input->post('cd_aluno');
        $cd_etapa          = $this->input->post('cd_etapa');
        $cd_turno          = $this->input->post('cd_turno');
        $nr_ano_letivo     = $this->input->post('nr_ano_letivo');
        $cd_escola_origem  = $this->input->post('cd_escola_origem');
        $cd_escola_destino = $this->input->post('cd_escola_destino');
        $fl_autorizado     = $this->input->post('fl_autorizado');
        $fl_tipo           = $this->input->post('fl_tipo');

        $result = $this->modeltransferencia->get_consulta_excel($cd_turma,
                                                                $cd_aluno,
                                                                $cd_etapa,
                                                                $cd_turno,
                                                                $nr_ano_letivo,
                                                                $cd_escola_origem,
                                                                $cd_escola_destino,
                                                                $fl_autorizado,
                                                                $fl_tipo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $cd_turma          = $this->input->post('cd_turma');
        $cd_aluno          = $this->input->post('cd_aluno');
        $cd_etapa          = $this->input->post('cd_etapa');
        $cd_turno          = $this->input->post('cd_turno');
        $nr_ano_letivo     = $this->input->post('nr_ano_letivo');
        $cd_escola_origem  = $this->input->post('cd_escola_origem');
        $cd_escola_destino = $this->input->post('cd_escola_destino');
        $fl_autorizado     = $this->input->post('fl_autorizado');
        $fl_tipo           = $this->input->post('fl_tipo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modeltransferencia->get_consulta_pdf(  $cd_turma,
                                                                            $cd_aluno,
                                                                            $cd_etapa,
                                                                            $cd_turno,
                                                                            $nr_ano_letivo,
                                                                            $cd_escola_origem,
                                                                            $cd_escola_destino,
                                                                            $fl_autorizado,
                                                                            $fl_tipo, '', '', '');
        $pagina =$this->load->view('transferencia/transferencia_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }    

    public function salvar(){
        $this->verifica_sessao();

        $ci_transferencia  = $this->input->post('ci_transferencia');
        $cd_aluno          = $this->input->post('cd_aluno');
        $txt_solicitacao   = $this->input->post('txt_solicitacao');
        $cd_escola_origem  = $this->input->post('cd_escola_origem');
        $cd_escola_destino = $this->input->post('cd_escola');
        $nr_ano_letivo     = date("Y");
        $fl_autorizado     =FALSE;
        $cd_turma_destino  = $this->input->post('cd_turma');
        
		$this->form_validation->set_rules('cd_aluno', 'Aluno','required');
        $this->form_validation->set_rules('cd_escola_origem', 'Escola de origem','required');
        $this->form_validation->set_rules('cd_escola', 'Escola de destino','required');
        //$this->form_validation->set_rules('nr_ano_letivo', 'Ano letivo','required');
        // $this->form_validation->set_rules('txt_data', 'Data associação do professor na turma','required');

        if ($this->form_validation->run() == FALSE) {
            if (!$ci_transferencia) { 
                $this->nova_transferencia($cd_aluno);
            }else{
                $this->editar($ci_transferencia);
            }
        } else {

            if (!$ci_transferencia) {                
                if ($this->modeltransferencia->inserir( $cd_aluno,
                                                        $nr_ano_letivo,
                                                        $cd_escola_origem,
                                                        $cd_escola_destino,
                                                        $fl_autorizado,
                                                        $txt_solicitacao,
                                                        $cd_turma_destino)){

                    $this->nova_transferencia($cd_aluno, "success");
                }else{
                    $this->nova_transferencia($cd_aluno, "registro_ja_existente");
                }
            }
            else {    
              
                if ($this->modeltransferencia->alterar( $ci_transferencia,
                                                        $cd_aluno,
                                                        $nr_ano_letivo,
                                                        $cd_escola_origem,
                                                        $cd_escola_destino,
                                                        $txt_solicitacao,
                                                        $cd_turma_destino)){

                    $this->editar($ci_transferencia, $cd_estado, $cd_cidade, "success");
                }else{
                    $this->editar($ci_transferencia, $cd_estado, $cd_cidade, "registro_ja_existente");
                }

            }
        }

    }
    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['transferencia'] = $this->modeltransferencia->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        // $dados['professores']   = $this->modelprofessor->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();
        //$dados['escolas']       = $this->modelescola->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transferencia/transferencia_cad',$dados);
        $this->load->view('template/html-footer');
    }
    public function nova_transferencia($ci_aluno = null, $msg = null){
        $this->verifica_sessao();
        
        $dados['ci_aluno']  = $ci_aluno;
        $dados['alunos']    = $this->modelaluno->buscar_aluno_transferencia($ci_aluno);

        // $dados['turmas']       = $this->modelturma->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        // $dados['escolas']       = $this->modelescola->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();

        $cd_estado_sme   = '';
        $cd_cidade_sme   = '';

        if ($this->session->userdata('ci_grupousuario') == 2){
            $cd_estado_sme   = $this->session->userdata('cd_estado_sme');
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }else if ($this->session->userdata('ci_grupousuario') == 3){
            $cd_escola          = $this->session->userdata('ci_escola');
            $dados['cd_escola'] = $cd_escola;
            $dados['turmas']    = $this->modelturma->get_turmas_combo($cd_escola);
        }

        $dados['msg'] = $msg;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transferencia/transferencia_aluno_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function editar($id = null, $cd_aluno = null, $cd_turma = null, $msg = null){
        $this->verifica_sessao();
        $dados['transferencia'] = $this->modeltransferencia->buscar($id,$cd_turma,$cd_aluno);
        //echo $this->db->last_query();die;
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['registros']     = $this->modelturma->buscar($id);
        $dados['escolas']       = $this->modelescola->buscar();
        $dados['estado']        = $this->modelestado->selectEstados(); 
        
        foreach ($dados['registros'] as $dado){
            $cd_estado = $dado->ci_estado;
            $cd_cidade = $dado->ci_cidade;
        
        }
        if ($this->session->userdata('ci_grupousuario') == 1){
            $cd_estado_sme   = '';
            $cd_cidade_sme   = '';
            foreach ($dados['registros'] as $registro){
                $cd_estado_sme   = $registro->ci_estado;
                $cd_cidade_sme   = $registro->ci_cidade;

            }

            if ($cd_estado_sme){                
                $dados['estados_sme']    = $this->modelestado->selectEstados($cd_estado_sme);
                $dados['municipios_sme'] = $this->modelcidade->selectCidade($cd_estado_sme, '', '', '', $cd_cidade_sme);
            }
        }

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transferencia/transferencia_aluno_alt', $dados);
        $this->load->view('template/html-footer');
    }
    
    public function aprovar($id = null, $cd_aluno = null, $cd_turma = null, $msg = null){
        $this->verifica_sessao();

        $dados['transferencia'] = $this->modeltransferencia->buscar($id,$cd_turma,$cd_aluno);
        //echo $this->db->last_query();die;
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['turmas']     = $this->modelturma->buscar($cd_turma);
        $dados['escolas']       = $this->modelescola->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['ci_transferencia'] =  $id;
        $dados['cd_turma']=$cd_turma;        
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transferencia/transferencia_aluno_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modeltransferencia->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

    public function aprovarTransferencia(){
        $this->verifica_sessao();
        
        $params['ci_transferencia']  = $this->input->post('ci_transferencia');
        $params['cd_aluno']          = $this->input->post('cd_aluno');        
        $params['cd_escola_origem']  = $this->input->post('cd_escola_origem');
        $params['cd_escola_destino'] = $this->input->post('cd_escola');        
        $params['fl_autorizado']     =true;
        $params['fl_ativo']          =false; 
        $params['cd_turma_destino']  = $this->input->post('cd_turma');

                if ($this->modeltransferencia->aprovarTransferencia($params)){
                    $this->nova_transferencia($params['cd_aluno'], "success");
                }else{
                    $this->nova_transferencia($params['cd_aluno'], "não foi possível realizar a transferencia");
                }        
    }

}
