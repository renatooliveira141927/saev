<?php
/**
 * Created by PhpStorm.
 * User: retan
 * Date: 18/11/2018
 * Time: 20:25
 */

class Relatorio extends CI_Controller
{
    protected $titulo = 'Relatorio';
        

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        //$this->load->library('phpexcel');
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

    public function index(){
        $this->porEscola();
    }
    //PARTE DE RELATÓRIOS DA PARTE ESCRITA
    public function porEscola(){

        $this->verifica_sessao();
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $cd_etapa = $this->input->post('cd_etapa');
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');

        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }


        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/estudante', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registros']=$this->modelavaliacoes_lancamento->buscaResultadoAlunoTopico($params);
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaResultadoAlunoDescritor($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/estudante', $dados);
            $this->load->view('template/html-footer');
        }
    }

    public function pesquisaErrosAcertos(){
        
        $this->verifica_sessao();
        
        $cd_estado=$this->input->post('cd_estado');
        $cd_cidade=$this->input->post('cd_cidade');
        
        $id_estado =!empty($cd_estado)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade)?$this->input->post('cd_cidade'):NULL;
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
        	$cid_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cid_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();                        
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);            
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/acertos_erros', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['avaliacao']=$this->modelavaliacao->buscaItensAvaliacao($params);            
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaResultadoAluno($params);
            //$dados['registroPacerto']=$this->modelavaliacoes_lancamento->buscaPercentAcerto($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/acertos_erros', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function pesquisaErrosAcertosnew(){
        
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
            $this->load->view('relatorio/acertos_errosnew', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            
            $dados['avaliacao']=$this->modelavaliacao->buscaItensAvaliacao($params);
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaResultadoAlunoNew($params);
            //$dados['registroPacerto']=$this->modelavaliacoes_lancamento->buscaPercentAcerto($params);
            //echo $this->db->last_query(); die;
            
            $this->load->view('relatorio/acertos_errosnew', $dados);
            $this->load->view('template/html-footer');
        }
    }
    

    public function pesquisaPorNivelDesempenho(){
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   
        $dados['dataLimite']=$this->input->post('datalimite');

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
            
            //echo $this->db->last_query();die;
        }else{
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme,$nr_inep);
                        
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/nivel_desempenho', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_escola'] = $this->input->post('cd_escola');

            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->pesquisaPorNivelDesempenho($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/nivel_desempenho', $dados);
            $this->load->view('template/html-footer');
        }
    }
    //fim de relatório da parte escrita
    //PARTE DE RELATÓRIOS DE LEITURA
    public function pesquisaAvaliacaoLeituraAluno(){
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
            
        }else if ($this->session->userdata('ci_grupousuario') == 2) {
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
            
        }else if ($this->session->userdata('ci_grupousuario') == 1) {
        	$nr_inep_escola=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $id_cidade?$id_cidade:$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme,$nr_inep);
        }
        
        $dados['titulo'] = $this->titulo;
        $dados['nr_inep']='';
        $dados['nm_escola']='';
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        $dados['turmas'] = $this->modelturma->buscar();
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/avaliacao_leitura_aluno', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $parames['nr_anoletivo'] = $dados['anoatual'];
            $parames['cd_cidade']= $this->input->post('cd_cidade');
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacaoLeitura($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_escola'] = $this->input->post('cd_escola');

            $dados['registrosDesc'] = $this->modelenturmacao->buscaEnturmacaoLeitura($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/avaliacao_leitura_aluno', $dados);
            $this->load->view('template/html-footer');
        }
    }

    public function percAcertoHabilidadeAvaliada(){

        $this->verifica_sessao();

        $dados['anoatual']= 0;
        
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $cd_etapa = $this->input->post('cd_etapa');
        $dados['estado'] = $this->modelestado->selectEstados();
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');

        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }


        $dados['titulo'] = $this->titulo;
        $dados['nr_inep']='';
        $dados['nm_escola']='';
        
        if ($this->session->userdata('ci_grupousuario') == 3) {
            $params['ci_escola']=$this->session->userdata('ci_escola');
        }
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        $parametro=isset($dados['ci_escola'])?$dados['ci_escola']:NULL;
        $dados['etapas'] = $this->modeletapa->buscaOfertaEscola($parametro);
        $dados['turmas'] = $this->modelturma->buscar();

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/habilidadeAvaliada', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registros']=$this->modelavaliacoes_lancamento->buscaResultadoAlunoTopico($params);
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaResultadoAlunoDescritor($params);
            echo $this->db->last_query(); die;

            $this->load->view('relatorio/habilidadeAvaliada', $dados);
            $this->load->view('template/html-footer');
        }

    }

    public function partials(){
        $action = ($this->uri->segment ( 3 ));
        //print_r($action);die;

        if ($action == 'buscar') {

            $cd_avaliacao = ($this->uri->segment ( 4 ));
            $cd_disciplina= ($this->uri->segment ( 5 ));
            $cd_turma = ($this->uri->segment ( 6 ));
            $cd_etapa = ($this->uri->segment ( 7 ));
            $cd_escola = ($this->uri->segment ( 8 ));
            
            $cd_topico = $_POST['cd_topico'];

            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;
            $params['cd_topico'] = $cd_topico;

            $result = $this->modelavaliacoes_lancamento->buscaResultadoTopico($params);
            //echo $this->db->last_query();die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaomunicipio') {
            
            $cd_disciplina= ($this->uri->segment ( 4 ));            
            $cd_etapa = ($this->uri->segment ( 5 ));            
            $cd_cidade = ($this->uri->segment ( 6 ));    
            $nr_anoletivo = ($this->uri->segment ( 7 ));
            $dados['estado'] = $this->modelestado->selectEstados();
            $params['cd_disciplina'] = $cd_disciplina;            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_cidade'] = $cd_cidade?$cd_cidade:$this->session->userdata('cd_cidade_sme');
            $params['nr_anoletivo']=$nr_anoletivo;

            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoMunicipio($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

         if ($action == 'evolucaomunicipioano') {
            
            $cd_disciplina= ($this->uri->segment ( 4 ));            
            $cd_etapa = ($this->uri->segment ( 5 ));            
            $cd_cidade = ($this->uri->segment ( 6 ));   
            $nr_anoletivo = ($this->uri->segment ( 7 )); 
            $dados['estado'] = $this->modelestado->selectEstados();
            $params['cd_disciplina'] = $cd_disciplina;            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_cidade'] = $cd_cidade?$cd_cidade:$this->session->userdata('cd_cidade_sme');
            $params['nr_anoletivo']=$nr_anoletivo;
            
            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoMunicipioAno($params);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaoescola') {
            
            $cd_disciplina= ($this->uri->segment ( 4 ));            
            $dados['estado'] = $this->modelestado->selectEstados();
            $cd_etapa = ($this->uri->segment ( 5 ));
            $cd_escola = ($this->uri->segment ( 6 ));
            $nr_anoletivo = ($this->uri->segment ( 7 ));
            $params['cd_disciplina'] = $cd_disciplina;        
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;
            $params['nr_anoletivo']=$nr_anoletivo;
            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoEscola($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

         if ($action == 'evolucaoturma') {
                        
            $cd_disciplina= ($this->uri->segment ( 4 ));
            $cd_turma = ($this->uri->segment ( 5 ));
            $cd_etapa = ($this->uri->segment ( 6 ));
            $cd_escola = ($this->uri->segment ( 7 ));
            $nr_anoletivo = ($this->uri->segment ( 8 ));
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;
            $params['nr_anoletivo']=$nr_anoletivo;
            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoTurma($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaoaluno') {
            
            $cd_disciplina= ($this->uri->segment ( 4 ));
            $cd_turma = ($this->uri->segment ( 5 ));
            $cd_etapa = ($this->uri->segment ( 6 ));
            $cd_escola = ($this->uri->segment ( 7 ));
            $nr_anoletivo = ($this->uri->segment ( 8 ));
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;
            $params['nr_anoletivo']=$nr_anoletivo;
            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'topicodescritor') {
            $cd_edicao= $this->input->post('cd_edicao');
            $cd_disciplina= $this->input->post('cd_disciplina');
            $ci_topico= $this->input->post('ci_matriz_topico');
            $cd_cidade= $this->input->post('cd_cidade');
            $rd_rel= $this->input->post('rd_rel');

            $params['ci_topico']=$ci_topico;
            $params['cd_edicao']=$cd_edicao;
            $params['rd_rel']=$rd_rel;
            $params['cd_disciplina']=$cd_disciplina;
            $params['cd_cidade']=$cd_cidade?$cd_cidade:$this->session->userdata('cd_cidade_sme');
            $result =$this->modelavaliacoes_lancamento->buscaTopicoDescritorNova($params);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if($action=='munleituraescola'){

            $cd_etapa = ($this->uri->segment ( 4 )); 
            $cd_turma = ($this->uri->segment ( 5 ));
            $cd_disciplina= ($this->uri->segment ( 6 ));                        
            $cd_avaliacao = ($this->uri->segment ( 7 ));            

            $params['cd_etapa']=$cd_etapa;
            $params['cd_turma']=$cd_turma;
            $params['cd_disciplina']=$cd_disciplina;
            $params['cd_avaliacao']=$cd_avaliacao;        
            
            $result =$this->modelenturmacao->graficoEnturmacaoLeituraEscola($params);
            //print_r($this->db->last_query());die;
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));   
        }
        
        if($action=='munleituraescolaano'){

            $cd_etapa = ($this->uri->segment ( 4 )); 
            $cd_turma = ($this->uri->segment ( 5 ));
            $cd_disciplina= ($this->uri->segment ( 6 ));                        
            $cd_avaliacao = ($this->uri->segment ( 7 ));            

            $params['cd_etapa']=$cd_etapa;
            $params['cd_turma']=$cd_turma;
            $params['cd_disciplina']=$cd_disciplina;
            $params['cd_avaliacao']=$cd_avaliacao;        
            
            $result =$this->modelenturmacao->graficoEnturmacaoLeituraEscolaAno($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));   
        }        
        
        if($action=='niveldesempenhomunicipioalunos'){
            $cd_nivel= $this->input->post('cd_nivel');
            $cd_topico = $this->input->post('cd_topico');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $cd_cidade = $this->input->post('cd_cidade');
            
            $params['cd_nivel']=$cd_nivel;
            $params['cd_topico']=$cd_topico;
            $params['cd_avaliacao']=$cd_avaliacao;
            $params['cd_cidade']=$cd_cidade;
            
            $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagemMunicipio($params);
            //echo $this->db->last_query();die;
            
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
        }
        
            if($action=='niveldesempenhoalunos'){
                $cd_nivel= $this->input->post('cd_nivel');
                $cd_turma = $this->input->post('cd_turma');
                $cd_avaliacao = $this->input->post('cd_avaliacao');
                $cd_cidade = $this->input->post('cd_cidade');
                
                $params['cd_nivel']=$cd_nivel;
                $params['cd_turma']=$cd_turma;
                $params['cd_avaliacao']=$cd_avaliacao;
                $params['cd_cidade']=$cd_cidade;
                
                $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagem($params);
               //print_r($this->db->last_query());
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));   
            }
        
       
            if ($action == 'infrequencia') {
                
                $cd_turma = ($this->input->post('cd_turma'));
                $cd_aluno= ($this->input->post('cd_aluno'));
                
                $params['cd_turma'] = $cd_turma;
                $params['cd_aluno'] = $cd_aluno;
                
                $result = $this->modelinfrequencia->buscaInfrequenciaAluno($params);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            
            if($action=='munleiturames'){
                
                $cd_etapa = ($this->uri->segment ( 4 ));
                $cd_cidade = ($this->uri->segment ( 5 ));
                $cd_disciplina= ($this->uri->segment ( 6 ));                
                $cd_anoletivo = ($this->uri->segment ( 7 ));
                
                $params['cd_etapa']=$cd_etapa;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_disciplina']=$cd_disciplina;                
                $params['cd_anoletivo']=$cd_anoletivo;
                $result =$this->modelenturmacao->graficoEnturmacaoLeituraMunicipioMes($params);
                //echo $this->db->last_query();die;
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            if($action=='munleituraano'){
                
                $cd_etapa = ($this->uri->segment ( 4 ));
                $cd_cidade = ($this->uri->segment ( 5 ));
                $cd_disciplina= ($this->uri->segment ( 6 ));
                $cd_avaliacao = ($this->uri->segment ( 7 ));
                
                $params['cd_etapa']=$cd_etapa;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_disciplina']=$cd_disciplina;
                $params['cd_avaliacao']=$cd_avaliacao;
                
                $result =$this->modelenturmacao->graficoEnturmacaoLeituraMunicipioAno($params);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            
            if($action=='conferenciaEnturmacaoEscola'){
                $cd_estado = ($this->uri->segment ( 4 ));
                $cd_cidade = ($this->uri->segment ( 5 ));
                $cd_escola = ($this->uri->segment ( 6 ));
                
                $params['cd_estado']=$cd_estado;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_escola']=$cd_escola;
                //$result =$this->modelenturmacao->relatorioEnturmacao($params);
                $dados['registros'] = $this->modelenturmacao->relatorioEnturmacaoEscola($params);
                
                $dados['total_registros'] = count($dados['registros']);
                $this->load->view('relatorio/listagemEnturmacaoEscola', $dados);
            }

            if($action=='conferenciaEnturmacao'){
                $cd_estado = ($this->uri->segment ( 4 ));
                $cd_cidade = ($this->uri->segment ( 5 ));
                $cd_escola = ($this->uri->segment ( 6 ));

                $params['cd_estado']=$cd_estado;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_escola']=$cd_escola;
                //$result =$this->modelenturmacao->relatorioEnturmacao($params);
                $dados['registros'] = $this->modelenturmacao->relatorioEnturmacao($params);
                //echo $this->db->last_query(); die;
                $dados['total_registros'] = count($dados['registros']);
                $this->load->view('relatorio/listagemConferenciaEnturmacao', $dados);                
            }
            
            if($action=='cadernoProva'){
                $cd_estado = ($this->uri->segment ( 4 ));
                $cd_cidade = ($this->uri->segment ( 5 ));
                $cd_avaliacao = ($this->uri->segment ( 6 ));

                $params['cd_estado']=$cd_estado;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_avaliacao']=$cd_avaliacao;
                $dados['registros'] =$this->modelavaliacao->cadernoProva($params);
                $dados['total_registros'] = count($dados['registros']);                
                //echo $this->db->last_query(); die;                
                $this->load->view('relatorio/listagemCadernoProva', $dados);                
            }
       
    }
    //parte para o grupo de municipio
    public function munNivelAprendizagem(){
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

        if ($this->session->userdata('ci_grupousuario') == 1) {        	
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola=$this->input->post('nr_inep_escola');
        
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else if ($this->session->userdata('ci_grupousuario') == 2) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');            
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }else{
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/munNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{            
            $dados['anoatual']=             
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $parames['nr_anoletivo']=$this->input->post('nr_anoletivo');
            $parames['cidade']=$this->input->post('cd_cidade');  
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_cidade']=$id_cidade;
            $params['topicos']=$this->input->post('cd_topico');            
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->pesquisaPorNivelDesempenho($params);
            //echo $this->db->last_query(); die;
            
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $dados['topicos']=$this->modeltopico->buscaTopicosAvaliacao($params);
            
            $this->load->view('relatorio/munNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function escNivelAprendizagem(){
        $this->verifica_sessao();
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
        
        if ($this->session->userdata('ci_grupousuario') == 1) {        	
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else if ($this->session->userdata('ci_grupousuario') == 2) {
        
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }else{
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->session->userdata('ci_escola');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);            
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/escNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->pesquisaPorNivelDesempenho($params);
            
            //print_r($dados['registrosDesc']);die;
            //echo $this->db->last_query(); die;
            
            $this->load->view('relatorio/escNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munEscrita(){
        $this->verifica_sessao();
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
        
        //echo sizeof($params['ci_escola']);die;
        
        if(sizeof($params['ci_escola'])>1){
            //print_r($params);die;
            $dados['escola'] = $this->modelescola->buscaEscolas($params);
        }else{
            $params['cd_cidade']=$id_cidade;
            //print_r($params);die;
            $dados['escola'] = $this->modelescola->buscaArrayEscolaUsuario($params);
        }
        
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario') == 1) {        	
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
            
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/munEscrita', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_escola = !empty($_POST['cd_escola'])?$_POST['cd_escola']:NULL;
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');            
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_cidade']=$id_cidade;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            if(sizeof($cd_escola)>=1){
                $params['cd_escola']=implode(",",$cd_escola);
            }else{
                $params['cd_escola']=$cd_escola;
            }
            
            $dados['avaliacao']=$this->modelavaliacao->buscaDescritoresAvaliacao($params);
            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaResultadoEscolaDescritor($params);
            $this->load->view('relatorio/munEscrita',$dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munEscritaEscola(){
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	  
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        if(sizeof($params['ci_escola'])>1){                    
            $dados['escola'] = $this->modelescola->buscaEscolas($params);
        }else{
            $params['cd_cidade']=$id_cidade;
            $dados['escola'] = $this->modelescola->buscaArrayEscolaUsuario($params);
        }
        
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        if ($this->session->userdata('ci_grupousuario') == 1) {
        	//$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/munEscritaEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_escola = !empty($_POST['cd_escola'])?$_POST['cd_escola']:NULL;
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');            
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
                        
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_cidade']=$id_cidade;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            if(sizeof($cd_escola)>=1){
                $params['cd_escola']=implode(",",$cd_escola);
            }else{
                $params['cd_escola']=$cd_escola;
            }

            $dados['avaliacao']=$this->modelavaliacao->buscaDescritoresAvaliacao($params);
            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaResultadoEscolaDescritor($params);
            $dados['totalDesc'] = $this->modelavaliacoes_lancamento->buscaTotalResultadoDescritor($params);

            $this->load->view('relatorio/munEscritaEscola',$dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munescritaescolaexcel(){
       
        $params['cd_cidade']=$this->uri->segment ( 3 );
        $params['cd_etapa'] = $this->uri->segment ( 4 );        
        $params['cd_disciplina'] = $this->uri->segment ( 5 );
        $params['cd_avaliacao'] = $this->uri->segment ( 6 );        
        $dados['avaliacao']=$this->modelavaliacao->buscaDescritoresAvaliacao($params);
        $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaResultadoEscolaDescritor($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=munescritaescola.xls");
        header("Pragma: no-cache");
        echo '<table class="table table-striped table-hover">
        <tr>
        <th> Escola</th>
        <th>  </th>';
        if( isset($dados['avaliacao']) ){
            foreach($dados['avaliacao'] as $item){
                    echo '<th align="center">'.$item->ds_codigo.'</th>';
             } 
        }
                    echo '<th align="center"> % Acerto</th> </tr>';
                    if( isset($dados['registrosDesc']) ){
                            $escolaAtual="";
                            $acertos=0;
                            $total=0;
                            $contagem=count(array_keys($dados['registrosDesc']))-1;
                            foreach($dados['registrosDesc'] as $resultado =>$item){
                                $chaveAtual=$resultado;

                                if($escolaAtual!="" && $escolaAtual!=$item->nm_escola){
                                    $pacertos =round(( ($nr_acertos*100)/$total),2);                                    
                                    echo '<td  align="center"';
                                        if($pacertos<=50){
                                            echo 'style="color: white; background:#E60000"';
                                        } 
                                        if($pacertos>50 && $pacertos<=70){                                        
                                            echo 'style="color: white; background:#FF9900"';
                                        }
                                        if($pacertos>70){
                                            echo 'style="color: white; background:#006600"';
                                        }     
                                        echo '>'.$pacertos.'</td>';
                                        $pacertos=0;
                                        $nr_acertos=0;
                                        $total=0; }
                                if($item->nm_escola!=$escolaAtual){
                                        $nr_acertos=0;
                                        $total=0;
                                        echo '<tr>
                                        <td>'.$item->nm_escola.'</td><td>% Qtd</td>';
                                }

                                        $nr_acertos=$nr_acertos+$item->acertos;
                                        $total+=$item->questoes;
                                        $escolaAtual=$item->nm_escola; 
                                        echo '<td align="center">'.$item->pacerto.'<br/>'.$item->acertos.'</td>';                                

                                    if ($escolaAtual != "" && $chaveAtual==$contagem) {
                                        $pacertos =round(( ($nr_acertos*100)/($total)),2);                                    
                                        echo '<td  align="center"';
                                        if($pacertos<=50){
                                            echo 'style="color: white; background:#E60000"';
                                        }
                                        if($pacertos>50 && $pacertos<=70){                                        
                                            echo 'style="color: white; background:#FF9900"';
                                        }
                                        if($pacertos>70){
                                            echo 'style="color: white; background:#006600"';
                                        }     
                                        echo '>'.$pacertos.'</td>';
                                    $pacertos=0;$nr_acertos=0;$total=0;
                                }                                
                            }
                            echo '</tr>';
                        }                    
                        echo '</table>';
        
    }
    
    public function munLeituraEscola(){
        $this->verifica_sessao();
        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
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

        if ($this->session->userdata('ci_grupousuario') == 1) {
        	//$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/munLeituraEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registrosDesc'] = $this->modelenturmacao->buscaEnturmacaoLeituraEscola($params);

            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/munLeituraEscola', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function leituraEscola(){
        $this->verifica_sessao();
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        if ($this->session->userdata('ci_grupousuario') == 1) {
        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
            $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $dados['estado'] = $this->modelestado->selectEstados($id_estado);
            $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
            
        }else if($this->session->userdata('ci_grupousuario') == 2) {
        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
            $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $dados['estado'] = $this->modelestado->selectEstados($id_estado);
            $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }else{
                $params['ci_escola']=$this->session->userdata('ci_escola');            
                $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
                foreach ($dados['escola']as $escola){
                    $dados['nr_inep']= $escola->nr_inep;
                    $dados['nm_escola']= $escola->nm_escola;
                    $dados['ci_escola']= $escola->ci_escola;
                }                
                $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($params['ci_escola']);
        }
         
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/leituraEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            
            $dados['registrosDesc'] = $this->modelenturmacao->buscaEnturmacaoLeituraEscola($params);
            
            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/leituraEscola', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munLeitura(){
        $this->verifica_sessao();
        
        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
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
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/munLeitura', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacaoLeitura($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            
            $dados['registrosDesc'] = $this->modelenturmacao->buscaEnturmacaoLeituraEscola($params);
            
            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/munLeitura', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munleituramesexcel(){
        $this->verifica_sessao();        
        $cd_etapa = ($this->uri->segment ( 3 ));
        $cd_cidade = ($this->uri->segment ( 4 ));
        $cd_disciplina= ($this->uri->segment ( 5 ));
        $cd_anoletivo= ($this->uri->segment ( 6 ));
        
        $params['cd_etapa']=$cd_etapa;
        $params['cd_cidade']=$cd_cidade;
        $params['cd_disciplina']=$cd_disciplina;       
        $params['cd_anoletivo']=$cd_anoletivo;
        
        $result = $this->modelenturmacao->graficoEnturmacaoLeituraMunicipioMes($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=munleituraexcel.xls");
        header("Pragma: no-cache");
        echo '<table>
                    <tr>
                        <td>Cidade</td>
                        <td>Mes</td>
                        <td>Avaliação</td>                          
                        <td>Leitor_Fluente</td> 
                        <td>Leitor_SemFluencia</td>
                        <td>Leitor_Frase</td>
                        <td>Leitor_Palavra</td>
                        <td>Leitor_Silaba</td>
                        <td>Nao_Leitor</td>
                        <td>Nao_Avaliado</td> 
                </tr>';
        $contador=1;
        foreach ($result as $key=>$value){
            $contador++;
            echo "<tr>
                    <td>".$value->nm_cidade."</td>
                    <td>".$value->mes."</td>
                    <td>".$value->nm_caderno."</td>
                    <td>".$value->leitor_fluente."</td>
                    <td>".$value->leitor_sfluente."</td>
                    <td>".$value->leitor_frase."</td>
                    <td>".$value->leitor_palavra."</td> 
                    <td>".$value->leitor_silaba."</td>
                    <td>".$value->nao_leitor."</td>
                    <td>".$value->nao_avaliado."</td></tr>";
        }
        echo '</table>';
    }
    
    public function munleituraanoexcel(){
        $this->verifica_sessao();
        $cd_etapa = ($this->uri->segment ( 3 ));
        $cd_cidade = ($this->uri->segment ( 4 ));
        $cd_disciplina= ($this->uri->segment ( 5 ));
        
        $params['cd_etapa']=$cd_etapa;
        $params['cd_cidade']=$cd_cidade;
        $params['cd_disciplina']=$cd_disciplina;
        
        $result = $this->modelenturmacao->graficoEnturmacaoLeituraMunicipioAno($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=munleituraexcel.xls");
        header("Pragma: no-cache");
        echo '<table>
                    <tr>
                        <td>Cidade</td>
                        <td>Ano</td>
                        <td>Leitor_Fluente</td>
                        <td>Leitor_SemFluencia</td>
                        <td>Leitor_Frase</td>
                        <td>Leitor_Palavra</td>
                        <td>Leitor_Silaba</td>
                        <td>Nao_Leitor</td>
                        <td>Nao_Avaliado</td>
                </tr>';
        $contador=1;
        foreach ($result as $key=>$value){
            $contador++;
            echo "<tr>
                    <td>".$value->nm_cidade."</td>
                    <td>".$value->ano."</td>
                    <td>".$value->leitor_fluente."</td>
                    <td>".$value->leitor_sfluente."</td>
                    <td>".$value->leitor_frase."</td>
                    <td>".$value->leitor_palavra."</td>
                    <td>".$value->leitor_silaba."</td>
                    <td>".$value->nao_leitor."</td>
                    <td>".$value->nao_avaliado."</td></tr>";
        }
        echo '</table>';
    }
    
    public function munleituraescolaexcel(){
        $this->verifica_sessao();
        
        $cd_escola = ($this->uri->segment ( 3 ));
        $cd_etapa = ($this->uri->segment ( 4 ));
        $cd_turma = ($this->uri->segment ( 5 ));
        $cd_disciplina= ($this->uri->segment ( 6 ));        
        $nm_turma= str_replace('%C3%A3','a',
                    str_replace("%20",' ',($this->uri->segment ( 7 )) )
                    );
                
        $params['cd_escola']=$cd_escola;
        $params['cd_etapa']=$cd_etapa;
        $params['cd_turma']=$cd_turma;
        $params['cd_disciplina']=$cd_disciplina;
        
        $result =$this->modelenturmacao->graficoEnturmacaoLeituraEscola($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=munleituraescolaexcel.xls");
        header("Pragma: no-cache");
        echo '<table>
                    <tr>
                        <td>Escola</td>
                        <td>Mes</td>
                        <td>Turma</td>
                        <td>Avaliação</td>
                        <td>Leitor_Fluente</td>
                        <td>Leitor_SemFluencia</td>
                        <td>Leitor_Frase</td>
                        <td>Leitor_Palavra</td>
                        <td>Leitor_Silaba</td>
                        <td>Nao_Leitor</td>
                        <td>Nao_Avaliado</td>
                </tr>';
        $contador=1;
        foreach ($result as $key=>$value){
            $contador++;
            echo "<tr>
                    <td>".$value->nm_escola."</td>
                    <td>".$value->mes."</td>
                    <td>".$nm_turma."</td>
                    <td>".$value->nm_caderno."</td>
                    <td>".$value->leitor_fluente."</td>
                    <td>".$value->leitor_sfluente."</td>
                    <td>".$value->leitor_frase."</td>
                    <td>".$value->leitor_palavra."</td>
                    <td>".$value->leitor_silaba."</td>
                    <td>".$value->nao_leitor."</td>
                    <td>".$value->nao_avaliado."</td></tr>";
        }
        echo '</table>';
    }
    
    
    public function estadoLeitura(){
        $this->verifica_sessao();
        $this->carregaTemplate();

        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $dados['disciplinas'] = $this->modeldisciplina->buscar();
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }
        
        $cd_etapa_temp=$this->input->post('cd_etapa');
        $cd_disciplina_temp=$this->input->post('cd_disciplina');
        $cd_avaliacao_temp=$this->input->post('cd_avaliacao');
        
        $id_etapa =!empty($cd_etapa_temp)?$this->input->post('cd_etapa'):NULL;
        $id_disciplina =!empty($cd_disciplina_temp)?$this->input->post('cd_disciplina'):NULL;
        $id_avaliacao =!empty($cd_avaliacao_temp)?$this->input->post('cd_avaliacao'):NULL;
        
        if($id_estado!=null && $id_cidade!=null && $id_etapa!=null && $id_disciplina!=null ){
            $params['estado']=$id_estado;
            $params['cd_cidade']=$id_cidade;
            $params['cd_etapa']=$id_etapa;
            $params['cd_disciplina']=$id_disciplina;
            $params['cd_avaliacao']=$id_avaliacao;
            $parames['cd_etapa'] = $id_etapa;
            $parames['cd_disciplina'] = $id_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacaoLeitura($parames);
            
            $dados['registros'] = $this->modelenturmacao->buscaEnturmacaoLeituraEscola($params);
            //print_r($this->db->last_query());die;
            //print_r($dados['registros']);die;
        }
        $this->load->view('relatorio/estadoleitura', $dados);
        $this->carregaTemplate();
    }
    
    public function estadoleituraexcel(){
        
        $params['estado']=$this->uri->segment ( 3 );
        $params['cd_cidade']=$this->uri->segment ( 4 );
        $params['cd_etapa']=$this->uri->segment ( 5 );
        $params['cd_disciplina']=$this->uri->segment ( 6 );
        $params['cd_avaliacao']=$this->uri->segment ( 7 );
        $parames['cd_etapa'] = $this->uri->segment ( 5 );
        
        $parames['estado'] = $this->uri->segment ( 8 );        
        $parames['cd_disciplina'] = $this->uri->segment ( 6 );
        $parames['cidade'] = $this->uri->segment ( 9 );
        $parames['etapa'] = $this->uri->segment ( 10 );
        $parames['disciplina'] = $this->uri->segment ( 11 );
        $parames['avaliacao'] = $this->uri->segment ( 12 );
        
        $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacaoLeitura($parames);       
        $dados['registros'] = $this->modelenturmacao->buscaEnturmacaoLeituraEscola($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=estadoleitura.xls");
        header("Pragma: no-cache");
        echo '<table class="table table-striped table-hover">
                <tr>                    
                    <th> Escola</th>
                    <th> </th>
                    <th> Leitor Fluente</th>
                    <th> Leitor Sem Fluência</th>
                    <th> Leitor Frase</th>
                    <th> Leitor Palavra</th>
                    <th> Leitor Sílaba</th>
                    <th> Não Leitor</th>
                    <th> Não Avaliado</th>
                    <th> Total</th>
                </tr>';
        if(isset($dados['registros'])){
            $tt_leitor_fluente=0;
            $tt_leitor_sfluente=0;
            $tt_leitor_frase=0;
            $tt_leitor_palavra=0;
            $tt_leitor_silaba=0;
            $tt_nao_leitor=0;
            $tt_nao_avaliado=0;
            $somatorio=0;
            
            foreach ($dados['registros'] as $result){
                $tt_leitor_fluente+=$result->leitor_fluente;
                $tt_leitor_sfluente+=$result->leitor_sfluente;
                $tt_leitor_frase+=$result->leitor_frase;
                $tt_leitor_palavra+=$result->leitor_palavra;
                $tt_leitor_silaba+=$result->leitor_silaba;
                $tt_nao_leitor+=$result->nao_leitor;
                $tt_nao_avaliado+=$result->nao_avaliado;
                	       echo '<tr>
                	        <td >'.$result->nm_escola,'
                            </td>
                            <td >Qtd<br/>%                                
                            </td>     
                            <td align="center">'.$result->leitor_fluente.'<br/>'
                                .round( ($result->leitor_fluente*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)                                   
                               ,2).'</td>
                            <td align="center">'.$result->leitor_sfluente.'<br/>'
                                .round( ($result->leitor_sfluente*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2).'
                            </td>
                            <td align="center">'.$result->leitor_frase.'<br/>'
                                .round( ($result->leitor_frase*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2).'
                            </td>
                            <td align="center">'.
                                $result->leitor_palavra.'<br/>'.
                                round( ($result->leitor_palavra*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2).'
                            </td>
                            <td align="center">'.$result->leitor_silaba.'<br/>'.
                                round( ($result->leitor_silaba*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)
                                    ,2).'</td>';                     	       	
                            echo'<td align="center">'.
                                $result->nao_leitor.'<br/>'.
                                round( ($result->nao_leitor*100)/
                                    (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor)>0?
                                        ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor):1)
                                    ,2).
                            '</td>';
                            echo'<td align="center">'.
                                $result->nao_avaliado.'<br/>'.
                                round( ($result->nao_avaliado*100)/
                                     (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor)>0?
                                          ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor):1)
                                     ,2).
                           '</td>';
                            echo'<td align="center">'
                                .($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)
                            .'<br/>'.
                             round( (
                                 ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)*100/
                                 (($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado)>0?
                                     ($result->leitor_fluente+$result->leitor_sfluente+$result->leitor_frase+$result->leitor_palavra+$result->leitor_silaba+$result->nao_leitor+$result->nao_avaliado):1)                                
                                       ),2).'</td>';
                		}
                		$somatorio=$tt_leitor_fluente+$tt_leitor_sfluente+$tt_leitor_frase+$tt_leitor_palavra+$tt_leitor_silaba+$tt_nao_leitor+$tt_nao_avaliado;
                		echo '</tr>';
                		echo '<tr><td>TOTAL</td><td>QTD-Σ <br/> %-Σ</td>                                
                                <td align="center">'.$tt_leitor_fluente.'<br/>'.round((($tt_leitor_fluente*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_sfluente.'<br/>'.round((($tt_leitor_sfluente*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_frase.'<br/>'.round((($tt_leitor_frase*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_palavra.'<br/>'.round((($tt_leitor_palavra*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_leitor_silaba.'<br/>'.round((($tt_leitor_silaba*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_nao_leitor.'<br/>'.round((($tt_nao_leitor*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$tt_nao_avaliado.'<br/>'.round((($tt_nao_avaliado*100)/($somatorio>0?$somatorio:1)),2).'</td>'.
                                '<td align="center">'.$somatorio.'<br/>'.round((($somatorio*100)/($somatorio>0?$somatorio:1)),2).'</td></tr>';
                	} 
                	echo '</table>';
    }


    public function evolucaoMunicipio(){
        $this->verifica_sessao();
        
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
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

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/evolucaoMunicipio', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);

            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/evolucaoMunicipio', $dados);
        } 
    }

    public function evolucaoEscola(){
        $this->verifica_sessao();

        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
        $cd_etapa = $this->input->post('cd_etapa');
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        if ($this->session->userdata('ci_grupousuario') == 3) {
            $params['ci_escola']=$this->session->userdata('ci_escola');
        }
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/evolucaoEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);

            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/evolucaoEscola', $dados);
        }
    }

    public function evolucaoTurma(){

        $this->verifica_sessao();
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
        $cd_etapa = $this->input->post('cd_etapa');
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        if ($this->session->userdata('ci_grupousuario') == 3) {
            $params['ci_escola']=$this->session->userdata('ci_escola');
        }
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/evolucaoTurma', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);

            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/evolucaoTurma', $dados);
        }
        
    }

    public function evolucaoAluno(){

        $this->verifica_sessao();

        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
        $cd_etapa = $this->input->post('cd_etapa');
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        if ($this->session->userdata('ci_grupousuario') == 3) {
            $params['ci_escola']=$this->session->userdata('ci_escola');
        }
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/evolucaoAluno', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            //$dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);

            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/evolucaoAluno');
        }
    }

    public function painelAprendizagem(){

        $this->verifica_sessao();
            
        $dados['anoatual']= 0;
        $dados['dataLimite']=$this->input->post('datalimite');    
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
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

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/painelaprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $parames['nr_anoletivo'] = $this->input->post('nr_anoletivo');
            $parames['cidade'] = $this->input->post('cd_cidade');
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_cidade']=$id_cidade;
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaPainelAprendizagem($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/painelaprendizagem', $dados);
            $this->load->view('template/html-footer');
        }

    }


    public function painelAprendizagemnew(){

        $this->verifica_sessao();
        
        	$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	//$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_edicao = $this->input->post('cd_edicao');
        $dados['edicoes']= $this->modeledicoes->selectEdicoes($cd_edicao);
        

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

        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
            $id_cidade=$cd_cidade_sme;
        }


        if( !isset( $cd_edicao ) ){
            $this->load->view('relatorio/painelaprendizagemnew', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_edicao = $this->input->post('cd_edicao');                        
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_etapa = $this->input->post('cd_etapa');
            $params['cd_edicao'] = $cd_edicao;
            $params['cd_disciplina'] = $cd_disciplina;            
            $params['cd_etapa'] = $cd_etapa;            
            $params['cd_cidade']=$id_cidade;            
            $dados['cd_edicao']=$cd_edicao;
            $dados['rd_rel']=$this->input->post('rd_rel');
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            $params['cd_disciplina'] = $cd_disciplina;            
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaPainelAprendizagemnovo($params);
            //echo $this->db->last_query(); die;

            $this->load->view('relatorio/painelaprendizagemnew', $dados);
            $this->load->view('template/html-footer');
        }

    }
    
    public function excelniveldesempenhomunicipio(){
        
        $this->verifica_sessao();
        $cd_nivel= ($this->uri->segment ( 3 ));
        $cd_avaliacao = ($this->uri->segment ( 4 ));
        $cd_topico = ($this->uri->segment ( 5 ));
        $cd_cidade = ($this->uri->segment ( 6 ));
        
        $params['cd_nivel']=$cd_nivel;
        $params['cd_avaliacao']=$cd_avaliacao;
        $params['cd_topico']=$cd_topico;
        $params['cd_cidade']=$cd_cidade;
        
        $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagemMunicipioExcel($params);
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=niveldesempenhomunicipio.xls");
        header("Pragma: no-cache");
        echo '<table>
                    <tr>
                        <td>Matrícula</td>
                        <td>Aluno</td>
                </tr>';
        $contador=1;
        foreach ($result as $key=>$value){
            $contador++;
            echo "<tr><td>".$value->ci_aluno."</td><td>".$value->nm_aluno."</td></tr>";
        }
        echo '</table>';
    }
    
    public function excelniveldesempenhoescola(){
        
        $this->verifica_sessao();
        //$this->load->library('export_excel');
        $cd_nivel= ($this->uri->segment ( 3 ));
        $cd_avaliacao = ($this->uri->segment ( 4 ));
        $cd_turma = ($this->uri->segment ( 5 ));
        $cd_cidade = ($this->uri->segment ( 6 ));
        
        $params['cd_nivel']=$cd_nivel;
        $params['cd_turma']=$cd_turma;
        $params['cd_avaliacao']=$cd_avaliacao;
        $params['cd_cidade']=$cd_cidade;
        //print_r($params);die;
        
        $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagem($params);
        //print_r($this->db->last_query());die;
        
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=nivedesempenhoescola.xls");
        header("Pragma: no-cache");
        echo '<table>
                    <tr>
                        <td>Matrícula</td>
                        <td>Aluno</td>
                </tr>';
        $contador=1;
        foreach ($result as $key=>$value){
            $contador++;
            echo "<tr><td>".$value->ci_aluno."</td><td>".$value->nm_aluno."</td></tr>";
        }
        echo '</table>';
        
    }
    
    
    public function excelniveldesempenho(){
        
        $this->verifica_sessao();
        //$this->load->library('export_excel');
        $cd_nivel= ($this->uri->segment ( 4 ));        
        $cd_avaliacao = ($this->uri->segment ( 5 ));
        $cd_topico = ($this->uri->segment ( 6 ));
        
        $params['cd_nivel']=$cd_nivel;        
        $params['cd_avaliacao']=$cd_avaliacao;
        $params['cd_topico']=$cd_topico;
        
        $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagem($params);
        
        
    }

    public function excelniveldesempenhoturma(){

        $this->verifica_sessao();
            $this->load->library('export_excel');
            $cd_nivel= ($this->uri->segment ( 4 ));
            $cd_turma = ($this->uri->segment ( 5 ));
            $cd_avaliacao = ($this->uri->segment ( 6 ));
            
            $params['cd_nivel']=$cd_nivel;
            $params['cd_turma']=$cd_turma;
            $params['cd_avaliacao']=$cd_avaliacao;
            
            $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagem($params);

            $this->export_excel->to_excel($result, $this->titulo);
    }
    
    public function carregaTemplate(){
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('template/html-footer');
    }
    
    public function infrEscola(){
        $this->verifica_sessao();
        $this->carregaTemplate();
        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        if($this->session->userdata('ci_grupousuario')==2){
            $cd_cidade=$this->session->userdata('cd_cidade_sme');
            $dados['escolas']   = $this->modelescola->buscar(
                $ci_escola      = null,
                $nr_inep        = null,
                $nm_escola      = null,
                $ds_telefone    = null,
                $ds_email       = null,
                $fl_extencao    = null,
                $fl_tpunidade   = null,
                $fl_localizacao = null,
                $cd_cidade,
                $nr_cep         = null,
                $ds_rua         = null,
                $nr_residencia  = null,
                $ds_bairro      = null,
                $ds_complemento = null,
                $ds_referencia  = null);
            
        }else if($this->session->userdata('ci_grupousuario')==1){
            $ci_escola= $this->session->userdata('ci_escola');
            $dados['escolas']       = $this->modelescola->buscar($ci_escola);
        }else{
            $cd_escola = $this->session->userdata('ci_escola');
            $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);
        }
        
        $this->load->view('relatorio/infrequenciaescola', $dados);
    }
    
    public function infrTurma(){
        $this->verifica_sessao();
        $this->carregaTemplate();

        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);

        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        if($this->session->userdata('ci_grupousuario')==2){
            $cd_cidade=$this->session->userdata('cd_cidade_sme');
            $dados['escolas']   = $this->modelescola->buscar(
                $ci_escola      = null,
                $nr_inep        = null,
                $nm_escola      = null,
                $ds_telefone    = null,
                $ds_email       = null,
                $fl_extencao    = null,
                $fl_tpunidade   = null,
                $fl_localizacao = null,
                $cd_cidade      = null,
                $nr_cep         = null,
                $ds_rua         = null,
                $nr_residencia  = null,
                $ds_bairro      = null,
                $ds_complemento = null,
                $ds_referencia  = null);
            
        }else if($this->session->userdata('ci_grupousuario')==1){
            $ci_escola= $this->session->userdata('ci_escola');
            $dados['escolas']       = $this->modelescola->buscar($ci_escola);
        }else{
            $cd_escola = $this->session->userdata('ci_escola');
            $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);
        }
        $this->load->view('relatorio/infrequenciaturma', $dados);
    }
    
    public function infrAluno(){
        $this->verifica_sessao();
        $this->carregaTemplate();

        $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['etapas'] = $this->modeletapa->buscar();
        if($this->session->userdata('ci_grupousuario')==2){
            $cd_cidade=$this->session->userdata('cd_cidade_sme');
            $dados['escolas']   = $this->modelescola->buscar(
                $ci_escola      = null,
                $nr_inep        = null,
                $nm_escola      = null,
                $ds_telefone    = null,
                $ds_email       = null,
                $fl_extencao    = null,
                $fl_tpunidade   = null,
                $fl_localizacao = null,
                $cd_cidade,
                $nr_cep         = null,
                $ds_rua         = null,
                $nr_residencia  = null,
                $ds_bairro      = null,
                $ds_complemento = null,
                $ds_referencia  = null);
            
        }else if($this->session->userdata('ci_grupousuario')==1){
            $ci_escola= $this->session->userdata('ci_escola');
            $dados['escolas']       = $this->modelescola->buscar($ci_escola);
        }else{
            $cd_escola = $this->session->userdata('ci_escola');
            $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);
        }
        $this->load->view('relatorio/infrequencia', $dados);
    }
    
    public function listagem_consulta($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $cd_escola     = $this->input->post('cd_escola');
            $cd_turma     = $this->input->post('cd_turma');
            $cd_etapa     = $this->input->post('cd_etapa');
            
            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $params['cd_escola']    = $this->session->userdata('ci_escola');
            }
            
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscar( $cd_escola,$cd_turma,$cd_etapa);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = $this->modelinfrequencia->count_buscar($cd_escola,$cd_turma,$cd_etapa);
            $this->load->view('relatorio/pesquisa_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    public function listagem_consultaescola($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $params['cd_escola']     = $this->input->post('cd_escola');
            $params['cd_estado']     = $this->input->post('cd_estado');
            $params['cd_cidade']     = $this->input->post('cd_cidade');
            $params['cd_anoletivo']     = $this->input->post('cd_ano');
            
            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $params['cd_escola']    = $this->session->userdata('ci_escola');
            }
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscarpercentualescola($params);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = count($dados['registros']);
            $this->load->view('relatorio/pesquisa_listaescola', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    public function listagem_consultaturma($offset=null){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $params['cd_escola'] = $this->input->post('cd_escola');            
            $params['cd_turma'] = $this->input->post('cd_turma');
                        
            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $params['cd_escola']    = $this->session->userdata('ci_escola');
            }
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscarpercentualturma($params);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = count($dados['registros']);
            $this->load->view('relatorio/pesquisa_listaturma', $dados);
        }else{
            echo $status_sessao;
        }
    }
    
    function charset_decode_utf_8 ($string) {
        /* Only do the slow convert if there are 8-bit characters */
        /* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
        if (! preg_match("[\200-\237]", $string) and ! preg_match("[\241-\377]", $string))
            return $string;
 
        // decode three byte unicode characters
        $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/", 
        "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",   
        $string);
 
        // decode two byte unicode characters
        $string = preg_replace("/([\300-\337])([\200-\277])/",
        "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
        $string);
 
        return $string;
    }
    
    function gerarplanilha($dados){
//         $arquivo='./planilhas/relatorio.xlsx';
//         $planilha= $this->phpexcel;
//         $planilha->setActiveSheetIndex(0)->setCellValue('A1','Dados');
        
        print_r($dados[0]->alunos);//die;
//         $contador=0;
//         foreach ($dados[0]->alunos as $linha){
//             print_r( $linha);die;
//             $contador++;
//             $planilha->setActiveSheetIndex(0)->setCellValue('A'>$contador,$linha->alunos);
//         }
        
//         $planilha->getActiveSheet()->setTitle('Lista de Alunos');
//         $objGravar = PHPExcel_IOFactory::createWriter($planilha,'Excel2007');
//         $objGravar->save($arquivo);
    }
    
    function leituraescritaMunicipio(){
        $this->verifica_sessao();
            $dados['anoatual']= 0;
        
        if($_POST){
           $dados['anoatual']=  $this->input->post('nr_anoletivo');
        }   

        $dados['anos'] = $this->modelutil->selectAnoletivo($dados['anoatual']);
        
        //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
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
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/leituraescritaMunicipio', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['nr_anoletivo']=$nr_anoletivo;
            
            $dados['registrosDesc'] = $this->modelavaliacoes_lancamento->buscaEvolucaoAluno($params);
            
            //echo $this->db->last_query(); die;
            $this->load->view('relatorio/leituraescritaMunicipio', $dados);
        }
    }
    
 	function participacaoMunicipio(){
 		$id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
		$dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        
 		$this->load->view('relatorio/participacaomunicipio', $dados);
 	}
 	
 	function participacaoEscola(){
 	
 		$this->verifica_sessao();
 		
 		//$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        
        $id_estado =!empty($cd_estado_temp)?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $cd_etapa = $this->input->post('cd_etapa');
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        
        $params['ci_escola']=$this->input->post('cd_escola');
        
        //echo sizeof($params['ci_escola']);die;
        
        if(sizeof($params['ci_escola'])>1){
            //print_r($params);die;
            $dados['escola'] = $this->modelescola->buscaEscolas($params);
        }else{
            $params['cd_cidade']=$id_cidade;
            //print_r($params);die;
            $dados['escola'] = $this->modelescola->buscaArrayEscolaUsuario($params);
        }
        
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            //$cd_estado_temp=$this->input->post('cd_estado');      
        	$cd_cidade_temp=$this->input->post('cd_cidade');
        	$nr_inep_escola_temp=$this->input->post('nr_inep_escola');
        	
            $cd_cidade =!empty($cd_cidade_temp)?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($nr_inep_escola_temp)?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscolaInep($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscolaInep($cd_cidade_sme);
            
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('relatorio/participacaoescola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_escola = !empty($_POST['cd_escola'])?$_POST['cd_escola']:NULL;
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');            
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $params['cd_cidade']=$id_cidade;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            if(sizeof($cd_escola)>=1){
                $params['cd_escola']=implode(",",$cd_escola);
            }else{
                $params['cd_escola']=$cd_escola;
            }
            
            $dados['avaliacao']=$this->modelavaliacao->buscaDescritoresAvaliacao($params);
            $dados['registrosDesc'] = $this->modelparticipacao->participacaoEscola($params);
            $this->load->view('relatorio/participacaoescola', $dados);
            $this->load->view('template/html-footer');
        }
 	  	
 	}
 	
 	function participacaoTur(){
		$this->verifica_sessao();
        
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
            $this->load->view('relatorio/participacaotur', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $nr_ano_letivo = $this->input->post('nr_anoletivo');
            $cd_escola = $this->input->post('cd_escola');
            
            $dados['turmas'] = $this->modelturma->buscar(null,null,$cd_etapa,null,null,null,$nr_ano_letivo,$cd_escola,null);
            
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacao($parames);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;
            
            $dados['avaliacao']=$this->modelavaliacao->buscaItensAvaliacao($params);
            $dados['registrosDesc']=$this->modelparticipacao->participacaoTurma($params);            
            //echo $this->db->last_query(); die;
            
            $this->load->view('relatorio/participacaotur', $dados);
            $this->load->view('template/html-footer');
        }    
     }
     
     function relatorioConferenciaEnturmacao(){
        $this->verifica_sessao();
        
        if($_POST){
            $cd_estado_temp=$this->input->post('cd_estado');
            $cd_cidade_temp=$this->input->post('cd_cidade');
        }ELSE{
            $cd_estado_temp=$this->input->get('estado');
            $cd_cidade_temp=$this->input->get('cidade');
        }
        
        $id_estado =!empty($cd_estado_temp)?$cd_estado_temp:$this->input->post('cd_estado');
        $id_cidade =!empty($cd_cidade_temp)?$cd_cidade_temp:$this->input->post('cd_cidade');        
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        //PRINT_R($dados['escolas']);DIE;        
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
            $cd_cidade = !empty($cd_cidade_temp)?$cd_cidade_temp:$this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $params['ci_escola']=$this->input->get('escola');
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep ,$params['ci_escola']);            
        }
                 
            $this->load->view('relatorio/conferenciaEnturmacao', $dados);
            $this->load->view('template/html-footer');
     }

     function cadernoProva(){

        $this->verifica_sessao();
        
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

         $this->load->view('relatorio/cadernoProva', $dados);
            $this->load->view('template/html-footer');
     }
}