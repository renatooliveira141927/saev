<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avaliacao_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar_itens_montar(  $ds_codigo      = null, 
                                                $cd_dificuldade = null,
                                                $cd_disciplina  = null
                                ){

        return count($this->buscar_itens_montar($ds_codigo      = null, 
                                                $cd_dificuldade = null,
                                                $cd_disciplina  = null
                                                ));
    }

    public function buscar_itens_montar($ds_codigo      = null, 
                                        $cd_dificuldade = null,
                                        $cd_disciplina  = null,
                                        $relatorio      = null,
                                        $limit          = null,
                                        $offset         = null){

        $this->db->select(' tb_avaliacao.ci_avaliacao,
                            tb_avalia_item.ci_avalia_item,
                            tb_avalia_item.ds_codigo,
                            tb_avalia_item.ds_titulo,
                            tb_disciplina.nm_disciplina,
                            tb_edicao.nm_edicao');
        $this->db->from('tb_avaliacao_itens');

        $this->db->join('tb_avaliacao', 'tb_avaliacao_itens.cd_avaliacao = tb_avaliacao.ci_avaliacao', 'right');
        $this->db->join('tb_avalia_item', 'tb_avaliacao_itens.cd_avalia_item = tb_avalia_item.ci_avalia_item', 'right');

        $this->db->join('tb_disciplina', 'tb_avalia_item.cd_disciplina = tb_disciplina.ci_disciplina');
        $this->db->join('tb_edicao', 'tb_avalia_item.cd_edicao = tb_edicao.ci_edicao');

        if ($ds_codigo)
        {
            $this->db->where('tb_avalia_item.ds_codigo', mb_strtoupper($ds_codigo, 'UTF-8'));
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avaliacao.cd_disciplina', $cd_disciplina);
        }
        if ($cd_dificuldade)
        {
            $this->db->where('tb_avalia_item.cd_dificuldade', $cd_dificuldade);
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
    public function buscar_avaliacao_itens($ci_avaliacao = null,$cd_aluno = null){
        $this->db->select(' educarpravaler.tb_Avalia_item.ci_avalia_item,
                            educarpravaler.tb_Avalia_item.ds_codigo,
                            educarpravaler.tb_Avalia_item.ds_titulo,
                            educarpravaler.tb_Avaliacao_aluno.cd_aluno,
                            educarpravaler.tb_Avaliacao_aluno.cd_avaliacao_itens,
                            educarpravaler.tb_Avaliacao_aluno.nr_alternativa_escolhida');

        $this->db->from('educarpravaler.tb_Avaliacao_Itens');
        $this->db->join('educarpravaler.tb_Avalia_item', 'educarpravaler.tb_Avaliacao_Itens.cd_avalia_item = educarpravaler.tb_Avalia_item.ci_avalia_item');
        $this->db->join('educarpravaler.tb_Avaliacao_aluno','educarpravaler.tb_Avaliacao_Itens.cd_avalia_item = educarpravaler.tb_Avaliacao_aluno.cd_avaliacao_itens','left');
        $this->db->where('educarpravaler.tb_Avalia_item.fl_ativo', 'true');
        $this->db->where('educarpravaler.tb_Avaliacao_Itens.cd_avaliacao', $ci_avaliacao);

        $this->db->order_by('educarpravaler.tb_Avalia_item.ci_avalia_item', 'ASC');

        return $this->db->get()->result();
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
                                    
        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_avaliacao   = null, 
                                        $nm_caderno     = null, 
                                        $cd_avalia_tipo = null, 
                                        $nr_ano         = null, 
                                        $cd_disciplina  = null, 
                                        $cd_edicao      = null,
                                        $cd_etapa       = null){

        
        $this->db->select(' ci_avaliacao,
                            nm_caderno,
                            nr_ano,
                            nm_disciplina,
                            nm_avalia_tipo,
                            nm_etapa, 
                            ds_texto_abertura');
        $this->db->from('vw_avalia_capa');

        if ($ci_avaliacao)
        {
            $this->db->where('ci_avaliacao', $ci_avaliacao);
        }
        if ($nm_caderno)
        {
            $this->db->where('upper(nm_caderno)', mb_strtoupper($nm_caderno, 'UTF-8'));
        }
        if ($cd_avalia_tipo)
        {
            $this->db->where('cd_avalia_tipo', $cd_avalia_tipo);
        }
        if ($cd_etapa)
        {
            $this->db->where('cd_etapa', $cd_etapa);
        }
        if ($cd_disciplina)
        {
            $this->db->where('cd_disciplina', $cd_disciplina);
        }
        if ($cd_edicao)
        {
            $this->db->where('cd_edicao', $cd_edicao);
        }
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
                            $fl_sortear_itens   = null,
                            $arr_ci_avalia_item = null
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
            $dados['ds_texto_abertura'] = $ds_texto_abertura;
            $dados['fl_avalia_nominal'] = $fl_avalia_nominal;
            $dados['fl_sortear_itens']  = $fl_sortear_itens;

            $dados['cd_usuario_cad']    = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avaliacao', $dados);

        // Inicio - Inserir Itens da avaliação
            if (isset($arr_ci_avalia_item)) {
                // Inicio - Verifica o id da Avaliação    
                $this->db->select('ci_avaliacao');
                $this->db->from('tb_avaliacao');
                $this->db->where('UPPER(nm_caderno)', mb_strtoupper($nm_caderno, 'UTF-8'));
                $this->db->where('fl_ativo', 'true');
                $result = $this->db->get()->result();

                foreach ($result as $i => $row) {
                    $ci_avaliacao = $row ->ci_avaliacao;
                }
                // Fim - Verifica o id do avaliacao                
            
                foreach ($arr_ci_avalia_item as $i => $value) {
                    $dados_avalia_item['cd_avalia_item']    = $value;
                    $dados_avalia_item['cd_avaliacao']     = $ci_avaliacao;
                    $this->db->insert('tb_avaliacao_itens', $dados_avalia_item);
                } 
               
            }
            // Fim - Inserir Itens da avaliação 

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
                            $fl_sortear_itens   = null, 
                            $arr_ci_avalia_item = null){
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
            $dados['ds_texto_abertura'] = $ds_texto_abertura;
            $dados['fl_avalia_nominal'] = $fl_avalia_nominal;
            $dados['fl_sortear_itens']  = $fl_sortear_itens;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avaliacao', $ci_avaliacao);
            $this->db->update('tb_avaliacao', $dados);

        // Inicio - Apagar itens de avaliação anteriores
        $this->db->where('cd_avaliacao', $ci_avaliacao);
        $this->db->delete('tb_avaliacao_itens');
        // Fim - Apagar itens de avaliação anteriores

        // Inicio - Inserir Itens da avaliação
        if (isset($arr_ci_avalia_item)) {             
        
            foreach ($arr_ci_avalia_item as $i => $value) {
                $dados_avalia_item['cd_avalia_item']   = $value;
                $dados_avalia_item['cd_avaliacao']     = $ci_avaliacao;
                $this->db->insert('tb_avaliacao_itens', $dados_avalia_item);
            } 
        }
        // Fim - Inserir Itens da avaliação 

            return true;
        }else{
            return false;
        }

    }

    public function buscaAvaliacao($params){
        //print_r($params);die;
        $sql="select distinct au.*,e.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload                    
            where au.cd_avalia_tipo=1 and au.fl_ativo=true
                        and exists (select 1 from tb_avaliacao_matriz am where au.ci_avaliacao_upload = am.cd_avaliacao_upload)";

       if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
       }
       if(isset($params['nr_anoletivo'])){
            $sql.=" and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
       }
       if(isset($params['cidade'])){
            $sql.=" and ac.cd_cidade=".$params['cidade'];
       }
       if(isset($params['cd_etapa'])){
          $sql.=" and au.cd_etapa=".$params['cd_etapa'];
       }
       if(isset($params['cd_disciplina'])){
        $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        
        if($this->session->userdata('ci_grupousuario')==2){
            $sql.=" and ac.cd_cidade=".$this->session->userdata('cd_cidade_sme'); 
        }
        if($this->session->userdata('ci_grupousuario')==3){
            $sql.=" and ac.cd_cidade 
                        in (select cd_cidade 
                                from tb_escola where ci_escola=".$this->session->userdata('ci_escola').")";
        }
                
        $sql.= " and au.fl_ativo=true";

        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaAvaliacaoAno($params){
        //print_r($params);
        $sql="select distinct au.*,e.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload
            where au.cd_avalia_tipo=1  
                    and exists (select 1 from tb_avaliacao_matriz am where au.ci_avaliacao_upload = am.cd_avaliacao_upload)";
        
        if(isset($params['ano'])){
            $sql.=" and extract( year from dt_final)=".$params['ano'];
        }
        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        
        if($this->session->userdata('ci_grupousuario')==2){
            $sql.=" and ac.cd_cidade=".$this->session->userdata('cd_cidade_sme');
        }
        
        if($this->session->userdata('ci_grupousuario')==3){
            $sql.=" and ac.cd_cidade
                        in (select cd_cidade
                                from tb_escola where ci_escola=".$this->session->userdata('ci_escola').")";
        }
        
        $sql.= " and au.fl_ativo=true";
        
        //print_r($params);die;
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    public function buscaAvaliacaoLeituraAno($params){
        //print_r($params);
        $sql="select distinct au.*,e.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload
            where au.cd_avalia_tipo<>1 ";
        
        if(isset($params['ano'])){
            $sql.=" and extract( year from dt_final)=".$params['ano'];
        }
        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        
        if($this->session->userdata('ci_grupousuario')==2){
            $sql.=" and ac.cd_cidade=".$this->session->userdata('cd_cidade_sme');
        }
        
        if($this->session->userdata('ci_grupousuario')==3){
            $sql.=" and ac.cd_cidade
                        in (select cd_cidade
                                from tb_escola where ci_escola=".$this->session->userdata('ci_escola').")";
        }
        
        $sql.= " and au.fl_ativo=true";
        
        //print_r($params);die;
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaAvaliacaoEscola($params){
        $sql="select distinct au.*,e.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload
                inner join tb_escola esc on ac.cd_cidade=esc.cd_cidade
            where au.cd_avalia_tipo=1
                        and exists (select 1 from tb_avaliacao_matriz am where au.ci_avaliacao_upload = am.cd_avaliacao_upload)";
        
        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        if(isset($params['cd_escola'])){
            $sql .= " and esc.ci_escola=".$params['cd_escola'];
        }        
        
        $sql .= " and au.fl_ativo=true";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    

    public function buscaAvaliacaoDisponivel($params){
        $sql="select distinct au.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload
                inner join tb_escola esc on ac.cd_cidade=esc.cd_cidade
            where au.cd_avalia_tipo=1
                        and exists (select 1 from tb_avaliacao_matriz am where au.ci_avaliacao_upload = am.cd_avaliacao_upload)";
        
        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        if(isset($params['cd_escola'])){
            $sql .= " and esc.ci_escola=".$params['cd_escola'];
        }

        $sql.=" and ac.dt_final>=now() and ac.dt_inicio<=now()";
        $sql .= " and au.fl_ativo=true";

        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaNrQuestoesAvaliacao($params){
        $sql="select ci_avaliacao_upload,count(am.*) as nr_questoes from tb_avaliacao_upload au
                    inner join tb_avaliacao_matriz am ON au.ci_avaliacao_upload = am.cd_avaliacao_upload
                            and am.fl_ativo='true'
                where au.ci_avaliacao_upload =".$params['cd_avaliacao']."
          group by ci_avaliacao_upload;";

        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    
    public function buscaTopicosAvaliacao($params){
        $sql="select am.*,md.ds_codigo as descritor from tb_avaliacao_upload au
                join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    and am.fl_ativo='true'
                inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
            where au.cd_avalia_tipo=1";
        
        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        
        $sql.=" order by nr_questao";
        
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaItensAvaliacao($params){
        $sql="select am.*,md.ds_codigo as descritor from tb_avaliacao_upload au
                join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    and am.fl_ativo='true' 	 
                inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
            where au.cd_avalia_tipo=1";

        if(isset($params['cd_avaliacao'])){
            $sql.=" and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(isset($params['cd_etapa'])){
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
        }
        if(isset($params['cd_disciplina'])){
            $sql .= " and au.cd_disciplina=".$params['cd_disciplina'];
        }
        
        $sql.=" order by nr_questao";
        
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaMatrizAvaliacao($idmatriz){
        $sql=" select count(au.ci_avaliacao_upload) as id from tb_avaliacao_upload au
                    join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                        and am.fl_ativo='true' 
                    join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    join tb_matriz_topico mt on md.cd_matriz_topico=mt.ci_matriz_topico
               where mt.cd_matriz=".$idmatriz;
        $query=$this->db->query($sql);
        return $query->result();       
    }

    public function buscaDescritoresAvaliacao($params){
            $sql=" select * from (
                select distinct md.*, replace(md.ds_codigo,'D','')::integer as ordem  from tb_avaliacao_upload au 
                    join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    and am.fl_ativo='true' 
                    join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                  where au.cd_avalia_tipo=1
                    and au.ci_avaliacao_upload=".$params['cd_avaliacao'];
            $sql.=" ) res order by ordem;";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaAvaliacaoLeitura($params){                
        $sql="select distinct * from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao        
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload                        
            where au.cd_avalia_tipo<>1 and au.cd_etapa=".$params['cd_etapa']." 
                    and au.cd_disciplina=".$params['cd_disciplina'];

        if(isset($params['cd_cidade'])){
            $sql.=" and ac.cd_cidade=".$params['cd_cidade'];
        }            
        if(isset($params['nr_anoletivo'])){
            $sql.=" and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
        }
        $sql.=" and au.fl_ativo=true ";
        
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaAvaliacaoLeituraDisponivel($params)
    {
        $sql = "select * from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao 
            where au.cd_avalia_tipo<>1 and au.cd_etapa=" . $params['cd_etapa'] . " 
        and au.cd_disciplina=" . $params['cd_disciplina'];
        $sql.=" and dt_final>=now() and dt_inicio<=now() and au.fl_ativo='true'";        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function buscaAvaliacaoLeituraDisponivelCidade($params)
    {
        
        $sql = "select distinct au.*,e.* from tb_avaliacao_upload au
                join tb_edicao e on au.cd_edicao=e.ci_edicao
                inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload
            where au.cd_avalia_tipo<>1 and au.cd_etapa=" . $params['cd_etapa'] . "
        and au.cd_disciplina=" . $params['cd_disciplina'];
        $sql.=" and ac.dt_final>=now() and ac.dt_inicio<=now() and au.fl_ativo='true'";
               
        //print_r($this->session->userdata());die;
        if ($this->session->userdata('ci_grupousuario')==3) {
            $cd_escola=$this->session->userdata('ci_escola');
            $sql.="and ac.cd_cidade in( select cd_cidade from tb_escola where ci_escola=".$this->session->userdata('ci_escola').")";
        }
        if ($this->session->userdata('ci_grupousuario') == 2){
            $sql.="and ac.cd_cidade=".$this->session->userdata('cd_cidade_sme');
        }
        
        if ($this->session->userdata('ci_grupousuario') == 1){
            $sql.=" and ac.cd_cidade=".$params['cd_cidade'];
        }
        $sql.=" order by au.ci_avaliacao_upload";
               

        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function selectAvaliacoes($etapa,$disciplina,$cidade,$nr_anoletivo){
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;
        $params['cidade']=$cidade;
        $params['nr_anoletivo']=$nr_anoletivo;
        $avaliacoes = $this->buscaAvaliacao($params);

        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;

    }
    public function selectAvaliacoesAno($ano){
        $params['ano']=$ano;
        
        $avaliacoes = $this->buscaAvaliacaoAno($params);
        
        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;
        
    }
    public function selectAvaliacoesLeituraAno($ano){
        $params['ano']=$ano;
        
        $avaliacoes = $this->buscaAvaliacaoLeituraAno($params);
        
        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;
        
    }
    
    public function selectAvaliacoesEscola($etapa,$disciplina,$escola){
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;
        $params['cd_escola']=$escola;
        
        $avaliacoes = $this->buscaAvaliacaoEscola($params);
        
        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;
        
    }

    public function selectAvaliacoesDisponiveis($etapa,$disciplina,$escola){
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;
        $params['cd_escola']=$escola;
        $avaliacoes = $this->buscaAvaliacaoDisponivel($params);

        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;

    }

    public function selectAvaliacoesLeitura($etapa,$disciplina,$cd_cidade,$nr_anoletivo){
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;
        $params['cd_cidade']=$cd_cidade;
        $params['nr_anoletivo']=$nr_anoletivo;

        $avaliacoes = $this->buscaAvaliacaoLeitura($params);

        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;

    }

    public function selectAvaliacoesLeituraDisponiveis($etapa,$disciplina){
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;

        $avaliacoes = $this->buscaAvaliacaoLeituraDisponivel($params);

        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;

    }
    
    public function selectAvaliacoesLeituraDisponiveisCidade($etapa, $disciplina, $cidade){
        
        $params['cd_etapa']=$etapa;
        $params['cd_disciplina']=$disciplina;
        $params['cd_cidade']=$cidade;
        
        $avaliacoes = $this->buscaAvaliacaoLeituraDisponivelCidade($params);
        
        $options = "<option value=''>Selecione uma Avalia&ccedil;&atilde;o </option>";
        foreach ($avaliacoes as $avaliacao){
            $options .= "<option value='{$avaliacao->ci_avaliacao_upload}'>{$avaliacao->nm_caderno}</option>".PHP_EOL;
        }
        return $options;                
    }
    
    public function consultaAnos(){
        $sql = "select distinct extract( year from dt_final) as ano from tb_avaliacao_upload where fl_ativo=true order by 1 asc;";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function selectAnosAvaliacoes(){
        $anos = $this->consultaAnos();
        
        $options = "<option value=''>Selecione um Ano </option>";
        foreach ($anos as $ano){
            $options .= "<option value='{$ano->ano}'>{$ano->ano}</option>".PHP_EOL;
        }
        return $options;
    }

    public function cadernoProva($params){
        $sql="select * from tb_avaliacao_upload au 
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico                   
        where au.ci_avaliacao_upload=".$params['cd_avaliacao'];
        
        $sql.=" order by nr_questao;"; 
        
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function getDataAvaliacaoMunicipio($cd_municipio,$cd_avaliacao){
        $sql="select coalesce(to_char(now(),'dd/mm/YYYY'),to_char(dt_final,'dd/mm/YYYY')) as final,
        			case when dt_final>=now() then false else false end as bloqueia from tb_avaliacao_cidade tac 
                    where tac.cd_avaliacao_upload=".$cd_avaliacao;
        $sql.=" and tac.cd_cidade=".$cd_municipio;

        $query=$this->db->query($sql);
        return $query->result();
    }
}