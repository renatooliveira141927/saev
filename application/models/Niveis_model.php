<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Niveis_model extends CI_Model {

    public $ci_nivel;
    public $nm_nivel;

    public function __construct(){
        parent::__construct();

    }

    public function buscar($ci_nivel = null,
                           $nm_nivel = null)
    {
        $this->db->select('     	ci_nivel,
                                    nm_nivel');
        $this->db->from('tb_nivel');
        $this->db->where('fl_ativo', true);
        if ($ci_nivel)
        {
            $this->db->where('ci_nivel', $ci_nivel);
        }
        if ($nm_nivel){
            $this->db->like('LOWER(nm_nivel)', strtolower($nm_nivel));
        }

        $this->db->order_by('nm_nivel', 'ASC');
        return $this->db->get()->result();
    }

    public function excluir($ci_nivel)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_nivel', $ci_nivel);
        return $this->db->update('tb_nivel', $dados);
    }

    public function inserir($nm_nivel)
    {
        try {
            $dados['nm_nivel']           = mb_strtoupper($nm_nivel, 'UTF-8');
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_nivel', $dados);
        }

        catch (MySQLException $e) {
            return $e->getMessage();
        }


    }

    public function alterar($ci_nivel, $nm_nivel)
    {

        $dados['dt_alteracao']    = "now()";
        $dados['nm_nivel']        = mb_strtoupper($nm_nivel, 'UTF-8');

        $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');

        $this->db->where('ci_nivel', $ci_nivel);
        return $this->db->update('tb_nivel', $dados);
    }


}