<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 31/07/2020
 * Time: 12:00
 */

class Monitoramento extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Monitoramento_model', 'modelmonitoramento');
        $this->load->model('estado_model', 'modelestado');        
        $this->load->model('escolas_model','modelescolas');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('util_model','modelutil');
        $this->load->model('enturmacoes_model', 'modelenturmacao');
        $this->load->model('turmas_model','modelturma');
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
        $cd_estado=isset($parametro['cd_estado'])?$parametro['cd_estado']:$this->input->post('cd_estado');
        $cd_cidade=isset($parametro['cd_municipio'])?$parametro['cd_municipio']:$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado)?$cd_estado:NULL;
        $id_cidade =!empty($cd_cidade)?$cd_cidade:NULL;
        
        $dados['anoatual']= date('Y');
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }elseif($_GET){
            $dados['anoatual']=  $this->input->GET('nr_anoletivo');
        }else{
            $dados['anoatual']= !empty($parametro['nr_anoletivo'])?$parametro['nr_anoletivo']:date('Y');
        }
        
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        return $dados;
    }
    
    public function enturmacao_geral(){
        
        $this->carregatemplate();
        $dados=$this->filtros();
        $params['cd_estado']=!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $params['cd_cidade']=!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
        $params['nr_anoletivo']=!empty($this->input->post('nr_anoletivo'))?$this->input->post('nr_anoletivo'):$dados['anoatual'];
        if($_POST){        
            $dados['enturmacaomunicipio']=$this->modelmonitoramento->enturmacao_geral($params);        
        }
        
        $dados['totalregistros']=count($dados['enturmacaomunicipio']);
        $total=0;
        $enturmados=0;
        $desenturmados=0;
        foreach($dados['enturmacaomunicipio'] as $enturmacao){
            $total= ($enturmacao->total+$total);            
            $enturmados=($enturmacao->enturmacao+$enturmados);
            $desenturmados=($enturmacao->desenturmacao+$desenturmados);
        }
        if(!empty($dados['enturmacaomunicipio'])){
            $dados['totalalunos']=$total;
            $dados['totalenturmados']=$enturmados;
            $dados['totaldesenturmados']=$desenturmados;
            $dados['perctotalenturmados']=round( ( ($enturmados*100)/($enturmados+$desenturmados)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['totalenturmados']=0;
            $dados['totaldesenturmados']=0;
            $dados['perctotalenturmados']=0;
        }
        $this->load->view('relatorio/enturmacao_geral', $dados);
    }
    
    public function enturmacao_municipio(){
        //print_r($_POST);die;
        $this->carregatemplate();
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            
        }else{
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
                    
        }
        
        $dados=$this->filtros($parametro);
        $total=0;
        $enturmados=0;
        $desenturmados=0;
        
        if($_POST || $_GET){
            $dados['enturmacaomunicipio']=$this->modelmonitoramento->enturmacao_municipio($parametro);
        }
        //print_r($dados['enturmacaomunicipio']);die;
        
        $dados['totalregistros']=count($dados['enturmacaomunicipio']);
        foreach($dados['enturmacaomunicipio'] as $enturmacao){                       
            $enturmados=($enturmacao->enturmacao+$enturmados);
            $desenturmados=($enturmacao->desenturmados+$desenturmados);
        }        
        
        if(!empty($dados['enturmacaomunicipio'])){
            $dados['totalalunos']=$enturmados+$desenturmados;
            $dados['totalenturmados']=$enturmados;
            $dados['totaldesenturmados']=$desenturmados;
            $dados['perctotalenturmados']=round((($enturmados*100)/($enturmados+$desenturmados)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['totalenturmados']=0;
            $dados['totaldesenturmados']=0;
            $dados['perctotalenturmados']=0;
        }
        $this->load->view('relatorio/enturmacao_municipio', $dados);        
    }
    
    public function enturmacao_escola(){
        
        $this->carregatemplate();
        
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=!empty($this->input->get('edicao'))?$this->input->get('edicao'):0;
            $parametro['cd_escola']=$this->input->get('escola');
            $parametro['nr_anoletivo']=$this->input->get('nr_anoletivo');
            
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');
            $parametro['cd_escola']=$this->input->post('cd_escola');
            $parametro['nr_anoletivo']=$this->input->post('nr_anoletivo');
            
        }
        
        $dados=$this->filtros($parametro);
        $total=0;
        $enturmados=0;
        $desenturmados=0;
        $dados['cd_escola']=$parametro['cd_escola'];
        //print_r($_POST);die;
        if($_POST || $_GET){
            $dados['enturmacaomunicipio']=$this->modelenturmacao->relatorioEnturmacaoEscola($parametro);
        }
        //echo $this->db->last_query();die;
        $dados['totalregistros']=count($dados['enturmacaomunicipio']);
        foreach($dados['enturmacaomunicipio'] as $enturmacao){
            $enturmados=($enturmacao->enturmacao+$enturmados);
            $desenturmados=($enturmacao->desenturmados+$desenturmados);
        }
        //print_r($this->db->last_query());die;
        if(!empty($dados['enturmacaomunicipio'])){
            $dados['escolas']= $this->modelescolas->get_EscolaByCidade($parametro['cd_municipio']);                       
            $dados['totalalunos']=$enturmados+$desenturmados;
            $dados['totalenturmados']=$enturmados;
            $dados['totaldesenturmados']=$desenturmados;
            $dados['perctotalenturmados']=round((($enturmados*100)/($enturmados+$desenturmados)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['totalenturmados']=0;
            $dados['totaldesenturmados']=0;
            $dados['perctotalenturmados']=0;
        }
        $this->load->view('relatorio/enturmacao_escola', $dados);
    }
    
    public function enturmacao_turma(){
        
        $this->carregatemplate();
        
        if($_GET){
            $parametro['cd_estado']=$this->input->get('estado');
            $parametro['cd_municipio']=$this->input->get('cidade');
            $parametro['cd_edicao']=!empty($this->input->get('edicao'))?$this->input->get('edicao'):0;
            $parametro['cd_escola']=$this->input->get('escola');
            $parametro['nr_anoletivo']=$this->input->get('nr_anoletivo');
            $parametro['cd_turma']=$this->input->get('turma');
            
        }
        
        if($_POST){
            $parametro['cd_estado']=$this->input->post('cd_estado');
            $parametro['cd_municipio']=$this->input->post('cd_cidade');
            $parametro['cd_edicao']=$this->input->post('cd_edicao');
            $parametro['cd_escola']=$this->input->post('cd_escola');
            $parametro['nr_anoletivo']=$this->input->post('nr_anoletivo');
            $parametro['cd_turma']=$this->input->post('cd_turma');
        
        }
        
        $dados=$this->filtros($parametro);
        $total=0;
        $enturmados=0;
        $desenturmados=0;
        $dados['cd_escola']=$parametro['cd_escola'];
        //print_r($_POST);die;
        if($_POST || $_GET){
            $dados['enturmacao']=$this->modelenturmacao->relatorioEnturmacaoTurma($parametro);
        }
        //echo $this->db->last_query();die;
        $dados['totalregistros']=count($dados['enturmacao']);
        $enturmados=$dados['totalregistros'];
        //print_r($this->db->last_query());die;
        $dados['escolas']= $this->modelescolas->get_EscolaByCidade($parametro['cd_municipio']);
        $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$parametro['nr_anoletivo'],$parametro['cd_escola'],null);
        if(!empty($dados['enturmacao'])){
            
            $dados['totalalunos']=$enturmados+$desenturmados;
            $dados['totalenturmados']=$enturmados;
            $dados['totaldesenturmados']=$desenturmados;
            $dados['cd_turma']=$parametro['cd_turma'];
            $dados['perctotalenturmados']=round((($enturmados*100)/($enturmados+$desenturmados)),2);
        }else{
            $dados['totalalunos']=0;
            $dados['totalenturmados']=0;
            $dados['totaldesenturmados']=0;
            $dados['perctotalenturmados']=0;
        }
        $this->load->view('relatorio/enturmacao_turma', $dados);
    }
    
}