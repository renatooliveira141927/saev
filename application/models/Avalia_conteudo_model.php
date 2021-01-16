<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avalia_conteudo_model extends CI_Model {

    public $ci_aluno;
    public $nm_aluno;

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_avalia_conteudo = null,
                                 $nm_avalia_conteudo = null,
                                 $cd_disciplina = null){

        return count($this->buscar( $ci_avalia_conteudo,
                                    $nm_avalia_conteudo,
                                    $cd_disciplina));

    }

    public function buscar($ci_avalia_conteudo  = null,
                           $nm_avalia_conteudo  = null,
                           $cd_disciplina       = null,
                           $relatorio           = null,
                           $limit               = null,
                           $offset              = null){

                            $this->db->select(' tb_avalia_conteudo.ci_avalia_conteudo",
                                                tb_avalia_conteudo.nm_avalia_conteudo",
                                                tb_avalia_conteudo.cd_disciplina",
                                                tb_disciplina.nm_disciplina');


        $this->db->from('tb_avalia_conteudo');
       
        $this->db->join('tb_disciplina', 'tb_avalia_conteudo.cd_disciplina = tb_disciplina.ci_disciplina');
       
        $this->db->where('tb_avalia_conteudo.fl_ativo', 'true');

        if ($ci_avalia_conteudo)
        {
            $this->db->where('tb_avalia_conteudo.ci_avalia_conteudo', $ci_avalia_conteudo);
        }
        if ($nm_avalia_conteudo){
            $this->db->like('LOWER("educarpravaler"."tb_avalia_conteudo"."nm_avalia_conteudo")', strtolower($nm_avalia_conteudo));
        }
        if ($cd_disciplina){
            $this->db->where('tb_avalia_conteudo.cd_disciplina', $cd_disciplina);
        }
        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');
        $this->db->order_by('tb_avalia_conteudo.nm_avalia_conteudo', 'ASC');

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

    public function get_consulta_excel( $ci_avalia_conteudo = null,
                                        $nm_avalia_conteudo = null, 
                                        $cd_disciplina = null){
        $this->db->select(' tb_avalia_conteudo.ci_avalia_conteudo as "CODIGO",
                            tb_avalia_conteudo.nm_avalia_conteudo as "CONTEUDO",
                            tb_disciplina.nm_disciplina as "DISCIPLINA"'
                        );

        $this->db->from('tb_avalia_conteudo');
        $this->db->join('tb_disciplina', 'tb_avalia_conteudo.cd_disciplina = tb_disciplina.ci_disciplina');

        $this->db->where('tb_avalia_conteudo.fl_ativo', 'true');
        if ($ci_avalia_conteudo)
        {
            $this->db->where('tb_avalia_conteudo.ci_avalia_conteudo', $ci_avalia_conteudo);
        }
        if ($nm_avalia_conteudo){
            $this->db->like('LOWER("educarpravaler"."tb_avalia_conteudo"."nm_avalia_conteudo")', strtolower($nm_avalia_conteudo));
        }
        if ($cd_disciplina){
            $this->db->where('tb_avalia_conteudo.cd_disciplina', $cd_disciplina);
        }

        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');
        $this->db->order_by('tb_avalia_conteudo.nm_avalia_conteudo', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_avalia_conteudo)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avalia_conteudo', $ci_avalia_conteudo);
        return $this->db->update('tb_avalia_conteudo', $dados);
    }

    public function inserir($nm_avalia_conteudo, $cd_disciplina)
    {
        $this->db->where('nm_avalia_conteudo', mb_strtoupper($nm_avalia_conteudo, 'UTF-8'));
        $this->db->from('tb_avalia_conteudo');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_conteudo'] = mb_strtoupper($nm_avalia_conteudo, 'UTF-8');
            $dados['cd_disciplina']      = $cd_disciplina;
            
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avalia_conteudo', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_avalia_conteudo, $cd_disciplina)
    {
        $this->db->from('tb_avalia_conteudo');

        $this->db->where('nm_avalia_conteudo', mb_strtoupper($nm_avalia_conteudo, 'UTF-8'));
        $this->db->where('cd_disciplina', $cd_disciplina);
        
        $this->db->where('ci_avalia_conteudo <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_avalia_conteudo']     = mb_strtoupper($nm_avalia_conteudo, 'UTF-8');
            $dados['cd_disciplina']          = $cd_disciplina;
            

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avalia_conteudo', $id);
            return $this->db->update('tb_avalia_conteudo', $dados);
//            return true;
        }else{
            return false;
        }

    }


}