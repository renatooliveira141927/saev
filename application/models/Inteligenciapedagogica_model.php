<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Inteligenciapedagogica_model extends CI_Model {

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
            where au.cd_avalia_tipo=9";
        
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
        $sql="select * from tb_avaliacao_upload au
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
        $sql="select distinct mt.nm_matriz_topico,
	                   count(nr_questao) as colspan 
                    from
                    	tb_avaliacao_upload au
                    join tb_avaliacao_matriz am on
                    	au.ci_avaliacao_upload = am.cd_avaliacao_upload
                    	and am.fl_ativo = 'true'
                    inner join tb_matriz_descritor md on
                    	am.cd_matriz_descritor = md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on
                    	mt.ci_matriz_topico = md.cd_matriz_topico	
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
        
        $sql.=" group by mt.nm_matriz_topico
                order by mt.nm_matriz_topico";
        
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaItensAvaliacao($params){
        $sql="select am.*,md.ds_codigo as descritor from tb_avaliacao_upload au
                join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    and am.fl_ativo='true' 	 
                inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
                inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
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
        
        $sql.=" order by mt.nm_matriz_topico,nr_questao";
        
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
            where au.cd_avalia_tipo=9 and au.cd_etapa=".$params['cd_etapa']." 
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
            where au.cd_avalia_tipo=9 and au.cd_etapa=" . $params['cd_etapa'] . " 
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
            where au.cd_avalia_tipo=9 and au.cd_etapa=" . $params['cd_etapa'] . "
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
    
    public function buscaResultadoAlunoNew($params){
        $sql=" select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		                        case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	           from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                		inner join tb_turma t on ent.cd_turma=t.ci_turma
                		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
               where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                    and aa.cd_situacao_aluno<>7 ";
                    if(isset($params['cd_turma'])){
                        $sql .= " and ent.cd_turma=".$params['cd_turma'];}
                    if(isset($params['cd_disciplina'])){
                        $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                    if(isset($params['cd_avaliacao'])){
                        $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    if(isset($params['cd_aluno'])){
                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                    
        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc";                   
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadoEscNew($params){
       $sql=" select ci_escola,nm_escola,nr_questao,cddescritor,topico,descritor, sum(acertos) as acertos,count(ci_aluno) as fizeram from 
(select
	distinct esc.ci_escola,esc.nm_escola, 
	al.ci_aluno,al.nm_aluno,
	nr_questao,
	md.ds_codigo as cddescritor,
	mt.nm_matriz_topico as topico,
	md.ds_codigo || '-' || md.nm_matriz_descritor as descritor,
	case
		when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
		else 0
	end as acertos,
	am.fl_ativo
from
	tb_ultimaenturmacao ent
inner join tb_aluno al on
	ent.cd_aluno = al.ci_aluno
inner join tb_turma t on
	ent.cd_turma = t.ci_turma
inner join tb_escola esc on t.cd_escola=esc.ci_escola 	
inner join tb_avaliacao_upload au on
	t.cd_etapa = au.cd_etapa
inner join tb_avaliacao_matriz am on
	au.ci_avaliacao_upload = am.cd_avaliacao_upload
inner join tb_matriz_descritor md on
	am.cd_matriz_descritor = md.ci_matriz_descritor
inner join tb_matriz_topico mt on
	mt.ci_matriz_topico = md.cd_matriz_topico
inner join tb_avaliacao_aluno aa on
	al.ci_aluno = aa.cd_aluno
	and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
where
	t.cd_etapa = ".$params['cd_etapa']."
	and al.fl_ativo = true
	and aa.cd_situacao_aluno <> 7
	and esc.cd_cidade = ".$params['cd_cidade']."	
	and ci_avaliacao_upload= ".$params['cd_avaliacao']."
order by
	al.nm_aluno,
	mt.nm_matriz_topico,
	nr_questao,
	md.ds_codigo,
	am.fl_ativo desc ) res
group by ci_escola,nm_escola,nr_questao,cddescritor,topico,descritor
order by 1,2,5,3;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    public function buscaResultadoMunNew($params){
        $sql=" select ci_cidade,nm_cidade,nr_questao,cddescritor,topico,descritor, sum(acertos) as acertos,count(ci_aluno) as fizeram from 
(select
	distinct cid.ci_cidade,cid.nm_cidade, 
	al.ci_aluno,al.nm_aluno,
	nr_questao,
	md.ds_codigo as cddescritor,
	mt.nm_matriz_topico as topico,
	md.ds_codigo || '-' || md.nm_matriz_descritor as descritor,
	case
		when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
		else 0
	end as acertos,
	am.fl_ativo
from
	tb_ultimaenturmacao ent
inner join tb_aluno al on
	ent.cd_aluno = al.ci_aluno
inner join tb_turma t on
	ent.cd_turma = t.ci_turma
inner join tb_escola esc on t.cd_escola=esc.ci_escola 	
inner join tb_cidade cid on esc.cd_cidade=cid.ci_cidade 	
inner join tb_avaliacao_upload au on
	t.cd_etapa = au.cd_etapa
inner join tb_avaliacao_matriz am on
	au.ci_avaliacao_upload = am.cd_avaliacao_upload
inner join tb_matriz_descritor md on
	am.cd_matriz_descritor = md.ci_matriz_descritor
inner join tb_matriz_topico mt on
	mt.ci_matriz_topico = md.cd_matriz_topico
inner join tb_avaliacao_aluno aa on
	al.ci_aluno = aa.cd_aluno
	and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
where
	t.cd_etapa = ".$params['cd_etapa']."
	and al.fl_ativo = true
	and aa.cd_situacao_aluno <> 7
	and esc.cd_cidade = ".$params['cd_cidade']."
	and ci_avaliacao_upload= ".$params['cd_avaliacao']."
order by
	al.nm_aluno,
	mt.nm_matriz_topico,
	nr_questao,
	md.ds_codigo,
	am.fl_ativo desc ) res
group by ci_cidade,nm_cidade,nr_questao,cddescritor,topico,descritor
order by 1,2,5,3;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function colunas($params){
        $sql="select fc_retiraespaco(replace(replace(nm_caderno,' ','_'),'\"','')) as nm_caderno,
                '$'||replace(fc_retiraespaco(replace(replace(nm_caderno,' ','_'),'\"',''))::text,',','&')||'@' as colunas from(
                (select replace(replace(array_agg(distinct lower(nm_caderno))::text,'{',''),'}','') as nm_caderno,
                ''||replace(replace(array_agg(distinct lower(nm_caderno))::text,'{',''),'}','')||'' as colunas
                from tb_avaliacao_upload tau
	                       inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=tau.ci_avaliacao_upload
                    where tau.fl_ativo=true and cd_avalia_tipo=1 and tau.cd_disciplina=".$params['cd_disciplina']."
                        and tau.cd_etapa=".$params['cd_etapa']."
                        and extract(year from tac.dt_final)=".$params['nr_anoletivo'].") )as res";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaInteligenciaAlunoDescritor($params){
        $colunas=$this->colunas($params);
       
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select nm_matriz_topico, ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas ,nm_descritor                 
                from";
            if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_compilamatematica_alunoavalaicaoprimeiraserie_descritor';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_compilamatematica_alunoavalaicaosegundaserie_descritor';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_compilamatematica_alunoavalaicaoterceiraserie_descritor';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_compilamatematica_alunoavalaicaoquataserie_descritor';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_compilamatematica_alunoavalaicaoquintaserie_descritor';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_compilamatematica_alunoavalaicaosextaserie_descritor';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_compilamatematica_alunoavalaicaosetimaserie_descritor';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_compilamatematica_alunoavalaicaooitavaserie_descritor';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_compilamatematica_alunoavalaicaononaserie_descritor';}
                                
            }
            
            if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_compilaportugues_alunoavalaicaoprimeiraserie_descritor';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_compilaportugues_alunoavalaicaosegundaserie_descritor';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_compilaportugues_alunoavalaicaoterceiraserie_descritor';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_compilaportugues_alunoavalaicaoquataserie_descritor';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_compilaportugues_alunoavalaicaoquintaserie_descritor';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_compilaportugues_alunoavalaicaosextaserie_descritor';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_compilaportugues_alunoavalaicaosetimaserie_descritor';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_compilaportugues_alunoavalaicaooitavaserie_descritor';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_compilaportugues_alunoavalaicaononaserie_descritor';}
                
            }
                    
            $sql.=" where cd_etapa=".$params['cd_etapa'];
            if(isset($params['cd_aluno'])){
                $sql .= "   and cd_aluno=".$params['cd_aluno'];}
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
            $sql.=" )res
        
    order by 1,2";
            $query=$this->db->query($sql);
            return $query->result();
            
        }else{
            echo 'erro de colunas';die;
        }
    }
    
    public function buscaInteligenciaAluno($params){
        $sql=" select ci_aluno,
            	nm_aluno,
            	nm_caderno, 
            	cd_disciplina, 	
            	cod_descritor,
            	topico,
            	sum(acertos) as acertos
            from (
            select
            	distinct al.ci_aluno,
            	al.nm_aluno,
            	au.nm_caderno, 
            	au.cd_disciplina, 	
            	md.ds_codigo as cod_descritor,
            	mt.nm_matriz_topico as topico,
            	case
            		when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
            		else 0
            	end as acertos            
                	from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                		inner join tb_turma t on ent.cd_turma=t.ci_turma
                		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                                and aa.cd_situacao_aluno<>7 ";
                        if(isset($params['cd_turma'])){
                            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
                            if(isset($params['cd_disciplina'])){
                                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                                if(isset($params['cd_avaliacao'])){
                                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                                    if(isset($params['cd_aluno'])){
                                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                                        
                                        $sql.=" ) res
                group by ci_aluno,
                	nm_aluno,
                	nm_caderno, 
                	cd_disciplina, 	
                	cod_descritor,
                	topico
                order by
                	nm_aluno,
                	cd_disciplina,	
                	nm_caderno,
                	cod_descritor,	
                	topico;";
                        
                        $query=$this->db->query($sql);
                        return $query->result();
    }
    
    public function buscadistratormaismarcado($params){
        $sql="select * from (
			select nr_questao,
				md.ds_codigo as descritor,
				mt.nm_matriz_topico as topico,
				md.ds_codigo, 
				case 
					when aa.nr_alternativa_escolhida=1 then 'A'
					when aa.nr_alternativa_escolhida=2 then 'B'
					when aa.nr_alternativa_escolhida=3 then 'C'
					when aa.nr_alternativa_escolhida=4 then 'D'
				end as nr_alternativa_escolhida,
				count(al.ci_aluno)
			from
				tb_ultimaenturmacao ent
			inner join tb_aluno al on
				ent.cd_aluno = al.ci_aluno
			inner join tb_turma t on
				ent.cd_turma = t.ci_turma
			inner join tb_avaliacao_upload au on
				t.cd_etapa = au.cd_etapa
			inner join tb_avaliacao_matriz am on
				au.ci_avaliacao_upload = am.cd_avaliacao_upload
			inner join tb_matriz_descritor md on
				am.cd_matriz_descritor = md.ci_matriz_descritor
			inner join tb_matriz_topico mt on
				mt.ci_matriz_topico = md.cd_matriz_topico
			inner join tb_avaliacao_aluno aa on
				al.ci_aluno = aa.cd_aluno
				and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
			where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                and aa.cd_situacao_aluno<>7 ";
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    
                    $sql.=" group by nr_questao,
				md.ds_codigo,
				mt.nm_matriz_topico,
				md.ds_codigo, 
				aa.nr_alternativa_escolhida 
		      ) res
                order by 3,1,2,6 desc ,5";
                    
                    $query=$this->db->query($sql);
                    return $query->result();
    }
    
    public function totalacerto($params){
        $sql="select nr_questao,
		          descritor,
		          topico,
		          count(*) as nr,
		          sum(acertos)
        from (
            select
            	distinct al.ci_aluno,
            	al.nm_aluno,
            	nr_questao,
            	md.ds_codigo as descritor,
            	mt.nm_matriz_topico as topico,
            	md.ds_codigo || '-' || md.nm_matriz_descritor,
            	case
            		when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
            		else 0
            	end as acertos,
            	am.fl_ativo
            from
            	tb_ultimaenturmacao ent
            inner join tb_aluno al on
            	ent.cd_aluno = al.ci_aluno
            inner join tb_turma t on
            	ent.cd_turma = t.ci_turma
            inner join tb_avaliacao_upload au on
            	t.cd_etapa = au.cd_etapa
            inner join tb_avaliacao_matriz am on
            	au.ci_avaliacao_upload = am.cd_avaliacao_upload
            inner join tb_matriz_descritor md on
            	am.cd_matriz_descritor = md.ci_matriz_descritor
            inner join tb_matriz_topico mt on
            	mt.ci_matriz_topico = md.cd_matriz_topico
            inner join tb_avaliacao_aluno aa on
            	al.ci_aluno = aa.cd_aluno
            	and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                            and aa.cd_situacao_aluno<>7 ";
            if(isset($params['cd_turma'])){
                    $sql .= " and ent.cd_turma=".$params['cd_turma'];
            }
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];
            }
            if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];
            }
            
        $sql.=" order by
            	al.nm_aluno,
            	mt.nm_matriz_topico,
            	nr_questao,
            	md.ds_codigo,
            	am.fl_ativo desc ) res
            group by nr_questao,
            		descritor,
            		topico;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function infrequencia($cd_turma, $cd_aluno=null){
        $sql="select distinct ci_aluno,nr_inep,upper(nm_aluno) as nm_aluno,dt_nascimento,
                    	cd_turma,nm_turma,cd_etapa,nm_etapa,
                    	sum(JAN) as JAN,
                    	sum(FEV) as FEV,
                    	sum(MAR) as MAR,
                    	sum(ABR) as ABR,
                    	sum(MAI) as MAI,
                    	sum(JUN) as JUN,
                    	sum(JUL) as JUL,
                    	sum(AGO) as AGO,
                    	sum(SET) as SET,
                    	sum(OUT) as OUT,
                    	sum(NOV) as NOV,
                    	sum(DEZ) as DEZ
                    from (
                    select distinct al.ci_aluno,al.nr_inep, al.nm_aluno,al.dt_nascimento,
                    	ent.cd_turma,
                    	tur.nm_turma,
                    	tur.cd_etapa,
                    	et.nm_etapa,
                    	case when nr_mes=1 then nr_faltas else 0 end as JAN,
                    	case when nr_mes=2 then nr_faltas else 0 end as FEV,
                    	case when nr_mes=3 then nr_faltas else 0 end as MAR,
                    	case when nr_mes=4 then nr_faltas else 0 end as ABR,
                    	case when nr_mes=5 then nr_faltas else 0 end as MAI,
                    	case when nr_mes=6 then nr_faltas else 0 end as JUN,
                    	case when nr_mes=7 then nr_faltas else 0 end as JUL,
                    	case when nr_mes=8 then nr_faltas else 0 end as AGO,
                    	case when nr_mes=9 then nr_faltas else 0 end as SET,
                    	case when nr_mes=10 then nr_faltas else 0 end as OUT,
                    	case when nr_mes=11 then nr_faltas else 0 end as NOV,
                    	case when nr_mes=12 then nr_faltas else 0 end as DEZ
                    from tb_aluno al
                    join tb_ultimaenturmacao ent on
                    	al.ci_aluno = ent.cd_aluno
                    left join tb_infrequencia inf on
                    	ent.cd_aluno =  inf.cd_aluno
                    	and ent.cd_turma =  inf.cd_turma
                    join tb_turma tur on
                    	ent.cd_turma = tur.ci_turma and
                        tur.cd_escola = al.cd_escola
                    join tb_etapa et on
                    	tur.cd_etapa = et.ci_etapa
                    where
                    	al.fl_ativo = true
                    	and tur.ci_turma =".$cd_turma;
        if($cd_aluno!=null){
            $sql.=" and al.ci_aluno=".$cd_aluno;
        }
                   $sql.=" order by
                    al.nm_aluno asc ) res
                    group by ci_aluno,nr_inep, nm_aluno,dt_nascimento,
                    	cd_turma,nm_turma,cd_etapa,nm_etapa
                    order by nm_aluno";
        
        $query=$this->db->query($sql);
        return $query->result();
           
    }
    
    public function avaliacao_leitura($cd_turma, $cd_aluno=null){
        $sql="select distinct tau.nm_caderno, 
				taa.cd_aluno,
				taa.*,
				tau.cd_etapa,
				extract(year from tac.dt_final)
        from tb_avaliacaoleitura_aluno taa
        	inner join tb_avaliacao_upload tau on taa.cd_avaliacao_upload=tau.ci_avaliacao_upload
                and tau.cd_avalia_tipo=9
        	inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=tau.ci_avaliacao_upload
        	inner join tb_ultimaenturmacao tu on taa.cd_aluno=tu.cd_aluno
                and tu.nr_anoletivo = extract(year from tac.dt_final)		
        	inner join tb_turma t on tu.cd_turma=t.ci_turma
        		and t.cd_etapa=tau.cd_etapa 
        		and t.nr_ano_letivo=extract(year from tac.dt_final)
        where 1=1 and t.ci_turma=".$cd_turma;
        if(isset($cd_aluno)&& !empty($cd_aluno)){$sql.=" and taa.cd_aluno=".$cd_aluno;}
        
        $sql.=" order by tau.nm_caderno;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function avaliacaoturma_leitura($params){
        $sql="select distinct extract(year from tac.dt_final) as ano, 
                	tau.nm_caderno,
                	tau.cd_etapa,	
                	taa.nr_alternativa_escolhida as conceito,
                	count(distinct taa.cd_aluno) as fizeram,
	               (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu 
                        where tu.cd_turma=".$params['cd_turma'].") as enturmado,
	               coalesce(tma.nr_percentual,0) as nr_percentual
        from tb_avaliacaoleitura_aluno taa
        	inner join tb_avaliacao_upload tau on taa.cd_avaliacao_upload=tau.ci_avaliacao_upload
                    and tau.cd_avalia_tipo=9
        	inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=tau.ci_avaliacao_upload
            inner join tb_ultimaenturmacao tu on taa.cd_aluno = tu.cd_aluno 
                        and tu.nr_anoletivo= extract(year from tac.dt_final)        	
        	inner join tb_turma t on tu.cd_turma=t.ci_turma
        		and t.cd_etapa=tau.cd_etapa
        		and t.nr_ano_letivo=extract(year from tac.dt_final)
            inner join tb_escola esc on t.cd_escola=esc.ci_escola 	
            left join tb_metas_aprendizagem tma on esc.cd_cidade=tma.cd_municipio
                		and extract(year from tac.dt_final)=tma.nr_anoletivo
                		and tma.cd_etapa=tau.cd_etapa 
                		and tau.cd_disciplina=tma.cd_disciplina 
                		and (t.cd_escola=tma.cd_escola or tma.cd_escola is null)
        where t.ci_turma=".$params['cd_turma'];
        
        if($params['cd_etapa']==18){
            $sql.=" and taa.nr_alternativa_escolhida in (5,6)";
        }else{
            $sql.=" and taa.nr_alternativa_escolhida in (6)";
        }
        
        $sql.="group by extract(year from tac.dt_final),
	                   tau.nm_caderno,tau.cd_etapa,	
	                   taa.nr_alternativa_escolhida,
	                   tma.nr_percentual
                order by 1,2;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function avaliacaoescola_leitura($params){
        $sql="select distinct extract(year from tac.dt_final) as ano,
                	tau.nm_caderno,
                	tau.cd_etapa,                	
                	count(distinct taa.cd_aluno) as fizeram,
	               (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu
                            inner join tb_turma t on tu.cd_turma=t.ci_turma
                                and t.cd_etapa=tau.cd_etapa
        		                and t.nr_ano_letivo=".$params['nr_anoletivo']."
                        where t.cd_escola=".$params['cd_escola'].") as enturmado,
	               coalesce(tma.nr_percentual,0) as nr_percentual
        from tb_avaliacaoleitura_aluno taa
        	inner join tb_avaliacao_upload tau on taa.cd_avaliacao_upload=tau.ci_avaliacao_upload
                    and tau.cd_avalia_tipo=9 
        	inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=tau.ci_avaliacao_upload
                 and extract(year from tac.dt_final)=".$params['nr_anoletivo']."
            inner join tb_ultimaenturmacao tu on taa.cd_aluno = tu.cd_aluno
                        and tu.nr_anoletivo=".$params['nr_anoletivo']."
        	inner join tb_turma t on tu.cd_turma=t.ci_turma
        		and t.cd_etapa=tau.cd_etapa
        		and t.nr_ano_letivo=extract(year from tac.dt_final)
            inner join tb_escola esc on t.cd_escola=esc.ci_escola
            left join tb_metas_aprendizagem tma on esc.cd_cidade=tma.cd_municipio
                		and tma.nr_anoletivo=".$params['nr_anoletivo']."
                		and tma.cd_etapa=tau.cd_etapa
                		and tau.cd_disciplina=tma.cd_disciplina
                		and (t.cd_escola=tma.cd_escola or tma.cd_escola is null)
        where esc.ci_escola=".$params['cd_escola'];
        
        if($params['cd_etapa']==18){
            $sql.=" and taa.nr_alternativa_escolhida in (5,6) and t.cd_etapa=".$params['cd_etapa'];
        }else{
            $sql.=" and taa.nr_alternativa_escolhida in (6) and t.cd_etapa=".$params['cd_etapa'];
        }
        
        $sql.=" group by extract(year from tac.dt_final),
	                   tau.nm_caderno,tau.cd_etapa,	                   
	                   tma.nr_percentual
                order by 1,2;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function avaliacaomunicipio_leitura($params){
        $sql="select distinct extract(year from tac.dt_final) as ano,
                	tau.nm_caderno,
                	tau.cd_etapa,
                	count(distinct taa.cd_aluno) as fizeram,
	               (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu
                            inner join tb_turma t on tu.cd_turma=t.ci_turma
                                and t.cd_etapa=tau.cd_etapa
        		                and t.nr_ano_letivo=".$params['nr_anoletivo']."
                            inner join tb_escola esc on t.cd_escola=esc.ci_escola
                        where esc.cd_cidade=".$params['cd_cidade'].") as enturmado,
	               coalesce(tma.nr_percentual,0) as nr_percentual
        from tb_avaliacaoleitura_aluno taa
        	inner join tb_avaliacao_upload tau on taa.cd_avaliacao_upload=tau.ci_avaliacao_upload
                    and tau.cd_avalia_tipo=9
        	inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=tau.ci_avaliacao_upload
                 and extract(year from tac.dt_final)=".$params['nr_anoletivo']."
            inner join tb_ultimaenturmacao tu on taa.cd_aluno = tu.cd_aluno
                        and tu.nr_anoletivo=".$params['nr_anoletivo']."
        	inner join tb_turma t on tu.cd_turma=t.ci_turma
        		and t.cd_etapa=tau.cd_etapa
        		and t.nr_ano_letivo=extract(year from tac.dt_final)
            inner join tb_escola esc on t.cd_escola=esc.ci_escola
            left join tb_metas_aprendizagem tma on esc.cd_cidade=tma.cd_municipio
                		and tma.nr_anoletivo=".$params['nr_anoletivo']."
                		and tma.cd_etapa=tau.cd_etapa
                		and tau.cd_disciplina=tma.cd_disciplina
                		and (t.cd_escola=tma.cd_escola or tma.cd_escola is null)
        where esc.cd_cidade=".$params['cd_cidade'];
        
        if($params['cd_etapa']==18){
            $sql.=" and taa.nr_alternativa_escolhida in (5,6) and t.cd_etapa=".$params['cd_etapa'];
        }else{
            $sql.=" and taa.nr_alternativa_escolhida in (6) and t.cd_etapa=".$params['cd_etapa'];
        }
        
        $sql.=" group by extract(year from tac.dt_final),
	                   tau.nm_caderno,tau.cd_etapa,
	                   tma.nr_percentual
                order by 1,2;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaAvaliacoesInteligencia($params){
        $sql=" select distinct nm_caderno, 
	                   cd_disciplina
        from (
            select
            	distinct al.ci_aluno,
            	al.nm_aluno,
            	au.nm_caderno,
            	au.cd_disciplina,
            	md.ds_codigo as cod_descritor,
            	mt.nm_matriz_topico as topico,
            	case
            		when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
            		else 0
            	end as acertos
	from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
		inner join tb_turma t on ent.cd_turma=t.ci_turma
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                and aa.cd_situacao_aluno<>7 ";
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    if(isset($params['cd_aluno'])){
                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                        
                        $sql.=" order by al.nm_aluno,
	                                   au.cd_disciplina,	
                                    	mt.nm_matriz_topico,	
                                    	md.ds_codigo,
                                    	au.nm_caderno) res
                                    group by 
                                    	nm_caderno, 
                                    	cd_disciplina,
                                    	topico
                                    order by 
                                    	cd_disciplina,
                                    	nm_caderno;";
                        
                        $query=$this->db->query($sql);
                        return $query->result();
    }
    
    public function buscaPercentAcerto($params){
        $sql="select au.cd_disciplina,
                	nm_caderno,traa.pacerto,
                    count(distinct traa.ci_aluno) as fizeram,
                    coalesce(tma.nr_percentual,0) as nr_percentual,
                    (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu 
                        where tu.cd_turma=".$params['cd_turma'].") as enturmado
                from tb_resultado_aluno_avaliacao traa 
                	inner join tb_avaliacao_upload au on traa.ci_avaliacao_upload=au.ci_avaliacao_upload
                	inner join tb_escola esc on traa.cd_escola=esc.ci_escola 
                	left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		and traa.ano=tma.nr_anoletivo
                		and tma.cd_etapa=traa.cd_etapa 
                		and traa.cd_disciplina=tma.cd_disciplina 
                		and (traa.cd_escola=tma.cd_escola or tma.cd_escola is null or tma.cd_escola=0)
            where traa.ci_aluno=".$params['cd_aluno']." 
            group by au.cd_disciplina,nm_caderno,traa.pacerto,tma.nr_percentual order by 1;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoTurma($params){
        $sql=" select au.cd_disciplina,
                	nm_caderno,
                		sum(traa.acerto),
	                    count(distinct traa.ci_aluno) as fizeram, 
	                    (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu 
                            where tu.cd_turma=".$params['cd_turma'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto,
	                    round(coalesce(plp.vl_proficiencia,pmt.vl_proficiencia)::numeric,1) as proficiencia,
	                    td.ds_descricaofaixa,td.estilo,
	coalesce(plp.ds_abaixo_basico,pmt.ds_abaixo_basico)::numeric as ds_abaixo_basico,
	coalesce(plp.ds_basico,pmt.ds_basico)::numeric as ds_basico,
	coalesce(plp.ds_intermediario,pmt.ds_intermediario)::numeric as ds_intermediario,
	replace(coalesce(plp.ds_adequado,pmt.ds_adequado),',','.')::numeric as ds_adequado

                from tb_resultado_aluno_avaliacao traa
    inner join tb_ultimaenturmacao tu2 on traa.ci_aluno = tu2.cd_aluno and traa.ano = tu2.nr_anoletivo
	inner join tb_avaliacao_upload au on traa.ci_avaliacao_upload = au.ci_avaliacao_upload and traa.cd_etapa=au.cd_etapa 
	inner join tb_escola esc on traa.cd_escola = esc.ci_escola
	inner join tb_etapa te on au.cd_etapa=te.ci_etapa
	inner join tb_turma tr on traa.ci_turma=tr.ci_turma	 
                	left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		and traa.ano=tma.nr_anoletivo
                		and tma.cd_etapa=traa.cd_etapa 
                		and traa.cd_disciplina=tma.cd_disciplina 
                		
    left join tb_import_proficiencia_turma_lp plp on esc.nr_inep::numeric=plp.inep_escola 
		and tu2.nr_anoletivo=plp.ano 
		and traa.cd_disciplina=2
		and fc_retira_all(plp.ds_etapa)=fc_retira_all(te.nm_etapa)
		and fc_retira_all(plp.ds_turma)=fc_retira_all(tr.nm_turma)

	left join tb_import_proficiencia_turma_mt pmt on esc.nr_inep::numeric=pmt.inep_escola
		and tu2.nr_anoletivo=pmt.ano and traa.cd_disciplina=1
		and fc_retira_all(pmt.ds_etapa)=fc_retira_all(te.nm_etapa)
		and fc_retira_all(pmt.ds_turma)=fc_retira_all(tr.nm_turma)	
	
	left join tb_faixa_proficiencia tfp on 
			round(coalesce(plp.vl_proficiencia,pmt.vl_proficiencia)::numeric,1)>=tfp.nr_inicio 	
			and round(coalesce(plp.vl_proficiencia,pmt.vl_proficiencia)::numeric,1)<=tfp.nr_fim
	left join tb_descricaofaixa td on tfp.cd_descricaofaixa=td.ci_descricaofaixa and td.fl_ativo=true
           
     where traa.ci_turma=".$params['cd_turma']."
                        and traa.ano=".$params['nr_anoletivo']." 
            group by au.cd_disciplina,
                	nm_caderno,	
                	tma.nr_percentual,
	                plp.vl_proficiencia,pmt.vl_proficiencia,
	                td.ds_descricaofaixa,td.estilo,
	plp.ds_abaixo_basico,pmt.ds_abaixo_basico,
	plp.ds_basico,pmt.ds_basico,
	plp.ds_intermediario,pmt.ds_intermediario,
	plp.ds_adequado,pmt.ds_adequado
                order by 1;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoEscola($params){
        $sql=" select au.cd_disciplina,
                	nm_caderno,
                		sum(traa.acerto),
	                    count(distinct traa.ci_aluno) as fizeram,
	                    (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu
                                 inner join tb_turma t on tu.cd_turma=t.ci_turma
                            where t.cd_escola=".$params['cd_escola']." 
                                    and t.nr_ano_letivo=".$params['nr_anoletivo']."
                                    and t.cd_etapa=".$params['cd_etapa'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto,
round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1) as proficiencia,
	td.ds_descricaofaixa,td.estilo
                from tb_resultado_aluno_avaliacao traa
inner join tb_ultimaenturmacao tue on traa.ci_aluno=tue.cd_aluno and traa.ano=tue.nr_anoletivo
inner join tb_avaliacao_upload au on traa.ci_avaliacao_upload = au.ci_avaliacao_upload and traa.cd_etapa = au.cd_etapa
inner join tb_escola esc on traa.cd_escola = esc.ci_escola
inner join tb_etapa te on au.cd_etapa = te.ci_etapa
inner join tb_turma tr on traa.ci_turma = tr.ci_turma

                	left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		and traa.ano=tma.nr_anoletivo
                		and tma.cd_etapa=traa.cd_etapa 
                		and traa.cd_disciplina=tma.cd_disciplina 
                		and (traa.cd_escola=tma.cd_escola or tma.cd_escola is null)

left join tb_import_proficiencia_escolas_lp plp on
	esc.nr_inep::numeric = plp.nr_inep_escola
	and tue.nr_anoletivo = plp.ano
	and traa.cd_disciplina = 2
	and fc_retira_all(plp.ds_etapa)= fc_retira_all(te.nm_etapa)
	
left join tb_import_proficiencia_escolas_mt pmt on
	esc.nr_inep::numeric = pmt.nr_inep_escola
	and tue.nr_anoletivo = pmt.ano
	and traa.cd_disciplina = 1
	and fc_retira_all(pmt.ds_etapa)= fc_retira_all(te.nm_etapa)

left join tb_faixa_proficiencia tfp on
	round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1)>= tfp.nr_inicio
	and round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1)<= tfp.nr_fim
left join tb_descricaofaixa td on
	tfp.cd_descricaofaixa = td.ci_descricaofaixa
	and td.fl_ativo = true

            where traa.cd_escola=".$params['cd_escola']."
                        and traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."
            group by au.cd_disciplina,
                	nm_caderno,
                	tma.nr_percentual,
	plp.vl_proficiencia,
	pmt.vl_proficiencia,
	td.ds_descricaofaixa,
	td.estilo
                order by 1;";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaPercentAcertoTurmaEscola($params){
        $sql="select nm_turma, 
       cd_disciplina,
       count(nm_caderno) as nr_cadernos,
	   replace(replace(replace(array_agg('<td><label>'||nm_caderno||'</label></td>')::text,'{',''),'}',''),',','') as nm_caderno,
	   replace(replace(replace(replace(array_agg('<td>%Participação:'||((fizeram*100)/enturmado)||'</br> %Acerto:'||pacerto||'</td>' )::text,'{',''),'}',''),',',''),'\"','') as participacao,
	   replace(replace(replace(array_agg('<td>'||pacerto||'</td>')::text,'{',''),'}',''),',','') as pacerto,
	   replace(replace(array_agg( ((fizeram*100)/enturmado))::text,'{',''),'}','') as nrpart,
	   replace(replace(array_agg(pacerto)::text,'{',''),'}','') as nrpacerto,
	   sum(pacerto)/count(nm_caderno) as profic,
	proficiencia,ds_descricaofaixa,estilo
        from ( select tr.nm_turma,au.cd_disciplina,
                	nm_caderno,
                		sum(traa.acerto),
	                    count(distinct traa.ci_aluno) as fizeram,
	                    (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu
                                 inner join tb_turma t on tu.cd_turma=t.ci_turma
                            where t.cd_escola=".$params['cd_escola']."
                                    and t.nr_ano_letivo=".$params['nr_anoletivo']."
                                    and t.cd_etapa=".$params['cd_etapa'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto,
	round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1) as proficiencia,
	td.ds_descricaofaixa,td.estilo
                from tb_resultado_aluno_avaliacao traa

inner join tb_ultimaenturmacao t on traa.ci_aluno = t.cd_aluno and traa.ano = t.nr_anoletivo
	inner join tb_turma tr on t.cd_turma = tr.ci_turma
	inner join tb_avaliacao_upload au on traa.ci_avaliacao_upload = au.ci_avaliacao_upload
	inner join tb_escola esc on traa.cd_escola = esc.ci_escola
	inner join tb_etapa te on au.cd_etapa = te.ci_etapa
	left join tb_metas_aprendizagem tma on
		traa.cd_cidade = tma.cd_municipio
		and traa.ano = tma.nr_anoletivo
		and tma.cd_etapa = traa.cd_etapa
		and traa.cd_disciplina = tma.cd_disciplina
		and (traa.cd_escola = tma.cd_escola
		or tma.cd_escola is null)

left join tb_import_proficiencia_turma_lp plp on
	esc.nr_inep::numeric = plp.inep_escola
	and t.nr_anoletivo = plp.ano
	and traa.cd_disciplina = 2
	and fc_retira_all(plp.ds_etapa)= fc_retira_all(te.nm_etapa)
	and fc_retira_all(plp.ds_turma)= fc_retira_all(tr.nm_turma)

left join tb_import_proficiencia_turma_mt pmt on
	esc.nr_inep::numeric = pmt.inep_escola
	and t.nr_anoletivo = pmt.ano
	and traa.cd_disciplina = 1
	and fc_retira_all(pmt.ds_etapa)= fc_retira_all(te.nm_etapa)	
left join tb_faixa_proficiencia tfp on
	round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1)>= tfp.nr_inicio
	and round(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia)::numeric, 1)<= tfp.nr_fim
left join tb_descricaofaixa td on
	tfp.cd_descricaofaixa = td.ci_descricaofaixa
	and td.fl_ativo = true

                    

            where traa.cd_escola=".$params['cd_escola']."
                        and traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."
            group by tr.nm_turma,au.cd_disciplina,
                	nm_caderno,
                	tma.nr_percentual,
		
            	plp.vl_proficiencia,
            	pmt.vl_proficiencia,
            	td.ds_descricaofaixa,
            	td.estilo
               ) res
        group by nm_turma, 
	           cd_disciplina,
                proficiencia,ds_descricaofaixa,estilo        
        order by 2,3 desc;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaInteligenciaTurma($params){
        
        $colunas=$this->colunas($params);
        //echo $this->db->last_query();die;
        
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select topico as nm_matriz_topico, ds_codigo as ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas, nm_descritor
                from";
            if($params['cd_disciplina']==1){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_sintese_PRIMEIRAserieturmadescritorMATEMATICA';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_sintese_SEGUNDAserieturmadescritorMATEMATICA';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_sintese_TERCEIRAserieturmadescritorMATEMATICA';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_sintese_QUARTAserieturmadescritorMATEMATICA';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_sintese_QUINTAserieturmadescritorMATEMATICA';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_sintese_SEXTAserieturmadescritorMATEMATICA';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_sintese_SETIMAserieturmadescritorMATEMATICA';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_sintese_OITAVAserieturmadescritorMATEMATICA';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_sintese_NONAAserieturmadescritorMATEMATICA';}
                
            }
            
            if($params['cd_disciplina']==2){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_sintese_PRIMEIRAserieturmadescritorPORTUGUES';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_sintese_SEGUNDAserieturmadescritorPORTUGUES';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_sintese_TERCEIRAserieturmadescritorPORTUGUES';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_sintese_QUARTAserieturmadescritorPORTUGUES';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_sintese_QUINTAserieturmadescritorPORTUGUES';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_sintese_SEXTAserieturmadescritorPORTUGUES';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_sintese_SETIMAserieturmadescritorPORTUGUES';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_sintese_OITAVAserieturmadescritorPORTUGUES';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_sintese_NONAAserieturmadescritorPORTUGUES';}
                
            }
            
            $sql.=" where 1=1";
            if(isset($params['cd_turma'])){
                $sql .= "   and cd_turma=".$params['cd_turma'];}
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
                    $sql.=" )res order by 1,2";
                    $query=$this->db->query($sql);
                    return $query->result();
                    
        }else{
            echo 'erro de colunas';die;
        }
        
    }
    
    public function buscaInteligenciaEscolaDescritor($params){
        
        $colunas=$this->colunas($params);
        //print_r($colunas);die;
        //echo $this->db->last_query();die;
        
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select topico as nm_matriz_topico, ds_codigo as ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas,nm_descritor
                from";
            if($params['cd_disciplina']==1){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_sintese_PRIMEIRAserieturmadescritorMATEMATICA';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_sintese_SEGUNDAserieturmadescritorMATEMATICA';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_sintese_TERCEIRAserieturmadescritorMATEMATICA';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_sintese_QUARTAserieturmadescritorMATEMATICA';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_sintese_QUINTAserieturmadescritorMATEMATICA';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_sintese_SEXTAserieturmadescritorMATEMATICA';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_sintese_SETIMAserieturmadescritorMATEMATICA';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_sintese_OITAVAserieturmadescritorMATEMATICA';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_sintese_NONAAserieturmadescritorMATEMATICA';}
                
            }
            
            if($params['cd_disciplina']==2){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_sintese_PRIMEIRAserieturmadescritorPORTUGUES';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_sintese_SEGUNDAserieturmadescritorPORTUGUES';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_sintese_TERCEIRAserieturmadescritorPORTUGUES';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_sintese_QUARTAserieturmadescritorPORTUGUES';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_sintese_QUINTAserieturmadescritorPORTUGUES';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_sintese_SEXTAserieturmadescritorPORTUGUES';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_sintese_SETIMAserieturmadescritorPORTUGUES';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_sintese_OITAVAserieturmadescritorPORTUGUES';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_sintese_NONAAserieturmadescritorPORTUGUES';}
                
            }
            
            $sql.=" where 1=1";
            if(isset($params['cd_turma'])){
                $sql .= "   and cd_turma=".$params['cd_turma'];}
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
                    $sql.=" )res order by 1,2";
                    $query=$this->db->query($sql);
                    return $query->result();
                    
        }else{
            echo 'erro de colunas';die;
        }
        
    }
    
    public function buscaResultadoEscolaNew($params){        
        $sql="select
	cd_disciplina,
	nm_caderno,
	topico,
	descritor,
	count(res.ci_aluno) as tt,
	sum(acertos) as acerto
from (
	select al.ci_aluno, al.nm_aluno, au.nm_caderno, nr_questao, md.ds_codigo as descritor, mt.nm_matriz_topico as topico, au.cd_disciplina,
			case
				when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
				else 0
			end as acertos
	from  tb_ultimaenturmacao ent		
		inner join tb_turma t on ent.cd_turma = t.ci_turma
		inner join tb_aluno al on ent.cd_aluno = al.ci_aluno and al.fl_ativo = true	
		inner join tb_avaliacao_upload au on t.cd_etapa = au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload = am.cd_avaliacao_upload	
		inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico	
		inner join tb_avaliacao_aluno aa on aa.cd_avaliacao_itens=am.ci_avaliacao_matriz 
			and aa.cd_aluno=al.ci_aluno 
			and aa.cd_situacao_aluno<>7
                where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_escola'])){
            $sql .= " and t.cd_escola=".$params['cd_escola'];}
        if(isset($params['nr_anoletivo'])){
                $sql .= " and ent.nr_anoletivo=".$params['nr_anoletivo'];}
                        
        $sql.=" ) res
                    group by cd_disciplina,
	                           nm_caderno,
	                            topico,
	                            descritor
                    order by 1,2;";
                        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaInteligenciaMunicipioDescritor($params){
        
        $colunas=$this->colunas($params);
        
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select topico as nm_matriz_topico, ds_codigo as ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas
                from";
            if($params['cd_disciplina']==1){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_municipio_PRIMEIRAserieturmadescritorMATEMATICA';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_municipio_SEGUNDAserieturmadescritorMATEMATICA';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_municipio_TERCEIRAserieturmadescritorMATEMATICA';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_municipio_QUARTAserieturmadescritorMATEMATICA';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_municipio_QUINTAserieturmadescritorMATEMATICA';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_municipio_SEXTAserieturmadescritorMATEMATICA';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_municipio_SETIMAserieturmadescritorMATEMATICA';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_municipio_OITAVAserieturmadescritorMATEMATICA';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_municipio_NONAAserieturmadescritorMATEMATICA';}
                
            }
            
            if($params['cd_disciplina']==2){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_municipio_PRIMEIRAserieturmadescritorPORTUGUES';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_municipio_SEGUNDAserieturmadescritorPORTUGUES';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_municipio_TERCEIRAserieturmadescritorPORTUGUES';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_municipio_QUARTAserieturmadescritorPORTUGUES';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_municipio_QUINTAserieturmadescritorPORTUGUES';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_municipio_SEXTAserieturmadescritorPORTUGUES';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_municipio_SETIMAserieturmadescritorPORTUGUES';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_municipio_OITAVAserieturmadescritorPORTUGUES';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_municipio_NONAAserieturmadescritorPORTUGUES';}
                
            }
            
            $sql.=" where 1=1";
            if(isset($params['cd_cidade'])){
                $sql .= "   and cd_municipio=".$params['cd_cidade'];}
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
                    $sql.=" )res order by 1,2";
                    $query=$this->db->query($sql);
                    return $query->result();
                    
        }else{
            echo 'erro de colunas';die;
        }
        
    }
    
    public function buscaResultadoMunicipioNew($params){  
        $sql="select * from tb_resultadomunicipio where cd_etapa=".$params['cd_etapa'];
            $sql .= " and nr_anoletivo=".$params['nr_anoletivo']." and ci_cidade=".$params['cd_cidade'];
            
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadoEscolaLeitura($params){
        $sql="select tur.*, tau.ci_avaliacao_upload,tau.nm_caderno,tau.cd_disciplina,tau.cd_avalia_tipo,count(distinct taa.cd_aluno) as leitura,count(distinct escrita.cd_aluno)
                    from
                    	(
                    	select tur.ci_turma, tur.nm_turma, tur.cd_etapa, 
                    		   tur.nr_ano_letivo as nr_anoletivo, te.cd_cidade, 
                    		   count(distinct cd_aluno) as enturmacao
                    	from
                    		tb_turma tur
                    	inner join tb_escola te on
                    		tur.cd_escola = te.ci_escola
                    	inner join tb_ultimaenturmacao tu on
                    		tu.cd_turma = tur.ci_turma
                    	where tur.cd_etapa =".$params['cd_etapa']."
                        		and tur.cd_escola =".$params['cd_escola']."
                        		and tur.nr_ano_letivo=".$params['nr_anoletivo']." 
                        	group by ci_turma,nm_turma,cd_etapa,nr_ano_letivo,cd_cidade 
                        
                        ) tur
                    inner join tb_avaliacao_cidade tac on tac.cd_cidade = tur.cd_cidade and extract(year from tac.dt_final)= tur.nr_anoletivo
                    inner join tb_avaliacao_upload tau on
                    	tac.cd_avaliacao_upload = tau.ci_avaliacao_upload
                    	and tau.cd_etapa = tur.cd_etapa
                    	and tau.fl_ativo = true
                    inner join tb_ultimaenturmacao tu on
                    	tu.cd_turma = tur.ci_turma
                    left join tb_avaliacaoleitura_aluno taa on
                    	taa.cd_avaliacao_upload = tau.ci_avaliacao_upload
                    	and taa.cd_aluno = tu.cd_aluno
                    					
                    left join (
                    	select cd_avaliacao_upload,cd_aluno from tb_avaliacao_matriz am 	
                    			inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
                    			inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico	
                    			inner join tb_avaliacao_aluno aa on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens 					 
                    ) escrita on escrita.cd_avaliacao_upload=tau.ci_avaliacao_upload and tu.cd_aluno = escrita.cd_aluno					
                    	
                    group by
                    	ci_turma,
                    	nm_turma,
                    	tur.cd_etapa,
                    	tur.nr_anoletivo,
                    	tur.cd_cidade,
                    	tur.enturmacao,
                    	tau.ci_avaliacao_upload,
                    	tau.nm_caderno,
                        tau.cd_disciplina,
                        tau.cd_avalia_tipo
                    order by
                    	1,
                    	tau.cd_avalia_tipo,
                    	upper(nm_caderno),
                    	tau.ci_avaliacao_upload;
                    ";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadopacertoTurma($params){
        $sql="select round(sum(acertos)*100/count(*),2) as pacertoturma 
                from (select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
		inner join tb_turma t on ent.cd_turma=t.ci_turma
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                and aa.cd_situacao_aluno<>7 ";
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    if(isset($params['cd_aluno'])){
                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                        
                        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc ) res";
                        
                        $query=$this->db->query($sql);
                        return $query->result();
    }
    
    public function buscaResultadopacertoescola($params){
        $sql="select round(sum(acertos)*100/count(*),2) as pacertoescola
                from (select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		        case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	    from tb_escola esc 		
		inner join tb_turma t on t.cd_escola=esc.ci_escola and t.cd_escola=".$params['cd_escola']."
                and t.cd_etapa=".$params['cd_etapa']."
				and t.nr_ano_letivo=".$params['nr_anoletivo']."
        inner join tb_ultimaenturmacao ent on ent.cd_turma=t.ci_turma
        inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where aa.cd_situacao_aluno<>7 ";
        if(isset($params['cd_aluno'])){
                $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                        
        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc ) res";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadopacertomunicipio($params){
        $sql="select round(sum(acertos)*100/count(*),2) as pacertomunicipio
                from (select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		        case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	    from tb_escola esc 		
		inner join tb_turma t on t.cd_escola=esc.ci_escola and esc.cd_cidade=".$params['cd_cidade']."
                and t.cd_etapa=".$params['cd_etapa']."
				and t.nr_ano_letivo=".$params['nr_anoletivo']."
        inner join tb_ultimaenturmacao ent on ent.cd_turma=t.ci_turma
        inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where aa.cd_situacao_aluno<>7 ";
        
        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc ) res";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaSinteseMunicipio($params){
        $sql="select * from tb_sintesemunicipio tur
              where tur.cd_etapa =".$params['cd_etapa']."
                        		and tur.cd_cidade =".$params['cd_cidade']."
                        		and tur.nr_anoletivo=".$params['nr_anoletivo'];
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoMunicipio($params){
        $sql=" select traa.*,tma.*,
    round(replace(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia), ',', '.')::numeric, 1) as proficiencia,
	                    td.ds_descricaofaixa,td.estilo,
    replace(coalesce(plp.ds_abaixo_basico, pmt.ds_abaixo_basico), ',', '.')::numeric as ds_abaixo_basico,
	replace(coalesce(plp.ds_basico, pmt.ds_basico), ',', '.')::numeric as ds_basico,
	replace(coalesce(plp.ds_intermediario, pmt.ds_intermediario), ',', '.')::numeric as ds_intermediario,
	replace(coalesce(plp.ds_adequado, pmt.ds_adequado), ',', '.')::numeric as ds_adequado 

from tb_percentacertomunicipio traa

 inner join tb_etapa te on traa.cd_etapa=te.ci_etapa 
 inner join tb_cidade tc on traa.cd_cidade=tc.ci_cidade 
 
 left join tb_metas_aprendizagem tma on
	traa.cd_cidade = tma.cd_municipio
	and traa.ano = tma.nr_anoletivo
	and tma.cd_etapa = traa.cd_etapa
	and traa.cd_disciplina = tma.cd_disciplina
	
	
left join tb_import_proficiencia_municipios_lp plp on traa.ano = plp.ano
	and traa.cd_disciplina = 2
	and fc_retira_all(plp.ds_etapa)= fc_retira_all(te.nm_etapa)
	and fc_retira_all(tc.nm_cidade)=fc_retira_all(plp.ds_municipio)
	
left join tb_import_proficiencia_municipios_mt pmt on
	traa.ano = pmt.ano
	and traa.cd_disciplina = 1
	and fc_retira_all(pmt.ds_etapa)= fc_retira_all(te.nm_etapa)
	and fc_retira_all(tc.nm_cidade)=fc_retira_all(pmt.ds_municipio)

left join tb_faixa_proficiencia tfp on
		round(replace(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia),',','.')::numeric, 1)>= tfp.nr_inicio
	and round(replace(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia),',','.')::numeric, 1)<= tfp.nr_fim

left join tb_descricaofaixa td on tfp.cd_descricaofaixa=td.ci_descricaofaixa and td.fl_ativo=true

                 
            where traa.cd_cidade=".$params['cd_cidade']."
                        and traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."            
                order by 4;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoMunicipioEscola($params){
        $sql=" select * from ( 
                select char_length(replace(replace(nm_caderno,'<td><label>',''),'</label></td>','&'))-
                    char_length(replace(replace(replace(nm_caderno,'<td><label>',''),'</label></td>','&'),'&','')) as nr_cadernos,
                    *, coalesce(pmt.vl_proficiencia,plp.vl_proficiencia) as proficiencia from tb_percentacertomunicipioescola pme

inner join tb_etapa te on pme.cd_etapa=te.ci_etapa
left join tb_import_proficiencia_escolas_lp plp on
	pme.nr_inep::numeric = plp.nr_inep_escola
	and pme.ano = plp.ano
	and pme.cd_disciplina = 2
	and fc_retira_all(plp.ds_etapa)= fc_retira_all(te.nm_etapa)
	
left join tb_import_proficiencia_escolas_mt pmt on
	pme.nr_inep::numeric = pmt.nr_inep_escola
	and pme.ano = pmt.ano
	and pme.cd_disciplina = 1
	and fc_retira_all(pmt.ds_etapa)= fc_retira_all(te.nm_etapa)

left join tb_faixa_proficiencia tfp on
		round(replace(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia),',','.')::numeric, 1)>= tfp.nr_inicio
	and round(replace(coalesce(plp.vl_proficiencia, pmt.vl_proficiencia),',','.')::numeric, 1)<= tfp.nr_fim

left join tb_descricaofaixa td on
	tfp.cd_descricaofaixa = td.ci_descricaofaixa
	and td.fl_ativo = true

               where pme.cd_cidade=".$params['cd_cidade']."
                                    and pme.ano=".$params['nr_anoletivo']."
                                    and pme.cd_etapa=".$params['cd_etapa']."
            ) res 
            order by 6,1 desc;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    public function buscaResultadopacertoEstado($params){
        $sql="select round(sum(acertos)*100/count(*),2) as pacertomunicipio
                from (select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
		inner join tb_turma t on ent.cd_turma=t.ci_turma
        inner join tb_escola esc on t.cd_escola=esc.ci_escola
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                and aa.cd_situacao_aluno<>7 ";
        if(isset($params['cd_cidade'])){
            $sql .= " and esc.cd_cidade=".$params['cd_cidade'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    if(isset($params['cd_aluno'])){
                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                        
                        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc ) res";
                        
                        $query=$this->db->query($sql);
                        return $query->result();
    }
    
    public function buscaSinteseEstado($params){
        $sql="select cd_avalia_tipo,cd_disciplina,
                	cd_etapa,nr_anoletivo,
                	nm_estado,nm_caderno,
                    sum(enturmacao) as enturmacao,
                	sum(leitura) as leitura,
                	sum(escrita) as escrita
                from (
                select tur.*, tau.ci_avaliacao_upload,tau.nm_caderno,tau.cd_disciplina,tau.cd_avalia_tipo,count(distinct taa.cd_aluno) as leitura,
                		count(distinct escrita.cd_aluno) as escrita
                    from
                    	(
                    	select tur.ci_turma, te2.nm_estado, tc.nm_cidade, tur.cd_etapa, 
                               tur.nr_ano_letivo as nr_anoletivo, te.cd_cidade, count(distinct cd_aluno) as enturmacao
                		from tb_ultimaenturmacao tu
                			inner join tb_turma tur on tu.cd_turma = tur.ci_turma
                		    inner join tb_escola te on tur.cd_escola = te.ci_escola
                		    inner join tb_cidade tc on te.cd_cidade = tc.ci_cidade
                		    inner join tb_estado te2 on tc.cd_estado = te2.ci_estado
                		where tu.nr_anoletivo=".$params['nr_anoletivo']." 
                    	       and tur.cd_etapa =".$params['cd_etapa']."
                               and te2.ci_estado =".$params['cd_estado']."
                        group by ci_turma,te2.nm_estado,nm_cidade,cd_etapa,nr_ano_letivo,cd_cidade
                        		    
                       ) tur
                    inner join tb_avaliacao_cidade tac on tac.cd_cidade = tur.cd_cidade and extract(year from tac.dt_final)=".$params['nr_anoletivo']."
                    inner join tb_avaliacao_upload tau on
                    	tac.cd_avaliacao_upload = tau.ci_avaliacao_upload
                    	and tau.cd_etapa = tur.cd_etapa
                    	and tau.fl_ativo = true
                    inner join tb_ultimaenturmacao tu on
                    	tu.cd_turma = tur.ci_turma
                    left join tb_avaliacaoleitura_aluno taa on
                    	taa.cd_avaliacao_upload = tau.ci_avaliacao_upload
                    	and taa.cd_aluno = tu.cd_aluno
                        		    
                    left join (
                    	select cd_avaliacao_upload,cd_aluno from tb_avaliacao_matriz am
                    			inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
                    			inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
                    			inner join tb_avaliacao_aluno aa on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                    ) escrita on escrita.cd_avaliacao_upload=tau.ci_avaliacao_upload and tu.cd_aluno = escrita.cd_aluno
                        		    
                   group by
                    	ci_turma,
                    	nm_estado,
                    	nm_cidade,
                    	tur.cd_etapa,
                    	tur.nr_anoletivo,
                    	tur.cd_cidade,
                    	tur.enturmacao,
                    	tau.ci_avaliacao_upload,
                    	tau.nm_caderno,
                        tau.cd_disciplina,
                        tau.cd_avalia_tipo
                    order by
                    	1,
                    	tau.cd_avalia_tipo,
                    	upper(nm_caderno),
                    	tau.ci_avaliacao_upload
                    ) rest
                    group by cd_avalia_tipo,cd_disciplina,
                    	cd_etapa,nr_anoletivo,
                    	nm_estado,nm_caderno;
                    ";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoEstado($params){
        $sql=" select au.cd_disciplina,
                	nm_caderno,
                		sum(traa.acerto),
	                    count(distinct traa.ci_aluno) as fizeram,
	                    (select count(cd_aluno) as enturmacao from tb_ultimaenturmacao tu
                                 inner join tb_turma t on tu.cd_turma=t.ci_turma
                                 inner join tb_escola esc on t.cd_escola=esc.ci_escola
                                 inner join tb_cidade tc on esc.cd_cidade=tc.ci_cidade 
                				 inner join tb_estado te on tc.cd_estado =te.ci_estado 
                            where te.ci_estado=".$params['cd_estado']."
                                    and t.nr_ano_letivo=".$params['nr_anoletivo']."
                                    and t.cd_etapa=".$params['cd_etapa'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto,
                        coalesce(profpt.vl_proficiencia,profmt.vl_proficiencia) as vl_proficiencia,
	                    td.ds_descricaofaixa,td.estilo
             from tb_resultado_aluno_avaliacao traa
                    inner join tb_ultimaenturmacao tu2 on traa.ci_aluno=tu2.cd_aluno and traa.ano=tu2.nr_anoletivo
                	inner join tb_avaliacao_upload au on traa.ci_avaliacao_upload=au.ci_avaliacao_upload
                	inner join tb_escola esc on traa.cd_escola=esc.ci_escola
                	inner join tb_cidade tc on esc.cd_cidade=tc.ci_cidade 
                	inner join tb_estado te on tc.cd_estado =te.ci_estado
                    inner join tb_etapa tep on tep.ci_etapa=traa.cd_etapa 
                	left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		and traa.ano=tma.nr_anoletivo
                		and tma.cd_etapa=traa.cd_etapa 
                		and traa.cd_disciplina=tma.cd_disciplina 
                		and (traa.cd_escola=tma.cd_escola or (tma.cd_escola is null or tma.cd_escola=0))
left join  (select  tc.cd_estado, fc_retira_all(ds_etapa) as ds_etapa, ano, sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia	 
					from tb_import_proficiencia_municipios_lp
						inner join tb_cidade tc on fc_retira_all(ds_municipio)=fc_retira_all(tc.nm_cidade) 
				group by tc.cd_estado,ds_etapa,ano
			) profpt on profpt.ano = traa.ano
	and profpt.ds_etapa= fc_retira_all(tep.nm_etapa)
	and au.cd_disciplina = 2
	and profpt.cd_estado=te.ci_estado
	
left join (select  tc.cd_estado, fc_retira_all(ds_etapa) as ds_etapa, ano, sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia	 
					from tb_import_proficiencia_municipios_mt tipmm 
						inner join tb_cidade tc on fc_retira_all(ds_municipio)=fc_retira_all(tc.nm_cidade) 
				group by tc.cd_estado,ds_etapa,ano
			) profmt on profmt.ano = traa.ano
	and profmt.ds_etapa= fc_retira_all(tep.nm_etapa)
	and au.cd_disciplina = 1
	and profmt.cd_estado=te.ci_estado
	
	
left join tb_faixa_proficiencia tfp on
	coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia) >= tfp.nr_inicio
	and coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia) <= tfp.nr_fim
	
left join tb_descricaofaixa td on
	tfp.cd_descricaofaixa = td.ci_descricaofaixa
	and td.fl_ativo = true

            where te.ci_estado=".$params['cd_estado']."
                        and traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."
            group by au.cd_disciplina,
                	nm_caderno,
                	tma.nr_percentual,
                    profpt.vl_proficiencia,profmt.vl_proficiencia,
	               td.ds_descricaofaixa,td.estilo
                order by 1;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    public function buscaPercentAcertoMunicipioEstado($params){
        $sql=" select nm_estado, au.cd_disciplina, nm_caderno,
	                  sum(traa.acerto),count(distinct traa.ci_aluno) as fizeram,
                        	(
                        	select
                        		count(cd_aluno) as enturmacao
                        	from
                        		tb_ultimaenturmacao tu
                        	inner join tb_turma t on
                        		tu.cd_turma = t.ci_turma
                        	inner join tb_escola esc on
                        		t.cd_escola = esc.ci_escola
                        	inner join tb_cidade tc on
                        	tc.ci_cidade=esc.cd_cidade 
                        	inner join tb_estado te on tc.cd_estado=te.ci_estado	
                        	where
                        		tc.cd_estado =".$params['cd_estado']."
                                    and t.nr_ano_letivo=".$params['nr_anoletivo']."
                                    and t.cd_etapa=".$params['cd_etapa'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto
                from tb_resultado_aluno_avaliacao traa
                        inner join tb_avaliacao_upload au on
                        	traa.ci_avaliacao_upload = au.ci_avaliacao_upload
                        inner join tb_escola esc on
                        	traa.cd_escola = esc.ci_escola
                        inner join tb_cidade tc on
                        	tc.ci_cidade=esc.cd_cidade 
                        inner join tb_estado te on tc.cd_estado=te.ci_estado 	
                        left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		  and traa.ano=tma.nr_anoletivo
                		  and tma.cd_etapa=traa.cd_etapa 
                		  and traa.cd_disciplina=tma.cd_disciplina 
                		  and (traa.cd_escola=tma.cd_escola or tma.cd_escola is null)
                        where
                        	tc.cd_estado =".$params['cd_estado']."
                        and traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."
            group by nm_estado, au.cd_disciplina,nm_caderno,tma.nr_percentual
            order by 2,1;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaInteligenciaEstadoDescritor($params){
        //print_r($params);die;
        
        $colunas=$this->colunas($params);
        
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select topico as nm_matriz_topico, ds_codigo as ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas,nm_descritor
                from";
            if($params['cd_disciplina']==1){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_estado_PRIMEIRAserieturmadescritorMATEMATICA';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_estado_SEGUNDAserieturmadescritorMATEMATICA';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_estado_TERCEIRAserieturmadescritorMATEMATICA';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_estado_QUARTAserieturmadescritorMATEMATICA';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_estado_QUINTAserieturmadescritorMATEMATICA';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_estado_SEXTAserieturmadescritorMATEMATICA';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_estado_SETIMAserieturmadescritorMATEMATICA';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_estado_OITAVAserieturmadescritorMATEMATICA';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_estado_NONAAserieturmadescritorMATEMATICA';}
                
            }
            
            if($params['cd_disciplina']==2){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_estado_PRIMEIRAserieturmadescritorPORTUGUES';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_estado_SEGUNDAserieturmadescritorPORTUGUES';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_estado_TERCEIRAserieturmadescritorPORTUGUES';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_estado_QUARTAserieturmadescritorPORTUGUES';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_estado_QUINTAserieturmadescritorPORTUGUES';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_estado_SEXTAserieturmadescritorPORTUGUES';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_estado_SETIMAserieturmadescritorPORTUGUES';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_estado_OITAVAserieturmadescritorPORTUGUES';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_estado_NONAAserieturmadescritorPORTUGUES';}
                
            }
            
            $sql.=" where 1=1";
            if(isset($params['cd_estado'])){
                $sql .= "   and cd_estado=".$params['cd_estado'];}
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
                    $sql.=" )res order by 1,2";
                    $query=$this->db->query($sql);
                    return $query->result();
                    
        }else{
            echo 'erro de colunas';die;
        }
        
    }
    
    public function buscaInteligenciaEPVDescritor($params){
        //print_r($params);die;
        
        $colunas=$this->colunas($params);
        
        if(isset($colunas) && !empty($colunas)){
            //print_r($colunas[0]->nm_caderno);die;
            $sql=" select res.*, replace(replace(replace(colunas::text,'$',''),'&',','),'@','') as provas
                from (
                select topico as nm_matriz_topico, ds_codigo as ds_descritor,".$colunas[0]->nm_caderno.",".
                "'".$colunas[0]->colunas."'"." as colunas,nm_descritor
                from";
            if($params['cd_disciplina']==1){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_EPV_PRIMEIRAserieturmadescritorMATEMATICA';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_EPV_SEGUNDAserieturmadescritorMATEMATICA';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_EPV_TERCEIRAserieturmadescritorMATEMATICA';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_EPV_QUARTAserieturmadescritorMATEMATICA';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_EPV_QUINTAserieturmadescritorMATEMATICA';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_EPV_SEXTAserieturmadescritorMATEMATICA';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_EPV_SETIMAserieturmadescritorMATEMATICA';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_EPV_OITAVAserieturmadescritorMATEMATICA';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_EPV_NONAserieturmadescritorMATEMATICA';}
                
            }
            
            if($params['cd_disciplina']==2){
                //17	Ensino Fundamental de 9 anos - 1º Ano
                if($params['cd_etapa']==17){$sql.=' tb_EPV_PRIMEIRAserieturmadescritorPORTUGUES';}
                //18	Ensino Fundamental de 9 anos - 2º Ano
                if($params['cd_etapa']==18){$sql.=' tb_EPV_SEGUNDAserieturmadescritorPORTUGUES';}
                //19	Ensino Fundamental de 9 anos - 3º Ano
                if($params['cd_etapa']==19){$sql.=' tb_EPV_TERCEIRAserieturmadescritorPORTUGUES';}
                //20	Ensino Fundamental de 9 anos - 4º Ano
                if($params['cd_etapa']==20){$sql.=' tb_EPV_QUARTAserieturmadescritorPORTUGUES';}
                //21	Ensino Fundamental de 9 anos - 5º Ano
                if($params['cd_etapa']==21){$sql.=' tb_EPV_QUINTAserieturmadescritorPORTUGUES';}
                //23	Ensino Fundamental de 9 anos - 6º Ano
                if($params['cd_etapa']==23){$sql.=' tb_EPV_SEXTAserieturmadescritorPORTUGUES';}
                //24	Ensino Fundamental de 9 anos - 7º Ano
                if($params['cd_etapa']==24){$sql.=' tb_EPV_SETIMAserieturmadescritorPORTUGUES';}
                //25	Ensino Fundamental de 9 anos - 8º Ano
                if($params['cd_etapa']==25){$sql.=' tb_EPV_OITAVAserieturmadescritorPORTUGUES';}
                //26	Ensino Fundamental de 9 anos - 9º Ano
                if($params['cd_etapa']==26){$sql.=' tb_EPV_NONAserieturmadescritorPORTUGUES';}
                
            }
            
            $sql.=" where 1=1";            
                if(isset($params['nr_anoletivo'])){
                    $sql .= "   and nr_anoletivo=".$params['nr_anoletivo'];}
                    $sql.=" )res order by 1,2";
                    $query=$this->db->query($sql);
                    return $query->result();
                    
        }else{
            echo 'erro de colunas';die;
        }
        
    }
    
    public function buscaResultadoEstado($params){
        $sql=" select
	cd_disciplina,
	nm_caderno,
	topico,
	descritor,
	count(res.ci_aluno) as tt,
	sum(acertos) as acerto
from
	(
select ci_aluno, nm_aluno, au.nm_caderno, nr_questao, md.ds_codigo as descritor, mt.nm_matriz_topico as topico, au.cd_disciplina,
		ress.cd_etapa,
		case
			when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
			else 0
		end as acertos from (
select * from tb_ultimaenturmacao ent		
	inner join tb_turma t on ent.cd_turma = t.ci_turma 	
	inner join tb_escola esc on t.cd_escola = esc.ci_escola
	inner join tb_cidade cid on esc.cd_cidade = cid.ci_cidade
	inner join tb_estado est on cid.cd_estado = est.ci_estado 
	inner join tb_aluno al on ent.cd_aluno = al.ci_aluno and al.fl_ativo = true
where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_estado'])){
            $sql .= " and est.ci_estado=".$params['cd_estado'];}
            if(isset($params['nr_anoletivo'])){
                $sql .= " and ent.nr_anoletivo=".$params['nr_anoletivo'];}
                
                $sql .= "  )ress                
                inner join tb_avaliacao_upload au on ress.cd_etapa = au.cd_etapa
                inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
                inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
                inner join tb_avaliacao_aluno aa on ress.ci_aluno = aa.cd_aluno
                and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                and aa.cd_situacao_aluno <> 7
                ) res
                group by
                cd_disciplina,
                nm_caderno,
                topico,
                descritor
                order by 1,2;";
                
                $query=$this->db->query($sql);
                return $query->result();
    }
    //EPV
    public function buscaResultadopacertoEpv($params){
        $sql="select round(sum(acertos)*100/count(*),2) as pacertomunicipio
                from (select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	from tb_ultimaenturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
		inner join tb_turma t on ent.cd_turma=t.ci_turma
        inner join tb_escola esc on t.cd_escola=esc.ci_escola
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            where t.cd_etapa=".$params['cd_etapa']." and al.fl_ativo=true
                and aa.cd_situacao_aluno<>7 ";
            //if(isset($params['cd_cidade'])){$sql .= " and esc.cd_cidade=".$params['cd_cidade'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
                if(isset($params['cd_avaliacao'])){
                    $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
                    if(isset($params['cd_aluno'])){
                        $sql .= "   and al.ci_aluno=".$params['cd_aluno'];}
                        
                        $sql.=" order by al.nm_aluno,mt.nm_matriz_topico,nr_questao,md.ds_codigo,am.fl_ativo desc ) res";
                        
                        $query=$this->db->query($sql);
                        return $query->result();
    }
    
    public function buscaSinteseEpv($params){
        $sql="select * from tb_epv
              where cd_etapa =".$params['cd_etapa']."
                and nr_anoletivo=".$params['nr_anoletivo'];
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaleituraestado($params){
        $sql=" select ano,
			taa.cd_etapa,
	nm_caderno as nm_caderno,
	sum(fizeram) as fizeram,
	(sum(fizeram)* 100)/ sum(enturmado) as particiapacao,
	(sum(fizeram)* 100)/ sum(enturmado) as nrpart,
	sum(enturmado) as enturmado,
	tma.nr_percentual as meta
	from
		tb_avaliacaocidadeleituraepv taa
            inner join tb_cidade tc on taa.ci_cidade=tc.ci_cidade
            inner join tb_metas_aprendizagem tma on tma.cd_municipio=tc.ci_cidade 	
	               and taa.cd_etapa=tma.cd_etapa and tma.nr_anoletivo=ano and tma.cd_disciplina=99
	where taa.cd_etapa=".$params['cd_etapa'];
        $sql .= " and taa.ano=".$params['nr_anoletivo'];
        $sql .= " and tc.cd_estado=".$params['cd_estado'];
        if($params['cd_etapa']==18){
            $sql.=" and taa.conceito in (5,6)";
        }else{
            $sql.=" and taa.conceito in (6)";
        }
        
        $sql.=" group by ano,taa.cd_etapa,nm_caderno,tma.nr_percentual order by 3 asc;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaleituraepv($params){
        $sql=" select taa.nm_cidade,ano,
		taa.cd_etapa,
		nm_caderno as nm_caderno,
		sum(fizeram) as fizeram,
		round((sum(fizeram)* 100)/ sum(enturmado),1) as participacao,
		round((sum(fizeram)* 100)/ sum(enturmado),1) as nrpart,
		sum(enturmado) as enturmado,
        tma.nr_percentual as meta
	from
		tb_avaliacaocidadeleituraepv taa
            inner join tb_cidade tc on taa.ci_cidade=tc.ci_cidade
            left join tb_metas_aprendizagem tma on tma.cd_municipio=tc.ci_cidade
	               and taa.cd_etapa=tma.cd_etapa and tma.nr_anoletivo=ano and tma.cd_disciplina=99
	where taa.cd_etapa=".$params['cd_etapa'];
        $sql .= " and taa.ano=".$params['nr_anoletivo'];
        if($params['cd_etapa']==18){
            $sql.=" and taa.conceito in (5,6)";
        }else{
            $sql.=" and taa.conceito in (6)";
        }
        
        $sql.=" group by taa.nm_cidade,ano,taa.cd_etapa,nm_caderno,tma.nr_percentual order by 1,3,4 asc;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    public function buscaleituraepvmunicipio($params){
        $sql="select nm_cidade,ano,cd_etapa,meta,
	replace(replace(array_agg('<td><label>'||nm_caderno||'</label></td>')::text,'{',''),'}','') as caderno,
		'\"'||replace(replace(array_agg(nrpart)::text,'{',''),'}','')||'\"'::text as pacerto,
        '\"'||replace(replace(array_agg(participacao)::text,'{',''),'}','')||'\"'::text as particiapacao,
		replace(replace(replace(replace(array_agg('<td>%Participação:'||round(((fizeram*100)/enturmado),2)||'</br>%Acerto:'||participacao||'</td>' )::text,'{',''),'}',''),',',''),'\"','') as participacao,
	array_agg(enturmado),
	count(distinct nm_caderno)as  nr_cadernos
from (
 
select taa.nm_cidade,ano,
		taa.cd_etapa,
		nm_caderno as nm_caderno,
		sum(fizeram) as fizeram,
		round((sum(fizeram)* 100)/ sum(enturmado),1) as participacao,
		round((sum(fizeram)* 100)/ sum(enturmado),1) as nrpart,
		sum(enturmado) as enturmado,
        tma.nr_percentual as meta
	from
		tb_avaliacaocidadeleituraepv taa
            inner join tb_cidade tc on taa.ci_cidade=tc.ci_cidade
            left join tb_metas_aprendizagem tma on tma.cd_municipio=tc.ci_cidade 	
	               and taa.cd_etapa=tma.cd_etapa and tma.nr_anoletivo=ano and tma.cd_disciplina=99
	where taa.cd_etapa=".$params['cd_etapa'];
        $sql .= " and taa.ano=".$params['nr_anoletivo'];
        if($params['cd_etapa']==18){
            $sql.=" and taa.conceito in (5,6)";
        }else{
            $sql.=" and taa.conceito in (6)";
        }
        
        $sql.=" group by taa.nm_cidade,ano,taa.cd_etapa,nm_caderno,tma.nr_percentual order by 1,3,4 asc

) res
group by nm_cidade,ano,cd_etapa,meta
order by count(distinct nm_caderno) desc;
";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoEpv($params){
        $sql=" select
	traa.ano,
	traa.cd_etapa,
	traa.cd_disciplina,
	nm_caderno,
	sum(traa.nr_percentual) as nr_percentual,
	sum(acerto) as acerto,
	sum(fizeram) as fizeram,
	sum(enturmado) as enturmado,
	sum(nrquestoes) as questoes,
	round((sum(acerto)* 100 / sum(nrquestoes)), 2) as pacerto,tma.nr_percentual,
        coalesce(SUM(profpt.vl_proficiencia),SUM(profmt.vl_proficiencia))/COUNT(*) as vl_proficiencia,
	    td.ds_descricaofaixa,td.estilo
from
	tb_percent_acertoepv traa
		
                    inner join tb_etapa tep on tep.ci_etapa=traa.cd_etapa 
                	left join tb_metas_aprendizagem tma on traa.ano=tma.nr_anoletivo
                		and tma.cd_etapa=traa.cd_etapa 
                		and traa.cd_disciplina=tma.cd_disciplina 
                		
left join (
	select
		tc.cd_estado,
		ci_etapa,
		ano,
		sum(replace(vl_proficiencia, ',', '.')::numeric)/ count(*) as vl_proficiencia
	from
		tb_import_proficiencia_municipios_lp
	inner join tb_cidade tc on
		fc_retira_all(ds_municipio)= fc_retira_all(tc.nm_cidade)
	group by
		tc.cd_estado,
		ci_etapa,
		ano ) profpt on
	profpt.ano = traa.ano
	and profpt.ci_etapa = tep.ci_etapa
	and TRAA.cd_disciplina = 2
	and profpt.cd_estado = tRAA.ci_estado
	
left join (
	select
		tc.cd_estado,
		ci_etapa,
		ano,
		sum(replace(vl_proficiencia, ',', '.')::numeric)/ count(*) as vl_proficiencia
	from
		tb_import_proficiencia_municipios_mt tipmm
	inner join tb_cidade tc on
		fc_retira_all(ds_municipio)= fc_retira_all(tc.nm_cidade)
	group by
		tc.cd_estado,
		ci_etapa,
		ano ) profmt on
	profmt.ano = traa.ano
	and profmt.ci_etapa = tep.ci_etapa
	and TRAA.cd_disciplina = 1
	and profmt.cd_estado = tRAA.ci_estado
left join tb_faixa_proficiencia tfp on
	round(coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia)::numeric, 1)>= tfp.nr_inicio
	and round(coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia)::numeric, 1)<= tfp.nr_fim

left join tb_descricaofaixa td on
	tfp.cd_descricaofaixa = td.ci_descricaofaixa
	and td.fl_ativo = true	

            where  traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa'];
        $sql.=" group by traa.ano,traa.cd_etapa,traa.cd_disciplina,nm_caderno,tma.nr_percentual,                
                td.ds_descricaofaixa,td.estilo
                 order by 3,4;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPercentAcertoEstadoEpv($params){
        $sql=" select ci_estado,
	nm_estado,
	ano,
	cd_etapa,
    cd_disciplina,
    	count(distinct(nm_caderno)) as nrcadernos,
	replace(replace(replace(array_agg('<td><label>'||nm_caderno||'</label></td>')::text,'{',''),'}',''),'\"','') as nm_caderno,
	replace(replace(array_agg(acerto)::text,'{',''),'}','') as acerto,
	replace(replace(array_agg(fizeram)::text,'{',''),'}','') as fizeram,
	replace(replace(replace(replace(array_agg('<td>%Participação:'||round(((fizeram*100)/enturmado),2)||'</br>%Acerto:'||pacerto||'</td>' )::text,'{',''),'}',''),',',''),'\"','') as participacao,
    replace(replace(array_agg( ((fizeram*100)/enturmado))::text,'{',''),'}','') as nrpart,
	replace(replace(array_agg(enturmado)::text,'{',''),'}','') as enturmado,
	replace(replace(array_agg(questoes)::text,'{',''),'}','') as questoes,
	replace(replace(array_agg(pacerto)::text, '{', ''), '}', '') as pacerto,
	nr_percentual,
	vl_proficiencia,
	ds_descricaofaixa,
	estilo

from (
select
	ci_estado,
	nm_estado,
	traa.ano,
	traa.cd_etapa,
	traa.cd_disciplina,
	traa.nm_caderno,
	traa.nr_percentual,
	sum(acerto) as acerto,
	sum(fizeram) as fizeram,
	sum(enturmado) as enturmado,
	sum(nrquestoes) as questoes,
	round((sum(acerto)* 100 / sum(nrquestoes)), 2) as pacerto,
		coalesce(SUM(profpt.vl_proficiencia), SUM(profmt.vl_proficiencia))/ COUNT(*) as vl_proficiencia,
		td.ds_descricaofaixa,
		td.estilo
from tb_percent_acertoepv traa
	inner join tb_etapa tep on
		tep.ci_etapa = traa.cd_etapa
	left join tb_metas_aprendizagem tma on
		traa.ano = tma.nr_anoletivo
		and tma.cd_etapa = traa.cd_etapa
		and traa.cd_disciplina = tma.cd_disciplina
	left join (
		select
			tc.cd_estado,
			tipml.ci_etapa,
			ano,
			sum(replace(vl_proficiencia, ',', '.')::numeric)/ count(*) as vl_proficiencia
		from
			tb_import_proficiencia_municipios_lp tipml
		inner join tb_cidade tc on
			fc_retira_all(ds_municipio)= fc_retira_all(tc.nm_cidade)
		group by
			tc.cd_estado,
			tipml.ci_etapa,
			ano ) profpt on
		profpt.ano = traa.ano
		and profpt.ci_etapa = tep.ci_etapa
		and TRAA.cd_disciplina = 1
		and profpt.cd_estado = tRAA.ci_estado
	left join (
		select
			tc.cd_estado,
			tipmm.ci_etapa,
			ano,
			sum(replace(vl_proficiencia, ',', '.')::numeric)/ count(*) as vl_proficiencia
		from
			tb_import_proficiencia_municipios_mt tipmm
		inner join tb_cidade tc on
			fc_retira_all(ds_municipio)= fc_retira_all(tc.nm_cidade)
		group by
			tc.cd_estado,
			tipmm.ci_etapa,
			ano ) profmt on
		profmt.ano = traa.ano
		and profmt.ci_etapa = tep.ci_etapa
		and TRAA.cd_disciplina = 1
		and profmt.cd_estado = tRAA.ci_estado
	left join tb_faixa_proficiencia tfp on
		round(coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia)::numeric, 1)>= tfp.nr_inicio
		and round(coalesce(profpt.vl_proficiencia, profmt.vl_proficiencia)::numeric, 1)<= tfp.nr_fim
	left join tb_descricaofaixa td on
		tfp.cd_descricaofaixa = td.ci_descricaofaixa
		and td.fl_ativo = true
                    	
            where  traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa'];
        $sql.=" group by ci_estado,
		nm_estado,
		traa.ano,
		traa.cd_etapa,
		traa.cd_disciplina,
		nm_caderno,
		traa.nr_percentual,
		td.ds_descricaofaixa,
		td.estilo
	order by
		1,
		5,
		6 ) res
group by
	ci_estado,
	nm_estado,
	ano,
	cd_etapa,
	cd_disciplina,
	nr_percentual,
	vl_proficiencia,
	ds_descricaofaixa,
	estilo
order by
	5,
	6 desc,
	2 ;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    public function buscaPercentMunicipioAcertoEpv($params){
        $sql=" select nm_estado, au.cd_disciplina, nm_caderno,
	                  sum(traa.acerto),count(distinct traa.ci_aluno) as fizeram,
                        	(
                        	select
                        		count(cd_aluno) as enturmacao
                        	from
                        		tb_ultimaenturmacao tu
                        	inner join tb_turma t on
                        		tu.cd_turma = t.ci_turma
                        	inner join tb_escola esc on
                        		t.cd_escola = esc.ci_escola
                        	inner join tb_cidade tc on
                        	tc.ci_cidade=esc.cd_cidade
                        	inner join tb_estado te on tc.cd_estado=te.ci_estado
                        	where t.nr_ano_letivo=".$params['nr_anoletivo']."
                                    and t.cd_etapa=".$params['cd_etapa'].") as enturmado,
                		sum(nr_questoes),
                		coalesce(tma.nr_percentual,0) as nr_percentual,
                		round((sum(traa.acerto)*100)/sum(nr_questoes),2) as pacerto
                from tb_resultado_aluno_avaliacao traa
                        inner join tb_avaliacao_upload au on
                        	traa.ci_avaliacao_upload = au.ci_avaliacao_upload
                        inner join tb_escola esc on
                        	traa.cd_escola = esc.ci_escola
                        inner join tb_cidade tc on
                        	tc.ci_cidade=esc.cd_cidade
                        inner join tb_estado te on tc.cd_estado=te.ci_estado
                        left join tb_metas_aprendizagem tma on traa.cd_cidade=tma.cd_municipio
                		      and traa.ano=tma.nr_anoletivo
                		      and tma.cd_etapa=traa.cd_etapa 
                		      and traa.cd_disciplina=tma.cd_disciplina 
                		      and (traa.cd_escola=tma.cd_escola or tma.cd_escola is null)
                        where traa.ano=".$params['nr_anoletivo']."
                        and traa.cd_etapa=".$params['cd_etapa']."
            group by nm_estado, au.cd_disciplina,nm_caderno,tma.nr_percentual
            order by 2,1;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadoEpv($params){
        $sql=" select * from tb_resultadoepv t
                where t.cd_etapa=".$params['cd_etapa'];
        //if(isset($params['cd_estado'])){$sql .= " and est.ci_estado=".$params['cd_estado'];}
            if(isset($params['nr_anoletivo'])){
                $sql .= " and t.nr_anoletivo=".$params['nr_anoletivo'];}                
                $sql.=" order by 3,4;";                
                $query=$this->db->query($sql);
                return $query->result();
    }
    
    public function buscaPercentAcertoEscolaEpv($params){
        $sql=" select * from tb_percentacertoescola t
                where t.cd_etapa=".$params['cd_etapa'];
        //if(isset($params['cd_estado'])){$sql .= " and est.ci_estado=".$params['cd_estado'];}
        if(isset($params['nr_anoletivo'])){
            $sql .= " and t.ano=".$params['nr_anoletivo'];}
            $sql.=" order by 3,4;";
            $query=$this->db->query($sql);
            return $query->result();
    }
    
    public function avaliacaoturmaleituraepv($params){
        $sql="select * from tb_avaliacaoturmaleituraepv taa        	
            where taa.cd_etapa=".$params['cd_etapa'];
        $sql .= " and taa.ano=".$params['nr_anoletivo'];
        if($params['cd_etapa']==18){
            $sql.=" and taa.conceito in (5,6)";
        }else{
            $sql.=" and taa.conceito in (6)";
        }
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function avaliacaocidadeleituraepv($params){
        $sql="select taa.ci_cidade,nm_cidade,ano,cd_etapa,
                        count(nm_caderno) as nr_cadernos,
                    	replace(replace(array_agg('<td><label>'||nm_caderno||'</label></td>')::text,'{',''),'}','') as nm_caderno,
                    	replace(replace(array_agg(fizeram)::text,'{',''),'}','') as fizeram,
                        replace(replace(array_agg( ((fizeram*100)/enturmado))::text,'{',''),'}','') as particiapacao,
                        replace(replace(array_agg( '<td><label>'||((fizeram*100)/enturmado)||'</label></td>')::text,'{',''),'}','') as nrpart,
                    	replace(replace(array_agg(distinct enturmado)::text,'{',''),'}','') as enturmado
            from tb_avaliacaocidadeleituraepv taa
                    where taa.cd_etapa=".$params['cd_etapa'];
        $sql .= " and taa.ano=".$params['nr_anoletivo'];
        if($params['cd_etapa']==18){
            $sql.=" and taa.conceito in (5,6)";
        }else{
            $sql.=" and taa.conceito in (6)";
        }
        
        $sql.=" group by taa.ci_cidade,nm_cidade,ano,cd_etapa
            order by 5 desc;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    
    
    public function buscaPercentAcertoCidadeEpv($params){
        $sql=" select ci_cidade,
	nm_cidade,
	res.ano,
	res.cd_etapa,
    res.cd_disciplina,
    count(distinct(nm_caderno)) as nr_cadernos,
	replace(replace(array_agg('<td><label>'||nm_caderno||'</label></td>')::text,'{',''),'}','') as nm_caderno,
	replace(replace(array_agg(acerto)::text,'{',''),'}','') as acerto,
	replace(replace(array_agg(fizeram)::text,'{',''),'}','') as fizeram,
	replace(replace(replace(replace(array_agg('<td>%Participação:'||round(((fizeram*100)/enturmado),2)||'</br>%Acerto:'||pacerto||'</td>' )::text,'{',''),'}',''),',',''),'\"','') as participacao,
    replace(replace(array_agg( ((fizeram*100)/enturmado))::text,'{',''),'}','') as nrpart,
	replace(replace(array_agg(enturmado)::text,'{',''),'}','') as enturmado,
	replace(replace(array_agg(questoes)::text,'{',''),'}','') as questoes,
	replace(replace(array_agg(pacerto)::text, '{', ''), '}', '') as pacerto,
    tma.nr_percentual as meta,
    coalesce(tipml.vl_proficiencia,tipmm.vl_proficiencia) as vl_proficiencia,
	td.ds_descricaofaixa,td.estilo
from (
select
	traa.ci_cidade,
	traa.nm_cidade,
	ano,
	cd_etapa,
	cd_disciplina,
	nm_caderno,
	nr_percentual,
	sum(acerto) as acerto,
	sum(fizeram) as fizeram,
	sum(enturmado) as enturmado,
	sum(nrquestoes) as questoes,
	round((sum(acerto)* 100 / sum(nrquestoes)), 2) as pacerto
from tb_percentacertocidadeepv traa
        inner join tb_cidade tc on traa.ci_cidade=tc.ci_cidade
    where  traa.ano=".$params['nr_anoletivo']."
           and traa.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_estado']) && !empty($params['cd_estado'])){ $sql.=" and tc.cd_estado=".$params['cd_estado'];}
        $sql.=" group by
	traa.ci_cidade,
	traa.nm_cidade,
	ano,
	cd_etapa,
	cd_disciplina,
	nm_caderno,
	nr_percentual
order by 1,5,6 ) res
inner join tb_etapa te on te.ci_etapa=res.cd_etapa
    		LEFT join tb_metas_aprendizagem tma on tma.cd_municipio=res.ci_cidade 
                        and tma.cd_etapa=res.cd_etapa 
                        and tma.nr_anoletivo=res.ano 
                        and res.cd_disciplina=tma.cd_disciplina 
		left join tb_import_proficiencia_municipios_lp tipml on tipml.ano=res.ano 
                    and tipml.ci_etapa=te.ci_etapa 
                    and res.cd_disciplina=2 
                    and fc_retira_all(tipml.ds_municipio)=fc_retira_all(res.nm_cidade) 
		left join tb_import_proficiencia_municipios_mt tipmm on tipmm.ano=res.ano 
                    and tipmm.ci_etapa=te.ci_etapa
                    and res.cd_disciplina=1 
                    and fc_retira_all(tipmm.ds_municipio)=fc_retira_all(res.nm_cidade)
		left join tb_faixa_proficiencia tfp on 
								replace(coalesce(tipml.vl_proficiencia,tipmm.vl_proficiencia),',','.')::numeric>=tfp.nr_inicio 
								and  replace(coalesce(tipml.vl_proficiencia,tipmm.vl_proficiencia),',','.')::numeric<=tfp.nr_fim 
		left join tb_descricaofaixa td on tfp.cd_descricaofaixa=td.ci_descricaofaixa and td.fl_ativo=true				

group by ci_cidade,
	nm_cidade,
	res.ano,
	res.cd_etapa,
	res.cd_disciplina,
	tma.nr_percentual,
    tipml.vl_proficiencia,tipmm.vl_proficiencia,
	td.ds_descricaofaixa,td.estilo
order by 5,6 desc,2;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function testeresultado($param){
       $sql=" select cd_disciplina,
        topico,
        nm_caderno,
        cod_descritor,
        sum(acertos) as acertos
        from
        (
            select
            distinct al.ci_aluno, al.nm_aluno, au.nm_caderno, au.cd_disciplina, md.ds_codigo as cod_descritor, mt.nm_matriz_topico as topico,
        case
            when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
            else 0
            end as acertos
            from
            tb_ultimaenturmacao ent
            inner join tb_aluno al on
            ent.cd_aluno = al.ci_aluno
            inner join tb_turma t on
            ent.cd_turma = t.ci_turma
            inner join tb_avaliacao_upload au on
            t.cd_etapa = au.cd_etapa
            inner join tb_avaliacao_matriz am on
            au.ci_avaliacao_upload = am.cd_avaliacao_upload
            inner join tb_matriz_descritor md on
            am.cd_matriz_descritor = md.ci_matriz_descritor
            inner join tb_matriz_topico mt on
            mt.ci_matriz_topico = md.cd_matriz_topico
            inner join tb_avaliacao_aluno aa on
            al.ci_aluno = aa.cd_aluno
            and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
            where
            t.cd_etapa = 18
            and al.fl_ativo = true
            and aa.cd_situacao_aluno <> 7
            and ent.cd_turma = 10394
            and al.ci_aluno = 32005
            and cd_disciplina=1) res
            group by
            nm_caderno,
            cd_disciplina,
            cod_descritor,
            topico
            order by
            cd_disciplina,
            topico,
            cod_descritor,
            nm_caderno;";
       
       $query=$this->db->query($sql);
       return $query->result();
    }
    
    public function testedescritores($param){
        $sql="select distinct cd_disciplina,
	topico,	
	cod_descritor
from
	(
	select
		distinct al.ci_aluno, al.nm_aluno, au.nm_caderno, au.cd_disciplina, md.ds_codigo as cod_descritor, mt.nm_matriz_topico as topico,
		case
			when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
			else 0
		end as acertos
	from
		tb_ultimaenturmacao ent
	inner join tb_aluno al on
		ent.cd_aluno = al.ci_aluno
	inner join tb_turma t on
		ent.cd_turma = t.ci_turma
	inner join tb_avaliacao_upload au on
		t.cd_etapa = au.cd_etapa
	inner join tb_avaliacao_matriz am on
		au.ci_avaliacao_upload = am.cd_avaliacao_upload
	inner join tb_matriz_descritor md on
		am.cd_matriz_descritor = md.ci_matriz_descritor
	inner join tb_matriz_topico mt on
		mt.ci_matriz_topico = md.cd_matriz_topico
	inner join tb_avaliacao_aluno aa on
		al.ci_aluno = aa.cd_aluno
		and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
	where
		t.cd_etapa = 18
		and al.fl_ativo = true
		and aa.cd_situacao_aluno <> 7
		and ent.cd_turma = ".$param['cd_turma']."
		and al.ci_aluno =".$param['cd_aluno']."
		and cd_disciplina=1) res
group by
	nm_caderno,
	cd_disciplina,
	cod_descritor,
	topico
order by
	cd_disciplina,	
	topico,
	cod_descritor;";
        $query=$this->db->query($sql);
        return $query->result();
    }


    public function avaliacaocaedaluno($params){

        if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
        }
        if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
        }                

        $sql="select distinct descritor, 
		vl_proficiencia,
		vl_perc_acertos,DS_DESCRICAOFAIXA,ESTILO,
('@'||ROUND(sum(d001_acerto),2)||'&')::text  d001, 
'@'||ROUND(sum(d001_total),2)||'&'  d001tt, 
'@'||ROUND(sum(d002_acerto),2)||'&'  d002, 
'@'||ROUND(sum(d002_total),2)||'&'  d002tt, 
'@'||ROUND(sum(d003_acerto),2)||'&'  d003,
'@'||ROUND(sum(d003_total),2)||'&'  d003tt,
'@'||ROUND(sum(d004_acerto),2)||'&'  d004,
'@'||ROUND(sum(d004_total),2)||'&'  d004tt,
'@'||ROUND(sum(d005_acerto),2)||'&'  d005,
'@'||ROUND(sum(d005_total),2)||'&'  d005tt,
'@'||ROUND(sum(d007_acerto),2)||'&'  d007,
'@'||ROUND(sum(d007_total),2)||'&'  d007tt,
'@'||ROUND(sum(d008_acerto),2)||'&'  d008,
'@'||ROUND(sum(d008_total),2)||'&'  d008tt,
'@'||ROUND(sum(d009_acerto),2)||'&'  d009,
'@'||ROUND(sum(d009_total),2)||'&'  d009tt,
'@'||ROUND(sum(d010_acerto),2)||'&'  d010,
'@'||ROUND(sum(d010_total),2)||'&'  d010tt,
'@'||ROUND(sum(d011_acerto),2)||'&'  d011,
'@'||ROUND(sum(d011_total),2)||'&'  d011tt,
'@'||ROUND(sum(d012_acerto),2)||'&'  d012,
'@'||ROUND(sum(d012_total),2)||'&'  d012tt,
'@'||ROUND(sum(d013_acerto),2)||'&'  d013,
'@'||ROUND(sum(d013_total),2)||'&'  d013tt,
'@'||ROUND(sum(d014_acerto),2)||'&'  d014,
'@'||ROUND(sum(d014_total),2)||'&'  d014tt,
'@'||ROUND(sum(d015_acerto),2)||'&'  d015,
'@'||ROUND(sum(d015_total),2)||'&'  d015tt,
'@'||ROUND(sum(d016_acerto),2)||'&'  d016,
'@'||ROUND(sum(d016_total),2)||'&'  d016tt,
'@'||ROUND(sum(d017_acerto),2)||'&'  d017,
'@'||ROUND(sum(d017_total),2)||'&'  d017tt,
'@'||ROUND(sum(d018_acerto),2)||'&'  d018,
'@'||ROUND(sum(d018_total),2)||'&'  d018tt,
'@'||ROUND(sum(d019_acerto),2)||'&'  d019,
'@'||ROUND(sum(d019_total),2)||'&'  d019tt,
'@'||ROUND(sum(d020_acerto),2)||'&'  d020,
'@'||ROUND(sum(d020_total),2)||'&'  d020tt,
'@'||ROUND(sum(d021_acerto),2)||'&'  d021,
'@'||ROUND(sum(d021_total),2)||'&'  d021tt,
'@'||ROUND(sum(d022_acerto),2)||'&'  d022,
'@'||ROUND(sum(d022_total),2)||'&'  d022tt,
'@'||ROUND(sum(d023_acerto),2)||'&'  d023,
'@'||ROUND(sum(d023_total),2)||'&'  d023tt,
'@'||ROUND(sum(d024_acerto),2)||'&'  d024tt,
'@'||ROUND(sum(d024_total),2)||'&'  d024tt,
'@'||ROUND(sum(d025_acerto),2)||'&'  d025,
'@'||ROUND(sum(d025_total),2)||'&'  d025tt,
'@'||ROUND(sum(d026_acerto),2)||'&'  d026,
'@'||ROUND(sum(d026_total),2)||'&'  d026tt
from 
(	select column_name, table_schema,
		tmd.ds_codigo as descritor
	from information_schema.columns ic
	  inner join tb_matriz_descritor tmd 
	  	on upper(tmd.ds_descritorcaed)=upper(substring(column_name from 0 for position('_' in column_name))) 
	  	and tmd.ds_descritorcaed is not null
	  inner join tb_matriz_topico tmt on tmt.ci_matriz_topico=tmd.cd_matriz_topico 
	  inner join tb_matriz tm on tmt.cd_matriz=tm.ci_matriz	and tm.cd_disciplina=1 
	WHERE table_name = '".$tabela."' 
	) ava,
    (select *  from ".$tabela." tmm
        inner join tb_faixa_proficiencia tfp on 
			( replace(TMM.vl_proficiencia,',','.')::numeric>=tfp.nr_inicio and replace(TMM.vl_proficiencia,',','.')::numeric<=tfp.nr_fim)			
		inner join tb_descricaofaixa  df on tfp.cd_descricaofaixa=df.ci_descricaofaixa
    where vl_proficiencia<>'' and  
        TMM.cd_alunoSAEV =".$params['cd_aluno']." 
 	 	and tmm.nu_ano = ".$params['nr_anoletivo']."
		) dados
group by descritor,
        vl_proficiencia,
        vl_perc_acertos,DS_DESCRICAOFAIXA,ESTILO";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }


    public function avaliacaocaedsinteseturma($params){

        if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
        }
        if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
        }                

        $sql="select distinct descritor, DS_DESCRICAOFAIXA,ESTILO,
		sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia,
		sum(vl_perc_acertos)*100/count(*) as vl_perc_acertos,

case when sum(d001_total)>0 then '@' || ROUND(sum(d001_acerto)* 100 / sum(d001_total),2)|| '&' else '@' || ROUND(sum(d001_acerto)* 100 / 1 ,2)|| '&'  end as d001,
case when sum(d002_total)>0 then '@' || ROUND(sum(d002_acerto)* 100 / sum(d002_total),2)|| '&' else '@' || ROUND(sum(d002_acerto)* 100 / 1,2)|| '&'  end as d002,
case when sum(d003_total)>0 then '@' || ROUND(sum(d003_acerto)* 100 / sum(d003_total),2)|| '&' else '@' || ROUND(sum(d003_acerto)* 100 / 1,2)|| '&'  end as d003,
case when sum(d004_total)>0 then '@' || ROUND(sum(d004_acerto)* 100 / sum(d004_total),2)|| '&' else '@' || ROUND(sum(d004_acerto)* 100 / 1,2)|| '&'  end as d004,
case when sum(d005_total)>0 then '@' || ROUND(sum(d005_acerto)* 100 / sum(d005_total),2)|| '&' else '@' || ROUND(sum(d005_acerto)* 100 / 1,2)|| '&'  end as d005,
case when sum(d007_total)>0 then '@' || ROUND(sum(d007_acerto)* 100 / sum(d007_total),2)|| '&' else '@' || ROUND(sum(d007_acerto)* 100 / 1,2)|| '&'  end as d007,
case when sum(d008_total)>0 then '@' || ROUND(sum(d008_acerto)* 100 / sum(d008_total),2)|| '&' else '@' || ROUND(sum(d008_acerto)* 100 / 1,2)|| '&'  end as d008,
case when sum(d009_total)>0 then '@' || ROUND(sum(d009_acerto)* 100 / sum(d009_total),2)|| '&' else '@' || ROUND(sum(d009_acerto)* 100 / 1,2)|| '&'  end as d009,
case when sum(d010_total)>0 then '@' || ROUND(sum(d010_acerto)* 100 / sum(d010_total),2)|| '&' else '@' || ROUND(sum(d010_acerto)* 100 / 1,2)|| '&'  end as d010,
case when sum(d011_total)>0 then '@' || ROUND(sum(d011_acerto)* 100 / sum(d011_total),2)|| '&' else '@' || ROUND(sum(d011_acerto)* 100 / 1,2)|| '&'  end as d011,
case when sum(d012_total)>0 then '@' || ROUND(sum(d012_acerto)* 100 / sum(d012_total),2)|| '&' else '@' || ROUND(sum(d012_acerto)* 100 / 1,2)|| '&'  end as d012,
case when sum(d013_total)>0 then '@' || ROUND(sum(d013_acerto)* 100 / sum(d013_total),2)|| '&' else '@' || ROUND(sum(d013_acerto)* 100 / 1,2)|| '&'  end as d013,
case when sum(d014_total)>0 then '@' || ROUND(sum(d014_acerto)* 100 / sum(d014_total),2)|| '&' else '@' || ROUND(sum(d014_acerto)* 100 / 1,2)|| '&'  end as d014,
case when sum(d015_total)>0 then '@' || ROUND(sum(d015_acerto)* 100 / sum(d015_total),2)|| '&' else '@' || ROUND(sum(d015_acerto)* 100 / 1,2)|| '&'  end as d015,
case when sum(d016_total)>0 then '@' || ROUND(sum(d016_acerto)* 100 / sum(d016_total),2)|| '&' else '@' || ROUND(sum(d016_acerto)* 100 / 1,2)|| '&'  end as d016,
case when sum(d017_total)>0 then '@' || ROUND(sum(d017_acerto)* 100 / sum(d017_total),2)|| '&' else '@' || ROUND(sum(d017_acerto)* 100 / 1,2)|| '&'  end as d017,
case when sum(d018_total)>0 then '@' || ROUND(sum(d018_acerto)* 100 / sum(d018_total),2)|| '&' else '@' || ROUND(sum(d018_acerto)* 100 / 1,2)|| '&'  end as d018,
case when sum(d019_total)>0 then '@' || ROUND(sum(d019_acerto)* 100 / sum(d019_total),2)|| '&' else '@' || ROUND(sum(d019_acerto)* 100 / 1,2)|| '&'  end as d019,
case when sum(d020_total)>0 then '@' || ROUND(sum(d020_acerto)* 100 / sum(d020_total),2)|| '&' else '@' || ROUND(sum(d020_acerto)* 100 / 1,2)|| '&'  end as d020,
case when sum(d021_total)>0 then '@' || ROUND(sum(d021_acerto)* 100 / sum(d021_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d021,
case when sum(d022_total)>0 then '@' || ROUND(sum(d022_acerto)* 100 / sum(d022_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d022,
case when sum(d023_total)>0 then '@' || ROUND(sum(d023_acerto)* 100 / sum(d023_total),2)|| '&' else '@' || ROUND(sum(d023_acerto)* 100 / 1,2)|| '&'  end as d023,
case when sum(d024_total)>0 then '@' || ROUND(sum(d024_acerto)* 100 / sum(d024_total),2)|| '&' else '@' || ROUND(sum(d024_acerto)* 100 / 1,2)|| '&'  end as d024,
case when sum(d025_total)>0 then '@' || ROUND(sum(d025_acerto)* 100 / sum(d025_total),2)|| '&' else '@' || ROUND(sum(d025_acerto)* 100 / 1,2)|| '&'  end as d025,
case when sum(d026_total)>0 then '@' || ROUND(sum(d026_acerto)* 100 / sum(d026_total),2)|| '&' else '@' || ROUND(sum(d026_acerto)* 100 / 1,2)|| '&'  end as d026
from 
(	select column_name, table_schema,
		tmd.ds_codigo as descritor
	from information_schema.columns ic
	  inner join tb_matriz_descritor tmd 
	  	on upper(tmd.ds_descritorcaed)=upper(substring(column_name from 0 for position('_' in column_name))) 
	  	and tmd.ds_descritorcaed is not null
	  inner join tb_matriz_topico tmt on tmt.ci_matriz_topico=tmd.cd_matriz_topico 
	  inner join tb_matriz tm on tmt.cd_matriz=tm.ci_matriz	and tm.cd_disciplina=1 
	WHERE table_name = '".$tabela."' 
	) ava,
    (select *  from ".$tabela." tmm
        inner join tb_faixa_proficiencia tfp on 
			( replace(TMM.vl_proficiencia,',','.')::numeric>=tfp.nr_inicio and replace(TMM.vl_proficiencia,',','.')::numeric<=tfp.nr_fim)			
		inner join tb_descricaofaixa  df on tfp.cd_descricaofaixa=df.ci_descricaofaixa
    where vl_proficiencia<>'' and   
        TMM.cd_turmasaev =".$params['cd_turma']." 
 	 	and tmm.nu_ano = ".$params['nr_anoletivo']."        
		) dados
group by descritor,DS_DESCRICAOFAIXA,ESTILO";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }

    public function avaliacaocaedsinteseescola($params){

        if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
        }
        if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
        }                

        $sql="select distinct descritor, 
		sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia,
		sum(vl_perc_acertos)*100/count(*) as vl_perc_acertos,

case when sum(d001_total)>0 then '@' || ROUND(sum(d001_acerto)* 100 / sum(d001_total),2)|| '&' else '@' || ROUND(sum(d001_acerto)* 100 / 1 ,2)|| '&'  end as d001,
case when sum(d002_total)>0 then '@' || ROUND(sum(d002_acerto)* 100 / sum(d002_total),2)|| '&' else '@' || ROUND(sum(d002_acerto)* 100 / 1,2)|| '&'  end as d002,
case when sum(d003_total)>0 then '@' || ROUND(sum(d003_acerto)* 100 / sum(d003_total),2)|| '&' else '@' || ROUND(sum(d003_acerto)* 100 / 1,2)|| '&'  end as d003,
case when sum(d004_total)>0 then '@' || ROUND(sum(d004_acerto)* 100 / sum(d004_total),2)|| '&' else '@' || ROUND(sum(d004_acerto)* 100 / 1,2)|| '&'  end as d004,
case when sum(d005_total)>0 then '@' || ROUND(sum(d005_acerto)* 100 / sum(d005_total),2)|| '&' else '@' || ROUND(sum(d005_acerto)* 100 / 1,2)|| '&'  end as d005,
case when sum(d007_total)>0 then '@' || ROUND(sum(d007_acerto)* 100 / sum(d007_total),2)|| '&' else '@' || ROUND(sum(d007_acerto)* 100 / 1,2)|| '&'  end as d007,
case when sum(d008_total)>0 then '@' || ROUND(sum(d008_acerto)* 100 / sum(d008_total),2)|| '&' else '@' || ROUND(sum(d008_acerto)* 100 / 1,2)|| '&'  end as d008,
case when sum(d009_total)>0 then '@' || ROUND(sum(d009_acerto)* 100 / sum(d009_total),2)|| '&' else '@' || ROUND(sum(d009_acerto)* 100 / 1,2)|| '&'  end as d009,
case when sum(d010_total)>0 then '@' || ROUND(sum(d010_acerto)* 100 / sum(d010_total),2)|| '&' else '@' || ROUND(sum(d010_acerto)* 100 / 1,2)|| '&'  end as d010,
case when sum(d011_total)>0 then '@' || ROUND(sum(d011_acerto)* 100 / sum(d011_total),2)|| '&' else '@' || ROUND(sum(d011_acerto)* 100 / 1,2)|| '&'  end as d011,
case when sum(d012_total)>0 then '@' || ROUND(sum(d012_acerto)* 100 / sum(d012_total),2)|| '&' else '@' || ROUND(sum(d012_acerto)* 100 / 1,2)|| '&'  end as d012,
case when sum(d013_total)>0 then '@' || ROUND(sum(d013_acerto)* 100 / sum(d013_total),2)|| '&' else '@' || ROUND(sum(d013_acerto)* 100 / 1,2)|| '&'  end as d013,
case when sum(d014_total)>0 then '@' || ROUND(sum(d014_acerto)* 100 / sum(d014_total),2)|| '&' else '@' || ROUND(sum(d014_acerto)* 100 / 1,2)|| '&'  end as d014,
case when sum(d015_total)>0 then '@' || ROUND(sum(d015_acerto)* 100 / sum(d015_total),2)|| '&' else '@' || ROUND(sum(d015_acerto)* 100 / 1,2)|| '&'  end as d015,
case when sum(d016_total)>0 then '@' || ROUND(sum(d016_acerto)* 100 / sum(d016_total),2)|| '&' else '@' || ROUND(sum(d016_acerto)* 100 / 1,2)|| '&'  end as d016,
case when sum(d017_total)>0 then '@' || ROUND(sum(d017_acerto)* 100 / sum(d017_total),2)|| '&' else '@' || ROUND(sum(d017_acerto)* 100 / 1,2)|| '&'  end as d017,
case when sum(d018_total)>0 then '@' || ROUND(sum(d018_acerto)* 100 / sum(d018_total),2)|| '&' else '@' || ROUND(sum(d018_acerto)* 100 / 1,2)|| '&'  end as d018,
case when sum(d019_total)>0 then '@' || ROUND(sum(d019_acerto)* 100 / sum(d019_total),2)|| '&' else '@' || ROUND(sum(d019_acerto)* 100 / 1,2)|| '&'  end as d019,
case when sum(d020_total)>0 then '@' || ROUND(sum(d020_acerto)* 100 / sum(d020_total),2)|| '&' else '@' || ROUND(sum(d020_acerto)* 100 / 1,2)|| '&'  end as d020,
case when sum(d021_total)>0 then '@' || ROUND(sum(d021_acerto)* 100 / sum(d021_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d021,
case when sum(d022_total)>0 then '@' || ROUND(sum(d022_acerto)* 100 / sum(d022_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d022,
case when sum(d023_total)>0 then '@' || ROUND(sum(d023_acerto)* 100 / sum(d023_total),2)|| '&' else '@' || ROUND(sum(d023_acerto)* 100 / 1,2)|| '&'  end as d023,
case when sum(d024_total)>0 then '@' || ROUND(sum(d024_acerto)* 100 / sum(d024_total),2)|| '&' else '@' || ROUND(sum(d024_acerto)* 100 / 1,2)|| '&'  end as d024,
case when sum(d025_total)>0 then '@' || ROUND(sum(d025_acerto)* 100 / sum(d025_total),2)|| '&' else '@' || ROUND(sum(d025_acerto)* 100 / 1,2)|| '&'  end as d025,
case when sum(d026_total)>0 then '@' || ROUND(sum(d026_acerto)* 100 / sum(d026_total),2)|| '&' else '@' || ROUND(sum(d026_acerto)* 100 / 1,2)|| '&'  end as d026
from 
(	select column_name, table_schema,
		tmd.ds_codigo as descritor
	from information_schema.columns ic
	  inner join tb_matriz_descritor tmd 
	  	on upper(tmd.ds_descritorcaed)=upper(substring(column_name from 0 for position('_' in column_name))) 
	  	and tmd.ds_descritorcaed is not null
	  inner join tb_matriz_topico tmt on tmt.ci_matriz_topico=tmd.cd_matriz_topico 
	  inner join tb_matriz tm on tmt.cd_matriz=tm.ci_matriz	and tm.cd_disciplina=1 
	WHERE table_name = '".$tabela."' 
	) ava,
    (select *  from ".$tabela." tmm
    where vl_proficiencia<>'' and  
        TMM.cd_escolasaev =".$params['cd_escola']." 
        and tmm.cd_etapasaev =".$params['cd_etapa']."     
 	 	and tmm.nu_ano = ".$params['nr_anoletivo']."        
		) dados
group by descritor";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }

    public function avaliacaocaedsintesemunicipio($params){

        if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
        }
        if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
        }                

        $sql="select distinct descritor, 
		sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia,
		sum(vl_perc_acertos)*100/count(*) as vl_perc_acertos,

case when sum(d001_total)>0 then '@' || ROUND(sum(d001_acerto)* 100 / sum(d001_total),2)|| '&' else '@' || ROUND(sum(d001_acerto)* 100 / 1 ,2)|| '&'  end as d001,
case when sum(d002_total)>0 then '@' || ROUND(sum(d002_acerto)* 100 / sum(d002_total),2)|| '&' else '@' || ROUND(sum(d002_acerto)* 100 / 1,2)|| '&'  end as d002,
case when sum(d003_total)>0 then '@' || ROUND(sum(d003_acerto)* 100 / sum(d003_total),2)|| '&' else '@' || ROUND(sum(d003_acerto)* 100 / 1,2)|| '&'  end as d003,
case when sum(d004_total)>0 then '@' || ROUND(sum(d004_acerto)* 100 / sum(d004_total),2)|| '&' else '@' || ROUND(sum(d004_acerto)* 100 / 1,2)|| '&'  end as d004,
case when sum(d005_total)>0 then '@' || ROUND(sum(d005_acerto)* 100 / sum(d005_total),2)|| '&' else '@' || ROUND(sum(d005_acerto)* 100 / 1,2)|| '&'  end as d005,
case when sum(d007_total)>0 then '@' || ROUND(sum(d007_acerto)* 100 / sum(d007_total),2)|| '&' else '@' || ROUND(sum(d007_acerto)* 100 / 1,2)|| '&'  end as d007,
case when sum(d008_total)>0 then '@' || ROUND(sum(d008_acerto)* 100 / sum(d008_total),2)|| '&' else '@' || ROUND(sum(d008_acerto)* 100 / 1,2)|| '&'  end as d008,
case when sum(d009_total)>0 then '@' || ROUND(sum(d009_acerto)* 100 / sum(d009_total),2)|| '&' else '@' || ROUND(sum(d009_acerto)* 100 / 1,2)|| '&'  end as d009,
case when sum(d010_total)>0 then '@' || ROUND(sum(d010_acerto)* 100 / sum(d010_total),2)|| '&' else '@' || ROUND(sum(d010_acerto)* 100 / 1,2)|| '&'  end as d010,
case when sum(d011_total)>0 then '@' || ROUND(sum(d011_acerto)* 100 / sum(d011_total),2)|| '&' else '@' || ROUND(sum(d011_acerto)* 100 / 1,2)|| '&'  end as d011,
case when sum(d012_total)>0 then '@' || ROUND(sum(d012_acerto)* 100 / sum(d012_total),2)|| '&' else '@' || ROUND(sum(d012_acerto)* 100 / 1,2)|| '&'  end as d012,
case when sum(d013_total)>0 then '@' || ROUND(sum(d013_acerto)* 100 / sum(d013_total),2)|| '&' else '@' || ROUND(sum(d013_acerto)* 100 / 1,2)|| '&'  end as d013,
case when sum(d014_total)>0 then '@' || ROUND(sum(d014_acerto)* 100 / sum(d014_total),2)|| '&' else '@' || ROUND(sum(d014_acerto)* 100 / 1,2)|| '&'  end as d014,
case when sum(d015_total)>0 then '@' || ROUND(sum(d015_acerto)* 100 / sum(d015_total),2)|| '&' else '@' || ROUND(sum(d015_acerto)* 100 / 1,2)|| '&'  end as d015,
case when sum(d016_total)>0 then '@' || ROUND(sum(d016_acerto)* 100 / sum(d016_total),2)|| '&' else '@' || ROUND(sum(d016_acerto)* 100 / 1,2)|| '&'  end as d016,
case when sum(d017_total)>0 then '@' || ROUND(sum(d017_acerto)* 100 / sum(d017_total),2)|| '&' else '@' || ROUND(sum(d017_acerto)* 100 / 1,2)|| '&'  end as d017,
case when sum(d018_total)>0 then '@' || ROUND(sum(d018_acerto)* 100 / sum(d018_total),2)|| '&' else '@' || ROUND(sum(d018_acerto)* 100 / 1,2)|| '&'  end as d018,
case when sum(d019_total)>0 then '@' || ROUND(sum(d019_acerto)* 100 / sum(d019_total),2)|| '&' else '@' || ROUND(sum(d019_acerto)* 100 / 1,2)|| '&'  end as d019,
case when sum(d020_total)>0 then '@' || ROUND(sum(d020_acerto)* 100 / sum(d020_total),2)|| '&' else '@' || ROUND(sum(d020_acerto)* 100 / 1,2)|| '&'  end as d020,
case when sum(d021_total)>0 then '@' || ROUND(sum(d021_acerto)* 100 / sum(d021_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d021,
case when sum(d022_total)>0 then '@' || ROUND(sum(d022_acerto)* 100 / sum(d022_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d022,
case when sum(d023_total)>0 then '@' || ROUND(sum(d023_acerto)* 100 / sum(d023_total),2)|| '&' else '@' || ROUND(sum(d023_acerto)* 100 / 1,2)|| '&'  end as d023,
case when sum(d024_total)>0 then '@' || ROUND(sum(d024_acerto)* 100 / sum(d024_total),2)|| '&' else '@' || ROUND(sum(d024_acerto)* 100 / 1,2)|| '&'  end as d024,
case when sum(d025_total)>0 then '@' || ROUND(sum(d025_acerto)* 100 / sum(d025_total),2)|| '&' else '@' || ROUND(sum(d025_acerto)* 100 / 1,2)|| '&'  end as d025,
case when sum(d026_total)>0 then '@' || ROUND(sum(d026_acerto)* 100 / sum(d026_total),2)|| '&' else '@' || ROUND(sum(d026_acerto)* 100 / 1,2)|| '&'  end as d026
from 
(	select column_name, table_schema,
		tmd.ds_codigo as descritor
	from information_schema.columns ic
	  inner join tb_matriz_descritor tmd 
	  	on upper(tmd.ds_descritorcaed)=upper(substring(column_name from 0 for position('_' in column_name))) 
	  	and tmd.ds_descritorcaed is not null
	  inner join tb_matriz_topico tmt on tmt.ci_matriz_topico=tmd.cd_matriz_topico 
	  inner join tb_matriz tm on tmt.cd_matriz=tm.ci_matriz	and tm.cd_disciplina=1 
	WHERE table_name = '".$tabela."' 
	) ava,
    (select *  from ".$tabela."  tmm
    where vl_proficiencia<>'' and  
        TMM.cd_municipiosaev =".$params['cd_cidade']." 
        and tmm.cd_etapasaev =".$params['cd_etapa']."     
 	 	and tmm.nu_ano = ".$params['nr_anoletivo']."        
		) dados
group by descritor";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }

    public function avaliacaocaedsinteseestado($params){

        if($params['cd_disciplina']==1){
                $tabela="tb_microdados_matematica";
        }
        if($params['cd_disciplina']==2){
                $tabela="tb_microdados_portugues";
        }                

        $sql="select distinct descritor, 
		sum(replace(vl_proficiencia,',','.')::numeric)/count(*) as vl_proficiencia,
		sum(vl_perc_acertos)*100/count(*) as vl_perc_acertos,

case when sum(d001_total)>0 then '@' || ROUND(sum(d001_acerto)* 100 / sum(d001_total),2)|| '&' else '@' || ROUND(sum(d001_acerto)* 100 / 1 ,2)|| '&'  end as d001,
case when sum(d002_total)>0 then '@' || ROUND(sum(d002_acerto)* 100 / sum(d002_total),2)|| '&' else '@' || ROUND(sum(d002_acerto)* 100 / 1,2)|| '&'  end as d002,
case when sum(d003_total)>0 then '@' || ROUND(sum(d003_acerto)* 100 / sum(d003_total),2)|| '&' else '@' || ROUND(sum(d003_acerto)* 100 / 1,2)|| '&'  end as d003,
case when sum(d004_total)>0 then '@' || ROUND(sum(d004_acerto)* 100 / sum(d004_total),2)|| '&' else '@' || ROUND(sum(d004_acerto)* 100 / 1,2)|| '&'  end as d004,
case when sum(d005_total)>0 then '@' || ROUND(sum(d005_acerto)* 100 / sum(d005_total),2)|| '&' else '@' || ROUND(sum(d005_acerto)* 100 / 1,2)|| '&'  end as d005,
case when sum(d007_total)>0 then '@' || ROUND(sum(d007_acerto)* 100 / sum(d007_total),2)|| '&' else '@' || ROUND(sum(d007_acerto)* 100 / 1,2)|| '&'  end as d007,
case when sum(d008_total)>0 then '@' || ROUND(sum(d008_acerto)* 100 / sum(d008_total),2)|| '&' else '@' || ROUND(sum(d008_acerto)* 100 / 1,2)|| '&'  end as d008,
case when sum(d009_total)>0 then '@' || ROUND(sum(d009_acerto)* 100 / sum(d009_total),2)|| '&' else '@' || ROUND(sum(d009_acerto)* 100 / 1,2)|| '&'  end as d009,
case when sum(d010_total)>0 then '@' || ROUND(sum(d010_acerto)* 100 / sum(d010_total),2)|| '&' else '@' || ROUND(sum(d010_acerto)* 100 / 1,2)|| '&'  end as d010,
case when sum(d011_total)>0 then '@' || ROUND(sum(d011_acerto)* 100 / sum(d011_total),2)|| '&' else '@' || ROUND(sum(d011_acerto)* 100 / 1,2)|| '&'  end as d011,
case when sum(d012_total)>0 then '@' || ROUND(sum(d012_acerto)* 100 / sum(d012_total),2)|| '&' else '@' || ROUND(sum(d012_acerto)* 100 / 1,2)|| '&'  end as d012,
case when sum(d013_total)>0 then '@' || ROUND(sum(d013_acerto)* 100 / sum(d013_total),2)|| '&' else '@' || ROUND(sum(d013_acerto)* 100 / 1,2)|| '&'  end as d013,
case when sum(d014_total)>0 then '@' || ROUND(sum(d014_acerto)* 100 / sum(d014_total),2)|| '&' else '@' || ROUND(sum(d014_acerto)* 100 / 1,2)|| '&'  end as d014,
case when sum(d015_total)>0 then '@' || ROUND(sum(d015_acerto)* 100 / sum(d015_total),2)|| '&' else '@' || ROUND(sum(d015_acerto)* 100 / 1,2)|| '&'  end as d015,
case when sum(d016_total)>0 then '@' || ROUND(sum(d016_acerto)* 100 / sum(d016_total),2)|| '&' else '@' || ROUND(sum(d016_acerto)* 100 / 1,2)|| '&'  end as d016,
case when sum(d017_total)>0 then '@' || ROUND(sum(d017_acerto)* 100 / sum(d017_total),2)|| '&' else '@' || ROUND(sum(d017_acerto)* 100 / 1,2)|| '&'  end as d017,
case when sum(d018_total)>0 then '@' || ROUND(sum(d018_acerto)* 100 / sum(d018_total),2)|| '&' else '@' || ROUND(sum(d018_acerto)* 100 / 1,2)|| '&'  end as d018,
case when sum(d019_total)>0 then '@' || ROUND(sum(d019_acerto)* 100 / sum(d019_total),2)|| '&' else '@' || ROUND(sum(d019_acerto)* 100 / 1,2)|| '&'  end as d019,
case when sum(d020_total)>0 then '@' || ROUND(sum(d020_acerto)* 100 / sum(d020_total),2)|| '&' else '@' || ROUND(sum(d020_acerto)* 100 / 1,2)|| '&'  end as d020,
case when sum(d021_total)>0 then '@' || ROUND(sum(d021_acerto)* 100 / sum(d021_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d021,
case when sum(d022_total)>0 then '@' || ROUND(sum(d022_acerto)* 100 / sum(d022_total),2)|| '&' else '@' || ROUND(sum(d022_acerto)* 100 / 1,2)|| '&'  end as d022,
case when sum(d023_total)>0 then '@' || ROUND(sum(d023_acerto)* 100 / sum(d023_total),2)|| '&' else '@' || ROUND(sum(d023_acerto)* 100 / 1,2)|| '&'  end as d023,
case when sum(d024_total)>0 then '@' || ROUND(sum(d024_acerto)* 100 / sum(d024_total),2)|| '&' else '@' || ROUND(sum(d024_acerto)* 100 / 1,2)|| '&'  end as d024,
case when sum(d025_total)>0 then '@' || ROUND(sum(d025_acerto)* 100 / sum(d025_total),2)|| '&' else '@' || ROUND(sum(d025_acerto)* 100 / 1,2)|| '&'  end as d025,
case when sum(d026_total)>0 then '@' || ROUND(sum(d026_acerto)* 100 / sum(d026_total),2)|| '&' else '@' || ROUND(sum(d026_acerto)* 100 / 1,2)|| '&'  end as d026
from 
(	select column_name, table_schema,
		tmd.ds_codigo as descritor
	from information_schema.columns ic
	  inner join tb_matriz_descritor tmd 
	  	on upper(tmd.ds_descritorcaed)=upper(substring(column_name from 0 for position('_' in column_name))) 
	  	and tmd.ds_descritorcaed is not null
	  inner join tb_matriz_topico tmt on tmt.ci_matriz_topico=tmd.cd_matriz_topico 
	  inner join tb_matriz tm on tmt.cd_matriz=tm.ci_matriz	and tm.cd_disciplina=1 
	WHERE table_name = '".$tabela."' 
	) ava,
    (select *  from ".$tabela." tmm     
    where vl_proficiencia<>'' and 
        TMM.cd_estadosaev =".$params['cd_estado']." 
        and tmm.cd_etapasaev =".$params['cd_etapa']."     
 	 	and tmm.nu_ano = ".$params['nr_anoletivo']."        
		) dados
group by descritor";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }
}
