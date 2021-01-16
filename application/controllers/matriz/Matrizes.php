<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matrizes extends CI_Controller
{
    protected $titulo = 'MATRIZ DE REFERÊNCIA';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('matrizes_model', 'modelmatriz');
        $this->load->model('etapas_model',   'modeletapa');
        $this->load->model('disciplina_model', 'modeldisciplina');
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
    public function index($offset=null){
        $this->verifica_sessao();

        $dados['matrizes']           = $this->modelmatriz->buscar();
        $dados['etapas']             = $this->modeletapa->buscar();
        $dados['disciplinas']        = $this->modeldisciplina->buscar();
                
        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('matriz/matriz', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_matriz     = $this->input->post('ci_matriz');
            $nm_matriz     = $this->input->post('nm_matriz');
            $cd_etapa      = $this->input->post('cd_etapa');
            $cd_disciplina = $this->input->post('cd_disciplina');

            // $ds_codigo-1              = $this->input->post('ds_codigo-1');
            // $nm_matriz_descritor-1    = $this->input->post('nm_matriz_descritor-1');
            

            //echo '<br><br><br>$cd_turno='.$cd_turno;
            //return false;
            $dados['titulo'] = $this->titulo;

            $limit = '10';

            $dados['registros'] = $this->modelmatriz->buscar(   $ci_matriz,
                                                                $nm_matriz,
                                                                $cd_disciplina,
                                                                $cd_etapa,
                                                                '', $limit, $offset);


            $dados['total_registros'] = $this->modelmatriz->count_buscar(   $ci_matriz,
                                                                            $nm_matriz,
                                                                            $cd_disciplina,
                                                                            $cd_etapa);

            $config['base_url']    = base_url("matriz/matrizes/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('matriz/matriz_lista', $dados);
        }else{
            echo $status_sessao;
         }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_matriz              = $this->input->post('ci_matriz');
        $nm_caderno             = $this->input->post('nm_caderno');
        $cd_cidade              = $this->input->post('cd_cidade');
        $cd_estado              = $this->input->post('cd_estado');
        $cd_etapa               = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
        $cd_edicao              = $this->input->post('cd_edicao');
        $fl_tipoavaliacao       = $this->input->post('fl_tipoavaliacao');

        $result = $this->modelmatriz->get_consulta_excel( $ci_matriz,
                                                                    $nm_caderno,
                                                                    $cd_avalia_tipo,
                                                                    $cd_disciplina,
                                                                    $cd_etapa,
                                                                    $cd_edicao,
                                                                    $fl_tipoavaliacao);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_matriz    = $this->input->post('ci_matriz');
        $nm_caderno             = $this->input->post('nm_caderno');
        $cd_cidade              = $this->input->post('cd_cidade');
        $cd_estado              = $this->input->post('cd_estado');
        $cd_etapa               = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
        $cd_edicao              = $this->input->post('cd_edicao');
        $fl_tipoavaliacao       = $this->input->post('fl_tipoavaliacao');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelmatriz->get_consulta_pdf(   $ci_matriz,
                                                                                $nm_caderno,
                                                                                $cd_avalia_tipo,
                                                                                $cd_disciplina,
                                                                                $cd_etapa,
                                                                                $cd_edicao,
                                                                                $fl_tipoavaliacao,
                                                                                '', '', '');
        $pagina =$this->load->view('matriz/matriz_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_matriz       = $this->input->post('ci_matriz');
        $nm_matriz       = strtoupper ($this->input->post('nm_matriz'));
        $cd_etapa        = $this->input->post('cd_etapa');
        $cd_disciplina   = $this->input->post('cd_disciplina');
        $arr_topicos     = $this->input->post('nm_matriz_topico');

        $str_descritores = '';
        $x = 0;
        foreach ($arr_topicos as $i => $value){ 

            $arr_codigo = $this->input->post('ds_codigo-'.($i+1));
            $arr_nome   = $this->input->post('nm_matriz_descritor-'.($i+1)); 

            
            foreach ($arr_codigo as $y => $vl_codigo){ // Criando array descritores
                $x++;
                
                if ($x == 1){
                    
                    $str_descritores = $str_descritores. '{ 
                                                                "num_ordem_topico": "'.$i.'", 
                                                                "ds_codigo": "'.$vl_codigo.'", 
                                                                "nm_matriz_descritor": "'.$arr_nome[$y].'" 
                                                        }';
                }else{

                    $str_descritores = $str_descritores. ',{ 
                                                                "num_ordem_topico": "'.$i.'", 
                                                                "ds_codigo": "'.$vl_codigo.'", 
                                                                "nm_matriz_descritor": "'.$arr_nome[$y].'" 
                                                        }';

                }
                //echo $str_descritores;
            }
        }

        // print_r($arr_topicos);
        // echo '<br><br><br>$str_descritores='.$str_descritores;
        $str_descritores  = '['. $str_descritores .']';

        $json_descritores = json_decode($str_descritores); // transforma string json em obj json;
          

        $this->form_validation->set_rules('nm_matriz', 'nome da matriz','required');
        $this->form_validation->set_rules('cd_disciplina', 'disciplina','required');
        $this->form_validation->set_rules('cd_etapa', 'etapa','required');
		
        if ($this->form_validation->run() == FALSE) {
            if (!$ci_matriz) { 
                $this->novo();
            }else{
                $this->editar($ci_matriz);
            }
        } else {

            if (!$ci_matriz) {

                if ($this->modelmatriz->inserir($nm_matriz,
                                                $cd_disciplina,
                                                $cd_etapa,
                                                $arr_topicos,
                                                $json_descritores
                                            )){

                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    


                if ($this->modelmatriz->alterar($ci_matriz,
                                                $nm_matriz,
                                                $cd_disciplina,
                                                $cd_etapa,
                                                $arr_topicos,
                                                $json_descritores)){
                    

                    $this->editar($ci_matriz,"success");
                }else{
                    $this->editar($ci_matriz, "registro_ja_existente");
                }

            }
        }

    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['matrizes']           = $this->modelmatriz->buscar();
        $dados['etapas']             = $this->modeletapa->buscar();
        $dados['disciplinas']        = $this->modeldisciplina->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('matriz/matriz_cad',$dados);
        $this->load->view('template/html-footer');
    }
    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['matrizes']    = $this->modelmatriz->buscar($id);
        $dados['etapas']      = $this->modeletapa->buscar();
        $dados['disciplinas'] = $this->modeldisciplina->buscar();
        $dados['matrizavaliacao']  = $this->modelavaliacao->buscaMatrizAvaliacao($id);

        $dados['descritores'] = $this->modelmatriz->buscar_descritores($id);

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('matriz/matriz_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelmatriz->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
}
