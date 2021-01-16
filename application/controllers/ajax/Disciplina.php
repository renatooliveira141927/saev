<?php
/**
 * Created by PhpStorm.
 * User: Windows
 * Date: 09/10/2018
 * Time: 19:47
 */

class Disciplina extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('disciplina_model', 'modeldisciplina');
    }
    public function getDisciplinas()
    {
        echo $this->modeldisciplina->selectDisciplinas();

    }
}