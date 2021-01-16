<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Anos_letivos_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function buscar( $ci_ano_letivo = null,
                            $nr_ano_letivo = null,
                            $ci_escola     = null,
                            $nm_escola     = null,
                            $consulta      = null,
                            $cd_cidade     = null,
                            $cd_estado     = null){
        
        if ($consulta){
            $this->db->select(' tb_ano_letivo.ci_ano_letivo,
                                tb_ano_letivo.nr_ano_letivo,
                                tb_ano_letivo.fl_ano_letivo_corrente,
                                tb_escola.ci_escola,
                                tb_escola.nm_escola,
                                tb_cidade.ci_cidade,
                                tb_cidade.nm_cidade,
                                tb_estado.ci_estado,
                                tb_estado.nm_uf');

            $this->db->from('tb_ano_letivoescolas');
            $this->db->join('tb_escola','tb_ano_letivoescolas.cd_escola = tb_escola.ci_escola');
            $this->db->join('tb_ano_letivo','tb_ano_letivoescolas.cd_ano_letivo = tb_ano_letivo.ci_ano_letivo');
            $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');

            if ($ci_ano_letivo)
            {
            $this->db->where('tb_ano_letivo.ci_ano_letivo', $ci_ano_letivo);
            }
            if ($nr_ano_letivo)
            {
            $this->db->where("remove_acentos(tb_ano_letivo.nr_ano_letivo) ilike remove_acentos('%".mb_strtoupper($nr_ano_letivo, 'UTF-8')."%')");
            }
            if ($nm_escola)
            {
            $this->db->where("remove_acentos(tb_escola.nm_escola) ilike remove_acentos('%".mb_strtoupper($nm_escola, 'UTF-8')."%')");
            }
            if ($cd_cidade)
            {
            $this->db->where('tb_cidade.ci_cidade', $cd_cidade);
            }
            if ($cd_estado)
            {
            $this->db->where('tb_estado.ci_estado', $cd_estado);
            }

            $this->db->where('tb_ano_letivo.fl_ativo', 'true');

            $this->db->order_by('tb_escola.nm_escola', 'ASC');
            $this->db->order_by('tb_ano_letivo.nr_ano_letivo', 'ASC');
        }else{
            $this->db->select(' tb_ano_letivo.ci_ano_letivo,
                                tb_ano_letivo.nr_ano_letivo,
                                tb_ano_letivo.fl_ano_letivo_corrente');

            $this->db->from('tb_ano_letivo');

            if ($ci_ano_letivo)
            {
            $this->db->where('tb_ano_letivo.ci_ano_letivo', $ci_ano_letivo);
            }
            if ($nr_ano_letivo)
            {
            $this->db->where("remove_acentos(tb_ano_letivo.nr_ano_letivo) ilike remove_acentos('%".mb_strtoupper($nr_ano_letivo, 'UTF-8')."%')");
            }

            $this->db->where('tb_ano_letivo.fl_ativo', 'true');
            $this->db->order_by('tb_ano_letivo.nr_ano_letivo', 'ASC');
        }

        return $this->db->get()->result();
    }

    public function buscar_escolas($cd_ano_letivo  = null, $cd_cidade  = null, $tipo = null){

        if ($tipo == 'selecionadas'){
            $this->db->select(' tb_ano_letivoescolas.cd_ano_letivo,
                                tb_ano_letivoescolas.cd_escola,
                                tb_escola.nr_inep,
                                tb_escola.nm_escola,
                                tb_cidade.ci_cidade,
                                tb_cidade.nm_cidade,
                                tb_estado.ci_estado,
                                tb_estado.nm_uf'); 

            $this->db->from('tb_ano_letivoescolas');
            $this->db->join('tb_escola', 'tb_ano_letivoescolas.cd_escola = tb_escola.ci_escola');
            $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');

            if ($cd_ano_letivo)
            {
            $this->db->where('tb_ano_letivoescolas.cd_ano_letivo', $cd_ano_letivo);
            }
            $this->db->order_by('tb_estado.nm_uf', 'ASC');
            $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
            $this->db->order_by('tb_escola.nm_escola', 'ASC');
        }else{
            $this->db->select(' tb_escola.ci_escola,
                                tb_escola.nr_inep,
                                tb_escola.nm_escola,
                                tb_cidade.ci_cidade,
                                tb_cidade.nm_cidade,
                                tb_estado.ci_estado,
                                tb_estado.nm_uf'); 

            $this->db->from('tb_escola');
            $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');
            $this->db->where('tb_cidade.ci_cidade', $cd_cidade);
            if ($cd_ano_letivo)
            {
                $this->db->where_not_in('tb_escola.ci_escola', 'select tb_ano_letivoescolas.cd_escola from tb_ano_letivoescolas where tb_ano_letivoescolas.cd_ano_letivo = '.$cd_ano_letivo, FALSE);
            }
            $this->db->order_by('tb_estado.nm_uf', 'ASC');
            $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
            $this->db->order_by('tb_escola.nm_escola', 'ASC');



        }


        return $this->db->get()->result();      
    }

    public function excluir($id)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_ano_letivo', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_ano_letivo', $dados);
    }

    public function set_anovigente($ci_ano_letivo = null){
        $this->db->query("update tb_ano_letivo set fl_ano_letivo_corrente = 'N'; ");        
        $this->db->query("update tb_ano_letivo set fl_ano_letivo_corrente = 'S' where ci_ano_letivo= ".$ci_ano_letivo);
    }

    public function inserir($nr_ano_letivo = null, 
                            $fl_ano_letivo_corrente = null, 
                            $cd_escolas_selecionadas = null){

        $this->db->where("tb_ano_letivo.nr_ano_letivo", $nr_ano_letivo);

        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_ano_letivo', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            if ($fl_ano_letivo_corrente == 'S'){
                $this->db->query("update tb_ano_letivo set fl_ano_letivo_corrente = 'N'; ");
            }

            $dados['nr_ano_letivo']          = $nr_ano_letivo;
            $dados['fl_ano_letivo_corrente'] = $fl_ano_letivo_corrente;
            
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_ano_letivo', $dados);


            if ($cd_escolas_selecionadas){

                $query = $this->db->query("select ci_ano_letivo from tb_ano_letivo ".
                                 "where nr_ano_letivo ='".$nr_ano_letivo."' and fl_ativo = true" );
                $ano_letivos = $query->result(); 
                
                foreach ($ano_letivos as $y => $ano_letivo){

                    $ci_ano_letivo = $ano_letivo->ci_ano_letivo;
                }    
                $this->db->query("delete from tb_ano_letivoescolas where cd_ano_letivo='".$ci_ano_letivo."'");
                
                // Inicio - Inserir escolas do usuário
                foreach ($cd_escolas_selecionadas as $i => $value) {
                    $dados_escola['cd_ano_letivo'] = $ci_ano_letivo;
                    $dados_escola['cd_escola']  = $value;
                    $this->db->insert('tb_ano_letivoescolas', $dados_escola);
                } 
            }
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_ano_letivo = null,
                            $nr_ano_letivo = null,
                            $fl_ano_letivo_corrente = null, 
                            $cd_escolas_selecionadas = null){

        $this->db->where("tb_ano_letivo.nr_ano_letivo", $nr_ano_letivo);
       
        $this->db->where('ci_ano_letivo <> '.$ci_ano_letivo);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_ano_letivo');

        if (!($this->db->get()->num_rows() > 0)){

            
            $this->db->query("update tb_ano_letivo set fl_ano_letivo_corrente = 'N'; ");       
                
            $dados['nr_ano_letivo']          = $nr_ano_letivo;
            $dados['fl_ano_letivo_corrente'] = $fl_ano_letivo_corrente;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_ano_letivo', $ci_ano_letivo);
            $this->db->update('tb_ano_letivo', $dados);
            
            if ($cd_escolas_selecionadas){
   
                $this->db->query("delete from tb_ano_letivoescolas where cd_ano_letivo='".$ci_ano_letivo."'");
                
                // Inicio - Inserir escolas do usuário
                foreach ($cd_escolas_selecionadas as $i => $value) {
                    $dados_escola['cd_ano_letivo'] = $ci_ano_letivo;
                    $dados_escola['cd_escola']  = $value;
                    $this->db->insert('tb_ano_letivoescolas', $dados_escola);
                } 
            }
            
            return true;
        }else{
            return false;
        }

    }

}