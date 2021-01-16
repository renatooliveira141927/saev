<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_conteudos extends CI_Controller
{
    protected $titulo = 'Conteúdos para avaliações';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('avalia_conteudo_model', 'modelavalia_conteudo');
        $this->load->model('disciplina_model', 'modeldisciplina');

        if(!$this->session->userdata('logado')){
            redirect(base_url('usuario/autenticacoes/login'));
        }
    }

    public function index($offset=null)
    {
        $dados['titulo'] = $this->titulo;
        $dados['disciplinas'] = $this->modeldisciplina->buscar('', '');

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_conteudo/avalia_conteudo', $dados);
        $this->load->view('template/html-footer');
    }
    public function listagem_consulta($offset=null)
    {
        $this->load->library('pagination');

        $ci_avalia_conteudo     = $this->input->post('ci_avalia_conteudo');
        $nm_avalia_conteudo     = $this->input->post('nm_avalia_conteudo');
        $cd_disciplina          = $this->input->post('cd_disciplina');

        $dados['disciplinas'] = $this->modeldisciplina->buscar('', '');
        $dados['titulo'] = $this->titulo;

        $limit = '10';
        $dados['registros'] = $this->modelavalia_conteudo->buscar('', $nm_avalia_conteudo, $cd_disciplina,'', $limit, $offset);
        $dados['total_registros'] = $this->modelavalia_conteudo->count_buscar('', $nm_avalia_conteudo);

        $config['base_url']    = base_url("avalia_conteudo/avalia_itens/listagem_consulta");
        $config['total_rows']  = $dados['total_registros'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = '3';
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $dados['links_paginacao']     = $this->pagination->create_links();

        $this->load->view('avalia_conteudo/avalia_conteudo_lista', $dados);
    }

    public function gerar_excel(){

        $this->load->library('export_excel');
        $ci_avalia_conteudo     = $this->input->post('ci_avalia_conteudo');
        $nm_avalia_conteudo     = $this->input->post('nm_avalia_conteudo');
        $cd_disciplina          = $this->input->post('cd_disciplina');

        $result = $this->modelavalia_conteudo->get_consulta_excel($ci_avalia_conteudo, $nm_avalia_conteudo, $cd_disciplina);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){

        $ci_avalia_conteudo     = $this->input->post('ci_avalia_conteudo');
        $nm_avalia_conteudo     = $this->input->post('nm_avalia_conteudo');
        $cd_disciplina          = $this->input->post('cd_disciplina');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_conteudo->buscar($ci_avalia_conteudo, $nm_avalia_conteudo, $cd_disciplina, '', '', '');
        $pagina =$this->load->view('avalia_conteudo/avalia_conteudo_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null)
    {
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['disciplinas'] = $this->modeldisciplina->buscar('', '');

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_conteudo/avalia_conteudo_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar()
    {
        $id       	        = $this->input->post('ci_avalia_conteudo');
        $nm_avalia_conteudo = $this->input->post('nm_avalia_conteudo');
        $cd_disciplina      = $this->input->post('cd_disciplina');

        $this->form_validation->set_rules('nm_avalia_conteudo', 'conteúdo','min_length[3]|required');
        $this->form_validation->set_rules('cd_disciplina',      'disciplina','required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modelavalia_conteudo->inserir($nm_avalia_conteudo, $cd_disciplina)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modelavalia_conteudo->alterar($id, $nm_avalia_conteudo, $cd_disciplina)){
                    $this->editar($id, "success");
                }else{
                    $this->editar($id,"registro_ja_existente");
                }

            }
        }
    }

    public function editar($id = null, $msg = null)
    {
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $dados['disciplinas'] = $this->modeldisciplina->buscar('', '');
        $dados['registros']   = $this->modelavalia_conteudo->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_conteudo/avalia_conteudo_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir()
    {
        $id    = $this->input->post('ci_avalia_conteudo');
        $this->modelavalia_conteudo->excluir($id);
        $this->listagem_consulta();
        //$this->index("success");
    }

}