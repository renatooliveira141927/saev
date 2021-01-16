<?php 

class Lancamentoavaliacao_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();        
    }
    
    public function lancamentoEdicaoEscolaTurma($parametro=null){
        
        if($parametro!=null){
            $sql="select res.ci_escola,res.nm_escola,
        	               res.ci_etapa,res.nm_etapa,res.cd_edicao,
                           res.nm_turma,  
        	               res.cd_aluno,
	                       al.nm_aluno,
        	               count(distinct taa.cd_aluno) as leitura,
        	               count(distinct escritap.cd_aluno) as escritap,
        	               count(distinct escritam.cd_aluno) as escritam
        	     from (
                    	select distinct esc.ci_escola,esc.nm_escola,
                    		   te.ci_etapa,te.nm_etapa,
                    		   tau.cd_edicao,
                               tr.nm_turma, 
                    		   tau.ci_avaliacao_upload,
                    		   tu.cd_aluno
                    	from tb_escola esc
                    	 	inner join tb_turma tr on tr.cd_escola=esc.ci_escola
                    	 		and esc.fl_ativo=true and tr.fl_ativo=true
                                and tr.cd_etapa=".$parametro['cd_etapa']."    
                    		inner join tb_etapa te on tr.cd_etapa=te.ci_etapa
                    			and te.fl_ativo=true
                    		inner join tb_ultimaenturmacao tu on tu.cd_turma=tr.ci_turma
                    		inner join tb_avaliacao_upload tau on tau.cd_etapa=te.ci_etapa
                    				and tau.fl_ativo=true 
                                    and tau.cd_edicao=".$parametro['cd_edicao']."                                            
                    		inner join tb_avaliacao_cidade tac on tau.ci_avaliacao_upload=tac.cd_avaliacao_upload
                    				and esc.cd_cidade=tac.cd_cidade
                    				and tr.nr_ano_letivo=extract(year from tac.dt_final)
                            inner join tb_cidade cid on tac.cd_cidade=cid.ci_cidade
                            inner join tb_estado est on cid.cd_estado=est.ci_estado
                    		where 1=1";
            if(isset($parametro['cd_escola']) && $parametro['cd_escola']!=null){
                $sql.=" and esc.ci_escola=".$parametro['cd_escola'];
            }
            $sql.= ") res
                    inner join tb_aluno al on res.cd_aluno=al.ci_aluno
                    left join tb_avaliacaoleitura_aluno taa on taa.cd_avaliacao_upload=res.ci_avaliacao_upload
                                    and res.cd_aluno=taa.cd_aluno
                    left join
                                (
                                select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                                		aa.cd_aluno,
                                		te.ci_edicao
                                from tb_avaliacao_aluno aa
                                 inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                                 inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                                 	and au.fl_ativo=true
                                    and au.cd_disciplina=1
                                 inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                                where au.cd_avalia_tipo=1
                
                                ) escritam on res.cd_edicao=escritam.ci_edicao and res.cd_aluno=escritam.cd_aluno
        	                       and escritam.cd_avaliacao_upload=res.ci_avaliacao_upload
                
                            left join
                            (
                            select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                            		aa.cd_aluno,
                            		te.ci_edicao
                            from tb_avaliacao_aluno aa
                             inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                             inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                             	and au.fl_ativo=true
                                and au.cd_disciplina=2
                             inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                            where au.cd_avalia_tipo=1
                            ) escritap on res.cd_edicao=escritap.ci_edicao and res.cd_aluno=escritap.cd_aluno
                            	and escritap.cd_avaliacao_upload=res.ci_avaliacao_upload
                    group by res.ci_escola,res.nm_escola,
        	                 res.ci_etapa,res.nm_etapa,res.cd_edicao,res.nm_turma,res.cd_aluno,	al.nm_aluno;";
            
            $query=$this->db->query($sql);
            return $query->result();
        }
    }

    public function lancamentoEdicaoEscola($parametro=null){
        if($parametro!=null){
        	$sql="select res.ci_escola,res.nm_escola,
        	               res.ci_etapa,res.nm_etapa,res.cd_edicao,
        	               count(distinct res.cd_aluno) as enturmacao,
        	               count(distinct taa.cd_aluno) as leitura,
        	               count(distinct escritap.cd_aluno) as escritap,
        	               count(distinct escritam.cd_aluno) as escritam
        	     from (
                    	select distinct esc.ci_escola,esc.nm_escola,
                    		   te.ci_etapa,te.nm_etapa,
                    		   tau.cd_edicao,
                    		   tau.ci_avaliacao_upload,
                    		   tu.cd_aluno 
                    	from tb_escola esc
                    	 	inner join tb_turma tr on tr.cd_escola=esc.ci_escola
                    	 		and esc.fl_ativo=true and tr.fl_ativo=true 
                    		inner join tb_etapa te on tr.cd_etapa=te.ci_etapa 
                    			and te.fl_ativo=true 
                    		inner join tb_ultimaenturmacao tu on tu.cd_turma=tr.ci_turma			
                    		inner join tb_avaliacao_upload tau on tau.cd_etapa=te.ci_etapa 
                    				and tau.fl_ativo=true and tau.cd_edicao=".$parametro['cd_edicao']."
                    		inner join tb_avaliacao_cidade tac on tau.ci_avaliacao_upload=tac.cd_avaliacao_upload
                    				and esc.cd_cidade=tac.cd_cidade
                    				and tr.nr_ano_letivo=extract(year from tac.dt_final)
                            inner join tb_cidade cid on tac.cd_cidade=cid.ci_cidade
                            inner join tb_estado est on cid.cd_estado=est.ci_estado 
                    		where 1=1";
        	if(isset($parametro['cd_escola']) && $parametro['cd_escola']!=null){
        	    $sql.=" and esc.ci_escola=".$parametro['cd_escola'];
        	}      
        	      $sql.= ") res	
                    left join tb_avaliacaoleitura_aluno taa on taa.cd_avaliacao_upload=res.ci_avaliacao_upload
                                    and res.cd_aluno=taa.cd_aluno
                    left join 
                                (
                                select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                                		aa.cd_aluno,
                                		te.ci_edicao 
                                from tb_avaliacao_aluno aa
                                 inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                                 inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                                 	and au.fl_ativo=true and au.cd_disciplina=1
                                 inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                                where au.cd_avalia_tipo=1 
                                 
                                ) escritam on res.cd_edicao=escritam.ci_edicao and res.cd_aluno=escritam.cd_aluno
        	                       and escritam.cd_avaliacao_upload=res.ci_avaliacao_upload 
        
                            left join 
                            (
                            select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                            		aa.cd_aluno,
                            		te.ci_edicao 
                            from tb_avaliacao_aluno aa
                             inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                             inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                             	and au.fl_ativo=true
                             inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                            where au.cd_avalia_tipo=1   and au.cd_disciplina=2
                            ) escritap on res.cd_edicao=escritap.ci_edicao and res.cd_aluno=escritap.cd_aluno
                            	and escritap.cd_avaliacao_upload=res.ci_avaliacao_upload 
                    group by res.ci_escola,res.nm_escola,
        	                 res.ci_etapa,res.nm_etapa,res.cd_edicao;";
        	
        	   $query=$this->db->query($sql);
        	   return $query->result();
        }
    }
    
    public function lancamentoEdicaomunicipio($parametro=null){
        if($parametro!=null){
        $sql="select res.ci_estado,res.nm_uf,res.nm_estado,res.ci_cidade,res.nm_cidade, 
                     res.ci_escola,res.nm_escola,res.cd_edicao,
            	     count(distinct res.cd_aluno) as enturmacao,
            	     count(distinct taa.cd_aluno) as leitura,
        	               count(distinct escritap.cd_aluno) as escritap,
        	               count(distinct escritam.cd_aluno) as escritam 
                    from (
                        	select distinct est.ci_estado, 
                                    est.nm_uf,est.nm_estado,
                                    cid.ci_cidade,cid.nm_cidade, 
                                   esc.ci_escola,esc.nm_escola,            		   
                        		   tau.cd_edicao,
                        		   tau.ci_avaliacao_upload,
                        		   tu.cd_aluno 
                        	from tb_escola esc
                        	 	inner join tb_turma tr on tr.cd_escola=esc.ci_escola
                        	 		and esc.fl_ativo=true and tr.fl_ativo=true 
                        		inner join tb_etapa te on tr.cd_etapa=te.ci_etapa 
                        			and te.fl_ativo=true 
                        		inner join tb_ultimaenturmacao tu on tu.cd_turma=tr.ci_turma			
                        		inner join tb_avaliacao_upload tau on tau.cd_etapa=te.ci_etapa 
                        				and tau.fl_ativo=true and tau.cd_edicao=".$parametro['cd_edicao']."
                        		inner join tb_avaliacao_cidade tac on tau.ci_avaliacao_upload=tac.cd_avaliacao_upload
                        				and esc.cd_cidade=tac.cd_cidade
                        				and tr.nr_ano_letivo=extract(year from tac.dt_final) 
                                inner join tb_cidade cid on tac.cd_cidade=cid.ci_cidade
                                inner join tb_estado est on cid.cd_estado=est.ci_estado
                        		where 1=1 ";
        
                if(isset($parametro['cd_municipio']) && $parametro['cd_municipio']!=null){
                    $sql.=" and esc.cd_cidade=".$parametro['cd_municipio'];
                }
                
                $sql.=") res	
                    left join tb_avaliacaoleitura_aluno taa on taa.cd_avaliacao_upload=res.ci_avaliacao_upload
                    			 and res.cd_aluno=taa.cd_aluno
            left join 
            ( select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                		aa.cd_aluno,
                		te.ci_edicao 
                from tb_avaliacao_aluno aa
                 inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                 inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
                 	and au.fl_ativo=true
                 inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                where au.cd_avalia_tipo=1 and au.cd_disciplina=1             
            ) escritam on res.cd_edicao=escritam.ci_edicao 
                        and res.cd_aluno=escritam.cd_aluno
            	        and escritam.cd_avaliacao_upload=res.ci_avaliacao_upload             
            left join 
            ( select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
            		aa.cd_aluno,
            		te.ci_edicao 
              from tb_avaliacao_aluno aa
                    inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                    inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload
             	          and au.fl_ativo=true
                    inner join tb_edicao te on au.cd_edicao=te.ci_edicao
              where au.cd_avalia_tipo=1  and au.cd_disciplina=2
            ) escritap on res.cd_edicao=escritap.ci_edicao and res.cd_aluno=escritap.cd_aluno
	               and escritap.cd_avaliacao_upload=res.ci_avaliacao_upload 
	        group by res.ci_estado,res.nm_uf,res.nm_estado,res.ci_cidade,res.nm_cidade,res.ci_escola,res.nm_escola,res.cd_edicao;";

        $query=$this->db->query($sql);
        return $query->result();
        }
    }
    
    public function lancamentoEdicaoGeral($parametro=null){
    if($parametro!=null){
        $sql="select res.ci_estado,res.nm_uf,res.nm_estado,res.ci_cidade,res.nm_cidade,res.cd_edicao,
                    count(distinct res.cd_aluno) as enturmacao,
                    count(distinct taa.cd_aluno) as leitura,
        	               count(distinct escritap.cd_aluno) as escritap,
        	               count(distinct escritam.cd_aluno) as escritam
             from (
                    select distinct est.ci_estado, 
                            est.nm_uf,
                            est.nm_estado,
                            cid.ci_cidade,
                            cid.nm_cidade,
                            tau.cd_edicao,
                            tau.ci_avaliacao_upload,
                            tu.cd_aluno
                    from tb_escola esc
                    inner join tb_turma tr on tr.cd_escola=esc.ci_escola
                            and esc.fl_ativo=true and tr.fl_ativo=true
                    inner join tb_etapa te on tr.cd_etapa=te.ci_etapa
                            and te.fl_ativo=true
                    inner join tb_ultimaenturmacao tu on tu.cd_turma=tr.ci_turma
                    inner join tb_avaliacao_upload tau on tau.cd_etapa=te.ci_etapa
                            and tau.fl_ativo=true and tau.cd_edicao=".$parametro['cd_edicao']."
                    inner join tb_avaliacao_cidade tac on tau.ci_avaliacao_upload=tac.cd_avaliacao_upload
                            and esc.cd_cidade=tac.cd_cidade and tr.nr_ano_letivo=extract(year from tac.dt_final)
                    inner join tb_cidade cid on tac.cd_cidade=cid.ci_cidade
                    inner join tb_estado est on cid.cd_estado=est.ci_estado
             where 1=1";
        
        if(isset($parametro['cd_estado']) && $parametro['cd_estado']!=null){ 
                $sql.=" and EST.ci_estado=".$parametro['cd_estado'];
        }
        if(isset($parametro['cd_municipio']) && $parametro['cd_municipio']!=null){
            $sql.=" and cid.ci_cidade=".$parametro['cd_municipio'];
        }
            
            $sql.=" ) res
            left join tb_avaliacaoleitura_aluno taa on taa.cd_avaliacao_upload=res.ci_avaliacao_upload and res.cd_aluno=taa.cd_aluno
            left join
               ( select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,
                     aa.cd_aluno,te.ci_edicao
                 from tb_avaliacao_aluno aa
                    inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                    inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload and au.fl_ativo=true
                    inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                 where au.cd_avalia_tipo=1 and au.cd_disciplina=1
               ) escritam on res.cd_edicao=escritam.ci_edicao and res.cd_aluno=escritam.cd_aluno
                            and escritam.cd_avaliacao_upload=res.ci_avaliacao_upload                
            left join
                ( select distinct au.ci_avaliacao_upload as cd_avaliacao_upload,aa.cd_aluno,te.ci_edicao
                  from tb_avaliacao_aluno aa
                    inner join tb_avaliacao_matriz am on am.ci_avaliacao_matriz = aa.cd_avaliacao_itens
                    inner join tb_avaliacao_upload au on au.ci_avaliacao_upload = am.cd_avaliacao_upload and au.fl_ativo=true
                    inner join tb_edicao te on au.cd_edicao=te.ci_edicao
                  where au.cd_avalia_tipo=1 and au.cd_disciplina=2
                ) escritap on res.cd_edicao=escritap.ci_edicao and res.cd_aluno=escritap.cd_aluno
                                and escritap.cd_avaliacao_upload=res.ci_avaliacao_upload
            group by res.ci_estado,res.nm_uf,res.nm_estado,res.ci_cidade,res.nm_cidade,res.cd_edicao;";
                    
        $query=$this->db->query($sql);
        return $query->result();
    }
   }
}