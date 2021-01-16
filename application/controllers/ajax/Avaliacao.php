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
        $nr_anoletivo = $this->input->post('nr_anoletivo');
        echo $this->modelavaliacao->selectAvaliacoes($etapa, $disciplina, $cidade,$nr_anoletivo);

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
        $escola = $this->input->post('cd_escola');
        echo $this->modelavaliacao->selectAvaliacoesDisponiveis($etapa, $disciplina,$escola);
    }

    public function getAvaliacoesLeitura()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        $cd_cidade = $this->input->post('cd_cidade');
        $nr_anoletivo = $this->input->post('nr_anoletivo');
        echo $this->modelavaliacao->selectAvaliacoesLeitura($etapa, $disciplina,$cd_cidade,$nr_anoletivo);        
    }
    
    public function getAvaliacoesLeituraDisponiveis()
    {
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        //echo $this->modelavaliacao->selectAvaliacoesLeitura($etapa, $disciplina);
        echo $this->modelavaliacao->selectAvaliacoesLeituraDisponiveis($etapa, $disciplina);

    }

    public function getAvaliacoesLeituraDisponiveisCidade(){
        $etapa = $this->input->post('cd_etapa');
        $disciplina = $this->input->post('cd_disciplina');
        $cidade  = $this->input->post('cd_cidade');        
        echo $this->modelavaliacao->selectAvaliacoesLeituraDisponiveisCidade($etapa, $disciplina, $cidade);
        
    }
    
    public function getAvaliacoesAno(){
        $ano = $this->input->post('ano');        
        echo $this->modelavaliacao->selectAvaliacoesAno($ano);
    }
    public function getAvaliacoesLeituraAno(){
        $ano = $this->input->post('ano');
        echo $this->modelavaliacao->selectAvaliacoesLeituraAno($ano);
    }

    
    public function getDataAvaliacaoMunicipio(){
        $cd_municipio = $this->input->post('municipio');
        $cd_avaliacao = $this->input->post('avaliacao');
        $result =$this->modelavaliacao->getDataAvaliacaoMunicipio($cd_municipio,$cd_avaliacao);
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));        
    }
}