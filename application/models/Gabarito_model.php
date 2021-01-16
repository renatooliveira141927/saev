<?php
/**
 * Created by PhpStorm.
 * User: Windows
 * Date: 11/10/2018
 * Time: 00:31
 */

class Gabarito_model  extends CI_Model {


    public function inserir($var_cd_alunos = null, $gabarito = null, $questoes = null, $cd_avaliacao = null, $qtd_reg = null){
        
        foreach ($questoes as $i => $item) {
            $where = "cd_aluno='$var_cd_alunos' and cd_avaliacao_itens='$item'";
            $this->db->where($where);
            $this->db->delete('tb_avaliacao_aluno');
        }

        $this->db->insert_batch('tb_avaliacao_aluno', $gabarito);
        
        $this->compilaresultadoEscrita($var_cd_alunos,$cd_avaliacao);
        
        return true;
    }
    
    public function compilaresultadoEscrita($cd_aluno,$cd_avaliacao){
        $sql="select * from compila_resultado_aluno_avaliacao(".$cd_aluno.",".$cd_avaliacao.");";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function inserirleitura($var_cd_alunos = null, $gabarito = null, $questoes = null, $qtd_reg = null,
        $cd_avaliacao_upload=null){

        foreach ($questoes as $i => $item) {
            $where = "cd_aluno='$var_cd_alunos' and cd_avaliacao_itens='$item' and cd_avaliacao_upload='$cd_avaliacao_upload'";
            $this->db->where($where);
            $this->db->delete('tb_avaliacaoleitura_aluno');
        }

        $this->db->insert_batch('tb_avaliacaoleitura_aluno', $gabarito);

        return true;
    }
    
    public function compilaresultadoLeitura($cd_avaliacao){
        $sql="select * from compila_resultado_avaliacao_leitura(".$cd_avaliacao.");";
        $query=$this->db->query($sql);
        return $query->result();
    }

}