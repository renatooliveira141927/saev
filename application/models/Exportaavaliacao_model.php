<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Exportaavaliacao_model extends CI_Model {
 
    public function __construct(){
        parent::__construct();        
    }
    
    public function consultaItensAvaliacao($provas){        
        $sql=" SELECT count(am.ci_avaliacao_matriz) as itens
                    from tb_avaliacao_upload au
                        JOIN tb_avaliacao_matriz am ON au.ci_avaliacao_upload = am.cd_avaliacao_upload
                        WHERE au.ci_avaliacao_upload=$provas
                group by au.ci_avaliacao_upload order by 1;";
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }
    
    public function montaConsulta($avaliacao,$escola){        
        /*$provas=0;
        for($i=0;$i<sizeof($avaliacao);$i++){
            $provas.=','.$avaliacao[$i];
        }*/
        
        $itens=$this->consultaItensAvaliacao($avaliacao);
        
        $questoes="";
        $agrupadores="";
        foreach ($itens as $key=>$teste){
            for($i=1;$i<=$teste->itens;$i++){
                if($i==$teste->itens){
                    $agrupadores.="sum(res.q".$i.") AS q".$i;
                    $questoes.="CASE WHEN am.nr_questao =".$i." THEN aa.nr_alternativa_escolhida ELSE null END AS q".$i;
                }else{
                    $agrupadores.="sum(res.q".$i.") AS q".$i.",";
                    $questoes.="CASE WHEN am.nr_questao =".$i." THEN aa.nr_alternativa_escolhida ELSE null END AS q".$i.",";
                }            
            }
        }                  
        $sql="SELECT res.ci_avaliacao_upload as ci_avaliacao, res.nm_caderno as nm_caderno_avaliacao,
                     res.ci_cidade as ci_municipio, res.nm_cidade as nm_municipio, res.ci_escola,res.nm_escola, 
                     res.ci_turma,res.nm_turma,res.nr_ano_letivo, res.ci_aluno,res.nm_aluno, ";
            $sql.=$agrupadores;
        $sql.=" FROM ( SELECT DISTINCT au.ci_avaliacao_upload, au.nm_caderno, cid.ci_cidade, cid.nm_cidade,esc.ci_escola,esc.nm_escola,
                        t.ci_turma,t.nm_turma,t.nr_ano_letivo,al.ci_aluno,al.nm_aluno,";
            $sql.=$questoes;
        $sql.=" FROM tb_enturmacao ent
                 JOIN tb_aluno al ON ent.cd_aluno = al.ci_aluno AND al.fl_ativo = true
                 JOIN tb_turma t ON ent.cd_turma = t.ci_turma
                 JOIN tb_escola esc ON t.cd_escola = esc.ci_escola
                 JOIN tb_cidade cid ON esc.cd_cidade = cid.ci_cidade
                 JOIN tb_avaliacao_upload au ON t.cd_etapa = au.cd_etapa
                 JOIN tb_avaliacao_matriz am ON au.ci_avaliacao_upload = am.cd_avaliacao_upload
                 JOIN tb_avaliacao_aluno aa ON al.ci_aluno = aa.cd_aluno AND am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
	           WHERE au.ci_avaliacao_upload=$avaliacao
                    and ci_escola=$escola";           
    	$sql.=" ORDER BY au.nm_caderno, cid.nm_cidade, esc.nm_escola, t.nm_turma, al.ci_aluno) res
                GROUP BY res.ci_avaliacao_upload,res.nm_caderno,res.ci_cidade,res.nm_cidade,res.ci_escola,res.nm_escola,
                         res.ci_turma,res.nm_turma,res.nr_ano_letivo,res.ci_aluno,res.nm_aluno
                ORDER BY res.nm_caderno, res.nm_cidade, res.nm_escola, res.nm_turma, res.nm_aluno,res.nr_ano_letivo;";
    	
    	$query=$this->db->query($sql);
    	return $query->result();
    	
    }
    
    public function montaConsultaLeitura($avaliacao,$escola){
        $sql="SELECT DISTINCT au.nm_caderno AS avaliacao, cid.nm_cidade AS municipio,
                    esc.nm_escola,t.nm_turma AS turma,t.nr_ano_letivo,
                    al.ci_aluno,al.nm_aluno AS aluno,
        CASE
            WHEN aa.cd_situacao_aluno = 1 THEN 'REALIZOU A ATIVIDADE'::text
            WHEN aa.cd_situacao_aluno = 2 THEN 'NÃO AVALIADO'::text
            ELSE NULL::text
        END AS situacao_aluno,
        CASE
            WHEN aa.cd_motivonaovaliacao_aluno = 1 THEN 'RECUSOU-SE A PARTICIPAR'::text
            WHEN aa.cd_motivonaovaliacao_aluno = 2 THEN 'FALTOU MAS ESTÁ FREQUENTANDO A ESCOLA'::text
            WHEN aa.cd_motivonaovaliacao_aluno = 3 THEN 'ABANDONOU A ESCOLA'::text
            WHEN aa.cd_motivonaovaliacao_aluno = 4 THEN 'FOI TRANSFERIDO PARA OUTRA ESCOLA5 - NAO PARTICIPOU - OUTRAS SITUAÇÕES'::text
            ELSE NULL::text
        END AS motivo_nao_particiapacao,
        CASE
            WHEN aa.nr_alternativa_escolhida = 6 THEN 'leitor_fluente'::text
            WHEN aa.nr_alternativa_escolhida = 5 THEN 'leitor_sem_fluencia'::text
            WHEN aa.nr_alternativa_escolhida = 4 THEN 'leitor_frase'::text
            WHEN aa.nr_alternativa_escolhida = 3 THEN 'leitor_palavra'::text
            WHEN aa.nr_alternativa_escolhida = 2 THEN 'leitor_silaba'::text
            WHEN aa.nr_alternativa_escolhida = 1 THEN 'nao_leitor'::text
            WHEN aa.nr_alternativa_escolhida = 0 THEN 'nao_avaliado'::text
            ELSE NULL::text
        END AS situacao_leitura
   FROM tb_enturmacao ent
     JOIN tb_aluno al ON ent.cd_aluno = al.ci_aluno AND al.fl_ativo = true AND ent.fl_ativo = true
     JOIN tb_turma t ON ent.cd_turma = t.ci_turma
     JOIN tb_escola esc ON t.cd_escola = esc.ci_escola
     JOIN tb_cidade cid ON esc.cd_cidade = cid.ci_cidade
     JOIN tb_avaliacao_upload au ON t.cd_etapa = au.cd_etapa
     JOIN tb_avaliacaoleitura_aluno aa ON aa.cd_avaliacao_upload = au.ci_avaliacao_upload AND al.ci_aluno = aa.cd_aluno
     WHERE au.ci_avaliacao_upload in (".$avaliacao.")
                    and ci_escola=$escola 
  ORDER BY au.nm_caderno, cid.nm_cidade, esc.nm_escola, t.nm_turma, al.ci_aluno;";
        $query=$this->db->query($sql);
        return $query->result();
    }
}