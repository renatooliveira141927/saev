<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anos_letivos extends CI_Controller
{
    protected $titulo = 'Ano letivo';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('anos_letivos_model', 'modelano_letivo');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');
        $this->load->model('escolas_model', 'modelescola'); 
        $this->load->model('cidade_model', 'modelcidade');
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
    public function index($offset=null){
        $this->verifica_sessao();       

        $dados['titulo'] = $this->titulo;
        $dados['estado']    = $this->modelestado->selectEstados();

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('ano_letivo/ano_letivo', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');

        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');
            $ci_ano_letivo = $this->input->post('ci_ano_letivo');
            $nr_ano_letivo = $this->input->post('nr_ano_letivo');
            $consulta      = $this->input->post('consulta');
            $nm_escola     = $this->input->post('nm_escola');
            $cd_estado     = $this->input->post('cd_estado');
            $cd_cidade     = $this->input->post('cd_cidade');
            $ci_escola     = $this->input->post('ci_escola');



            $dados['titulo'] = $this->titulo;

            $dados['registros'] = $this->modelano_letivo->buscar($ci_ano_letivo, 
                                                                 $nr_ano_letivo, 
                                                                 $ci_escola, 
                                                                 $nm_escola, 
                                                                 $consulta,
                                                                 $cd_cidade,
                                                                 $cd_estado);

            $this->load->view('ano_letivo/ano_letivo_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_ano_letivo          = $this->input->post('ci_ano_letivo');
        $nr_ano_letivo          = $this->input->post('nr_ano_letivo');
        $fl_ano_letivo_corrente = $this->input->post('fl_ano_letivo_corrente');
        $cd_escolas_selecionadas = $this->input->post('cd_escolas_selecionadas');

        $this->form_validation->set_rules('nr_ano_letivo', 'ano letivo','required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {
            if (!$ci_ano_letivo) { 
                $this->novo();
            }else{
                $this->editar($ci_ano_letivo);
            }
        } else {

            if (!$ci_ano_letivo) {
                if ($this->modelano_letivo->inserir($nr_ano_letivo, 
                                                    $fl_ano_letivo_corrente,
                                                    $cd_escolas_selecionadas)){

                    //$this->novo("success");
                    redirect(base_url('ano_letivo/anos_letivos/novo/success'));
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    
      
                
                if ($this->modelano_letivo->alterar($ci_ano_letivo,
                                                    $nr_ano_letivo, 
                                                    $fl_ano_letivo_corrente,
                                                    $cd_escolas_selecionadas)){


                    //$this->editar($ci_ano_letivo, "success");
                    redirect(base_url('ano_letivo/anos_letivos/editar/'.$ci_ano_letivo.'/'."success"));
                    
                }else{
                    redirect(base_url('ano_letivo/anos_letivos/editar/'.$ci_ano_letivo.'/'."success"));
                    //$this->editar($ci_ano_letivo, "registro_ja_existente");
                }

            }
        }

    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['anos_letivos']  = $this->modelano_letivo->buscar();
        $dados['estado']        = $this->modelestado->selectEstados();
        
        $dados['titulo']        = $this->titulo;
        $dados['msg']           = $msg;
        if ($msg != null) {
            $dados['msg']       = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('ano_letivo/ano_letivo_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['anos_letivos']      = $this->modelano_letivo->buscar();        
        $dados['anoletivo_escolas']  = $this->modelano_letivo->buscar_escolas($id, '', 'selecionadas');

        $cd_estado = '';
        $cd_cidade = '';
        foreach ($dados['anoletivo_escolas'] as $dado){
            $cd_estado = $dado->ci_estado;
            $cd_cidade = $dado->ci_cidade;
        
        }
        $dados['escolas_municipios'] = $this->modelano_letivo->buscar_escolas($id, $cd_cidade, 'nao_selecionadas');
        $dados['estado']        = $this->modelestado->selectEstados($cd_estado);
        if ($cd_estado){
            $dados['municipios']    = $this->modelcidade->selectCidade($cd_estado, '', '', '', $cd_cidade);
        }

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }


        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelano_letivo->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('ano_letivo/ano_letivo_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelano_letivo->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    public function set_anovigente(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelano_letivo->set_anovigente($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    
}
