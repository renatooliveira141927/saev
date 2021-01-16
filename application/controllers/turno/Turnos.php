<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Turnos extends CI_Controller
{
    protected $titulo = 'TIPOS DE TURNOS';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

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
    public function index($offset=null){
        $this->verifica_sessao();       

        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turno/turno', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_turno      = $this->input->post('ci_turno');
            $nm_turno      = $this->input->post('nm_turno');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelturno->buscar($ci_turno, $nm_turno, '', $limit, $offset);
                        
            $dados['total_registros'] = $this->modelturno->buscar_count($ci_turno, $nm_turno);

            $config['base_url']    = base_url("turno/turnos/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('turno/turno_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_turno      = $this->input->post('ci_turno');
        $nm_turno      = $this->input->post('nm_turno');

        $dados['registros'] = $this->modelturno->buscar($ci_turno,
                                                        $nm_turno,
                                                        'XLS', $limit, $offset);

        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_turno      = $this->input->post('ci_turno');
        $nm_turno      = $this->input->post('nm_turno');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelturno->buscar($ci_turno,
                                                            $nm_turno,
                                                            '', $limit, $offset);

        $pagina =$this->load->view('turno/turno_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['turnos']        = $this->modelturno->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turno/turno_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_turno      = $this->input->post('ci_turno');
        $nm_turno      = $this->input->post('nm_turno');

        $this->form_validation->set_rules('nm_turno', 'nome da turno','required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            if (!$ci_turno) { 
                $this->novo();
            }else{
                $this->editar($ci_turno);
            }
        } else {

            if (!$ci_turno) {
                if ($this->modelturno->inserir($nm_turno)){

                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
      
                
                if ($this->modelturno->alterar($ci_turno,
                                                $nm_turno)){


                    $this->editar($ci_turno, "success");
                }else{
                    $this->editar($ci_turno, "registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['turnos'] = $this->modelturno->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelturno->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('turno/turno_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelturno->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
}
