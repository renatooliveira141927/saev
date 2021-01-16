<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Escola extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('escolas_model', 'modelescola');

    }

    public function getEscolas($cd_cidade = null, $nr_inep = null)
    {
        // echo $nm_cidade;
        // echo $sg_estado;
        $cd_cidade  = $this->input->post('cd_cidade');
        $nr_inep    = $this->input->post('nr_inep');
        echo $this->modelescola->selectEscola($cd_cidade, $nr_inep);

    }
    public function getEscolaListaOpcoes()
    {
        $nm_escola  = $this->input->post('nm_escola');
        $nr_inep    = $this->input->post('nr_inep');
        $ci_escola  = $this->input->post('ci_escola');
        
        echo $this->modelescola->selectEscola($cd_cidade, $nr_inep);

    }

    public function getEscolaInep(){
        $nr_inep    = $this->input->post('nr_inep');

        echo $this->modelescola->consulta_escola_inep($nr_inep);
    }
    
}