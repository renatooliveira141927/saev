<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidade_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

	public function get_CidadeByEstado($id_estado = null, $sg_estado = null){

		$this->db->select('
			tb_cidade.ci_cidade,
			tb_cidade.nm_cidade');
		$this->db->from('tb_cidade');
		$this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');
		
		if ($id_estado)
        {
            $this->db->where('tb_cidade.cd_estado',$id_estado);
        }else{
            $this->db->where('tb_cidade.cd_estado',0);
        }
		if ($sg_estado)
        {
            $this->db->where('tb_estado.nm_uf', $sg_estado);
        }
		$this->db->order_by('nm_cidade','ASC');

		return $this->db->get()->result();
	}

    public function selectCidade($id_estado = null, $nm_cidade = null, $sg_estado = null, $exibir_cabecario = null, $cd_cidade = null){

        $cidades = $this->get_CidadeByEstado($id_estado, $sg_estado);
		
		$options = '';
		//if ($exibir_cabecario == 'true'|| Empty($cidades)){
			$options = "<option value=''>Selecione a Cidade </option>";
		//}
        
        foreach ($cidades as $cidade){			
			if ((strtolower(trim($cidade->nm_cidade)) == strtolower(trim($nm_cidade))) || ($cidade->ci_cidade == $cd_cidade) ){
				$options .= "<option value='{$cidade->ci_cidade}' selected>".trim($cidade->nm_cidade)."</option>".PHP_EOL;
			}else{
				$options .= "<option value='{$cidade->ci_cidade}'>".trim($cidade->nm_cidade)."</option>".PHP_EOL;
			}

        }
        return $options;
    }
}
