<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Usuario_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_usuario  = null,
                                    $nm_usuario = null,
                                    $nm_login   = null,
                                    $nr_cpf     = null,
                                    $cd_grupo   = null,
                                    $cd_estado_sme= null,
                                    $cd_cidade_sme= null){

        return count($this->buscar( $ci_usuario,
                                    $nm_usuario,
                                    $nm_login,
                                    $nr_cpf,
                                    $cd_grupo,
                                    $cd_estado_sme,
                                    $cd_cidade_sme));
    }

    public function buscar($ci_usuario  = null,
                            $nm_usuario = null,
                            $nm_login   = null,
                            $nr_cpf     = null,
                            $cd_grupo   = null,
                            $cd_estado_sme= null,
                            $cd_cidade_sme= null,
                            $relatorio  = null,
                            $limit      = null,
                            $offset     = null){
        $this->db->select(' tb_usuario.ci_usuario,
                            tb_usuario.nm_usuario,
                            tb_usuario.nm_login,
                            tb_usuario.nr_cpf,
                            tb_usuario.cd_grupo,
                            tb_usuario.img,
                            tb_grupo.nm_grupo,
                            tb_grupo.tp_administrador,
                            tb_usuario.fl_sexo,
                            tb_usuario.ds_telefone,
                            tb_usuario.ds_email,                            
                            tb_usuario.cd_cidade,
                            tb_cidade.cd_estado,
                            tb_usuario.nr_cep,
                            tb_usuario.ds_rua,
                            tb_usuario.ds_bairro,
                            tb_usuario.nr_residencia,
                            tb_usuario.ds_complemento,
                            tb_usuario.ds_referencia,
                            tb_usuario.cd_estado_sme,
                            tb_usuario.cd_cidade_sme
                            '); 

        $this->db->from('tb_usuario');
        $this->db->join('tb_grupo', 'tb_usuario.cd_grupo = tb_grupo.ci_grupousuario');
        $this->db->join('tb_cidade', 'tb_usuario.cd_cidade = tb_cidade.ci_cidade', 'left');
        
        $this->db->where('tb_usuario.fl_ativo', 'true');
        if ($ci_usuario)
        {
            $this->db->where('tb_usuario.ci_usuario', $ci_usuario);
        }
        if ($nm_usuario)
        {
            $this->db->where("remove_acentos(tb_usuario.nm_usuario) ilike remove_acentos('%".mb_strtoupper($nm_usuario, 'UTF-8')."%')");            
        }
        if ($nm_login)
        {
            $this->db->where("remove_acentos(tb_usuario.nm_login) ilike remove_acentos('%".mb_strtoupper($nm_login, 'UTF-8')."%')");
        }
        if ($nr_cpf)
        {
            $this->db->where('tb_usuario.nr_cpf', $nr_cpf);
        }
        if ($cd_grupo)
        {
            $this->db->where('tb_usuario.cd_grupo', $cd_grupo);
        }

        if ($cd_estado_sme)
        {
            $this->db->where('tb_usuario.cd_estado_sme', $cd_estado_sme);
        }
        if ($cd_cidade_sme)
        {
            $this->db->where('tb_usuario.cd_cidade_sme', $cd_cidade_sme);
        }
        $this->db->order_by('tb_grupo.nm_grupo', 'ASC');
        $this->db->order_by('tb_usuario.nm_usuario', 'ASC');

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

    public function get_consulta_excel( $ci_usuario  = null,
                                        $nm_usuario = null,
                                        $nm_login   = null,
                                        $nr_cpf     = null,
                                        $cd_grupo   = null,
                                        $relatorio  = null,
                                        $limit      = null,
                                        $offset     = null){

        $this->db->select(' tb_usuario.nm_usuario as Nome,
                            tb_usuario.nm_login as Usuário,
                            tb_usuario.nr_cpf as CPF,
                            tb_grupo.nm_grupo as Grupo,
                            tb_usuario.fl_sexo as Sexo,
                            tb_usuario.ds_telefone as Telefone,
                            tb_usuario.ds_email as E-mail');  
        
        $this->db->from('tb_usuario');
        $this->db->join('tb_grupo', 'tb_usuario.cd_grupo = tb_grupo.ci_grupousuario');
        
        $this->db->where('tb_usuario.fl_ativo', 'true');
        if ($ci_usuario)
        {
            $this->db->where('tb_usuario.ci_usuario', $ci_usuario);
        }
        if ($nm_usuario)
        {
            $this->db->where("remove_acentos(tb_usuario.nm_usuario) ilike remove_acentos('%".mb_strtoupper($nm_usuario, 'UTF-8')."%')");
            
        }
        if ($nm_login)
        {
            $this->db->where("remove_acentos(tb_usuario.nm_login) ilike remove_acentos('%".mb_strtoupper($nm_login, 'UTF-8')."%')");
        }
        if ($nr_cpf)
        {
            $this->db->where('tb_usuario.nr_cpf', $nr_cpf);
        }
        if ($cd_grupo)
        {
            $this->db->where('tb_usuario.cd_grupo', $cd_grupo);
        }
        $this->db->order_by('tb_grupo.nm_grupo', 'ASC');
        $this->db->order_by('tb_usuario.nm_usuario', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_usuario     = null,
                                        $nm_usuario     = null,
                                        $nm_login       = null,
                                        $nr_cpf         = null,
                                        $cd_grupo       = null){

        
    return $this->buscar(   $ci_usuario     = null,
                            $nm_usuario     = null,
                            $nm_login       = null,
                            $nr_cpf         = null,
                            $cd_grupo       = null);
    }
    public function excluir($ci_usuario)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_usuario', $ci_usuario);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_usuario', $dados);
    }
    
    public function buscar_escolas($cd_usuario  = null, $cd_cidade_sme = null, $cd_estado_sme = null, $tipo = null){

        if ($tipo == 'selecionadas'){
         
            $this->db->select(' tb_usuarioescolas.cd_usuario,
                                tb_usuarioescolas.cd_escola,
                                tb_escola.nr_inep,
                                tb_escola.nm_escola,
                                tb_cidade.nm_cidade,
                                tb_estado.nm_uf,
                                tb_estado.nm_estado,
                                tb_usuario.cd_cidade_sme,
                                tb_usuario.cd_estado_sme'); 

            $this->db->from('tb_usuarioescolas');
            $this->db->join('tb_usuario', 'tb_usuario.ci_usuario = tb_usuarioescolas.cd_usuario');

            $this->db->join('tb_escola', 'tb_usuarioescolas.cd_escola = tb_escola.ci_escola');
            $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');

            if ($cd_usuario)
            {
            $this->db->where('tb_usuarioescolas.cd_usuario', $cd_usuario);
            }
            if ($cd_cidade_sme)
            {
            $this->db->where('tb_escola.cd_cidade', $cd_cidade_sme);
            }

            if ($cd_estado_sme)
            {
            $this->db->where('tb_cidade.cd_estado', $cd_estado_sme);
            }

            $this->db->order_by('tb_estado.nm_uf', 'ASC');
            $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
            $this->db->order_by('tb_escola.nm_escola', 'ASC');

        }else{

            $this->db->select(' tb_escola.ci_escola,
                                tb_escola.nr_inep,
                                tb_escola.nm_escola,
                                tb_cidade.nm_cidade,
                                tb_estado.nm_uf,
                                tb_estado.nm_estado'); 

            $this->db->from('tb_escola');
            $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');

            if ($cd_cidade_sme)
            {
            $this->db->where('tb_escola.cd_cidade', $cd_cidade_sme);
            }

            if ($cd_estado_sme)
            {
            $this->db->where('tb_cidade.cd_estado', $cd_estado_sme);
            }
            if ($cd_usuario)
            {
            $this->db->where_not_in('tb_escola.ci_escola', 'select cd_escola from tb_usuarioescolas where cd_usuario='.$cd_usuario, false);
            }
            $this->db->order_by('tb_estado.nm_uf', 'ASC');
            $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
            $this->db->order_by('tb_escola.nm_escola', 'ASC');
            
        }

        return $this->db->get()->result();      
    }

    public function inserir($nm_usuario = null,
                            $nm_login   = null,
                            $nr_cpf     = null,
                            $cd_grupo   = null,
                            $fl_sexo    = null,
                            $ds_telefone= null,
                            $ds_email   = null,

                            $nr_cep         = null,
                            $cd_estado      = null,
                            $cd_cidade      = null,
                            $ds_rua         = null,
                            $nr_residencia  = null,
                            $ds_bairro      = null,
                            $ds_complemento = null,
                            $ds_referencia  = null, 
                            $cd_estado_sme  = null,
                            $cd_cidade_sme  = null,
                            $cd_escolas_selecionadas = null){

        if ($nm_login)
        {
            $this->db->where("
                    ((remove_acentos(nm_login) = remove_acentos('".mb_strtoupper($nm_login, 'UTF-8')."')) 
                or  (remove_acentos(nr_cpf)   = remove_acentos('".$nr_cpf."')))
                ");
        }
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_usuario');
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_usuario']    = $nm_usuario;            
            $dados['nm_login']      = $nm_login;
            $dados['nr_cpf']        = $nr_cpf;
            if ($cd_grupo){
                $dados['cd_grupo']      = $cd_grupo;
            }
            $dados['fl_sexo']       = $fl_sexo;
            $dados['ds_telefone']   = $ds_telefone;
            $dados['ds_email']      = $ds_email;

            $dados['nr_cep']        = $nr_cep;
            if ($cd_cidade){
                $dados['cd_cidade']     = $cd_cidade;
            }
            $dados['ds_rua']        = $ds_rua;
            $dados['nr_residencia'] = $nr_residencia;
            $dados['ds_bairro']     = $ds_bairro;
            $dados['ds_complemento']= $ds_complemento;
            $dados['ds_referencia'] = $ds_referencia;
            if ($cd_estado_sme){
                $dados['cd_estado_sme'] = $cd_estado_sme;
            }
            if ($cd_cidade_sme){
                $dados['cd_cidade_sme'] = $cd_cidade_sme;
            }

            $dados['cd_usuario_cad']    = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_usuario', $dados);
            
            $ci_usuario = '';
            if ($cd_escolas_selecionadas){

                $query = $this->db->query("select * from tb_usuario where fl_ativo=true and nr_cpf='".$nr_cpf."'");
                $usuarios = $query->result();
                foreach ($usuarios as $y => $usuario){

                    $ci_usuario = $usuario->ci_usuario;
                }

                // Inicio - Apagar escolas do usuário
                $this->db->where('cd_usuario', $ci_usuario);
                $this->db->delete('tb_usuarioescolas');

                // Inicio - Inserir escolas do usuário
                foreach ($cd_escolas_selecionadas as $i => $value) {
                    $dados_escola['cd_usuario'] = $ci_usuario;
                    $dados_escola['cd_escola']  = $value;
                    $this->db->insert('tb_usuarioescolas', $dados_escola);
                } 
            }

            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_usuario = null, 
                            $nm_usuario = null,
                            $nm_login   = null,
                            $nr_cpf     = null,
                            $cd_grupo   = null,
                            $fl_sexo    = null,
                            $img        = null,
                            $ds_telefone= null,
                            $ds_email   = null,
                            $nr_cep         = null,
                            $cd_estado      = null,
                            $cd_cidade      = null,
                            $ds_rua         = null,
                            $nr_residencia  = null,
                            $ds_bairro      = null,
                            $ds_complemento = null,
                            $ds_referencia  = null,
                            $cd_estado_sme  = null,
                            $cd_cidade_sme  = null,
                            $cd_escolas_selecionadas = null){

        $this->db->where("
                            ((remove_acentos(nm_login) = remove_acentos('%".$nm_login."%')) 
                            or  (remove_acentos(nr_cpf)   = remove_acentos('%".$nr_cpf."%')))
                            and (ci_usuario <> ".$ci_usuario.")
                            and (fl_ativo = true)
                        ");
        $this->db->from('tb_usuario');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_usuario']    = $nm_usuario;            
            $dados['nm_login']      = $nm_login;
            $dados['nr_cpf']        = $nr_cpf;
            $dados['cd_grupo']      = $cd_grupo;
            $dados['fl_sexo']       = $fl_sexo;
            $dados['img']           = $img;
            $dados['ds_telefone']   = $ds_telefone;
            $dados['ds_email']      = $ds_email;
            $dados['nr_cep']        = $nr_cep;
            if ($cd_cidade){
                $dados['cd_cidade']     = $cd_cidade;
            }
            $dados['ds_rua']        = $ds_rua;
            $dados['nr_residencia'] = $nr_residencia;
            $dados['ds_bairro']     = $ds_bairro;
            $dados['ds_complemento']= $ds_complemento;
            $dados['ds_referencia'] = $ds_referencia;
            if ($cd_estado_sme){
                $dados['cd_estado_sme'] = $cd_estado_sme;
            }
            if ($cd_cidade_sme){
                $dados['cd_cidade_sme'] = $cd_cidade_sme;
            }
            
            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_usuario', $ci_usuario);
            $this->db->update('tb_usuario', $dados);

            // Inicio - Apagar escolas do usuário
            $this->db->where('cd_usuario', $ci_usuario);
            $this->db->delete('tb_usuarioescolas');

            if ($cd_escolas_selecionadas){
                // Inicio - Inserir escolas do usuário
                foreach ($cd_escolas_selecionadas as $i => $value) {
                    // echo '<br><br>cd_usuario='.$ci_usuario;
                    // echo '<br><br>cd_escola='.$value;
                    $dados_escola['cd_usuario'] = $ci_usuario;
                    $dados_escola['cd_escola']  = $value;
                    $this->db->insert('tb_usuarioescolas', $dados_escola);
                } 
            }

            return true;
        }else{
            return false;
        }

    }
    public function get_id($nr_cpf     = null){
        $this->db->select('ci_usuario');
        $this->db->from('tb_usuario');
        $this->db->where("nr_cpf", $nr_cpf);
        $this->db->where("fl_ativo = true");                          

        $id = "";                        
        $resultados = $this->db->get()->result();

        foreach ($resultados as $result){
            $id = $result->ci_usuario;
        }
        return $id; 
    }
    public function grava_img_db($id, $nm_campo, $nm_img){
        $dados[$nm_campo]   = $nm_img;
        $this->db->where('ci_usuario', $id);
        return $this->db->update('tb_usuario', $dados);
    }
}