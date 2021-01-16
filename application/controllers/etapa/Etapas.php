<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etapas extends CI_Controller
{
    protected $titulo = 'Etapas';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('etapas_model', 'modeletapa');
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
        $this->load->view('etapa/etapa', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_etapa      = $this->input->post('ci_etapa');
            $nm_etapa      = $this->input->post('nm_etapa');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modeletapa->buscar($ci_etapa, $nm_etapa, '', $limit, $offset);
                        
            $dados['total_registros'] = $this->modeletapa->buscar_count($ci_etapa, $nm_etapa);

            $config['base_url']    = base_url("etapa/etapas/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('etapa/etapa_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_etapa      = $this->input->post('ci_etapa');
        $nm_etapa      = $this->input->post('nm_etapa');

        $dados['registros'] = $this->modeletapa->buscar($ci_etapa,
                                                        $nm_etapa,
                                                        'XLS', $limit, $offset);

        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_etapa      = $this->input->post('ci_etapa');
        $nm_etapa      = $this->input->post('nm_etapa');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modeletapa->buscar($ci_etapa,
                                                            $nm_etapa,
                                                            '', $limit, $offset);

        $pagina =$this->load->view('etapa/etapa_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['etapas']        = $this->modeletapa->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('etapa/etapa_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_etapa      = $this->input->post('ci_etapa');
        $nm_etapa      = $this->input->post('nm_etapa');

        $this->form_validation->set_rules('nm_etapa', 'nome da etapa','required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            if (!$ci_etapa) { 
                $this->novo();
            }else{
                $this->editar($ci_etapa);
            }
        } else {

            if (!$ci_etapa) {
                if ($this->modeletapa->inserir($nm_etapa)){

                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
      
                
                if ($this->modeletapa->alterar($ci_etapa,
                                                $nm_etapa)){


                    $this->editar($ci_etapa, "success");
                }else{
                    $this->editar($ci_etapa, "registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['etapas'] = $this->modeletapa->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modeletapa->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('etapa/etapa_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modeletapa->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
}
