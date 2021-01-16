<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_tipo_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    public function buscar_count( $ci_avalia_tipo = null,
                                  $nm_avalia_tipo = null){
        
        return  count($this->buscar($ci_avalia_tipo, $nm_avalia_tipo));
    }
    public function buscar( $ci_avalia_tipo          = null,
                            $nm_avalia_tipo          = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_avalia_tipo.ci_avalia_tipo,
                            tb_avalia_tipo.nm_avalia_tipo');
        
        $this->db->from('tb_avalia_tipo');

        if ($ci_avalia_tipo)
        {
            $this->db->where('tb_avalia_tipo.ci_avalia_tipo', $ci_avalia_tipo);
        }
        if ($nm_avalia_tipo)
        {
            $this->db->where("remove_acentos(tb_avalia_tipo.nm_avalia_tipo) ilike remove_acentos('%".mb_strtoupper($nm_avalia_tipo, 'UTF-8')."%')");
        }
        $this->db->where('tb_avalia_tipo.fl_ativo', 'true');
        $this->db->order_by('tb_avalia_tipo.nm_avalia_tipo', 'ASC');

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

        $this->db->where('ci_avalia_tipo', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_avalia_tipo', $dados);
    }

    public function inserir($nm_avalia_tipo = null){

        $this->db->where("remove_acentos(tb_avalia_tipo.nm_avalia_tipo) ilike remove_acentos('%".mb_strtoupper($nm_avalia_tipo, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_avalia_tipo.nm_avalia_tipo) ilike remove_acentos('%".mb_strtoupper($nm_avalia_tipo, 'UTF-8')."%')
        // or  tb_avalia_tipo.ds_codigo ='$ds_codigo')
        // ");

        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_avalia_tipo', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_tipo']  = $nm_avalia_tipo;
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_tipo', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_avalia_tipo = null,
                            $nm_avalia_tipo = null){

        $this->db->where("remove_acentos(tb_avalia_tipo.nm_avalia_tipo) ilike remove_acentos('%".mb_strtoupper($nm_avalia_tipo, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_avalia_tipo.nm_avalia_tipo) ilike remove_acentos('%".mb_strtoupper($nm_avalia_tipo, 'UTF-8')."%')
        // or  tb_avalia_tipo.ds_codigo ='$ds_codigo')
        // ");
   
        $this->db->where('ci_avalia_tipo <> '.$ci_avalia_tipo);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_avalia_tipo');

        if (!($this->db->get()->num_rows() > 0)){
                
            $dados['nm_avalia_tipo']        = $nm_avalia_tipo;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_tipo', $ci_avalia_tipo);
            return $this->db->update('tb_avalia_tipo', $dados);
        }else{
            return false;
        }

    }

}