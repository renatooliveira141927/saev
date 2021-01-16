<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Aluno extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('enturmacoes_model', 'modelenturmacao');
    }
    public function getAlunos()
    {        
        $cd_turma  = $this->input->post('cd_turma');        
        echo $this->modelenturmacao->selectAlunoTurma($cd_turma);

    }
    public function getTurmasporAnoletivo()
    {
        $cd_etapa  = $this->input->post('cd_etapa');        
        $cd_escola = $this->input->post('cd_escola');
        $cd_turma  = $this->input->post('cd_turma');
        $nr_anoletivo  = $this->input->post('nr_anoletivo');
        echo $this->modelturma->selectTurmasAno($cd_etapa, $cd_escola, $cd_turma,$nr_anoletivo);

    }
    public function getTurmasEscola()
    {
        $cd_etapa = $this->input->post('cd_etapa');        
        $cd_escola = $this->input->post('cd_escola');
        $cd_turno = $this->input->post('cd_turno');
        $nr_anoletivo =$this->input->post('nr_anoletivo');
        echo $this->modelturma->selectTurmas($cd_etapa, $cd_escola, $cd_turno,$nr_anoletivo);

    }
    
    public function getTurmasAnoLetivo()
    {
        $cd_etapa  = $this->input->post('cd_etapa');
        $cd_escola = $this->input->post('cd_escola');
        $cd_turma  = $this->input->post('cd_turma');
        $nr_ano_letivo=date('Y');
        echo $this->modelturma->selectTurmasAno($cd_etapa, $cd_escola, $cd_turma,$nr_ano_letivo);
        
    }
    public function getTurmasEscolaAnoLetivo()
    {
        $cd_etapa = $this->input->post('cd_etapa');
        $cd_escola = $this->input->post('cd_escola');
        $cd_turno = $this->input->post('cd_turno');
        $nr_ano_letivo=date('Y');
        echo $this->modelturma->selectTurmasAno($cd_etapa, $cd_escola, $cd_turno,$nr_ano_letivo);
        
    }
}