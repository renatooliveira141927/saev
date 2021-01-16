<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Estado extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('estado_model', 'modelestado');
    }
    public function getEstados($sg_estado = null)
    {
        // echo $sg_estado;
        $id_estado = $this->input->post('id_estado');
        $sg_estado = $this->input->post('sg_estado');
        echo $this->modelestado->selectEstados($id_estado, $sg_estado);

    }
}