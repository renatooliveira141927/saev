<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 31/07/2020
 * Time: 12:00
 */

class Lancamento extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Lancamentoavaliacao_model', 'modellancamentoavaliacao');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('util_model','modelutil');
        $this->load->model('edicao_model', 'modeledicao');
        $this->load->model('escolas_model','modelescolas');
        $this->load->model('etapas_model','modeletapas');
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
        
        //print_r($parametro);die;
        $cd_estado=isset($parametro['cd_estado'])?$parametro['cd_estado']:$this->input->post('cd_estado');
        $cd_cidade=isset($parametro['cd_municipio'])?$parametro['cd_municipio']:$this->input->post('cd_cidade');
        $cd_edicao=isset($parametro['cd_edicao'])?$parametro['cd_edicao']:$this->input->post('cd_edicao');
        $cd_escola=isset($parametro['cd_escola'])?$parametro['cd_escola']:$this->input->post('cd_escola');
        $cd_etapa=isset($parametro['cd_etapa'])?$parametro['cd_etapa']:$this->input->post('cd_etapa');
       
        $id_estado =!empty($cd_estado)?$cd_estado:NULL;
        $id_cidade =!empty($cd_cidade)?$cd_cidade:NULL;
         
        $dados['anoatual']= date('Y');
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        $dados['edicoes']= $this->modeledicao->buscar();
        $dados['escolas']= $this->modelescolas->get_EscolaByCidade($cd_cidade);
        $dados['etapas']= $this->modeletapas->buscaOfertaEscola($cd_escola);
        $dados['cd_edicao']=$cd_edicao;
        $dados['cd_etapa']=$cd_etapa;
        $dados['cd_escola']=isset($parametro['cd_escola'])?$parametro['cd_escola']:null;
        return $dados;
    }
    
    public function lancamentogeral(){
        $parametro=[];
        $this->carregatemplate();
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=!empty($this->input->get('edicao'))?$this->input->get('edicao'):0;
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');           
        }
        $total=0;
        $leitura=0;
        $lportuguesa=0;
        $matematica=0;
        
        $dados=$this->filtros($parametro);
        $dados['lancamento']=$this->modellancamentoavaliacao->lancamentoEdicaoGeral($parametro);

        if(!empty($dados['lancamento'])){
            foreach($dados['lancamento'] as $item){
                //print_r($dados['lancamento']);die;
                $total= ($item->enturmacao+$total);
                $leitura=($item->leitura+$leitura);
                $lportuguesa=($item->escritap+$lportuguesa);
                $matematica=($item->escritam+$matematica);                
            }
            
            $dados['totalalunos']=$total;
            $dados['leitura']=round( ( ($leitura*100)/($total)),2);
            $dados['lportuguesa']=round( ( ($lportuguesa*100)/($total)),2);
            $dados['matematica']=round( ( ($matematica*100)/($total)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['leitura']=0;
            $dados['lportuguesa']=0;
            $dados['matematica']=0;
        }
        
        $this->load->view('relatorio/lancamentoavaliacaogeral', $dados);
    }
    
    public function lancamentoMunicipio($estado=null,$cidade=null,$edicao=null){
        //print_r($_POST);die;
        $parametro=[];
        $this->carregatemplate();
        //$dados=$this->filtros();
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=$this->input->get('edicao');
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');
            
        }
        $total=0;
        $leitura=0;
        $lportuguesa=0;
        $matematica=0;
        
        $dados=$this->filtros($parametro);
        $dados['lancamento']=$this->modellancamentoavaliacao->lancamentoEdicaomunicipio($parametro);
        
        if(!empty($dados['lancamento'])){
            foreach($dados['lancamento'] as $item){
                //print_r($dados['lancamento']);die;
                $total= ($item->enturmacao+$total);
                $leitura=($item->leitura+$leitura);
                $lportuguesa=($item->escritap+$lportuguesa);
                $matematica=($item->escritam+$matematica);
            }
            
            $dados['totalalunos']=$total;
            $dados['leitura']=round( ( ($leitura*100)/($total)),2);
            $dados['lportuguesa']=round( ( ($lportuguesa*100)/($total)),2);
            $dados['matematica']=round( ( ($matematica*100)/($total)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['leitura']=0;
            $dados['lportuguesa']=0;
            $dados['matematica']=0;
        }
        
        $this->load->view('relatorio/lancamentoavaliacaomunicipio', $dados);
    }
    
    
    public function lancamentoescola(){
        //print_r($_POST);die;
        $parametro=[];
        $this->carregatemplate();
        //$dados=$this->filtros();        
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=!empty($this->input->get('edicao'))?$this->input->get('edicao'):0;
            $parametro['cd_escola']=$this->input->get('escola');
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');
            $parametro['cd_escola']=$this->input->post('cd_escola');
        }
        
        $total=0;
        $leitura=0;
        $lportuguesa=0;
        $matematica=0;
        
        $dados=$this->filtros($parametro);
        if(isset($parametro['cd_edicao']) && !empty($parametro['cd_edicao'])){
            $dados['lancamento']=$this->modellancamentoavaliacao->lancamentoEdicaoEscola($parametro);
        }
        
        if(!empty($dados['lancamento'])){
            foreach($dados['lancamento'] as $item){
                //print_r($dados['lancamento']);die;
                $total= ($item->enturmacao+$total);
                $leitura=($item->leitura+$leitura);
                $lportuguesa=($item->escritap+$lportuguesa);
                $matematica=($item->escritam+$matematica);
            }
            
            $dados['totalalunos']=$total;
            $dados['leitura']=round( ( ($leitura*100)/($total)),2);
            $dados['lportuguesa']=round( ( ($lportuguesa*100)/($total)),2);
            $dados['matematica']=round( ( ($matematica*100)/($total)),2);
            $dados['ciestado']=$parametro['cd_estado'];
            $dados['cicidade']=$parametro['cd_municipio'];
        }else{
            $dados['totalalunos']=0;
            $dados['leitura']=0;
            $dados['lportuguesa']=0;
            $dados['matematica']=0;
        }
        $this->load->view('relatorio/lancamentoavaliacaoescola', $dados);
    }

    public function lancamentoturma(){                          
        //print_r('aqui');die;
        $parametro=[];
        $this->carregatemplate();
        //$dados=$this->filtros();
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=!empty($this->input->get('edicao'))?$this->input->get('edicao'):0;
            $parametro['cd_escola']=$this->input->get('escola');
            $parametro['cd_etapa']=$this->input->get('etapa');
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');
            $parametro['cd_escola']=$this->input->post('cd_escola');
            $parametro['cd_etapa']=$this->input->post('cd_etapa');
        }
        
        $total=0;
        $leitura=0;
        $lportuguesa=0;
        $matematica=0;
        
        $dados=$this->filtros($parametro);
        if(isset($parametro['cd_edicao']) && !empty($parametro['cd_edicao'])){
            $dados['lancamento']=$this->modellancamentoavaliacao->lancamentoEdicaoEscolaTurma($parametro);
            $total= count($dados['lancamento']);
        }
        
        if(!empty($dados['lancamento'])){
            foreach($dados['lancamento'] as $item){
                $leitura=($item->leitura+$leitura);
                $lportuguesa=($item->escritap+$lportuguesa);
                $matematica=($item->escritam+$matematica);
            }
            
            $dados['totalalunos']=$total;
            $dados['leitura']=$leitura;
            $dados['lportuguesa']=$lportuguesa;
            $dados['matematica']=$matematica;            
        }else{
            $dados['totalalunos']=0;
            $dados['leitura']=0;
            $dados['lportuguesa']=0;
            $dados['matematica']=0;
        }
        $this->load->view('relatorio/lancamentoavaliacaoturma', $dados);
    }    
}