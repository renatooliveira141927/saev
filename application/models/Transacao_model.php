<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Transacao_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_transacao = null,
                                 $nm_transacao = null){

        return count($this->buscar( $ci_transacao,
                                    $nm_transacao));

    }

    public function buscar($ci_transacao = null,
                           $nm_transacao = null,
                           $relatorio = null,
                           $limit    = null,
                           $offset   = null){

        $this->db->from('tb_transacao');

        $this->db->where('fl_ativo', 'true');

        if ($ci_transacao)
        {
            $this->db->where('ci_transacao', $ci_transacao);
        }
        if ($nm_transacao){
            $this->db->like('LOWER(nm_transacao)', strtolower($nm_transacao));
        }

        $this->db->order_by('nm_transacao', 'ASC');

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

    public function get_consulta_excel( $ci_transacao = null,
                                        $nm_transacao){
        $this->db->select('     ci_transacao as "CODIGO",
                                nm_transacao as "NOME"');
        $this->db->from('tb_transacao');

        $this->db->where('fl_ativo', 'true');
        if ($ci_transacao)
        {
            $this->db->where('ci_transacao', $ci_transacao);
        }
        if ($nm_transacao){
            $this->db->like('LOWER(nm_transacao)', strtolower($nm_transacao));
        }

        $this->db->order_by('nm_transacao', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_transacao)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_transacao', $ci_transacao);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_transacao', $dados);
    }

    public function inserir($nm_transacao)
    {
        $this->db->from('tb_transacao');
        $this->db->where('nm_transacao', mb_strtoupper($nm_transacao, 'UTF-8'));
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_transacao']       = mb_strtoupper($nm_transacao, 'UTF-8');
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_transacao', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_transacao)
    {
        $this->db->from('tb_transacao');

        $this->db->where('nm_transacao', mb_strtoupper($nm_transacao, 'UTF-8'));
        $this->db->where('ci_transacao <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_transacao']          = mb_strtoupper($nm_transacao, 'UTF-8');

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_transacao', $id);
            return $this->db->update('tb_transacao', $dados);
//            return true;
        }else{
            return false;
        }

    }


}