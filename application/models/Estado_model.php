<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	public function get_estados($id_estado=null){

		$this->db->select('
			ci_estado,
			nm_uf,
			nm_estado');
		$this->db->from('tb_estado');
		//if($id_estado!=null){ $this->db->where('ci_estado=', $id_estado);}
			$this->db->order_by('nm_estado','ASC');

		return $this->db->get()->result();
	}

	public function selectEstados($id_estado = null, $sg_estado = null){
	    $options = "<option value=''>Selecione o estado</option>";
	    $estados = $this->get_estados($id_estado);

	    foreach ($estados as $estado){
			if ((strtolower(trim($estado->nm_uf)) == strtolower(trim($sg_estado))) || ($estado->ci_estado == $id_estado)){				
				$options .= "<option value='{$estado->ci_estado}' selected>".trim($estado->nm_estado)."</option>".PHP_EOL;
			}else{
				$options .= "<option value='{$estado->ci_estado}'>".trim($estado->nm_estado)."</option>".PHP_EOL;
			}
            
        }
        return $options;
    }
}
