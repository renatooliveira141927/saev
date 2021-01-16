<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Turmas_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_turma= null,
                                    $nm_turma= null,
                                    $cd_etapa= null,
                                    $cd_turno= null,
                                    $cd_professor= null,
                                    $dt_associa_prof= null,
                                    $nr_ano_letivo= null,
                                    $cd_escola= null,
                                    $cd_cidade_sme=null){


        return count($this->buscar( $ci_turma,
                                    $nm_turma,
                                    $cd_etapa,
                                    $cd_turno,
                                    $cd_professor,
                                    $dt_associa_prof,
                                    $nr_ano_letivo,
                                    $cd_escola,
                                    $cd_cidade_sme));
    }

    public function buscar( $ci_turma       = null,
                            $nm_turma       = null,
                            $cd_etapa       = null,
                            $cd_turno       = null,
                            $cd_professor   = null,
                            $dt_associa_prof= null,
                            $nr_ano_letivo  = null,
                            $cd_escola      = null,
                            $cd_cidade_sme  = null, 
                            $relatorio      = null,
                            $limit          = null,
                            $offset         = null){ 
        
        $this->db->select(' tb_turma.ci_turma,
                            tb_turma.nm_turma,
                            tb_turma.cd_escola,
                            tb_turma.cd_etapa,
                            tb_turma.cd_turno,
                            tb_turma.cd_professor,
                            tb_turma.tp_turma,
                            tb_turma.dt_associa_prof,
                            tb_turma.nr_ano_letivo,
                            tb_professor.ci_professor,
                            tb_professor.nr_cpf,
                            tb_professor.nm_professor,
                            tb_escola.nr_inep,
                            tb_etapa.nm_etapa,
                            tb_turno.nm_turno,
                            tb_cidade.ci_cidade,
                            tb_cidade.nm_cidade,
                            tb_estado.ci_estado,
                            tb_estado.nm_estado as nm_estado_sme');  
        $this->db->from('tb_turma');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_professor', 'tb_turma.cd_professor = tb_professor.ci_professor', 'left');

        $this->db->join('tb_escola', 'tb_turma.cd_escola  = tb_escola.ci_escola');
        $this->db->join('tb_cidade', 'tb_escola.cd_cidade = tb_cidade.ci_cidade');
        $this->db->join('tb_estado', 'tb_cidade.cd_estado = tb_estado.ci_estado');

        $this->db->where('tb_turma.fl_ativo', 'true');

        if ($ci_turma)
        {
            $this->db->where('tb_turma.ci_turma', $ci_turma);
        }
        if ($nm_turma)
        {
            $this->db->where("remove_acentos(tb_turma.nm_turma) ilike remove_acentos('%".mb_strtoupper($nm_turma, 'UTF-8')."%')");
        }
        if ($nr_ano_letivo)
        {
            $this->db->where('tb_turma.nr_ano_letivo', $nr_ano_letivo);
        }else if($ci_turma==null){
            $this->db->where('tb_turma.nr_ano_letivo', date('Y'));
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa', $cd_etapa);
        }
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        if($cd_cidade_sme){
           $this->db->where('tb_escola.cd_cidade', $cd_cidade_sme);   
        }
        if ($cd_turno)
        {
            $this->db->where('tb_turma.cd_turno', $cd_turno);
        }
        if ($cd_professor)
        {
            $this->db->where('tb_turma.cd_professor', $cd_professor);
        }
        if ($this->session->userdata('ci_escola') && $this->session->userdata('ci_grupousuario')==3)
        {
            $this->db->where('tb_turma.cd_escola', $this->session->userdata('ci_escola'));
        }        

        $this->db->order_by('tb_turma.nm_turma', 'ASC');

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
                                        $cd_edicao      = null,
                                        $cd_etapa       = null,
                                        $cd_turno       = null,
                                        $cd_professor   = null,
                                        $dt_associa_prof= null,
                                        $relatorio      = null,
                                        $limit          = null,
                                        $offset         = null){

        $this->db->select(' tb_turma.nm_turma as Nome,
                            tb_edicao.nm_edicao as Edicao,
                            tb_etapa.nm_etapa as Etapa,
                            tb_turno.nm_turno as Turno,
                            tb_professor.nm_professor as Professor,
                            tb_turma.dt_associa_prof as Data de associação do professor');  
        
        $this->db->from('tb_turma');
        $this->db->join('tb_edicao', 'tb_turma.cd_edicao = tb_edicao.ci_edicao');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_professor', 'tb_turma.cd_professor = tb_professor.ci_professor');
        
        $this->db->where('tb_turma.fl_ativo', 'true');
        if ($nm_turma)
        {
            $this->db->where("remove_acentos(tb_turma.nm_turma) ilike remove_acentos('%".mb_strtoupper($nm_turma, 'UTF-8')."%')");
        }
        if ($cd_edicao)
        {
            $this->db->where('tb_turma.cd_edicao', $cd_edicao);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa', $cd_etapa);
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
                                        $cd_edicao      = null,
                                        $cd_etapa       = null,
                                        $cd_turno       = null,
                                        $cd_professor   = null,
                                        $dt_associa_prof= null){

        
    return $this->buscar(   $ci_turma,
                            $nm_turma,
                            $cd_edicao,
                            $cd_etapa,
                            $cd_turno,
                            $cd_professor,
                            $dt_associa_prof);
    }
    public function excluir($ci_turma)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_turma', $ci_turma);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_turma', $dados);
    }

    public function inserir( $nm_turma = null, 
                                                $cd_etapa = null,
                                                $cd_turno = null, 
                                                $cd_professor = null,
                                                $cd_escola = null,
                                                $tp_turma = null,
                                                $nr_ano_letivo = null){

        if ($nm_turma)
        {            
            $this->db->where("((remove_acentos(nm_turma) ilike remove_acentos('%".$nm_turma."%')))");            
        }
        $this->db->where('cd_etapa', $cd_etapa);
        $this->db->where('cd_escola', $cd_escola);
        $this->db->where('cd_turno', $cd_turno);
        $this->db->where('nr_ano_letivo', $nr_ano_letivo);
        $this->db->where('fl_ativo', 'true');
        $this->db->from('tb_turma');

        if (!($this->db->get()->num_rows() > 0)){
            
            $dados['nm_turma']       = $nm_turma;                        
            $dados['cd_etapa']       = $cd_etapa;
            $dados['cd_turno']       = $cd_turno;
            if($cd_professor!=null ){ $dados['cd_professor']   = $cd_professor; }
            $dados['cd_escola']      = $cd_escola;
            $dados['tp_turma']       = $tp_turma;
            $dados['nr_ano_letivo']  = $nr_ano_letivo;            

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_turma', $dados);
            return true;
        }else{

            return false;
        }

    }

    public function alterar($ci_turma       = null,
                            $nm_turma       = null,                            
                            $cd_etapa       = null,
                            $cd_turno       = null,
                            $cd_professor   = null,
                            $cd_escola      = null,
                            $tp_turma       = null,
                            $nr_ano_letivo = null){

        $this->db->where("
                            (remove_acentos(nm_turma) ilike remove_acentos('%".$nm_turma."%')) 
                            and (ci_turma <> ".$ci_turma.")
                            and (fl_ativo = true)
                        ");
        $this->db->where('cd_etapa', $cd_etapa);
        $this->db->where('cd_escola', $cd_escola);
        $this->db->where('cd_turno', $cd_turno);
        $this->db->where('nr_ano_letivo', $nr_ano_letivo);                
        $this->db->from('tb_turma');

        

        if (!($this->db->get()->num_rows() > 0)){            
            $dados['nm_turma']       = $nm_turma;            
            $dados['cd_etapa']       = $cd_etapa;
            $dados['cd_turno']       = $cd_turno;
            if($cd_professor!=null ){ $dados['cd_professor']   = $cd_professor; }
            $dados['cd_escola']      = $cd_escola;
            $dados['tp_turma']       = $tp_turma;
            $dados['nr_ano_letivo']  =$nr_ano_letivo;

            $dados['cd_usuario_alt']  = $this->session->userdata('ci_usuario');
            $dados['dt_alteracao']    = "now()";

            $this->db->where('ci_turma', $ci_turma);
            return $this->db->update('tb_turma', $dados);
//            return true;
        }else{
            //echo($this->db->last_query());die;
            return false;
        }

    }
    public function get_turmas_combo($cd_escola){

		$this->db->select('
            tb_turma.ci_turma,            
            tb_turma.nm_turma,
            tb_turma.nr_ano_letivo, 
            tb_turma.cd_etapa, 
            tb_etapa.nm_etapa,
            tb_turma.cd_turno,
            tb_turno.nm_turno');
        $this->db->from('tb_turma');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
	
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        $this->db->where('tb_turma.fl_ativo', 'true');
		$this->db->order_by('nm_turma','ASC');

         //echo $this->db->last_query(); //Exibe o comando SQL
        return $this->db->get()->result();
    }
    
    public function get_turmasatuais_combo($cd_escola){

		$this->db->select('
            tb_turma.ci_turma,            
            tb_turma.nm_turma,
            tb_turma.nr_ano_letivo, 
            tb_turma.cd_etapa, 
            tb_etapa.nm_etapa,
            tb_turma.cd_turno,
            tb_turno.nm_turno');
        $this->db->from('tb_turma');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
	
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        $this->db->where('tb_turma.fl_ativo', 'true');
        $this->db->where('tb_turma.nr_ano_letivo', date('Y'));
		$this->db->order_by('nm_turma','ASC');

         //echo $this->db->last_query(); //Exibe o comando SQL
        return $this->db->get()->result();
    }
    
    public function get_TurmasByEtapaEscola($cd_etapa = null, $cd_escola = null){

        $this->db->distinct();
        $this->db->select('             
			tb_turma.ci_turma,
			tb_turma.nm_turma');
        $this->db->from('tb_turma');

        if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa',$cd_etapa);
        }
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        $this->db->order_by('nm_turma','ASC');

        return $this->db->get()->result();
    }
    
    public function get_TurmasByEtapaTurno($cd_etapa = null, $cd_escola = null,$nr_anoletivo = null){
        
        $this->db->select('
            tb_turma.ci_turma,
            tb_turma.nm_turma,
            tb_turma.nr_ano_letivo,
            tb_turma.cd_etapa,
            tb_etapa.nm_etapa,
            tb_turma.cd_turno,
            tb_turno.nm_turno');
        $this->db->from('tb_turma');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
        
        if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa',$cd_etapa);
        }
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        if($nr_anoletivo){
            $this->db->where('tb_turma.nr_ano_letivo', $nr_anoletivo);
        }
        $this->db->where('tb_turma.fl_ativo', 'true');        
        $this->db->order_by('nm_turma','ASC');
        
        return $this->db->get()->result();
    }

    public function get_TurmasByEtapaTurnoAno($cd_etapa = null, $cd_escola = null, $nr_anoletivo = null){

		$this->db->select('
            tb_turma.ci_turma,            
            tb_turma.nm_turma,
            tb_turma.nr_ano_letivo, 
            tb_turma.cd_etapa, 
            tb_etapa.nm_etapa,
            tb_turma.cd_turno,
            tb_turno.nm_turno');
        $this->db->from('tb_turma');
        $this->db->join('tb_turno', 'tb_turma.cd_turno = tb_turno.ci_turno');
        $this->db->join('tb_etapa', 'tb_turma.cd_etapa = tb_etapa.ci_etapa');
				
		if ($cd_etapa)
        {
            $this->db->where('tb_turma.cd_etapa',$cd_etapa);
		}
        if ($cd_escola)
        {
            $this->db->where('tb_turma.cd_escola', $cd_escola);
        }
        $this->db->where('tb_turma.fl_ativo', 'true');
        $this->db->where('tb_turma.nr_ano_letivo', $nr_anoletivo);
		$this->db->order_by('nm_turma','ASC');

		return $this->db->get()->result();
	}


    public function selectTurmas($cd_etapa = null, $cd_escola = null, $cd_turma = null, $nr_anoletivo = null){

        $turmas = $this->get_TurmasByEtapaTurno($cd_etapa, $cd_escola,$nr_anoletivo);

        $options = "<option value=''>Selecione a Turma </option>";

        foreach ($turmas as $turma){
            if ($cd_turma == $turma->ci_turma){
                $options .= "<option value='{$turma->ci_turma}' cd_etapa='{$turma->cd_etapa}' cd_turno='{$turma->cd_turno}' selected>{$turma->nr_ano_letivo}  - {$turma->nm_turno} - {$turma->nm_turma}</option>".PHP_EOL;
            }else{
                $options .= "<option value='{$turma->ci_turma}' cd_etapa='{$turma->cd_etapa}' cd_turno='{$turma->cd_turno}'>{$turma->nr_ano_letivo}  - {$turma->nm_turno} - {$turma->nm_turma}</option>".PHP_EOL;
            }

        }
        return $options;
    }
    
    public function selectTurmasAno($cd_etapa = null, $cd_escola = null, $cd_turma = null, $nr_anoletivo= null){
        
        $turmas = $this->get_TurmasByEtapaTurnoAno($cd_etapa, $cd_escola,$nr_anoletivo);
        
        $options = "<option value=''>Selecione a Turma </option>";
        
        foreach ($turmas as $turma){
            if ($cd_turma == $turma->ci_turma){
                $options .= "<option value='{$turma->ci_turma}' cd_etapa='{$turma->cd_etapa}' cd_turno='{$turma->cd_turno}' selected>{$turma->nr_ano_letivo}  - {$turma->nm_turno} - {$turma->nm_turma}</option>".PHP_EOL;
            }else{
                $options .= "<option value='{$turma->ci_turma}' cd_etapa='{$turma->cd_etapa}' cd_turno='{$turma->cd_turno}'>{$turma->nr_ano_letivo}  - {$turma->nm_turno} - {$turma->nm_turma}</option>".PHP_EOL;
            }
            
        }
        return $options;
    }
    
    // public function selectTurmas($cd_etapa = null, $cd_escola = null){

    //     $turmas = $this->get_TurmasByEtapaEscola($cd_etapa, $cd_escola);

    //     $options = "<option value=''>Selecione a Turma </option>";

    //     foreach ($turmas as $turma){
    //         //if ($cd_turma == $turma->ci_turma){
    //             $options .= "<option value='{$turma->ci_turma}' selected>{$turma->nm_turma}</option>".PHP_EOL;
    //         //}else{
    //         //    $options .= "<option value='{$turma->ci_turma}'>{$turma->nm_turma}</option>".PHP_EOL;
    //         //}

    //     }
    //     return $options;
    // }
}