<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enturmacoes extends CI_Controller
{
    protected $titulo = 'ENTURMAÇÃO DE ALUNOS';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');        
        $this->load->model('enturmacoes_model', 'modelenturmacao');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('util_model','modelutil');
        ini_set('memory_limit', '256M');
        
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
    public function index($msg=null){
        $this->verifica_sessao();

        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['turnos'] = $this->modelturno->buscar();
        $dados['anos'] = $this->modelutil->selectAnoletivo();
        $dados['anoatual']= date('Y');
               
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

        $dados['titulo'] = $this->titulo;
        $dados['msg']    = $msg;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('enturmacao/enturmacao', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        $dados['etapas'] = $this->modeletapa->buscar();
 
        if ($status_sessao!='sessaooff') {

            $nr_inep_aluno = $this->input->post('nr_inep_aluno');
            $nm_aluno      = $this->input->post('nm_aluno');   
            $nr_inep_escola= $this->input->post('nr_inep_escola');
            $cd_escola     = $this->input->post('cd_escola');            
            $nm_escola     = $this->input->post('nm_escola');   
            $cd_cidade     = $this->input->post('cd_cidade');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            $cd_turno     = $this->input->post('cd_turno');
            $nr_anoletivo = $this->input->post('nr_anoletivo');
            $dados['anopesquisa']= $nr_anoletivo;

            $dados['turmas'] = $this->modelturma->get_turmasatuais_combo($cd_escola);    

            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $cd_escola     = $this->session->userdata('ci_escola');
            }

            $dados['titulo'] = $this->titulo;
            //$nm_escola = 190;
            $dados['registros'] = $this->modelenturmacao->buscar($nr_inep_aluno,
                                                                $nm_aluno,
                                                                $cd_escola,
                                                                $nr_inep_escola,
                                                                $nm_escola,
                                                                $cd_cidade,
                                                                $cd_turma,
                                                                $cd_etapa,
                                                                $cd_turno,
                                                                $nr_anoletivo);  

            //echo $this->db->last_query();die;
            $dados['total_registros'] = $this->modelenturmacao->count_buscar($nr_inep_aluno,
                                                                $nm_aluno,
                                                                $cd_escola,
                                                                $nr_inep_escola,
                                                                $nm_escola,
                                                                $cd_cidade,
                                                                $cd_turma,
                                                                $cd_etapa,
                                                                $cd_turno,
                                                                $nr_anoletivo);
            $dados['anoatual']= date('Y');    
            $dados['msgdesativa']=$dados['anoatual']!=$dados['anopesquisa']?'desativa':'ativa';
            $dados['desativasalvar']= $dados['anoatual']!=$dados['anopesquisa']?'disabled=true':'disabled=false';
            $this->load->view('enturmacao/enturmacao_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }


    public function salvar(){
        $this->verifica_sessao();
        
        $var_cd_alunos = $this->input->post('arr_ci_alunos');
        $var_enturmacoes=  $this->input->post('enturmacao');
        $var_turmas= $this->input->post('cd_turma');
        $var_ultimaenturmacao=  $this->input->post('ultimaenturmacao');
        
        for($i=0;$i<sizeof($var_turmas);$i++){
            
            if (!empty($var_enturmacoes[$i])){
                $obj = new stdClass();
                $obj->cd_aluno = $var_cd_alunos[$i];
                $obj->cd_turma = isset($var_turmas[$i])?$var_turmas[$i]:0;
                $obj->ci_enturmacao = $var_enturmacoes[$i];
                $obj->ci_ultimaenturmacao = $var_ultimaenturmacao[$i];
                $obj->fl_ativo       = true;
                $obj->cd_usuario_cad = $this->session->userdata('ci_usuario');
                $enturmacoes[]= $obj;

            }else if(!empty($var_turmas[$i])){
                $obj = new stdClass();
                $obj->cd_aluno = $var_cd_alunos[$i];
                $obj->cd_turma = $var_turmas[$i];
                $obj->fl_ativo       = true;                
                $enturmacoes[]= $obj;

            }
            
        }
        
        if($this->modelenturmacao->gravar($enturmacoes)){
            $this->index("success");
        }else{
            $this->index("ocorreu_um_erro");
        }
    }

}
