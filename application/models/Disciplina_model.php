<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Disciplina_model extends CI_Model {

    public $ci_aluno;
    public $nm_aluno;

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_disciplina = null,
                                 $nm_disciplina = null){

        return count($this->buscar( $ci_disciplina,
                                    $nm_disciplina));

    }

    public function buscar($ci_disciplina = null,
                           $nm_disciplina = null,
                           $relatorio = null,
                           $limit    = null,
                           $offset   = null){

        $this->db->from('tb_disciplina');

        $this->db->where('fl_ativo', 'true');

        if ($ci_disciplina)
        {
            $this->db->where('ci_disciplina', $ci_disciplina);
        }
        if ($nm_disciplina){
            $this->db->like('LOWER(nm_disciplina)', strtolower($nm_disciplina));
        }

        $this->db->order_by('nm_disciplina', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }

        //echo $this->db->last_query(); //Exibeo comando SQL
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }

    public function get_consulta_excel( $ci_disciplina = null,
                                        $nm_disciplina){
        $this->db->select(' ci_disciplina as "CODIGO",
                            nm_disciplina as "NOME"');
        $this->db->from('tb_disciplina');

        $this->db->where('fl_ativo', 'true');
        if ($ci_disciplina)
        {
            $this->db->where('ci_disciplina', $ci_disciplina);
        }
        if ($nm_disciplina){
            $this->db->like('LOWER(nm_disciplina)', strtolower($nm_disciplina));
        }

        $this->db->order_by('nm_disciplina', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_disciplina)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_disciplina', $ci_disciplina);
        return $this->db->update('tb_disciplina', $dados);
    }

    public function inserir($nm_disciplina)
    {
        $this->db->from('tb_disciplina');
        $this->db->where('nm_disciplina', mb_strtoupper($nm_disciplina, 'UTF-8'));
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_disciplina']          = mb_strtoupper($nm_disciplina, 'UTF-8');
            $dados['cd_usuario_cad']     = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_disciplina', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, $nm_disciplina)
    {
        $this->db->from('tb_disciplina');

        $this->db->where('nm_disciplina', mb_strtoupper($nm_disciplina, 'UTF-8'));
        $this->db->where('ci_disciplina <>', $id);
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_disciplina']          = mb_strtoupper($nm_disciplina, 'UTF-8');

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_disciplina', $id);
            return $this->db->update('tb_disciplina', $dados);
//            return true;
        }else{
            return false;
        }

    }

    public function selectDisciplinas(){

        $disciplinas = $this->buscar();

        $options = "<option value=''>Selecione uma Disciplina </option>";
        foreach ($disciplinas as $disciplina){
            $options .= "<option value='{$disciplina->ci_disciplina}'>{$disciplina->nm_disciplina}</option>".PHP_EOL;
        }
        return $options;
    }


}