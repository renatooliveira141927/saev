<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();

        if(!$this->session->userdata('logado')){
            redirect(base_url('usuario/autenticacoes/login'));
        }

	}
	public function index()
	{
		$this->load->view('template/html-header');
		$this->load->view('template/template');
		$this->load->view('template/html-footer');
	}


}
