<?php 

class Metasaprendizagem_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();        
    }
    
    public function buscametaaprendizagem($parametro=null){        
        $sql="select MA.*, te.*,tc.*,tes.*,ds.ci_disciplina,
                case when ma.cd_disciplina = 99 then 'LEITURA'
		              else ds.nm_disciplina
	               end as nm_DISCIPLINA 
            from tb_metas_aprendizagem ma 
                 inner join tb_etapa te on ma.cd_etapa=te.ci_etapa 
                 inner join tb_cidade tc on ma.cd_municipio=tc.ci_cidade 
                 inner join tb_estado tes on tc.cd_estado=tes.ci_estado
                 left join tb_disciplina ds on ma.cd_disciplina=ds.ci_disciplina 
                 left join tb_escola esc on ma.cd_escola=esc.ci_escola 
            where 1=1 ";
        if(isset($parametro['id']) && !empty($parametro['id'])){
            $sql.=" and ma.ci_metas_aprendeizagem=".$parametro['id'];
        }
        if(isset($parametro['cd_cidade']) && !empty($parametro['cd_cidade'])){
            $sql.=" and ma.cd_municipio=".$parametro['cd_cidade'];
        }
        if(isset($parametro['cd_estado']) && !empty($parametro['cd_estado'])){
            $sql.=" and tes.ci_estado=".$parametro['cd_estado'];
        }
        if(isset($parametro['cd_etapa']) && !empty($parametro['cd_etapa'])){
            $sql.=" and cd_etapa=".$parametro['cd_etapa'];
        }
        if(isset($parametro['cd_escola']) && !empty($parametro['cd_escola'])){
            $sql.=" and cd_escola=".$parametro['cd_escola'];
        }
        if(isset($parametro['nr_anoletivo']) && !empty($parametro['nr_anoletivo'])){
            $sql.=" and nr_anoletivo=".$parametro['nr_anoletivo'];
        }
        if(isset($parametro['cd_disciplina']) && !empty($parametro['cd_disciplina'])){
            $sql.=" and ma.cd_disciplina=".$parametro['cd_disciplina'];
        }
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function salvar($params){
        //print_r($params);die;
        $this->db->insert('tb_metas_aprendizagem', $params);
        return true;
    }
    
    public function alterar($params){        
        $this->db->where('ci_metas_aprendeizagem', $params['ci_metas_aprendeizagem']);
        return $this->db->update('tb_metas_aprendizagem', $params);
    }
    
    public function excluir($ci_turma)
    {   
        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";
        
        $this->db->where('ci_turma', $ci_turma);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_metas_aprendizagem', $dados);
    }
    
}