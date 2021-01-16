<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Escolas_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_escola      = null,
                                    $nr_inep        = null,
                                    $nm_escola      = null,
                                    $ds_telefone    = null,
                                    $ds_email       = null,
                                    $fl_extencao    = null,
                                    $fl_tpunidade   = null,
                                    $fl_localizacao = null,
                                    $cd_cidade      = null,
                                    $nr_cep         = null,
                                    $ds_rua         = null,
                                    $nr_residencia  = null,
                                    $ds_bairro      = null,
                                    $ds_complemento = null,
                                    $ds_referencia  = null){


        return count($this->buscar( $ci_escola,
                                    $nr_inep,
                                    $nm_escola,
                                    $ds_telefone,
                                    $ds_email,
                                    $fl_extencao,
                                    $fl_tpunidade,
                                    $fl_localizacao,
                                    $cd_cidade,
                                    $nr_cep,
                                    $ds_rua,
                                    $nr_residencia,
                                    $ds_bairro,
                                    $ds_complemento,
                                    $ds_referencia));
    }

    public function buscar( $ci_escola      = null,
                            $nr_inep        = null,
                            $nm_escola      = null,
                            $ds_telefone    = null,
                            $ds_email       = null,
                            $fl_extencao    = null,
                            $fl_tpunidade   = null,
                            $fl_localizacao = null,
                            $cd_cidade      = null,
                            $nr_cep         = null,
                            $ds_rua         = null,
                            $nr_residencia  = null,
                            $ds_bairro      = null,
                            $ds_complemento = null,
                            $ds_referencia  = null,
                            $relatorio      = null,
                            $limit          = null,
                            $offset         = null){
        $this->db->select(' tb_escola.*,
                            tb_cidade.nm_cidade,
                            tb_cidade.cd_estado,
                            tb_estado.nm_estado');  
        $this->db->from('tb_escola');
        $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');        
        $this->db->where('tb_escola.fl_ativo', 'true');
        if ($ci_escola)
        {
            $this->db->where('tb_escola.ci_escola', $ci_escola);
        }
        if ($nm_escola)
        {
            $this->db->where("remove_acentos(tb_escola.nm_escola) ilike remove_acentos('%".mb_strtoupper($nm_escola, 'UTF-8')."%')");
            
        }
        if ($nr_inep)
        {
            $this->db->where('tb_escola.nr_inep', $nr_inep);
        }
        if ($cd_cidade)
        {
            $this->db->where('tb_escola.cd_cidade', $cd_cidade);
        }
        if ($fl_extencao)
        {
            $this->db->where('tb_escola.fl_extencao', $fl_extencao);
        }
         if ($fl_tpunidade)
        {
            $this->db->where('tb_escola.fl_tpunidade', $fl_tpunidade);
        }
        if ($fl_localizacao)
        {
            $this->db->where('tb_escola.fl_localizacao', $fl_localizacao);
        }
        $this->db->order_by('tb_estado.nm_estado', 'ASC');
        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
        $this->db->order_by('tb_escola.nm_escola', 'ASC');

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

    public function get_consulta_excel( $ci_escola          = null,
                                        $nr_inep            = null,
                                        $nm_escola          = null,
                                        $ds_telefone        = null,
                                        $ds_email           = null,
                                        $fl_extencao        = null,
                                        $fl_tpunidade       = null,
                                        $fl_localizacao     = null,
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

                        $this->db->select(' tb_escola.*,
                                            tb_cidade.nm_cidade,
                                            tb_cidade.cd_estado,
                                            tb_estado.nm_estado');  
                        $this->db->from('tb_escola');
                        $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
                        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');        
                        $this->db->where('tb_escola.fl_ativo', 'true');
                        if ($ci_escola)
                        {
                            $this->db->where('tb_escola.ci_escola', $ci_escola);
                        }
                        if ($nm_escola)
                        {
                            $this->db->where("remove_acentos(tb_escola.nm_escola) ilike remove_acentos('%".mb_strtoupper($nm_escola, 'UTF-8')."%')");
                        }
                        if ($nr_inep)
                        {
                            $this->db->where('tb_escola.nr_inep', $nr_inep);
                        }
                        if ($cd_cidade)
                        {
                            $this->db->where('tb_escola.cd_cidade', $cd_cidade);
                        }
                        if ($fl_extencao)
                        {
                            $this->db->where('tb_escola.fl_extencao', $fl_extencao);
                        }
                        if ($fl_localizacao)
                        {
                            $this->db->where('tb_escola.fl_localizacao', $fl_localizacao);
                        }
                        $this->db->order_by('tb_estado.nm_estado', 'ASC');
                        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
                        $this->db->order_by('tb_escola.nm_escola', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_escola      = null,
                                        $nr_inep        = null,
                                        $nm_escola      = null,
                                        $ds_telefone    = null,
                                        $ds_email       = null,
                                        $fl_extencao    = null,
                                        $fl_tpunidade   = null,
                                        $fl_localizacao = null,
                                        $cd_cidade      = null,
                                        $nr_cep         = null,
                                        $ds_rua         = null,
                                        $nr_residencia  = null,
                                        $ds_bairro      = null,
                                        $ds_complemento = null,
                                        $ds_referencia  = null){

        
    return $this->buscar(   $ci_escola,
                            $nr_inep,
                            $nm_escola,
                            $ds_telefone,
                            $ds_email,
                            $fl_extencao,
                            $fl_tpunidade,
                            $fl_localizacao,
                            $cd_cidade,
                            $nr_cep,
                            $ds_rua,
                            $nr_residencia,
                            $ds_bairro,
                            $ds_complemento,
                            $ds_referencia);
    }
    public function excluir($ci_escola)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_escola', $ci_escola);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_escola', $dados);
    }

    public function inserir($ci_escola      = null,
                            $nr_inep        = null,
                            $nm_escola      = null,
                            $ds_telefone    = null,
                            $ds_email       = null,
                            $fl_extencao    = null,
                            $fl_tpunidade   = null,
                            $fl_localizacao = null,
                            $cd_cidade      = null,
                            $nr_cep         = null,
                            $ds_rua         = null,
                            $nr_residencia  = null,
                            $ds_bairro      = null,
                            $ds_complemento = null,
                            $ds_referencia  = null){

        $this->db->where('nr_inep', $nr_inep);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_escola');
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nr_inep']           = $nr_inep;
            $dados['nm_escola']         = $nm_escola;
            $dados['ds_telefone']       = $ds_telefone;
            $dados['ds_email']          = $ds_email;
            $dados['fl_extencao']       = $fl_extencao;
            $dados['fl_tpunidade']      = $fl_tpunidade;
            $dados['fl_localizacao']    = $fl_localizacao;
            $dados['cd_cidade']         = $cd_cidade;
            $dados['nr_cep']            = $nr_cep;
            $dados['ds_rua']            = $ds_rua;
            $dados['nr_residencia']     = $nr_residencia;
            $dados['ds_bairro']         = $ds_bairro;
            $dados['ds_complemento']    = $ds_complemento;
            $dados['ds_referencia']     = $ds_referencia;

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_escola', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_escola      = null,
                            $nr_inep        = null,
                            $nm_escola      = null,
                            $ds_telefone    = null,
                            $ds_email       = null,
                            $fl_extencao    = null,
                            $fl_tpunidade   = null,
                            $fl_localizacao = null,
                            $cd_cidade      = null,
                            $nr_cep         = null,
                            $ds_rua         = null,
                            $nr_residencia  = null,
                            $ds_bairro      = null,
                            $ds_complemento = null,
                            $ds_referencia  = null){

        $this->db->where('nr_inep', $nr_inep);
        $this->db->where('ci_escola <> '.$ci_escola);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_escola');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nr_inep']           = $nr_inep;
            $dados['nm_escola']         = $nm_escola;
            $dados['ds_telefone']       = $ds_telefone;
            $dados['ds_email']          = $ds_email;
            $dados['fl_extencao']       = $fl_extencao;
            $dados['fl_tpunidade']      = $fl_tpunidade;
            $dados['fl_localizacao']    = $fl_localizacao;
            $dados['cd_cidade']         = $cd_cidade;
            $dados['nr_cep']            = $nr_cep;
            $dados['ds_rua']            = $ds_rua;
            $dados['nr_residencia']     = $nr_residencia;
            $dados['ds_bairro']         = $ds_bairro;
            $dados['ds_complemento']    = $ds_complemento;
            $dados['ds_referencia']     = $ds_referencia;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_escola', $ci_escola);
            return $this->db->update('tb_escola', $dados);
//            return true;
        }else{
            return false;
        }

    }

    public function get_id($nr_inep     = null){
        $this->db->select('ci_escola');
        $this->db->from('tb_escola');
        $this->db->where("nr_inep", $nr_inep);
        $this->db->where("fl_ativo = true");                          

        $id = "";                        
        $resultados = $this->db->get()->result();

        foreach ($resultados as $result){
            $id = $result->ci_escola;
        }
        return $id; 
    }
    public function grava_img_db($id, $nm_campo, $nm_img){
        $dados[$nm_campo]   = $nm_img;
        $this->db->where('ci_escola', $id);
        return $this->db->update('tb_escola', $dados);
    }


    public function get_EscolaByCidade($cd_cidade = null, $nr_inep = null){

		$this->db->select('
            tb_escola.ci_escola,
            tb_escola.nr_inep,
			tb_escola.nm_escola');
		$this->db->from('tb_escola');

		if ($cd_cidade)
        {
            $this->db->where('tb_escola.cd_cidade',$cd_cidade);
		}
		if ($nr_inep)
        {
            $this->db->where('tb_escola.nr_inep', $nr_inep);
        }
        $this->db->where('tb_escola.fl_ativo', 'true');
		$this->db->order_by('nm_escola','ASC');

		return $this->db->get()->result();
	}


    // public function selectEscola($cd_cidade = null, $nr_inep = null){

    //     $escolas = $this->get_EscolaByCidade($cd_cidade, $nr_inep);
    //     $options = "";

    //     if (count($escolas) >= 1){
    //         $options = "<option value='0'>Selecione a Escola </option>";
    //     }        
    //     foreach ($escolas as $escola){
    //         if($escola->nr_inep==$nr_inep){
    //             $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."' selected>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
    //         }else{
    //             $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."'>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
    //         }
            
    //     }
    //     return $options;
    // }


    public function selectEscola($cd_cidade = null, $nr_inep = null, $cd_escola = null){

        $escolas = $this->get_EscolaByCidade($cd_cidade, $nr_inep);
        $options = "";

        if (count($escolas) >= 1){
            $options = "<option value='0'>Selecione a Escola </option>";
        }        
        foreach ($escolas as $escola){
            if($escola->ci_escola==$cd_escola){
                $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."' selected>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
            }else{
                if($escola->nr_inep==$nr_inep){
                    $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."' selected>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
                }else{
                    $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."'>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
                }
            }
            
        }
        return $options;
    }


    public function selectEscolaInep($cd_cidade = null, $nr_inep = null){
        
        $escolas = $this->get_EscolaByCidade($cd_cidade, null);
        $options = "";
        
        if (count($escolas) >= 1){
            $options = "<option value='0'>Selecione a Escola </option>";
        }
        foreach ($escolas as $escola){
            if($escola->nr_inep==$nr_inep){
                $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."' selected>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
            }else{
                $options .= "<option value='".$escola->ci_escola."' nr_inep='".$escola->nr_inep."'>".$escola->nr_inep ." - ". $escola->nm_escola."</option>".PHP_EOL;
            }
            
        }
        return $options;
    }


    public function get_Escola($ci_escola = null, $nr_inep = null, $nm_escola = null, $limit = null, $offset = null){

        $this->db->select('
			ci_escola,
			nr_inep,
			nm_escola');
        $this->db->from('tb_escola');

        if ($ci_escola)
            $this->db->where('ci_escola',$ci_escola);
        if ($nr_inep)
            $this->db->where('nr_inep',$nr_inep);
        if ($nm_escola != "")
        $this->db->where("remove_acentos(tb_escola.nm_escola) ilike remove_acentos('%".mb_strtoupper($nm_escola, 'UTF-8')."%')");

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit, 1);
        }

        $this->db->order_by('nm_escola','ASC');

        return $this->db->get()->result();
    }

    public function conta_itens_selecionados($ci_escola = null, $nr_inep = null, $nm_escola = null){

        return count($this->get_Escola($ci_escola, $nr_inep, $nm_escola));
    }
    public function popula_select_consulta_escola($ci_escola = null, $nr_inep = null, $nm_escola = null, $limit = null, $offset = null){

        $results = $this->get_Escola($ci_escola, $nr_inep, $nm_escola, $limit, $offset);

        return $results;
    }
    public function consulta_escola_inep($nr_inep = null){

        $results = $this->get_Escola('', $nr_inep, '');

        $escola = "";
        foreach ($results as $result){
            $escola = $result->nm_escola;
        }

        return $escola;

    }

    public function buscaEscolaUsuario($params){
        
            $sql=" select e.* from tb_usuario u 
                      inner join tb_usuarioescolas ue on u.ci_usuario=ue.cd_usuario 
                      inner join tb_escola e on ue.cd_escola=e.ci_escola
              where 1=1 and e.fl_ativo=true";

            if(isset($params['ci_usuario'])){
                $sql.=" and u.ci_usuario=".$params['ci_usuario'];
            }
            
            $escola['ci_escola']=isset($params['ci_escola'])?($params['ci_escola']):0;
            
            //print_r($escola);echo';';
            if($escola['ci_escola']!=0 ) {
         
                //print_r($escola);die;
                $listaescolas=implode(",",$escola);             
                //print_r($listaescolas);die;
                $sql .= " and e.ci_escola in (" . $listaescolas.")";
                
            }    
            $query=$this->db->query($sql);
            return $query->result();

    }
    
    public function buscaArrayEscolaUsuario($params){
        
        $sql=" select e.* from tb_usuario u
                      inner join tb_usuarioescolas ue on u.ci_usuario=ue.cd_usuario
                      inner join tb_escola e on ue.cd_escola=e.ci_escola
              where 1=1  and e.fl_ativo=true";
        
        if(isset($params['ci_usuario'])){
            $sql.=" and u.ci_usuario=".$params['ci_usuario'];
        }
        
        if(isset($params['cd_cidade'])){
            $sql.=" and e.cd_cidade=".$params['cd_cidade'];
        }
        
        
        if(isset($params['ci_usuario'])){
            $sql.=" and u.ci_usuario=".$params['ci_usuario'];
        }
                
        if( sizeof($params['ci_escola'])>0 ) {
            $listaescolas=implode(",",$params['ci_escola']);            
            $sql .= " and e.ci_escola in (" . $listaescolas.")";            
        }
        $query=$this->db->query($sql);
        return $query->result();
        
    }
    
    public function buscaEscolas($params){
        
        $sql=" select e.* from tb_usuario u
                      inner join tb_usuarioescolas ue on u.ci_usuario=ue.cd_usuario
                      inner join tb_escola e on ue.cd_escola=e.ci_escola
              where 1=1  and e.fl_ativo=true";
        
        if(isset($params['ci_usuario'])){
            $sql.=" and u.ci_usuario=".$params['ci_usuario'];
        }
        $listaescolas=implode(',',$params['ci_escola']);
        
        if(isset($params['ci_escola'])) {
            $sql .= " and e.ci_escola in (" . $listaescolas.");";
        }
        
        $query=$this->db->query($sql);
        return $query->result();
        
    }
}