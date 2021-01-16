<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_origem_model extends CI_Model {

    public $ci_aluno;
    public $nm_aluno;

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_avalia_origem = null,
                                 $nm_avalia_origem = null){

        return count($this->buscar( $ci_avalia_origem,
                                    $nm_avalia_origem));

    }

    public function buscar($ci_avalia_origem = null,
                           $nm_avalia_origem = null,
                           $relatorio = null,
                           $limit    = null,
                           $offset   = null){

        $this->db->from('tb_avalia_origem');

        $this->db->where('fl_ativo', 'true');

        if ($ci_avalia_origem)
        {
            $this->db->where('ci_avalia_origem', $ci_avalia_origem);
        }
        if ($nm_avalia_origem){
            $this->db->like('LOWER(nm_avalia_origem)', strtolower($nm_avalia_origem));
        }

        $this->db->order_by('nm_avalia_origem', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }

//        echo $this->db->last_query(); //Exibeo comando SQL
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }

    public function get_consulta_excel( $ci_avalia_origem = null,
                                        $nm_avalia_origem){
        $this->db->select('     ci_avalia_origem as "CODIGO",
                                nm_avalia_origem as "NOME"');
        $this->db->from('tb_avalia_origem');

        $this->db->where('fl_ativo', 'true');
        if ($ci_avalia_origem)
        {
            $this->db->where('ci_avalia_origem', $ci_avalia_origem);
        }
        if ($nm_avalia_origem){
            $this->db->like('LOWER(nm_avalia_origem)', strtolower($nm_avalia_origem));
        }

        $this->db->order_by('nm_avalia_origem', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_avalia_origem)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avalia_origem', $ci_avalia_origem);
        return $this->db->update('tb_avalia_origem', $dados);
    }

    public function inserir($nm_avalia_origem)
    {
        $this->db->where('nm_avalia_origem', mb_strtoupper($nm_avalia_origem, 'UTF-8'));
        $this->db->from('tb_avalia_origem');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_origem']          = mb_strtoupper($nm_avalia_origem, 'UTF-8');
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_origem', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_avalia_origem)
    {
        $this->db->from('tb_avalia_origem');

        $this->db->where('nm_avalia_origem', mb_strtoupper($nm_avalia_origem, 'UTF-8'));
        $this->db->where('ci_avalia_origem <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_origem']          = mb_strtoupper($nm_avalia_origem, 'UTF-8');

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_origem', $id);
            return $this->db->update('tb_avalia_origem', $dados);
//            return true;
        }else{
            return false;
        }

    }


}