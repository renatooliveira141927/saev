<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Avaliacoes_lancamento_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $nr_inep_aluno  = null,
                                    $nm_aluno       = null,
                                    $nr_inep_escola = null,
                                    $nm_escola      = null,
                                    $cd_cidade      = null,
                                    $cd_turma       = null,
                                    $cd_etapa       = null,
                                    $cd_turno       = null,
                                    $ci_enturmacao  = null){


        return count($this->buscar($nr_inep_aluno,
                                    $nm_aluno,
                                    $nr_inep_escola,
                                    $nm_escola,
                                    $cd_cidade,
                                    $cd_turma,
                                    $cd_etapa,
                                    $cd_turno,
                                    $ci_enturmacao));
    }
    
    public function buscar_avaliacao_cabecalho($ci_avaliacao_turma  = null){
        
        $this->db->from(' tb_avaliacao ');

        $this->db->join('tb_etapa', 'tb_avaliacao.cd_etapa = tb_etapa.ci_etapa');

        $this->db->join('tb_edicao', 'tb_avaliacao.cd_edicao = tb_edicao.ci_edicao');

        $this->db->join('tb_avaliacao_itens', 
        'tb_avaliacao.ci_avaliacao = tb_avaliacao_itens.cd_avaliacao', 
        'left');
        
        $this->db->join('tb_avaliacao_aluno', 
        'tb_avaliacao_aluno.cd_avaliacao_itens = tb_avaliacao_itens.ci_avaliacao_itens', 
        'left');

        $this->db->join('tb_aluno', 
            'tb_avaliacao_aluno.cd_aluno = tb_aluno.ci_aluno', 
            'left');

        $this->db->join('tb_enturmacao', 
            'tb_aluno.ci_aluno = tb_enturmacao.cd_aluno', 
            'left');
        
        
        if ($ci_avaliacao_turma)
        {
            $this->db->join('tb_avaliacao_turma', 
                'tb_avaliacao.ci_avaliacao = tb_avaliacao_turma.cd_avaliacao
                and tb_avaliacao_turma.ci_avaliacao_turma ='. $ci_avaliacao_turma, 
                'left');
        }else{
            $this->db->join('tb_avaliacao_turma', 
            'tb_avaliacao.ci_avaliacao = tb_avaliacao_turma.cd_avaliacao', 
            'left');
        }
        
        $this->db->where('tb_avaliacao.fl_ativo = true');

        $this->db->order_by('tb_aluno.nm_aluno', 'ASC');

        return $this->db->get()->result();

    }
    public function buscar_avaliacao_aluno( $cd_aluno  = null, $ci_avaliacao_turma  = null){

        $cd_aluno  = 1;
        $ci_avaliacao_turma  = 1;

        $query = $this->db->query(' select
                                    tb_avaliacao.ci_avaliacao,
                                    tb_avaliacao_itens.ci_avaliacao_itens,
                                    tb_Avalia_item.ci_avalia_item,
                                    tb_avaliacao.nm_caderno,
                                    tb_avaliacao.nr_ano,
                                    tb_edicao.nm_edicao,
                                    tb_Avalia_tipo.nm_avalia_tipo,
                                    tb_Disciplina.nm_disciplina,
                                    tb_etapa.nm_etapa,
                                    
                                    tb_Avalia_item.ds_enunciado,
                                    tb_avaliacao_aluno.nr_alternativa_escolhida,
                                    tb_Avalia_item.tp_questao,
                                    tb_Avalia_item.ds_img_item_01,
                                    tb_Avalia_item.ds_img_item_02,
                                    tb_Avalia_item.ds_img_item_03,
                                    tb_Avalia_item.ds_img_item_04,
                                    tb_Avalia_item.ds_primeiro_item,
                                    tb_Avalia_item.ds_segundo_item,
                                    tb_Avalia_item.ds_terceiro_item,
                                    tb_Avalia_item.ds_quarto_item
        
             
                                from tb_Avalia_item
                                
                                join tb_avaliacao_itens on
                                    tb_avaliacao_itens.cd_avalia_item = tb_Avalia_item.ci_avalia_item
                                
                                join tb_avaliacao on
                                    tb_avaliacao_itens.cd_avaliacao = tb_avaliacao.ci_avaliacao   
                                    
                                join tb_edicao on
                                    tb_avaliacao.cd_edicao = tb_edicao.ci_edicao
                                    
                                join tb_Avalia_tipo on
                                    tb_avaliacao.cd_avalia_tipo = tb_Avalia_tipo.ci_avalia_tipo
                                    
                                join tb_Disciplina on
                                    tb_avaliacao.cd_disciplina = tb_Disciplina.ci_disciplina
                                    
                                join tb_etapa on
                                    tb_avaliacao.cd_etapa = tb_etapa.ci_etapa
                                
                                left join tb_avaliacao_turma on
                                    tb_avaliacao_itens.cd_avaliacao = tb_avaliacao_turma.cd_avaliacao
                                    
                                left join tb_avaliacao_aluno on
                                    tb_avaliacao_aluno.cd_avaliacao_itens = tb_avaliacao_itens.ci_avaliacao_itens 
                                    and tb_avaliacao_aluno.cd_aluno = '.$cd_aluno.'
        
        
                        where
                            tb_avaliacao.fl_ativo = true 
                            and tb_Avalia_item.fl_ativo = true
                            and tb_avaliacao_turma.ci_avaliacao_turma ='.$ci_avaliacao_turma.'
                            
                        order by tb_avaliacao.ci_avaliacao,
                                tb_avaliacao_itens.ci_avaliacao_itens, 
                                tb_Avalia_item.ci_avalia_item
                    ');


        return $query->result();
    }

    public function buscar( $nr_inep_aluno  = null,
                            $nm_aluno       = null,
                            $nr_inep_escola = null,
                            $nm_escola      = null,
                            $cd_cidade      = null,
                            $cd_turma       = null,
                            $cd_etapa       = null,
                            $cd_turno       = null,
                            $ci_enturmacao  = null,
                            $relatorio      = null,
                            $limit          = null,
                            $offset         = null){

        $this->db->select(' tb_aluno.*,
                            tb_enturmacao.ci_enturmacao,
                            tb_enturmacao.cd_turma,
                            tb_turma.nm_turma,
                            tb_turma.cd_etapa,
                            tb_etapa.nm_etapa,
                            "tb_turno".ci_turno,
                            "tb_turno".nm_turno,
                            tb_avaliacao_turma.ci_avaliacao_turma,
                            tb_cidade.nm_cidade,
                            tb_cidade.cd_estado,
                            tb_estado.nm_estado');  
        $this->db->from('tb_aluno');

        $this->db->join('tb_enturmacao', 'tb_aluno.ci_aluno = tb_enturmacao.cd_aluno');

        if ($cd_turma)
        {
            $this->db->join('tb_turma', 'tb_enturmacao.cd_turma = tb_turma.ci_turma');
        }else{
            $this->db->join('tb_turma', 'tb_enturmacao.cd_turma = tb_turma.ci_turma');
        }
       
        if ($cd_turno)
        {
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        }else{
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        }
        if ($cd_etapa)
        {
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        }else{
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        
        }
        
        $this->db->join('tb_avaliacao_turma', 
            'tb_turma.ci_turma = tb_avaliacao_turma.cd_turma');

        $this->db->join('tb_cidade', 'tb_aluno.cd_cidade = tb_cidade.ci_cidade');
        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');        
        $this->db->where('tb_aluno.fl_ativo', 'true');
        
        if ($nr_inep_aluno)
        {
            $this->db->where('tb_aluno.nr_inep', $nr_inep_aluno);
        }
        if ($nm_aluno)
        {
            $this->db->where("remove_acentos(tb_aluno.nm_aluno) ilike remove_acentos('%".mb_strtoupper($nm_aluno, 'UTF-8')."%')");
        }
        
        if ($cd_turma)
        {
            $this->db->where('tb_turma.ci_turma', $cd_turma);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_etapa.ci_etapa', $cd_etapa);
        }
        if ($cd_turno)
        {
            $this->db->where('tb_turno.ci_turno', $cd_turno);
        }
        if ($cd_cidade)
        {
            $this->db->where('tb_aluno.cd_cidade', $cd_cidade);
        }
        
        $this->db->order_by('tb_estado.nm_estado', 'ASC');
        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
        $this->db->order_by('tb_aluno.nm_aluno', 'ASC');

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


    public function inserir($cd_alunos = null, $lancamento_avaliacao = null){
        
        $this->db->where('cd_avaliacao_itens',$lancamento_avaliacao->cd_avaliacao_itens);
        $this->db->where('cd_aluno',$cd_alunos);
        $this->db->delete('tb_avaliacao_aluno');

        $this->db->insert_batch('tb_avaliacao_aluno', $lancamento_avaliacao);
       
        return true;
        
     }
     
     

    public function buscaResultadoTopico($params){
        $sql="select topico,
	                  array_to_string(array_agg(descritor),',') as descritor,
	                  array_to_string(array_agg(acertos),',') as tt_certo,
	                  array_to_string(array_agg(pacerto),',') as pacerto
                    from (					
                    SELECT res.topico,
                           ordem,  
                           descritor as descritor, 	
                           Sum(res.acertos)                               AS acertos, 
                           Sum(res.acertos) * 100 / Count(res.nr_questao) AS pacerto 
                    FROM   (SELECT nr_questao, 
                                            mt.nm_matriz_topico       AS topico,
                                            replace(md.ds_codigo,'D','')::integer AS ordem, 
                                            md.ds_codigo AS descritor, 
                                            CASE 
                                              WHEN am.nr_opcaocorreta = aa.nr_alternativa_escolhida 
                                            THEN 1 
                                              ELSE 0 
                                            END                       AS acertos 
                            FROM   tb_enturmacao ent 
                                   INNER JOIN tb_aluno al 
                                           ON ent.cd_aluno = al.ci_aluno 
                                   INNER JOIN tb_turma t 
                                           ON ent.cd_turma = t.ci_turma 
                                   INNER JOIN tb_avaliacao_upload au 
                                           ON t.cd_etapa = au.cd_etapa 
                                   INNER JOIN tb_avaliacao_matriz am 
                                           ON au.ci_avaliacao_upload = am.cd_avaliacao_upload 
                                                 
                                   INNER JOIN tb_matriz_descritor md 
                                           ON am.cd_matriz_descritor = md.ci_matriz_descritor 
                                   INNER JOIN tb_matriz_topico mt 
                                           ON mt.ci_matriz_topico = md.cd_matriz_topico 
                                   INNER JOIN tb_avaliacao_aluno aa 
                                           ON al.ci_aluno = aa.cd_aluno 
                                              AND am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                                              and aa.cd_situacao_aluno<>7     
            where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){
            $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){
            $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
            
        if(isset($params['cd_topico']) && !empty($params['cd_topico']) && $params['cd_topico'][0]!=0 ){
            $item=implode(",",$params['cd_topico']);
            $sql .= "   and ci_matriz_topico in (".$item.")";
        }

        $sql.=" ) res GROUP BY res.topico,res.descritor,res.ordem order by ordem::integer) resultado group by topico
                order by substring(topico from 0 for position('.' in topico));";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaResultadoAluno($params){
        $sql=" select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,		
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos
	from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
		inner join tb_turma t on ent.cd_turma=t.ci_turma 
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload  
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                    and aa.cd_situacao_aluno<>7    
            where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){
            $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){
            $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}

        $sql.=" order by al.nm_aluno,nr_questao,md.ds_codigo";

        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaResultadoAlunoNew($params){
        $sql=" select distinct al.ci_aluno, al.nm_aluno, nr_questao, md.ds_codigo as descritor,
		                        mt.nm_matriz_topico as topico,
		                        md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos,am.fl_ativo
	from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
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
                    
                    $sql.=" order by al.nm_aluno,nr_questao,md.ds_codigo,am.fl_ativo desc";
                    
                    $query=$this->db->query($sql);
                    return $query->result();
    }

     public function buscaResultadoAlunoTopico($params){
         $sql="select res.ci_aluno, res.nm_aluno,res.topico,	
	count(res.nr_questao) as questoes, sum(res.acertos) as acertos, 
	sum(res.acertos)*100/count(res.nr_questao) as pacerto 
from (
	select distinct al.ci_aluno, al.nm_aluno, nr_questao, 
		mt.nm_matriz_topico as topico,
		md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,		
		case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
	from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
		inner join tb_turma t on ent.cd_turma=t.ci_turma 
		inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
		inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
		inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
		inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
		inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno 
            and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
            and aa.cd_situacao_aluno<>7    
            where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma'])){
             $sql .= " and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){
                 $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){
                     $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}

        $sql.=" order by al.ci_aluno ) res group by res.ci_aluno,res.nm_aluno,res.topico";

        $query=$this->db->query($sql);
        return $query->result();
     }

    public function buscaResultadoAlunoDescritor($params){
        $sql="select res.ci_aluno, res.nm_aluno,res.descritor,	
	                  count(res.nr_questao) as questoes, sum(res.acertos) as acertos, 
	                  sum(res.acertos)*100/count(res.nr_questao) as pacerto 
            from (
                select distinct al.ci_aluno, al.nm_aluno, nr_questao, 
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,		
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens 
                        and aa.cd_situacao_aluno<>7   
                        where t.cd_etapa=".$params['cd_etapa'];
            if(isset($params['cd_turma'])){
                $sql .= " and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){
                $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
            if(isset($params['cd_avaliacao'])){
                $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}

            $sql.=" order by al.ci_aluno ) res group by res.ci_aluno,res.nm_aluno,res.descritor";

            $query=$this->db->query($sql);
            return $query->result();
    }

    public function buscaPercentAcerto($params){
        $sql="select res.ci_aluno, sum(res.acertos)*100/count(res.nr_questao) as pacerto 
            from (
                select distinct al.ci_aluno, al.nm_aluno, nr_questao, 
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,		
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
                from tb_enturmacao ent 
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
                                and ent.fl_ativo=true and al.fl_ativo=true
                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                        and aa.cd_situacao_aluno<>7    
                        where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma'])){
            $sql .= " and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){
            $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){
            $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];}

        $sql.=" order by al.ci_aluno ) res group by res.ci_aluno";

        $query=$this->db->query($sql);
        return $query->result();

    }

    public function pesquisaPorNivelDesempenho($params){
        
        //print_r($params);die;
        $sql="select cd_nivel_desempenho,count(ci_aluno) as alunos
	       from (
			select res.ci_aluno, 						
                		round(SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric,2) AS pacerto,
                		CASE
                			WHEN round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric ),2)<= 25 THEN 1
                			WHEN round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric),2)>25
                			 AND round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric),2)<= 50 THEN 2
                            WHEN round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric),2)>50
                			 AND round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric),2)<= 75 THEN 3
                			WHEN round((SUM(res.acertos)::numeric* 100 / COUNT(res.nr_questao)::numeric),2)>75 THEN 4
                		END AS cd_nivel_desempenho	
			            from (
			                select distinct al.ci_aluno, al.nm_aluno, nr_questao, 
			                    mt.nm_matriz_topico as topico,
			                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,		
			                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
			                from tb_enturmacao ent 
			                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
			                                and ent.fl_ativo=true and al.fl_ativo=true
			                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
			                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
			                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
			                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
			                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
			                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                                        and aa.cd_situacao_aluno<>7  
              where ci_avaliacao_upload=".$params['cd_avaliacao'];

        if(isset($params['cd_escola']) && !empty($params['cd_escola']) ) {
            $sql .= " and t.cd_escola=".$params['cd_escola'];
        }
        
        if(isset($params['cd_cidade']) && !empty($params['cd_cidade']) ) {
            $sql .= " and cd_cidade=".$params['cd_cidade'];
        }

        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ) {
            $sql .= " and ci_turma=".$params['cd_turma'];
        }
        
        if(isset($params['topicos']) && !empty($params['topicos']) && ($params['topicos']>0) ) {
            $sql .= " and mt.ci_matriz_topico=".$params['topicos'];
        }
        
        $sql.=" order by al.ci_aluno ) res
		              group by res.ci_aluno
		              ) resul
                        inner join tb_nivel_desempenho nd on resul.cd_nivel_desempenho=nd.ci_nivel_desempenho
                group by cd_nivel_desempenho
                order by 1 desc;";

        $query=$this->db->query($sql);
        return $query->result();

    }

    public function buscaResultadoEscolaDescritor($params){
        $sql=" SELECT res.nm_escola,
                      res.descritor,
                      res.ordem as ordem,        
                       Count(res.nr_questao)                          AS questoes, 
                        Sum(res.acertos)                               AS acertos, 
                        round(( (Sum(res.acertos)::numeric * 100 / Count(res.nr_questao))::numeric),2) AS pacerto  
            from (
                select distinct esc.nm_escola,
			            al.ci_aluno, 
                        al.nm_aluno, 
                        nr_questao, 
                        mt.nm_matriz_topico       AS topico, 
                        md.ds_codigo AS descritor, 
                        replace(md.ds_codigo,'D','')::integer AS ordem, 
                        CASE 
                          WHEN am.nr_opcaocorreta = aa.nr_alternativa_escolhida 
                        THEN 1 
                          ELSE 0 
                        END                       AS acertos  
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                            and aa.cd_situacao_aluno<>7 
                    INNER JOIN tb_escola esc on t.cd_escola=esc.ci_escola   
                        where t.cd_etapa=".$params['cd_etapa'];

        if(isset($params['cd_turma'])){
            //$sql .= " and ent.cd_turma=".$params['cd_turma'];
            $sql.="";
        }

        if(isset($params['cd_disciplina'])){
            $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){
            $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];            
        }
        if(isset($params['cd_escola']) && !empty($params['cd_escola'])){
            if(sizeof($params['cd_escola'])>1){
                $item=implode(",",$params['cd_escola']);    
            }else{
                $item=$params['cd_escola'];
            }
            $sql .= "   and t.cd_escola in (".$item.")";
        }
        
        if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
            $sql .= "   and esc.cd_cidade=".$params['cd_cidade'];
        }

        $sql.=" order by al.ci_aluno ) res GROUP  BY res.nm_escola,
	                res.descritor,res.ordem
	                order by res.nm_escola,res.ordem";

        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaTotalResultadoDescritor($params){
        $sql=" SELECT res.descritor,res.ordem as ordem,
                       Count(res.nr_questao)                          AS questoes,
                        Sum(res.acertos)                               AS acertos,
                        round(( (Sum(res.acertos)::numeric * 100 / Count(res.nr_questao))::numeric),2) AS pacerto
            from (
                select distinct esc.nm_escola,
			            al.ci_aluno,
                        al.nm_aluno,
                        nr_questao,
                        mt.nm_matriz_topico       AS topico,
                        md.ds_codigo AS descritor,
                        replace(md.ds_codigo,'D','')::integer AS ordem,
                        CASE
                          WHEN am.nr_opcaocorreta = aa.nr_alternativa_escolhida
                        THEN 1
                          ELSE 0
                        END                       AS acertos
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                            and aa.cd_situacao_aluno<>7
                    INNER JOIN tb_escola esc on t.cd_escola=esc.ci_escola
                        where t.cd_etapa=".$params['cd_etapa'];
        
        if(isset($params['cd_turma'])){
            //$sql .= " and ent.cd_turma=".$params['cd_turma'];
            $sql.="";
        }
        
        if(isset($params['cd_disciplina'])){
            $sql .= "  and au.cd_disciplina=".$params['cd_disciplina'];}
            if(isset($params['cd_avaliacao'])){
                $sql .= "   and ci_avaliacao_upload=".$params['cd_avaliacao'];
            }
            if(isset($params['cd_escola']) && !empty($params['cd_escola'])){
                if(sizeof($params['cd_escola'])>1){
                    $item=implode(",",$params['cd_escola']);
                }else{
                    $item=$params['cd_escola'];
                }
                $sql .= "   and t.cd_escola in (".$item.")";
            }
            
            if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
                $sql .= "   and esc.cd_cidade=".$params['cd_cidade'];
            }
            
            $sql.=" order by al.ci_aluno ) res GROUP BY
	                res.descritor,res.ordem
	                order by res.ordem";
            
            $query=$this->db->query($sql);
            return $query->result();
    }

    public function buscaEvolucaoMunicipio($params){
            $sql="select cidade,
            array_to_string(array_agg(mes),',') as mes, 
            array_to_string(array_agg(pacerto),',') as pacertos from( 
                        select nm_cidade as cidade,case when extract(month from ac.dt_final)=1 then 'JANEIRO'
                                          when extract(month from ac.dt_final)=2 then 'FEVEREIRO'
                                          when  extract(month from ac.dt_final)=3 then 'MARÇO'
                                          when  extract(month from ac.dt_final)=4 then 'ABRIL'
                                          when  extract(month from ac.dt_final)=5 then 'MAIO'
                                          when  extract(month from ac.dt_final)=6 then 'JUNHO'
                                          when  extract(month from ac.dt_final)=7 then 'JULHO'     
                                          when  extract(month from ac.dt_final)=8 then 'AGOSTO'    
                                          when  extract(month from ac.dt_final)=9 then 'SETEMBRO'      
                                          when  extract(month from ac.dt_final)=10 then 'OUTUBRO'      
                                          when  extract(month from ac.dt_final)=11 then 'NOVEMBRO'     
                                          when  extract(month from ac.dt_final)=12 then 'DEZEMBRO'     
                                        END AS MES,
                        sum(acerto)as acertos,sum(nr_questoes)as nr_questoes, round(sum(acerto)*100/sum(nr_questoes),2)::numeric as pacerto 
                    from tb_resultado_aluno_avaliacao aa 
                        inner join tb_cidade cid on aa.cd_cidade=cid.ci_cidade
                        inner join tb_avaliacao_upload au on aa.ci_avaliacao_upload=au.ci_avaliacao_upload
                        inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
            $sql.="   where cid.ci_cidade=".$params['cd_cidade']; 
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
            $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
            $sql.=" group by nm_cidade,ac.dt_final order by extract(month from ac.dt_final)::INTEGER ) res group by cidade";

        $query=$this->db->query($sql);
        return $query->result();            
    }

    public function buscaEvolucaoMunicipioAno($params){
            $sql="select cidade,
            array_to_string(array_agg(ano),',') as ano, 
            array_to_string(array_agg(pacerto),',') as pacertos from(                     
                    select nm_cidade as cidade,
                        extract(year from ac.dt_final) as ano,
                        sum(acerto)as acertos,sum(nr_questoes)as nr_questoes, round(sum(acerto)*100/sum(nr_questoes),2)::numeric as pacerto 
                    from tb_resultado_aluno_avaliacao aa
                        inner join tb_avaliacao_upload au on aa.ci_avaliacao_upload=au.ci_avaliacao_upload
                        inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
                      $sql.="  inner join tb_cidade cid on aa.cd_cidade=cid.ci_cidade
                         where cid.ci_cidade=".$params['cd_cidade']; 
                        
            $sql.=" and au.cd_etapa=".$params['cd_etapa'];
            $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
            $sql.=" group by nm_cidade,extract(year from ac.dt_final)
                    order by extract(year from ac.dt_final)::INTEGER                        
                ) res group by cidade;";

        $query=$this->db->query($sql);
        return $query->result();            
    }

    

    public function buscaEvolucaoEscola($params){
        
         $sql=" select escola,array_to_string(array_agg(mes),',') as mes, array_to_string(array_agg(pacerto),',') as pacertos 
                    from( select nm_escola as escola,case when extract(month from ac.dt_final)=1 then 'JANEIRO'
                              when extract(month from ac.dt_final)=2 then 'FEVEREIRO'
                              when  extract(month from ac.dt_final)=3 then 'MARÇO'
                              when  extract(month from ac.dt_final)=4 then 'ABRIL'
                              when  extract(month from ac.dt_final)=5 then 'MAIO'
                              when  extract(month from ac.dt_final)=6 then 'JUNHO'
                              when  extract(month from ac.dt_final)=7 then 'JULHO'     
                              when  extract(month from ac.dt_final)=8 then 'AGOSTO'    
                              when  extract(month from ac.dt_final)=9 then 'SETEMBRO'      
                              when  extract(month from ac.dt_final)=10 then 'OUTUBRO'      
                              when  extract(month from ac.dt_final)=11 then 'NOVEMBRO'     
                              when  extract(month from ac.dt_final)=12 then 'DEZEMBRO'     
                            END AS MES,
                        sum(acerto)as acertos,sum(nr_questoes)as nr_questoes, round(sum(acerto)*100/sum(nr_questoes),2)::numeric as pacerto 
                                from tb_resultado_aluno_avaliacao aa 
                                        inner join tb_escola esc on aa.cd_escola=esc.ci_escola
                                        inner join tb_avaliacao_upload au on aa.ci_avaliacao_upload=au.ci_avaliacao_upload
                                        inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload and extract(year from ac.dt_final)=".$params['nr_anoletivo'];  
                            $sql.="    where esc.ci_escola=".$params['cd_escola'];
          $sql.=" and au.cd_etapa=".$params['cd_etapa'];
          $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
          $sql.=" group by nm_escola,ac.dt_final order by extract(month from ac.dt_final)::INTEGER ) res group by escola";

        $query=$this->db->query($sql);
        return $query->result();
    }
        
    public function buscaEvolucaoTurma($params){
         
        $sql="select turma,array_to_string(array_agg(mes),',') as mes, array_to_string(array_agg(pacerto),',') as pacertos from(
                select nm_etapa||'-'||nm_turma||'-'||nm_turno as turma,                    
                    case when extract(month from ac.dt_final)=1 then 'JANEIRO'
                         when extract(month from ac.dt_final)=2 then 'FEVEREIRO'
                          when  extract(month from ac.dt_final)=3 then 'MARÇO'
                          when  extract(month from ac.dt_final)=4 then 'ABRIL'
                          when  extract(month from ac.dt_final)=5 then 'MAIO'
                          when  extract(month from ac.dt_final)=6 then 'JUNHO'
                          when  extract(month from ac.dt_final)=7 then 'JULHO'     
                          when  extract(month from ac.dt_final)=8 then 'AGOSTO'    
                          when  extract(month from ac.dt_final)=9 then 'SETEMBRO'      
                          when  extract(month from ac.dt_final)=10 then 'OUTUBRO'      
                          when  extract(month from ac.dt_final)=11 then 'NOVEMBRO'     
                          when  extract(month from ac.dt_final)=12 then 'DEZEMBRO'     
                        END AS MES,sum(acerto)as acertos,sum(nr_questoes)as nr_questoes,
                    round(sum(acerto)*100/sum(nr_questoes),2)::numeric as pacerto";
        $sql.=" from tb_resultado_aluno_avaliacao aa 
                        inner join tb_avaliacao_upload au on aa.ci_avaliacao_upload=au.ci_avaliacao_upload
                        inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
                $sql.=" inner join tb_turma tr on aa.ci_turma=tr.ci_turma
                        inner join tb_etapa e on tr.cd_etapa=e.ci_etapa
                        inner join tb_turno t on tr.cd_turno=t.ci_turno";
        $sql.=" where aa.ci_turma=".$params['cd_turma'];
        $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
        $sql.=" group  by nm_etapa,nm_turma,nm_turno,ac.dt_final order by extract(month from ac.dt_final)::INTEGER ) res group by turma";

        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaEvolucaoAluno($params){        
         
        $sql="select nm_aluno, array_to_string(array_agg(mes),',') as mes, 
                    array_to_string(array_agg(pacerto::numeric),',') as pacertos from (
                select nm_aluno,case when extract(month from ac.dt_final)=1 then 'JANEIRO'
                          when extract(month from ac.dt_final)=2 then 'FEVEREIRO'
                          when  extract(month from ac.dt_final)=3 then 'MARÇO'
                          when  extract(month from ac.dt_final)=4 then 'ABRIL'
                          when  extract(month from ac.dt_final)=5 then 'MAIO'
                          when  extract(month from ac.dt_final)=6 then 'JUNHO'
                          when  extract(month from ac.dt_final)=7 then 'JULHO'     
                          when  extract(month from ac.dt_final)=8 then 'AGOSTO'    
                          when  extract(month from ac.dt_final)=9 then 'SETEMBRO'      
                          when  extract(month from ac.dt_final)=10 then 'OUTUBRO'      
                          when  extract(month from ac.dt_final)=11 then 'NOVEMBRO'     
                          when  extract(month from ac.dt_final)=12 then 'DEZEMBRO'     
                        END AS MES,pacerto  from tb_resultado_aluno_avaliacao aa  
            inner join tb_avaliacao_upload au on aa.ci_avaliacao_upload=au.ci_avaliacao_upload";

            if($params['nr_anoletivo']!==null ){
                $sql.=" inner join tb_avaliacao_cidade ac on au.ci_avaliacao_upload=ac.cd_avaliacao_upload and extract(year from ac.dt_final)=".$params['nr_anoletivo'];
            } 
            
        $sql.=" inner join tb_aluno al on aa.ci_aluno=al.ci_aluno ";
        $sql.=" where ci_turma=".$params['cd_turma'];
        $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
        $sql.=" order by nm_aluno,extract(month from ac.dt_final)::INTEGER ) res  group by nm_aluno order by nm_aluno";

        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaPainelAprendizagem($params){
        $sql=" select escola,pacerto,
                        case when pacerto<=25 then 1 
                            when pacerto>25 and pacerto<=50 then 2
                            when pacerto>50 and pacerto<=75 then 3
                            when pacerto>75 then 3
                        end as ci_nivel_desempenho 
                from ( select nm_escola as escola,
                        sum(acerto)as acertos,sum(nr_questoes)as nr_questoes, round(sum(acerto)*100/sum(nr_questoes),2)::numeric as pacerto 
                                from tb_resultado_aluno_avaliacao aa 
                                        inner join tb_escola esc on aa.cd_escola=esc.ci_escola 
                                    where ci_avaliacao_upload=".$params['cd_avaliacao']."
                                        and aa.cd_cidade=".$params['cd_cidade'];
        $sql.=" group by nm_escola ) res";

        //print_r($params);die;
        
        $query=$this->db->query($sql);
        return $query->result();
    }   

    public function buscaPainelAprendizagemnew($params){
        $sql="select res.ano,    res.mes,
                res.cd_cidade,
                res.cd_etapa, res.ci_matriz_topico,   res.topico,
                res.ci_avaliacao_upload,
                res.cd_disciplina, sum(res.acertos) as acerto,      
                count(res.nr_questao) as nr_questoes,
                round(sum(res.acertos)*100/count(res.nr_questao),2)::numeric as pacerto 
            from (         
            select distinct             
            extract(year from au.dt_final) as ano,
            extract(month from au.dt_final) as mes,
            au.dt_final,
            e.cd_cidade,    
            t.cd_escola,
            t.ci_turma,
            t.cd_etapa, 
            au.ci_avaliacao_upload,
            au.cd_disciplina,
            al.ci_aluno, 
            al.nm_aluno, 
            nr_questao, 
                    mt.ci_matriz_topico,
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,     
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
                    inner join tb_etapa et on au.cd_etapa=et.ci_etapa
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno 
                        and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                        and aa.cd_situacao_aluno<>7    
                    inner join tb_escola e on t.cd_escola=e.ci_escola
                where 1=1 
                        and au.cd_edicao=".$params['cd_edicao'];
                $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
                
                if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
                    $sql.=" and e.cd_cidade=".$params['cd_cidade'];
                }
                if(isset($params['cd_etapa']) && !empty($params['cd_etapa'])){
                    //$sql.="  and ( et.nm_etapa=" t.cd_etapa";
                    $sql.=" and t.cd_etapa=".$params['cd_etapa'];
                }
                
                /*if($params['rd_rel']=="I"){
                    $sql.=" and ( et.nm_etapa ilike ('%1º%') or
			                      et.nm_etapa ilike ('%2º%') or
			                      et.nm_etapa ilike ('%3º%') or
			                      et.nm_etapa ilike ('%4º%')
                                )  ";
                }else if($params['rd_rel']=="F"){
                    $sql.=" and ( et.nm_etapa ilike ('%5º%') or
			                      et.nm_etapa ilike ('%6º%') or
			                      et.nm_etapa ilike ('%7º%') or
			                      et.nm_etapa ilike ('%8º%') or
                                  et.nm_etapa ilike ('%9º%')
                                )  ";
                }*/
                
          $sql.="  order by al.ci_aluno
                    ) res group by res.ano,
                    res.mes,
                    res.cd_cidade,                    
                    res.cd_etapa,
                    res.ci_matriz_topico,
                    res.topico,
                    res.ci_avaliacao_upload,
                    res.cd_disciplina";

        $query=$this->db->query($sql);
        return $query->result();

   }     
   
   public function buscaPainelAprendizagemnovo($params){
       $sql="select res.ano,                
                res.cd_etapa, res.ci_matriz_topico, upper(res.topico) as topico,               
                res.cd_disciplina, sum(res.acertos) as acerto,
                count(res.nr_questao) as nr_questoes,
                round(sum(res.acertos)*100/count(res.nr_questao),2)::numeric as pacerto
            from (
            select distinct extract(year from au.dt_final) as ano,            
            au.dt_final,
            e.cd_cidade,
            t.cd_escola,
            t.ci_turma,
            t.cd_etapa,
            au.ci_avaliacao_upload,
            au.cd_disciplina,
            al.ci_aluno,
            al.nm_aluno,
            nr_questao,
                    mt.ci_matriz_topico,
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_etapa et on au.cd_etapa=et.ci_etapa
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno
                        and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                        and aa.cd_situacao_aluno<>7 
                    inner join tb_escola e on t.cd_escola=e.ci_escola
                where 1=1
                        and au.cd_edicao=".$params['cd_edicao'];
       $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
       
       if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
           $sql.=" and e.cd_cidade=".$params['cd_cidade'];
       }
       if(isset($params['cd_etapa']) && !empty($params['cd_etapa'])){
           //$sql.="  and ( et.nm_etapa=" t.cd_etapa";
           $sql.=" and t.cd_etapa=".$params['cd_etapa'];
       }
       
       $sql.="  order by al.ci_aluno
                    ) res group by res.ano,
                    res.topico,                                       
                    res.cd_etapa,
                    res.ci_matriz_topico,                    
                    res.cd_disciplina
                order by res.ano,res.ci_matriz_topico";
       
       $query=$this->db->query($sql);
       return $query->result();
       
   }

   public function buscaTopicoDescritor($params){
        $sql="select * from (select res.ano,    res.mes,
                res.cd_cidade,   
                res.cd_etapa, res.ci_matriz_topico,   res.topico,
                substring(res.descritor,2,position('-' in res.descritor)-2)::integer as  ordenador,
                res.descritor,
                res.ci_avaliacao_upload,
                res.cd_disciplina, sum(res.acertos) as acerto,      
                count(res.nr_questao) as nr_questoes,
                round(sum(res.acertos)*100/count(res.nr_questao),2)::numeric as pacerto 
            from (         
            select distinct             
            extract(year from au.dt_final) as ano,
            extract(month from au.dt_final) as mes,
            au.dt_final,
            e.cd_cidade,    
            t.cd_escola,
            t.ci_turma,
            t.cd_etapa, 
            au.ci_avaliacao_upload,
            au.cd_disciplina,
            al.ci_aluno, 
            al.nm_aluno, 
            nr_questao, 
                    mt.ci_matriz_topico,
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,     
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos 
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
                    inner join tb_turma t on ent.cd_turma=t.ci_turma 
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa 
                    inner join tb_etapa et on au.cd_etapa=et.ci_etapa
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload 
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno 
                        and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                        and aa.cd_situacao_aluno<>7    
                    inner join tb_escola e on t.cd_escola=e.ci_escola
                where 1=1                         
                        and mt.ci_matriz_topico=".$params['ci_topico'];
                $sql.=" and au.cd_edicao=".$params['cd_edicao'];
                $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
                
                if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
                    $sql.=" and e.cd_cidade=".$params['cd_cidade'];
                }
                if($params['rd_rel']=="I"){
                    $sql.=" and ( et.nm_etapa ilike ('%1º%') or
			                      et.nm_etapa ilike ('%2º%') or
			                      et.nm_etapa ilike ('%3º%') or
			                      et.nm_etapa ilike ('%4º%')
                                )  ";
                }else if($params['rd_rel']=="F"){
                    $sql.=" and ( et.nm_etapa ilike ('%5º%') or
			                      et.nm_etapa ilike ('%6º%') or
			                      et.nm_etapa ilike ('%7º%') or
			                      et.nm_etapa ilike ('%8º%') or
                                  et.nm_etapa ilike ('%9º%')
                                )  ";
                }
          $sql.="  order by al.ci_aluno
                    ) res group by res.ano,
                    res.mes,
                    res.cd_cidade,                    
                    res.cd_etapa,
                    res.ci_matriz_topico,
                    res.topico,
                    res.descritor,
                    res.ci_avaliacao_upload,
                    res.cd_disciplina
                    order by descritor
                    ) result order by ordenador";

        $query=$this->db->query($sql);
        return $query->result();

   }
   
   public function buscaTopicoDescritorNova($params){
       $sql="select * from (select res.ano,    res.mes,                
                res.cd_etapa, res.ci_matriz_topico,   res.topico,
                substring(res.descritor,2,position('-' in res.descritor)-2)::integer as  ordenador,
                res.descritor,
                res.cd_disciplina, sum(res.acertos) as acerto,
                count(res.nr_questao) as nr_questoes,
                round(sum(res.acertos)*100/count(res.nr_questao),2)::numeric as pacerto
            from (
            select distinct
            extract(year from au.dt_final) as ano,
            extract(month from au.dt_final) as mes,
            au.dt_final,
            e.cd_cidade,
            t.cd_escola,
            t.ci_turma,
            t.cd_etapa,
            au.ci_avaliacao_upload,
            au.cd_disciplina,
            al.ci_aluno,
            al.nm_aluno,
            nr_questao,
                    mt.ci_matriz_topico,
                    mt.nm_matriz_topico as topico,
                    md.ds_codigo||'-'||md.nm_matriz_descritor as descritor,
                    case when am.nr_opcaocorreta=aa.nr_alternativa_escolhida then 1 else 0 end as acertos
                from tb_enturmacao ent inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_etapa et on au.cd_etapa=et.ci_etapa
                    inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
                    inner join tb_matriz_descritor md on am.cd_matriz_descritor=md.ci_matriz_descritor
                    inner join tb_matriz_topico mt on mt.ci_matriz_topico=md.cd_matriz_topico
                    inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno
                        and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
                        and aa.cd_situacao_aluno<>7 
                    inner join tb_escola e on t.cd_escola=e.ci_escola
                where 1=1
                        and mt.ci_matriz_topico=".$params['ci_topico'];
       $sql.=" and au.cd_edicao=".$params['cd_edicao'];
       $sql.=" and au.cd_disciplina=".$params['cd_disciplina'];
       
       if(isset($params['cd_cidade']) && !empty($params['cd_cidade'])){
           $sql.=" and e.cd_cidade=".$params['cd_cidade'];
       }
       
       $sql.="  order by al.ci_aluno
                    ) res group by res.ano,
                    res.mes,                    
                    res.cd_etapa,
                    res.ci_matriz_topico,
                    res.topico,
                    res.descritor,
                    res.cd_disciplina
                    order by descritor
                    ) result order by ordenador";
       
       $query=$this->db->query($sql);
       return $query->result();
       
   }
   
   public function listaAlunoNivelAprendizagemMunicipio($params){
       
       $sql="select cd_nivel_desempenho,
        replace(replace(replace(replace(array_agg('Matrícula:'||ci_aluno||'-'||nm_aluno||'</br>')::text,'\"',''),'{',''),'}',''),',','') as alunos
from
	(
	select
		res.ci_aluno, res.nm_aluno,
		round(sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric, 2) as pacerto,
		case
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric ), 2)<=25 then 1
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>25
			and round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)<=50 then 2
            when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>50
			and round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)<=75 then 3
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>75 then 4
		end as cd_nivel_desempenho
	from
		(
		select
			distinct al.ci_aluno,
			al.nm_aluno,
			nr_questao,
			mt.nm_matriz_topico as topico,
			md.ds_codigo || '-' || md.nm_matriz_descritor as descritor,
			case
				when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
				else 0
			end as acertos
		from
			tb_enturmacao ent
		inner join tb_aluno al on
			ent.cd_aluno = al.ci_aluno
			and ent.fl_ativo = true
			and al.fl_ativo = true
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
            and aa.cd_situacao_aluno<>7 
		where 1=1 ";
       
       if (!empty($params['cd_avaliacao']))
       {
           $sql.=" and ci_avaliacao_upload=".$params['cd_avaliacao'];
       }
       if(!empty($params['cd_topico'])){
           $sql.=" and mt.ci_matriz_topico=".$params['cd_topico'];
       }
       if(!empty($params['cd_cidade'])){
           $sql.=" and cd_cidade=".$params['cd_cidade'];
       }
       
       $sql.=" order by al.ci_aluno ) res
	           group by res.ci_aluno,res.nm_aluno ) resul
        inner join tb_nivel_desempenho nd on
	           resul.cd_nivel_desempenho = nd.ci_nivel_desempenho";
       if(!empty($params['cd_nivel'])){
           $sql.=" where nd.ci_nivel_desempenho=".$params['cd_nivel'];
       }
       $sql.=" group by cd_nivel_desempenho order by 1 desc;";
       
       $query=$this->db->query($sql);
       return $query->result();
   }
   
   
   public function listaAlunoNivelAprendizagemMunicipioExcel($params){
       
       $sql="select cd_nivel_desempenho,ci_aluno,nm_aluno
from
	(
	select
		res.ci_aluno, res.nm_aluno,
		round(sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric, 2) as pacerto,
		case
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric ), 2)<=25 then 1
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>25
			and round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)<=50 then 2
            when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>50
			and round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)<=75 then 3
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>75 then 4
		end as cd_nivel_desempenho
	from
		(
		select
			distinct al.ci_aluno,
			al.nm_aluno,
			nr_questao,
			mt.nm_matriz_topico as topico,
			md.ds_codigo || '-' || md.nm_matriz_descritor as descritor,
			case
				when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1
				else 0
			end as acertos
		from
			tb_enturmacao ent
		inner join tb_aluno al on
			ent.cd_aluno = al.ci_aluno
			and ent.fl_ativo = true
			and al.fl_ativo = true
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
            and aa.cd_situacao_aluno<>7 
		where 1=1 ";
       
       if (!empty($params['cd_avaliacao']))
       {
           $sql.=" and ci_avaliacao_upload=".$params['cd_avaliacao'];
       }
       if(!empty($params['cd_topico'])){
           $sql.=" and mt.ci_matriz_topico=".$params['cd_topico'];
       }
       if(!empty($params['cd_cidade'])){
           $sql.=" and cd_cidade=".$params['cd_cidade'];
       }
       
       $sql.=" order by al.ci_aluno ) res
	           group by res.ci_aluno,res.nm_aluno ) resul
        inner join tb_nivel_desempenho nd on
	           resul.cd_nivel_desempenho = nd.ci_nivel_desempenho";
       if(!empty($params['cd_nivel'])){
           $sql.=" where nd.ci_nivel_desempenho=".$params['cd_nivel'];
       }
       $sql.="order by 3;";
       
       $query=$this->db->query($sql);
       return $query->result();
   }
   
   public function listaAlunoNivelAprendizagem($params){
       
       $sql="select nd.*,ci_aluno,nm_aluno  
                from  (  select  		
                res.ci_aluno,res.nm_aluno, 
                    round(sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric, 2) as pacerto,
		case
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric ), 2)<= 50 then 1
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>50
			and round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)<= 70 then 2
			when round((sum(res.acertos)::numeric* 100 / count(res.nr_questao)::numeric), 2)>70 then 3
		end as cd_nivel_desempenho  	
                from  		(  		select  			distinct al.ci_aluno,  			al.nm_aluno,  			nr_questao,  			
                                    mt.nm_matriz_topico as topico,  			md.ds_codigo || '-' || md.nm_matriz_descritor as descritor,
              			case  				when am.nr_opcaocorreta = aa.nr_alternativa_escolhida then 1  				else 0  			
            end as acertos  		from  			
            tb_enturmacao ent  		inner join tb_aluno al on  			
                ent.cd_aluno = al.ci_aluno  			and ent.fl_ativo = true  			and al.fl_ativo = true  		
                inner join tb_turma t on  			ent.cd_turma = t.ci_turma  		
                inner join tb_avaliacao_upload au on  			t.cd_etapa = au.cd_etapa  		
                inner join tb_avaliacao_matriz am on  			au.ci_avaliacao_upload = am.cd_avaliacao_upload  		
                inner join tb_matriz_descritor md on  			am.cd_matriz_descritor = md.ci_matriz_descritor  		
                inner join tb_matriz_topico mt on  			mt.ci_matriz_topico = md.cd_matriz_topico  		
                inner join tb_avaliacao_aluno aa on  			al.ci_aluno = aa.cd_aluno  			and am.ci_avaliacao_matriz = aa.cd_avaliacao_itens 
                        and aa.cd_situacao_aluno<>7  
		where 1=1 ";                    
       if (!empty($params['cd_avaliacao']))          {             
           $sql.=" and ci_avaliacao_upload=".$params['cd_avaliacao'];          }          
           if(!empty($params['cd_turma'])){              $sql.=" and ci_turma=".$params['cd_turma'];          }                  
           /*if(!empty($params['cd_cidade'])){              $sql.=" and res.cd_cidade=".$params['cd_cidade'];          }*/               
           $sql.=" order by al.ci_aluno ) res  	               
group by res.ci_aluno,res.nm_aluno ) resul                  
inner join tb_nivel_desempenho nd on  	               resul.cd_nivel_desempenho = nd.ci_nivel_desempenho";                    
           if(!empty($params['cd_nivel'])){              $sql.=" where nd.ci_nivel_desempenho=".$params['cd_nivel'];          }          
           $sql.=" order by 1 desc;";          
        $query=$this->db->query($sql);
        return $query->result();
   }

   public function listaAlunoNivelAprendizagemOld($params){
       
       $sql="select nd.*,ci_aluno,nm_aluno from
	               tb_nivel_desempenho nd
                    left join (
                    		select 
                    		case when pacerto<=50 then 1
                    		when pacerto>50 and pacerto<=70 then 2
                    		when pacerto>70 then 3 end as 
                    		cd_nivel_desempenho,
                    		al.ci_aluno,al.nm_aluno
                    	 from
                    		tb_resultado_aluno_avaliacao res
                    		inner join tb_aluno al on res.ci_aluno=al.ci_aluno	
                    	where 1=1 ";
        
        if (!empty($params['cd_avaliacao']))
        {
            $sql.=" and ci_avaliacao_upload=".$params['cd_avaliacao'];
        }
        if(!empty($params['cd_turma'])){
            $sql.=" and ci_turma=".$params['cd_turma'];
        }        
        if(!empty($params['cd_cidade'])){
            $sql.=" and res.cd_cidade=".$params['cd_cidade'];
        }
        
        $sql.=" group by cd_nivel_desempenho,al.ci_aluno,al.nm_aluno order by 1) result on
        result.cd_nivel_desempenho = nd.ci_nivel_desempenho";
        
        if(!empty($params['cd_nivel'])){
            $sql.=" where nd.ci_nivel_desempenho=".$params['cd_nivel'];
        }
        $sql.=" order by 1 desc;";
        
        $query=$this->db->query($sql);
        return $query->result();
   }
}
