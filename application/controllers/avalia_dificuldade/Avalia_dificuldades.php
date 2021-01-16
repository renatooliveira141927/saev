<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_dificuldades extends CI_Controller
{
    protected $titulo = 'Tipos de  dificuldades';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('avalia_dificuldade_model', 'modelavalia_dificuldade');
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
        $this->load->view('avalia_dificuldade/avalia_dificuldade', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->form_validation->set_rules('nm_avalia_dificuldade', 'nome do tipo de dificuldade','min_length[3]|required');


            if ($this->form_validation->run() == FALSE) {
                $dados['total_registros'] = 0;
                $this->load->view('avalia_dificuldade/avalia_dificuldade_lista', $dados);
            } else {
                $this->load->library('pagination');

                $ci_avalia_dificuldade     = $this->input->post('ci_avalia_dificuldade');
                $nm_avalia_dificuldade     = $this->input->post('nm_avalia_dificuldade');

                $dados['titulo'] = $this->titulo;

                $limit = '10';
                $dados['registros'] = $this->modelavalia_dificuldade->buscar('', $nm_avalia_dificuldade, '', $limit, $offset);
                $dados['total_registros'] = $this->modelavalia_dificuldade->count_buscar('', $nm_avalia_dificuldade);

                $config['base_url']    = base_url("avalia_dificuldade/avalia_dificuldades/listagem_consulta");
                $config['total_rows']  = $dados['total_registros'];
                $config['per_page']    = $limit;
                $config['uri_segment'] = '3';
                $config['cur_page'] = $offset;
                $this->pagination->initialize($config);
                $dados['links_paginacao']     = $this->pagination->create_links();

                $this->load->view('avalia_dificuldade/avalia_dificuldade_lista', $dados);
            }
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avalia_dificuldade     = $this->input->post('ci_avalia_dificuldade');
        $nm_avalia_dificuldade     = $this->input->post('nm_avalia_dificuldade');

        $result = $this->modelavalia_dificuldade->get_consulta_excel($ci_avalia_dificuldade, 
                                                                    $nm_avalia_dificuldade);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_avalia_dificuldade     = $this->input->post('ci_avalia_dificuldade');
        $nm_avalia_dificuldade     = $this->input->post('nm_avalia_dificuldade');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_dificuldade->buscar($ci_avalia_dificuldade, 
                                                                     $nm_avalia_dificuldade, '', '', '');
        $pagina =$this->load->view('avalia_dificuldade/avalia_dificuldade_pdf', $dados, true);

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
        $this->load->view('avalia_dificuldade/avalia_dificuldade_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $id       	        = $this->input->post('ci_avalia_dificuldade');
        $nm_avalia_dificuldade = $this->input->post('nm_avalia_dificuldade');

        $this->form_validation->set_rules('nm_avalia_dificuldade', 'conteúdo','min_length[3]|required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                if ($this->modelavalia_dificuldade->inserir($nm_avalia_dificuldade)){
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($this->modelavalia_dificuldade->alterar($id, $nm_avalia_dificuldade)){
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

        $dados['registros']   = $this->modelavalia_dificuldade->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_dificuldade/avalia_dificuldade_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('ci_avalia_dificuldade');
            $this->modelavalia_dificuldade->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}