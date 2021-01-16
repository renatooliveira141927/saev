<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_dificuldade_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_avalia_dificuldade = null,
                                 $nm_avalia_dificuldade = null){

        return count($this->buscar( $ci_avalia_dificuldade,
                                    $nm_avalia_dificuldade));

    }

    public function buscar($ci_avalia_dificuldade = null,
                           $nm_avalia_dificuldade = null,
                           $relatorio = null,
                           $limit    = null,
                           $offset   = null){

        $this->db->from('tb_avalia_dificuldade');

        $this->db->where('fl_ativo', 'true');

        if ($ci_avalia_dificuldade)
        {
            $this->db->where('ci_avalia_dificuldade', $ci_avalia_dificuldade);
        }
        if ($nm_avalia_dificuldade){
            $this->db->like('LOWER(nm_avalia_dificuldade)', strtolower($nm_avalia_dificuldade));
        }

        $this->db->order_by('nm_avalia_dificuldade', 'ASC');

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

    public function get_consulta_excel( $ci_avalia_dificuldade = null,
                                        $nm_avalia_dificuldade){
        $this->db->select('     ci_avalia_dificuldade as "CODIGO",
                                nm_avalia_dificuldade as "NOME"');
        $this->db->from('tb_avalia_dificuldade');

        $this->db->where('fl_ativo', 'true');
        if ($ci_avalia_dificuldade)
        {
            $this->db->where('ci_avalia_dificuldade', $ci_avalia_dificuldade);
        }
        if ($nm_avalia_dificuldade){
            $this->db->like('LOWER(nm_avalia_dificuldade)', strtolower($nm_avalia_dificuldade));
        }

        $this->db->order_by('nm_avalia_dificuldade', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_avalia_dificuldade)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avalia_dificuldade', $ci_avalia_dificuldade);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_avalia_dificuldade', $dados);
    }

    public function inserir($nm_avalia_dificuldade)
    {
        $this->db->from('tb_avalia_dificuldade');
        $this->db->where('nm_avalia_dificuldade', mb_strtoupper($nm_avalia_dificuldade, 'UTF-8'));
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_dificuldade']          = mb_strtoupper($nm_avalia_dificuldade, 'UTF-8');
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_dificuldade', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_avalia_dificuldade)
    {
        $this->db->from('tb_avalia_dificuldade');

        $this->db->where('nm_avalia_dificuldade', mb_strtoupper($nm_avalia_dificuldade, 'UTF-8'));
        $this->db->where('ci_avalia_dificuldade <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_dificuldade']          = mb_strtoupper($nm_avalia_dificuldade, 'UTF-8');

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_dificuldade', $id);
            return $this->db->update('tb_avalia_dificuldade', $dados);
//            return true;
        }else{
            return false;
        }

    }


}