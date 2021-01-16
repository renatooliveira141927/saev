<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Liberacao_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();
        
    }
    
    public function pesquisaLiberacao($params){
        
        $sql=" select * from tb_liberacaoinfrequencia 
                where nr_mes=".$params['nr_mes']." 
                        and cd_cidade_sme=".$params['cd_cidade_sme']." 
                        and nr_anoliberacao=".$params['nr_anoliberacao'];        
            $query=$this->db->query($sql);
            return $query->result();
    }
    
    public function pesquisaMesLiberacao(){
        
        $sql=" select mes as nr_mes,
        	case
        		when mes = 1 then upper('janeiro')
        		when mes = 2 then upper('fevereiro')
        		when mes = 3 then upper('março')
        		when mes = 4 then upper('abril')
        		when mes = 5 then upper('maio')
        		when mes = 6 then upper('junho')
        		when mes = 7 then upper('julho')
        		when mes = 8 then upper('agosto')
        		when mes = 9 then upper('setembro')
        		when mes = 10 then upper('outubro')
        		when mes = 11 then upper('novembro')
        		when mes = 12 then upper('dezembro')
        	end as descricao
        from (select generate_series(1, 12 , 1) as mes ) rec;";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function pesquisaMesLiberado($params){
        
        $sql=" select distinct nr_mes,
                	case when nr_mes=1 then 'JANEIRO'
                			when nr_mes=2 then 'FEVEREIRO'
                			when nr_mes=3 then 'MARÇO'
                			when nr_mes=4 then 'ABRIL'
                			when nr_mes=5 then 'MAIO'
                			when nr_mes=6 then 'JUNHO'
                			when nr_mes=7 then 'JULHO'
                			when nr_mes=8 then 'AGOSTO'
                			when nr_mes=9 then 'SETEMBRO'
                			when nr_mes=10 then 'OUTUBRO'
                			when nr_mes=11 then 'NOVEMBRO'
                			when nr_mes=12 then 'DEZEMBRO'
                	end as descricao
                from tb_liberacaoinfrequencia
                where nr_anoliberacao=".$params['nr_anoliberacao'];
        
        if($params['ci_grupousuario']>1){
                $sql.=" and cd_cidade_sme=".$params['cd_cidade_sme'];
        }
                $sql.=" and fl_ativo=true
                and extract(day from now())>10
                and extract(day from now())<=20";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function pesquisaMesLiberadoEscola($params){
        
        $sql=" select distinct nr_mes,
                	case when nr_mes=1 then 'JANEIRO'
                			when nr_mes=2 then 'FEVEREIRO'
                			when nr_mes=3 then 'MARÇO'
                			when nr_mes=4 then 'ABRIL'
                			when nr_mes=5 then 'MAIO'
                			when nr_mes=6 then 'JUNHO'
                			when nr_mes=7 then 'JULHO'
                			when nr_mes=8 then 'AGOSTO'
                			when nr_mes=9 then 'SETEMBRO'
                			when nr_mes=10 then 'OUTUBRO'
                			when nr_mes=11 then 'NOVEMBRO'
                			when nr_mes=12 then 'DEZEMBRO'
                	end as descricao
                from tb_liberacaoinfrequencia lf
                    inner join tb_escola e on lf.cd_cidade_sme=e.cd_cidade
                where nr_anoliberacao=".$params['nr_anoliberacao'];
        
        if($params['ci_grupousuario']==3){
            $sql.=" and e.ci_escola=".$params['ci_escola'];
        }
        $sql.=" and lf.fl_ativo=true
                and extract(day from now())>10
                and extract(day from now())<=20";
        $query=$this->db->query($sql);
        return $query->result();
    }
    
    public function selectLiberaMeses($params){
        $options = "<option value=''>Selecione o M&ecirc;s</option>";
        $meses = $this->pesquisaMesLiberacao($params);
        
        foreach ($meses as $mes){
            $options .= "<option value='{$mes->nr_mes}'>".trim($mes->descricao)."</option>".PHP_EOL;
        }
        return $options;
    }
    
    public function selectMesesLiberados($params){
        $options = "<option value=''>Selecione o M&ecirc;s</option>";
        $meses = $this->pesquisaMesLiberado($params);
        
        foreach ($meses as $mes){
            $options .= "<option value='{$mes->nr_mes}'>".trim($mes->descricao)."</option>".PHP_EOL;
        }
        return $options;
    }
    
    public function selectMesesLiberadosEscola($params){
        $options = "<option value=''>Selecione o M&ecirc;s</option>";
        $meses = $this->pesquisaMesLiberadoEscola($params);
        
        foreach ($meses as $mes){
            $options .= "<option value='{$mes->nr_mes}'>".trim($mes->descricao)."</option>".PHP_EOL;
        }
        return $options;
    }
    
}