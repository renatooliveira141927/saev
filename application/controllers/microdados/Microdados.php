<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Microdados extends CI_Controller
{   
   
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('microdados_model', 'modelmicrodadosmodel');
        $this->load->model('enturmacoes_model', 'modelenturmacao');
        $this->load->model('util_model','modelutil');
        $this->load->model('disciplina_model', 'modeldisciplina');
        ini_set("memory_limit","640M");
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
        $cd_disciplina =isset($parametro['cd_disciplina'])?$parametro['cd_disciplina']: $this->input->get('cd_disciplina');
        
        $dados['anoatual']= date('Y');
        if($_GET){
            $dados['anoatual']=isset($parametro['ano'])?$parametro['ano']:$this->input->get('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        $dados['disciplinas'] = $this->modeldisciplina->buscar();     
        return $dados;
    }
    
    public function relatorio($offset=null){
        $limit=1000;
        $this->carregatemplate();
        $dados=$this->filtros();
        $this->load->library('pagination');
        $dados['totalregistros']=0;
        if($_GET){            
            $params['ano']=!empty($this->input->get('nr_anoletivo'))?$this->input->get('nr_anoletivo'):NULL;
            $params['cd_disciplina']=!empty($this->input->get('cd_disciplina'))?$this->input->get('cd_disciplina'):NULL;
            $dados=$this->filtros($params);
            $params['limit']=$limit;
            $params['offset']=!empty($offset)?$offset:null;            
            $dados['microdados']=$this->modelmicrodadosmodel->relatorio($params);
            $dados['totalregistros']=$this->modelmicrodadosmodel->totalregistros($params)[0]->total;
            //print_r($dados['totalregistros']);die;
            $total=0;
            $config['base_url']    = base_url("microdados/Microdados/relatorio");
            $config['total_rows']  = $dados['totalregistros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);           
            $dados['cd_disciplina']=$params['cd_disciplina'];
            $dados['links_paginacao'] = $this->pagination->create_links();
        }
        $this->load->view('microdados/listagem', $dados);
    }
    
    public function identificar($msg = null){
        $limit=30;
        $this->carregatemplate();
        $dados=$this->filtros();
        $this->load->library('pagination');
        
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $dados['totalregistros']=0;
        if($_GET){
            $params['ano']=!empty($this->input->get('nr_anoletivo'))?$this->input->get('nr_anoletivo'):NULL;
            $params['cd_disciplina']=!empty($this->input->get('cd_disciplina'))?$this->input->get('cd_disciplina'):NULL;
            $dados=$this->filtros($params);
            $params['limit']=$limit;
            $params['offset']=!empty($offset)?$offset:null;
            $dados['microdados']=$this->modelmicrodadosmodel->identificar($params);
                            
            foreach ($dados['microdados'] as $dates){                
              $estados.="','".trim($dates->nm_estado);
              $municipios.="','".trim($dates->nm_municipio);
            }
            $params['estados']=$estados;
            $params['municipios']=$municipios;
            
            $dados['alunos'] = $this->modelenturmacao->selectIdentificarAlunos($params);           
            //print_r($dados['alunos']);die;            
            //echo $this->db->last_query();die;
            $dados['totalregistros']=count($dados['microdados']);
            $total=0;
            $config['base_url']    = base_url("microdados/Microdados/identificar");
            $config['total_rows']  = $dados['totalregistros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['cd_disciplina']=$params['cd_disciplina'];
            $dados['links_paginacao'] = $this->pagination->create_links();
        }
        $this->carregatemplate();
        $this->load->view('microdados/identificar', $dados);
    }
    
    public function salvar(){
        
        $cd_disciplina=$_POST['cd_disciplina'][0];
        $id=$_POST['ci_microdados'];
        $alunos = $_POST['cd_aluno'];
        
        foreach ($alunos as $i => $item){            
            if(!empty($item)){
             $obj = new stdClass();
             $obj->cd_alunosaev = $item;
             $obj->ci_microdados = $id[$i];
             $gabarito[]= $obj;
            }
        }

        //print_r($gabarito);
        //die;
        $retorno=$this->modelmicrodadosmodel->salvar($cd_disciplina,$gabarito);
        if ($retorno){
            $this->identificar("success");
        }else{
            $this->identificar("registro_ja_existente");
        }
        
    }
}