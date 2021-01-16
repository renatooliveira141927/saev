<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('niveis_model', 'modelnivel');
    }

    public function index($acao = null)
    {

        $nivel = $this->input->post('txt-nm_nivel');
        $dados['niveis'] = $this->modelnivel->buscar('', $nivel);
        $dados['titulo'] = "Nível";

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('nivel/niveis', $dados);
        $this->load->view('template/html-footer');
    }

    public function novo($msg = null)
    {
        $dados['titulo'] = "Nível";
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('nivel/nivel_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar()
    {
        $id       	    = $this->input->post('txt-id');
        $nm_nivel 	    = $this->input->post('txt-nm_nivel');

        if (!$id){
                $this->form_validation->set_rules('txt-nm_nivel', 'nivel','required|min_length[3]|is_unique[tb_Nivel.nm_nivel]');
        }else{
            $this->form_validation->set_rules('txt-nm_nivel', 'nivel','required|min_length[3]|unique[tb_Nivel.nm_nivel:ci_nivel:'.$id.']');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$id) {
                $this->modelnivel->inserir($nm_nivel);
                $this->novo("success");
            }
            else {
                $this->modelnivel->alterar($id, $nm_nivel);
                $this->editar($id, "success");
            }
        }
    }

    public function editar($id = null, $msg = null)
    {
        $dados['titulo'] = "Nível";
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['niveis']   = $this->modelnivel->buscar($id);


        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('nivel/nivel_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir($id)
    {
        $this->modelnivel->excluir($id);
        $this->index("success");
    }

}