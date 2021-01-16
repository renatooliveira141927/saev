<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Transferencias_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $id                 = null,
                                    $cd_turma           = null,
                                    $cd_aluno           = null,
                                    $nm_aluno           = null,
                                    $cd_etapa           = null,
                                    $cd_turno           = null,
                                    $nr_ano_letivo      = null,
                                    $cd_escola_origem   = null,
                                    $cd_escola_destino  = null,
                                    $fl_autorizado      = null,
                                    $fl_tipo            = null,
                                    $tpconsulta         = null,
                                    $flstatus           = null,                                    
                                    $cd_escola_consulta =null,
                                    $cd_cidade           = null){


        return count($this->buscar( $id,
                                    $cd_turma,
                                    $cd_aluno,
                                    $nm_aluno,
                                    $cd_etapa,
                                    $cd_turno,
                                    $nr_ano_letivo,
                                    $cd_escola_origem,
                                    $cd_escola_destino,
                                    $fl_autorizado,
                                    $fl_tipo,
                                    $tpconsulta,
                                    $flstatus,
                                    $cd_escola_consulta,$cd_cidade));
    }

    public function buscar( $id                 = null,
                            $cd_turma           = null,
                            $cd_aluno           = null,
                            $nm_aluno           = null,
                            $cd_etapa           = null,
                            $cd_turno           = null,
                            $nr_ano_letivo      = null,
                            $cd_escola_origem   = null,
                            $cd_escola_destino  = null,
                            $fl_autorizado      = null,
                            $fl_tipo            = null,
                            $tpconsulta         = null,
                            $flstatus         = null,
                            $cd_escola_consulta = null,
                            $cd_cidade = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){
        

        $this->db->select(' tb_transferencia.ci_transferencia,
                            tb_transferencia.cd_aluno,
                            tb_transferencia.cd_escola_origem,
                            tb_transferencia.cd_escola_destino,
                            tb_transferencia.cd_turma_destino,
                            tb_transferencia.fl_ativo,
                            tb_transferencia.fl_autorizado,
                            tb_transferencia.nr_ano_letivo,
                            tb_transferencia.txt_solicitacao,
                            tb_aluno.*,                            
                            escola_origem.nr_inep as nr_inep_origem,
                            escola_origem.nm_escola as nm_escola_origem,
                            escola_destino.nr_inep  as nr_inep_destino,  
                            escola_destino.nm_escola as nm_escola_destino,                            
                            escola_origem.cd_cidade as cd_cidade_origem,
                            cidade_escola_origem.cd_estado as cd_estado_origem,
                            escola_destino.cd_cidade as cd_cidade_destino,
                            cidade_escola_destino.cd_estado as cd_estado_destino');  
        $this->db->from('tb_transferencia');
        $this->db->join('tb_aluno', 'tb_transferencia.cd_aluno = tb_aluno.ci_aluno');

        $this->db->join('tb_escola escola_origem', 'tb_transferencia.cd_escola_origem = escola_origem.ci_escola');

        $this->db->join('tb_cidade cidade_escola_origem', 'escola_origem.cd_cidade = cidade_escola_origem.ci_cidade');
        $this->db->join('tb_estado estado_escola_origem', 'cidade_escola_origem.cd_estado = estado_escola_origem.ci_estado');

        $this->db->join('tb_escola escola_destino', 'tb_transferencia.cd_escola_destino = escola_destino.ci_escola');

        $this->db->join('tb_cidade cidade_escola_destino', 'escola_destino.cd_cidade = cidade_escola_destino.ci_cidade');
        $this->db->join('tb_estado estado_escola_destino', 'cidade_escola_destino.cd_estado = estado_escola_destino.ci_estado');

        if($flstatus=='T'){
            //$this->db->where('tb_transferencia.fl_ativo', 'false');
            $this->db->where('tb_transferencia.fl_autorizado', 'true');
        }    
        if($flstatus=='F'){
            $this->db->where('tb_transferencia.fl_ativo', 'true');
            $this->db->where('tb_transferencia.fl_autorizado', 'false');
        }    

        if ($id)
        {
            $this->db->where('tb_transferencia.ci_transferencia', $id);
        }

        if ($cd_aluno)
        {
            $this->db->where('tb_transferencia.cd_aluno', $cd_aluno);
        }
        if($nm_aluno){
            $condicao=(" nm_aluno ilike '%".$nm_aluno."%'");
            $this->db->where($condicao);
        }
        
        if ($nr_ano_letivo)
        {
            $this->db->where('tb_transferencia.nr_ano_letivo', $nr_ano_letivo);
        }
        if ($cd_escola_origem)
        {
            $this->db->where('tb_transferencia.cd_escola_origem', $cd_escola_origem);
        }
        if ($cd_escola_destino)
        {
            $this->db->where('tb_transferencia.cd_escola_destino', $cd_escola_destino);
        }
        if ($fl_autorizado)
        {
            $this->db->where('tb_transferencia.fl_autorizado', $fl_autorizado);
        }
        if($tpconsulta=='E' && !empty($cd_escola_consulta)){
            $this->db->where('tb_transferencia.cd_escola_origem', $cd_escola_consulta);            
        }
        if($tpconsulta=='R' && !empty($cd_escola_consulta)){
            $this->db->where('tb_transferencia.cd_escola_destino', $cd_escola_consulta);
        }
        
        if($tpconsulta=='E' && !empty($cd_cidade)){
            $this->db->where(' cidade_escola_origem.ci_cidade', $cd_cidade);
        }
        if($tpconsulta=='R' && !empty($cd_cidade)){
            $this->db->where(' cidade_escola_destino.ci_cidade', $cd_cidade);
        }

        //echo $this->db->last_query();die; //Exibeo comando SQL

        $this->db->order_by('escola_destino.nm_escola', 'ASC');
        $this->db->order_by('tb_aluno.nm_aluno', 'ASC');

        if ($limit && $offset) {
            $this->db->limit($limit, $offset);
        }elseif ($limit && !$offset){
            $this->db->limit($limit);
        }
        
        //echo $this->db->last_query();die; //Exibeo comando SQL
        if ($relatorio){
            return $this->db->get();
        }else{
            return $this->db->get()->result();
        }
    }

    public function get_consulta_excel( $ci_turma       = null,
                                        $nm_turma       = null,
                                        $cd_etapa       = null,
                                        $cd_turno       = null,
                                        $cd_professor   = null,
                                        $dt_associa_prof= null,
                                        $nr_ano_letivo  = null,
                                        $relatorio      = null,
                                        $limit          = null,
                                        $offset         = null){

        $this->db->select(' tb_turma.nm_turma as Nome,
                            tb_turma.nr_ano_letivo as Ano Letivo,
                            tb_edicao.nm_edicao as Edicao,
                            tb_etapa.nm_etapa as Etapa,
                            tb_turno.nm_turno as Turno,
                            tb_professor.nm_professor as Professor,
                            tb_turma.dt_associa_prof as Data de associação do professor');  
        
        $this->db->from('tb_turma');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_professor', 'tb_turma.cd_professor = tb_professor.ci_professor');
        
        $this->db->where('tb_turma.fl_ativo', 'true');
        if ($nm_turma)
        {
            $this->db->where("remove_acentos(tb_turma.nm_turma) ilike remove_acentos('%".mb_strtoupper($nm_turma, 'UTF-8')."%')");
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa', $cd_etapa);
        }
        if ($nr_ano_letivo)
        {
            $this->db->where('tb_turma.nr_ano_letivo', $nr_ano_letivo);
        }
        if ($cd_turno)
        {
            $this->db->where('tb_turma.cd_turno', $cd_turno);
        }
        if ($cd_professor)
        {
            $this->db->where('tb_turma.cd_professor', $cd_professor);
        }
        $this->db->order_by('tb_turma.nm_turma', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_turma       = null,
                                        $nm_turma       = null,
                                        $cd_etapa       = null,
                                        $cd_turno       = null,
                                        $cd_professor   = null,
                                        $dt_associa_prof= null,
                                        $nr_ano_letivo  = null){

        
    return $this->buscar(   $ci_turma,
                            $nm_turma,
                            $cd_etapa,
                            $cd_turno,
                            $cd_professor,
                            $dt_associa_prof,
                            $nr_ano_letivo);
    }
    public function excluir($ci_transferencia)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_transferencia', $ci_transferencia);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_transferencia', $dados);
    }

    public function inserir($cd_aluno           = null,
                            $nr_ano_letivo      = null,
                            $cd_escola_origem   = null,
                            $cd_escola_destino  = null,
                            $fl_autorizado      = null,
                            $txt_solicitacao    = null,
                            $cd_turma_destino   = null){

        $this->db->where('cd_aluno', $cd_aluno);
        $this->db->where('cd_escola_origem', $cd_escola_origem);
        $this->db->where('cd_escola_destino', $cd_escola_destino);
        $this->db->where('cd_turma_destino', $cd_turma_destino);

        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_transferencia');

        if (!($this->db->get()->num_rows() > 0)){

            $dados['cd_aluno']          = $cd_aluno;
            $dados['nr_ano_letivo']     = $nr_ano_letivo;
            $dados['cd_escola_origem']  = $cd_escola_origem;
            $dados['cd_escola_destino'] = $cd_escola_destino;
            $dados['cd_turma_destino']  = $cd_turma_destino;
            $dados['txt_solicitacao']   = $txt_solicitacao;
            $dados['fl_autorizado']   = 'false';

            if ($cd_turma_destino){
                $dados['cd_turma_destino']  = $cd_turma_destino;
            }

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_transferencia', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_transferencia   = null,
                            $cd_aluno           = null,
                            $nr_ano_letivo      = null,
                            $cd_escola_origem   = null,
                            $cd_escola_destino  = null,
                            $fl_autorizado      = null,
                            $txt_solicitacao    = null,
                            $cd_turma_destino   = null){

          
        $this->db->where('cd_aluno', $cd_aluno);
        $this->db->where('cd_escola_origem', $cd_escola_origem);
        $this->db->where('cd_escola_destino', $cd_escola_destino);

        $this->db->where('ci_transferencia <>', $ci_transferencia);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_transferencia');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['cd_aluno']          = $cd_aluno;
            $dados['nr_ano_letivo']     = $nr_ano_letivo;
            $dados['cd_escola_origem']  = $cd_escola_origem;
            $dados['cd_escola_destino'] = $cd_escola_destino;
            $dados['fl_autorizado']     = $fl_autorizado;
            $dados['txt_solicitacao']   = $txt_solicitacao;
            $dados['fl_autorizado']   = 'false';

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_transferencia', $ci_transferencia);
            return $this->db->update('tb_transferencia', $dados);
//            return true;
        }else{
            return false;
        }

    }
    public function aprovarTransferencia($params){
        
        $this->db->where('cd_aluno', $params['cd_aluno']);
        $this->db->where('cd_escola_origem', $params['cd_escola_origem']);
        $this->db->where('cd_escola_destino', $params['cd_escola_destino']);

        $this->db->where('ci_transferencia',$params['ci_transferencia']);
        $this->db->where('fl_ativo', 'true');
        $this->db->where('fl_autorizado', 'false');        
        $this->db->from('tb_transferencia');
        $retorno=$this->db->get()->num_rows();
        
        if (($retorno== 1)){
            
            $ultimaenturmacao=$this->buscaUltimaEnturmacaoAluno($params);
            //print_r($ultimaenturmacao[0]->cd_turma);die;
        
            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";
            $dados['fl_autorizado'] = 'true';
            $dados['fl_ativo'] = 'false';
            $this->db->where('ci_transferencia', $params['ci_transferencia']);
            $transferido=$this->db->update('tb_transferencia', $dados);
            
            if($transferido==1){
                
                    $parames['cd_aluno']=$params['cd_aluno'];
                    $parames['fl_ativo']='false';
                    $this->db->where('cd_aluno', $params['cd_aluno']);
                    $this->db->where('fl_ativo', 'true');
                    $desenturmado=$this->db->update('tb_enturmacao', $parames);
                            
                    $dadosaluno['cd_escola']=$params['cd_escola_destino'];
                    $this->db->where('ci_aluno',$params['cd_aluno']);
                    $enturmado=$this->db->update('tb_aluno',$dadosaluno);
                    
                    $dadosultimaenturmacao['cd_turma']=$params['cd_turma_destino'];
                    $this->db->where('cd_turma',$ultimaenturmacao[0]->cd_turma);
                    $this->db->where('ci_aluno',$params['cd_aluno']);
                    $atualizaultimaenturmacao=$this->db->update('tb_ultimaenturmacao',$dadosultimaenturmacao);
                                            
                    if($enturmado==1 && $atualizaultimaenturmacao==1){                        
                        $param['cd_aluno']=$params['cd_aluno'];
                        $param['cd_turma']=$params['cd_turma_destino'];
                        $param['fl_ativo']='true';
                        $param['cd_usuario_cad']= $this->session->userdata('ci_usuario');
                        $param['dt_cadastro']= date('Y-m-d');
                        return $this->db->insert('tb_enturmacao', $param);
                    }                
            }            
        }else{
            return false;
        }

    }
    
    public function buscaUltimaEnturmacaoAluno($params){
        
        $sql=" select ent.*,al.* from tb_ultimaenturmacao ent
                inner join tb_aluno al on ent.cd_aluno=al.ci_aluno and al.fl_ativo=true
               where 1=1 ";
        if(isset($params['cd_aluno'])){$sql.=" and ent.cd_aluno=".$params['cd_aluno'];}
        if(isset($params['cd_turma'])){$sql.=" and ent.cd_turma=".$params['cd_turma'];}
        
        if(!isset($params['cd_aluno']) && !isset($params['cd_turma']) ){
            $sql.=" and ent.nr_anoletivo=extract(year from now())";
        }
        
        $sql.=" order by al.nm_aluno limit 1000;";
        
        $query=$this->db->query($sql);
        return $query->result();
    }
}