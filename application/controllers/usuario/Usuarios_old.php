<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model','modelusuarios');

	}
	public function index()
	{
		$this->load->library('table');

		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}
		
		$dados['usuarios'] = $this->modelusuarios->listar_autores();

		$dados['titulo'] = 'Peinel de Controle';
		$dados['subtitulo'] = 'Usuários';


        $this->load->view('template/html-header');
        $this->load->view('template/template', $dados);
        $this->load->view('usuario/usuario');
        $this->load->view('template/html-footer');

	}

	public function inserir()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt-nome', 'Nome do  Usuário','required|min_length[3]');
		$this->form_validation->set_rules('txt-email', 'Email','required|valid_email');
		$this->form_validation->set_rules('txt-cpf', 'CPF','required|valid_cpf');
        $this->form_validation->set_rules('txt-telefone', 'Telefone','required|valid_phone');
		$this->form_validation->set_rules('txt-user', 'User','required|min_length[3]');
		$this->form_validation->set_rules('txt-senha', 'Senha','required|min_length[3]');
		$this->form_validation->set_rules('txt-confir-senha', 'Confirmar Senha','required|matches[txt-senha]');

		if ($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else{

            $nm_usuario 	= $this->input->post('txt-nome');
            $ds_email 		= $this->input->post('txt-email');
            $nr_cpf 	    = $this->input->post('txt-cpf');
            $ds_telefone	= $this->input->post('txt-telefone');
            $nm_login 		= $this->input->post('txt-user');
            $ds_senha 		= $this->input->post('txt-senha');

			if($this->modelusuarios->adicionar($nm_usuario, $nm_login, $nr_cpf, $ds_telefone, $ds_email, $ds_senha)){
				redirect(base_url('usuario/usuarios'));
			}
			else{
				echo "Houve um erro no sistema!";
			}
		}
	}

	public function excluir($id)
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}
			if($this->modelusuarios->excluir($id)){
				redirect(base_url('usuarios'));
			}
			else{
				echo "Houve um erro no sistema!";
			}
	}	

	public function alterar($id)
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}

		$dados['usuarios'] = $this->modelusuarios->listar_usuario($id);

		// Dados a serem enviados ao cabeçalho

		$dados['titulo'] = 'Peinel de Controle';
		$dados['subtitulo'] = 'Usuarios';


        $this->load->view('template/html-header');
        $this->load->view('template/template', $dados);
        $this->load->view('usuario/alterar-usuario');
        $this->load->view('template/html-footer');

	}

	public function salvar_alteracoes(){
		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}

        $id = $this->input->post('txt-id');

		$this->load->library('form_validation');

        $this->form_validation->set_rules('txt-nome', 'Nome do  Usuário','required|min_length[3]');
        $this->form_validation->set_rules('txt-email', 'Email','required|valid_email');
        $this->form_validation->set_rules('txt-cpf', 'CPF','required|valid_cpf');
        $this->form_validation->set_rules('txt-telefone', 'Telefone','required|valid_phone');

        $this->form_validation->set_rules('txt-user', 'User','required|min_length[3]|unique[tb_Usuario.nm_login:ci_usuario:'.$id.']');
        $this->form_validation->set_rules('txt-senha', 'Senha','required|min_length[3]');
        $this->form_validation->set_rules('txt-confir-senha', 'Confirmar Senha','required|matches[txt-senha]');



		if ($this->form_validation->run() == FALSE)
		{
			$this->alterar($id);
		}
		else{


            $nm_usuario 	= $this->input->post('txt-nome');
            $ds_email 		= $this->input->post('txt-email');
            $nr_cpf 	    = $this->input->post('txt-cpf');
            $ds_telefone	= $this->input->post('txt-telefone');
            $nm_login 		= $this->input->post('txt-user');
            $ds_senha 		= $this->input->post('txt-senha');


			if($this->modelusuarios->alterar($id, $nm_usuario, $nm_login, $nr_cpf, $ds_telefone, $ds_email, $ds_senha)){
				redirect(base_url('usuarios'));
			}
			else{
				echo "Houve um erro no sistema!";
			}
		}
	}

	public function nova_foto()
	{
		if(!$this->session->userdata('logado')){
			redirect(base_url('login'));
		}

		$id = $this->input->post('id');
		$config['upload_path'] = './assets/frontend/img/usuarios';
		$config['allowed_types'] = 'jpg';
		$config['file_name'] = $id.'.jpg';
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);

		if(!$this->upload->do_upload()){
			echo $this->upload->display_errors();
		}else{
			$config2['source_image'] = './assets/frontend/img/usuarios/'.$id.'.jpg';
			$config2['create_tumb']  = FALSE;
			$config2['width']   = 200;
			$config2['height']  = 200;
			$this->load->library('image_lib',$config2);

			if(!$this->image_lib->resize()){
				echo $this->upload->display_errors();				
			}else{

				if($this->modelusuarios->alterar_img($id)){
					redirect(base_url('usuario/usuarios/alterar/'.$id));
				}
				else{
					echo "Houve um erro no sistema!";
				}
				
			}
		}

	}



}
