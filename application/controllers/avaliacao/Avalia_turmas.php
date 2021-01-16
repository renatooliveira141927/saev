<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_turmas extends CI_Controller
{
    protected $titulo = 'Cadastro de avaliação';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('avaliacao_model'    , 'modelavaliacao');
        $this->load->model('avalia_turmas_model', 'modelavalia_turma');
        $this->load->model('estado_model'       , 'modelestado');
        $this->load->model('disciplina_model'   , 'modeldisciplina');
        $this->load->model('edicao_model'       , 'modeledicao');
        $this->load->model('etapas_model'       , 'modeletapa');
        $this->load->model('avalia_tipo_model'  , 'modelavalia_tipo');
        
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

        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        $dados['titulo']        = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_turma/avalia_turma', $dados);
        $this->load->view('template/html-footer');
    }

    public function montar_avaliacao(){

        $dados['ci_avaliacao'] = $this->input->post('ci_avaliacao');
        $dados['nm_caderno']   = $this->input->post('nm_caderno');
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_montar/avalia_montar_itens', $dados);
        $this->load->view('template/html-footer');
    }
    public function listagem_montar_avaliacao($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ds_codigo              = $this->input->post('ds_codigo');
            $cd_dificuldade         = $this->input->post('cd_dificuldade');
            $cd_disciplina          = $this->input->post('cd_disciplina');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelavaliacao->buscar_itens_montar(   $ds_codigo, 
                                                                                $cd_dificuldade,
                                                                                $cd_disciplina,
                                                                                '', $limit, $offset);

            $dados['total_registros'] = $this->modelavaliacao->count_buscar_itens_montar(   $ds_codigo, 
                                                                                            $cd_dificuldade,
                                                                                            $cd_disciplina);

            $config['base_url']    = base_url("avalia_montar/avalia_montar_itens_lista");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avalia_montar/avalia_montar_itens_lista', $dados);
        }else{
            echo $status_sessao;
        }

    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_avaliacao   = $this->input->post('ci_avaliacao');
            $nm_caderno     = $this->input->post('nm_caderno');  
            $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
            $cd_cidade      = $this->input->post('cd_cidade');
            $nr_ano         = $this->input->post('nr_ano');
            $cd_disciplina  = $this->input->post('cd_disciplina');
            $cd_edicao      = $this->input->post('cd_edicao');
            $cd_etapa		= $this->input->post('cd_etapa');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelavalia_montar->buscar($ci_avaliacao, 
                                                                $nm_caderno, 
                                                                $cd_avalia_tipo,
                                                                $nr_ano, 
                                                                $cd_disciplina, 
                                                                $cd_edicao,
                                                                $cd_etapa, 
                                                                
                                                                '', $limit, $offset);

            $dados['total_registros'] = $this->modelavalia_montar->count_buscar($ci_avaliacao, 
                                                                            $nm_caderno, 
                                                                            $cd_avalia_tipo,
                                                                            $nr_ano, 
                                                                            $cd_disciplina, 
                                                                            $cd_edicao,
                                                                            $cd_etapa);

            $config['base_url']    = base_url("avalia_montar/Avalia_montar/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avalia_montar/avalia_montar_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avaliacao   = $this->input->post('ci_avaliacao');
        $nm_caderno     = $this->input->post('nm_caderno');  
        $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
        $nr_ano         = $this->input->post('nr_ano');
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_edicao      = $this->input->post('cd_edicao');
        $cd_etapa		= $this->input->post('cd_etapa');

        $result = $this->modelavalia_montar->get_consulta_excel($ci_avaliacao, 
                                                            $nm_caderno, 
                                                            $cd_avalia_tipo, 
                                                            $nr_ano, 
                                                            $cd_disciplina, 
                                                            $cd_edicao,
                                                            $cd_etapa);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_avaliacao   = $this->input->post('ci_avaliacao');
        $nm_caderno     = $this->input->post('nm_caderno');  
        $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
        $nr_ano         = $this->input->post('nr_ano');
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_edicao      = $this->input->post('cd_edicao');
        $cd_etapa		= $this->input->post('cd_etapa');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelAvalia_montar->get_consulta_pdf(  $ci_avaliacao, 
                                                                        $nm_caderno, 
                                                                        $cd_avalia_tipo, 
                                                                        $nr_ano, 
                                                                        $cd_disciplina, 
                                                                        $cd_edicao,
                                                                        $cd_etapa, '', '', '');
        $pagina =$this->load->view('Avalia_montar/Avalia_montar_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('Avalia_montar/Avalia_montar_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_avaliacao       = $this->input->post('ci_avaliacao');
        $nm_caderno         = $this->input->post('nm_caderno');  
        $cd_avalia_tipo     = $this->input->post('cd_avalia_tipo');
        $nr_ano             = $this->input->post('nr_ano');
        $cd_disciplina      = $this->input->post('cd_disciplina');
        $cd_edicao          = $this->input->post('cd_edicao');
        $cd_etapa		    = $this->input->post('cd_etapa');
        $ds_texto_abertura	= $this->input->post('ds_texto_abertura');
        $fl_avalia_nominal  = $this->input->post('fl_avalia_nominal');
        $fl_sortear_itens   = $this->input->post('fl_sortear_itens');
        
        $this->form_validation->set_rules('nm_caderno'    , 'caderno'           ,'required');
        $this->form_validation->set_rules('cd_avalia_tipo', 'tipo de avaliacao' ,'required');
        $this->form_validation->set_rules('cd_disciplina' , 'disciplina'        ,'required');
        $this->form_validation->set_rules('cd_edicao'     , 'edicao'            ,'required');
        $this->form_validation->set_rules('cd_etapa'      , 'etapa'             ,'required');

        if ($fl_avalia_nominal == 1){
            $fl_avalia_nominal = true;
        }
        else{
            $fl_avalia_nominal = false;
        }
        if ($fl_sortear_itens == 1){
            $fl_sortear_itens = true;
        }
        else{
            $fl_sortear_itens = false;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$ci_avaliacao) {
                if ($this->modelAvalia_montar->inserir( $nm_caderno, 
                                                    $cd_avalia_tipo, 
                                                    $nr_ano, 
                                                    $cd_disciplina, 
                                                    $cd_edicao,
                                                    $cd_etapa,
                                                    $ds_texto_abertura,
                                                    $fl_avalia_nominal,
                                                    $fl_sortear_itens)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {                
                if ($this->modelAvalia_montar->alterar( $ci_avaliacao,
                                                    $nm_caderno, 
                                                    $cd_avalia_tipo, 
                                                    $nr_ano, 
                                                    $cd_disciplina, 
                                                    $cd_edicao,
                                                    $cd_etapa,
                                                    $ds_texto_abertura,
                                                    $fl_avalia_nominal,
                                                    $fl_sortear_itens)){

                    $this->editar($ci_avaliacao, "success");
                }else{
                    $this->editar($ci_avaliacao,"registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();
        
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelAvalia_montar->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('Avalia_montar/Avalia_montar_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelAvalia_montar->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
}
