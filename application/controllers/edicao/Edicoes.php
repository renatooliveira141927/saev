<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edicoes extends CI_Controller
{
    protected $titulo = 'EDIÇÕES';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('edicao_model', 'modeledicao');
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
        
        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('edicao/edicao', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            //$this->form_validation->set_rules('nm_edicao', 'nome do tipo de avaliação','min_length[3]|required');


            $this->load->library('pagination');

            $ci_edicao     = $this->input->post('ci_edicao');
            $nm_edicao     = $this->input->post('nm_edicao');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modeledicao->buscar('', $nm_edicao, '', $limit, $offset);
            $dados['total_registros'] = $this->modeledicao->buscar_count('', $nm_edicao);

            $config['base_url']    = base_url("edicao/edicoes/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('edicao/edicao_lista', $dados);
            
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_edicao     = $this->input->post('ci_edicao');
        $nm_edicao     = $this->input->post('nm_edicao');

        $result = $this->modeledicao->get_consulta_excel($ci_edicao, 
                                                                    $nm_edicao);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_edicao     = $this->input->post('ci_edicao');
        $nm_edicao     = $this->input->post('nm_edicao');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modeledicao->buscar($ci_edicao, 
                                                                     $nm_edicao, '', '', '');
        $pagina =$this->load->view('edicao/edicao_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('edicao/edicao_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $id       	    = $this->input->post('ci_edicao');
        $nm_edicao = $this->input->post('nm_edicao');

        $this->form_validation->set_rules('nm_edicao', 'conteúdo','required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modeledicao->inserir($nm_edicao)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modeledicao->alterar($id, $nm_edicao)){
                    $this->editar($id, "success");
                }else{
                    $this->editar($id,"registro_ja_existente");
                }

            }
        }
    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modeledicao->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('edicao/edicao_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modeledicao->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}