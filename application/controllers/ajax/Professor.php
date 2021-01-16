<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Professor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('professores_model', 'modelprofessor');
    }
    public function getProfessores()
    {
        $nr_cpf = $this->input->post('nr_cpf');

        if ($nr_cpf && $nr_cpf != '___.___.___-__'){
            echo $this->modelprofessor->get_professor_cpf($nr_cpf);
        }else{
            echo '';
        }
        

    }
}