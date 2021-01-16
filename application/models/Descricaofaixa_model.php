<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Descricaofaixa_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    public function buscar_count( $ci_etapa = null,
                                  $nm_etapa = null){
        
        return  count($this->buscar($ci_etapa, $nm_etapa));
    }
    public function buscar( $ci_descricaofaixa = null,
                            $ds_descricaofaixa = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_descricaofaixa.ci_descricaofaixa,
                            tb_descricaofaixa.ds_descricaofaixa');
        
        $this->db->from('tb_descricaofaixa');

        if($ci_descricaofaixa)
        {
            $this->db->where('tb_descricaofaixa.ci_descricaofaixa', $ci_descricaofaixa);
        }
        
        $this->db->where('tb_descricaofaixa.fl_ativo', 'true');
        
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
}