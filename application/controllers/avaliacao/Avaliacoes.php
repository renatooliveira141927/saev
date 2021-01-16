<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacoes extends CI_Controller
{
    protected $titulo = 'Cadastro de avaliação';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('avalia_item_model'       , 'modelavalia_item');
        $this->load->model('avalia_dificuldade_model', 'modelavalia_dificuldade');
        $this->load->model('avalia_conteudo_model'   , 'modelavalia_conteudo');
        $this->load->model('avalia_subconteudo_model', 'modelavalia_subconteudo');
        $this->load->model('avalia_origem_model'     , 'modelavalia_origem');
        
        $this->load->model('Avaliacao_model'    , 'modelAvaliacao');
        $this->load->model('estado_model'       , 'modelestado');
        $this->load->model('disciplina_model'   , 'modeldisciplina');
        $this->load->model('edicao_model'       , 'modeledicao');
        $this->load->model('etapas_model'       , 'modeletapa');
        $this->load->model('avalia_tipo_model'  , 'modelavalia_tipo');
        
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

        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        $dados['titulo']        = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('Avaliacao/Avaliacao', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_avaliacao   = $this->input->post('ci_avaliacao');
            $nm_caderno     = $this->input->post('nm_caderno');  
            $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
            $cd_cidade      = $this->input->post('cd_cidade');
            $nr_ano         = $this->input->post('nr_ano');
            $cd_disciplina  = $this->input->post('cd_disciplina');
            $cd_edicao      = $this->input->post('cd_edicao');
            $cd_etapa		= $this->input->post('cd_etapa');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelAvaliacao->buscar($ci_avaliacao, 
                                                                $nm_caderno, 
                                                                $cd_avalia_tipo,
                                                                $nr_ano, 
                                                                $cd_disciplina, 
                                                                $cd_edicao,
                                                                $cd_etapa, 
                                                                
                                                                '', $limit, $offset);

            $dados['total_registros'] = $this->modelAvaliacao->count_buscar($ci_avaliacao, 
                                                                            $nm_caderno, 
                                                                            $cd_avalia_tipo,
                                                                            $nr_ano, 
                                                                            $cd_disciplina, 
                                                                            $cd_edicao,
                                                                            $cd_etapa);

            $config['base_url']    = base_url("Avaliacao/Avaliacoes/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('Avaliacao/Avaliacao_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avaliacao   = $this->input->post('ci_avaliacao');
        $nm_caderno     = $this->input->post('nm_caderno');  
        $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
        $nr_ano         = $this->input->post('nr_ano');
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_edicao      = $this->input->post('cd_edicao');
        $cd_etapa		= $this->input->post('cd_etapa');

        $result = $this->modelAvaliacao->get_consulta_excel($ci_avaliacao, 
                                                            $nm_caderno, 
                                                            $cd_avalia_tipo, 
                                                            $nr_ano, 
                                                            $cd_disciplina, 
                                                            $cd_edicao,
                                                            $cd_etapa);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf($id = null){
        $this->verifica_sessao();

        $ci_avaliacao   = $this->input->post('ci_avaliacao');
        $nm_caderno     = $this->input->post('nm_caderno');  
        $cd_avalia_tipo = $this->input->post('cd_avalia_tipo');
        $nr_ano         = $this->input->post('nr_ano');
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_edicao      = $this->input->post('cd_edicao');
        $cd_etapa		= $this->input->post('cd_etapa');


        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelAvaliacao->get_consulta_pdf(  $id, 
                                                                        $nm_caderno, 
                                                                        $cd_avalia_tipo, 
                                                                        $nr_ano, 
                                                                        $cd_disciplina, 
                                                                        $cd_edicao,
                                                                        $cd_etapa, '', '', '');

        $dados['reg_avalia_itens'] = $this->modelavalia_item->get_itens_avaliacao_pdf($id);

        $pagina =$this->load->view('Avaliacao/Avaliacao_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        $dados['avalia_dificuldades']   = $this->modelavalia_dificuldade->buscar();
        $dados['avalia_conteudos']      = $this->modelavalia_conteudo->buscar();
        $dados['avalia_subconteudos']   = $this->modelavalia_subconteudo->buscar();
        $dados['avalia_origens']        = $this->modelavalia_origem->buscar();

        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacao/avaliacao_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_avaliacao       = $this->input->post('ci_avaliacao');
        $nm_caderno         = $this->input->post('nm_caderno');  
        $cd_avalia_tipo     = $this->input->post('cd_avalia_tipo');
        $nr_ano             = $this->input->post('nr_ano');
        $cd_disciplina      = $this->input->post('cd_disciplina_ava');
        $cd_edicao          = $this->input->post('cd_edicao_ava');
        $cd_etapa		    = $this->input->post('cd_etapa_ava');
        $ds_texto_abertura	= $this->input->post('ds_texto_abertura');
        $fl_avalia_nominal  = $this->input->post('fl_avalia_nominal');
        $fl_sortear_itens   = $this->input->post('fl_sortear_itens');
        $arr_ci_avalia_item = $this->input->post('arr_avalia_item');
        
        $this->form_validation->set_rules('nm_caderno'    , 'caderno'           ,'required');
        $this->form_validation->set_rules('cd_avalia_tipo', 'tipo de avaliacao' ,'required');
        $this->form_validation->set_rules('cd_disciplina_ava' , 'disciplina'        ,'required');
        $this->form_validation->set_rules('cd_edicao_ava'     , 'edicao'            ,'required');
        $this->form_validation->set_rules('cd_etapa_ava'      , 'etapa'             ,'required');

        if ($fl_avalia_nominal == 1){
            $fl_avalia_nominal = true;
        }
        else{
            $fl_avalia_nominal = false;
        }
        if ($fl_sortear_itens == 1){
            $fl_sortear_itens = true;
        }
        else{
            $fl_sortear_itens = false;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$ci_avaliacao) {
                if ($this->modelAvaliacao->inserir( $nm_caderno, 
                                                    $cd_avalia_tipo, 
                                                    $nr_ano, 
                                                    $cd_disciplina, 
                                                    $cd_edicao,
                                                    $cd_etapa,
                                                    $ds_texto_abertura,
                                                    $fl_avalia_nominal,
                                                    $fl_sortear_itens, 
                                                    $arr_ci_avalia_item)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {                
                if ($this->modelAvaliacao->alterar( $ci_avaliacao,
                                                    $nm_caderno, 
                                                    $cd_avalia_tipo, 
                                                    $nr_ano, 
                                                    $cd_disciplina, 
                                                    $cd_edicao,
                                                    $cd_etapa,
                                                    $ds_texto_abertura,
                                                    $fl_avalia_nominal,
                                                    $fl_sortear_itens,
                                                    $arr_ci_avalia_item)){

                    $this->editar($ci_avaliacao, "success");
                }else{
                    $this->editar($ci_avaliacao,"registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();
        $dados['avalia_dificuldades']   = $this->modelavalia_dificuldade->buscar();
        $dados['avalia_conteudos']      = $this->modelavalia_conteudo->buscar();
        $dados['avalia_subconteudos']   = $this->modelavalia_subconteudo->buscar();
        $dados['avalia_origens']        = $this->modelavalia_origem->buscar();
        
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();

        $dados['avaliacao_itens']   = $this->modelAvaliacao->buscar_avaliacao_itens($id);
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelAvaliacao->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacao/avaliacao_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelAvaliacao->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    
    public function buscaQuestoes(){
        $id= $this->input->post('ci_avaliacao');
        $cd_aluno= $this->input->post('cd_aluno');
        $dados= json_encode($this->modelAvaliacao->buscar_avaliacao_itens($id,$cd_aluno));
        if($dados !=null) echo $dados;

    }
}
