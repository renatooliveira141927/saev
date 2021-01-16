<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Topicos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('topico_model', 'modeltopico');
    }

    public function getTopicos()
    {
        $cd_avalicao = $this->input->post('cd_avaliacao');     
        echo $this->modeltopico->selectTopicos($cd_avalicao);

    }
    
}