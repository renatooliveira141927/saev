<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disciplinas extends CI_Controller
{
    protected $titulo = 'DISCIPLINAS';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('disciplina_model', 'modeldisciplina');
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
        $this->load->view('disciplina/disciplina', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            //$this->form_validation->set_rules('nm_disciplina', 'nome da disciplina','min_length[3]|required');


            /*if ($this->form_validation->run() == FALSE) {
                $dados['total_registros'] = 0;
                $this->load->view('disciplina/disciplina_lista', $dados);
            } else {*/
                $this->load->library('pagination');

                $ci_disciplina     = $this->input->post('ci_disciplina');
                $nm_disciplina     = $this->input->post('nm_disciplina')?$this->input->post('nm_disciplina'):null;

                $dados['titulo'] = $this->titulo;

                $limit = '10';
                $dados['registros'] = $this->modeldisciplina->buscar('', $nm_disciplina, '', $limit, $offset);
           
                $dados['total_registros'] = $this->modeldisciplina->count_buscar('', $nm_disciplina);

                $config['base_url']    = base_url("disciplina/disciplinas/listagem_consulta");
                $config['total_rows']  = $dados['total_registros'];
                $config['per_page']    = $limit;
                $config['uri_segment'] = '3';
                $config['cur_page'] = $offset;
                $this->pagination->initialize($config);
                $dados['links_paginacao']     = $this->pagination->create_links();

                $this->load->view('disciplina/disciplina_lista', $dados);
            //}
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_disciplina     = $this->input->post('ci_disciplina');
        $nm_disciplina     = $this->input->post('nm_disciplina');

        $result = $this->modeldisciplina->get_consulta_excel('', $ci_disciplina, $nm_disciplina);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_disciplina     = $this->input->post('ci_disciplina');
        $nm_disciplina     = $this->input->post('nm_disciplina');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modeldisciplina->buscar('', $ci_disciplina, $nm_disciplina, '', '', '');
        $pagina =$this->load->view('disciplina/disciplina_pdf', $dados, true);

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
        $this->load->view('disciplina/disciplina_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $id       	        = $this->input->post('ci_disciplina');
        $nm_disciplina = $this->input->post('nm_disciplina');

        $this->form_validation->set_rules('nm_disciplina', 'conteúdo','min_length[3]|required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modeldisciplina->inserir($nm_disciplina)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modeldisciplina->alterar($id, $nm_disciplina)){
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

        $dados['registros']   = $this->modeldisciplina->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('disciplina/disciplina_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('ci_disciplina');
            $this->modeldisciplina->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}