<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Professores_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_professor       = null, 
                                    $nm_professor       = null,
                                    $nr_cpf             = null, 
                                    $dt_nascimento      = null,
                                    $ds_email           = null, 
                                    $fl_formacao        = null,
                                    $ds_outra_formacao  = null,
                                    $cd_cidade          = null,
                                    $nr_cep             = null,
                                    $ds_rua             = null,
                                    $nr_residencia      = null,
                                    $ds_bairro          = null,
                                    $ds_complemento     = null,
                                    $ds_referencia      = null){


        return count($this->buscar( $ci_professor, 
                                    $nm_professor,
                                    $nr_cpf, 
                                    $dt_nascimento,
                                    $ds_email, 
                                    $fl_formacao,
                                    $ds_outra_formacao,
                                    $cd_cidade,
                                    $nr_cep,
                                    $ds_rua,
                                    $nr_residencia,
                                    $ds_bairro,
                                    $ds_complemento,
                                    $ds_referencia));
    }

    public function buscar( $ci_professor       = null, 
                            $nm_professor       = null,
                            $nr_cpf             = null, 
                            $dt_nascimento      = null,
                            $ds_email           = null, 
                            $fl_formacao        = null,
                            $ds_outra_formacao  = null,
                            $cd_cidade          = null,
                            $nr_cep             = null,
                            $ds_rua             = null,
                            $nr_residencia      = null,
                            $ds_bairro          = null,
                            $ds_complemento     = null,
                            $ds_referencia      = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){
        $this->db->select(' tb_professor.*,
                            tb_cidade.nm_cidade,
                            tb_cidade.cd_estado,
                            tb_estado.nm_estado');  
        $this->db->from('tb_professor');
        $this->db->join('tb_cidade', 'tb_professor.cd_cidade = tb_cidade.ci_cidade');
        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');        
        $this->db->where('tb_professor.fl_ativo', 'true');
        if ($ci_professor)
        {
            $this->db->where('tb_professor.ci_professor', $ci_professor);
        }
        if ($nm_professor)
        {
            $this->db->where("remove_acentos(tb_professor.nm_professor) ilike remove_acentos('%".mb_strtoupper($nm_professor, 'UTF-8')."%')");
        }
        if ($nr_cpf)
        {
            $this->db->where('tb_professor.nr_cpf', $nr_cpf);
        }
        if ($cd_cidade)
        {
            $this->db->where('tb_professor.cd_cidade', $cd_cidade);
        }
        if ($fl_formacao)
        {
            $this->db->where('tb_professor.fl_formacao', $fl_formacao);
        }
        
        $this->db->order_by('tb_estado.nm_estado', 'ASC');
        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
        $this->db->order_by('tb_professor.nm_professor', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }

        //$this->db->last_query(); //Exibeo comando SQL'
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }
    public function get_professor_cpf($nr_cpf = null){

        $this->db->select('tb_professor.nm_professor, tb_professor.ci_professor');  

        $this->db->from('tb_professor');
        $this->db->where('tb_professor.nr_cpf', $nr_cpf);
        $this->db->where('tb_professor.fl_ativo', 'true');
        $professores = $this->db->get()->result();
        $resultado = '';

        foreach ($professores as $professor){
            $resultado = $professor->ci_professor.'|'; 
            $resultado .= $professor->nm_professor; 
        }

        echo $resultado;
    }
    public function get_consulta_excel( $ci_professor       = null, 
                                        $nm_professor       = null,
                                        $nr_cpf             = null, 
                                        $dt_nascimento      = null,
                                        $ds_email           = null, 
                                        $fl_formacao        = null,
                                        $ds_outra_formacao  = null,
                                        $cd_cidade          = null,
                                        $nr_cep             = null,
                                        $ds_rua             = null,
                                        $nr_residencia      = null,
                                        $ds_bairro          = null,
                                        $ds_complemento     = null,
                                        $ds_referencia      = null,
                                        $relatorio          = null,
                                        $limit              = null,
                                        $offset             = null){

                        $this->db->select(' tb_professor.*,
                                            tb_cidade.nm_cidade,
                                            tb_cidade.cd_estado,
                                            tb_estado.nm_estado');  
                        $this->db->from('tb_professor');
                        $this->db->join('tb_cidade', 'tb_professor.cd_cidade = tb_cidade.ci_cidade');
                        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');        
                        $this->db->where('tb_professor.fl_ativo', 'true');
                        if ($ci_professor)
                        {
                            $this->db->where('tb_professor.ci_professor', $ci_professor);
                        }
                        if ($nm_professor)
                        {
                            $this->db->where("remove_acentos(tb_professor.nm_professor) ilike remove_acentos('%".mb_strtoupper($nm_professor, 'UTF-8')."%')");
                        }
                        if ($cd_cidade)
                        {
                            $this->db->where('tb_professor.cd_cidade', $cd_cidade);
                        }
                        if ($nr_cpf)
                        {
                            $this->db->where('tb_professor.nr_cpf', $nr_cpf);
                        }
                        if ($dt_nascimento)
                        {
                            $this->db->where('tb_professor.dt_nascimento', $dt_nascimento);
                        }
                        if ($ds_email)
                        {
                            $this->db->where('tb_professor.ds_email', $ds_email);
                        }
                        $this->db->order_by('tb_estado.nm_estado', 'ASC');
                        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
                        $this->db->order_by('tb_professor.nm_professor', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_professor       = null, 
                                        $nm_professor       = null,
                                        $nr_cpf             = null, 
                                        $dt_nascimento      = null,
                                        $ds_email           = null, 
                                        $fl_formacao        = null,
                                        $ds_outra_formacao  = null,
                                        $cd_cidade          = null,
                                        $nr_cep             = null,
                                        $ds_rua             = null,
                                        $nr_residencia      = null,
                                        $ds_bairro          = null,
                                        $ds_complemento     = null,
                                        $ds_referencia      = null){

        
    return $this->buscar(   $ci_professor, 
                            $nm_professor,
                            $nr_cpf, 
                            $dt_nascimento,
                            $ds_email, 
                            $fl_formacao,
                            $ds_outra_formacao,
                            $cd_cidade,
                            $nr_cep,
                            $ds_rua,
                            $nr_residencia,
                            $ds_bairro,
                            $ds_complemento,
                            $ds_referencia);
    }
    public function excluir($ci_professor)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_professor', $ci_professor);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_professor', $dados);
    }

    public function inserir($ci_professor       = null, 
                            $nm_professor       = null,
                            $nr_cpf             = null, 
                            $dt_nascimento      = null,
                            $ds_email           = null, 
                            $fl_formacao        = null,
                            $ds_outra_formacao  = null,
                            $ds_telefone        = null,
                            $fl_sexo            = null,
                            $cd_cidade          = null,
                            $nr_cep             = null,
                            $ds_rua             = null,
                            $nr_residencia      = null,
                            $ds_bairro          = null,
                            $ds_complemento     = null,
                            $ds_referencia      = null,
                            $nm_formacao_letras = null){

        $this->db->where('nr_cpf', $nr_cpf);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_professor');
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_professor']      = $nm_professor;
            $dados['nr_cpf']            = $nr_cpf;
            $dados['dt_nascimento']     = $dt_nascimento;
            $dados['ds_email']          = $ds_email;
            $dados['fl_formacao']       = $fl_formacao;
            $dados['ds_outra_formacao'] = $ds_outra_formacao;
            $dados['ds_telefone']       = $ds_telefone;
            $dados['fl_sexo']           = $fl_sexo;
            $dados['cd_cidade']         = $cd_cidade;
            $dados['nr_cep']            = $nr_cep;
            $dados['ds_rua']            = $ds_rua;
            $dados['nr_residencia']     = $nr_residencia;
            $dados['ds_bairro']         = $ds_bairro;
            $dados['ds_complemento']    = $ds_complemento;
            $dados['ds_referencia']     = $ds_referencia;
            $dados['nm_formacao_letras']= $nm_formacao_letras;
            

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_professor', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_professor       = null, 
                            $nm_professor       = null,
                            $nr_cpf             = null, 
                            $dt_nascimento      = null,
                            $ds_email           = null, 
                            $fl_formacao        = null,
                            $ds_outra_formacao  = null,
                            $nm_img             = null,
                            $ds_telefone        = null,
                            $fl_sexo            = null,
                            $cd_cidade          = null,
                            $nr_cep             = null,
                            $ds_rua             = null,
                            $nr_residencia      = null,
                            $ds_bairro          = null,
                            $ds_complemento     = null,
                            $ds_referencia      = null,
                            $nm_formacao_letras = null){

        $this->db->where('nr_cpf', $nr_cpf);
        $this->db->where('ci_professor <> '.$ci_professor);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_professor');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_professor']      = $nm_professor;            
            $dados['nr_cpf']            = $nr_cpf;
            $dados['dt_nascimento']     = $dt_nascimento;
            $dados['ds_email']          = $ds_email;
            $dados['fl_formacao']       = $fl_formacao;
            $dados['ds_outra_formacao'] = $ds_outra_formacao;
            $dados['img']               = $nm_img;
            $dados['ds_telefone']       = $ds_telefone;
            $dados['fl_sexo']           = $fl_sexo;
            $dados['cd_cidade']         = $cd_cidade;
            $dados['nr_cep']            = $nr_cep;
            $dados['ds_rua']            = $ds_rua;
            $dados['nr_residencia']     = $nr_residencia;
            $dados['ds_bairro']         = $ds_bairro;
            $dados['ds_complemento']    = $ds_complemento;
            $dados['ds_referencia']     = $ds_referencia;
            $dados['nm_formacao_letras']= $nm_formacao_letras;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_professor', $ci_professor);
            return $this->db->update('tb_professor', $dados);
//            return true;
        }else{
            return false;
        }

    }

    public function get_id($nr_cpf     = null){
        $this->db->select('ci_professor');
        $this->db->from('tb_professor');
        $this->db->where("nr_cpf", $nr_cpf);
        $this->db->where("fl_ativo = true");                          

        $id = "";                        
        $resultados = $this->db->get()->result();

        foreach ($resultados as $result){
            $id = $result->ci_professor;
        }
        return $id; 
    }
    public function grava_img_db($id, $nm_campo, $nm_img){
        $dados[$nm_campo]   = $nm_img;
        $this->db->where('ci_professor', $id);
        return $this->db->update('tb_professor', $dados);
    }
}