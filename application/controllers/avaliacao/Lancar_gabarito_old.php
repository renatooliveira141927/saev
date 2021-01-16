<?php
/**
 * Created by PhpStorm.
 * User: Windows
 * Date: 08/10/2018
 * Time: 20:28
 */
class Lancar_gabarito extends CI_Controller
{
    protected $titulo = 'Lançar Gabarito dos Alunos';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('avaliacoes_lancamento_model', 'modelavaliacoes_lancamento');
        $this->load->model('turmas_model', 'modelturma');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('turnos_model', 'modelturno');
        $this->load->model('enturmacoes_model', 'modelenturmacao');
        $this->load->model('gabarito_model', 'modelgabarito');
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

        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['avaliacoes_lancamento'] = $this->modelenturmacao->buscar();
        $dados['turmas'] = $this->modelturma->buscar();
        $dados['etapas'] = $this->modeletapa->buscar();
        $dados['turnos'] = $this->modelturno->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg']    = $msg;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacoes_lancamento/gabarito', $dados);
        $this->load->view('template/html-footer');
    }
    public function buscaEnturmacao(){
            $params['cd_turma']= $this->input->post('cd_turma');
            $dados= json_encode($this->modelenturmacao->buscaEnturmacao($params));
            if($dados !=null) echo $dados;
    }

    /* public function salvar(){


        /*foreach( $questoes AS $key => $questao ) {
            echo $questao;
        }
        foreach( $itens AS $key => $item ) {
            echo '<item>'.$item.'</item>';
        }
    }*/

    public function salvar(){
        //$this->verifica_sessao();

        $var_cd_alunos = $this->input->post('cd_aluno');
        $itens=$_POST['itens'];
        $questoes = $_POST['cd_item'];
        $cd_situacao = $this->input->post('cd_participou+'.$var_cd_alunos);
        $gabarito = "";

        $qtd_reg = 0;
        foreach ($itens as $i => $item){

                $qtd_reg = $qtd_reg + 1;
                $obj = new stdClass();
                $obj->cd_aluno = $var_cd_alunos;
                $obj->cd_avaliacao_itens = intval($item);
                $obj->cd_situacao_aluno=intval($cd_situacao);
                $obj->nr_alternativa_escolhida = intval($questoes[$i]);

                $gabarito[]= $obj;

        }

        if ($qtd_reg >= 1){
            if ($this->modelgabarito->inserir($var_cd_alunos, $gabarito,$itens, $qtd_reg)){
                $this->index("success");
            }else{
                $this->index("ocorreu_um_erro");
            }
        }else{
            $this->index("nenhuma_turma_escolhida");
        }

    }
}