<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_subconteudo_model extends CI_Model {

    public $ci_aluno;
    public $nm_aluno;

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_avalia_subconteudo = null,
                                 $nm_avalia_subconteudo = null,
                                 $cd_avalia_conteudo = null){

        return count($this->buscar( $ci_avalia_subconteudo,
                                    $nm_avalia_subconteudo,
                                    $cd_avalia_conteudo));

    }

    public function buscar($ci_avalia_subconteudo  = null,
                           $nm_avalia_subconteudo  = null,
                           $cd_avalia_conteudo       = null,
                           $relatorio           = null,
                           $limit               = null,
                           $offset              = null){

                            $this->db->select(' tb_avalia_subconteudo.ci_avalia_subconteudo",
                                                tb_avalia_subconteudo.nm_avalia_subconteudo",
                                                tb_avalia_subconteudo.cd_avalia_conteudo",
                                                tb_avalia_conteudo.nm_avalia_conteudo');


        $this->db->from('tb_avalia_subconteudo');
       
        $this->db->join('tb_avalia_conteudo', 'tb_avalia_subconteudo.cd_avalia_conteudo = tb_avalia_conteudo.ci_avalia_conteudo');
       
        $this->db->where('tb_avalia_subconteudo.fl_ativo', 'true');

        if ($ci_avalia_subconteudo)
        {
            $this->db->where('tb_avalia_subconteudo.ci_avalia_subconteudo', $ci_avalia_subconteudo);
        }
        if ($nm_avalia_subconteudo){
            $this->db->like('LOWER("educarpravaler"."tb_avalia_subconteudo"."nm_avalia_subconteudo")', strtolower($nm_avalia_subconteudo));
        }
        if ($cd_avalia_conteudo){
            $this->db->where('tb_avalia_subconteudo.cd_avalia_conteudo', $cd_avalia_conteudo);
        }
        $this->db->order_by('tb_avalia_conteudo.nm_avalia_conteudo', 'ASC');
        $this->db->order_by('tb_avalia_subconteudo.nm_avalia_subconteudo', 'ASC');

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

    public function get_consulta_excel( $ci_avalia_subconteudo = null,
                                        $nm_avalia_subconteudo = null, 
                                        $cd_avalia_conteudo = null){
        $this->db->select(' tb_avalia_subconteudo.ci_avalia_subconteudo as "CODIGO",
                            tb_avalia_subconteudo.nm_avalia_subconteudo as "CONTEUDO",
                            tb_avalia_conteudo.nm_avalia_conteudo as "DISCIPLINA"'
                        );

        $this->db->from('tb_avalia_subconteudo');
        $this->db->join('tb_avalia_conteudo', 'tb_avalia_subconteudo.cd_avalia_conteudo = tb_avalia_conteudo.ci_avalia_conteudo');

        $this->db->where('tb_avalia_subconteudo.fl_ativo', 'true');
        if ($ci_avalia_subconteudo)
        {
            $this->db->where('tb_avalia_subconteudo.ci_avalia_subconteudo', $ci_avalia_subconteudo);
        }
        if ($nm_avalia_subconteudo){
            $this->db->like('LOWER("educarpravaler"."tb_avalia_subconteudo"."nm_avalia_subconteudo")', strtolower($nm_avalia_subconteudo));
        }
        if ($cd_avalia_conteudo){
            $this->db->where('tb_avalia_subconteudo.cd_avalia_conteudo', $cd_avalia_conteudo);
        }

        $this->db->order_by('tb_avalia_conteudo.nm_avalia_conteudo', 'ASC');
        $this->db->order_by('tb_avalia_subconteudo.nm_avalia_subconteudo', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_avalia_subconteudo)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avalia_subconteudo', $ci_avalia_subconteudo);
        return $this->db->update('tb_avalia_subconteudo', $dados);
    }

    public function inserir($nm_avalia_subconteudo, $cd_avalia_conteudo)
    {
        $this->db->where('nm_avalia_subconteudo', mb_strtoupper($nm_avalia_subconteudo, 'UTF-8'));
        $this->db->from('tb_avalia_subconteudo');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_subconteudo'] = mb_strtoupper($nm_avalia_subconteudo, 'UTF-8');
            $dados['cd_avalia_conteudo']      = $cd_avalia_conteudo;
            
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_subconteudo', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_avalia_subconteudo, $cd_avalia_conteudo)
    {
        $this->db->from('tb_avalia_subconteudo');

        $this->db->where('nm_avalia_subconteudo', mb_strtoupper($nm_avalia_subconteudo, 'UTF-8'));
        $this->db->where('cd_avalia_conteudo', $cd_avalia_conteudo);
        
        $this->db->where('ci_avalia_subconteudo <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_subconteudo']     = mb_strtoupper($nm_avalia_subconteudo, 'UTF-8');
            $dados['cd_avalia_conteudo']          = $cd_avalia_conteudo;
            

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_subconteudo', $id);
            return $this->db->update('tb_avalia_subconteudo', $dados);
//            return true;
        }else{
            return false;
        }

    }


}