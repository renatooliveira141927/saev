<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Etapa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('etapas_model', 'modeletapa');
    }
    public function getEtapaEdicaoDisciplina()
    {
        $cd_edicao       = $this->input->post('cd_edicao');
        $cd_disciplina  = $this->input->post('cd_disciplina');
        
        echo $this->modeletapa->selectEtapaEdicaoDisciplina($cd_disciplina, $cd_edicao);
        
    }
}