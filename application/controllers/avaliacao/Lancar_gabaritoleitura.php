<?php
/**
 * Created by PhpStorm.
 * User: Windows
 * Date: 08/10/2018
 * Time: 20:28
 */
class Lancar_gabaritoleitura extends CI_Controller
{
    protected $titulo = 'Lançar Gabarito dos Alunos';

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
    public function index($msg=null){
       
        $this->verifica_sessao();
        $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
        $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
        $dados['estado'] = $this->modelestado->selectEstados($id_estado);
        $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);

        $params['ci_usuario']=$this->session->userdata('ci_usuario');
        $cd_etapa = $this->input->post('cd_etapa');
        
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
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

        if ($this->session->userdata('ci_grupousuario')==3) {
            $parametro=$dados['ci_escola'];
            $dados['etapas'] = $this->modeletapa->buscaOfertaEscola($parametro);
            $dados['turmas'] = $this->modelturma->buscar();
        }else if ($this->session->userdata('ci_grupousuario') == 1) {
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
            $this->load->view('avaliacoes_lancamento/lancar_gabaritoleitura', $dados);
            $this->load->view('template/html-footer');
        }else{
            $this->listagem_consulta();
        }
    }

    public function listagem_consulta(){
            $params['ci_usuario']=$this->session->userdata('ci_usuario');
            $params['ci_escola']=$this->input->post('cd_escola');

            $id_estado =!empty($this->input->post('cd_estado'))?$this->input->post('cd_estado'):NULL;
            $id_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
            $dados['estado'] = $this->modelestado->selectEstados($id_estado);
            $dados['cidade'] = $this->modelmunicipio->selectCidades($id_estado,$id_cidade);

            if ($this->session->userdata('ci_grupousuario') == 1) {
                   $dados['etapas'] = $this->modeletapa->buscar();
                    $cd_cidade =!empty($this->input->post('cd_cidade'))?$this->input->post('cd_cidade'):NULL;
                    $nr_inep =!empty($this->input->post('nr_inep_escola'))?$this->input->post('nr_inep_escola'):NULL;
                    $dados['escolas']= $this->modelescola->selectEscola($cd_cidade,$nr_inep);            
            }

            //$dados['avaliacoes_lancamento'] = $this->modelenturmacao->buscar();
            $dados['nr_inep'] = '';
            $dados['nm_escola'] = '';
            $dados['escola'] = $this->modelescola->buscaEscolaUsuario($params);

            foreach ($dados['escola'] as $escola) {
                $dados['nr_inep'] = $escola->nr_inep;
                $dados['nm_escola'] = $escola->nm_escola;
                $dados['ci_escola'] = $escola->ci_escola;
            }

            $cd_etapa = $this->input->post('cd_etapa');
            $ci_turma = $this->input->post('cd_turma');
            $cd_disciplina = $this->input->post('cd_disciplina');
            $cd_avaliacao = $this->input->post('cd_avaliacao');
            $parames['cd_etapa'] = $cd_etapa;
            $parames['cd_disciplina'] = $cd_disciplina;
            $dados['etapas'] = $this->modeletapa->buscar();
            $dados['turmas'] = $this->modelturma->buscar($ci_turma);
            $dados['disciplinas'] = $this->modeldisciplina->buscar();
            $dados['avaliacoes'] = $this->modelavaliacao->buscaAvaliacaoLeituraDisponivel($parames);
            $params['cd_etapa'] = $cd_etapa;
            $params['cd_turma'] = $ci_turma;
            $params['cd_disciplina'] = $cd_disciplina;
            $params['cd_avaliacao'] = $cd_avaliacao;

            $dados['registros'] = $this->modelenturmacao->buscaEnturmacaoLeitura($params);
            //$dados['itensinseridos'] = $this->modelenturmacao->buscaItensInseridos($params);
            //echo $this->db->last_query();die;
            //$dados['itens'] = $this->modelenturmacao->buscaItens($params);

            $this->load->view('avaliacoes_lancamento/lancar_gabaritoleitura', $dados);
            $this->load->view('template/html-footer');
    }

    public function buscaEnturmacao(){
            $params['cd_turma']= $this->input->post('cd_turma');
            $dados= json_encode($this->modelenturmacao->buscaEnturmacao($params));
            if($dados !=null) echo $dados;
    }

    public function salvar(){
        //$this->verifica_sessao();
        $var_cd_alunos = $this->input->post('cd_aluno');
        $itens=$_POST['itens'];
        $questoes = $_POST['cd_item'];
        $motivo= $_POST['cd_naoavaliado'];
        $cd_situacao = $this->input->post('cd_participou');
        $cd_avaliacao_upload = $this->input->post('cd_avaliacao_upload');
        $gabarito = "";

        $qtd_reg = 0;
        foreach ($itens as $i => $item){

                $qtd_reg = $qtd_reg + 1;
                $obj = new stdClass();
                $obj->cd_aluno = $var_cd_alunos;
                $obj->cd_avaliacao_itens = intval($item);
                $obj->cd_situacao_aluno=intval($cd_situacao);
                $obj->cd_usuario_cad = $this->session->userdata('ci_usuario');
                if(intval($cd_situacao)==1){
                    $obj->nr_alternativa_escolhida = intval($questoes[$i]);
                }
                if(intval($cd_situacao)==2){
                    $obj->nr_alternativa_escolhida =0;
                    $obj->cd_motivonaovaliacao_aluno = intval($motivo[$i]);
                }
                $obj->cd_avaliacao_upload=intval($cd_avaliacao_upload);
                $gabarito[]= $obj;

        }
        
        if ($qtd_reg >= 1){
            if ($this->modelgabarito->inserirleitura($var_cd_alunos, $gabarito,$itens, $qtd_reg,$cd_avaliacao_upload)){
                $this->index("success");
            }else{
                $this->index("ocorreu_um_erro");
            }
        }else{
            $this->index("nenhuma_turma_escolhida");
        }

    }
}