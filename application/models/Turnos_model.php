<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Turnos_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    public function buscar_count( $ci_turno = null,
                                  $nm_turno = null){
        
        return  count($this->buscar($ci_turno, $nm_turno));
    }
    public function buscar( $ci_turno          = null,
                            $nm_turno          = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_turno.ci_turno,
                            tb_turno.nm_turno');
        
        $this->db->from('tb_turno');

        if ($ci_turno)
        {
            $this->db->where('tb_turno.ci_turno', $ci_turno);
        }
        if ($nm_turno)
        {
            $this->db->where("remove_acentos(tb_turno.nm_turno) ilike remove_acentos('%".mb_strtoupper($nm_turno, 'UTF-8')."%')");
        }
        $this->db->where('tb_turno.fl_ativo', 'true');
        $this->db->order_by('tb_turno.nm_turno', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }

        //$this->db->last_query(); //Exibeo comando SQL
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }

    public function excluir($id)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_turno', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_turno', $dados);
    }

    public function inserir($nm_turno = null){

        $this->db->where("remove_acentos(tb_turno.nm_turno) ilike remove_acentos('%".mb_strtoupper($nm_turno, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_turno.nm_turno) ilike remove_acentos('%".mb_strtoupper($nm_turno, 'UTF-8')."%')
        // or  tb_turno.ds_codigo ='$ds_codigo')
        // ");

        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_turno', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_turno']  = $nm_turno;
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_turno', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_turno = null,
                            $nm_turno = null){

        $this->db->where("remove_acentos(tb_turno.nm_turno) ilike remove_acentos('%".mb_strtoupper($nm_turno, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_turno.nm_turno) ilike remove_acentos('%".mb_strtoupper($nm_turno, 'UTF-8')."%')
        // or  tb_turno.ds_codigo ='$ds_codigo')
        // ");
   
        $this->db->where('ci_turno <> '.$ci_turno);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_turno');

        if (!($this->db->get()->num_rows() > 0)){
                
            $dados['nm_turno']        = $nm_turno;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_turno', $ci_turno);
            return $this->db->update('tb_turno', $dados);
        }else{
            return false;
        }

    }

}