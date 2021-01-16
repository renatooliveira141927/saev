<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_turmas_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_Avaliacao       = null, 
                                    $nm_caderno         = null, 
                                    $cd_avalia_tipo     = null, 
                                    $nr_ano             = null, 
                                    $cd_disciplina      = null, 
                                    $cd_edicao          = null,
                                    $cd_etapa           = null,
                                    $fl_avalia_nominal  = null,
                                    $fl_sortear_itens   = null
                                ){

        return count($this->buscar( $ci_Avaliacao, 
                                    $nm_caderno, 
                                    $cd_avalia_tipo, 
                                    $nr_ano, 
                                    $cd_disciplina, 
                                    $cd_edicao,
                                    $cd_etapa
                                ));
    }

    public function buscar($ci_avaliacao        = null, 
                            $nm_caderno         = null, 
                            $cd_avalia_tipo     = null, 
                            $nr_ano             = null, 
                            $cd_disciplina      = null, 
                            $cd_edicao          = null,
                            $cd_etapa           = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_avaliacao.ci_avaliacao,
                            tb_avaliacao.nm_caderno,
                            tb_avaliacao.cd_avalia_tipo,
                            tb_avaliacao.cd_disciplina,
                            tb_avaliacao.cd_edicao,
                            tb_avaliacao.cd_etapa,
                            tb_avaliacao.fl_avalia_nominal,
                            tb_avaliacao.fl_sortear_itens,
                            tb_avaliacao.ds_texto_abertura,
                            tb_avaliacao.nr_ano,
                            tb_disciplina.nm_disciplina,
                            tb_avalia_tipo.nm_avalia_tipo,
                            tb_edicao.nm_edicao,
                            tb_etapa.nm_etapa');
        $this->db->from('tb_avaliacao');

        $this->db->join('tb_avalia_tipo', 'tb_avaliacao.cd_avalia_tipo = tb_avalia_tipo.ci_avalia_tipo');
        $this->db->join('tb_disciplina', 'tb_avaliacao.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avaliacao.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_etapa', 'tb_avaliacao.cd_etapa = tb_etapa.ci_etapa');


        $this->db->where('tb_avaliacao.fl_ativo', 'true');

        if ($ci_avaliacao)
        {
            $this->db->where('tb_avaliacao.ci_avaliacao', $ci_avaliacao);
        }
        if ($nm_caderno)
        {
            $this->db->where('tb_avaliacao.nm_caderno', mb_strtoupper($nm_caderno, 'UTF-8'));
        }
        if ($cd_avalia_tipo)
        {
            $this->db->where('tb_avaliacao.cd_avalia_tipo', $cd_avalia_tipo);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avaliacao.cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avaliacao.cd_disciplina', $cd_disciplina);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avaliacao.cd_edicao', $cd_edicao);
        }
        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }

        //$this->db->last_query(); //Exibeo comando SQL
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }

    public function get_consulta_excel( $ci_Avaliacao   = null, 
                                        $nm_caderno     = null, 
                                        $cd_avalia_tipo = null, 
                                        $nr_ano         = null, 
                                        $cd_disciplina  = null, 
                                        $cd_edicao      = null,
                                        $cd_etapa       = null
                                    ){
        $this->db->select(' tb_avaliacao.nm_caderno as "Caderno",
                            tb_avaliacao.nr_ano as "Ano",
                            tb_disciplina.nm_disciplina as "Disciplina",
                            tb_avalia_tipo.nm_avalia_tipo as "Tipo de avaliação",
                            tb_edicao.nm_edicao as "Edição",
                            tb_etapa.nm_etapa as "Etapa"');
        $this->db->from('tb_avaliacao');

        $this->db->join('tb_avalia_tipo', 'tb_avaliacao.cd_avalia_tipo = tb_avalia_tipo.ci_avalia_tipo');
        $this->db->join('tb_disciplina', 'tb_avaliacao.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avaliacao.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_etapa', 'tb_avaliacao.cd_etapa = tb_etapa.ci_etapa');

        $this->db->where('tb_avaliacao.fl_ativo', 'true');

        if ($ci_avaliacao)
        {
            $this->db->where('tb_avaliacao.ci_avaliacao', $ci_avaliacao);
        }
        if ($cd_avalia_tipo)
        {
            $this->db->where('tb_avaliacao.cd_avalia_tipo', $cd_avalia_tipo);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avaliacao.cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avaliacao.cd_disciplina', $cd_disciplina);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avaliacao.cd_edicao', $cd_edicao);
        }
        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');
                                    
        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_Avaliacao   = null, 
                                        $nm_caderno     = null, 
                                        $cd_avalia_tipo = null, 
                                        $nr_ano         = null, 
                                        $cd_disciplina  = null, 
                                        $cd_edicao      = null,
                                        $cd_etapa       = null){

        
        $this->db->select(' tb_avaliacao.nm_caderno as "Caderno",
                            tb_avaliacao.nr_ano as "Ano",
                            tb_disciplina.nm_disciplina as "Disciplina",
                            tb_avalia_tipo.nm_avalia_tipo as "Tipo de avaliação",
                            tb_edicao.nm_edicao as "Edição",
                            tb_etapa.nm_etapa as "Etapa"');
        $this->db->from('tb_avaliacao');

        $this->db->join('tb_avalia_tipo', 'tb_avaliacao.cd_avalia_tipo = tb_avalia_tipo.ci_avalia_tipo');
        $this->db->join('tb_disciplina', 'tb_avaliacao.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avaliacao.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_etapa', 'tb_avaliacao.cd_etapa = tb_etapa.ci_etapa');

        $this->db->where('tb_avaliacao.fl_ativo', 'true');

        if ($ci_avaliacao)
        {
            $this->db->where('tb_avaliacao.ci_avaliacao', $ci_avaliacao);
        }
        if ($cd_avalia_tipo)
        {
            $this->db->where('tb_avaliacao.cd_avalia_tipo', $cd_avalia_tipo);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avaliacao.cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avaliacao.cd_disciplina', $cd_disciplina);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avaliacao.cd_edicao', $cd_edicao);
        }
        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');        //echo $this->db->last_query(); //Exibeo comando SQL
 
        return $this->db->get()->result();
    }
    public function excluir($ci_avaliacao)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avaliacao', $ci_avaliacao);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_avaliacao', $dados);
    }

    public function inserir($nm_caderno         = null, 
                            $cd_avalia_tipo     = null, 
                            $nr_ano             = null, 
                            $cd_disciplina      = null, 
                            $cd_edicao          = null,
                            $cd_etapa           = null,  
                            $ds_texto_abertura  = null,
                            $fl_avalia_nominal  = null,
                            $fl_sortear_itens   = null
                            ){

        $this->db->from('tb_avaliacao');
        $this->db->where('fl_ativo', 'true');

        if ($nm_caderno)
        {
            $this->db->where('nm_caderno', mb_strtoupper($nm_caderno, 'UTF-8'));
        }

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_caderno']        = $nm_caderno;            
            $dados['cd_avalia_tipo']    = $cd_avalia_tipo;
            $dados['nr_ano']            = $nr_ano;
            $dados['cd_disciplina']     = $cd_disciplina;
            $dados['cd_edicao']         = $cd_edicao;
            $dados['cd_etapa']          = $cd_etapa;
            $dados['ds_texto_abertura'] = mb_strtoupper($ds_texto_abertura, 'UTF-8');
            $dados['fl_avalia_nominal'] = $fl_avalia_nominal;
            $dados['fl_sortear_itens']  = $fl_sortear_itens;

            $dados['cd_usuario_cad']    = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avaliacao', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_avaliacao       = null, 
                            $nm_caderno         = null, 
                            $cd_avalia_tipo     = null, 
                            $nr_ano             = null, 
                            $cd_disciplina      = null, 
                            $cd_edicao          = null,
                            $cd_etapa           = null,  
                            $ds_texto_abertura  = null,
                            $fl_avalia_nominal  = null,
                            $fl_sortear_itens   = null){
        $this->db->from('tb_avaliacao');

        $this->db->where('nm_caderno', mb_strtoupper($nm_caderno, 'UTF-8'));
        $this->db->where('ci_avaliacao <>', $ci_avaliacao);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_caderno']        = $nm_caderno;            
            $dados['cd_avalia_tipo']    = $cd_avalia_tipo;
            $dados['nr_ano']            = $nr_ano;
            $dados['cd_disciplina']     = $cd_disciplina;
            $dados['cd_edicao']         = $cd_edicao;
            $dados['cd_etapa']          = $cd_etapa;
            $dados['ds_texto_abertura'] = mb_strtoupper($ds_texto_abertura, 'UTF-8');
            $dados['fl_avalia_nominal'] = $fl_avalia_nominal;
            $dados['fl_sortear_itens']  = $fl_sortear_itens;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avaliacao', $ci_avaliacao);
            return $this->db->update('tb_avaliacao', $dados);
//            return true;
        }else{
            return false;
        }

    }
}