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
        //$this->load->library('PHPExel/phpexcel');
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
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }


        if( !isset( $cd_etapa ) ){
            $this->load->view('estudante', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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

            $this->load->view('estudante', $dados);
            $this->load->view('template/html-footer');
        }
    }

    public function pesquisaErrosAcertos(){
        
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($params['ci_escola']);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();                        
            $cd_cidade = $this->input->post('cd_cidade');
            $nr_inep = $this->input->post('nr_inep_escola');
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);            
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('acertos_erros', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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

            $this->load->view('acertos_erros', $dados);
            $this->load->view('template/html-footer');
        }
    }

    public function pesquisaPorNivelDesempenho(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($params['ci_escola']);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario')==2) {
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
            
            //echo $this->db->last_query();die;
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('nivel_desempenho', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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

            $this->load->view('nivel_desempenho', $dados);
            $this->load->view('template/html-footer');
        }
    }
    //fim de relatório da parte escrita
    //PARTE DE RELATÓRIOS DE LEITURA
    public function pesquisaAvaliacaoLeituraAluno(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $dados['etapas'] = $this->modeletapa->buscaTodasOfertasEscola($params['ci_escola']);
            //echo $this->db->last_query();die;
            foreach ($dados['escola']as $escola){
                $dados['nr_inep']= $escola->nr_inep;
                $dados['nm_escola']= $escola->nm_escola;
                $dados['ci_escola']= $escola->ci_escola;
            }
            
        }else if ($this->session->userdata('ci_grupousuario') == 2) {
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):$this->session->userdata('cd_cidade_sme');
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }
        
        $dados['titulo'] = $this->titulo;        
        //$dados['avaliacoes_lancamento'] = $this->modelenturmacao->buscar();
        $dados['nr_inep']='';
        $dados['nm_escola']='';
        $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
        foreach ($dados['escola']as $escola){
            $dados['nr_inep']= $escola->nr_inep;
            $dados['nm_escola']= $escola->nm_escola;
            $dados['ci_escola']= $escola->ci_escola;
        }
        //$parametro=isset($dados['ci_escola'])?$dados['ci_escola']:NULL;        
        //$dados['etapas'] = $this->modeletapa->buscaOfertaEscola($parametro);
        $dados['turmas'] = $this->modelturma->buscar();
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('avaliacao_leitura_aluno', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $params['cd_escola'] = $this->input->post('cd_escola');

            $dados['registrosDesc'] = $this->modelenturmacao->buscaEnturmacaoLeitura($params);
            //echo $this->db->last_query(); die;

            $this->load->view('avaliacao_leitura_aluno', $dados);
            $this->load->view('template/html-footer');
        }
    }

    public function percAcertoHabilidadeAvaliada(){

        $this->verifica_sessao();
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
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }


        $dados['titulo'] = $this->titulo;
        //$dados['estado'] = $this->modelestado->selectEstados();
        //$dados['avaliacoes_lancamento'] = $this->modelenturmacao->buscar();
        $dados['nr_inep']='';
        $dados['nm_escola']='';
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
            $this->load->view('habilidadeAvaliada', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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

            $this->load->view('habilidadeAvaliada', $dados);
            $this->load->view('template/html-footer');
        }

    }

    public function partials(){
        $action = ($this->uri->segment ( 4 ));

        if ($action == 'buscar') {

            $cd_avaliacao = ($this->uri->segment ( 5 ));
            $cd_disciplina= ($this->uri->segment ( 6 ));
            $cd_turma = ($this->uri->segment ( 7 ));
            $cd_etapa = ($this->uri->segment ( 8 ));
            $cd_escola = ($this->uri->segment ( 9 ));
            $cd_topico = $_POST['cd_topico'];

            $params['cd_avaliacao'] = $cd_avaliacao;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;
            $params['cd_topico'] = $cd_topico;

            $result = $this->modelavaliacoes_lancamento->buscaResultadoTopico($params);            

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaomunicipio') {
            
            $cd_disciplina= ($this->uri->segment ( 5 ));            
            $cd_etapa = ($this->uri->segment ( 6 ));            
            $cd_cidade = ($this->uri->segment ( 7 ));    
            $dados['estado'] = $this->modelestado->selectEstados();
            $params['cd_disciplina'] = $cd_disciplina;            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_cidade'] = $cd_cidade?$cd_cidade:$this->session->userdata('cd_cidade_sme');

            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoMunicipio($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

         if ($action == 'evolucaomunicipioano') {
            
            $cd_disciplina= ($this->uri->segment ( 5 ));            
            $cd_etapa = ($this->uri->segment ( 6 ));            
            $cd_cidade = ($this->uri->segment ( 7 ));    
            $dados['estado'] = $this->modelestado->selectEstados();
            $params['cd_disciplina'] = $cd_disciplina;            
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_cidade'] = $cd_cidade?$cd_cidade:$this->session->userdata('cd_cidade_sme');
            
            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoMunicipioAno($params);
            //echo $this->db->last_query(); die;
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaoescola') {
            
            $cd_disciplina= ($this->uri->segment ( 5 ));            
            $dados['estado'] = $this->modelestado->selectEstados();
            $cd_etapa = ($this->uri->segment ( 6 ));
            $cd_escola = ($this->uri->segment ( 7 ));
            
            $params['cd_disciplina'] = $cd_disciplina;        
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;

            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoEscola($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

         if ($action == 'evolucaoturma') {
            
            $cd_disciplina= ($this->uri->segment ( 5 ));
            $cd_turma = ($this->uri->segment ( 6 ));
            $cd_etapa = ($this->uri->segment ( 7 ));
            $cd_escola = ($this->uri->segment ( 8 ));
            
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;

            $result =$this->modelavaliacoes_lancamento->buscaEvolucaoTurma($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if ($action == 'evolucaoaluno') {
            
            $cd_disciplina= ($this->uri->segment ( 5 ));
            $cd_turma = ($this->uri->segment ( 6 ));
            $cd_etapa = ($this->uri->segment ( 7 ));
            $cd_escola = ($this->uri->segment ( 8 ));
            
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_turma'] = $cd_turma;
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_escola'] = $cd_escola;

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
            $params['cd_cidade']=$cd_cidade;
            $result =$this->modelavaliacoes_lancamento->buscaTopicoDescritor($params);
            //echo $this->db->last_query(); die;

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        if($action=='munleituraescola'){

            $cd_etapa = ($this->uri->segment ( 5 )); 
            $cd_turma = ($this->uri->segment ( 6 ));
            $cd_disciplina= ($this->uri->segment ( 7 ));                        
            $cd_avaliacao = ($this->uri->segment ( 8 ));            

            $params['cd_etapa']=$cd_etapa;
            $params['cd_turma']=$cd_turma;
            $params['cd_disciplina']=$cd_disciplina;
            $params['cd_avaliacao']=$cd_avaliacao;        
            
            $result =$this->modelenturmacao->graficoEnturmacaoLeituraEscola($params);
            
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));   
        }
        
        if($action=='munleituraescolaano'){

            $cd_etapa = ($this->uri->segment ( 5 )); 
            $cd_turma = ($this->uri->segment ( 6 ));
            $cd_disciplina= ($this->uri->segment ( 7 ));                        
            $cd_avaliacao = ($this->uri->segment ( 8 ));            

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
                
                $cd_etapa = ($this->uri->segment ( 5 ));
                $cd_cidade = ($this->uri->segment ( 6 ));
                $cd_disciplina= ($this->uri->segment ( 7 ));
                $cd_avaliacao = ($this->uri->segment ( 8 ));
                
                $params['cd_etapa']=$cd_etapa;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_disciplina']=$cd_disciplina;
                $params['cd_avaliacao']=$cd_avaliacao;
                
                $result =$this->modelenturmacao->graficoEnturmacaoLeituraMunicipioMes($params);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            if($action=='munleituraano'){
                
                $cd_etapa = ($this->uri->segment ( 5 ));
                $cd_cidade = ($this->uri->segment ( 6 ));
                $cd_disciplina= ($this->uri->segment ( 7 ));
                $cd_avaliacao = ($this->uri->segment ( 8 ));
                
                $params['cd_etapa']=$cd_etapa;
                $params['cd_cidade']=$cd_cidade;
                $params['cd_disciplina']=$cd_disciplina;
                $params['cd_avaliacao']=$cd_avaliacao;
                
                $result =$this->modelenturmacao->graficoEnturmacaoLeituraMunicipioAno($params);
                
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            
       
    }
    //parte para o grupo de municipio
    public function munNivelAprendizagem(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('munNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{
            
            
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;            
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
            
            

            $this->load->view('munNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function escNivelAprendizagem(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else if ($this->session->userdata('ci_grupousuario') == 2) {
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('escNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            
            $this->load->view('escNivelAprendizagem', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    
    public function munEscritaEscola(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);

        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('munEscritaEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_escola = !empty($_POST['cd_escola'])?$_POST['cd_escola']:NULL;
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
           //echo $this->db->last_query(); die;

            $this->load->view('munEscritaEscola',$dados);
            $this->load->view('template/html-footer');
        }


    }
    public function munLeituraEscola(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('munLeituraEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('munLeituraEscola', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function leituraEscola(){
        $this->verifica_sessao();
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
            $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $dados['estado'] = $this->modelestado->selectEstados($id_estado);
            $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
            
        }else if($this->session->userdata('ci_grupousuario') == 2) {
            $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
            $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $dados['estado'] = $this->modelestado->selectEstados($id_estado);
            $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
            
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
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
            $this->load->view('leituraEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('leituraEscola', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    public function munLeitura(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }
        
        if( !isset( $cd_etapa ) ){
            $this->load->view('munLeitura', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('munLeitura', $dados);
            $this->load->view('template/html-footer');
        }
    }
    
    
    public function estadoLeitura(){
        $this->verifica_sessao();
        $this->carregaTemplate();
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);
        $dados['disciplinas'] = $this->modeldisciplina->buscar();
        
        if ($this->session->userdata('ci_grupousuario') == 1) {
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }
        
        $id_etapa =!empty($this->input->post('cd_etapa'))?$this->input->post('cd_etapa'):NULL;
        $id_disciplina =!empty($this->input->post('cd_disciplina'))?$this->input->post('cd_disciplina'):NULL;
        $id_avaliacao =!empty($this->input->post('cd_avaliacao'))?$this->input->post('cd_avaliacao'):NULL;
        
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
            
            //print_r($dados['registros']);die;
        }
        $this->load->view('estadoleitura', $dados);
        $this->carregaTemplate();
    }


    public function evolucaoMunicipio(){
        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('evolucaoMunicipio', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('evolucaoMunicipio', $dados);
        } 
    }

    public function evolucaoEscola(){
        $this->verifica_sessao();
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
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
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('evolucaoEscola', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('evolucaoEscola', $dados);
        }
    }

    public function evolucaoTurma(){

        $this->verifica_sessao();
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
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
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('evolucaoTurma', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('evolucaoTurma', $dados);
        }
        
    }

    public function evolucaoAluno(){

        $this->verifica_sessao();
        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $dados['estado'] = $this->modelestado->selectEstados();
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
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('evolucaoAluno', $dados);
            $this->load->view('template/html-footer');
        }else {
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $this->load->view('evolucaoAluno');
        }
    }

    public function painelAprendizagem(){

        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }

        if( !isset( $cd_etapa ) ){
            $this->load->view('painelaprendizagem', $dados);
            $this->load->view('template/html-footer');
        }else{
            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
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
            $params['cd_cidade']=$id_cidade;
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaPainelAprendizagem($params);
            //echo $this->db->last_query(); die;

            $this->load->view('painelaprendizagem', $dados);
            $this->load->view('template/html-footer');
        }

    }


    public function painelAprendizagemnew(){

        $this->verifica_sessao();
        
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
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
            $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
            $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);
        }else{
            $dados['etapas'] = $this->modeletapa->buscar();
            $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            $dados['escolas'] = $this->modelescola->selectEscola($cd_cidade_sme);
        }


        if( !isset( $cd_edicao ) ){
            $this->load->view('painelaprendizagemnew', $dados);
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
            //$params['cd_avaliacao']=5;
            $dados['registrosDesc']=$this->modelavaliacoes_lancamento->buscaPainelAprendizagemnew($params);
            //echo $this->db->last_query(); die;

            $this->load->view('painelaprendizagemnew', $dados);
            $this->load->view('template/html-footer');
        }

    }
    
    public function excelniveldesempenhomunicipio(){
        
        $this->verifica_sessao();
        //$this->load->library('export_excel');
        $cd_nivel= ($this->uri->segment ( 4 ));
        $cd_avaliacao = ($this->uri->segment ( 5 ));
        $cd_topico = ($this->uri->segment ( 6 ));
        $cd_cidade = ($this->uri->segment ( 7 ));
        
        $params['cd_nivel']=$cd_nivel;
        $params['cd_avaliacao']=$cd_avaliacao;
        $params['cd_topico']=$cd_topico;
        $params['cd_cidade']=$cd_cidade;
        //print_r($params);die;
        
        $result =$this->modelavaliacoes_lancamento->listaAlunoNivelAprendizagemMunicipio($params);        
        print_r($result[0]->alunos);        
        //$this->export_excel->to_excel($result, $this->titulo);
        //$this->gerarplanilha($result);
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
        
        $this->load->view('infrequenciaescola', $dados);
    }
    
    public function infrTurma(){
        $this->verifica_sessao();
        $this->carregaTemplate();
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
        $this->load->view('infrequenciaturma', $dados);
    }
    
    public function infrAluno(){
        $this->verifica_sessao();
        $this->carregaTemplate();
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
        $this->load->view('infrequencia', $dados);
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
            $this->load->view('pesquisa_lista', $dados);
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
            
            if ($this->session->userdata('ci_grupousuario') == 3){ // Se for escola
                $params['cd_escola']    = $this->session->userdata('ci_escola');
            }
            $dados['titulo'] = $this->titulo;
            
            $dados['registros'] = $this->modelinfrequencia->buscarpercentualescola($params);
            //echo $this->db->last_query(); die;
            $dados['total_registros'] = count($dados['registros']);
            $this->load->view('pesquisa_listaescola', $dados);
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
            $this->load->view('pesquisa_listaturma', $dados);
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
}