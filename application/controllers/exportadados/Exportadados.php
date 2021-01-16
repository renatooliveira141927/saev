<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportadados extends CI_Controller
{
    protected $titulo = 'Exportar dados de Avaliações';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');        
        $this->load->model('exportaavaliacao_model', 'modelexporta');
        $this->load->model('estado_model'       , 'modelestado');
        $this->load->model('disciplina_model'   , 'modeldisciplina');
        $this->load->model('edicao_model'       , 'modeledicao');
        $this->load->model('etapas_model'       , 'modeletapa');
        $this->load->model('avaliacao_model'    , 'modelavaliacao');
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
        $this->load->library('export_excel');
    }
    
    public function escrita(){
        
        $this->verifica_sessao();
        
        $dados['titulo']        = $this->titulo;
        if($_POST){
            $tipo=' Escrita';
            $this->load->library('export_excel');
            $dados['estado']        = $this->modelestado->selectEstados();
            $dados['etapas']        = $this->modeletapa->buscar();
            $dados['disciplinas']   = $this->modeldisciplina->buscar();
            $dados['edicoes']       = $this->modeledicao->buscar();
            $dados['anos']          = $this->modelavaliacao->selectAnosAvaliacoes();
            $dados['avaliacoes']          = $this->modelavaliacao->selectAvaliacoesAno($_POST['cd_ano']);
            foreach ($_POST['cd_avaliacao'] as $avaliacao){                
                $escola=$_POST['cd_escola'];
                $dados       = $this->modelexporta->montaConsulta($avaliacao,$escola);
                $database=json_decode(json_encode($dados), True);                
                $this->exportadadosavaliacao($dados,$tipo);
            }
            
        }else{
            $dados['estado']        = $this->modelestado->selectEstados();
            $dados['etapas']        = $this->modeletapa->buscar();
            $dados['disciplinas']   = $this->modeldisciplina->buscar();
            $dados['edicoes']       = $this->modeledicao->buscar();
            $dados['anos']          = $this->modelavaliacao->selectAnosAvaliacoes();
            $this->load->view('template/html-header');
            $this->load->view('template/template');
            $this->load->view('template/mensagens');
            $this->load->view('exportadados/exportar', $dados);
            $this->load->view('template/html-footer');
        }

        
    }
    
    public function leitura(){
        
        $this->verifica_sessao();
        
        if($_POST){
            $tipo=' Leitura';
            $dados['estado']        = $this->modelestado->selectEstados();
            $dados['etapas']        = $this->modeletapa->buscar();
            $dados['disciplinas']   = $this->modeldisciplina->buscar();
            $dados['edicoes']       = $this->modeledicao->buscar();
            $dados['titulo']        = $this->titulo;
            $dados['anos']          = $this->modelavaliacao->selectAnosAvaliacoes();
            $dados['avaliacoes']    = $this->modelavaliacao->selectAvaliacoesLeituraAno($_POST['cd_ano']);
                $avaliacao=$_POST['cd_avaliacao']; 
                $escola=$_POST['cd_escola'];
                $dados       = $this->modelexporta->montaConsultaLeitura($avaliacao,$escola);
                $this->exportadadosavaliacao($dados,$tipo);
                
        }else{
            $dados['estado']        = $this->modelestado->selectEstados();
            $dados['etapas']        = $this->modeletapa->buscar();
            $dados['disciplinas']   = $this->modeldisciplina->buscar();
            $dados['edicoes']       = $this->modeledicao->buscar();
            $dados['titulo']        = $this->titulo;
            $dados['anos']          = $this->modelavaliacao->selectAnosAvaliacoes();          
            
            $this->load->view('template/html-header');
            $this->load->view('template/template');
            $this->load->view('template/mensagens');
            $this->load->view('exportadados/exportarleitura', $dados);
            $this->load->view('template/html-footer');
        }

        
    }
    
    public function exportadadosavaliacao(){
        
        $this->load->library('export_excel');
        $database=json_decode(json_encode($dados ), True);
        $this->export_excel->avaliacao_excel($database, 'membrosdogremio');
    }
    
}