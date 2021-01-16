<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deficiencia extends CI_Controller
{
    protected $titulo = 'Cadastro de Tipos Deficiência';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('deficiencias_model', 'modeldeficiencia');
        
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
        $dados['titulo'] = $this->titulo;
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('deficiencia/deficiencia', $dados);
        $this->load->view('template/html-footer');
        
    }
    
    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');
            
            $ci_deficiencia     = $this->input->post('ci_deficiencia');
            $nm_deficiencia     = $this->input->post('nm_deficiencia')?$this->input->post('nm_deficiencia'):null;
            
            $dados['titulo'] = $this->titulo;
            
            $limit = '10';
            $dados['registros'] = $this->modeldeficiencia->buscar('', $nm_deficiencia, '', $limit, $offset);
            
            $dados['total_registros'] = $this->modeldeficiencia->count_buscar('', $nm_deficiencia);
            
            $config['base_url']    = base_url("deficiencia/deficiencia/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();
            
            $this->load->view('deficiencia/deficiencia_lista', $dados);
            //}
        }else{
            echo $status_sessao;
        }
    }
    
    
    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('deficiencia/deficiencia_cad',$dados);
        $this->load->view('template/html-footer');
    }
    
    public function salvar(){
        $this->verifica_sessao();
        
        $id = $this->input->post('ci_deficiencia');
        $nm_deficiencia = $this->input->post('nm_deficiencia');
        
        $this->form_validation->set_rules('nm_deficiencia', 'Nome da Deficiência','min_length[3]|required');
        
        
        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {
            
            if (!$id) {
                if ($this->modeldeficiencia->inserir($nm_deficiencia)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modeldeficiencia->alterar($id, $nm_deficiencia)){
                    $this->editar($id, "success");
                }else{
                    $this->editar($id,"registro_ja_existente");
                }
                
            }
        }
    }
    
    public function editar($id = null, $msg = null){
        $this->verifica_sessao();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $dados['registros']   = $this->modeldeficiencia->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('deficiencia/deficiencia_alt', $dados);
        $this->load->view('template/html-footer');
    }
    
}