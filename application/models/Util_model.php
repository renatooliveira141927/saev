<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Util_model extends CI_Model {
    public function __construct(){
        parent::__construct();
        
    }
    
    function buscarMeses(){
        $sql="				select mes,					
					case when mes=1 and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =02 
						)
					then upper('janeiro')
                    when mes=2 and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =03 
						)
					then upper('fevereiro')
                    when mes=3  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =04 
						)
					then upper('março')
                    when mes=4  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =05 
						)then upper('abril')
                    when mes=5  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =06 
						)then upper('maio')
                    when mes=6  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =07 
						)then upper('junho')
                    when mes=7  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =08 
						)then upper('julho')
                    when mes=8  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =09 
						)then upper('agosto')
                    when mes=9  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =10 
						)then upper('setembro')
                    when mes=10  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =11 
						)then upper('outubro')
                    when mes=11  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =12 
						)then upper('novembro')
                    when mes=12  and ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =01 
						)then upper('dezembro')
                    end as descricao from ( 

			select distinct case when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =02 
						) then 1 
						when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =03 
						) then 2
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =04 
						) then 3
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =05 
						)then 4
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =06 
						)then 5
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =07 
						)then 6
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =08 
						)then 7
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =09 
						)then 8
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =10 
						)then 9
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =11 
						)then 10
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =12 
						)then 11
                    when ( 
							extract (day from now())::integer <=10 and 
							extract( month from now())::integer =01 
						)then 12 end as mes
            from (
                    select generate_series(1, 12 , 1) as mes                     
                 )res
                 
           ) cont;";
        
        $query=$this->db->query($sql);
        return $query->result();        
    }
    
   public function selectMeses(){
        $options = "<option value=''>Selecione o M&ecirc;s</option>";
        $meses = $this->buscarMeses();
        
        foreach ($meses as $mes){            
            $options .= "<option value='{$mes->mes}'>".trim($mes->descricao)."</option>".PHP_EOL;
        }
        return $options;
    }
	
	
	public function buscarAnoLetivo(){
		$sql="select distinct nr_ano_letivo as anoletivo from tb_turma t where t.fl_ativo =true order by 1 desc";
		$query=$this->db->query($sql);
        return $query->result();   
	}

	public function selectAnoletivo($anoatual=null){		
        $options = "<option value=''>Selecione um Ano Letivo</option>";
        $anos = $this->buscarAnoLetivo();
        
        foreach ($anos as $ano){
			if($ano->anoletivo == $anoatual){
				$options .= "<option value='{$ano->anoletivo}' selected >".trim($ano->anoletivo)."</option>".PHP_EOL;
			}else{
				$options .= "<option value='{$ano->anoletivo}'>".trim($ano->anoletivo)."</option>".PHP_EOL;
			}            
            
        }
        return $options;
	}	
}