<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turmas extends CI_Controller
{
    protected $titulo = 'turmas';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('edicao_model', 'modeledicao');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('anos_letivos_model', 'modelano_letivo');
        $this->load->model('turnos_model', 'modelturno');
        $this->load->model('professores_model', 'modelprofessor');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('cidade_model', 'modelcidade');
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

        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['professores']   = $this->modelprofessor->buscar();

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
            $dados['escolas']       = $this->modelescola->buscar();
        }

        $dados['estado']        = $this->modelestado->selectEstados();

        $dados['titulo']        = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turma/turma', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_turma       = $this->input->post('ci_turma');
            $nm_turma       = $this->input->post('nm_turma'); 
            $cd_etapa       = $this->input->post('cd_etapa');           
            $cd_turno       = $this->input->post('cd_turno');
            $cd_professor   = $this->input->post('cd_professor');
            $dt_associa_prof= $this->input->post('dt_associa_prof');
            $nr_ano_letivo  = $this->input->post('nr_ano_letivo');
            $cd_escola      = $this->input->post('cd_escola');
            $cd_cidade_sme  = $this->input->post('cd_cidade_sme');
            if ($this->session->userdata('ci_grupousuario') ==2){
                $cd_cidade_sme=$this->session->userdata('cd_cidade_sme');
            }
            //echo ($cd_cidade_sme);die;
            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelturma->buscar($ci_turma,
                                                            $nm_turma,
                                                            $cd_etapa,
                                                            $cd_turno,
                                                            $cd_professor,
                                                            $dt_associa_prof,
                                                            $nr_ano_letivo,
                                                            $cd_escola,
                                                            $cd_cidade_sme,
                                                            '', $limit, $offset);

            $dados['total_registros'] = $this->modelturma->count_buscar($ci_turma,
                                                            $nm_turma,
                                                            $cd_etapa,
                                                            $cd_turno,
                                                            $cd_professor,
                                                            $dt_associa_prof,
                                                            $nr_ano_letivo,
                                                            $cd_escola,
                                                            $cd_cidade_sme);

            $config['base_url']    = base_url("turma/Turmas/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('turma/turma_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_turma       = $this->input->post('ci_turma');
        $nm_turma       = $this->input->post('nm_turma');
        $cd_etapa       = $this->input->post('cd_etapa');           
        $cd_turno       = $this->input->post('cd_turno');
        $cd_professor   = $this->input->post('cd_professor');
        $dt_associa_prof= $this->input->post('dt_associa_prof');
        $nr_ano_letivo  = $this->input->post('nr_ano_letivo');

        $result = $this->modelturma->get_consulta_excel($ci_turma, 
                                                        $nm_turma, 
                                                        $cd_etapa, 
                                                        $cd_turno, 
                                                        $cd_professor,
                                                        $dt_associa_prof,
                                                        $nr_ano_letivo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_turma       = $this->input->post('ci_turma');
        $nm_turma       = $this->input->post('nm_turma'); 
        $cd_etapa       = $this->input->post('cd_etapa');         
        $cd_turno       = $this->input->post('cd_turno');
        $cd_professor   = $this->input->post('cd_professor');
        $dt_associa_prof= $this->input->post('dt_associa_prof');
        $nr_ano_letivo  = $this->input->post('nr_ano_letivo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelturma->get_consulta_pdf(  $ci_turma, 
                                                                    $nm_turma, 
                                                                    $cd_etapa,
                                                                    $cd_turno, 
                                                                    $cd_professor,
                                                                    $dt_associa_prof,
                                                                    $nr_ano_letivo, '', '', '');
        $pagina =$this->load->view('turma/turma_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }    

    public function salvar(){
        $this->verifica_sessao();

        $ci_turma       = $this->input->post('ci_turma');
        $nm_turma       = strtoupper ($this->input->post('nm_turma'));
        $nr_ano_letivo  = $this->input->post('nr_ano_letivo');
        $cd_etapa       = $this->input->post('cd_etapa'); 
        $cd_turno       = $this->input->post('cd_turno');
        $cd_professor   = $this->input->post('cd_professor');
        $cd_estado      = $this->input->post('cd_estado');
        $cd_cidade      = $this->input->post('cd_cidade');
        $cd_escola      = $this->input->post('cd_escola');
        $tp_turma       = $this->input->post('tp_turma');
        // $dt_associa_prof= $this->input->post('txt_data');
    
        // $data = implode('/',array_reverse(explode('/',$dt_associa_prof))); // Converte data para padrão amaericano
        // $dt_associa_prof = $data;

        $this->form_validation->set_rules('cd_escola', 'Escola','required');        
		$this->form_validation->set_rules('nm_turma', 'Nome da Turma','required|min_length[1]');
        $this->form_validation->set_rules('cd_etapa', 'Etapa','required');
		$this->form_validation->set_rules('cd_turno', 'Turno','required');
        $this->form_validation->set_rules('nr_ano_letivo', 'Ano Letivo','required');
        // $this->form_validation->set_rules('txt_data', 'Data asosciação do professor na turma','required');
		
        if ($this->form_validation->run() == FALSE) {
            if (!$ci_turma) { 
                $this->novo();
            }else{
                $this->editar($ci_turma);
            }
        } else {

            if (!$ci_turma) {
                if ($this->modelturma->inserir( $nm_turma, 
                                                $cd_etapa,
                                                $cd_turno, 
                                                $cd_professor,
                                                $cd_escola,
                                                $tp_turma,
                                                $nr_ano_letivo)){
//echo $this->db->last_query();die;
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
              
                if ($this->modelturma->alterar( $ci_turma,
                                                $nm_turma,                                                 
                                                $cd_etapa,
                                                $cd_turno, 
                                                $cd_professor,
                                                $cd_escola,
                                                $tp_turma,
                                                $nr_ano_letivo)){
                    

                    $this->editar($ci_turma, $cd_estado, $cd_cidade, "success");
                }else{
                    $this->editar($ci_turma, $cd_estado, $cd_cidade, "registro_ja_existente");
                }

            }
        }

    }
    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['anos_letivos']  = $this->modelano_letivo->buscar();        
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['professores']   = $this->modelprofessor->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();
        
        if ($this->session->userdata('ci_grupousuario') ==2){
            $cd_cidade=$this->session->userdata('cd_cidade_sme');
            $dados['escolas']       = $this->modelescola->buscar(
                $ci_escola=null,
                $nr_inep=null,
                $nm_escola=null,
                $ds_telefone=null,
                $ds_email=null,
                $fl_extencao=null,
                $fl_tpunidade=null,
                $fl_localizacao=null,
                $cd_cidade
                );
        }else{
            $dados['escolas']       = $this->modelescola->buscar();
        }
        
        
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turma/turma_cad',$dados);
        $this->load->view('template/html-footer');
    }
    
    public function editar($id = null, $cd_estado = null, $cd_cidade = null, $msg = null){
        $this->verifica_sessao();

        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['anos_letivos']  = $this->modelano_letivo->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['turnos']        = $this->modelturno->buscar();
        $dados['professores']   = $this->modelprofessor->buscar();                
        $dados['escolas']       = $this->modelescola->buscar(); 
        $dados['registros']     = $this->modelturma->buscar($id);
        
        foreach ($dados['registros'] as $dado){
            $cd_estado = $dado->ci_estado;
            $cd_cidade = $dado->ci_cidade;
        
        }
        if ($this->session->userdata('ci_grupousuario') < 3){
            $cd_estado_sme   = '';
            $cd_cidade_sme   = '';
            foreach ($dados['registros'] as $registro){
                $cd_estado_sme   = $registro->ci_estado;
                $cd_cidade_sme   = $registro->ci_cidade;                
            }
            if ($cd_estado_sme){
                $dados['estados_sme']    = $this->modelestado->selectEstados($cd_estado_sme);
                $dados['municipios_sme'] = $this->modelcidade->selectCidade($cd_estado_sme, '', '', '', $cd_cidade_sme);
            }
        }

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turma/turma_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelturma->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}
