<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacoes_model extends CI_Model {

	public function __construct(){
		parent::__construct();

	}

    public function login($usuario, $senha){

        $this->db->select('
			ci_usuario,
			nm_usuario,
			img,
			nm_login,
			fl_sexo,
			cd_grupo, 
			cd_cidade_sme,
			cd_estado_sme, 
			tb_cidade.nm_cidade,
			tb_estado.nm_estado,
			tb_estado.nm_uf');
		$this->db->from('tb_usuario');
		$this->db->join('tb_cidade', 'tb_usuario.cd_cidade_sme = tb_cidade.ci_cidade','left');
		$this->db->join('tb_estado', 'tb_usuario.cd_estado_sme = tb_estado.ci_estado','left');

		$this->db->where("fl_ativo = true");   
        $this->db->where('UPPER(nm_login) = UPPER(\''.$usuario.'\')');
        $this->db->where('ds_senha', md5($senha));

        return $this->db->get()->result();
	}
	
    public function listar_grupo_usuario($id){

		$this->db->select('
			gr.ci_grupousuario,
			gr.nm_grupo,
			gr.tp_administrador,
			e.ci_escola,
			e.nr_inep,
			e.nm_escola,
			est.nm_estado,
			est.nm_uf,
			cid.nm_cidade');
		$this->db->from('"tb_usuario"		as u
				join "tb_grupo" 				as gr  on (u.cd_grupo 	= gr.ci_grupousuario)
				left join "tb_usuarioescolas"  as ue  on (u.ci_usuario 	= ue.cd_usuario)
				left join "tb_escola" 		as e   on (ue.cd_escola 	= e.ci_escola)
				left join "tb_cidade" 		as cid on (e.cd_cidade 		= cid.ci_cidade)
				left join "tb_estado" 		as est on (cid.cd_estado 	= est.ci_estado)	
		');

		$this->db->where('u.ci_usuario'		, $id);
		$this->db->where("u.fl_ativo = true");
        $this->db->order_by('cid.nm_cidade'	, 'ASC');
        $this->db->order_by('e.nm_escola'	, 'ASC');

		return $this->db->get()->result();
	}
	public function listar_grupo_transacoes_usuario($id){

		$this->db->where('tb_grupotransacao.cd_grupo'	, $id);
		$this->db->where("tb_transacao.fl_ativo = true");
		$this->db->from('tb_grupotransacao');
		$this->db->join('tb_transacao','tb_grupotransacao.cd_transacao = tb_transacao.ci_transacao');
		
        
        return $this->db->get()->result();
	}
	public function getId($nr_cpf){

		$this->db->where('nr_cpf', $nr_cpf);
		$this->db->where("fl_ativo = true");   
		$this->db->from('tb_usuario');
        
        return $this->db->get()->result();
	}
	public function cadastrarsenha($ci_usuario, $ds_senha){
		$dados['ds_senha']   = md5($ds_senha);
        $this->db->where('MD5(\'A_\' || ci_usuario) =\''.$ci_usuario.'\'');
		return $this->db->update('tb_usuario', $dados);
	}
	public function alterarsenha($ci_usuario, $ds_senha){
		$dados['ds_senha']   = md5($ds_senha);
		$this->db->where('MD5(\'A_\' || ci_usuario) =\''.$ci_usuario.'\'');
		$this->db->where("fl_ativo = true");   
		return $this->db->update('tb_usuario', $dados);
	}
}
