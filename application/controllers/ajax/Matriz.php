<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Matriz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('matrizes_model', 'modelmatriz');
    }
    public function getMatriz()
    {
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_etapa       = $this->input->post('cd_etapa');
        
        echo $this->modelmatriz->selectMatriz($cd_disciplina, $cd_etapa);

    }

    public function getMatrizes($ds_codigo = null,$cd_matriz = null)
    {        
        $cd_disciplina  = $this->input->post('cd_disciplina');
        $cd_etapa       = $this->input->post('cd_etapa');
        
        echo $this->modelmatriz->select_matriz($cd_disciplina, $cd_etapa,$cd_matriz);
        //echo $this->db->last_query();die;

    }
    
    public function atualizaDescritorCaed()
    {           
        $id=$this->input->post('id');
        $descritorcaed=$this->input->post('descritorcaed');
        echo $this->modelmatriz->atualizadescritorCaed($id, $descritorcaed);
        
    }
}