<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Cidade extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cidade_model', 'modelcidade');
    }
    public function getCidades($nm_cidade = null, $sg_estado = null)
    {
        // echo $nm_cidade;
        // echo $sg_estado;
        $id_estado = $this->input->post('id_estado');
        $nm_cidade = $this->input->post('nm_cidade');
        $sg_estado = $this->input->post('sg_estado');
        $exibir_cabecario   = $this->input->post('exibir_cabecario');
        
        echo $this->modelcidade->selectCidade($id_estado, $nm_cidade, $sg_estado, $exibir_cabecario);

    }
}