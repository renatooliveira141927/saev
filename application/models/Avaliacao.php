<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Unidades
 * Função Ajax para popular as combo de Cidades
 */
class Avaliacao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('avaliacao_model', 'modelavaliacao');
    }

    public function getAvaliacoes()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        $cidade = $this->input->post('cd_cidade');
        echo $this->modelavaliacao->selectAvaliacoes($etapa, $disciplina, $cidade);

    }
    
    public function getAvaliacoesEscola()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        $escola = $this->input->post('cd_escola');
        echo $this->modelavaliacao->selectAvaliacoesEscola($etapa, $disciplina, $escola);
        
    }

    public function getAvaliacoesDisponiveis(){
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        echo $this->modelavaliacao->selectAvaliacoesDisponiveis($etapa, $disciplina);
    }

    public function getAvaliacoesLeitura()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        echo $this->modelavaliacao->selectAvaliacoesLeitura($etapa, $disciplina);

    }
    public function getAvaliacoesLeituraDisponiveis()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        echo $this->modelavaliacao->selectAvaliacoesLeitura($etapa, $disciplina);
        //echo $this->modelavaliacao->selectAvaliacoesLeituraDisponiveis($etapa, $disciplina);

    }



}