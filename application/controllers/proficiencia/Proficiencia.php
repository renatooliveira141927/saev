<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proficiencia extends CI_Controller
{
    protected $titulo = 'Cadastro de Proficiência';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');  
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('escolas_model', 'modelescola');      
        $this->load->model('professores_model', 'modelprofessor');
        $this->load->model('turmas_model','modelturma');
        $this->load->model('proficiencia_model','proficienciamodel');
        $this->load->model('descricaofaixa_model','modeldescricaofaixa');
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
    
    public function carregatemplate(){
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('template/html-footer');
    }
    
    public function filtros($parametro=null){
        $this->verifica_sessao();
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['descricaofaixa'] = $this->modeldescricaofaixa->buscar();
        return $dados;
    }
    
    public function index($offset=null){
        $this->verifica_sessao();
    }
    
    public function listar(){
        $this->carregatemplate();
        $dados=$this->filtros();
        
        if($_POST){
            $params['cd_descricaofaixa']=!empty($this->input->post('cd_descricaofaixa'))?$this->input->post('cd_descricaofaixa'):NULL;
            $params['cd_etapa']=!empty($this->input->post('cd_etapa'))?$this->input->post('cd_etapa'):NULL;
            $dados['proficiencias']=$this->proficienciamodel->busca($params);            
            $dados['totalregistros']=count($dados['proficiencias']);
            $total=0;
        }
        
        $this->load->view('proficiencia/listagem', $dados);
    }
    
    public function novo($msg=null){
            $this->carregatemplate();
            $dados=$this->filtros();
            $dados['msg'] = $msg;
            if ($msg != null) {
                $dados['msg'] = $msg;
            }
            $this->load->view('proficiencia/cadastrar', $dados);
    }
    
    public function editar($id,$msg=null){
        $this->carregatemplate();
        $params['id']=$id;
        $find['consulta']=$this->proficienciamodel->busca($params);
        $dados=$this->filtros($parametro);
        $dados['meta']=$find['consulta'][0]->ci_faixa_proficiencia;
        $dados['cd_etapa']=$find['consulta'][0]->cd_etapa;
        $dados['cd_descricaofaixa']=$find['consulta'][0]->cd_descricaofaixa;
        $dados['nr_inicio']=$find['consulta'][0]->nr_inicio;
        $dados['nr_fim']=$find['consulta'][0]->nr_fim;
        
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $this->load->view('proficiencia/editar', $dados);
    }
    
    
    public function gravar($id=null){
        
        $params['cd_descricaofaixa']=$this->input->post('cd_descricaofaixa');
        $params['cd_etapa']=$this->input->post('cd_etapa');
        $params['nr_inicio']=$this->input->post('nr_inicio');
        $params['nr_fim']=$this->input->post('nr_fim');
        $params['fl_ativo']        = true;

        //print_R($params);die;
        
        if($id!=null){
            $params['ci_faixa_proficiencia']=$id;
            $params['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            if ($this->proficienciamodel->alterar( $params)){
                //print_r($this->db->last_query());die;
                $this->editar($id,"success");
            }else{
                $this->editar($id,"registro_ja_existente");
            }
        }else{
            $params['cd_usuario_cad']  = $this->session->userdata('ci_usuario');
            if ($this->proficienciamodel->salvar( $params)){
                $this->novo("success");
            }else{
                $this->novo("registro_ja_existente");
            }
        }
        
    }
    
}