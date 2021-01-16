<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 18/11/2018
 * Time: 20:25
 */

class InteligenciaPedagogica extends CI_Controller
{
    protected $titulo = 'Relatorio';
        

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');                           
        $this->load->model('avaliacoes_lancamento_model', 'modelavaliacoes_lancamento');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');
        $this->load->model('disciplina_model', 'modeldisciplina');
        $this->load->model('enturmacoes_model', 'modelenturmacao');        
        $this->load->model('gabarito_model', 'modelgabarito');
        $this->load->model('avaliacao_model', 'modelavaliacao');
        $this->load->model('infrequencia_model', 'modelinfrequencia');
        $this->load->model('edicao_model','modeledicoes');
        $this->load->model('topico_model', 'modeltopico');        
        $this->load->model('util_model','modelutil');
        $this->load->model('participacao_model','modelparticipacao');            
        $this->load->model('inteligenciapedagogica_model','inteligenciapedagogicamodel');
        
    }

    public function verifica_sessao($acao = null){
        if(!$this->session->userdata('logado')){
            if ($acao == 'rotina_ajax'){
                return 'sessaooff';
            }else{
                redirect(base_url('usuario/autenticacoes/login'));
            }
        }
    }

    public function turma(){
        
        $this->verifica_sessao();

        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/turma', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            $cd_cidade = $this->input->post('cd_cidade');
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $parames['nr_anoletivo'] = $nr_ano_letivo;
            $parames['cidade'] = $cd_cidade;
            $dados['avaliacoes'] = $this->inteligenciapedagogicamodel->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['nr_anoletivo']=$parames['nr_anoletivo'];
            
            $dados['topicos']=$this->inteligenciapedagogicamodel->buscaTopicosAvaliacao($params);
            //echo $this->db->last_query();die;
            $dados['pacertoturma']=$this->inteligenciapedagogicamodel->buscaResultadopacertoTurma($params);            
            $params['cd_escola']=$cd_escola;
            $dados['pacertoescola']=$this->inteligenciapedagogicamodel->buscaResultadopacertoescola($params);            
            $params['cd_cidade']=$cd_cidade;
            $dados['pacertocidade']=$this->inteligenciapedagogicamodel->buscaResultadopacertomunicipio($params);                        
            $dados['avaliacao']=$this->inteligenciapedagogicamodel->buscaItensAvaliacao($params);            
            $dados['distratores']=$this->inteligenciapedagogicamodel->buscadistratormaismarcado($params);            
            $dados['registrosDesc']=$this->inteligenciapedagogicamodel->buscaResultadoAlunoNew($params);            
            //echo $this->db->last_query(); die;
            
            $dados['totalacerto']=$this->inteligenciapedagogicamodel->totalacerto($params);            
            $dados['infrequencia']=$this->inteligenciapedagogicamodel->infrequencia($params['cd_turma']);            
            $dados['fluencia']=$this->inteligenciapedagogicamodel->avaliacao_leitura($params['cd_turma']);
            
            $params['nr_anoletivo']=$nr_ano_letivo;
            $dados['registrosDescMunicipio']=$this->inteligenciapedagogicamodel->buscaResultadoEscNew($params);
            $dados['registrosDescEpv']=$this->inteligenciapedagogicamodel->buscaResultadoMunNew($params);

            $this->load->view('inteligenciapedagogica/turma', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    
    public function aluno(){
        
        $this->verifica_sessao();
        
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/aluno', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $cd_aluno = $this->input->post('cd_aluno');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->inteligenciapedagogicamodel->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            
            $dados['alunos'] = $this->modelenturmacao->buscaUltimaEnturmacaoAluno($params);
            
            $params['cd_aluno'] = $cd_aluno;
            
            $dados['topicos']=$this->inteligenciapedagogicamodel->buscaTopicosAvaliacao($params);
            $dados['avaliacao']=$this->inteligenciapedagogicamodel->buscaAvaliacoesInteligencia($params);
            $dados['distratores']=$this->inteligenciapedagogicamodel->buscadistratormaismarcado($params);
            $dados['registrosDesc']=$this->inteligenciapedagogicamodel->buscaInteligenciaAluno($params);
            
            $params['nr_anoletivo']=$nr_ano_letivo;
            $params['cd_disciplina']=1;
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaAlunoDescritor($params);
            $dados['microcadosCaedMat']=$this->inteligenciapedagogicamodel->avaliacaocaedaluno($params);
            
            //print_r($dados['microcadosCaedMat']);die;
            //echo $this->db->last_query(); die;
            
            $params['cd_disciplina']=2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaAlunoDescritor($params);
            $dados['microcadosCaedPort']=$this->inteligenciapedagogicamodel->avaliacaocaedaluno($params);
            
            $dados['infrequencia']=$this->inteligenciapedagogicamodel->infrequencia($params['cd_turma'],$params['cd_aluno']);
            $dados['fluencia']=$this->inteligenciapedagogicamodel->avaliacao_leitura($params['cd_turma'],$params['cd_aluno']);
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcerto($params);
            
            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2){array_push($registroPacertoP,$valor);}
            }
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
            
            $dados['tstdescritor']=$this->inteligenciapedagogicamodel->testedescritores($params);
            $testeresultado=[];
            foreach ($this->inteligenciapedagogicamodel->testeresultado($params) as $valor){
                $testeresultado[$valor->cod_descritor]=$valor->cod_descritor;
            }
            
            $prova='';
            $caderno=[];
            foreach($dados['tstdescritor'] as $valor){                           
                if(array_key_exists($valor->cod_descritor,$testeresultado)){
                        $caderno[$valor->cod_descritor]='contem';
                }else{
                    $caderno[$valor->cod_descritor]='nao contem';
                }
            }
            //print_r($testeresultado); echo '<br>';
            //print_r($caderno);die;
            
            $this->load->view('inteligenciapedagogica/aluno', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function sinteseturma(){
        
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/sinteseturma', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');                                   
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $cd_aluno = $this->input->post('cd_aluno');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->inteligenciapedagogicamodel->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['nr_anoletivo']=$nr_ano_letivo;
            
            $dados['alunos'] = $this->modelenturmacao->buscaUltimaEnturmacaoAluno($params);
            
            $params['cd_aluno'] = $cd_aluno;
            
            $dados['topicos']=$this->inteligenciapedagogicamodel->buscaTopicosAvaliacao($params);
            $dados['avaliacao']=$this->inteligenciapedagogicamodel->buscaAvaliacoesInteligencia($params);
            $dados['distratores']=$this->inteligenciapedagogicamodel->buscadistratormaismarcado($params);
            $params['cd_disciplina']=1;            
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaTurma($params);
            //echo $this->db->last_query(); die;
            $dados['microcadosCaedMat']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseturma($params);
            

            $params['cd_disciplina']=2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaTurma($params);
            $dados['microcadosCaedPort']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseturma($params);
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcertoTurma($params);
            //echo $this->db->last_query();die;
            
            $dados['fluencia']=$this->inteligenciapedagogicamodel->avaliacaoturma_leitura($params);            
            
            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2){array_push($registroPacertoP,$valor);}
            }
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
                        
            $this->load->view('inteligenciapedagogica/sinteseturma', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function escola(){
        
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);            
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/escola', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;            
            $params['nr_anoletivo'] = $nr_ano_letivo;
                                                
            $params['cd_escola']=$cd_escola;
            $dados['pacertoescola']=$this->inteligenciapedagogicamodel->buscaResultadopacertoescola($params);
            //print_r($dados['pacertoescola']);die;                    
            $params['cd_cidade']=$cd_cidade;
            $dados['pacertocidade']=$this->inteligenciapedagogicamodel->buscaResultadopacertomunicipio($params);
            

            $dados['sintese']=$this->inteligenciapedagogicamodel->buscaResultadoEscolaLeitura($params);
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcertoEscola($params);
            $dados['registroTurma']=$this->inteligenciapedagogicamodel->buscaPercentAcertoTurmaEscola($params);
            //echo $this->db->last_query();die;
            $params['cd_disciplina'] = 1;
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaEscolaDescritor($params);
            $dados['microcadosCaedMat']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseescola($params);
            $params['cd_disciplina'] = 2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaEscolaDescritor($params);
            $dados['microcadosCaedPort']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseescola($params);
            
            $dados['fluencia']=$this->inteligenciapedagogicamodel->avaliacaoescola_leitura($params);

            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2){array_push($registroPacertoP,$valor);}
            }
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
            
            $this->load->view('inteligenciapedagogica/escola', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function municipio(){
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/municipio', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            
            $params['cd_etapa'] = $cd_etapa;            
            $params['nr_anoletivo'] = $nr_ano_letivo;
            
            $params['cd_cidade']=$cd_cidade;
            
            $dados['sintese']=$this->inteligenciapedagogicamodel->buscaSinteseMunicipio($params);
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcertoMunicipio($params);
            //print_r($dados['registroPacerto']);die;
            //echo $this->db->last_query();die;
            $dados['registroEscola']=$this->inteligenciapedagogicamodel->buscaPercentAcertoMunicipioEscola($params);            
            //print_r($dados['registroEscola']);die;
            //echo $this->db->last_query();die;
            
            $dados['fluencia']=$this->inteligenciapedagogicamodel->avaliacaomunicipio_leitura($params);
            
            //$dados['registrosDescM']=$this->inteligenciapedagogicamodel->buscaResultadoMunicipioNew($params);            
            $params['cd_disciplina'] = 1;
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaEscolaDescritor($params);
            
            $dados['microcadosCaedMat']=$this->inteligenciapedagogicamodel->avaliacaocaedsintesemunicipio($params);
            $params['cd_disciplina'] = 2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaEscolaDescritor($params);
            
                                
            $dados['microcadosCaedPort']=$this->inteligenciapedagogicamodel->avaliacaocaedsintesemunicipio($params);
            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){                
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2||$valor->cd_disciplina!=1){array_push($registroPacertoP,$valor);}
            }
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
            
            $this->load->view('inteligenciapedagogica/municipio', $dados);
            $this->load->view('template/html-footer');
            }
    }
    
    public function estado(){
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/estado', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_estado = $this->input->post('cd_estado');
            $cd_etapa = $this->input->post('cd_etapa');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            
            $params['cd_etapa'] = $cd_etapa;
            $params['nr_anoletivo'] = $nr_ano_letivo;
            $params['cd_estado']=$cd_estado;
            $dados['sintese']=$this->inteligenciapedagogicamodel->buscaSinteseEstado($params);
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcertoEstado($params);
            //echo $this->db->last_query();die;
            
            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2){array_push($registroPacertoP,$valor);}
            }
            
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
            
            //$dados['registroEscola']=$this->inteligenciapedagogicamodel->buscaPercentAcertoMunicipioEstado($params);
                       
            $params['cd_disciplina'] = 1;
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaEstadoDescritor($params);
            //echo $this->db->last_query(); die;
            $dados['microcadosCaedMat']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseestado($params);
            $params['cd_disciplina'] = 2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaEstadoDescritor($params);
            $dados['microcadosCaedPort']=$this->inteligenciapedagogicamodel->avaliacaocaedsinteseestado($params);
            
            //print_r($params);die;
            $dados['fluencia']=$this->inteligenciapedagogicamodel->buscaleituraestado($params);
            //echo $this->db->last_query(); die;
            $dados['registroCidade']=$this->inteligenciapedagogicamodel->buscaPercentAcertoCidadeEpv($params);
            
            $this->load->view('inteligenciapedagogica/estado', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function epv(){
       
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
            $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }
        
        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $cd_estado_temp=$this->input->post('cd_estado');
        $cd_cidade_temp=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        
        if ($this->session->userdata('ci_grupousuario')==3) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $parametro=$dados['escola'][0]->ci_escola;
            
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($parametro);
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $cd_cidade_temp=$this->input->post('cd_cidade');
            $nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('inteligenciapedagogica/epv', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_estado = $this->input->post('cd_estado');
            $cd_etapa = $this->input->post('cd_etapa');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            
            $params['cd_etapa'] = $cd_etapa;
            $params['nr_anoletivo'] = $nr_ano_letivo;
            $params['cd_estado']=$cd_estado;
            $dados['sintese']=$this->inteligenciapedagogicamodel->buscaSinteseEpv($params);
                        
            $dados['registroPacerto']=$this->inteligenciapedagogicamodel->buscaPercentAcertoEpv($params);
            //echo $this->db->last_query();die;
            //print_r($dados['registroPacerto']);die;
            
            $registroPacertoM=[];
            $registroPacertoP=[];
            foreach ($dados['registroPacerto'] as $valor){
                if($valor->cd_disciplina==1){array_push($registroPacertoM,$valor);}
                if($valor->cd_disciplina==2){array_push($registroPacertoP,$valor);}
            }
            $dados['registroPacertoM']=$registroPacertoM;
            $dados['registroPacertoP']=$registroPacertoP;
            
            $dados['registroEscola']=$this->inteligenciapedagogicamodel->buscaPercentAcertoEstadoEpv($params);
            //echo $this->db->last_query();die;
            //print_r($dados['registroEscola']);die;
            $dados['registroCidade']=$this->inteligenciapedagogicamodel->buscaPercentAcertoCidadeEpv($params);
            //print_r($dados['registroCidade']);die;
            //echo $this->db->last_query();die;
            //$dados['registrosDesc']=$this->inteligenciapedagogicamodel->buscaResultadoEpv($params);
            $params['cd_disciplina'] = 1;
            $dados['registrosDescMat']=$this->inteligenciapedagogicamodel->buscaInteligenciaEPVDescritor($params);
            //echo $this->db->last_query();die;
            $params['cd_disciplina'] = 2;
            $dados['registrosDescPort']=$this->inteligenciapedagogicamodel->buscaInteligenciaEPVDescritor($params);
            
            $dados['fluenciaepv']=$this->inteligenciapedagogicamodel->buscaleituraepv($params);
            $dados['fluenciaepvmunicipio']=$this->inteligenciapedagogicamodel->buscaleituraepvmunicipio($params);
            //print_r($dados['fluenciaepvmunicipio']);die;
            //echo $this->db->last_query();die;
            
            $dados['fluenciacidade']=$this->inteligenciapedagogicamodel->avaliacaocidadeleituraepv($params);

            //print_r($dados['fluencia']);die;
            
            
            $this->load->view('inteligenciapedagogica/epv', $dados);
            $this->load->view('template/html-footer');
        }
    }
}