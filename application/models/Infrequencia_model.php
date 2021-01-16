<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Infrequencia_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        
    }
    
    public function count_buscar(
        $cd_escola      = null,        
        $cd_turma       = null,
        $cd_etapa       = null){
            
            
            return count($this->buscar(
                $cd_escola,
                $cd_turma,
                $cd_etapa));
    }
    
    public function buscar(
        $cd_escola      = null,        
        $cd_turma       = null,
        $cd_etapa       = null,
        $relatorio      = null,
        $limit          = null,
        $offset         = null){
            
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
                    	and tur.ci_turma =".$cd_turma."
                    	and et.ci_etapa =".$cd_etapa."
                    	and tur.cd_escola = ".$cd_escola."
                    order by
                    al.nm_aluno asc ) res
                    group by ci_aluno,nr_inep, nm_aluno,dt_nascimento,
                    	cd_turma,nm_turma,cd_etapa,nm_etapa
                    order by nm_aluno";
            
            $query=$this->db->query($sql);
            return $query->result();
            
    }
    
    public function buscarpercentualescola($params){
        $sql="select upper(nm_escola) as nm_escola, 
	sum(jan) as jan,
		sum(fev) as fev,
		sum(mar) as mar,
		sum(abr) as abr,
		sum(mai) as mai,
		sum(jun) as jun,
		sum(jul) as jul,
		sum(ago) as ago,
		sum(set) as set,
		sum(out) as out,
		sum(nov) as nov,
		sum(dez)as dez 
	from (
				 select tur.cd_escola,
				 		case when nr_mes=1 then sum(nr_faltas) else 0 end as JAN,
                    	case when nr_mes=2 then sum(nr_faltas) else 0 end as FEV,
                    	case when nr_mes=3 then sum(nr_faltas) else 0 end as MAR,
                    	case when nr_mes=4 then sum(nr_faltas) else 0 end as ABR,
                    	case when nr_mes=5 then sum(nr_faltas) else 0 end as MAI,
                    	case when nr_mes=6 then sum(nr_faltas) else 0 end as JUN,
                    	case when nr_mes=7 then sum(nr_faltas) else 0 end as JUL,
                    	case when nr_mes=8 then sum(nr_faltas) else 0 end as AGO,
                    	case when nr_mes=9 then sum(nr_faltas) else 0 end as SET,
                    	case when nr_mes=10 then sum(nr_faltas) else 0 end as OUT,
                    	case when nr_mes=11 then sum(nr_faltas) else 0 end as NOV,
                    	case when nr_mes=12 then sum(nr_faltas) else 0 end as DEZ
                    from tb_ultimaenturmacao ent
                    join tb_aluno al on
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
                        al.fl_ativo = true ";
                        if(!empty($params['cd_anoletivo'])){
                            
                            $sql.=" and tur.nr_ano_letivo=".$params['cd_anoletivo'];
                        }else{
                            $sql.=" and tur.nr_ano_letivo= extract(year from now())";
                        }    
                            if(!empty($params['cd_escola'])){                                
                               $sql.=" and tur.cd_escola=".$params['cd_escola'];   
                            }                            

                       $sql.=" group by tur.cd_escola,nr_mes 
                        )rest
                         inner join tb_escola esc on rest.cd_escola=esc.ci_escola";
                       if(!empty($params['cd_cidade'])){
                           $sql.=" where esc.cd_cidade=".$params['cd_cidade'];
                       }
                       $sql.="  group by nm_escola order by upper(nm_escola);";
                       
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscarpercentualturma($params){
        $sql="select nm_turma, 
                        	sum(jan) as jan,
                        		sum(fev) as fev,
                        		sum(mar) as mar,
                        		sum(abr) as abr,
                        		sum(mai) as mai,
                        		sum(jun) as jun,
                        		sum(jul) as jul,
                        		sum(ago) as ago,
                        		sum(set) as set,
                        		sum(out) as out,
                        		sum(nov) as nov,
                        		sum(dez)as dez 
                        	from (
                        				 select tur.cd_escola,tur.nm_turma,
                        				 		case when nr_mes=1 then sum(nr_faltas) else 0 end as JAN,
                                            	case when nr_mes=2 then sum(nr_faltas) else 0 end as FEV,
                                            	case when nr_mes=3 then sum(nr_faltas) else 0 end as MAR,
                                            	case when nr_mes=4 then sum(nr_faltas) else 0 end as ABR,
                                            	case when nr_mes=5 then sum(nr_faltas) else 0 end as MAI,
                                            	case when nr_mes=6 then sum(nr_faltas) else 0 end as JUN,
                                            	case when nr_mes=7 then sum(nr_faltas) else 0 end as JUL,
                                            	case when nr_mes=8 then sum(nr_faltas) else 0 end as AGO,
                                            	case when nr_mes=9 then sum(nr_faltas) else 0 end as SET,
                                            	case when nr_mes=10 then sum(nr_faltas) else 0 end as OUT,
                                            	case when nr_mes=11 then sum(nr_faltas) else 0 end as NOV,
                                            	case when nr_mes=12 then sum(nr_faltas) else 0 end as DEZ
                                            from tb_ultimaenturmacao ent
                                            join tb_aluno al on
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
                                            	and tur.cd_escola=".$params['cd_escola'];
                            if(!empty($params['cd_turma'])){
                               $sql.=" and tur.ci_turma=".$params['cd_turma'];   
                            }

                       $sql.=" group by tur.cd_escola,tur.nm_turma,nr_mes 
                        )rest
                         inner join tb_escola esc on rest.cd_escola=esc.ci_escola
                        group by nm_turma order by nm_turma;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscarInfrequenciaMes(
        $cd_escola      = null,
        $cd_turma       = null,
        $cd_etapa       = null,
        $cd_mes         = null ){
        
    
            $sql="select distinct ci_aluno,	nr_inep, nm_aluno,
	                     dt_nascimento,	cd_turma,	nm_turma,
	                     cd_etapa,	nm_etapa,	ci_infrequencia,
                    	case when nr_mes=1 then UPPER('janEIRO')
                    		 when nr_mes=2 then UPPER('FEVEREIRO')
                    		 when nr_mes=3 then UPPER('MARÇO')
                    		 when nr_mes=4 then UPPER('ABRIL')
                    		 when nr_mes=5 then UPPER('MAIO')
                    		 when nr_mes=6 then UPPER('JUNHO')
                    		 when nr_mes=7 then UPPER('JULHO')
                    		 when nr_mes=8 then UPPER('AGOSTO')
                    		 when nr_mes=9 then UPPER('setEMBRO')
                    		 when nr_mes=10 then UPPER('outUBRO')
                    		 when nr_mes=11 then UPPER('NOVEMBRO')
                    		 when nr_mes=12 then UPPER('DEZEMBRO')
                    	end as nr_mes,nr_faltas	 
                    from (select distinct ci_aluno,nr_inep, al.nm_aluno,dt_nascimento,
                    	ent.cd_turma,nm_turma,tur.cd_etapa,nm_etapa,
                        ci_infrequencia,coalesce(nr_mes,".$cd_mes.") as nr_mes,nr_faltas
                    from tb_aluno al
                    join tb_ultimaenturmacao ent on
                    	al.ci_aluno = ent.cd_aluno                                            
                    join tb_turma tur on
                    	ent.cd_turma = tur.ci_turma and 
                        tur.cd_escola = al.cd_escola
                    join tb_etapa et on
                    	tur.cd_etapa = et.ci_etapa
                    left join tb_infrequencia inf on
                    	ent.cd_aluno =  inf.cd_aluno
                    	and ent.cd_turma =  inf.cd_turma
                        and (nr_mes=".$cd_mes." or nr_mes is null)
                    where
                    	al.fl_ativo = true
                    	and tur.ci_turma =".$cd_turma."
                    	and et.ci_etapa =".$cd_etapa."
                    	and tur.cd_escola = ".$cd_escola."                        
                    order by
                    al.nm_aluno asc ) res ORDER BY NM_ALUNO;";
        
           
     $query=$this->db->query($sql);
            return $query->result();
            
    }
    
    public function buscaInfrequenciaAluno($params){
        $sql="select distinct ci_aluno,	nr_inep,	nm_aluno,
	                     dt_nascimento,	cd_turma,	nm_turma,
	                     cd_etapa,	nm_etapa,	ci_infrequencia,
                    	case when nr_mes=1 then UPPER('janeiro')
                    		 when nr_mes=2 then UPPER('FEVEREIRO')
                    		 when nr_mes=3 then UPPER('MARÇO')
                    		 when nr_mes=4 then UPPER('ABRIL')
                    		 when nr_mes=5 then UPPER('MAIO')
                    		 when nr_mes=6 then UPPER('JUNHO')
                    		 when nr_mes=7 then UPPER('JULHO')
                    		 when nr_mes=8 then UPPER('AGOSTO')
                    		 when nr_mes=9 then UPPER('setembro')
                    		 when nr_mes=10 then UPPER('outubro')
                    		 when nr_mes=11 then UPPER('NOVEMBRO')
                    		 when nr_mes=12 then UPPER('DEZEMBRO')
                    	end as nr_mes,nr_faltas,portugues,pacerto,
                        matematica,macerto,leitura,lacerto, res.nr_mes as ordem	 
                    from (select distinct al.ci_aluno,nr_inep, nm_aluno,dt_nascimento,
                    	ent.cd_turma,nm_turma,tur.cd_etapa,nm_etapa,
                        ci_infrequencia,nr_mes,nr_faltas,
                        coalesce(dp.nm_disciplina,'LÍNGUA PORTUGUESA') as portugues,
                        coalesce(raap.pacerto,0) as pacerto,
                        COALESCE(dm.nm_disciplina,'MATEMÁTICA') as matematica,
                        coalesce(raam.pacerto,0) as macerto,
                        'LEITURA' as leitura,
                        coalesce(ral.nr_alternativa_escolhida,0) as lacerto        
                    from tb_aluno al
                    join tb_ultimaenturmacao ent on
                    	al.ci_aluno = ent.cd_aluno                        
                    join tb_turma tur on
                    	ent.cd_turma = tur.ci_turma and 
                        tur.cd_escola = al.cd_escola
                    join tb_etapa et on
                    	tur.cd_etapa = et.ci_etapa
                    inner join tb_infrequencia inf on
                    	ent.cd_aluno =  inf.cd_aluno
                    	and ent.cd_turma =  inf.cd_turma
                    left join tb_resultado_aluno_avaliacao raap 	
                     on raap.ci_aluno=al.ci_aluno
                     and raap.ci_turma=inf.cd_turma
                     and raap.mes=inf.nr_mes
                     and raap.cd_disciplina=2
                    left join tb_avaliacao_upload aup on raap.ci_avaliacao_upload=aup.ci_avaliacao_upload
                            and extract(month from aup.dt_final)::integer=nr_mes
 					left join tb_disciplina dp on dp.ci_disciplina=aup.cd_disciplina and dp.ci_disciplina=2
                    left join tb_resultado_aluno_avaliacao raam 	
                        on raam.ci_aluno=al.ci_aluno
                        and raam.ci_turma=inf.cd_turma
                        and raam.mes=inf.nr_mes
                        and raam.cd_disciplina=1
                    left join tb_avaliacao_upload aum on raam.ci_avaliacao_upload=aum.ci_avaliacao_upload
 					left join tb_disciplina dm on dp.ci_disciplina=aum.cd_disciplina and dm.ci_disciplina=1
                    left join tb_avaliacaoleitura_aluno ral on ral.cd_aluno=al.ci_aluno
                            and aup.ci_avaliacao_upload=ral.cd_avaliacao_upload
                    left join tb_avaliacao_upload aul on aul.ci_avaliacao_upload=ral.cd_avaliacao_upload
                       and extract(month from aul.dt_final) =inf.nr_mes
                    where
                    	al.fl_ativo = true
                    	and tur.ci_turma =".$params['cd_turma']."
                    	and al.ci_aluno =".$params['cd_aluno']."                    	                
                    order by nr_mes asc ) res order by res.nr_mes";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscarLiberacao($params){
        $sql="select c.ci_cidade,
                    	c.nm_cidade, 
                    	case when nr_mes=1 then 'JANEIRO'  
                    			when nr_mes=2 then 'FEVEREIRO'
                    			when nr_mes=3 then 'MARÇO'
                    			when nr_mes=4 then 'ABRIL'
                    			when nr_mes=5 then 'MAIO'
                    			when nr_mes=6 then 'JUNHO'
                    			when nr_mes=7 then 'JULHO'
                    			when nr_mes=8 then 'AGOSTO'
                    			when nr_mes=9 then 'SETEMBRO'
                    			when nr_mes=10 then 'OUTUBRO'
                    			when nr_mes=11 then 'NOVEMBRO'
                    			when nr_mes=12 then 'DEZEMBRO'
                    	end as mes, 
                    	fl.fl_ativo		
                    from tb_liberacaoinfrequencia fl
                      inner join tb_cidade c on fl.cd_cidade_sme=c.ci_cidade
                    where nr_mes=".$params['cd_mes']." and cd_cidade_sme=".$params['cd_cidade'];
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function inserir($infrequencia =null){
        
        foreach ($infrequencia as $value) {
            $cd_turma=$value->cd_turma;
            $cd_aluno=$value->cd_aluno;
            $nr_mes=$value->nr_mes;
            $existeinfrequencia=$this->consultainfrequencialancada($cd_turma,$cd_aluno,$nr_mes);

            if(!empty($existeinfrequencia) && isset($existeinfrequencia->ci_infrequencia)){                                
                $this->db->where('ci_infrequencia', $existeinfrequencia->ci_infrequencia);
                $this->db->update('tb_infrequencia', $value);
            }else{
                $this->db->insert('tb_infrequencia', $value);
            }
        }
        //$this->db->insert_batch('tb_infrequencia', $infrequencia);        
        return true;
        
    }
    
    public function update($infrequencia =null){
        
        $this->db->update_batch('tb_infrequencia', $infrequencia,'ci_infrequencia');
        
        return true;
        
    }
    
    public function inserirLiberacao($params){        
        $this->db->insert('tb_liberacaoinfrequencia', $params);        
        return true;        
    }
    
    public function updateLiberacao($dados,$id){    
        $this->db->set($dados);
        $this->db->where('ci_liberacao', $id);
        $this->db->update('tb_liberacaoinfrequencia');        
        return true;      
    }
    
    public function consultainfrequencialancada($cd_turma,$cd_aluno,$nr_mes){
        
        $sql="select * from tb_infrequencia int where cd_turma=$cd_turma and cd_aluno=$cd_aluno and nr_mes=$nr_mes";
        $query=$this->db->query($sql);
        return $query->result();
    }
}