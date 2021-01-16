<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Alunos_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function buscar( $params ){        
        
        $this->db->select(' tb_aluno.*,
                            usu_cad.ci_usuario as "ci_usuario_cad",
                            usu_cad.nm_usuario as "nm_usuario_cad",
                            usu_alt.ci_usuario as "ci_usuario_alt",
                            usu_alt.nm_usuario as "nm_usuario_alt",
                            usu_del.ci_usuario as "ci_usuario_del",
                            usu_del.nm_usuario as "nm_usuario_del",
                            usu_rea.ci_usuario as "ci_usuario_rea",
                            usu_rea.nm_usuario as "nm_usuario_rea",
                            tb_ultimaenturmacao.cd_turma,
                            tb_ultimaenturmacao.ci_ultimaenturmacao,
                            tb_turma.nm_turma,
                            tb_turma.cd_etapa,
                            tb_turma.nr_ano_letivo,
                            tb_etapa.nm_etapa,
                            "tb_turno".ci_turno,
                            "tb_turno".nm_turno,
                            tb_cidade.nm_cidade,
                            tb_cidade.cd_estado,
                            tb_estado.nm_estado,
                            tb_escola.ci_escola,
                            tb_escola.nr_inep as  nr_inep_escola,
                            tb_escola.nm_escola as escola,
                            cidade_sme.ci_cidade as ci_cidade_sme,
                            cidade_sme.nm_cidade as nm_cidade_sme,
                            estado_sme.ci_estado as ci_estado_sme,
                            estado_sme.nm_estado as nm_estado_sme');  
        $this->db->from('tb_aluno');
        $this->db->join('tb_escola', 'tb_aluno.cd_escola = tb_escola.ci_escola');
        $this->db->join('tb_cidade as cidade_sme', 'cidade_sme.ci_cidade = tb_escola.cd_cidade');
        $this->db->join('tb_estado as estado_sme', 'estado_sme.ci_estado = cidade_sme.cd_estado');

        $this->db->join('tb_ultimaenturmacao', 'tb_aluno.ci_aluno = tb_ultimaenturmacao.cd_aluno', 'left');

        $this->db->join('tb_usuario usu_cad', 'tb_aluno.cd_usuario_cad = usu_cad.ci_usuario', 'left');        
        $this->db->join('tb_usuario usu_alt', 'tb_aluno.cd_usuario_alt = usu_alt.ci_usuario', 'left');
        $this->db->join('tb_usuario usu_del', 'tb_aluno.cd_usuario_del = usu_del.ci_usuario', 'left');
        $this->db->join('tb_usuario usu_rea', 'tb_aluno.cd_usuario_rea = usu_rea.ci_usuario', 'left');

        if ( (isset($params['cd_turma'])) || (isset($params['cd_ano_letivo'])))
        {
            
            if (isset($params['cd_ano_letivo'])){
                $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma and tb_turma.nr_ano_letivo='.$params['cd_ano_letivo']);
            }else{
                $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma');
            }
            
        }else{            
            $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma', 'left');
        }

        if (isset($params['cd_turno']))
        {
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        }else{
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno', 'left');
        }
        if (isset($params['cd_etapa']))
        {
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        }else{
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa', 'left');
        }
        $this->db->join('tb_cidade', 'tb_aluno.cd_cidade = tb_cidade.ci_cidade', 'left');
        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado', 'left');
        if (isset($params['fl_ativo']))
        {
            $this->db->where('tb_aluno.fl_ativo', $params['fl_ativo']);        
        }
        if (isset($params['ci_aluno']))
        {
            $this->db->where('tb_aluno.ci_aluno', $params['ci_aluno']);
        }
        if (isset($params['nr_inep_aluno']))
        {
            $this->db->where("tb_aluno.nr_inep ilike '%".$params['nr_inep_aluno']."%'");
        }
        if (isset($params['nm_aluno']))
        {
            $this->db->where("remove_acentos(tb_aluno.nm_aluno) ilike remove_acentos('%".mb_strtoupper($params['nm_aluno'], 'UTF-8')."%')");
        }
        if (isset($params['cd_turma']))
        {
            $this->db->where('tb_turma.ci_turma', $params['cd_turma']);
        }
        if (isset($params['cd_etapa']))
        {
            $this->db->where('tb_etapa.ci_etapa', $params['cd_etapa']);
        }
        if (isset($params['cd_turno']))
        {
            $this->db->where('tb_turno.ci_turno', $params['cd_turno']);
        }
        if (isset($params['cd_cidade']))
        {
            $this->db->where('tb_escola.cd_cidade', $params['cd_cidade']);
        }        
        if (isset($params['fl_rede']) && isset($params['cd_escola']) && ($params['fl_rede']=='true') && isset($params['cd_escola']) )
        {
            $this->db->where('tb_aluno.cd_escola', $params['cd_escola']);
        }
            
        $this->db->order_by('tb_estado.nm_estado', 'ASC');
        $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
        $this->db->order_by('tb_aluno.nm_aluno', 'ASC');

        $retorno =$this->db->get()->result();

        //echo $this->db->last_query();die; //Exibeo comando SQL
        return $retorno;
    }

    public function gravar_filtros( $params ){

        $this->db->where('cd_usuario', $params['cd_usuario']);
        $this->db->delete('tb_aluno_filtros');

        return $this->db->insert('tb_aluno_filtros', $params);
    }
    public function gravar_cabecalho( $params ){

        $this->db->where('cd_usuario', $params['cd_usuario']);
        $this->db->delete('tb_aluno_cabecalho');

        return $this->db->insert('tb_aluno_cabecalho', $params);
    }

    public function busca_cabecalho( $id ) {

        $sql=" select * from tb_aluno_cabecalho where cd_usuario =".$id;                
        $query  =   $this->db->query($sql);
        return $query->result();
    }

    public function busca_filtros( $id ) {

        $sql=" select * from tb_aluno_filtros where cd_usuario =".$id;                
        $query  =   $this->db->query($sql);
        return $query->result();
    }
    public function inserir( $params ){

        if ( isset( $params['nr_inep'] ) ){
            $this->db->where('nr_inep', $params['nr_inep']);
        }else{
            $this->db->where("tb_aluno.nm_aluno = '".mb_strtoupper( $params['nm_aluno'] , 'UTF-8')."'");
            $this->db->where("tb_aluno.nm_mae = '".mb_strtoupper( $params['nm_mae'], 'UTF-8')."'");
            $this->db->where('"tb_aluno".dt_nascimento', $params['dt_nascimento'] );
        }

        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_aluno');
        
        if (!($this->db->get()->num_rows() > 0)){

            $params['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_aluno', $params);
            
            return true;
        }else{
            return false;
        }

    }

    public function alterar( $params ){

        if ( isset( $params['nr_inep'] ) ){
            $this->db->where('nr_inep', $params['nr_inep']);
        }else{
            $this->db->where("tb_aluno.nm_aluno = '".mb_strtoupper( $params['nm_aluno'] , 'UTF-8')."'");
            $this->db->where("tb_aluno.nm_mae = '".mb_strtoupper( $params['nm_mae'] , 'UTF-8')."'");
            $this->db->where('"tb_aluno".dt_nascimento', $params['dt_nascimento'] );
        }
        
        $this->db->where('ci_aluno <> '.$params['ci_aluno'] );
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_aluno');

        if (!($this->db->get()->num_rows() > 0)){
            
            $params['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $params['dt_alteracao']    = "now()";
                        
            $this->db->where('ci_aluno', $params['ci_aluno'] );
            return $this->db->update('tb_aluno', $params);
//            return true;
        }else{
            return false;
        }

    }
    
    public function excluir($id){

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_aluno', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_aluno', $dados);
    }

    public function reativar($id){

        $dados['fl_ativo']        = true;
        $dados['cd_usuario_rea']  = $this->session->userdata('ci_usuario');
        $dados['dt_reativacao']   = "now()";

        $this->db->where('ci_aluno', $id);
        $this->db->where('fl_ativo', 'false');
        return $this->db->update('tb_aluno', $dados);
    }

    public function buscar_aluno_transferencia( $ci_aluno           = null,
                                                $nr_inep            = null,
                                                $nm_aluno           = null,
                                                $cd_cidade          = null,
                                                $cd_turma           = null,
                                                $cd_etapa           = null,
                                                $cd_turno           = null,
                                                $cd_escola          = null){

        $this->db->select(" tb_aluno.ci_aluno,
                            tb_aluno.nr_inep,
                            tb_aluno.nm_aluno,
                            tb_aluno.nm_mae,
                            to_char(tb_aluno.dt_nascimento, 'DD/MM/YYYY') as dt_nascimento,
                            tb_escola.ci_escola,
                            tb_escola.nr_inep as nr_inep_escola,
                            tb_escola.nm_escola,
                            tb_turma.nm_turma,                            
                            tb_etapa.nm_etapa,
                            tb_turno.nm_turno");
        $this->db->from('tb_aluno');
        $this->db->join('tb_escola', 'tb_aluno.cd_escola = tb_escola.ci_escola');        
        $this->db->join('tb_ultimaenturmacao', 'tb_aluno.ci_aluno = tb_ultimaenturmacao.cd_aluno', 'left');

        if ($cd_turma)
        {
            $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma');
        }else{
            $this->db->join('tb_turma', 'tb_ultimaenturmacao.cd_turma = tb_turma.ci_turma', 'left');
        }
       
        if ($cd_turno)
        {
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        }else{
            $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno', 'left');
        }
        if ($cd_etapa)
        {
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        }else{
            $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa', 'left');
        }

        $this->db->where('tb_aluno.fl_ativo', 'true');
        $this->db->where('tb_turma.fl_ativo', 'true');
        //$this->db->where('tb_enturmacao.fl_ativo', 'true');

        if ($ci_aluno)
        {
            $this->db->where('tb_aluno.ci_aluno', $ci_aluno);
        }
        if ($nr_inep)
        {
            $this->db->where("tb_aluno.nr_inep ilike '%".$nr_inep."%'");
        }
        if ($nm_aluno)
        {
            $this->db->where("remove_acentos(tb_aluno.nm_aluno) ilike remove_acentos('%".mb_strtoupper($nm_aluno, 'UTF-8')."%')");
        }
        if ($cd_turma)
        {
            $this->db->where('tb_turma.ci_turma', $cd_turma);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_etapa.ci_etapa', $cd_etapa);
        }
        if ($cd_turno)
        {
            $this->db->where('tb_turno.ci_turno', $cd_turno);
        }
        if ($cd_escola)
        {
            $this->db->where('tb_aluno.cd_escola', $cd_escola);
        }
        
        $this->db->order_by('tb_aluno.nm_aluno', 'ASC');

        return $this->db->get()->result();
        
    }

    public function get_id( $params ){
        $this->db->select('ci_aluno');
        $this->db->from('tb_aluno');
        if ( isset( $params['nr_inep']) ){
            $this->db->where("nr_inep"      , $params['nr_inep']);
        }else{
            $this->db->where("nm_aluno"     , $params['nm_aluno']);
            $this->db->where("nm_mae"       , $params['nm_mae']);
            $this->db->where("dt_nascimento", $params['dt_nascimento']);
        }       
        
        $this->db->where("fl_ativo = true");                          

        $id = "";                        
        $resultados = $this->db->get()->result();

        foreach ($resultados as $result){
            $id = $result->ci_aluno;
        }
        return $id; 
    }
    public function grava_img_db($id, $nm_campo, $nm_img){
        $dados[$nm_campo]   = $nm_img;
        $this->db->where('ci_aluno', $id);
        return $this->db->update('tb_aluno', $dados);
    }


    public function consultaAnos($cd_escola){
        $sql = "select distinct nr_ano_letivo as ano from tb_turma "
               ."where fl_ativo=true and cd_escola=" . $cd_escola
               ." order by 1 desc;";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function selectAnosTurmas($cd_escola, $cd_ano_letivo){
        $anos = $this->consultaAnos($cd_escola);        

        $options = "";
        foreach ($anos as $ano){
            if ($ano->ano == $cd_ano_letivo){
                $options .= "<option selected value='{$ano->ano}'>{$ano->ano}</option>".PHP_EOL;
            }else{
                $options .= "<option value='{$ano->ano}'>{$ano->ano}</option>".PHP_EOL;
            }
            
        }
        return $options;
    }
    
    //reincluido em 04022020
    public function count_buscar(   $ci_aluno           = null,
        $nr_inep            = null,
        $nm_aluno           = null,
        $nm_mae             = null,
        $nm_pai             = null,
        $nm_responsavel     = null,
        $dt_nascimento      = null,
        $ds_email           = null,
        $fl_sexo            = null,
        $ds_telefone1       = null,
        $ds_telefone2       = null,
        $cd_cidade          = null,
        $nr_cep             = null,
        $ds_rua             = null,
        $nr_residencia      = null,
        $ds_bairro          = null,
        $ds_complemento     = null,
        $ds_referencia      = null,
        $cd_turma           = null,
        $cd_etapa           = null,
        $cd_turno           = null,
        $cd_escola          = null){
            
            
            return count($this->buscar( $ci_aluno,
                $nr_inep,
                $nm_aluno,
                $nm_mae,
                $nm_pai,
                $nm_responsavel,
                $dt_nascimento,
                $ds_email,
                $fl_sexo,
                $ds_telefone1,
                $ds_telefone2,
                $cd_cidade,
                $nr_cep,
                $ds_rua,
                $nr_residencia,
                $ds_bairro,
                $ds_complemento,
                $ds_referencia,
                $cd_turma,
                $cd_etapa,
                $cd_turno,
                $cd_escola));
    }
    
    public function count_buscar_aluno_transferencia(   $ci_aluno           = null,
        $nr_inep            = null,
        $nm_aluno           = null,
        $cd_cidade          = null,
        $cd_turma           = null,
        $cd_etapa           = null,
        $cd_turno           = null,
        $cd_escola          = null){
            
            
            return count($this->buscar_aluno_transferencia( $ci_aluno,
                $nr_inep,
                $nm_aluno,
                $cd_cidade,
                $cd_turma,
                $cd_etapa,
                $cd_turno,
                $cd_escola));
    }
    
    public function get_consulta_excel( $ci_aluno           = null,
        $nr_inep            = null,
        $nm_aluno           = null,
        $nm_mae             = null,
        $nm_pai             = null,
        $nm_responsavel     = null,
        $dt_nascimento      = null,
        $ds_email           = null,
        $fl_sexo            = null,
        $ds_telefone1       = null,
        $ds_telefone2       = null,
        $cd_cidade          = null,
        $nr_cep             = null,
        $ds_rua             = null,
        $nr_residencia      = null,
        $ds_bairro          = null,
        $ds_complemento     = null,
        $ds_referencia      = null,
        $cd_turma           = null,
        $cd_etapa           = null,
        $cd_turno           = null,
        $relatorio          = null,
        $limit              = null,
        $offset             = null,
        $cd_escola          = null){
            
            $this->db->select(' tb_aluno.*,
                                            tb_cidade.nm_cidade,
                                            tb_cidade.cd_estado,
                                            tb_estado.nm_estado');
            $this->db->from('tb_aluno');
            $this->db->join('tb_cidade', 'tb_aluno.cd_cidade = tb_cidade.ci_cidade');
            $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');
            $this->db->where('tb_aluno.fl_ativo', 'true');
            if ($ci_aluno)
            {
                $this->db->where('tb_aluno.ci_aluno', $ci_aluno);
            }
            if ($nr_inep)
            {
                $this->db->where("tb_aluno.nr_inep ilike '%".$nr_inep."%'");
            }
            if ($nm_aluno)
            {
                $this->db->where("remove_acentos(tb_aluno.nm_aluno) ilike remove_acentos('%".mb_strtoupper($nm_aluno, 'UTF-8')."%')");
            }
            if ($nm_mae)
            {
                $this->db->where("remove_acentos(tb_aluno.nm_mae) ilike remove_acentos('%".mb_strtoupper($nm_mae, 'UTF-8')."%')");
            }
            
            if ($cd_cidade)
            {
                $this->db->where('tb_aluno.cd_cidade', $cd_cidade);
            }
            if ($cd_escola)
            {
                $this->db->where('tb_aluno.cd_escola', $cd_escola);
            }
            
            $this->db->order_by('tb_estado.nm_estado', 'ASC');
            $this->db->order_by('tb_cidade.nm_cidade', 'ASC');
            $this->db->order_by('tb_aluno.nm_aluno', 'ASC');
            
            // echo $this->db->last_query(); //Exibeo comando SQL
            return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_aluno           = null,
        $nr_inep            = null,
        $nm_aluno           = null,
        $nm_mae             = null,
        $nm_pai             = null,
        $nm_responsavel     = null,
        $dt_nascimento      = null,
        $ds_email           = null,
        $fl_sexo            = null,
        $ds_telefone1       = null,
        $ds_telefone2       = null,
        $cd_cidade          = null,
        $nr_cep             = null,
        $ds_rua             = null,
        $nr_residencia      = null,
        $ds_bairro          = null,
        $ds_complemento     = null,
        $ds_referencia      = null,
        $cd_turma           = null,
        $cd_etapa           = null,
        $cd_turno           = null,
        $cd_escola          = null){
            
            
            return $this->buscar(   $ci_aluno,
                $nr_inep,
                $nm_aluno,
                $nm_mae,
                $nm_pai,
                $nm_responsavel,
                $dt_nascimento,
                $ds_email,
                $fl_sexo,
                $ds_telefone1,
                $ds_telefone2,
                $cd_cidade,
                $nr_cep,
                $ds_rua,
                $nr_residencia,
                $ds_bairro,
                $ds_complemento,
                $ds_referencia,
                $cd_turma,
                $cd_etapa,
                $cd_turno,
                $cd_escola);
    }
}