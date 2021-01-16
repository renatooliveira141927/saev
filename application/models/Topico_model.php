<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 05/12/2018
 * Time: 15:57
 */

class Topico_model extends CI_Model
{
    public function __construct(){
        parent::__construct();

    }

    public function buscaTopicosAvaliacao($params){
        $sql="select distinct mt.* from tb_matriz_topico mt 
                inner join tb_matriz_descritor md
	                  on mt.ci_matriz_topico=md.cd_matriz_topico 		
                inner join tb_avaliacao_matriz am
                      on am.cd_matriz_descritor=md.ci_matriz_descritor
              where am.cd_avaliacao_upload=".$params['cd_avaliacao']."order by 1";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function selectTopicos($avaliacao){
        $params['cd_avaliacao']=$avaliacao;

        $topicos = $this->buscaTopicosAvaliacao($params);

        $options = "<option value='0' >Todos </option>";        
        foreach ($topicos as $topico){
            $options .= "<option value='{$topico->ci_matriz_topico}'>{$topico->nm_matriz_topico}</option>".PHP_EOL;
        }
        return $options;

    }

}