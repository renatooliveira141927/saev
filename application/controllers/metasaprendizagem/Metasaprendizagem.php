<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 31/07/2020
 * Time: 12:00
 */

class Metasaprendizagem extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Metasaprendizagem_model', 'modelmetasaprendizagem');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('util_model','modelutil');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('disciplina_model', 'modeldisciplina');
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
        $cd_disciplina =isset($parametro['cd_disciplina'])?$parametro['cd_disciplina']: $this->input->post('cd_disciplina');
        
        $id_estado =!empty($cd_estado)?$cd_estado:NULL;
        $id_cidade =!empty($cd_cidade)?$cd_cidade:NULL;
        
        $dados['anoatual']= date('Y');
        if($_POST){
            $dados['anoatual']=isset($parametro['nr_anoletivo'])?$parametro['nr_anoletivo']:$this->input->post('nr_anoletivo');
        }
        
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $dados['anos'] = $this->modelutil->selectAnoletivo(!isset($parametro['nr_anoletivo'])?$dados['anoatual']:$parametro['nr_anoletivo']);
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['disciplinas'] = $this->modeldisciplina->buscar();
        
        $ldisciplina = new stdClass(); 
        $ldisciplina->ci_disciplina=99; 
        $ldisciplina->nm_disciplina='LEITURA'; 
        $ldisciplina->fl_ativo='t';
        array_push ($dados['disciplinas'],$ldisciplina);
        
        //PRINT_R($dados['disciplinas'] );DIE;
        
        $dados['escolas'] = $this->modelescola->get_EscolaByCidade($parametro['cd_municipio']);
        return $dados;
    }
    
    public function metaslista(){
        $this->carregatemplate();
        $dados=$this->filtros();
        
        if($_POST){
            $params['cd_estado']=!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
            $params['cd_cidade']=!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $params['nr_anoletivo']=!empty($this->input->post('nr_anoletivo'))?$this->input->post('nr_anoletivo'):$dados['anoatual'];
            $params['cd_disciplina']=!empty($this->input->post('cd_disciplina'))?$this->input->post('cd_disciplina'):NULL;
            $dados['metas']=$this->modelmetasaprendizagem->buscametaaprendizagem($params);
            $dados['totalregistros']=count($dados['metas']);
            $total=0;
        }
        
        $this->load->view('metasaprendizagem/listagem', $dados);
    }
    
    public function novo($msg=null){
        $this->carregatemplate();        
        $dados=$this->filtros();
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $this->load->view('metasaprendizagem/cadastrar', $dados);
    }
    
    public function editar($id,$msg=null){
        $this->carregatemplate();        
        $params['id']=$id;
        $find['consulta']=$this->modelmetasaprendizagem->buscametaaprendizagem($params);
        //print_R($find['consulta'][0]->cd_disciplina);die;
        $parametro['cd_estado']=$find['consulta'][0]->ci_estado;
        $parametro['cd_municipio']=$find['consulta'][0]->cd_municipio;
        $parametro['nr_anoletivo']=$find['consulta'][0]->nr_anoletivo;
        $parametro['cd_escola']=$find['consulta'][0]->cd_escola;
        $params['cd_disciplina']=$find['consulta'][0]->cd_disciplina;
        $dados=$this->filtros($parametro);
        $dados['meta']=$find['consulta'][0]->ci_metas_aprendeizagem;
        $dados['etapa']=$find['consulta'][0]->cd_etapa;
        $dados['nr_percentual']=$find['consulta'][0]->nr_percentual;
        $dados['cd_escola']=$find['consulta'][0]->cd_escola;
        $dados['cd_disciplina']=$find['consulta'][0]->cd_disciplina;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $this->load->view('metasaprendizagem/editar', $dados);
    }
    
    public function gravar($id=null){
        
        if($id!=null){
            $params['ci_metas_aprendeizagem']=$id;
            $params['cd_municipio']=$this->input->post('cd_cidade');
            $params['nr_anoletivo']=$this->input->post('nr_anoletivo');
            $params['cd_etapa']=$this->input->post('cd_etapa');
            $params['cd_escola']=($this->input->post('cd_escola')==''?null:$this->input->post('cd_escola'));
            $params['nr_percentual']=$this->input->post('nr_percentual');
            $params['cd_disciplina']=$this->input->post('cd_disciplina');
            if ($this->modelmetasaprendizagem->alterar( $params)){
                //print_r($this->db->last_query());die;
                $this->editar($id,"success");
            }else{
                $this->editar($id,"registro_ja_existente");
            }
        }else{
            $params['cd_municipio']=$this->input->post('cd_cidade');
            $params['nr_anoletivo']=$this->input->post('nr_anoletivo');
            $params['cd_etapa']=$this->input->post('cd_etapa');
            $params['cd_escola']=($this->input->post('cd_escola')==''?null:$this->input->post('cd_escola'));
            $params['nr_percentual']=$this->input->post('nr_percentual');
            $params['cd_disciplina']=$this->input->post('cd_disciplina');
            
            if ($this->modelmetasaprendizagem->salvar( $params)){
                $this->novo("success");
            }else{
                $this->novo("registro_ja_existente");
            }
        } 
        
    }
    
}