<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Edicao_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    public function buscar_count( $ci_edicao = null,
                                  $nm_edicao = null){
        
        return  count($this->buscar($ci_edicao, $nm_edicao));
    }
    public function buscar( $ci_edicao          = null,
                            $nm_edicao          = null,
                            $relatorio          = null,                            
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_edicao.ci_edicao,
                            tb_edicao.nm_edicao');
        
        $this->db->from('tb_edicao');

        if ($ci_edicao)
        {
            $this->db->where('tb_edicao.ci_edicao', $ci_edicao);
        }
        if ($nm_edicao)
        {
            $this->db->where("remove_acentos(tb_edicao.nm_edicao) ilike remove_acentos('%".mb_strtoupper($nm_edicao, 'UTF-8')."%')");
        }
        $this->db->where('tb_edicao.fl_ativo', 'true');
        $this->db->order_by('tb_edicao.nm_edicao', 'ASC');

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

        $this->db->where('ci_edicao', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_edicao', $dados);
    }

    public function inserir($nm_edicao = null){

        $this->db->where("remove_acentos(tb_edicao.nm_edicao) ilike remove_acentos('%".mb_strtoupper($nm_edicao, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_edicao.nm_edicao) ilike remove_acentos('%".mb_strtoupper($nm_edicao, 'UTF-8')."%')
        // or  tb_edicao.ds_codigo ='$ds_codigo')
        // ");

        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_edicao', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_edicao']  = $nm_edicao;
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_edicao', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_edicao = null,
                            $nm_edicao = null){

        $this->db->where("remove_acentos(tb_edicao.nm_edicao) ilike remove_acentos('%".mb_strtoupper($nm_edicao, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_edicao.nm_edicao) ilike remove_acentos('%".mb_strtoupper($nm_edicao, 'UTF-8')."%')
        // or  tb_edicao.ds_codigo ='$ds_codigo')
        // ");
   
        $this->db->where('ci_edicao <> '.$ci_edicao);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_edicao');

        if (!($this->db->get()->num_rows() > 0)){
                
            $dados['nm_edicao']        = $nm_edicao;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_edicao', $ci_edicao);
            return $this->db->update('tb_edicao', $dados);
        }else{
            return false;
        }

    }
    
    public function selectEdicoes($ci_edicao=null){
        
        $edicoes = $this->buscar();
        $options = "";
        
        if (count($edicoes) >= 1){
            $options = "<option value=''>Selecione uma Edição </option>";
        }
        foreach ($edicoes as $edicao){
            if($edicao->ci_edicao==$ci_edicao){
                $options .= "<option value='".$edicao->ci_edicao."' selected>".$edicao->nm_edicao."</option>".PHP_EOL;
            }else{
                $options .= "<option value='".$edicao->ci_edicao."'>".$edicao->nm_edicao."</option>".PHP_EOL;
            }
            
        }
        return $options;
    }

}