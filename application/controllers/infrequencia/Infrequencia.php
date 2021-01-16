<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infrequencia extends CI_Controller
{
	protected $titulo = 'etapas';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('util_model', 'modelutil');
        $this->load->model('infrequencia_model', 'modelinfrequencia');
        $this->load->model('liberacao_model','modelliberacao');
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
    public function carregaTemplate(){
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('template/html-footer');
    }
    
    public function index($offset=null){
        
        $this->verifica_sessao();
        $this->carregaTemplate();
        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        if($this->session->userdata('ci_grupousuario')==2){
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
            
        }else if($this->session->userdata('ci_grupousuario')==1){
            $ci_escola= $this->session->userdata('ci_escola');
            $dados['escolas']       = $this->modelescola->buscar($ci_escola);
        }else{
            $cd_escola = $this->session->userdata('ci_escola');
            $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);
        }
        
        $this->load->view('infrequencia/infrequencia', $dados);
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        $this->carregaTemplate();
        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        
        if($this->session->userdata('ci_grupousuario')==2){           
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
            
        }else if($this->session->userdata('ci_grupousuario')==1){
            $ci_escola= $this->session->userdata('ci_escola');
            $dados['escolas']       = $this->modelescola->buscar($ci_escola);
        }else{                       
            $cd_escola = $this->session->userdata('ci_escola');
            $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);            
        }
         
        if ($this->session->userdata('ci_grupousuario')==2) {                
            $params['cd_cidade_sme']=$this->session->userdata('cd_cidade_sme');
            $params['nr_anoliberacao']=date('Y');
            $params['ci_grupousuario']=$this->session->userdata('ci_grupousuario');            
                if(date('d')>10){                
                    $dados['meses']=$this->modelliberacao->selectMesesLiberados($params);                  
                }else{
                    $dados['meses'] = $this->modelutil->selectMeses();
                }
            
        }if ($this->session->userdata('ci_grupousuario')==3) {            
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $params['nr_anoliberacao']=date('Y');
            $params['ci_grupousuario']=$this->session->userdata('ci_grupousuario');
            if(date('d')>10){
                $dados['meses']=$this->modelliberacao->selectMesesLiberadosEscola($params);
            }else{
                $dados['meses'] = $this->modelutil->selectMeses();
            }
            
        }else{
            $params['ci_grupousuario']=$this->session->userdata('ci_grupousuario');
            $params['nr_anoliberacao']=date('Y');            
            $dados['meses'] =$this->modelliberacao->selectLiberaMeses($params);
        }
        
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $this->load->view('infrequencia/infrequencia_cad', $dados);        
    }
    
    public function listagem_consulta($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {           
            $cd_escola     = $this->input->post('cd_escola');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            
            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $cd_escola     = $this->session->userdata('ci_escola');
            }            
            
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscar( $cd_escola,$cd_turma,$cd_etapa);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = $this->modelinfrequencia->count_buscar($cd_escola,$cd_turma,$cd_etapa);
            $this->load->view('infrequencia/pesquisa_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    public function listagem_infrequencia($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            
            $cd_escola     = $this->input->post('cd_escola');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            $cd_mes       = $this->input->post('cd_mes');
            
            $dados['registros'] = $this->modelinfrequencia->buscarInfrequenciaMes( $cd_escola,$cd_turma,$cd_etapa,$cd_mes);
            //echo $this->db->last_query();die;
            $dados['total_registros'] = sizeof($dados['registros']);
            $this->load->view('infrequencia/infrequencia_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    public function pesquisaliberacao($msg = null){
        $this->verifica_sessao();
        $this->carregaTemplate();
        $params['cd_cidade_sme']=$this->session->userdata('cd_cidade_sme');
        $params['nr_anoliberacao']=date('Y');
        $dados['estado'] = $this->modelestado->selectEstados();        
        $dados['meses'] = $this->modelliberacao->selectLiberaMeses($params);
        
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $this->load->view('infrequencia/liberacao', $dados);
    }
    
    public function listagem_liberacao($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
                  
            $params['cd_mes']     = $this->input->post('cd_mes');
            $params['cd_cidade']     = $this->input->post('cd_cidade');     
           
            
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscarLiberacao($params);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = sizeof($dados['registros'] );
            $this->load->view('infrequencia/pesquisa_liberacao', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    public function cadastraliberacao($msg = null){
        $this->verifica_sessao();
        $this->carregaTemplate();
        
        $params['cd_cidade_sme']=$this->session->userdata('cd_cidade_sme');
        $params['nr_anoliberacao']=date('Y');
        
        $dados['estado'] = $this->modelestado->selectEstados();
        
        $dados['meses'] = $this->modelliberacao->selectLiberaMeses($params);
        
        //echo $this->db->last_query();die;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $this->load->view('infrequencia/liberacao_cad', $dados);
    }
    
    public function salvar(){        
        $this->verifica_sessao();
        
        $var_cd_alunos = $this->input->post('arr_ci_alunos');
        
        $arr_cd_alunos = explode(',',$var_cd_alunos);
        $qtd_reg = 0;
        
        foreach ($arr_cd_alunos as $i => $aluno){

            if ($this->input->post('infrequencia_'.$aluno) !=""){
                $cd_aluno = $aluno;                
                $ci_infrequencia = $this->input->post('infrequencia_'.$aluno);                
                $nr_faltas = $this->input->post('nrfaltas_'.$aluno);                
                    
                   $qtd_reg = $qtd_reg + 1;
                    $obj = new stdClass();
                    $obj->ci_infrequencia=$ci_infrequencia;
                    $obj->cd_aluno = $aluno;
                    $obj->nr_faltas = $nr_faltas;
                    $obj->cd_turma =  $this->input->post('cd_turma');
                    $obj->cd_etapa =  $this->input->post('cd_etapa');
                    $obj->nr_mes = $this->input->post('cd_mes');
                    $obj->cd_usuarioalteracao = $this->session->userdata('ci_usuario');
                    $obj->dt_alteracao = date('Y-m-d');
                    
                    $updateinfrequencia[]= $obj;
                
            }else if ($this->input->post('infrequencia_'.$aluno) =="" && $this->input->post('nrfaltas_'.$aluno)!="" ){                
                $cd_aluno = $aluno;                
                $nr_faltas = $this->input->post('nrfaltas_'.$aluno);
                 $qtd_reg = $qtd_reg + 1;
                 $obj = new stdClass();                 
                 $obj->cd_aluno = $aluno;
                 $obj->nr_faltas = $nr_faltas;
                 $obj->cd_turma =  $this->input->post('cd_turma');
                 $obj->cd_etapa =  $this->input->post('cd_etapa');
                 $obj->nr_mes = $this->input->post('cd_mes');
                 $obj->cd_usuariocadastro = $this->session->userdata('ci_usuario');
                 $obj->dt_cadastro = date('Y-m-d');
                 
                 $insertinfrequencia[]= $obj;                 
            }
        }
        
       if ($qtd_reg >= 1){           
           if (isset($insertinfrequencia)){
               if($this->modelinfrequencia->inserir($insertinfrequencia)){
                   $this->novo("success");
               }else{
                   $this->novo("ocorreu_um_erro");
               }
           }else if(isset($updateinfrequencia)){ 
               if($this->modelinfrequencia->update($updateinfrequencia)){
                   $this->novo("success");
               }else{
                   $this->novo("ocorreu_um_erro");
               }
           }
       }else{
           $this->novo("success");
       }
        
    }
    
    public function salvarLiberacao(){
        $this->verifica_sessao();
        
        if($this->session->userdata('ci_grupousuario')!=1){
            $params['cd_cidade_sme']=$this->session->userdata('cd_cidade_sme');
        }else{
            $params['cd_cidade_sme'] = $this->input->post('cd_cidade');
        }
        
        $params['nr_anoliberacao'] = date('Y');
        $params['nr_mes'] = $this->input->post('cd_mes');
        $params['fl_ativo']= $this->input->post('fl_situacao');
        $params['cd_usariocadastro'] = $this->session->userdata('ci_usuario');
        $params['dt_cadastro'] = date('Y-m-d');
        
        $liberacaoExiste=$this->modelliberacao->pesquisaLiberacao($params);
        
        if(isset($liberacaoExiste[0])){
            $params['cd_usarioalteracao'] = $this->session->userdata('ci_usuario');
            $params['dt_alteracao'] = date('Y-m-d');
            $id=$liberacaoExiste[0]->ci_liberacao;
            if($this->modelinfrequencia->updateLiberacao($params,$id)){                
                $this->cadastraliberacao("success");
            }else{
                $this->cadastraliberacao("ocorreu_um_erro");
            }            
        }else if($this->modelinfrequencia->inserirLiberacao($params)){
            $this->cadastraliberacao("success");
        }else{
            $this->cadastraliberacao("ocorreu_um_erro");
        }
    }
    
    public function partials(){
       
        $action = ($this->uri->segment ( 4 ));
        
        if ($action == 'infrequencia') {
            
            $cd_turma = ($this->input->post('cd_turma'));
            $cd_aluno= ($this->input->post('cd_aluno'));
            
            $params['cd_turma'] = $cd_turma;
            $params['cd_aluno'] = $cd_aluno;
            
            $result = $this->modelinfrequencia->buscaInfrequenciaAluno($params);
            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
        }
    }

        
}