<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_item_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_avalia_item      = null,
                                    $ds_codigo           = null,
                                    $cd_dificuldade      = null,
                                    $cd_etapa            = null, 
                                    $cd_disciplina       = null, 
                                    $cd_avalia_conteudo  = null, 
                                    $cd_edicao           = null,
                                    $ds_titulo           = null
                                ){

        return count($this->buscar( $ci_avalia_item,
                                    $ds_codigo,
                                    $cd_dificuldade,
                                    $cd_etapa, 
                                    $cd_disciplina, 
                                    $cd_avalia_conteudo, 
                                    $cd_edicao,
                                    $ds_titulo
                                ));
    }

    public function buscar($ci_avalia_item      = null,
                           $ds_codigo           = null,
                           $cd_dificuldade      = null,
                           $cd_etapa            = null, 
                           $cd_disciplina       = null, 
                           $cd_avalia_conteudo  = null, 
                           $cd_edicao           = null,
                           $ds_titulo           = null,
                           $relatorio           = null,
                           $limit               = null,
                           $offset              = null){

        $this->db->select(' tb_avalia_item.ci_avalia_item,
                            tb_avalia_item.ds_codigo,
                            tb_avalia_item.cd_dificuldade,
                            tb_avalia_item.cd_etapa,
                            tb_avalia_item.cd_disciplina,
                            tb_avalia_item.cd_avalia_conteudo,
                            tb_avalia_item.cd_avalia_subconteudo,
                            tb_avalia_item.cd_avalia_origem,
                            tb_avalia_item.cd_edicao,
                            tb_avalia_item.ds_titulo,
                            tb_avalia_item.ds_enunciado,
                            tb_avalia_item.ds_texto_suporte,
                            tb_avalia_item.ds_fonte_texto,
                            tb_avalia_item.tp_questao,
                            tb_avalia_item.ds_comando,
                            tb_avalia_item.ds_primeiro_item,
                            tb_avalia_item.ds_segundo_item,
                            tb_avalia_item.ds_terceiro_item,
                            tb_avalia_item.fl_tipo_itens,
                            tb_avalia_item.ds_img_item_01,
                            tb_avalia_item.ds_img_item_02,
                            tb_avalia_item.ds_img_item_03,
                            tb_avalia_item.ds_img_item_04,
                            tb_avalia_item.ds_quarto_item,
                            tb_avalia_item.ds_img_suporte,
                            tb_avalia_item.ds_fonte_imagem,
                            tb_avalia_item.ds_justificativa_01,
                            tb_avalia_item.ds_justificativa_02,
                            tb_avalia_item.ds_justificativa_03,
                            tb_avalia_item.ds_justificativa_04,
                            tb_avalia_item.nr_alternativa_correta,
                            tb_etapa.nm_etapa,
                            tb_disciplina.nm_disciplina,
                            tb_edicao.nm_edicao,
                            tb_avalia_origem.nm_avalia_origem');
        $this->db->from('tb_avalia_item');

        $this->db->join('tb_etapa', 'tb_avalia_item.cd_etapa = tb_etapa.ci_etapa');
        $this->db->join('tb_disciplina', 'tb_avalia_item.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avalia_item.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_avalia_origem', 'tb_avalia_item.cd_avalia_origem = tb_avalia_origem.ci_avalia_origem');


        $this->db->where('tb_avalia_item.fl_ativo', 'true');

        if ($ci_avalia_item)
        {
            $this->db->where('tb_avalia_item.ci_avalia_item', $ci_avalia_item);
        }
        if ($ds_codigo)
        {            
            $this->db->where("(remove_acentos(ds_codigo) ilike remove_acentos('%".$ds_codigo."%'))");            
        }
        if ($cd_dificuldade)
        {
            $this->db->where('tb_avalia_item.cd_dificuldade', $cd_dificuldade);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avalia_item.cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avalia_item.cd_disciplina', $cd_disciplina);
        }
        if ($cd_avalia_conteudo)
        {
            $this->db->where('tb_avalia_item.cd_avalia_conteudo', $cd_avalia_conteudo);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avalia_item.cd_edicao', $cd_edicao);
        }
        if ($ds_titulo)
        {
            $this->db->where("(remove_acentos(ds_titulo) ilike remove_acentos('%".$ds_titulo."%'))");
        }
        $this->db->order_by('tb_avalia_item.cd_disciplina', 'ASC');

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

    public function get_consulta_excel( $ci_avalia_item      = null,
                                        $ds_codigo           = null,
                                        $cd_dificuldade      = null,
                                        $cd_etapa            = null, 
                                        $cd_disciplina       = null, 
                                        $cd_avalia_conteudo  = null, 
                                        $cd_edicao           = null,
                                        $ds_titulo           = null
                                    ){
        $this->db->select(' tb_avalia_item.ds_codigo as "Código",
                            tb_avalia_item.ds_titulo as "Titulo",
                            tb_avalia_item.ds_enunciado as "Enunciado",
                            tb_avalia_item.ds_comando as "Comando",
                            tb_avalia_item.ds_primeiro_item as "Alternativa 01",
                            tb_avalia_item.ds_segundo_item as "Alternativa 02",
                            tb_avalia_item.ds_terceiro_item as "Alternativa 03",
                            tb_avalia_item.ds_quarto_item as "Alternatnriva 04",
                            tb_avalia_item.nr_alternativa_correta as "Nr alternativa Correta",
                            tb_avalia_item.fl_tipo_itens,
                            tb_avalia_item.ds_img_item_01,
                            tb_avalia_item.ds_img_item_02,
                            tb_avalia_item.ds_img_item_03,
                            tb_avalia_item.ds_img_item_04,
                            tb_etapa.nm_etapa as "Etapa",
                            tb_disciplina.nm_disciplina as "Disciplina",
                            tb_edicao.nm_edicao as "Edição",
                            tb_avalia_origem.nm_avalia_origem as "Origem"');
        $this->db->from('tb_avalia_item');

        $this->db->join('tb_etapa', 'tb_avalia_item.cd_etapa = tb_etapa.ci_etapa');
        $this->db->join('tb_disciplina', 'tb_avalia_item.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avalia_item.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_avalia_origem', 'tb_avalia_item.cd_avalia_origem = tb_avalia_origem.ci_avalia_origem');


        $this->db->where('tb_avalia_item.fl_ativo', 'true');

        if ($ci_avalia_item)
        {
            $this->db->where('tb_avalia_item.ci_avalia_item', $ci_avalia_item);
        }
        if ($ds_codigo)
        {
            $this->db->where("(remove_acentos(ds_codigo) ilike remove_acentos('%".$ds_codigo."%'))");
        }
        if ($cd_dificuldade)
        {
            $this->db->where('tb_avalia_item.cd_dificuldade', $cd_dificuldade);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avalia_item.cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avalia_item.cd_disciplina', $cd_disciplina);
        }
        if ($cd_avalia_conteudo)
        {
            $this->db->where('tb_avalia_item.cd_avalia_conteudo', $cd_avalia_conteudo);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avalia_item.cd_edicao', $cd_edicao);
        }
        if ($ds_titulo)
        {
            $this->db->where("(remove_acentos(ds_titulo) ilike remove_acentos('%".$ds_titulo."%'))");
        }
        $this->db->order_by('tb_avalia_item.cd_disciplina', 'ASC');
                                    
        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_avalia_item      = null,
                                        $ds_codigo           = null,
                                        $cd_dificuldade      = null,
                                        $cd_etapa            = null, 
                                        $cd_disciplina       = null, 
                                        $cd_avalia_conteudo  = null, 
                                        $cd_edicao           = null,
                                        $ds_titulo           = null
){

        $this->db->from('vw_avalia_itens ');


        if ($ci_avalia_item)
        {
            $this->db->where('ci_avalia_item', $ci_avalia_item);
        }
        if ($ds_codigo)
        {
            $this->db->where("(remove_acentos(ds_codigo) ilike remove_acentos('%".$ds_codigo."%'))");
        }
        
        if ($cd_dificuldade)
        {
            $this->db->where('cd_dificuldade', $cd_dificuldade);
        }
        if ($cd_etapa)
        {
            $this->db->where('cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('cd_disciplina', $cd_disciplina);
        }
        if ($cd_avalia_conteudo)
        {
            $this->db->where('cd_avalia_conteudo', $cd_avalia_conteudo);
        }
        if ($cd_edicao)
        {
            $this->db->where('cd_edicao', $cd_edicao);
        }
        if ($ds_titulo)
        {
            $this->db->where("(remove_acentos(ds_titulo) ilike remove_acentos('%".$ds_titulo."%'))");
        }
        $this->db->order_by('cd_disciplina', 'ASC');

        //echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get()->result();
    }
    public function get_itens_avaliacao_pdf($cd_avaliacao = null){

        $this->db->from('vw_avalia_itens ');
        $this->db->join('tb_Avaliacao_Itens', 'tb_Avaliacao_Itens.cd_avalia_item = vw_avalia_itens.ci_avalia_item');
        

        if ($cd_avaliacao)
        {
            $this->db->where('tb_Avaliacao_Itens.cd_avaliacao', $cd_avaliacao);
        }

        //echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get()->result();
    }
    public function excluir($ci_avalia_item)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avalia_item', $ci_avalia_item);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_avalia_item', $dados);
    }

    public function inserir(    $ci_avalia_item      = null,
                                $ds_codigo           = null,
                                $cd_dificuldade      = null,
                                $cd_etapa            = null, 
                                $cd_disciplina       = null, 
                                $cd_avalia_conteudo  = null, 
                                $cd_avalia_subconteudo = null,
                                $cd_avalia_origem    = null,
                                $cd_edicao           = null,
                                $ds_titulo           = null,
                                $ds_enunciado        = null,
                                $tp_questao          = null,
                                $ds_comando          = null,
                                $ds_primeiro_item    = null,
                                $ds_segundo_item     = null,
                                $ds_terceiro_item    = null,
                                $ds_quarto_item      = null,
                                $ds_img_suporte      = null,
                                $ds_fonte_imagem     = null,
                                $nr_alternativa_correta = null,
                                $ds_justificativa_01 = null,
                                $ds_justificativa_02 = null,
                                $ds_justificativa_03 = null,
                                $ds_justificativa_04 = null,
                                $fl_tipo_itens       = null,
                                $ds_img_item_01      = null,
                                $ds_img_item_02      = null,
                                $ds_img_item_03      = null,
                                $ds_img_item_04      = null,
                                $ds_texto_suporte    = null,
                                $ds_fonte_texto      = null
                            ){

        $this->db->from('tb_avalia_item');
        $this->db->where('fl_ativo', 'true');

        if ($ds_titulo)
        {
            $this->db->where('ds_codigo', mb_strtoupper($ds_codigo, 'UTF-8'));
        }

        if (!($this->db->get()->num_rows() > 0)){

            $dados['cd_dificuldade']        = $cd_dificuldade;
            $dados['ds_codigo']             = mb_strtoupper($ds_codigo, 'UTF-8');
            $dados['cd_etapa']              = $cd_etapa;
            $dados['cd_disciplina']         = $cd_disciplina;
            $dados['cd_avalia_conteudo']    = $cd_avalia_conteudo;
            $dados['cd_avalia_subconteudo'] = $cd_avalia_subconteudo;
            $dados['cd_avalia_origem']      = $cd_avalia_origem;
            $dados['cd_edicao']             = $cd_edicao;
            $dados['ds_titulo']             = $ds_titulo;
            $dados['ds_enunciado']          = $ds_enunciado;
            $dados['tp_questao']            = $tp_questao;
            $dados['ds_comando']            = $ds_comando;
            $dados['ds_primeiro_item']      = $ds_primeiro_item;
            $dados['ds_segundo_item']       = $ds_segundo_item;
            $dados['ds_terceiro_item']      = $ds_terceiro_item;
            $dados['ds_quarto_item']        = $ds_quarto_item;
            $dados['ds_img_suporte']        = $ds_img_suporte;
            $dados['ds_fonte_imagem']       = $ds_fonte_imagem;
            $dados['nr_alternativa_correta']= $nr_alternativa_correta;
            $dados['ds_justificativa_01']   = $ds_justificativa_01;
            $dados['ds_justificativa_02']   = $ds_justificativa_02;
            $dados['ds_justificativa_03']   = $ds_justificativa_03;
            $dados['ds_justificativa_04']   = $ds_justificativa_04;
            $dados['fl_tipo_itens']         = $fl_tipo_itens;
            $dados['ds_img_item_01']        = $ds_img_item_01;
            $dados['ds_img_item_02']        = $ds_img_item_02;
            $dados['ds_img_item_03']        = $ds_img_item_03;
            $dados['ds_img_item_04']        = $ds_img_item_04;
            $dados['ds_texto_suporte']      = $ds_texto_suporte;
            $dados['ds_fonte_texto']        = $ds_fonte_texto;

            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_item', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar(    $id                  = null,
                                $ds_codigo           = null,
                                $cd_dificuldade      = null,
                                $cd_etapa            = null, 
                                $cd_disciplina       = null, 
                                $cd_avalia_conteudo  = null, 
                                $cd_avalia_subconteudo = null,
                                $cd_avalia_origem    = null,
                                $cd_edicao           = null,
                                $ds_titulo           = null,
                                $ds_enunciado        = null,
                                $tp_questao          = null,
                                $ds_comando          = null,
                                $ds_primeiro_item    = null,
                                $ds_segundo_item     = null,
                                $ds_terceiro_item    = null,
                                $ds_quarto_item      = null,
                                $ds_img_suporte      = null,
                                $ds_fonte_imagem     = null,
                                $nr_alternativa_correta = null,
                                $ds_justificativa_01 = null,
                                $ds_justificativa_02 = null,
                                $ds_justificativa_03 = null,
                                $ds_justificativa_04 = null,
                                $fl_tipo_itens       = null,
                                $ds_img_item_01      = null,
                                $ds_img_item_02      = null,
                                $ds_img_item_03      = null,
                                $ds_img_item_04      = null,
                                $ds_texto_suporte    = null,
                                $ds_fonte_texto      = null){
        $this->db->from('tb_avalia_item');
        $this->db->where('ds_codigo', mb_strtoupper($ds_codigo, 'UTF-8'));
        $this->db->where('ci_avalia_item <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['ds_codigo']             = mb_strtoupper($ds_codigo, 'UTF-8');
            $dados['cd_dificuldade']        = $cd_dificuldade;
            $dados['cd_etapa']              = $cd_etapa;
            $dados['cd_disciplina']         = $cd_disciplina;
            $dados['cd_avalia_conteudo']    = $cd_avalia_conteudo;
            $dados['cd_avalia_subconteudo'] = $cd_avalia_subconteudo;
            $dados['cd_avalia_origem']      = $cd_avalia_origem;
            $dados['cd_edicao']             = $cd_edicao;
            $dados['ds_titulo']             = $ds_titulo;
            $dados['ds_enunciado']          = $ds_enunciado;
            $dados['tp_questao']            = $tp_questao;
            $dados['ds_comando']            = $ds_comando;
            $dados['ds_primeiro_item']      = $ds_primeiro_item;
            $dados['ds_segundo_item']       = $ds_segundo_item;
            $dados['ds_terceiro_item']      = $ds_terceiro_item;
            $dados['ds_quarto_item']        = $ds_quarto_item;
            $dados['ds_img_suporte']        = $ds_img_suporte;
            $dados['ds_fonte_imagem']       = $ds_fonte_imagem;
            $dados['nr_alternativa_correta']= $nr_alternativa_correta;
            $dados['ds_justificativa_01']   = $ds_justificativa_01;
            $dados['ds_justificativa_02']   = $ds_justificativa_02;
            $dados['ds_justificativa_03']   = $ds_justificativa_03;
            $dados['ds_justificativa_04']   = $ds_justificativa_04;
            $dados['fl_tipo_itens']         = $fl_tipo_itens;
            $dados['ds_img_item_01']        = $ds_img_item_01;
            $dados['ds_img_item_02']        = $ds_img_item_02;
            $dados['ds_img_item_03']        = $ds_img_item_03;
            $dados['ds_img_item_04']        = $ds_img_item_04;
            $dados['ds_texto_suporte']      = $ds_texto_suporte;
            $dados['ds_fonte_texto']        = $ds_fonte_texto;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_item', $id);
            return $this->db->update('tb_avalia_item', $dados);
//            return true;
        }else{
            return false;
        }

    }
    public function get_id( $cd_dificuldade     = null, 
                            $ds_codigo          = null,
                            $cd_etapa           = null, 
                            $cd_disciplina      = null, 
                            $cd_avalia_conteudo = null, 
                            $cd_edicao          = null, 
                            $ds_titulo          = null){
        $this->db->select('ci_avalia_item');
        $this->db->from('tb_avalia_item');

        $this->db->where('cd_dificuldade'       , $cd_dificuldade);
        $this->db->where('cd_etapa'             , $cd_etapa);
        $this->db->where('upper(ds_codigo)', mb_strtoupper($ds_codigo, 'UTF-8'));
        $this->db->where('cd_disciplina'        , $cd_disciplina);
        $this->db->where('cd_avalia_conteudo'   , $cd_avalia_conteudo);
        $this->db->where('cd_edicao'            , $cd_edicao);
        $this->db->where('upper(ds_titulo)', mb_strtoupper($ds_titulo, 'UTF-8'));

        $id = "";                        
        $resultados = $this->db->get()->result();
        foreach ($resultados as $result){
            $id = $result->ci_avalia_item;
        }
        return $id; 
    }

    public function grava_img_db($id, $nm_campo, $nm_img){
        $dados[$nm_campo]   = $nm_img;
        $this->db->where('ci_avalia_item', $id);
        return $this->db->update('tb_avalia_item', $dados);
    }
}