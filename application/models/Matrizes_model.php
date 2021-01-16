<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Matrizes_model extends CI_Model {

    public function __construct(){
        parent::__construct();

    }

    public function count_buscar(   $ci_matriz      = null,
                                    $nm_matriz      = null,
                                    $cd_disciplina  = null,
                                    $cd_etapa       = null){

        return count($this->buscar($ci_matriz, $nm_matriz, $cd_disciplina, $cd_etapa));

    }
    public function buscar( $ci_matriz      = null,
                            $nm_matriz      = null,
                            $cd_disciplina  = null,
                            $cd_etapa       = null,
                            $relatorio      = null,
                            $limit          = null,
                            $offset         = null,
                            $cd_escola      = null){

        $this->db->select(' tb_matriz.ci_matriz,
                            tb_matriz.nm_matriz,
                            tb_matriz.cd_etapa,
                            tb_matriz.cd_disciplina,
                            tb_disciplina.nm_disciplina,
                            tb_etapa.nm_etapa');
        
        $this->db->from('tb_matriz');
        $this->db->join('tb_disciplina', 'tb_disciplina.ci_disciplina = tb_matriz.cd_disciplina', 'right');
        $this->db->join('tb_etapa', 'tb_etapa.ci_etapa = tb_matriz.cd_etapa', 'right');

        if ($ci_matriz)
        {
            $this->db->where('tb_matriz.ci_matriz', $ci_matriz);
        }
        if ($nm_matriz)
        {
            $this->db->where("remove_acentos(tb_matriz.nm_matriz) ilike remove_acentos('%".mb_strtoupper($nm_matriz, 'UTF-8')."%')");
        }
        if ($cd_disciplina)
        {
            $this->db->where('tb_matriz.cd_disciplina', $cd_disciplina);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_matriz.cd_etapa', $cd_etapa);
        }
        $this->db->where('tb_matriz.fl_ativo', 'true');
        $this->db->order_by('tb_matriz.nm_matriz', 'ASC');

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

    public function listaMatriz($cd_disciplina,$cd_etapa){
        $this->db->select('tb_matriz.ci_matriz,
                            tb_matriz.nm_matriz');
        $this->db->from('tb_matriz'); 
        $this->db->where('tb_matriz.fl_ativo',true); 
        $this->db->where('cd_etapa',$cd_etapa); 
        $this->db->where('cd_disciplina',$cd_disciplina);
        $this->db->order_by('nm_matriz','ASC');
        return $this->db->get()->result();
    } 

    public function selectMatriz($cd_disciplina,$cd_etapa, $cd_matriz=null){
        
        $matriz = $this->listaMatriz($cd_disciplina,$cd_etapa);

        $options = "<option value=''>Selecione a Matriz </option>";
        
        foreach ($matriz as $item){
            if ($cd_matriz == $item->ci_matriz){
                $options .= "<option value='{$item->ci_matriz}' selected >{$item->nm_matriz}</option>".PHP_EOL;
            }else{
                $options .= "<option value='{$item->ci_matriz}' >{$item->nm_matriz}</option>".PHP_EOL;
            }
            
        }
        return $options;
    }

    public function buscar_descritores($cd_matriz = null){
        
        $this->db->select(' tb_matriz_topico.nm_matriz_topico,
                            tb_matriz_topico.ci_matriz_topico,
                            tb_matriz_descritor.ds_codigo,
                            tb_matriz_descritor.nm_matriz_descritor,
                            tb_matriz_descritor.ds_descritorcaed,
                            tb_matriz_descritor.ci_matriz_descritor');

        $this->db->from('tb_matriz_topico');        
        $this->db->join('tb_matriz_descritor', 'tb_matriz_topico.ci_matriz_topico = tb_matriz_descritor.cd_matriz_topico', 'left');
        $this->db->where('tb_matriz_topico.cd_matriz', $cd_matriz);
        $this->db->order_by('tb_matriz_descritor.ci_matriz_descritor', 'ASC');      
        return $this->db->get()->result();
    }
    
    public function get_consulta_excel( $ci_matriz           = null,
                                        $ds_codigo           = null,
                                        $nm_matriz           = null,
                                        $cd_disciplina      = null,
                                        $cd_etapa           = null,
                                        $relatorio          = null,
                                        $limit              = null,
                                        $offset             = null,
                                        $cd_escola          = null){

                        $this->db->select(' tb_matriz.ci_matriz,
                                            tb_matriz. ds_codigo,
                                            tb_matriz.nm_matriz,
                                            tb_matriz.cd_etapa,
                                            tb_matriz.cd_disciplina,
                                            tb_disciplina.nm_disciplina,
                                            tb_etapa.nm_etapa');
                        
                        $this->db->from('tb_matriz');
                        $this->db->join('tb_disciplina', 'tb_disciplina.ci_disciplina = tb_matriz.cd_disciplina', 'right');
                        $this->db->join('tb_etapa', 'tb_etapa.ci_etapa = tb_matriz.cd_etapa', 'right');
                

                        if ($ci_matriz)
                        {
                            $this->db->where('tb_matriz.ci_matriz', $ci_matriz);
                        }
                        if ($ds_codigo)
                        {
                            $this->db->where('tb_matriz.ds_codigo', $ds_codigo);
                        }
                        if ($nm_matriz)
                        {
                            $this->db->where("remove_acentos(tb_matriz.nm_matriz) ilike remove_acentos('%".mb_strtoupper($nm_matriz, 'UTF-8')."%')");
                        }
                        if ($cd_disciplina)
                        {
                            $this->db->where('tb_matriz.cd_disciplina', $cd_disciplina);
                        }
                        if ($cd_etapa)
                        {
                            $this->db->where('tb_matriz.cd_etapa', $cd_etapa);
                        }

                        $this->db->where('tb_matriz.fl_ativo', 'true');
                        $this->db->order_by('tb_matriz.nm_matriz', 'ASC');
                                    
       // echo $this->db->last_query(); //Exibeo comando SQL
        return $this->db->get();
    }
    public function get_consulta_pdf(   $ci_matriz           = null,
                                        $ds_codigo           = null,
                                        $nm_matriz           = null,
                                        $cd_disciplina      = null,
                                        $cd_etapa           = null){

        
    return $this->buscar(   $ci_matriz,
                            $ds_codigo,
                            $nm_matriz);
    }
    public function excluir($ci_matriz)
    {

        $dados['fl_ativo']        = false;
        $dados['cd_usuario_del']  = $this->session->userdata('ci_usuario');
        $dados['dt_exclusao']     = "now()";

        $this->db->where('ci_matriz', $ci_matriz);
        $this->db->where('fl_ativo', 'true');
        return $this->db->update('tb_matriz', $dados);
    }

    public function inserir($nm_matriz       = null,
                            $cd_disciplina   = null,
                            $cd_etapa        = null,
                            $arr_topicos     = null,
                            $json_descritores = null){

        $this->db->where("(remove_acentos(tb_matriz.nm_matriz) ilike remove_acentos('%".mb_strtoupper($nm_matriz, 'UTF-8')."%'))");
        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_matriz', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_matriz']      = $nm_matriz; 
            $dados['cd_disciplina']  = $cd_disciplina;
            $dados['cd_etapa']       = $cd_etapa;

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->insert('tb_matriz', $dados);
            
            $this->db->select('ci_matriz');
            $this->db->where("nm_matriz",$nm_matriz);
            $this->db->where("cd_disciplina",$cd_disciplina);
            $this->db->where("cd_etapa",$cd_etapa);
            $this->db->from('tb_matriz');
            $matrizes = $this->db->get()->result();
            $cd_matriz = '';
            $cd_matriz_topico = '';

            foreach ($matrizes as $i => $value){
                $cd_matriz = $value->ci_matriz;
            }
            

            foreach($arr_topicos as $i => $nm_matriz_topico){
                $dados_topico['nm_matriz_topico']  = $nm_matriz_topico;
                $dados_topico['cd_matriz']         = $cd_matriz;

                $this->db->insert('tb_matriz_topico', $dados_topico);

                $this->db->select('ci_matriz_topico');
                $this->db->where("nm_matriz_topico",$nm_matriz_topico);
                $this->db->from('tb_matriz_topico');
                $topicos = $this->db->get()->result();

                foreach ($topicos as $y => $topico){
                    $cd_matriz_topico = $topico->ci_matriz_topico;
                }

                foreach ($json_descritores  as $z => $d){

                    if ($i == $d->num_ordem_topico){
                        $dados_descritor['ds_codigo']             = $d->ds_codigo;
                        $dados_descritor['nm_matriz_descritor']   = $d->nm_matriz_descritor;
                        $dados_descritor['cd_matriz_topico']      = $cd_matriz_topico;
                        

                        $this->db->insert('tb_matriz_descritor', $dados_descritor);
                    }

                }

            }

            return true;
        }else{
            return false;
        }

    }

    public function apagar_topico($ci_matriz = null){

        // $this->db->where('tb_matriz_topico.cd_matriz', $ci_matriz);
        // $this->db->delete('tb_matriz_topico', $dados);
        
        $this->db->query('delete from tb_matriz_topico where tb_matriz_topico.cd_matriz = '. $ci_matriz);

    }

    public function apagar_descritor($ci_matriz = null){

        // $this->db->where('tb_matriz_descritor.cd_matriz_topico in ( select ci_matriz_topico from tb_matriz_topico where cd_matriz = '.$ci_matriz.')');           
        // $this->db->delete('tb_matriz_descritor'); 

        $this->db->query('delete from tb_matriz_descritor where tb_matriz_descritor.cd_matriz_topico in ( select ci_matriz_topico from tb_matriz_topico where cd_matriz = '.$ci_matriz.')');

    }

    public function gravar_topico($ci_matriz = null, $arr_topicos = null, $json_descritores = null){

        $cd_matriz_topico = '';

        foreach($arr_topicos as $i => $nm_matriz_topico){
            // $dados['nm_matriz_topico']  = $nm_matriz_topico;
            // $dados['cd_matriz']         = $ci_matriz;

            // $dados['cd_usuario_cad']  = $this->session->userdata('ci_usuario');
            // $this->db->insert('tb_matriz_topico', $dados);

            $this->db->query("insert into tb_matriz_topico( nm_matriz_topico, cd_matriz )values( '".$nm_matriz_topico."', '".$ci_matriz."' )");

            // $this->db->select('ci_matriz_topico');
            // $this->db->where("nm_matriz_topico",$nm_matriz_topico);
            // $this->db->from('tb_matriz_topico');

            $query = $this->db->query("select ci_matriz_topico from tb_matriz_topico where nm_matriz_topico='".$nm_matriz_topico."'");

            $topicos = $query->result(); 

            // $topicos = $this->db->get()->result();

            foreach ($topicos as $y => $topico){

                $cd_matriz_topico = $topico->ci_matriz_topico;
            }

            $num_ordem_topico = $i;

            $this->gravar_descritor($num_ordem_topico, $cd_matriz_topico, $json_descritores);
        }

    }

    public function gravar_descritor($num_ordem_topico = null, $cd_matriz_topico = null, $json_descritores = null){

        foreach ($json_descritores  as $z => $d){

            if ($num_ordem_topico == $d->num_ordem_topico){

                // $dados['ds_codigo']             = $d->ds_codigo;
                // $dados['nm_matriz_descritor']   = $d->nm_matriz_descritor;
                // $dados['cd_matriz_topico']      = $cd_matriz_topico;

                // $this->db->insert('tb_matriz_descritor', $dados);
                
                $this->db->query("insert into tb_matriz_descritor( ds_codigo, nm_matriz_descritor, cd_matriz_topico )values( '".$d->ds_codigo."', '".$d->nm_matriz_descritor."', '".$cd_matriz_topico."' )");
            }
        }
    }

    public function alterar($ci_matriz       = null,
                            $nm_matriz       = null,
                            $cd_disciplina   = null,
                            $cd_etapa        = null,
                            $arr_topicos     = null,
                            $json_descritores = null){


        $this->db->where("(remove_acentos(tb_matriz.nm_matriz) = remove_acentos('%".mb_strtoupper($nm_matriz, 'UTF-8')."%'))");
        $this->db->where('ci_matriz <> '.$ci_matriz);
        $this->db->where('fl_ativo', 'true', false);
        $this->db->from('tb_matriz', false);
        
        if (!($this->db->get()->num_rows() > 0)){

            $dados['nm_matriz']      = $nm_matriz; 
            $dados['cd_disciplina']  = $cd_disciplina;
            $dados['cd_etapa']       = $cd_etapa;

            $dados['cd_usuario_cad']   = $this->session->userdata('ci_usuario');
            $this->db->where("ci_matriz", $ci_matriz);
            $this->db->update('tb_matriz', $dados);               


            $this->apagar_descritor($ci_matriz);
            $this->apagar_topico($ci_matriz);            

            $this->gravar_topico($ci_matriz, $arr_topicos, $json_descritores);            

            return true;
        }else{
            return false;
        }

    }

    public function buscar_matriz(  $cd_disciplina = null,
                                    $cd_etapa = null,
                                    $cd_matriz = null){

        $this->db->select(' tb_matriz_descritor.ci_matriz_descritor,
                            tb_matriz_descritor.ds_codigo,
                            tb_matriz_descritor.nm_matriz_descritor');

        $this->db->from('tb_matriz');
        $this->db->join('tb_matriz_topico', 'tb_matriz_topico.cd_matriz = tb_matriz.ci_matriz');
        $this->db->join('tb_matriz_descritor', 'tb_matriz_descritor.cd_matriz_topico = tb_matriz_topico.ci_matriz_topico');
        
        if ($cd_disciplina)
        {
            $this->db->where('tb_matriz.cd_disciplina', $cd_disciplina);
        }
        if ($cd_etapa)
        {
            $this->db->where('tb_matriz.cd_etapa', $cd_etapa);
        }
        if ($cd_matriz){
            $this->db->where('tb_matriz.ci_matriz', $cd_matriz);
        }

        $this->db->where('tb_matriz.fl_ativo = true');
        $this->db->order_by('tb_matriz_descritor.ci_matriz_descritor', 'ASC');

        return $this->db->get()->result();
    }
    public function select_matriz(  $cd_disciplina  = null,
                                    $cd_etapa       = null,
                                    $cd_matriz      = null){

        
        $matrizes = $this->buscar_matriz($cd_disciplina, $cd_etapa,$cd_matriz);
        $options = "";
        $retorno = "";
        
        
        //foreach ($matrizes as $matriz){ 
        // $i = 0;
        // foreach ($matrizes as $matriz){
        //     $i++;
        //     $dados[] = pg_fetch_assoc($matriz, $i);
        // } 
         
       $dados[] = $matrizes;
        
        $retorno = json_encode($matrizes, JSON_PRETTY_PRINT);


        // if ($cd_matriz){
        //     foreach ($matrizes as $matriz){
        //         $retorno = $matriz->ds_codigo;
        //     }

        // }else{
        //     if (count($matrizes) > 1){
        //         $options = "<option value=''>Selecione a matriz </option>";
        //     }
        //     foreach ($matrizes as $matriz){
        //         if (mb_strtoupper($ds_codigo, 'UTF-8') == mb_strtoupper($matriz->ds_codigo, 'UTF-8')){

        //             $options .= "<option value='{$matriz->ci_matriz}' selected>{$matriz->nm_matriz}</option>".PHP_EOL;
                    
        //         }else{
        //             $options .= "<option value='{$matriz->ci_matriz}'>{$matriz->nm_matriz}</option>".PHP_EOL;
        //         }
        //     }
        //     $retorno = $options;
        // }
        return $retorno;
    }
    
    public function atualizadescritorCaed($ci_matriz,$descritor){
        
        $dados['cd_usuario_altde']  = $this->session->userdata('ci_usuario');
        $dados['dt_altde']     = "now()";
        $dados['ds_descritorcaed']     = mb_strtoupper($descritor);

        $this->db->where('ci_matriz_descritor', $ci_matriz);
        return $this->db->update('tb_matriz_descritor', $dados);       
    }
}