<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Modalidades_model extends CI_Model {

    public $ci_modalidade;
    public $nm_modalidade;

    public function __construct(){
        parent::__construct();

    }

    public function buscar($ci_modalidade = null,
                           $nm_modalidade = null)
    {
        $this->db->select(' ci_modalidade,
                            nm_modalidade');
        $this->db->from('tb_modalidade');

        if ($ci_modalidade)
        {
            $this->db->where('ci_modalidade', $ci_modalidade);
        }
        if ($nm_modalidade){
            $this->db->like('LOWER(nm_modalidade)', strtolower($nm_modalidade));
        }

        $this->db->order_by('nm_modalidade', 'ASC');
        return $this->db->get()->result();
    }

    public function excluir($ci_modalidade)
    {
        $this->db->where('ci_modalidade', $ci_modalidade);
        return $this->db->delete('tb_modalidade');
    }

    public function inserir($nm_modalidade)
    {
        $dados['nm_modalidade']     = mb_strtoupper($nm_modalidade, 'UTF-8');

        $this->db->insert('tb_modalidade', $dados);
    }

    public function alterar($ci_modalidade, $nm_modalidade)
    {
        $dados['nm_modalidade']     = mb_strtoupper($nm_modalidade, 'UTF-8');

        $this->db->where('ci_modalidade', $ci_modalidade);
        return $this->db->update('tb_modalidade', $dados);
    }


}