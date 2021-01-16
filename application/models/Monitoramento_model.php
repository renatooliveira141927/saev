<?php 

class Monitoramento_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();       
    }
    
    public function enturmacao_geral($parametro=null){        
        $sql="select cm.ci_estado,nm_uf,tc.ci_cidade,nm_cidade,
                	   sum(enturmacao)+sum(desenturmados) as total,
                	   sum(enturmacao) as enturmacao, 
                	   sum(desenturmados) as desenturmacao,
                	   (sum(enturmacao)*100)::numeric/(sum(enturmacao)::numeric+sum(desenturmados)::numeric) as perc
                from tb_compilaenturmacao_municipio cm
                 inner join tb_cidade tc on cm.ci_cidade=tc.ci_cidade 
                 inner join tb_estado te on cm.ci_estado=te.ci_estado";
        if($parametro!=null){
                if(isset($parametro['nr_anoletivo']) && !empty(isset($parametro['nr_anoletivo']))){
                    $sql.=' where nr_anoletivo='.$parametro['nr_anoletivo'];
                }else{
                    $sql.=' where nr_anoletivo=extract(year from now())';
                }
                if(isset($parametro['cd_estado']) && !empty(isset($parametro['cd_estado']))){
                    $sql.=' and te.ci_estado='.$parametro['cd_estado'];
                }
                if(isset($parametro['cd_cidade']) && !empty(isset($parametro['cd_cidade']))){
                    $sql.=' and tc.ci_cidade='.$parametro['cd_cidade'];
                }
                
        }
         $sql.="       group by cm.ci_estado,nm_uf,tc.ci_cidade,nm_cidade
                order by 1,3; ";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function enturmacao_municipio($parametro=null){
        $sql="select * from tb_compilaenturmacao_municipio where 1=1";
        
        if(isset($parametro['cd_estado']) && $parametro['cd_estado']!=null){
            $sql.=" and ci_estado=".$parametro['cd_estado'];
        }
        
        if(isset($parametro['cd_municipio']) && $parametro['cd_municipio']!=null){
            $sql.=" and ci_cidade=".$parametro['cd_municipio'];
        }
        
        if($parametro!=null && isset($parametro['nr_anoletivo']) && !empty(isset($parametro['nr_anoletivo']))){
            $sql.=' and nr_anoletivo='.$parametro['nr_anoletivo'];
        }else{
            $sql.=' and nr_anoletivo=extract(year from now())';
        }
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function enturmacao_escola($parametro=null){
        $sql="select * from tb_compilaenturmacao_municipio where 1=1";
        
        if(isset($parametro['cd_estado']) && $parametro['cd_estado']!=null){
            $sql.=" and ci_estado=".$parametro['cd_estado'];
        }
        
        if(isset($parametro['cd_municipio']) && $parametro['cd_municipio']!=null){
            $sql.=" and ci_cidade=".$parametro['cd_municipio'];
        }
        
        if($parametro!=null && isset($parametro['nr_anoletivo']) && !empty(isset($parametro['nr_anoletivo']))){
            $sql.=' and nr_anoletivo='.$parametro['nr_anoletivo'];
        }else{
            $sql.=' and nr_anoletivo=extract(year from now())';
        }
        $query=$this->db->query($sql);
        return $query->result();
    }
    
}