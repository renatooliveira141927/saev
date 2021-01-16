<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Avaliacao_uploads_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function buscar_matrizes( $ci_avaliacao_upload = null){

        $this->db->select(' tb_avaliacao_matriz.cd_avaliacao_upload, 
                            tb_avaliacao_matriz.cd_matriz_descritor, 
                            tb_avaliacao_matriz.nr_opcaocorreta, 
                            tb_matriz_descritor.ds_codigo, 
                            tb_matriz_descritor.nm_matriz_descritor
                        ');

        $this->db->from('tb_avaliacao_matriz');
        $this->db->join('tb_matriz_descritor', 'tb_matriz_descritor.ci_matriz_descritor = tb_avaliacao_matriz.cd_matriz_descritor', 'left');

        $this->db->where('tb_avaliacao_matriz.cd_avaliacao_upload', $ci_avaliacao_upload);

        $this->db->where('tb_avaliacao_matriz.fl_ativo', 'true');

        $this->db->order_by('nr_questao', 'ASC');

        return $this->db->get()->result();
    }

    public function buscar_municipios( $ci_avaliacao_upload = null){

        $this->db->select(' tb_avaliacao_cidade.ci_avaliacao_cidade,
                            tb_avaliacao_cidade.cd_cidade, 
                            tb_estado.nm_estado, 
                            tb_cidade.nm_cidade,
                            to_char(tb_avaliacao_cidade.dt_caderno,\'dd/mm/yyyy\') as dt_caderno,
                            to_char(tb_avaliacao_cidade.dt_inicio,\'dd/mm/yyyy\') as dt_inicio,
                            to_char(tb_avaliacao_cidade.dt_final,\'dd/mm/yyyy\') as dt_final,
                            tb_avaliacao_cidade.cd_avaliacao_upload,                            
                        ');
        $this->db->from('tb_avaliacao_cidade');
        $this->db->join('tb_cidade', 'tb_cidade.ci_cidade = tb_avaliacao_cidade.cd_cidade');
        $this->db->join('tb_estado', 'tb_estado.ci_estado = tb_cidade.cd_estado');

        $this->db->where('tb_avaliacao_cidade.cd_avaliacao_upload', $ci_avaliacao_upload);
        $this->db->order_by('tb_estado.nm_estado', 'ASC');
        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');

        return $this->db->get()->result();
    }
    public function count_buscar(   $ci_avaliacao_upload = null,
                                    $nm_caderno          = null,
                                    $cd_avalia_tipo      = null,
                                    $cd_disciplina       = null,
                                    $cd_etapa            = null,
                                    $cd_edicao           = null,
                                    $fl_tipoavaliacao    = null,
                                    $relatorio           = null,
                                    $limit               = null,
                                    $offset              = null,
                                    $cd_escola           = null){


        return count($this->buscar( $ci_avaliacao_upload,
                                    $nm_caderno,                                    
                                    $cd_avalia_tipo,
                                    $cd_disciplina,
                                    $cd_etapa,
                                    $cd_edicao,
                                    $fl_tipoavaliacao,
                                    '',
                                    '',
                                    '',
                                    $cd_escola));
    }
    public function buscar( $ci_avaliacao_upload = null,
                            $nm_caderno          = null,
                            $cd_avalia_tipo      = null,
                            $cd_disciplina       = null,
                            $cd_etapa            = null,
                            $cd_edicao           = null,
                            $fl_tipoavaliacao    = null,
                            $relatorio           = null,
                            $limit               = null,
                            $offset              = null,
                            $cd_escola           = null){

        $this->db->select(' tb_avaliacao_upload.ci_avaliacao_upload,
                            tb_avaliacao_upload.nm_caderno,
                            tb_avaliacao_upload.cd_avalia_tipo,
                            tb_avaliacao_upload.cd_disciplina,
                            tb_avaliacao_upload.cd_etapa,
                            tb_avaliacao_upload.cd_edicao,
                            tb_avaliacao_upload.ci_matriz,
                            tb_matriz.nm_matriz,
                            tb_avaliacao_upload.ds_arquivo_avaliacao,
                            tb_avaliacao_upload.ds_arquivo_aplicador,
                            tb_avaliacao_upload.dt_inicio,
                            tb_avaliacao_upload.dt_final,
                            tb_avalia_tipo.nm_avalia_tipo,
                            tb_disciplina.nm_disciplina,
                            tb_etapa.nm_etapa,
                            tb_edicao".nm_edicao,
                            (select 
                            case when now()>tb_avaliacao_cidade.dt_inicio then \'BLOQUEIA\' else \'LIBERA\' end as editamatriz
                            from tb_avaliacao_cidade where cd_avaliacao_upload=tb_avaliacao_upload.ci_avaliacao_upload limit 1) as editamatriz ');  
        $this->db->from('tb_avaliacao_upload');
        $this->db->join('tb_avalia_tipo', 'tb_avaliacao_upload.cd_avalia_tipo   = tb_avalia_tipo.ci_avalia_tipo');
        $this->db->join('tb_disciplina', 'tb_avaliacao_upload.cd_disciplina     = tb_disciplina.ci_disciplina');
        $this->db->join('tb_etapa', 'tb_avaliacao_upload.cd_etapa               = tb_etapa.ci_etapa');
        $this->db->join('tb_edicao', 'tb_avaliacao_upload.cd_edicao             = tb_edicao.ci_edicao');
        $this->db->join('tb_matriz', 'tb_matriz.ci_matriz   = tb_avaliacao_upload.ci_matriz', 'left');

        if ($this->session->userdata('ci_grupousuario') != 1){

            $this->db->join('tb_avaliacao_cidade', 'tb_avaliacao_cidade.cd_avaliacao_upload = tb_avaliacao_upload.ci_avaliacao_upload');
            $this->db->where('tb_avaliacao_cidade.cd_cidade', $this->session->userdata('cd_cidade_sme'));
        }

        $this->db->where('tb_avaliacao_upload.fl_ativo', 'true');

        if ($ci_avaliacao_upload)
        {
            $this->db->where('tb_avaliacao_upload.ci_avaliacao_upload', $ci_avaliacao_upload);
        }
        if ($nm_caderno)
        {
            $condicao="tb_avaliacao_upload.nm_caderno ilike'%".$nm_caderno."%' ";
            $this->db->where($condicao);
        }
        if ($fl_tipoavaliacao)
        {
            $this->db->where('tb_avaliacao_upload.fl_tipoavaliacao', $fl_tipoavaliacao);
        }
        if ($cd_avalia_tipo)
        {
            $this->db->where('tb_avaliacao_upload.cd_avalia_tipo', $cd_avalia_tipo);
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_avaliacao_upload.cd_disciplina', $cd_disciplina);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_avaliacao_upload.cd_etapa', $cd_etapa);
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_avaliacao_upload.cd_edicao', $cd_edicao);
        }
        $this->db->order_by('tb_edicao.nm_edicao', 'ASC');
        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');
        $this->db->order_by('tb_avalia_tipo.nm_avalia_tipo', 'ASC');
        $this->db->order_by('tb_etapa.nm_etapa', 'ASC');

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

    public function get_consulta_excel( $ci_avaliacao_upload = null,
                                        $nm_caderno          = null,
                                        $cd_avalia_tipo      = null,
                                        $cd_disciplina       = null,
                                        $cd_etapa            = null,
                                        $cd_edicao           = null,
                                        $fl_tipoavaliacao    = null,
                                        $relatorio          = null,
                                        $limit              = null,
                                        $offset             = null,
                                        $cd_escola          = null){

                        $this->db->select(' tb_avaliacao_upload.ci_avaliacao_upload,
                                            tb_avaliacao_upload.nm_caderno,
                                            tb_avaliacao_upload.cd_avalia_tipo,
                                            tb_avaliacao_upload.cd_disciplina,
                                            tb_avaliacao_upload.cd_etapa,
                                            tb_avaliacao_upload.cd_edicao,
                                            tb_avalia_tipo.nm_avalia_tipo,
                                            tb_disciplina.nm_disciplina,
                                            tb_etapa.nm_etapa,
                                            tb_edicao".nm_edicao');  
                        $this->db->from('tb_avaliacao_upload');
                
                        $this->db->join('tb_avalia_tipo', 'tb_avaliacao_upload.cd_avalia_tipo   = tb_avalia_tipo.ci_avalia_tipo');
                        $this->db->join('tb_disciplina', 'tb_avaliacao_upload.cd_disciplina     = tb_disciplina.ci_disciplina');
                        $this->db->join('tb_etapa', 'tb_avaliacao_upload.cd_etapa               = tb_etapa.ci_etapa');
                        $this->db->join('tb_edicao', 'tb_avaliacao_upload.cd_edicao             = tb_edicao.ci_edicao');
                     
                        $this->db->where('tb_avaliacao_upload.fl_ativo', 'true');
                
                        if ($ci_avaliacao_upload)
                        {
                            $this->db->where('tb_avaliacao_upload.ci_avaliacao_upload', $ci_avaliacao_upload);
                        }
                        if ($nm_caderno)
                        {
                            $this->db->where('tb_avaliacao_upload.nm_caderno', $nm_caderno);
                        }
                        if ($fl_tipoavaliacao)
                        {
                            $this->db->where('tb_avaliacao_upload.fl_tipoavaliacao', $fl_tipoavaliacao);
                        }
                        if ($cd_avalia_tipo)
                        {
                            $this->db->where('tb_avaliacao_upload.cd_avalia_tipo', $cd_avalia_tipo);
                        }
                        if ($cd_disciplina)
                        {
                            $this->db->where('tb_avaliacao_upload.cd_disciplina', $cd_disciplina);
                        }
                        if ($cd_etapa)
                        {
                            $this->db->where('tb_avaliacao_upload.cd_etapa', $cd_etapa);
                        }
                        if ($cd_edicao)
                        {
                            $this->db->where('tb_avaliacao_upload.cd_edicao', $cd_edicao);
                        }
                        $this->db->order_by('tb_edicao.nm_edicao', 'ASC');
                        $this->db->order_by('tb_disciplina.nm_disciplina', 'ASC');
                        $this->db->order_by('tb_avalia_tipo.nm_avalia_tipo', 'ASC');
                        $this->db->order_by('tb_etapa.nm_etapa', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_avaliacao_upload = null,
                                        $nm_caderno          = null,
                                        $cd_avalia_tipo      = null,
                                        $cd_disciplina       = null,
                                        $cd_etapa            = null,
                                        $cd_edicao           = null,
                                        $fl_tipoavaliacao    = null){

        
    return $this->buscar(   $ci_avaliacao_upload,
                            $nm_caderno,
                            $cd_avalia_tipo,
                            $cd_disciplina,
                            $cd_etapa,
                            $cd_edicao,
                            $fl_tipoavaliacao);
    }
    public function excluir($ci_avaliacao_upload)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_avaliacao_upload', $ci_avaliacao_upload);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_avaliacao_upload', $dados);
    }

    public function inserir($nm_caderno             = null,
                            $cd_avalia_tipo         = null,
                            $cd_edicao              = null,
                            // $nr_ano                 = null,
                            $cd_disciplina          = null,
                            $cd_etapa               = null,
                            $ds_codigo              = null,
                            $ci_matriz              = null,
                            $cd_matriz_descritor    = null,
                            //$cd_cidade_participante = null,
                            $nr_opcaocorreta        = null,
                            //$dt_inicio              = null,
                            //$dt_final               = null
                            $estados,
                            $municipios,
                            $dt_caderno,
                            $dt_inicio,
                            $dt_final){

        if ($nm_caderno){
            $this->db->where('nm_caderno', $nm_caderno);
        }

        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_avaliacao_upload');
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_caderno']       = $nm_caderno;
            $dados['cd_avalia_tipo']   = $cd_avalia_tipo;
            $dados['cd_edicao']        = $cd_edicao;
            // $dados['nr_ano']           = $nr_ano;
            $dados['cd_disciplina']    = $cd_disciplina;
            $dados['cd_etapa']         = $cd_etapa;

            //$dados['dt_inicio']        = $dt_inicio;
            //$dados['dt_final']         = $dt_final;
            $dados['ci_matriz']        = $ci_matriz;
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_avaliacao_upload', $dados);

            $this->db->select('ci_avaliacao_upload');
            $this->db->from('tb_avaliacao_upload');
            $this->db->where('upper(nm_caderno)', mb_strtoupper($nm_caderno, 'UTF-8'));
            $this->db->where('fl_ativo', 'true');
            $result = $this->db->get()->result();

            $ci_avaliacao_upload = '';
            foreach ($result as $i => $row) {
                $ci_avaliacao_upload = $row ->ci_avaliacao_upload;
            }
            
            if ($cd_matriz_descritor != ''){
                            
                // Inicio - Inserir matrizes
                foreach ($cd_matriz_descritor as $i => $value) {
                    $dados_matriz['cd_avaliacao_upload']    = $ci_avaliacao_upload;
                    if ($value){
                        $dados_matriz['cd_matriz_descritor']= $value;
                    }else{
                        $dados_matriz['cd_matriz_descritor']= null;
                    }
                    $dados_matriz['nr_questao']             = $i+1;
                    $dados_matriz['nr_opcaocorreta']        = $nr_opcaocorreta[$i];
                    $this->db->insert('tb_avaliacao_matriz', $dados_matriz);
                } 
                // Fim - Inserir matrizes 
            }
           
            if ($estados != ''){                
                // Inicio - Inserir cidades    
                foreach ($estados as $i => $value) {
                    $dados_cidade['cd_avaliacao_upload']    = $ci_avaliacao_upload;
                    $dados_cidade['cd_estado']              = $value;
                    $dados_cidade['cd_cidade']              = $municipios[$i];

                    $dados_cidade['dt_caderno']             = implode('/',array_reverse(explode('/',$dt_caderno[$i])));
                    $dados_cidade['dt_inicio']              = implode('/',array_reverse(explode('/',$dt_inicio[$i])));
                    $dados_cidade['dt_final']               = implode('/',array_reverse(explode('/',$dt_final[$i])));

                    //$dados_cidade['dt_caderno']             = $dt_caderno[$i];
                    //$dados_cidade['dt_inicio']              = $dt_inicio[$i];
                    //$dados_cidade['dt_final']               = $dt_final[$i];
                    $this->db->insert('tb_avaliacao_cidade', $dados_cidade);
                    //print_r($dados_cidade);
                } 
                //die;
                // Fim - Inserir cidades 
            }
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_avaliacao_upload    = null,
                            $nm_caderno             = null,
                            $cd_avalia_tipo         = null,
                            $cd_edicao              = null,
                            // $nr_ano                 = null,
                            $cd_disciplina          = null,
                            $cd_etapa               = null,
                            $ds_arquivo_avaliacao   = null,
                            $ds_arquivo_aplicador   = null,
                            $ds_codigo              = null,
                            //$ci_matriz              = null,
                            $cd_matriz_descritor    = null,
                            $cd_cidade_participante = null,
                            $nr_opcaocorreta        = null,
        $estados        = null,
        $municipios        = null,
        $dt_caderno        = null,
        $dt_inicio        = null,
        $dt_final        = null){

        if ($nm_caderno){
            $this->db->where('upper(nm_caderno)', mb_strtoupper($nm_caderno, 'UTF-8'));
        }
        
        $this->db->where('ci_avaliacao_upload <> '.$ci_avaliacao_upload);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_avaliacao_upload');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_caderno']            = $nm_caderno;
            $dados['cd_avalia_tipo']        = $cd_avalia_tipo;
            $dados['cd_edicao']             = $cd_edicao;
            // $dados['nr_ano']                = $nr_ano;
            $dados['cd_disciplina']         = $cd_disciplina;
            $dados['cd_etapa']              = $cd_etapa;
            $dados['ds_arquivo_avaliacao']  = $ds_arquivo_avaliacao;
            $dados['ds_arquivo_aplicador']  = $ds_arquivo_aplicador;

            //$dados['dt_inicio']        = $dt_inicio;
            //$dados['dt_final']         = $dt_final;
            //$dados['ci_matriz']        = $ci_matriz;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_avaliacao_upload', $ci_avaliacao_upload);
            $this->db->update('tb_avaliacao_upload', $dados);
            
            if ($cd_matriz_descritor && $editarmatriz!='BLOQUEIA'){
                // Apagar matrizes anteriores
                $dados_delecao_matriz['fl_ativo']        = false;
                $dados_delecao_matriz['cd_usuario_del']  = $this->session->userdata('ci_usuario');
                $dados_delecao_matriz['dt_exclusao']     = "now()";

                $this->db->where('cd_avaliacao_upload', $ci_avaliacao_upload);
                $this->db->update('tb_avaliacao_matriz', $dados_delecao_matriz);

                // Inserir matrizes    
                foreach ($cd_matriz_descritor as $i => $value) {
                    $dados_matriz['cd_avaliacao_upload']     = $ci_avaliacao_upload;
                    if ($value){
                        $dados_matriz['cd_matriz_descritor'] = $value;
                    }else{
                        $dados_matriz['cd_matriz_descritor'] = null;
                    }
                    $dados_matriz['nr_questao']             = $i+1;
                    $dados_matriz['nr_opcaocorreta']        = $nr_opcaocorreta[$i];
                    
                    $this->db->insert('tb_avaliacao_matriz', $dados_matriz);
                } 
            }
            
            if ($estados != ''){                           
                //$this->db->where('cd_avaliacao_upload', $ci_avaliacao_upload);
                //$this->db->delete('tb_avaliacao_cidade');
                // Inicio - Inserir cidades
                //print_r($estados);die;
                foreach ($estados as $i => $value) {
                    
                    
                    $this->db->where('cd_avaliacao_upload', $ci_avaliacao_upload);
                    $this->db->where('cd_cidade', $municipios[$i]);
                    $this->db->from('tb_avaliacao_cidade');
                    
                    if (!($this->db->get()->num_rows() > 0)){
                        $dados_cidade['cd_avaliacao_upload']    = $ci_avaliacao_upload;
                        $dados_cidade['cd_estado']              = $value;
                        $dados_cidade['cd_cidade']              = $municipios[$i];
                    
                        $dados_cidade['dt_caderno']             = implode('/',array_reverse(explode('/',$dt_caderno[$i])));
                        $dados_cidade['dt_inicio']              = implode('/',array_reverse(explode('/',$dt_inicio[$i])));
                        $dados_cidade['dt_final']               = implode('/',array_reverse(explode('/',$dt_final[$i])));
                        $this->db->insert('tb_avaliacao_cidade', $dados_cidade);                    
                    }
                }
                // Fim - Inserir cidades
            }
            
            return true;
        }else{
            return false;
        }

    }

    public function get_id($nm_caderno = null, $cd_avalia_tipo = null, $cd_disciplina = null, $cd_etapa = null, $cd_edicao = null){
        $this->db->select('ci_avaliacao_upload');
        $this->db->from('tb_avaliacao_upload');
        if ($nm_caderno){
            $this->db->where("nm_caderno"      , $nm_caderno);
        }else{
            $this->db->where("cd_avalia_tipo"   , $cd_avalia_tipo);
            $this->db->where("cd_disciplina"    , $cd_disciplina);
            $this->db->where("cd_etapa"         , $cd_etapa);
            $this->db->where("cd_edicao"        , $cd_edicao);
        }       
        
        $this->db->where("fl_ativo = true");                          

        $id = "";                        
        $resultados = $this->db->get()->result();

        foreach ($resultados as $result){
            $id = $result->ci_avaliacao_upload;
        }
        return $id; 
    }
    public function grava_pdf_db($id, $nm_campo, $nm_pdf){
        $dados[$nm_campo]   = $nm_pdf;
        $this->db->where('ci_avaliacao_upload', $id);
        return $this->db->update('tb_avaliacao_upload', $dados);
    }

    public function alteradatas($params){  
        $dados=[]; 
        if(isset($params['inicio'])){
            $dados['dt_inicio']   =implode('/',array_reverse(explode('/',$params['inicio'])));                 
        }        
        if(isset($params['fim'])){
            $dados['dt_final']   =implode('/',array_reverse(explode('/',$params['fim'])));                 
        }
    
        if( isset($params['chave']) && (sizeof($dados)>0) ){
            $this->db->where('ci_avaliacao_cidade', $params['chave']);

            if($this->db->update('tb_avaliacao_cidade', $dados)>0){
                return true;
            }else{
                return false;
            };
        }        
    }
}