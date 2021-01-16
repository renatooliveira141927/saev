<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alunos extends CI_Controller
{
    protected $titulo     = 'Alunos';
    protected $cd_usuario = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');        
        $this->load->model('alunos_model', 'modelaluno');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('cidade_model', 'modelcidade');
        $this->load->model('enturmacoes_model',  'modelenturmacao');
        $this->load->model('Deficiencias_model', 'modeldeficiencia');
    }
    public function verifica_sessao($acao = null){
        if(!$this->session->userdata('logado')){
            if ($acao == 'rotina_ajax'){
                return 'sessaooff';                
            }else{
                redirect(base_url('usuario/autenticacoes/login'));
            }            
        }
        else{
            $this->cd_usuario = $this->session->userdata('ci_usuario');
        }
    }
    public function index(){
        $this->verifica_sessao(); 

        $dados = $this->busca_filtros();
        $dados['titulo']  = $this->titulo;
 
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('aluno/aluno', $dados);
        $this->load->view('template/html-footer');
    }
    
    public function busca_filtros(){
        $filtros = $this->modelaluno->busca_filtros( $this->cd_usuario );
        
        $dados['cd_estado']         = '';
        $dados['cd_cidade']         = '';
        $dados['cd_escola']         = '';
        $dados['cd_turma']          = '';
        $dados['nr_inep_escola']    = '';
        $dados['cd_etapa']          = '';
        $dados['cd_turno']          = '';
        $dados['nr_inep_aluno']     = '';
        $dados['nm_aluno']          = '';
        $dados['cidades']           = '';
        $dados['escolas']           = '';
        $dados['turmas']            = '';
        $dados['cd_ano_letivo']     = '';
        $dados['fl_ativo']          = '';
        $dados['cd_tipodeficiencia']= '';
        $dados['fl_rede']           = '';        

        foreach ($filtros as $filtro) {
            $dados['cd_estado']     = $filtro->cd_estado;
            $dados['cd_cidade']     = $filtro->cd_cidade;
            $dados['nr_inep_escola']= $filtro->nr_inep_escola;
            $dados['cd_escola']     = $filtro->cd_escola;
            $dados['cd_turma']      = $filtro->cd_turma;
            $dados['cd_etapa']      = $filtro->cd_etapa;
            $dados['cd_turno']      = $filtro->cd_turno;
            $dados['nr_inep_aluno'] = $filtro->nr_inep_aluno;
            $dados['nm_aluno']      = $filtro->nm_aluno;

            $dados['fl_ativo']      = $filtro->fl_ativo;
            $dados['cd_ano_letivo'] = $filtro->cd_ano_letivo;
            $dados['fl_rede']      = $filtro->fl_rede;
        }

        if ($this->session->userdata('ci_grupousuario') == 2){
            $dados['cd_estado']   = $this->session->userdata('cd_estado_sme');
            $dados['cd_cidade']   = $this->session->userdata('cd_cidade_sme');
        }else if ($this->session->userdata('ci_grupousuario') == 3){
            $dados['cd_estado'] = $this->session->userdata('cd_estado_sme');
            $dados['cd_cidade'] = $this->session->userdata('cd_cidade_sme');            
            $dados['cd_escola'] = $this->session->userdata('ci_escola');
        }

        $dados['estado']    = $this->modelestado->selectEstados($dados['cd_estado']);

        if ($dados['cd_cidade']){
            $dados['cidades']   = $this->modelcidade->selectCidade($dados['cd_estado'], '', '', '', $dados['cd_cidade']);
        }else{$dados['cidades'] = '';}

        if ($dados['cd_escola']){
            
            $dados['escolas']   = $this->modelescola->selectEscola($dados['cd_cidade'], '', $dados['cd_escola']);
        }else if ($dados['cd_cidade']){
            $dados['escolas']   = $this->modelescola->selectEscola($dados['cd_cidade']);
        }else{$dados['escolas'] = '';}        

        if ($dados['cd_escola']){            
            $dados['turmas']    = $this->modelturma->selectTurmas('', $dados['cd_escola'], $dados['cd_turma']);
            $dados['anos']   = $this->modelaluno->selectAnosTurmas($dados['cd_escola'], $dados['cd_ano_letivo']);
        }else{$dados['turmas'] = '';}

        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['turnos'] = $this->modelturno->buscar();
        
        return $dados;
    }
    public function listagem_consulta(){        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        $dados['titulo'] = $this->titulo;
        $dados['anoatual']= date('Y');
    
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');
            $params['cd_usuario']   = $this->session->userdata('ci_usuario');

            if ($this->input->post('cd_estado')){
                $params['cd_estado']    = $this->input->post('cd_estado');
            }
            if ($this->input->post('cd_cidade')){
                $params['cd_cidade']    = $this->input->post('cd_cidade');
            }
            if ($this->input->post('nr_inep_escola')){
                $params['nr_inep_escola']= $this->input->post('nr_inep_escola');
            }
            if ($this->input->post('cd_escola')){
                $params['cd_escola']    = $this->input->post('cd_escola');
            }
            if ($this->input->post('cd_turma')){
                $params['cd_turma']     = $this->input->post('cd_turma');
            }
            if ($this->input->post('cd_etapa')){
                $params['cd_etapa']     = $this->input->post('cd_etapa');
            }
            if ($this->input->post('cd_turno')){
                $params['cd_turno']     = $this->input->post('cd_turno');
            }
            if ($this->input->post('nr_inep_aluno')){
                $params['nr_inep_aluno']= $this->input->post('nr_inep_aluno');
            }
            if ($this->input->post('nm_aluno')){
                $params['nm_aluno']     = $this->input->post('nm_aluno');
            }
            if ($this->input->post('cd_ano_letivo')){                
                $params['cd_ano_letivo'] = $this->input->post('cd_ano_letivo');
            }
            if ($this->input->post('cd_tipodeficiencia')){                
                $params['cd_tipodeficiencia'] = $this->input->post('cd_tipodeficiencia');
            }
            
            $params['fl_ativo']     = $this->input->post('fl_ativo');

            $params['fl_rede']     = $this->input->post('fl_rede');            

            $this->form_validation->set_rules('cd_cidade', 'município','required');
            //$this->form_validation->set_rules('cd_escola', 'escola','required');
                    
            if ($this->form_validation->run()) {                

                $this->modelaluno->gravar_filtros( $params );                

                $dados['registros'] = $this->modelaluno->buscar( $params );
                               
                $this->load->view('aluno/aluno_lista', $dados);
            }

        }else{
            echo $status_sessao;
        }
    }

    public function gravar_cabecalho(){

        $params['cd_usuario']    = $this->cd_usuario;
        $params['cd_estado']     = $this->input->post('cd_estado_sme');
        
        if ($this->input->post('cd_cidade_sme')){
            $params['cd_cidade']     = $this->input->post('cd_cidade_sme');
        }
        
        $params['nr_inep_escola']= $this->input->post('nr_inep_escola');
        $params['cd_escola']     = $this->input->post('cd_escola');
        if ($this->input->post('cd_turma')){
            $params['cd_turma']      = $this->input->post('cd_turma');
        }        
        $params['fl_bloqueado']  = $this->input->post('fl_bloqueado');
                
        $this->modelaluno->gravar_cabecalho( $params );
    }

    public function salvar(){
        $this->verifica_sessao();

        $this->gravar_cabecalho();

        if($this->input->post('ci_aluno')){
            
            $params['ci_aluno']      = $this->input->post('ci_aluno');
        }
        
        if ($this->input->post('nr_inep')){
            $params['nr_inep']       = $this->input->post('nr_inep');
        }
        $params['nm_aluno']             = $this->input->post('nm_aluno');   
        $params['nm_mae']               = $this->input->post('nm_mae');
        $params['nm_pai']               = $this->input->post('nm_pai');
        $params['nm_responsavel']       = $this->input->post('nm_responsavel');
        $params['dt_nascimento']        = $this->input->post('txt_data');           
        $params['ds_email']             = $this->input->post('ds_email');            
        $params['fl_sexo']              = $this->input->post('fl_sexo');
        $params['ds_telefone1']         = $this->input->post('ds_telefone1');
        $params['ds_telefone2']         = $this->input->post('ds_telefone2');
        $params['cd_cidade']            = $this->input->post('cd_cidade');        
        $params['nr_cep']               = $this->input->post('nr_cep');
        $params['ds_rua']               = $this->input->post('ds_rua');
        $params['nr_residencia']        = $this->input->post('nr_residencia');
        $params['ds_bairro']            = $this->input->post('ds_bairro');
        $params['ds_complemento']       = $this->input->post('ds_complemento');
        $params['ds_referencia']        = $this->input->post('ds_referencia');
        $params['cd_escola']            = $this->input->post('cd_escola');

        if (!$this->input->post('cd_tipodeficiencia')){
            $params['cd_tipodeficiencia']   = 1;
        }else{
            $params['cd_tipodeficiencia']   = $this->input->post('cd_tipodeficiencia');
        }

        $cd_turma       = $this->input->post('cd_turma');
        $cd_enturmacao  = $this->input->post('cd_enturmacao');
        $ci_ultimaenturmacao  = $this->input->post('ci_ultimaenturmacao');
        //echo '<br><br><br><br><br><br>$ci_ultimaenturmacao='.$ci_ultimaenturmacao;
        
        $data = implode('/',array_reverse(explode('/',$params['dt_nascimento']))); // Converte data para padrÃ£o amaericano
        $params['dt_nascimento'] = $data;
        
        
        $img	        = $this->input->post('img');

        $ds_img         = $_FILES['img']['name'];
        
        if ($ds_img || !isset($params['ci_aluno']) ){
            $nm_img = $this->input->post('ds_img_hidden');            
        }
        $ext_img        = $this->extensao_imagem('img');

        $this->form_validation->set_rules('nm_aluno', 'nome do aluno','required|min_length[3]');
        $this->form_validation->set_rules('nm_mae', 'nome da mÃ£e','required|min_length[3]');
        $this->form_validation->set_rules('txt_data', 'data de nascimento','required');
        $this->form_validation->set_rules('fl_sexo', 'sexo','required');
        $this->form_validation->set_rules('cd_cidade', 'municipio','required');        
        $this->form_validation->set_rules('ds_telefone1', 'telefone 1','required');

        $this->form_validation->set_rules('cd_escola', 'escola','required');
        
        if ($this->form_validation->run() == FALSE) {

            if ( !isset( $params['ci_aluno'] ) ) { 
                $this->novo();
            }else{                
                $this->editar( $params['ci_aluno'] );
            }
        } else {
            
            if ( !isset( $params['ci_aluno']) ) {
               
                if ($this->modelaluno->inserir( $params )){
                    
                    $ci_aluno = $this->modelaluno->get_id( $params );

                    $this->persistir_Imagem($ci_aluno , $ds_img, $ext_img, '', 'img');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    
                    if ($cd_turma){
                        
                        $obj = new stdClass();
                        $obj->cd_aluno = $ci_aluno;
                        $obj->cd_turma = $cd_turma;
                        $obj->fl_ativo = true;                
                        $enturmacoes[]= $obj;

                        $this->modelenturmacao->gravar_enturmacaoAluno($enturmacoes);
                    }
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
                $nm_img = '';
                if ($ds_img){
                    $nm_img = md5($params['ci_aluno']).'.'.$ext_img; //nome do aquivo = id + extensÃ£o
                    $params['img'] = $nm_img;
                }                
                
                if ($this->modelaluno->alterar( $params )){
                    
                    $this->upload_img($nm_img, 'img', $ext_img);
                    
                    // echo '<br><br>$cd_turma='.$cd_turma;
                    // echo '<br><br>$ci_aluno='.$params['ci_aluno'];die;
                    //if ($ci_ultimaenturmacao){
                        //echo '<br><br><br><br><br><br>$cd_enturmacao='.$cd_enturmacao;
                        //echo '<br><br><br><br><br><br>$ci_ultimaenturmacao='.$ci_ultimaenturmacao;
                        //die;
                        $obj = new stdClass();
                        $obj->cd_aluno       = $params['ci_aluno'];
                        $obj->cd_turma       = $cd_turma;                        
                        $obj->ci_ultimaenturmacao  = $ci_ultimaenturmacao;
                        $obj->fl_ativo       = true;
                        $obj->cd_usuario_cad = $this->session->userdata('ci_usuario');
                        $enturmacoes[]= $obj;

                        $this->modelenturmacao->gravar_enturmacaoAluno($enturmacoes);
                    //}

                    $this->editar($params['ci_aluno'], "success");
                    
                }else{
                    $this->editar($params['ci_aluno'], "registro_ja_existente");
                }

            }
        }

    }

    public function busca_cabecalho(){
        $results = $this->modelaluno->busca_cabecalho( $this->cd_usuario );
        
        $dados['cd_estado']     = null;
        $dados['cd_cidade']     = null;
        $dados['cd_escola']     = null;
        $dados['cd_turma']      = null;
        $dados['nr_inep_escola']= null;
        $dados['cidades']       = null;
        $dados['escolas']       = null;
        $dados['turmas']        = null;
        $dados['fl_bloqueado']  = null;

        foreach ($results as $result) {
            $dados['cd_estado']     = $result->cd_estado;
            $dados['cd_cidade']     = $result->cd_cidade;
            $dados['nr_inep_escola']= $result->nr_inep_escola;
            $dados['cd_escola']     = $result->cd_escola;
            $dados['cd_turma']      = $result->cd_turma;
            $dados['fl_bloqueado']  = $result->fl_bloqueado;
        }

        if ($this->session->userdata('ci_grupousuario') == 2){
            $dados['cd_estado']   = $this->session->userdata('cd_estado_sme');
            $dados['cd_cidade']   = $this->session->userdata('cd_cidade_sme');
        }else if ($this->session->userdata('ci_grupousuario') == 3){
            $dados['cd_estado'] = $this->session->userdata('cd_estado_sme');
            $dados['cd_cidade'] = $this->session->userdata('cd_cidade_sme');            
            $dados['cd_escola'] = $this->session->userdata('ci_escola');
        }

        if ($dados['fl_bloqueado'] == 'S'){

            $dados['estados']    = $this->modelestado->selectEstados($dados['cd_estado']); 
            $dados['municipios'] = $this->modelcidade->selectCidade($dados['cd_estado'], '', '', '', $dados['cd_cidade']);
            $dados['escolas']   = $this->modelescola->selectEscola($dados['cd_cidade'], $dados['nr_inep_escola']);
            $dados['turmas']    = $this->modelturma->selectTurmas('', $dados['cd_escola'], $dados['cd_turma']);
        }else{
            $dados['estados']    = $this->modelestado->selectEstados(); 
            $dados['escolas']   = $this->modelescola->selectEscola($dados['cd_cidade']);
            $dados['turmas']    = $this->modelturma->selectTurmas('', $dados['cd_escola']);
        }
        return $dados;
    }

    public function novo($msg = null){
        $this->verifica_sessao();        
        
        $dados = $this->busca_cabecalho( );

        $dados['titulo']        = $this->titulo;
        $dados['msg']           = $msg;
        if ($msg != null) {
            $dados['msg']       = $msg;
        }
        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['deficiencia']   = $this->modeldeficiencia->selectDeficiencia();

        if ($this->session->userdata('ci_grupousuario') == 1){ // Se for Administrador

            

            // $cd_estado      = $this->input->post('cd_estado_sme');
            // $cd_cidade      = $this->input->post('cd_cidade_sme');
            // $nr_inep_escola = $this->input->post('nr_inep_escola');
            // $cd_escola      = $this->input->post('cd_escola');
            // $cd_turma       = $this->input->post('cd_turma');
    
            // $dados['nr_inep_escola']      = $this->input->post('nr_inep_escola');
            // $dados['fl_bloqueado']        = $this->input->post('fl_bloqueado');



            // if ($dados['fl_bloqueado'] == 'S'){
            //     $dados['estados'] = $this->modelestado->selectEstados( $cd_estado );
            //     $dados['municipios'] = $this->modelcidade->selectCidade( $cd_estado , '', '', '', $cd_cidade);
            //     $dados['escolas'] = $this->modelescola->selectEscola( $cd_cidade, '',  $cd_escola );   
            //     $dados['turmas'] = $this->modelturma->selectTurmas('', $cd_escola , $cd_turma );
            // }

        }else if ($this->session->userdata('ci_grupousuario') == 2){ // Se for SME

            // $params['cd_cidade'] = $this->session->userdata('cd_cidade_sme');

            // $dados['escolas'] = $this->modelescola->buscar($params);
            //echo $this->db->last_query();die;
        }else{
            $cd_escola = $this->session->userdata('ci_escola');
           
            // $dados['turmas'] = $this->modelturma->selectTurmas('', $cd_escola, '');
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('aluno/aluno_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function editar($id = null,$ano = null, $msg = null){
        
        $this->verifica_sessao();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $params['ci_aluno'] = $id;
        $params['cd_ano_letivo'] = empty($ano)?Date('Y'):$ano;
        $dados['ano']=$ano;
        $dados['registros']   = $this->modelaluno->buscar($params);
        
        //echo $this->db->last_query();die;
        //print_r($dados['registros']);die;
        // $dados['turmas'] = $this->modelturma->get_turmas_combo($cd_escola);  

        foreach ($dados['registros'] as $registro){
            $cd_estado_sme      = $registro->ci_estado_sme;
            $cd_cidade          = $registro->ci_cidade_sme;
            $cd_escola          = $registro->cd_escola;
            $cd_turma           = $registro->cd_turma;
            $cd_tipodeficiencia = $registro->cd_tipodeficiencia;



            $dados['estados'] = $this->modelestado->get_estados($cd_estado_sme);
            $dados['municipios']  = $this->modelmunicipio->get_municipios($cd_estado_sme);
            $dados['escolas'] = $this->modelescola->buscar($cd_escola);

            $dados['turmas'] = $this->modelturma->selectTurmas('', $cd_escola, $cd_turma);

            $dados['deficiencia']   = $this->modeldeficiencia->selectDeficiencia($cd_tipodeficiencia);
        }

        if ($this->session->userdata('ci_grupousuario') == 1){
            $cd_estado_sme   = '';
            $cd_cidade_sme   = '';
            foreach ($dados['registros'] as $registro){
                $cd_estado_sme   = $registro->ci_estado_sme;
                $cd_cidade_sme   = $registro->ci_cidade_sme;

            }
            if ($cd_estado_sme){
                $dados['estados_sme']    = $this->modelestado->selectEstados($cd_estado_sme);
                $dados['municipios_sme'] = $this->modelcidade->selectCidade($cd_estado_sme, '', '', '', $cd_cidade_sme);
            }
        }
                
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('aluno/aluno_alt', $dados);
        $this->load->view('template/html-footer');
    }
    
    public function reativar(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelaluno->reativar($id);
            $this->listagem_consulta();
        }else{
            echo $status_sessao;
        }
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelaluno->excluir($id);
            $this->listagem_consulta();
        }else{
            echo $status_sessao;
        }
    }
    
    // Recebe o nome do campo file do form contendo o arquivo e devolve a extensÃ£o do arquivo
    public function extensao_imagem($nm_campo_img){

        $path   = $_FILES[$nm_campo_img]['name'];     // Extrai o nome completo do arquivo enviado
        return  pathinfo($path, PATHINFO_EXTENSION);  // Extraindo a extensÃ£o do arquivo
        
    }

    public function persistir_Imagem($id, $campo_post, $extensao, $complemento_nome, $nm_campo){

        if ($campo_post){
            $nm_img = md5($id).$complemento_nome.'.'.$extensao; //nome do aquivo = id + complemento + extensÃ£o

            $this->modelaluno->grava_img_db($id, $nm_campo, $nm_img);  
            $this->upload_img($nm_img, $nm_campo, $extensao);
        }
    }

    public function upload_img($nm_img, $ds_campo_file_img, $ext)
    {
        if(!$this->session->userdata('logado')){
            redirect(base_url('login'));
        }
       $ext = mb_strtoupper($ext, 'UTF-8');

       if (($ext == 'JPG') || ($ext == 'JPEG') || ($ext == 'PNG') || ($ext == 'GIF')){   

            $config['upload_path'] = './assets/img/alunos';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $nm_img;
            $config['overwrite'] = TRUE;
            $config['max_size'] = '10240';//5mb

            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($ds_campo_file_img)){
                // echo 'Arquivo salvo com sucesso.';
            }
            else
                echo $this->upload->display_errors();
        }    
    }
    
}
