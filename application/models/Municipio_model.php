<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Municipio_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	public function get_municipios($estado = null){

		$this->db->select('
			ci_cidade,
			nm_cidade');
		$this->db->from('tb_cidade');
        $this->db->where('cd_estado=', $estado);
		$this->db->order_by('nm_cidade','ASC');

		return $this->db->get()->result();
	}


	public function get_cidades($estado = null){

		$this->db->select('
			ci_cidade,
			nm_cidade');
		$this->db->from('tb_cidade');
        $this->db->where('cd_estado=', $estado);
		$this->db->order_by('nm_cidade','ASC');

		return $this->db->get()->result();
	}

	public function selectCidades($id_estado = null, $id_cidade = null){
	    $options = "<option value=''>Selecione o estado</option>";
	    $cidades = $this->get_cidades($id_estado);

	    foreach ($cidades as $cidade){
			if (($cidade->ci_cidade == $id_cidade)){				
				$options .= "<option value='{$cidade->ci_cidade}' selected>".trim($cidade->nm_cidade)."</option>".PHP_EOL;
			}else{
				$options .= "<option value='{$cidade->ci_cidade}'>".trim($cidade->nm_cidade)."</option>".PHP_EOL;
			}
            
        }
        return $options;
    }
}
