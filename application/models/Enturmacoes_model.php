<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Enturmacoes_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();
        
    }
    
    public function count_buscar(   $nr_inep_aluno  = null,
        $nm_aluno       = null,
        $cd_escola      = null,
        $nr_inep_escola = null,
        $nm_escola      = null,
        $cd_cidade      = null,
        $cd_turma       = null,
        $cd_etapa       = null,
        $cd_turno       = null,
        $nr_anoletivo   = null ){
            
            
            return count($this->buscar( $nr_inep_aluno,
                $nm_aluno,
                $cd_escola,
                $nr_inep_escola,
                $nm_escola,
                $cd_cidade,
                $cd_turma,
                $cd_etapa,
                $cd_turno,
                $nr_anoletivo));
    }
    
    public function buscar( $nr_inep_aluno  = null,
        $nm_aluno       = null,
        $cd_escola      = null,
        $nr_inep_escola = null,
        $nm_escola      = null,
        $cd_cidade      = null,
        $cd_turma       = null,
        $cd_etapa       = null,
        $cd_turno       = null,
        $nr_anoletivo   = null,        
        $relatorio      = null,
        $limit          = null,
        $offset         = null){
            //         //traz alunos que estejam com enturmacao falsa
            //        $subselect="select max(ci_enturmacao) as id from tb_enturmacao ent
            //                         inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
            //                         inner join tb_escola esc on al.cd_escola=esc.ci_escola
            //                                 and esc.cd_cidade=$cd_cidade
            //                         where not exists
            //                         	(select 1 from tb_enturmacao ent1
            //                         		where ent.cd_aluno=ent1.cd_aluno
            //                         			and ent1.fl_ativo=true)
            //                         group by cd_aluno;";
            
            //        $query=$this->db->query($subselect)->result();
            //        $inIds=array();
            //        foreach ($query as $row) {
            //            //print_r($row->id);
            //            $inIds[]= implode(",", (array)$row->id);
            //        }
            //        $parametros=implode(",", $inIds); //trata o retorno para ser usado como lista de parametros na sql a seguir
            
            //traz lista de enturmados e sem enturmacao
            $this->db->distinct()->select('tb_aluno.*,
                            tb_ultimaenturmacao.ci_ultimaenturmacao,
                            tb_enturmacao.ci_enturmacao,
                            tb_ultimaenturmacao.cd_turma,
                            tb_turma.nm_turma,
                            tb_turma.cd_etapa,
                            tb_etapa.nm_etapa,
                            "tb_turno".ci_turno,
                            "tb_turno".nm_turno,
                            tb_cidade.nm_cidade,
                            tb_cidade.cd_estado,
                            tb_estado.nm_estado');
            $this->db->from('tb_aluno');
            $this->db->join('tb_cidade', 'tb_aluno.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');
            
            $this->db->join('tb_ultimaenturmacao', 'tb_aluno.ci_aluno = tb_ultimaenturmacao.cd_aluno ', 'left');
            $this->db->join('tb_enturmacao', 'tb_enturmacao.cd_aluno = tb_ultimaenturmacao.cd_aluno
                            and tb_enturmacao.cd_turma=tb_ultimaenturmacao.cd_turma', 'left');
            
            if ($cd_turma)
            {
                $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma and tb_turma.cd_escola=tb_aluno.cd_escola');
            }else{
                $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma', 'left');
            }
            
            if ($cd_turno)
            {
                $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
            }else{
                $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno', 'left');
            }
            if ($cd_etapa)
            {
                $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
            }else{
                $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa', 'left');
            }
            $this->db->where('(tb_aluno.fl_ativo = true)');
            //$this->db->where('( tb_turma.fl_ativo=true');
            //$this->db->or_where('tb_turma.ci_turma is null )');
            
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
            
            if ($nr_anoletivo)
            {
                $this->db->where('tb_ultimaenturmacao.nr_anoletivo ', $nr_anoletivo);
            }
            
            if ($cd_escola)
            {
                $this->db->where('tb_aluno.cd_escola', $cd_escola);
            }
            
            $this->db->order_by('tb_aluno.nm_aluno', 'ASC');
            $this->db->order_by('tb_aluno.ci_aluno', 'ASC');
            $this->db->order_by('tb_ultimaenturmacao.ci_ultimaenturmacao', 'DESC');
            
            if ($limit && $offset) {
                $this->db->limit($limit, $offset);
            }elseif ($limit && !$offset){
                $this->db->limit($limit);
            }
            
            if ($relatorio){
                $retorno= $this->db->get();
                
            }else{
                $retorno= $this->db->get()->result();
            }
            //echo $this->db->last_query();die;
            return $retorno;
    }
    
    
    public function inserir($arr_cd_alunos=null,$enturmacoes = null, $qtd_reg = null){
        
        foreach ($enturmacoes as $enturmacao){
            $params['cd_aluno']=$enturmacao->cd_aluno;
            $params['cd_turma']=!empty($enturmacao->cd_turma)?$enturmacao->cd_turma:null;
            
            $params['cd_turma']=$enturmacao->cd_turma;
            $dadosturma=$this->buscadadosturma($params);
            print($dadosturma);die;
            
            if(isset($enturmacao->ci_enturmacao)){
                $dados['fl_ativo']        = $enturmacao->fl_ativo;
                $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
                $dados['dt_alteracao']     = "now()";
                $this->db->where('ci_enturmacao', $enturmacao->ci_enturmacao);
                $this->db->update('tb_enturmacao', $dados);
                
                $dadosultimaenturmacao['cd_aluno']=$enturmacao->cd_aluno;
                $dadosultimaenturmacao['cd_turma']=$enturmacao->cd_turma;
                $dadosultimaenturmacao['nr_anoletivo']=$dadosturma->nr_anoletivo;
                $this->db->where('cd_aluno', $enturmacao->cd_aluno);
                $this->db->update('tb_ultimaenturmacao', $dadosultimaenturmacao);
                
            }else{
                $dados['cd_aluno']=$enturmacao->cd_aluno;
                $dados['cd_turma']=$enturmacao->cd_turma;
                $dados['fl_ativo']        = true;
                $dados['cd_usuario_cad']  = $this->session->userdata('ci_usuario');
                $dados['dt_cadastro']     = "now()";
                $this->db->insert('tb_enturmacao', $dados);
                
                $dadosultimaenturmacao['cd_aluno']=$enturmacao->cd_aluno;
                $dadosultimaenturmacao['cd_turma']=$enturmacao->cd_turma;
                $dadosultimaenturmacao['nr_anoletivo']=$dadosturma->nr_anoletivo;
                $this->db->insert('tb_ultimaenturmacao', $dadosultimaenturmacao);
            }
        }
        return true;
    }
    
    public function gravar($enturmacoes = null){
        
        if($enturmacoes!=null){
            foreach ($enturmacoes as $enturmacao){
                $enturmar = new stdClass();
                $dadosultimaenturmacao = new stdClass();
                $enturmar = new stdClass();
                                
                $params['cd_turma']=$enturmacao->cd_turma?$enturmacao->cd_turma:0;
                $params['cd_aluno']=$enturmacao->cd_aluno;
                $existeenturmacao=$this->buscaEnturmacaoAluno($params);
                $params['cd_turma']=$enturmacao->cd_turma?$enturmacao->cd_turma:0;
                $dadosturma=$this->buscadadosturma($params);
                
                if(isset($enturmacao->ci_enturmacao)  ){
                    
                    if(!empty($enturmacao->cd_turma)){
                  
                        $enturmar->cd_aluno=$enturmacao->cd_aluno;
                        $enturmar->cd_turma=$enturmacao->cd_turma;
                        $enturmar->fl_ativo=$enturmacao->fl_ativo;
                        $enturmar->cd_usuario_alt  = $this->session->userdata('ci_usuario');
                        $enturmar->dt_alteracao     = "now()";
                        $this->db->where('ci_enturmacao', $enturmacao->ci_enturmacao);
                        $this->db->update('tb_enturmacao', $enturmar);
                        
                            if(empty($enturmacao->ci_ultimaenturmacao)){
                                
                                $dadosultimaenturmacao->cd_aluno=$enturmacao->cd_aluno;
                                $dadosultimaenturmacao->cd_turma=$enturmacao->cd_turma;
                                $dadosultimaenturmacao->nr_anoletivo=$dadosturma[0]->nr_ano_letivo;
                                $dadosultimaenturmacao->cd_usuario_cad=$this->session->userdata('ci_usuario');
                                $dadosultimaenturmacao->dt_cadastro=date('Y-m-d');
                                $this->db->insert('tb_ultimaenturmacao', $dadosultimaenturmacao);
                                
                            }else {
                                $dadosultimaenturmacao->cd_aluno=$enturmacao->cd_aluno;
                                $dadosultimaenturmacao->cd_turma=$enturmacao->cd_turma;
                                $dadosultimaenturmacao->nr_anoletivo=$dadosturma[0]->nr_ano_letivo;
                                $dadosultimaenturmacao->cd_usuario_alt=$this->session->userdata('ci_usuario');
                                $dadosultimaenturmacao->dt_alteracao=date('Y-m-d');
                                $this->db->where('ci_ultimaenturmacao', $enturmacao->ci_ultimaenturmacao);
                                $this->db->update('tb_ultimaenturmacao', $dadosultimaenturmacao);                               
                                
                            }
                    }
                }else if(!empty($enturmacao->cd_turma) && !$existeenturmacao ){
                    
                    $desenturmaraluno= new stdClass();
                    $desenturmaraluno->fl_ativo=false;
                    $desenturmaraluno->cd_aluno=$enturmacao->cd_aluno;
                    $this->db->where('cd_aluno', $enturmacao->cd_aluno);
                    $this->db->update('tb_enturmacao', $desenturmaraluno);
                    
                    $enturmar->cd_aluno=$enturmacao->cd_aluno;
                    $enturmar->cd_turma=$enturmacao->cd_turma;
                    $enturmar->fl_ativo        = true;
                    $enturmar->cd_usuario_cad  = $this->session->userdata('ci_usuario');
                    $enturmar->dt_cadastro     = "now()";
                    $this->db->insert('tb_enturmacao', $enturmar);
                    
                    $dadosultimaenturmacao->cd_aluno=$enturmacao->cd_aluno;
                    $dadosultimaenturmacao->cd_turma=$enturmacao->cd_turma;
                    $dadosultimaenturmacao->nr_anoletivo=$dadosturma[0]->nr_ano_letivo;
                    $dadosultimaenturmacao->cd_usuario_cad=$this->session->userdata('ci_usuario');
                    $dadosultimaenturmacao->dt_cadastro=date('Y-m-d');
                    $this->db->insert('tb_ultimaenturmacao', $dadosultimaenturmacao);
                }
            }
            return true;
        }else{
            return false;
        }
        
    }
    public function gravar_enturmacaoAluno($enturmacoes = null){
        
        if($enturmacoes!=null){
            foreach ($enturmacoes as $enturmacao){
                $enturmar = new stdClass();
                $dadosultimaenturmacao = new stdClass();
                $enturmar = new stdClass();
                
                $qtd_Enturmacoes            =   0;
                $qtd_UltimaEnturmacao       =   0;
                $params['cd_aluno']         =   $enturmacao->cd_aluno;
                
                $qtd_UltimaEnturmacao       =   count($this->buscaUltimaEnturmacaoAluno($params));
                
                $params['cd_turma']         =   $enturmacao->cd_turma;
                
                if (!empty($enturmacao->cd_turma)){
                    
                    $entumacao_dados            =   $this->buscaEnturmacaoAluno($params);
                    $qtd_Enturmacoes            =   count($entumacao_dados);
                    
                    if ($qtd_Enturmacoes > 0){
                        $enturmacao->ci_enturmacao = $entumacao_dados[0]->ci_enturmacao;
                    }
                    $enturmacao->nr_anoletivo   =   $this->buscadadosturma($params)[0]->nr_ano_letivo;
                }else{
                    
                    $enturmacao->ci_enturmacao = '';
                    $enturmacao->nr_anoletivo   =  '';
                }
                
                
                
                // echo '<br><$enturmacao->ci_enturmacao='.$enturmacao->ci_enturmacao;
                // echo '<br><br>$qtd_Enturmacoes='.$qtd_Enturmacoes;
                // echo '<br><br>$qtd_UltimaEnturmacao ='.$qtd_UltimaEnturmacao ;
                // echo '<br><br>$enturmacao->cd_aluno ='.$enturmacao->cd_aluno ;
                // echo '<br><br>$enturmacao->cd_turma='.$enturmacao->cd_turma;die;
                
                
                
                if ($qtd_Enturmacoes > 0) {
                    if(!empty($enturmacao->cd_turma)){
                        $enturmar->cd_aluno         =   $enturmacao->cd_aluno;
                        $enturmar->cd_turma         =   $enturmacao->cd_turma;
                        $enturmar->fl_ativo         =   $enturmacao->fl_ativo;
                        $enturmar->cd_usuario_alt   =   $this->session->userdata('ci_usuario');
                        $enturmar->dt_alteracao     =   "now()";
                        $this->db->where('ci_enturmacao', $enturmacao->ci_enturmacao);
                        $this->db->update('tb_enturmacao', $enturmar);
                        
                        if ($qtd_UltimaEnturmacao == 0){
                            
                            $dadosultimaenturmacao->cd_aluno        =   $enturmacao->cd_aluno;
                            $dadosultimaenturmacao->cd_turma        =   $enturmacao->cd_turma;
                            $dadosultimaenturmacao->nr_anoletivo    =   $enturmacao->nr_anoletivo;
                            $dadosultimaenturmacao->cd_usuario_cad  =   $this->session->userdata('ci_usuario');
                            $dadosultimaenturmacao->dt_cadastro     =   "now()";
                            $this->db->insert('tb_ultimaenturmacao', $dadosultimaenturmacao);
                            
                        }else{
                            $dadosultimaenturmacao->cd_aluno        =   $enturmacao->cd_aluno;
                            $dadosultimaenturmacao->cd_turma        =   $enturmacao->cd_turma;
                            $dadosultimaenturmacao->nr_anoletivo    =   $enturmacao->nr_anoletivo;
                            $dadosultimaenturmacao->cd_usuario_alt  =   $this->session->userdata('ci_usuario');
                            $dadosultimaenturmacao->dt_alteracao    =   "now()";
                            $this->db->where('ci_ultimaenturmacao', $enturmacao->ci_ultimaenturmacao);
                            $this->db->update('tb_ultimaenturmacao', $dadosultimaenturmacao);
                        }
                        
                    }
                }else if(empty($enturmacao->cd_turma) ){
                    
                    $desenturmaraluno= new stdClass();
                    $desenturmaraluno->fl_ativo         =   false;
                    $desenturmaraluno->cd_aluno         =   $enturmacao->cd_aluno;
                    $this->db->where('cd_aluno', $enturmacao->cd_aluno);
                    $this->db->update('tb_enturmacao', $desenturmaraluno);
                    
                    //$dadosultimaenturmacao->cd_aluno    =   $enturmacao->cd_aluno;
                    $this->db->delete('tb_ultimaenturmacao', array('cd_aluno' => $enturmacao->cd_aluno));
                    
                }else if(!empty($enturmacao->cd_turma) ){
                    
                    // echo '<br><br>$qtd_Enturmacoes='.$qtd_Enturmacoes;
                    // echo '<br><br>$qtd_UltimaEnturmacao ='.$qtd_UltimaEnturmacao ;
                    // echo '<br><br>$enturmacao->cd_aluno ='.$enturmacao->cd_aluno ;
                    // echo '<br><br>$enturmacao->cd_turma='.$enturmacao->cd_turma;die;
                    $desenturmaraluno= new stdClass();
                    
                    $enturmar->cd_aluno     =   $enturmacao->cd_aluno;
                    $enturmar->cd_turma     =   $enturmacao->cd_turma;
                    $enturmar->fl_ativo        = true;
                    $enturmar->cd_usuario_cad  = $this->session->userdata('ci_usuario');
                    $enturmar->dt_cadastro     = "now()";
                    $this->db->insert('tb_enturmacao', $enturmar);
                    
                    $this->db->delete('tb_ultimaenturmacao', array('cd_aluno' => $enturmacao->cd_aluno));
                    
                    $dadosultimaenturmacao->cd_aluno        =   $enturmacao->cd_aluno;
                    $dadosultimaenturmacao->cd_turma        =   $enturmacao->cd_turma;
                    $dadosultimaenturmacao->nr_anoletivo    =   $enturmacao->nr_anoletivo;
                    $dadosultimaenturmacao->cd_usuario_cad  =   $this->session->userdata('ci_usuario');
                    $dadosultimaenturmacao->dt_cadastro     =   "now()";
                    $this->db->insert('tb_ultimaenturmacao', $dadosultimaenturmacao);
                }
            }
            return true;
        }else{
            return false;
        }
        
    }
    public function buscaUltimaEnturmacaoAluno($params){
        
        $sql=" select ent.*,al.* from tb_ultimaenturmacao ent
                inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
               where 1=1 ";
        if(isset($params['cd_aluno'])){$sql.=" and ent.cd_aluno=".$params['cd_aluno'];}
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        
        if(!isset($params['cd_aluno']) && !isset($params['cd_turma']) ){
            $sql.=" and ent.nr_anoletivo=extract(year from now())";
        }
        
        $sql.=" order by al.nm_aluno limit 1000;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaEnturmacaoAluno($params){
        
        $sql=" select ent.* from tb_enturmacao ent
               where ent.fl_ativo=true";
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_aluno'])){$sql.=" and ent.cd_aluno=".$params['cd_aluno'];}
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaAlunoIdentificarMicrodados($params){
        
        if($params['cd_disciplina']==1){
            $tabela="tb_microdados_matematica ";
        }else{
            $tabela="tb_microdados_portugues ";
        }
        
        $sql=" select al.ci_aluno, al.nm_aluno from tb_ultimaenturmacao ent 
	inner join tb_aluno al on ent.cd_aluno=al.ci_aluno 
			and al.fl_ativo=true 
	inner join tb_turma t on ent.cd_turma=t.ci_turma 
	inner join tb_escola esc on t.cd_escola=esc.ci_escola
 
inner join (
	select * from tb_estado est
		 inner join tb_cidade cit on est.ci_estado=cit.cd_estado 
	where fc_retira_all(cit.nm_cidade) in (".$params['cidades']."') 
		and fc_retira_all(est.nm_estado) in (".$params['uf']."') 
	)cit on esc.cd_cidade = cit.ci_cidade 

	inner join (select distinct fc_retira_all(tmm.nm_estado) as nm_estado,
				fc_retira_all(tmm.nm_municipio)as nm_cidade
				from ". 
				    $tabela 
				."tmm
				where cd_alunosaev is null
		          and fc_retira_all(tmm.nm_municipio) in (".$params['cidades']."')
		          and fc_retira_all(tmm.nm_estado) in (".$params['uf']."') 
            )res on 
			         res.nm_estado=fc_retira_all(cit.nm_estado) 
			                 and res.nm_cidade=fc_retira_all(cit.nm_cidade)
        where 1=1 and ent.nr_anoletivo=extract(year from now())
	           and not exists (select 1 from ".$tabela." tmm1 where tmm1.cd_alunosaev=ent.cd_aluno)";
        
        $sql.=" order by al.nm_aluno;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function selectIdentificarAlunos($params=null){
        
        $params['uf']= substr($params['estados'], 2);
        $params['cidades']= substr($params['municipios'], 2);
        
        $options = "<option value=''>Selecione um Aluno</option>";
        $alunos = $this->buscaAlunoIdentificarMicrodados($params);
        
        foreach ($alunos as $aluno){            
           $options .= "<option value='{$aluno->ci_aluno}'>".trim($aluno->nm_aluno)."</option>".PHP_EOL;            
        }
        return $options;
    }
    
    public function buscaEnturmacao($params){
        
        $sql=" select distinct al.*,aa.cd_situacao_aluno,au.ci_avaliacao_upload as ci_avaliacao from tb_enturmacao ent
	              inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
	              inner join tb_turma t on ent.cd_turma=t.ci_turma
	              inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
	              inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
	              left join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno
		              and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
              where ent.fl_ativo=true";
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_etapa'])){$sql.=" and t.cd_etapa=".$params['cd_etapa'];}
        if(isset($params['cd_aluno'])){$sql.=" and al.ci_aluno=".$params['cd_aluno'];}
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        if(isset($params['cd_escola'])){$sql.="   and al.cd_escola =".$params['cd_escola'];}
        
        $sql.=" order by al.nm_aluno;";
        // print_r('<br>$sql=<br>'. $sql);
        // die;
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaEnturmacaoNova($params){
        
        $sql="select distinct ci_aluno,cd_escola,nm_aluno,
                       cd_tipodeficiencia,ds_tipodeficiencia,ci_avaliacao,
	                   sum(cd_situacao_aluno) as cd_situacao_aluno
              from ( select distinct al.ci_aluno,al.cd_escola,al.nm_aluno,
	                           coalesce(aa.cd_situacao_aluno,0) as cd_situacao_aluno,
	                           au.ci_avaliacao_upload as ci_avaliacao,
                               al.cd_tipodeficiencia, td.ds_tipodeficiencia
                    from tb_enturmacao ent
                  inner join tb_ultimaenturmacao ue on ent.cd_turma=ue.cd_turma
	              inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
                  inner join tb_tipodeficiencia td on al.cd_tipodeficiencia=td.ci_tipodeficiencia
	              inner join tb_turma t on ent.cd_turma=t.ci_turma
	              inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
	              inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
	              left join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno
		              and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
              where ent.fl_ativo=true";
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_etapa'])){$sql.=" and t.cd_etapa=".$params['cd_etapa'];}
        if(isset($params['cd_aluno'])){$sql.=" and al.ci_aluno=".$params['cd_aluno'];}
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        if(isset($params['cd_escola'])){$sql.="   and al.cd_escola =".$params['cd_escola'];}
        $sql.=" order by al.nm_aluno) rest
                    group by ci_aluno,cd_escola,nm_aluno,cd_tipodeficiencia,ds_tipodeficiencia,ci_avaliacao order by nm_aluno;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaEnturmacaoLeitura($params){
        
        $sql=" select distinct al.*,aa.cd_avaliacao_upload,aa.cd_situacao_aluno,aa.nr_alternativa_escolhida,
                    aa.cd_motivonaovaliacao_aluno, td.ds_tipodeficiencia
                    from tb_ultimaenturmacao ue
	              inner join tb_aluno al on ue.cd_aluno=al.ci_aluno
                            and al.fl_ativo='true'
                  inner join tb_tipodeficiencia td on al.cd_tipodeficiencia=td.ci_tipodeficiencia
	              inner join tb_turma t on ue.cd_turma=t.ci_turma
                  inner join tb_escola esc on t.cd_escola=esc.ci_escola
	              inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
	              left join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno
		              and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
              where t.fl_ativo='true' and t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ){$sql.=" and ue.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        //if(isset($params['ci_escola'])){$sql.="   and al.cd_escola =".$params['ci_escola'];}
        $sql.=" order by al.nm_aluno;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaEnturmacaoLeituraEscola($params){
        
        $sql=" select nm_escola,
                        coalesce(sum(leitor_fluente),0) as leitor_fluente,
                        coalesce(sum(leitor_sfluente),0)as leitor_sfluente,
                        coalesce(sum(leitor_frase),0) as leitor_frase,
                        coalesce(sum(leitor_palavra),0) as leitor_palavra,
                        coalesce(sum(leitor_silaba),0) as leitor_silaba,
                        coalesce(sum(nao_leitor),0) as nao_leitor,
	                    coalesce(sum(nao_avaliado), 0) as nao_avaliado
                from (
                select distinct esc.nm_escola,
                    al.*,aa.cd_avaliacao_upload,aa.cd_situacao_aluno,
                        case when aa.nr_alternativa_escolhida=6 then 1 end as leitor_fluente,
                        case when aa.nr_alternativa_escolhida=5 then 1 end as leitor_sfluente,
                        case when aa.nr_alternativa_escolhida=4 then 1 end as leitor_frase,
                        case when aa.nr_alternativa_escolhida=3 then 1 end as leitor_palavra,
                        case when aa.nr_alternativa_escolhida=2 then 1 end as leitor_silaba,
                        case when aa.nr_alternativa_escolhida=1 then 1 end as nao_leitor,
		                case when aa.nr_alternativa_escolhida = 0 then 1 end as nao_avaliado
                from tb_ultimaenturmacao ent
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo='true'
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola";
        $sql.=" where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ){
            $sql.=" and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
            if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
            if(isset($params['cd_cidade'])){$sql.="   and esc.cd_cidade=".$params['cd_cidade'];}
            /*$sql.=" where t.cd_etapa=
             and au.cd_disciplina=2
             and ci_avaliacao_upload=3 */
            $sql.=" )res group by nm_escola order by nm_escola;";
            
            $query=$this->db->query($sql);
            return $query->result();
    }
    
    public function graficoEnturmacaoLeituraEscola($params){
        
        $sql="select nm_escola, mes::integer as ordem,
                    nm_caderno,
                    case when mes=1 then 'JANEIRO'
                      when mes=2 then 'FEVEREIRO'
                      when mes=3 then 'MARCO'
                      when mes=4 then 'ABRIL'
                      when mes=5 then 'MAIO'
                      when mes=6 then 'JUNHO'
                      when mes=7 then 'JULHO'
                      when mes=8 then 'AGOSTO'
                      when mes=9 then 'SETEMBRO'
                      when mes=10 then 'OUTUBRO'
                      when mes=11 then 'NOVEMBRO'
                      when mes=12 then 'DEZEMBRO'
                 end as MES,
                        coalesce(sum(leitor_fluente),0) as leitor_fluente,
                        coalesce(sum(leitor_sfluente),0)as leitor_sfluente,
                        coalesce(sum(leitor_frase),0) as leitor_frase,
                        coalesce(sum(leitor_palavra),0) as leitor_palavra,
                        coalesce(sum(leitor_silaba),0) as leitor_silaba,
                        coalesce(sum(nao_leitor),0) as nao_leitor,
                        coalesce(sum(nao_avaliado),0) as nao_avaliado
                from (
            
                select distinct esc.nm_escola,
                        extract( month from tac.dt_final) as mes,
                        au.nm_caderno,
                        al.*,
                        aa.cd_avaliacao_upload,
                        aa.cd_situacao_aluno,
                        case when aa.nr_alternativa_escolhida=6 then 1 end as leitor_fluente,
                        case when aa.nr_alternativa_escolhida=5 then 1 end as leitor_sfluente,
                        case when aa.nr_alternativa_escolhida=4 then 1 end as leitor_frase,
                        case when aa.nr_alternativa_escolhida=3 then 1 end as leitor_palavra,
                        case when aa.nr_alternativa_escolhida=2 then 1 end as leitor_silaba,
                        case when aa.nr_alternativa_escolhida=1 then 1 end as nao_leitor,
                        case when aa.nr_alternativa_escolhida=0 then 1 end as nao_avaliado
                from tb_ultimaenturmacao ent
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo='true'
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
                    inner join tb_avaliacao_cidade tac on aa.cd_avaliacao_upload=tac.cd_avaliacao_upload 
                    		and tac.cd_cidade=esc.cd_cidade";
        $sql.=" where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ){
            $sql.=" and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
            if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
            $sql.=" and extract(year from tac.dt_final)=t.nr_ano_letivo )res group by nm_escola,mes,nm_caderno order by ordem,nm_caderno;";
            
            $query=$this->db->query($sql);
            return $query->result();
    }
    
    public function buscaEnturmacaoLeituraAlt($params){
        
        $sql=" select distinct al.*,aa.cd_avaliacao_upload,aa.cd_situacao_aluno,aa.nr_alternativa_escolhida,
                    aa.cd_motivonaovaliacao_aluno, td.ds_tipodeficiencia
                    from tb_enturmacao ent
	              inner join tb_aluno al on ent.cd_aluno=al.ci_aluno
                            and al.fl_ativo='true'
                  inner join tb_tipodeficiencia td on al.cd_tipodeficiencia=td.ci_tipodeficiencia
	              inner join tb_turma t on ent.cd_turma=t.ci_turma
	              inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
	              left join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno
		              and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
              where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        if(isset($params['ci_escola'])){$sql.="   and al.cd_escola =".$params['ci_escola'];}
        $sql.=" order by al.nm_aluno;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function graficoEnturmacaoLeituraMunicipioMes($params){
        
        $sql="		select nm_cidade, mes::integer as ordem,
                    case when mes=1 then 'JANEIRO'
                      when mes=2 then 'FEVEREIRO'
                      when mes=3 then 'MARCO'
                      when mes=4 then 'ABRIL'
                      when mes=5 then 'MAIO'
                      when mes=6 then 'JUNHO'
                      when mes=7 then 'JULHO'
                      when mes=8 then 'AGOSTO'
                      when mes=9 then 'SETEMBRO'
                      when mes=10 then 'OUTUBRO'
                      when mes=11 then 'NOVEMBRO'
                      when mes=12 then 'DEZEMBRO'
                 end as MES,upper(nm_caderno) as nm_caderno,
                        coalesce(sum(leitor_fluente),0) as leitor_fluente,
                        coalesce(sum(leitor_sfluente),0)as leitor_sfluente,
                        coalesce(sum(leitor_frase),0) as leitor_frase,
                        coalesce(sum(leitor_palavra),0) as leitor_palavra,
                        coalesce(sum(leitor_silaba),0) as leitor_silaba,
                        coalesce(sum(nao_leitor),0) as nao_leitor,
                        coalesce(sum(nao_avaliado),0) as nao_avaliado
                from (
            
                select distinct cid.nm_cidade,
                        extract( month from tac.dt_final) as mes,
                        au.ci_avaliacao_upload,
		                au.nm_caderno,
                        al.*,
                        aa.cd_avaliacao_upload,
                        aa.cd_situacao_aluno,
                        case when aa.nr_alternativa_escolhida=6 then 1 end as leitor_fluente,
                        case when aa.nr_alternativa_escolhida=5 then 1 end as leitor_sfluente,
                        case when aa.nr_alternativa_escolhida=4 then 1 end as leitor_frase,
                        case when aa.nr_alternativa_escolhida=3 then 1 end as leitor_palavra,
                        case when aa.nr_alternativa_escolhida=2 then 1 end as leitor_silaba,
                        case when aa.nr_alternativa_escolhida=1 then 1 end as nao_leitor,
                        case when aa.nr_alternativa_escolhida=0 then 1 end as nao_avaliado
                from tb_enturmacao ent
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and ent.fl_ativo='true' and al.fl_ativo='true'
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_cidade cid on esc.cd_cidade=cid.ci_cidade
                    inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=au.ci_avaliacao_upload and tac.cd_cidade=cid.ci_cidade ";
        $sql.=" where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_cidade'])){$sql.="  and cid.ci_cidade=".$params['cd_cidade'];}
        if(isset($params['cd_anoletivo'])){$sql.="  and extract( year from tac.dt_final)=".$params['cd_anoletivo'];}else{
            $sql.="  and extract( year from tac.dt_final)= extract(year from now())";
        }
        $sql.=" )res group by nm_cidade,mes,ci_avaliacao_upload,nm_caderno order by upper(nm_caderno),ordem;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function graficoEnturmacaoLeituraMunicipioAno($params){
        
        $sql="		select nm_cidade, ano::integer as ordem,ano,
                        coalesce(sum(leitor_fluente),0) as leitor_fluente,
                        coalesce(sum(leitor_sfluente),0)as leitor_sfluente,
                        coalesce(sum(leitor_frase),0) as leitor_frase,
                        coalesce(sum(leitor_palavra),0) as leitor_palavra,
                        coalesce(sum(leitor_silaba),0) as leitor_silaba,
                        coalesce(sum(nao_leitor),0) as nao_leitor,
                        coalesce(sum(nao_avaliado),0) as nao_avaliado
                from (
            
                select distinct cid.nm_cidade,
                        extract( year from tac.dt_final) as ano,
                        al.*,
                        aa.cd_avaliacao_upload,
                        aa.cd_situacao_aluno,
                        case when aa.nr_alternativa_escolhida=6 then 1 end as leitor_fluente,
                        case when aa.nr_alternativa_escolhida=5 then 1 end as leitor_sfluente,
                        case when aa.nr_alternativa_escolhida=4 then 1 end as leitor_frase,
                        case when aa.nr_alternativa_escolhida=3 then 1 end as leitor_palavra,
                        case when aa.nr_alternativa_escolhida=2 then 1 end as leitor_silaba,
                        case when aa.nr_alternativa_escolhida=1 then 1 end as nao_leitor,
                        case when aa.nr_alternativa_escolhida=0 then 1 end as nao_avaliado
                from tb_enturmacao ent
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and ent.fl_ativo='true'
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_cidade cid on esc.cd_cidade=cid.ci_cidade
                    inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=au.ci_avaliacao_upload and tac.cd_cidade=esc.ci_cidade";
        $sql.=" where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_cidade'])){$sql.="  and cid.ci_cidade=".$params['cd_cidade'];}
        $sql.=" )res group by nm_cidade,ano order by ano desc;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function graficoEnturmacaoLeituraEscolaAno($params){
        
        $sql="select nm_escola, ano::integer as ordem,ano,
                        coalesce(sum(leitor_fluente),0) as leitor_fluente,
                        coalesce(sum(leitor_sfluente),0)as leitor_sfluente,
                        coalesce(sum(leitor_frase),0) as leitor_frase,
                        coalesce(sum(leitor_palavra),0) as leitor_palavra,
                        coalesce(sum(leitor_silaba),0) as leitor_silaba,
                        coalesce(sum(nao_leitor),0) as nao_leitor,
                        coalesce(sum(nao_avaliado),0) as nao_avaliado
                from (
            
                select distinct esc.nm_escola,
                        extract( year from tac.dt_final) as ano,
                        al.*,
                        aa.cd_avaliacao_upload,
                        aa.cd_situacao_aluno,
                        case when aa.nr_alternativa_escolhida=6 then 1 end as leitor_fluente,
                        case when aa.nr_alternativa_escolhida=5 then 1 end as leitor_sfluente,
                        case when aa.nr_alternativa_escolhida=4 then 1 end as leitor_frase,
                        case when aa.nr_alternativa_escolhida=3 then 1 end as leitor_palavra,
                        case when aa.nr_alternativa_escolhida=2 then 1 end as leitor_silaba,
                        case when aa.nr_alternativa_escolhida=1 then 1 end as nao_leitor,
                        case when aa.nr_alternativa_escolhida=0 then 1 end as nao_avaliado
                from tb_enturmacao ent
                    inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and ent.fl_ativo='true'
                    inner join tb_turma t on ent.cd_turma=t.ci_turma
                    inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
                    inner join tb_avaliacaoleitura_aluno aa on al.ci_aluno=aa.cd_aluno and au.ci_avaliacao_upload=aa.cd_avaliacao_upload
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_avaliacao_cidade tac on tac.cd_avaliacao_upload=au.ci_avaliacao_upload and tac.cd_cidade=esc.ci_cidade ";
        $sql.=" where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma']) && !empty($params['cd_turma']) ){
            $sql.=" and ent.cd_turma=".$params['cd_turma'];}
            if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
            //if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
            $sql.=" )res group by nm_escola,ano order by ano desc;";
            
            $query=$this->db->query($sql);
            return $query->result();
            
    }
    
    //     #mudança
    public function buscaItensInseridos($params){
        
        $sql=" select distinct am.*,aa.*  from tb_enturmacao ent
	              inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo='true'
	              inner join tb_turma t on ent.cd_turma=t.ci_turma
	              inner join tb_avaliacao_upload au on t.cd_etapa=au.cd_etapa
	              inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
	              inner join tb_avaliacao_aluno aa on al.ci_aluno=aa.cd_aluno
		              and am.ci_avaliacao_matriz=aa.cd_avaliacao_itens
              where t.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        $sql.=" order by cd_aluno,am.nr_questao, am.fl_ativo desc";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaItens($params){
        
        $sql=" select distinct am.* from tb_avaliacao_upload au
	                  inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
            
              where  au.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        
        $sql.=" order by nr_questao";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function buscaItensLancamento($params){
        
        $sql=" select distinct am.* from tb_avaliacao_upload au
	                  inner join tb_avaliacao_matriz am on au.ci_avaliacao_upload=am.cd_avaliacao_upload
              where au.cd_etapa=".$params['cd_etapa'];
        if(isset($params['cd_disciplina'])){$sql.="  and au.cd_disciplina=".$params['cd_disciplina'];}
        if(isset($params['cd_avaliacao'])){$sql.="   and ci_avaliacao_upload=".$params['cd_avaliacao'];}
        
        $sql.=" order by nr_questao";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function verifica_enturmacao($cd_aluno, $cd_turma){
        $params['cd_aluno']=$cd_aluno;
        $params['cd_turma']=$cd_turma;
        return $this->buscaEnturmacaoAluno($params);
    }
    
    public function buscadadosturma($params){
        $sql=" select * from tb_turma t where 1=1 ";
        if(isset($params['cd_turma'])){$sql.="  and t.ci_turma=".$params['cd_turma'];}
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function relatorioEnturmacaoEscola($params){
        $sql="select esc.ci_escola,esc.nm_escola,t.ci_turma,	                 
                     t.nm_turma, t.nr_ano_letivo, esc.cd_cidade,
	                 tc.cd_estado,
                     count(al.ci_aluno)as enturmacao                
                from tb_ultimaenturmacao tu
                    inner join tb_turma t on tu.cd_turma=t.ci_turma
                    inner join tb_aluno al on tu.cd_aluno=al.ci_aluno
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_cidade tc on esc.cd_cidade=tc.ci_cidade
                where 1=1";
        if(!empty($params['nr_anoletivo'])){
            $sql.=" and t.nr_ano_letivo =".$params['nr_anoletivo'];
        }else{
            $sql.=" and t.nr_ano_letivo =extract(year from now()) ";
        }

        if(isset($params['cd_escola']) ){
            $sql.=" and t.cd_escola=".$params['cd_escola'];
        }
        
        $sql.=" group by esc.ci_escola,esc.nm_escola,t.ci_turma,	                 
                     t.nm_turma, t.nr_ano_letivo, esc.cd_cidade,tc.cd_estado
                order by 2,4,5;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function relatorioEnturmacaoTurma($params){
        $sql="select esc.ci_escola,esc.nm_escola,t.ci_turma,
                     t.nm_turma, t.nr_ano_letivo, 
                     esc.cd_cidade,tc.cd_estado,
                     al.ci_aluno,al.nm_aluno,
                     al.nm_mae,
                     to_char(al.dt_nascimento,'dd/mm/yyyy') as dt_nascimento    
                from tb_ultimaenturmacao tu
                    inner join tb_turma t on tu.cd_turma=t.ci_turma
                    inner join tb_aluno al on tu.cd_aluno=al.ci_aluno
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola
                    inner join tb_cidade tc on esc.cd_cidade=tc.ci_cidade
                where 1=1";
        if(!empty($params['nr_anoletivo'])){
            $sql.=" and t.nr_ano_letivo =".$params['nr_anoletivo'];
        }else{
            $sql.=" and t.nr_ano_letivo =extract(year from now()) ";
        }
        
        if(isset($params['cd_escola']) ){
            $sql.=" and t.cd_escola=".$params['cd_escola'];
        }
        if(isset($params['cd_turma']) ){
            $sql.=" and t.ci_turma=".$params['cd_turma'];
        }
        
        $sql.=" order by 2,4,5,9;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    

    public function relatorioEnturmacao($params){
        $sql="select esc.ci_escola,esc.nm_escola,
	                 al.ci_aluno,al.nm_aluno,to_char(al.dt_nascimento,'dd/mm/yyyy') as dt_nascimento,
                     t.nm_turma, t.nr_ano_letivo, esc.cd_cidade,
                (select count(distinct tu1.cd_aluno) as qdt from tb_ultimaenturmacao tu1 
                    inner join tb_turma t1 on tu1.cd_turma=t1.ci_turma 
                    inner join tb_aluno al1 on tu1.cd_aluno=al1.ci_aluno 
                    inner join tb_escola esc1 on t1.cd_escola=esc1.ci_escola 
                where t1.nr_ano_letivo =extract(year from now()) 
                	and esc1.ci_escola=esc.ci_escola ) enturmacao                      
                from tb_ultimaenturmacao tu 
                    inner join tb_turma t on tu.cd_turma=t.ci_turma 
                    inner join tb_aluno al on tu.cd_aluno=al.ci_aluno 
                    inner join tb_escola esc on t.cd_escola=esc.ci_escola 
                where t.nr_ano_letivo =extract(year from now())-1 ";
        if(isset($params['cd_escola']) ){
            $sql.=" and t.cd_escola=".$params['cd_escola'];
        }
        
        if(isset($params['cd_cidade']) ){
            $sql.=" and esc.cd_cidade=".$params['cd_cidade'];
        }

        $sql.=" and not exists(
                    select 1 from tb_ultimaenturmacao tu1
	                        inner join tb_turma t1 on tu1.cd_turma=t1.ci_turma
                    where tu1.cd_aluno=tu.cd_aluno and  
	                        t1.nr_ano_letivo =extract(year from now()) 
                    )
                    order by 2,4,5;";

        $query=$this->db->query($sql);
        return $query->result();            
    }
    
    public function selectAlunoTurma($cd_turma = null, $cd_aluno = null){
        
        //echo 'aqui'.$cd_turma;die;
        $params['cd_turma']=$cd_turma;
        //$params['cd_aluno']=$cd_aluno;
        $turmas = $this->buscaUltimaEnturmacaoAluno($params);
        
        $options = "<option value=''>Selecione um Aluno </option>";
        
        foreach ($turmas as $turma){
            if ($cd_aluno == $turma->cd_aluno){
                $options .= "<option value='{$turma->cd_aluno}' selected>{$turma->nm_aluno}</option>".PHP_EOL;
            }else{
                $options .= "<option value='{$turma->cd_aluno}'>{$turma->nm_aluno}</option>".PHP_EOL;
            }
            
        }
        return $options;
    }
    
}