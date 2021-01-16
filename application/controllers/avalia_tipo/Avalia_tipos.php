<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_tipos extends CI_Controller
{
    protected $titulo = 'TIPOS DE AVALIAÇÕES';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('avalia_tipo_model', 'modelavalia_tipo');
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
        $this->load->view('avalia_tipo/avalia_tipo', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_avalia_tipo      = $this->input->post('ci_avalia_tipo');
            $nm_avalia_tipo      = $this->input->post('nm_avalia_tipo');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelavalia_tipo->buscar($ci_avalia_tipo, $nm_avalia_tipo, '', $limit, $offset);
                        
            $dados['total_registros'] = $this->modelavalia_tipo->buscar_count($ci_avalia_tipo, $nm_avalia_tipo);

            $config['base_url']    = base_url("avalia_tipo/avalia_tipos/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avalia_tipo/avalia_tipo_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avalia_tipo      = $this->input->post('ci_avalia_tipo');
        $nm_avalia_tipo      = $this->input->post('nm_avalia_tipo');

        $dados['registros'] = $this->modelavalia_tipo->buscar($ci_avalia_tipo,
                                                        $nm_avalia_tipo,
                                                        'XLS', $limit, $offset);

        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_avalia_tipo      = $this->input->post('ci_avalia_tipo');
        $nm_avalia_tipo      = $this->input->post('nm_avalia_tipo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_tipo->buscar($ci_avalia_tipo,
                                                            $nm_avalia_tipo,
                                                            '', $limit, $offset);

        $pagina =$this->load->view('avalia_tipo/avalia_tipo_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['avalia_tipos']        = $this->modelavalia_tipo->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_tipo/avalia_tipo_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_avalia_tipo      = $this->input->post('ci_avalia_tipo');
        $nm_avalia_tipo      = $this->input->post('nm_avalia_tipo');

        $this->form_validation->set_rules('nm_avalia_tipo', 'nome da avalia_tipo','required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            if (!$ci_avalia_tipo) { 
                $this->novo();
            }else{
                $this->editar($ci_avalia_tipo);
            }
        } else {

            if (!$ci_avalia_tipo) {
                if ($this->modelavalia_tipo->inserir($nm_avalia_tipo)){

                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
      
                
                if ($this->modelavalia_tipo->alterar($ci_avalia_tipo,
                                                $nm_avalia_tipo)){


                    $this->editar($ci_avalia_tipo, "success");
                }else{
                    $this->editar($ci_avalia_tipo, "registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['avalia_tipos'] = $this->modelavalia_tipo->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelavalia_tipo->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_tipo/avalia_tipo_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelavalia_tipo->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
}
