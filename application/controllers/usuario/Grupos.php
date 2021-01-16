<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends CI_Controller
{
    protected $titulo = 'Grupos';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('escolas_model', 'modelescola');
        $this->load->model('estado_model', 'modelestado');
        $this->load->model('grupo_model', 'modelgrupo');
        $this->load->model('transacao_model', 'modeltransacao');
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
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('grupo/grupo', $dados);
        $this->load->view('template/html-footer');
    }
    public function listagem_escolas(){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        if ($status_sessao!='sessaooff') {

            $nr_inep    = $this->input->post('nr_inep');
            $nm_escola  = $this->input->post('nm_escola');
            $cd_cidade  = $this->input->post('cd_cidade');

            $escolas = $this->modelescola->buscar('', $nr_inep, $nm_escola, '', '', '', '', $cd_cidade);

            $html_tabela = '';
            foreach ($escolas as $escola){
                $html_tabela .= '<tr>'.PHP_EOL;
                $html_tabela .= '    <td>'.PHP_EOL;

                $html_tabela .= '       <div class="button-list">'.PHP_EOL;
                $html_tabela .= '           <a  type="button" '.PHP_EOL;
                $html_tabela .= '               id="ci_escola_'.$escola->ci_escola.'" '.PHP_EOL;
                $html_tabela .= '               onclick="add_select_escolas(\''.$escola->ci_escola.'\', \''.$escola->nr_inep.' - '.$escola->nm_escola.' - '.$escola->nm_cidade.'\');"'.PHP_EOL;
                $html_tabela .= '               class="btn btn-primary btn-custom">'.PHP_EOL;
                $html_tabela .= '               <i class="glyphicon glyphicon-plus img-circle btn-icon"></i>'.PHP_EOL;
                $html_tabela .= '           </a>'.PHP_EOL;
                $html_tabela .= '       </div>'.PHP_EOL;

                $html_tabela .= '    </td>'.PHP_EOL;
                $html_tabela .= '    <td>'.$escola->nr_inep.'</td>'.PHP_EOL;
                $html_tabela .= '    <td>'.$escola->nm_escola.'</td>'.PHP_EOL;
                $html_tabela .= '    <td>'.$escola->nm_cidade.'</td>'.PHP_EOL;
                $html_tabela .= '</tr>'.PHP_EOL;
            }
            echo $html_tabela;
            
        }else{
            echo $status_sessao;
        }

    }
    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            //$this->form_validation->set_rules('nm_grupo', 'nome do tipo de avaliação','min_length[3]|required');


            $this->load->library('pagination');

            $ci_grupo     = $this->input->post('ci_grupo');
            $nm_grupo     = $this->input->post('nm_grupo');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelgrupo->buscar('', $nm_grupo, '', $limit, $offset);
            $dados['total_registros'] = $this->modelgrupo->count_buscar('', $nm_grupo);

            $config['base_url']    = base_url("grupo/grupos/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('grupo/grupo_lista', $dados);
            
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_grupo     = $this->input->post('ci_grupo');
        $nm_grupo     = $this->input->post('nm_grupo');

        $result = $this->modelgrupo->get_consulta_excel($ci_grupo, 
                                                        $nm_grupo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_grupo     = $this->input->post('ci_grupo');
        $nm_grupo     = $this->input->post('nm_grupo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelgrupo->buscar($ci_grupo, 
                                                                     $nm_grupo, '', '', '');
        $pagina =$this->load->view('grupo/grupo_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $dados['estado']    = $this->modelestado->selectEstados();
        $dados['transacoes'] = $this->modeltransacao->buscar();
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('grupo/grupo_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $id                 = $this->input->post('ci_grupousuario');
        $nm_grupo           = $this->input->post('nm_grupo');
        $tp_administrador           = $this->input->post('tp_administrador');
        $arr_ci_transacoes  = $this->input->post('arr_transacoes');
        $arr_ci_escolas     = $this->input->post('arr_escolas');

        if (!$tp_administrador){
            $tp_administrador = 'E'; // Se não for administrador será do tipo escola
        }

        // echo '<br><br><br><br>$arr_ci_transacoes=' .print_r($arr_ci_transacoes);
        // echo '<br><br><br><br>$arr_ci_escolas=' .print_r($arr_ci_escolas);

        $this->form_validation->set_rules('nm_grupo', 'grupo','required');

        
            if ($this->form_validation->run() == FALSE) {
                $this->novo();
            } else {

                if (!$id) {

                    if ($this->modelgrupo->inserir($nm_grupo, $tp_administrador, $arr_ci_transacoes, $arr_ci_escolas)){
                        $this->novo("success");
                    }else{
                        $this->novo("registro_ja_existente");
                    }
                }
                else {
                    if ($this->modelgrupo->alterar($id, $nm_grupo, $tp_administrador, $arr_ci_transacoes, $arr_ci_escolas)){
                        $this->editar($id, "success");
                    }else{
                        $this->editar($id,"registro_ja_existente");
                    }

                }

            }
       
    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        $dados['estado']            = $this->modelestado->selectEstados();
        $dados['transacoes']        = $this->modeltransacao->buscar();
        $dados['escolas']           = $this->modelgrupo->buscar_grupoescolas($id);
        $dados['grupotransacoes']   = $this->modelgrupo->buscar_transacoes($id);
        $dados['registros']         = $this->modelgrupo->buscar($id);
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('grupo/grupo_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('ci_grupousuario');
            $this->modelgrupo->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }

}