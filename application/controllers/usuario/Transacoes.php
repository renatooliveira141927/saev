<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transacoes extends CI_Controller
{
    protected $titulo = 'Transação';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('transacao_model', 'modeltransacao');
    }
    public function verifica_sessao($acao = null){
        if(!$this->session->userdata('logado')){
            if ($acao == 'rotina_ajax'){
                return 'sessaooff';                
            }else{
                redirect(base_url('usuario/usuarios/login'));
            }
            
        }

    }
    public function index($offset=null){
        $this->verifica_sessao();
        
        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transacao/transacao', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            //$this->form_validation->set_rules('nm_transacao', 'nome do tipo de avaliação','min_length[3]|required');


            $this->load->library('pagination');

            $ci_transacao     = $this->input->post('ci_transacao');
            $nm_transacao     = $this->input->post('nm_transacao');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modeltransacao->buscar('', $nm_transacao, '', $limit, $offset);
            $dados['total_registros'] = $this->modeltransacao->count_buscar('', $nm_transacao);

            $config['base_url']    = base_url("usuario/transacoes/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('transacao/transacao_lista', $dados);
            
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_transacao     = $this->input->post('ci_transacao');
        $nm_transacao     = $this->input->post('nm_transacao');

        $result = $this->modeltransacao->get_consulta_excel($ci_transacao, 
                                                            $nm_transacao);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_transacao     = $this->input->post('ci_transacao');
        $nm_transacao     = $this->input->post('nm_transacao');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modeltransacao->buscar($ci_transacao, 
                                                                     $nm_transacao, '', '', '');
        $pagina =$this->load->view('transacao/transacao_pdf', $dados, true);

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
        $this->load->view('transacao/transacao_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $id       	    = $this->input->post('ci_transacao');
        $nm_transacao = $this->input->post('nm_transacao');

        $this->form_validation->set_rules('nm_transacao', 'conteúdo','required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modeltransacao->inserir($nm_transacao)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modeltransacao->alterar($id, $nm_transacao)){
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

        $dados['registros']   = $this->modeltransacao->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('transacao/transacao_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('ci_transacao');
            $this->modeltransacao->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}