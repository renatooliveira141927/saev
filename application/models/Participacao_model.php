<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participacao_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    
    public function participacaoMunicipio($params){
		
		$sql="select * from (
						select t.ci_turma,
							t.nm_turma,
							count(ent.cd_aluno) as ent
						from tb_enturmacao ent
							  inner join tb_ultimaenturmacao ue on ent.cd_turma=ue.cd_turma and ent.cd_aluno=ue.cd_aluno and ent.fl_ativo = true 			
							  inner join tb_aluno al on ent.cd_aluno = al.ci_aluno and al.fl_ativo = true
							  inner join tb_turma t on ent.cd_turma = t.ci_turma and t.fl_ativo=true 
							  		and t.nr_ano_letivo=2020 
							  inner join tb_escola esc on t.cd_escola=esc.ci_escola 
						where 1=1
							and t.cd_etapa=18 
							and esc.ci_escola=28 
						group by t.ci_turma,t.nm_turma 
						) res1       
			inner join (
							select ent.cd_turma,count(distinct aa.cd_aluno) from tb_avaliacao_upload au --on t.cd_etapa = au.cd_etapa
								  inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload = am.cd_avaliacao_upload 
								  inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
								  inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
								  inner join tb_avaliacao_aluno aa on 
								  		am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
								        and aa.cd_situacao_aluno<>7
								  inner join tb_aluno al on aa.cd_aluno=al.ci_aluno and al.fl_ativo = true
								  inner join tb_enturmacao ent on al.ci_aluno=ent.cd_aluno and ent.fl_ativo = true  
								  inner join tb_ultimaenturmacao ue on ent.cd_aluno=ue.cd_aluno and ue.cd_turma=ent.cd_turma 
							where ci_avaliacao_upload=9
							group by ent.cd_turma 
					) res2 on res1.ci_turma=res2.cd_turma;";
			
		$query=$this->db->query($sql);
        return $query->result();
	}
    
    
    public function participacaoEscola($params){
		
		$sql="select * from (
						select t.ci_turma,
							t.nm_turma,
							count(ent.cd_aluno) as ent
						from tb_enturmacao ent
							  inner join tb_ultimaenturmacao ue on ent.cd_turma=ue.cd_turma and ent.cd_aluno=ue.cd_aluno and ent.fl_ativo = true 			
							  inner join tb_aluno al on ent.cd_aluno = al.ci_aluno and al.fl_ativo = true
							  inner join tb_turma t on ent.cd_turma = t.ci_turma and t.fl_ativo=true 
							  		and t.nr_ano_letivo=2020 
							  inner join tb_escola esc on t.cd_escola=esc.ci_escola 
						where 1=1
							and t.cd_etapa=18 
							and esc.ci_escola=28 
						group by t.ci_turma,t.nm_turma 
						) res1       
			inner join (
							select ent.cd_turma,count(distinct aa.cd_aluno) from tb_avaliacao_upload au --on t.cd_etapa = au.cd_etapa
								  inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload = am.cd_avaliacao_upload 
								  inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
								  inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
								  inner join tb_avaliacao_aluno aa on 
								  		am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
								        and aa.cd_situacao_aluno<>7
								  inner join tb_aluno al on aa.cd_aluno=al.ci_aluno and al.fl_ativo = true
								  inner join tb_enturmacao ent on al.ci_aluno=ent.cd_aluno and ent.fl_ativo = true  
								  inner join tb_ultimaenturmacao ue on ent.cd_aluno=ue.cd_aluno and ue.cd_turma=ent.cd_turma 
							where ci_avaliacao_upload=9
							group by ent.cd_turma 
					) res2 on res1.ci_turma=res2.cd_turma;";
			
		$query=$this->db->query($sql);
        return $query->result();
	}
    

	public function participacaoTurma($params){
		
		$sql="select * from (
						select t.ci_turma,
							t.nm_turma,
							count(ent.cd_aluno) as ent
						from tb_enturmacao ent
							  inner join tb_ultimaenturmacao ue on ent.cd_turma=ue.cd_turma and ent.cd_aluno=ue.cd_aluno and ent.fl_ativo = true 			
							  inner join tb_aluno al on ent.cd_aluno = al.ci_aluno and al.fl_ativo = true
							  inner join tb_turma t on ent.cd_turma = t.ci_turma and t.fl_ativo=true 
							  		and t.nr_ano_letivo=2020 
							  inner join tb_escola esc on t.cd_escola=esc.ci_escola 
						where 1=1
							and t.cd_etapa=".$params['cd_etapa']; 
						$sql.=" and esc.ci_escola=".$params['cd_turma']; 
						$sql.=" group by t.ci_turma,t.nm_turma 
						) res1       
			inner join (
							select ent.cd_turma,count(distinct aa.cd_aluno) from tb_avaliacao_upload au
								  inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload = am.cd_avaliacao_upload 
								  inner join tb_matriz_descritor md on am.cd_matriz_descritor = md.ci_matriz_descritor
								  inner join tb_matriz_topico mt on mt.ci_matriz_topico = md.cd_matriz_topico
								  inner join tb_avaliacao_aluno aa on 
								  		am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
								        and aa.cd_situacao_aluno<>7
								  inner join tb_aluno al on aa.cd_aluno=al.ci_aluno and al.fl_ativo = true
								  inner join tb_enturmacao ent on al.ci_aluno=ent.cd_aluno and ent.fl_ativo = true  
								  inner join tb_ultimaenturmacao ue on ent.cd_aluno=ue.cd_aluno and ue.cd_turma=ent.cd_turma 
							where ci_avaliacao_upload=".$params['cd_avaliacao'];
						$sql.="	group by ent.cd_turma 
					) res2 on res1.ci_turma=res2.cd_turma;";
			
		$query=$this->db->query($sql);
        return $query->result();
	}

	
}	


