<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Etapas_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }
    public function buscar_count( $ci_etapa = null,
                                  $nm_etapa = null){
        
        return  count($this->buscar($ci_etapa, $nm_etapa));
    }
    public function buscar( $ci_etapa          = null,
                            $nm_etapa          = null,
                            $relatorio          = null,
                            $limit              = null,
                            $offset             = null){

        $this->db->select(' tb_etapa.ci_etapa,
                            tb_etapa.nm_etapa');
        
        $this->db->from('tb_etapa');

        if ($ci_etapa)
        {
            $this->db->where('tb_etapa.ci_etapa', $ci_etapa);
        }
        if ($nm_etapa)
        {
            $this->db->where("remove_acentos(tb_etapa.nm_etapa) ilike remove_acentos('%".mb_strtoupper($nm_etapa, 'UTF-8')."%')");
        }
        $this->db->where('tb_etapa.fl_ativo', 'true');
        $this->db->order_by('tb_etapa.nm_etapa', 'ASC');

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

    public function excluir($id)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_etapa', $id);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_etapa', $dados);
    }

    public function inserir($nm_etapa = null){

        $this->db->where("remove_acentos(tb_etapa.nm_etapa) ilike remove_acentos('%".mb_strtoupper($nm_etapa, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_etapa.nm_etapa) ilike remove_acentos('%".mb_strtoupper($nm_etapa, 'UTF-8')."%')
        // or  tb_etapa.ds_codigo ='$ds_codigo')
        // ");

        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_etapa', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_etapa']  = $nm_etapa;
            
            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_etapa', $dados);
            return true;
        }else{
            return false;
        }

    }

    public function alterar($ci_etapa = null,
                            $nm_etapa = null){

        $this->db->where("remove_acentos(tb_etapa.nm_etapa) ilike remove_acentos('%".mb_strtoupper($nm_etapa, 'UTF-8')."%')");
        // $this->db->where("
        // (remove_acentos(tb_etapa.nm_etapa) ilike remove_acentos('%".mb_strtoupper($nm_etapa, 'UTF-8')."%')
        // or  tb_etapa.ds_codigo ='$ds_codigo')
        // ");
   
        $this->db->where('ci_etapa <> '.$ci_etapa);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_etapa');

        if (!($this->db->get()->num_rows() > 0)){
                
            $dados['nm_etapa']        = $nm_etapa;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_etapa', $ci_etapa);
            return $this->db->update('tb_etapa', $dados);
        }else{
            return false;
        }

    }
    
    public function buscaTodasOfertasEscola($params){
        $sql=" select distinct e.* from tb_turma t
                inner join tb_etapa e on t.cd_etapa=e.ci_etapa
            where 1=1 and e.fl_ativo=true";
        if($params!=NULL){$sql.=" and cd_escola=".$params;}
        $sql.=" order by nm_etapa"; 
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function buscaOfertaEscola($params){
        $sql=" select distinct e.* from tb_turma t 
                inner join tb_etapa e on t.cd_etapa=e.ci_etapa
            where t.nr_ano_letivo in (extract(year from now()), (extract(year from now())-1) )
                and e.fl_ativo = true ";
                
        if($params!=NULL){$sql.=" and cd_escola=".$params;}

        $sql.="order by e.nm_etapa";        
       
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function getEtapaEdicaoDisciplina($cd_disciplina, $cd_edicao){
        $sql="  select distinct et.ci_etapa,et.nm_etapa
        from tb_edicao ed
        inner join tb_avaliacao_upload au on
        ed.ci_edicao=au.cd_edicao
        inner join tb_etapa et on au.cd_etapa=et.ci_etapa
        where ed.ci_edicao=".$cd_edicao."
        and au.cd_disciplina=".$cd_disciplina;
        
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function selectEtapaEdicaoDisciplina($cd_disciplina=null, $cd_edicao=null){
        
        $etapas = $this->getEtapaEdicaoDisciplina($cd_disciplina, $cd_edicao);
        $options = "";
        
        if (count($etapas) >= 1){
            $options = "<option value='0'>Selecione uma Etapa </option>";
        }
        foreach ($etapas as $etapa){            
            $options .= "<option value='".$etapa->ci_etapa."'>".$etapa->nm_etapa."</option>".PHP_EOL;
        }
        return $options;
    }
}