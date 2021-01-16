<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacoes_lancamentos extends CI_Controller
{
    protected $titulo = 'Lançamento de notas de avaliações';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');        
        $this->load->model('avaliacoes_lancamento_model', 'modelavaliacoes_lancamento');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');
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
        $dados['avaliacoes_lancamento'] = $this->modelavaliacoes_lancamento->buscar();
        $dados['turmas'] = $this->modelturma->buscar();
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['turnos'] = $this->modelturno->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg']    = $msg;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacoes_lancamento/avaliacoes_lancamento', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        $dados['turmas'] = $this->modelturma->buscar();
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['turnos'] = $this->modelturno->buscar();

        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $nr_inep_aluno = $this->input->post('nr_inep_aluno');
            $nm_aluno      = $this->input->post('nm_aluno');   
            $nr_inep_escola= $this->input->post('nr_inep_escola');
            $nm_escola     = $this->input->post('nm_escola');   
            $cd_cidade     = $this->input->post('cd_cidade');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            $cd_turno     = $this->input->post('cd_turno');
            $ci_enturmacao = $this->input->post('ci_enturmacao');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelavaliacoes_lancamento->buscar($nr_inep_aluno,
                                                                $nm_aluno,
                                                                $nr_inep_escola,
                                                                $nm_escola,
                                                                $cd_cidade,
                                                                $cd_turma,
                                                                $cd_etapa,
                                                                $cd_turno,
                                                                $ci_enturmacao,
                                                                '', $limit, $offset);

            $dados['total_registros'] = $this->modelavaliacoes_lancamento->count_buscar($nr_inep_aluno,
                                                                $nm_aluno,
                                                                $nr_inep_escola,
                                                                $nm_escola,
                                                                $cd_cidade,
                                                                $cd_turma,
                                                                $cd_etapa,
                                                                $cd_turno,
                                                                $ci_enturmacao);

            $config['base_url']    = base_url("avaliacoes_lancamento/avaliacoes_lancamento/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avaliacoes_lancamento/avaliacoes_lancamento_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }


    public function salvar(){
        $this->verifica_sessao();

        $cd_aluno           = $this->input->post('cd_aluno');
        $ci_avaliacao_itens = $this->input->post('ci_avaliacao_itens');

        $arr_ci_avaliacao_itens = explode(',',$ci_avaliacao_itens);
        
        $qtd_reg = 0;
        foreach ($arr_ci_avaliacao_itens as $i => $ci_avaliacao_item){  
            // echo '<br/>$this->input->post(ci_avaliacao_itens_.$ci_avaliacao_item)'.$this->input->post('ci_avaliacao_itens_'.$ci_avaliacao_item);

            if ($this->input->post('ci_avaliacao_itens_'.$ci_avaliacao_item) !=""){
                $qtd_reg = $qtd_reg + 1;
                $obj = new stdClass();
                
                $obj->cd_aluno                  = $cd_aluno;
                $obj->nr_alternativa_escolhida  = $this->input->post('ci_avaliacao_itens_'.$ci_avaliacao_item);
                $obj->cd_avaliacao_itens        = $ci_avaliacao_item;

                $lancamento_avaliacao[]= $obj;
            }            
        }
        //$qtd_reg = (count($enturmacoes));
        // echo '<br/>$qtd_reg='.$qtd_reg;

        if ($qtd_reg >= 1){
            if ($this->modelavaliacoes_lancamento->inserir($cd_aluno, $lancamento_avaliacao)){
                $this->index("success");
            }else{
                $this->index("ocorreu_um_erro");
            }
        }else{
            $this->index("nenhuma_turma_escolhida");
        }
        
        //$this->index("success");

    }
    public function popula_modal_veritem(){
        $cd_aluno           = $this->input->post('id');
        $ci_avaliacao_turma = $this->input->post('ci_avaliacao_turma');
        $nm_aluno           = $this->input->post('nm_aluno');

        $dados['cd_aluno']  = $cd_aluno;
        $dados['nm_aluno']  = $nm_aluno;
        $dados['cabecalho'] = $this->modelavaliacoes_lancamento->buscar_avaliacao_cabecalho($ci_avaliacao_turma);
        $dados['registros'] = $this->modelavaliacoes_lancamento->buscar_avaliacao_aluno($cd_aluno, $ci_avaliacao_turma);
        $this->load->view('avaliacoes_lancamento/modal_lancar_nota', $dados);
    }
}
