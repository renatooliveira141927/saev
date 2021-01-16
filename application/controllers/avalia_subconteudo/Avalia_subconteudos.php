<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_subconteudos extends CI_Controller
{
    protected $titulo = 'Conteúdos para avaliações';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('avalia_subconteudo_model', 'modelavalia_subconteudo');
        $this->load->model('avalia_conteudo_model', 'modelavalia_conteudo');

        if(!$this->session->userdata('logado')){
            redirect(base_url('usuario/autenticacoes/login'));
        }
    }

    public function index($offset=null)
    {
        $dados['titulo'] = $this->titulo;
        $dados['avalia_conteudos'] = $this->modelavalia_conteudo->buscar('', '');

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_subconteudo/avalia_subconteudo', $dados);
        $this->load->view('template/html-footer');
    }
    public function listagem_consulta($offset=null)
    {
        $this->load->library('pagination');

        $ci_avalia_subconteudo     = $this->input->post('ci_avalia_subconteudo');
        $nm_avalia_subconteudo     = $this->input->post('nm_avalia_subconteudo');
        $cd_avalia_conteudo          = $this->input->post('cd_avalia_conteudo');

        $dados['avalia_conteudos'] = $this->modelavalia_conteudo->buscar('', '');
        $dados['titulo'] = $this->titulo;

        $limit = '10';
        $dados['registros'] = $this->modelavalia_subconteudo->buscar('', $nm_avalia_subconteudo, $cd_avalia_conteudo,'', $limit, $offset);
        $dados['total_registros'] = $this->modelavalia_subconteudo->count_buscar('', $nm_avalia_subconteudo);

        $config['base_url']    = base_url("avalia_subconteudo/avalia_itens/listagem_consulta");
        $config['total_rows']  = $dados['total_registros'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = '3';
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $dados['links_paginacao']     = $this->pagination->create_links();

        $this->load->view('avalia_subconteudo/avalia_subconteudo_lista', $dados);
    }

    public function gerar_excel(){

        $this->load->library('export_excel');
        $ci_avalia_subconteudo     = $this->input->post('ci_avalia_subconteudo');
        $nm_avalia_subconteudo     = $this->input->post('nm_avalia_subconteudo');
        $cd_avalia_conteudo          = $this->input->post('cd_avalia_conteudo');

        $result = $this->modelavalia_subconteudo->get_consulta_excel($ci_avalia_subconteudo, $nm_avalia_subconteudo, $cd_avalia_conteudo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){

        $ci_avalia_subconteudo     = $this->input->post('ci_avalia_subconteudo');
        $nm_avalia_subconteudo     = $this->input->post('nm_avalia_subconteudo');
        $cd_avalia_conteudo          = $this->input->post('cd_avalia_conteudo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_subconteudo->buscar($ci_avalia_subconteudo, $nm_avalia_subconteudo, $cd_avalia_conteudo, '', '', '');
        $pagina =$this->load->view('avalia_subconteudo/avalia_subconteudo_pdf', $dados, true);

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

        $dados['avalia_conteudos'] = $this->modelavalia_conteudo->buscar('', '');

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_subconteudo/avalia_subconteudo_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar()
    {
        $id       	        = $this->input->post('ci_avalia_subconteudo');
        $nm_avalia_subconteudo = $this->input->post('nm_avalia_subconteudo');
        $cd_avalia_conteudo      = $this->input->post('cd_avalia_conteudo');

        $this->form_validation->set_rules('nm_avalia_subconteudo', 'conteúdo','min_length[3]|required');
        $this->form_validation->set_rules('cd_avalia_conteudo',      'avalia_conteudo','required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modelavalia_subconteudo->inserir($nm_avalia_subconteudo, $cd_avalia_conteudo)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modelavalia_subconteudo->alterar($id, $nm_avalia_subconteudo, $cd_avalia_conteudo)){
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
        $dados['avalia_conteudos'] = $this->modelavalia_conteudo->buscar('', '');
        $dados['registros']   = $this->modelavalia_subconteudo->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_subconteudo/avalia_subconteudo_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir()
    {
        $id    = $this->input->post('ci_avalia_subconteudo');
        $this->modelavalia_subconteudo->excluir($id);
        $this->listagem_consulta();
        //$this->index("success");
    }

}