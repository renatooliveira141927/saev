<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Grupo_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar($ci_grupousuario = null,
                                 $nm_grupo = null){

        return count($this->buscar( $ci_grupousuario,
                                    $nm_grupo));

    }
    public function buscar_grupotransacoes($ci_grupousuario){
        $this->db->select(' tb_grupotransacao.cd_transacao,
                            tb_transacao.nm_transacao'
                        );
        
        $this->db->from('tb_grupotransacao');
                            
        $this->db->join('tb_grupo', 'tb_grupotransacao.cd_grupo = tb_grupo.ci_grupousuario');
        $this->db->join('tb_transacao', 'tb_grupotransacao.cd_transacao = tb_transacao.ci_transacao');
        $this->db->where('tb_grupotransacao.cd_grupo', $ci_grupousuario);

        $this->db->order_by('tb_grupo.nm_grupo', 'ASC');

        echo $this->db->get()->result();
    }

    public function buscar($ci_grupousuario = null,
                           $nm_grupo = null,
                           $relatorio = null,
                           $limit    = null,
                           $offset   = null){

        $this->db->from('tb_grupo');

        $this->db->where('fl_ativo', 'true');

        if ($ci_grupousuario)
        {
            $this->db->where('ci_grupousuario', $ci_grupousuario);
        }
        if ($nm_grupo){
            $this->db->like('LOWER(nm_grupo)', strtolower($nm_grupo));
        }

        $this->db->order_by('nm_grupo', 'ASC');

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
    
    public function buscar_grupoescolas($ci_grupousuario){

        $query = $this->db->query('

            SELECT 	"tb_escola".ci_escola,
                    "tb_escola".nr_inep, 
                    "tb_escola".nm_escola, 
                    "tb_cidade".nm_cidade
                    
            FROM "tb_grupoescolas"
            join "tb_escola" on ("tb_grupoescolas".cd_escola = "tb_escola".ci_escola
                                                and "tb_grupoescolas".cd_grupo = '.$ci_grupousuario.')
            join "tb_cidade" on ("tb_escola".cd_cidade = "tb_cidade".ci_cidade)

            ORDER BY "tb_cidade".nm_cidade, "tb_escola".nm_escola
        ');

        return $query->result();
 
    }
    public function buscar_transacoes($ci_grupousuario){

        $query = $this->db->query('
            SELECT ci_transacao, nm_transacao, cd_grupo
            FROM "tb_transacao"
            left join  "tb_grupotransacao" on 
                ("tb_transacao".ci_transacao = "tb_grupotransacao".cd_transacao 
                                                            and "tb_grupotransacao".cd_grupo = '.$ci_grupousuario.')
            ORDER BY ci_transacao
        ');

        return $query->result();
 
    }
    public function get_consulta_excel( $ci_grupousuario = null,
                                        $nm_grupo){
        $this->db->select(' ci_grupousuario as "CODIGO",
                            nm_grupo as "NOME"');
        $this->db->from('tb_grupo');

        $this->db->where('fl_ativo', 'true');
        if ($ci_grupousuario)
        {
            $this->db->where('ci_grupousuario', $ci_grupousuario);
        }
        if ($nm_grupo){
            $this->db->like('LOWER(nm_grupo)', strtolower($nm_grupo));
        }

        $this->db->order_by('nm_grupo', 'ASC');

        //        echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }

    public function excluir($ci_grupousuario)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        // Inicio - Apagar escolas do grupo anteriores
        $this->db->where('cd_grupo', $ci_grupousuario);
        $this->db->delete('tb_grupoescolas');
        // Fim - Apagar escolas do grupo anteriores     

        // Inicio - Apagar transações anteriores
        $this->db->where('cd_grupo', $ci_grupousuario);
        $this->db->delete('tb_grupotransacao');
        // Fim - Apagar transações anteriores     

        $this->db->where('ci_grupousuario', $ci_grupousuario);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_grupo', $dados);
    }

    public function inserir($nm_grupo, 
                            $tp_administrador,
                            $arr_ci_transacoes = null, 
                            $arr_ci_escolas = null)
    {
        $ci_grupousuario = '';
        $this->db->from('tb_grupo');
        $this->db->where('nm_grupo', mb_strtoupper($nm_grupo, 'UTF-8'));
        $this->db->where('fl_ativo', 'true');

        if (!($this->db->get()->num_rows() > 0)){
            $dados['nm_grupo']          = mb_strtoupper($nm_grupo, 'UTF-8');
            $dados['tp_administrador']       = $tp_administrador;
            $dados['cd_usuario_cad']    = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_grupo', $dados);

            // Inicio - Verifica o id do Grupo    
            $this->db->select('ci_grupousuario');
            $this->db->from('tb_grupo');
            $this->db->where('nm_grupo', mb_strtoupper($nm_grupo, 'UTF-8'));
            $this->db->where('fl_ativo', 'true');
            $result = $this->db->get()->result();

            foreach ($result as $i => $row) {
                $ci_grupousuario = $row ->ci_grupousuario;
            }
            // Fim - Verifica o id do Grupo
            // Inicio - Inserir escolas    
            foreach ($arr_ci_escolas as $i => $value) {
                $dados_escolas['cd_escola']    = $value;
                $dados_escolas['cd_grupo']     = $ci_grupousuario;
                $this->db->insert('tb_grupoescolas', $dados_escolas);
            } 
            // Fim - Inserir escolas 
            // Inicio - Inserir transações    
            foreach ($arr_ci_transacoes as $i => $value) {
                $dados_grupos['cd_grupo']     = $ci_grupousuario;
                $dados_grupos['cd_transacao'] = $value;
                $this->db->insert('tb_grupotransacao', $dados_grupos);
            } 
            // Fim - Inserir transações
            return true;
        }else{
            return false;
        }

    }

    public function alterar($id, 
                            $nm_grupo, 
                            $tp_administrador,
                            $arr_ci_transacoes = null, 
                            $arr_ci_escolas = null)
    {
        $this->db->from('tb_grupo');

        $this->db->where('nm_grupo', mb_strtoupper($nm_grupo, 'UTF-8'));
        $this->db->where('ci_grupousuario <>', $id);
        $this->db->where('fl_ativo', 'true');
        
        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_grupo']          = mb_strtoupper($nm_grupo, 'UTF-8');
            $dados['tp_administrador']       = $tp_administrador;
            
            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_grupousuario', $id);
            $this->db->update('tb_grupo', $dados);

            // Inicio - Apagar escolas anteriores
            $this->db->where('cd_grupo', $id);
            $this->db->delete('tb_grupoescolas');
            // Fim - Apagar escolas anteriores

            // Inicio - Apagar transações anteriores
            $this->db->where('cd_grupo', $id);
            $this->db->delete('tb_grupotransacao');
            // Fim - Apagar transações anteriores

            // Inicio - Inserir escolas
            if ($arr_ci_escolas != ''){
                foreach ($arr_ci_escolas as $i => $value) {
                    $dados_escolas['cd_escola']    = $value;
                    $dados_escolas['cd_grupo']     = $id;
                    $this->db->insert('tb_grupoescolas', $dados_escolas);
                } 
            }
            // Fim - Inserir escolas 
            // Inicio - Inserir transações    
            foreach ($arr_ci_transacoes as $i => $value) {
                $dados_grupos['cd_grupo']     = $id;
                $dados_grupos['cd_transacao'] = $value;
                $this->db->insert('tb_grupotransacao', $dados_grupos);
            } 
            // Fim - Inserir transações       


            return true;
        }else{
            return false;
        }

    }


}