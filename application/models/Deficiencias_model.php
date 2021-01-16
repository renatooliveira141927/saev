<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deficiencias_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}
	
	public function count_buscar($ci_tipodeficiencia = null,
	    $ds_tipodeficiencia = null){
	        
	        return count($this->buscar( $ci_tipodeficiencia,
	            $ds_tipodeficiencia));
	        
	}
	
	public function buscar($ci_tipodeficiencia = null,
	    $ds_tipodeficiencia = null,
	    $relatorio = null,
	    $limit    = null,
	    $offset   = null){
	        
	        $this->db->from('tb_tipodeficiencia');
	        
	        $this->db->where('fl_ativo', 'true');
	        
	        if ($ci_tipodeficiencia)
	        {
	            $this->db->where('ci_tipodeficiencia', $ci_tipodeficiencia);
	        }
	        if ($ds_tipodeficiencia){
	            $this->db->like('LOWER(ds_tipodeficiencia)', strtolower($ds_tipodeficiencia));
	        }
	        
	        $this->db->order_by('ds_tipodeficiencia', 'ASC');
	        
	        if ($limit && $offset) {
	            $this->db->limit($limit, $offset);
	        }elseif ($limit && !$offset){
	            $this->db->limit($limit);
	        }
	        
	        //echo $this->db->last_query(); //Exibeo comando SQL
	        if ($relatorio){
	            return $this->db->get();
	        }else{
	            return $this->db->get()->result();
	        }
	}
	
	
	public function get_deficiencias(){
	    $this->db->select('tb_tipodeficiencia.ci_tipodeficiencia,
                           tb_tipodeficiencia.ds_tipodeficiencia');
	    $this->db->from('tb_tipodeficiencia');
	    $this->db->where('tb_tipodeficiencia.fl_ativo',true);	      
	    return $this->db->get()->result();
	}
	public function selectDeficiencia($id = null){
	    $options = "<option value=''>Selecione uma Deficiência</option>";
	    $deficiencias = $this->get_deficiencias();
	    
	    foreach ($deficiencias as $deficiencia){
	        if ( $deficiencia->ci_tipodeficiencia == $id ){
	           $options .= "<option value='{$deficiencia->ci_tipodeficiencia}' selected>".trim($deficiencia->ds_tipodeficiencia)."</option>".PHP_EOL;
           }else{
	               $options .= "<option value='{$deficiencia->ci_tipodeficiencia}'>".trim($deficiencia->ds_tipodeficiencia)."</option>".PHP_EOL;	       
           }
	        
	    }
	    return $options;
	}
	public function selectDeficiencias(){
	    $options = "<option value=''>Selecione uma Deficiência</option>";
	    $deficiencias = $this->get_deficiencias();
	    
	    foreach ($deficiencias as $deficiencia){
// 	        if ((strtolower(trim($estado->nm_uf)) == strtolower(trim($sg_estado))) || ($estado->ci_estado == $id_estado)){
// 	            $options .= "<option value='{$estado->ci_tipodeficiencia}' selected>".trim($estado->ds_tipodeficiencia)."</option>".PHP_EOL;
// 	        }else{
	            $options .= "<option value='{$deficiencia->ci_tipodeficiencia}'>".trim($deficiencia->ds_tipodeficiencia)."</option>".PHP_EOL;
// 	        }
	        
	    }
	    return $options;
	}
	
	public function inserir($ds_tipodeficiencia)
	{
	    $this->db->from('tb_tipodeficiencia');
	    $this->db->where('ds_tipodeficiencia', mb_strtoupper($ds_tipodeficiencia, 'UTF-8'));
	    $this->db->where('fl_ativo', 'true');
	    
	    if (!($this->db->get()->num_rows() > 0)){
	        
	        $dados['ds_tipodeficiencia'] = mb_strtoupper($ds_tipodeficiencia, 'UTF-8');
	        $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
	        $this->db->insert('tb_tipodeficiencia', $dados);
	        return true;
	    }else{
	        return false;
	    }
	    
	}
	
	public function alterar($id, $ds_tipodeficiencia)
	{
	    $this->db->from('tb_tipodeficiencia');
	    
	    $this->db->where('ds_tipodeficiencia', mb_strtoupper($ds_tipodeficiencia, 'UTF-8'));
	    $this->db->where('ci_tipodeficiencia <>', $id);
	    $this->db->where('fl_ativo', 'true');
	    
	    if (!($this->db->get()->num_rows() > 0)){
	        
	        $dados['ds_tipodeficiencia']  = mb_strtoupper($ds_tipodeficiencia, 'UTF-8');
	        
	        $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
	        $dados['dt_alteracao']    = "now()";
	        
	        $this->db->where('ci_tipodeficiencia', $id);
	        return $this->db->update('tb_tipodeficiencia', $dados);
	        //            return true;
	    }else{
	        return false;
	    }
	}
}