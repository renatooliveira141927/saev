<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacao_uploads extends CI_Controller
{
    protected $titulo = 'Avaliação';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');        
        $this->load->model('avaliacao_uploads_model', 'modelavaliacao_upload');
        $this->load->model('etapas_model', 'modeletapa');
        $this->load->model('disciplina_model', 'modeldisciplina');
        $this->load->model('avalia_tipo_model', 'modelavalia_tipo');
        $this->load->model('edicao_model', 'modeledicao');
        $this->load->model('matrizes_model', 'modelmatriz');


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

        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
                
        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacao_upload/avaliacao_upload', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_avaliacao_upload    = $this->input->post('ci_avaliacao_upload');
            $nm_caderno             = $this->input->post('nm_caderno');
            $cd_etapa               = $this->input->post('cd_etapa');
            $cd_disciplina          = $this->input->post('cd_disciplina');
            $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
            $cd_edicao              = $this->input->post('cd_edicao');
            $fl_tipoavaliacao       = $this->input->post('fl_tipoavaliacao');
            

            //echo '<br><br><br>$cd_turno='.$cd_turno;
            //return false;
            $dados['titulo'] = $this->titulo;

            $limit = '10';

            $dados['registros'] = $this->modelavaliacao_upload->buscar( $ci_avaliacao_upload,
                                                                        $nm_caderno,
                                                                        $cd_avalia_tipo,
                                                                        $cd_disciplina,
                                                                        $cd_etapa,
                                                                        $cd_edicao,
                                                                        $fl_tipoavaliacao,
                                                                        '', $limit, $offset);


            // $dados['total_registros'] = count($dados['registros']);
            //print_r($this->db->last_query());die;

            $dados['total_registros'] = $this->modelavaliacao_upload->count_buscar($ci_avaliacao_upload,
                                                                                   $nm_caderno,
                                                                                   $cd_avalia_tipo,
                                                                                   $cd_disciplina,
                                                                                   $cd_etapa,
                                                                                   $cd_edicao,
                                                                                   $fl_tipoavaliacao);

            $config['base_url']    = base_url("avaliacao_upload/avaliacao_uploads/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avaliacao_upload/avaliacao_upload_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avaliacao_upload    = $this->input->post('ci_avaliacao_upload');
        $nm_caderno             = $this->input->post('nm_caderno');
        $cd_cidade              = $this->input->post('cd_cidade');
        $cd_estado              = $this->input->post('cd_estado');
        $cd_etapa               = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
        $cd_edicao              = $this->input->post('cd_edicao');
        $fl_tipoavaliacao       = $this->input->post('fl_tipoavaliacao');

        $result = $this->modelavaliacao_upload->get_consulta_excel( $ci_avaliacao_upload,
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
        $ci_avaliacao_upload    = $this->input->post('ci_avaliacao_upload');
        $nm_caderno             = $this->input->post('nm_caderno');
        $cd_cidade              = $this->input->post('cd_cidade');
        $cd_estado              = $this->input->post('cd_estado');
        $cd_etapa               = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
        $cd_edicao              = $this->input->post('cd_edicao');
        $fl_tipoavaliacao       = $this->input->post('fl_tipoavaliacao');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavaliacao_upload->get_consulta_pdf(   $ci_avaliacao_upload,
                                                                                $nm_caderno,
                                                                                $cd_avalia_tipo,
                                                                                $cd_disciplina,
                                                                                $cd_etapa,
                                                                                $cd_edicao,
                                                                                $fl_tipoavaliacao,
                                                                                '', '', '');
        $pagina =$this->load->view('avaliacao_upload/avaliacao_upload_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();
        
        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        $dados['matrizes']      = $this->modelmatriz->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacao_upload/avaliacao_upload_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_avaliacao_upload    = $this->input->post('ci_avaliacao_upload');
        $nm_caderno             = $this->input->post('nm_caderno');
        $cd_avalia_tipo         = $this->input->post('cd_avalia_tipo');
        $cd_edicao              = $this->input->post('cd_edicao');
        // $nr_ano                 = $this->input->post('nr_ano');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_etapa               = $this->input->post('cd_etapa');
        $ds_codigo              = $this->input->post('ds_codigo');
        $ci_matriz              = $this->input->post('ci_matriz');
        $cd_matriz              = $this->input->post('cd_matriz');
        $nr_opcaocorreta        = $this->input->post('nr_opcaocorreta');

        //LIBERAÇÃO POR MUNICIPIO
        $estados =$this->input->post('idestado');
        $municipios = $this->input->post('idcidade');
        $dt_caderno =$this->input->post('dtcaderno');
        $dt_inicio =$this->input->post('dtinicio');
        $dt_final = $this->input->post('dtfim');

        $editarmatriz           =  $this->input->post('editarmatriz');        
        $ds_arquivo_avaliacao   = $this->input->post('ds_arquivo_avaliacao');
        $ds_arquivo_aplicador   = $this->input->post('ds_arquivo_aplicador');
        $pdf_arquivo_avaliacao_hidden   = $this->input->post('pdf_arquivo_avaliacao_hidden');
        $pdf_arquivo_aplicador_hidden   = $this->input->post('pdf_arquivo_aplicador_hidden');

        // Inicio dados arquivo de avaliação
        $pdf_arquivo_avaliacao      = $_FILES['ds_arquivo_avaliacao']['name'];
        $ext_pdf_arquivo_avaliacao  = $this->extensao_imagem('ds_arquivo_avaliacao');

        // Fim dados arquivo de avaliação

        // Inicio dados do arquivo de avaliação
        $pdf_arquivo_aplicador      = $_FILES['ds_arquivo_aplicador']['name'];
        $ext_pdf_arquivo_aplicador  = $this->extensao_imagem('ds_arquivo_aplicador');

        // Fim dados do arquivo de avaliação

        $this->form_validation->set_rules('nm_caderno', 'Avaliação:Nome do caderno','required');
        $this->form_validation->set_rules('cd_avalia_tipo', 'Avaliação:Tipo de avaliação','required');
        $this->form_validation->set_rules('cd_edicao', 'Avaliação:Edição','required');
        $this->form_validation->set_rules('cd_disciplina', 'Avaliação:Disciplina','required');
        $this->form_validation->set_rules('cd_etapa', 'Avaliação:Etapa','required');        
        //$this->form_validation->set_rules('dt_inicio', 'Municipío:Data Inicio','required');
        //$this->form_validation->set_rules('dt_final', 'Municipío:Data Final','required');
    
        /*if(sizeof($estados)==0){
            $this->form_validation->set_rules('cd_cidade_participante', 'Municipío:Municípios participantes','required');    
        }*/
        		
        if ($this->form_validation->run() == FALSE) {
            if (!$ci_avaliacao_upload) { 
                $this->novo();
            }else{
                $this->editar($ci_avaliacao_upload);
            }
        } else {

            if (!$ci_avaliacao_upload) {
            
                if ($this->modelavaliacao_upload->inserir(  $nm_caderno,
                                                            $cd_avalia_tipo,
                                                            $cd_edicao,
                                                            // $nr_ano,
                                                            $cd_disciplina,
                                                            $cd_etapa,
                                                            $ds_codigo,
                                                            $ci_matriz,
                                                            $cd_matriz,
                                                            //$cd_cidade_participante,
                                                            $nr_opcaocorreta,
                                                            //$dt_inicio,
                                                            //$dt_final
                                                            $estados,
                                                            $municipios,
                                                            $dt_caderno,
                                                            $dt_inicio,
                                                            $dt_final
                                                        )){

                    $ci_avaliacao_upload = $this->modelavaliacao_upload->get_id($nm_caderno, $cd_avalia_tipo, $cd_disciplina, $cd_etapa, $cd_edicao);


                    if($pdf_arquivo_avaliacao){
                        $this->persistir_Imagem($ci_avaliacao_upload, $pdf_arquivo_avaliacao, $ext_pdf_arquivo_avaliacao, '_avaliacao', 'ds_arquivo_avaliacao');
                        $this->persistir_Imagem($ci_avaliacao_upload, $pdf_arquivo_aplicador, $ext_pdf_arquivo_aplicador, '_aplicador', 'ds_arquivo_aplicador');
                    }
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                $enviar_arquivo_avaliacao = false;
                $enviar_arquivo_aplicador = false;

                if ($pdf_arquivo_avaliacao){
                    $pdf_arquivo_avaliacao = md5($ci_avaliacao_upload).'_avaliacao.'.$ext_pdf_arquivo_avaliacao; //nome do aquivo = id + extensão
                    $enviar_arquivo_avaliacao = true;

                }else if ($pdf_arquivo_avaliacao_hidden){
                    $pdf_arquivo_avaliacao = $pdf_arquivo_avaliacao_hidden;
                }

                if ($pdf_arquivo_aplicador){
                    $pdf_arquivo_aplicador = md5($ci_avaliacao_upload).'_aplicador.'.$ext_pdf_arquivo_aplicador; //nome do aquivo = id + extensão
                    $enviar_arquivo_aplicador = true;

                }else if ($pdf_arquivo_aplicador_hidden){
                    $pdf_arquivo_aplicador = $pdf_arquivo_aplicador_hidden;
                }

                if ($this->modelavaliacao_upload->alterar(  $ci_avaliacao_upload,
                                                            $nm_caderno,
                                                            $cd_avalia_tipo,
                                                            $cd_edicao,
                                                            // $nr_ano,
                                                            $cd_disciplina,
                                                            $cd_etapa,
                                                            $pdf_arquivo_avaliacao,
                                                            $pdf_arquivo_aplicador,
                                                            $ds_codigo,
                                                            //$ci_matriz,
                                                            $cd_matriz,
                                                            $cd_cidade_participante,
                                                            $nr_opcaocorreta,
                                                            //$dt_inicio,
                                                            //$dt_final,
                                                            //$editarmatriz
                    $estados,
                    $municipios,
                    $dt_caderno,
                    $dt_inicio,
                    $dt_final)){

                    
                    if($enviar_arquivo_avaliacao){
                            $this->persistir_Imagem($ci_avaliacao_upload, $pdf_arquivo_avaliacao, $ext_pdf_arquivo_avaliacao, '_avaliacao', 'ds_arquivo_avaliacao');                       
                        //$this->upload_pdf($pdf_arquivo_avaliacao, 'ds_arquivo_avaliacao', $ext_pdf_arquivo_avaliacao);
                    }

                    if($enviar_arquivo_aplicador){
                        //$this->upload_pdf($pdf_arquivo_aplicador, 'ds_arquivo_aplicador', $ext_pdf_arquivo_aplicador);
                         $this->persistir_Imagem($ci_avaliacao_upload, $pdf_arquivo_aplicador, $ext_pdf_arquivo_aplicador, '_aplicador', 'ds_arquivo_aplicador');
                    }

                    $this->editar($ci_avaliacao_upload,"success");
                }else{
                    $this->editar($ci_avaliacao_upload, "registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();

        $dados['estado']        = $this->modelestado->selectEstados();
        $dados['disciplinas']   = $this->modeldisciplina->buscar();
        $dados['avalia_tipos']  = $this->modelavalia_tipo->buscar();
        $dados['etapas']        = $this->modeletapa->buscar();
        $dados['edicoes']       = $this->modeledicao->buscar();
        // $dados['matrizes']      = $this->modelmatriz->buscar();

        $dados['edicoes']       = $this->modeledicao->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['matrizes'] = $this->modelavaliacao_upload->buscar_matrizes( $id);
        //echo $this->db->last_query();die;
        $dados['municipios'] = $this->modelavaliacao_upload->buscar_municipios( $id);
        $dados['registros']   = $this->modelavaliacao_upload->buscar($id);
        //echo $this->db->last_query();die;
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avaliacao_upload/avaliacao_upload_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelavaliacao_upload->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    // Recebe o nome do campo file do form contendo o arquivo e devolve a extensão do arquivo
    public function extensao_imagem($nm_campo_pdf){

        $path   = $_FILES[$nm_campo_pdf]['name'];     // Extrai o nome completo do arquivo enviado
        return  pathinfo($path, PATHINFO_EXTENSION);  // Extraindo a extensão do arquivo
        
    }

    public function persistir_Imagem($id, $campo_post, $extensao, $complemento, $nm_campo){

        if ($campo_post){
            $nm_pdf = md5($id).$complemento.'.'.$extensao; //nome do aquivo = id + extensão

            $this->modelavaliacao_upload->grava_pdf_db($id, $nm_campo, $nm_pdf);  
            $this->upload_pdf($nm_pdf, $nm_campo, $extensao);
        }
    }

    public function upload_pdf($nm_pdf, $ds_campo_file_pdf, $ext)
    {
        if(!$this->session->userdata('logado')){
            redirect(base_url('login'));
        }
        // $nm_pdf = mb_strtoupper($nm_pdf, 'UTF-8');
       $ext = mb_strtoupper($ext, 'UTF-8');
 
        if ($ext == 'PDF'){   

            $config['upload_path'] = './assets/pdf/avaliacao_uploads';
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $nm_pdf;
            $config['overwrite'] = TRUE;
            $config['max_size'] = '10240';//5mb

            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($ds_campo_file_pdf))
                echo 'Arquivo salvo com sucesso.';
            else
                echo $this->upload->display_errors();
        }    
    }

    public function alteraDatas(){
        $this->verifica_sessao();
        $params['chave']=$this->input->post('cd_cidade_avaliacao');
        if($this->input->post('dt_inicial')){
            $params['inicio']=$this->input->post('dt_inicial');
        }
        if($this->input->post('dt_fim')){
            $params['fim']=$this->input->post('dt_fim');
        }        
        $avaliacao=$this->input->post('cd_avaliacao_upload');

        //print_r($params);die;

        if($this->modelavaliacao_upload->alteradatas($params)){            
            $this->editar($avaliacao,"success");
        }else{
            $this->editar($avaliacao,"alteracao_nao_realizada");
        }
        
    }
}
