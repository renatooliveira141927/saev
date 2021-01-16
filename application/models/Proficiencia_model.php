<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Proficiencia_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    
    public function select(){
        $this->db->order_by('ci_faixa_proficiencia', 'DESC');
        $query = $this->db->get('tb_faixa_proficiencia');
        return $query;
    }
    
    public function busca($parametro){
        //print_r($parametro);die;
        
        $sql="select p.*, te.*, df.*
            from tb_faixa_proficiencia p
                 inner join tb_etapa te on p.cd_etapa=te.ci_etapa 
                 inner join tb_descricaofaixa df on p.cd_descricaofaixa=df.ci_descricaofaixa                   
            where 1=1 ";
        if(isset($parametro['id']) && !empty($parametro['id'])){
            $sql.=" and p.ci_faixa_proficiencia=".$parametro['id'];
        }
        
        if(isset($parametro['cd_descricaofaixa']) && !empty($parametro['cd_descricaofaixa'])){
            $sql.=" and p.cd_descricaofaixa=".$parametro['cd_descricaofaixa'];
        }
        
        if(isset($parametro['cd_etapa']) && !empty($parametro['cd_etapa'])){
            $sql.=" and cd_etapa=".$parametro['cd_etapa'];
        }
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function salvar($params){
        //print_r($params);die;
        $this->db->insert('tb_faixa_proficiencia', $params);
        return true;
    }
    
    public function alterar($params){
        $this->db->where('ci_faixa_proficiencia', $params['ci_faixa_proficiencia']);
        return $this->db->update('tb_faixa_proficiencia', $params);
    }
    
    public function excluir($id)
    {
        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";
        
        $this->db->where('ci_faixa_proficiencia', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_faixa_proficiencia', $dados);
    }
}