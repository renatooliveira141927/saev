<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_origens extends CI_Controller
{
    protected $titulo = 'Origem';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('avalia_origem_model', 'modelavalia_origem');

        if(!$this->session->userdata('logado')){
            redirect(base_url('usuario/autenticacoes/login'));
        }
    }

    public function index($offset=null)
    {
        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_origem/avalia_origem', $dados);
        $this->load->view('template/html-footer');
    }
    public function listagem_consulta($offset=null)
    {
        $this->load->library('pagination');

        $ci_avalia_origem     = $this->input->post('ci_avalia_origem');
        $nm_avalia_origem     = $this->input->post('nm_avalia_origem');

        $dados['titulo'] = $this->titulo;

        $limit = '10';
        $dados['registros'] = $this->modelavalia_origem->buscar('', $nm_avalia_origem, '', $limit, $offset);
        $dados['total_registros'] = $this->modelavalia_origem->count_buscar('', $nm_avalia_origem);

        $config['base_url']    = base_url("avalia_origem/avalia_origens/listagem_consulta");
        $config['total_rows']  = $dados['total_registros'];
        $config['per_page']    = $limit;
        $config['uri_segment'] = '3';
        $config['cur_page'] = $offset;
        $this->pagination->initialize($config);
        $dados['links_paginacao']     = $this->pagination->create_links();

        $this->load->view('avalia_origem/avalia_origem_lista', $dados);
    }

    public function gerar_excel(){

        $this->load->library('export_excel');
        $ci_avalia_origem     = $this->input->post('ci_avalia_origem');
        $nm_avalia_origem     = $this->input->post('nm_avalia_origem');

        $result = $this->modelavalia_origem->get_consulta_excel('', $ci_avalia_origem, $nm_avalia_origem);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){

        $ci_avalia_origem     = $this->input->post('ci_avalia_origem');
        $nm_avalia_origem     = $this->input->post('nm_avalia_origem');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_origem->buscar('', $ci_avalia_origem, $nm_avalia_origem, '', '', '');
        $pagina =$this->load->view('avalia_origem/avalia_origem_pdf', $dados, true);

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

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_origem/avalia_origem_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar()
    {
        $id       	        = $this->input->post('ci_avalia_origem');
        $nm_avalia_origem = $this->input->post('nm_avalia_origem');

        $this->form_validation->set_rules('nm_avalia_origem', 'conteúdo','min_length[3]|required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modelavalia_origem->inserir($nm_avalia_origem)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modelavalia_origem->alterar($id, $nm_avalia_origem)){
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

        $dados['registros']   = $this->modelavalia_origem->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_origem/avalia_origem_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir()
    {
        $id    = $this->input->post('ci_avalia_origem');
        $this->modelavalia_origem->excluir($id);
        $this->listagem_consulta();
        //$this->index("success");
    }

}