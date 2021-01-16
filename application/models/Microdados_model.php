<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Microdados_model extends CI_Model {

    public function __construct(){
        parent::__construct();        
    }
    
    public function select(){
        $this->db->order_by('ci_microdados', 'DESC');
        $query = $this->db->get('tb_microdados');
        return $query;
    }
    
    public function insert($data){
        $this->db->insert_batch('tb_microdados', $data);
    }
    
    public function relatorio($params){
        //print_r($params);die;
        if(isset($params['cd_disciplina'])){
            //print_r($params['cd_disciplina']=="2"?"Sim":"Não");die;
            if($params['cd_disciplina']=="2"){
                $sql="select * from tb_microdados_portugues where nu_ano=".$params['ano'];
            }else{
                $sql="select * from tb_microdados_matematica where nu_ano=".$params['ano'];
            }
        }
        if(isset($params['limit'])){
            $sql.=" limit ".$params['limit']; 
        }
        if(isset($params['offset'])){
            $sql.=" offset ".$params['offset'];
        }
        //echo $sql;die;
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function totalregistros($params){
        //print_r($params);die;
        if(isset($params['cd_disciplina'])){
            //print_r($params['cd_disciplina']=="2"?"Sim":"Não");die;
            if($params['cd_disciplina']=="2"){
                $sql="select count(*) as total from tb_microdados_portugues where nu_ano=".$params['ano'];
            }else{
                $sql="select count(*) as total from tb_microdados_matematica where nu_ano=".$params['ano'];
            }
        }
        //echo $sql;die;
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function identificar($params){
        //print_r($params);die;
        if(isset($params['cd_disciplina'])){
            //print_r($params['cd_disciplina']=="2"?"Sim":"Não");die;
            if($params['cd_disciplina']=="2"){
                $sql="select * from tb_microdados_portugues where cd_alunosaev is null and nu_ano=".$params['ano'];
            }else{
                $sql="select * from tb_microdados_matematica where cd_alunosaev is null and nu_ano=".$params['ano'];
            }
        }
        if(isset($params['limit'])){
            $sql.="order by 6 asc limit ".$params['limit'];
        }
        if(isset($params['offset'])){
            $sql.=" offset ".$params['offset'];
        }
        //echo $sql;die;
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function salvar($cd_disciplina,$gabarito){
        //print_r($gabarito);die;
        
        if($cd_disciplina==2){
            $tabela="tb_microdados_portugues";
        }else{
            $tabela="tb_microdados_matematica";
        }
        
        foreach ($gabarito as $key => $value) {            
            $this->db->where('ci_microdados',$value->ci_microdados);
            $retorno+=$this->db->update($tabela,$value);
        } 
        //($retorno>1)?print_r($retorno):print_r('erro'); die;
        
        if($retorno>=1){ 
            return true;
        }else{ 
            return false;
        }
        
    }
}