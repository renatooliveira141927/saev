<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avalia_itens extends CI_Controller
{
    protected $titulo = 'Elaboração de questões';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('avalia_item_model'       , 'modelavalia_item');
        $this->load->model('avalia_dificuldade_model', 'modelavalia_dificuldade');
        $this->load->model('etapas_model'            , 'modeletapa');
        $this->load->model('disciplina_model'        , 'modeldisciplina');
        $this->load->model('avalia_conteudo_model'   , 'modelavalia_conteudo');
        $this->load->model('avalia_subconteudo_model', 'modelavalia_subconteudo');
        $this->load->model('avalia_origem_model'     , 'modelavalia_origem');
        $this->load->model('edicao_model'            , 'modeledicao');
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

        $dados['avalia_dificuldades']   = $this->modelavalia_dificuldade->buscar();
        $dados['etapas']                = $this->modeletapa->buscar();
        $dados['disciplinas']           = $this->modeldisciplina->buscar();
        $dados['avalia_conteudos']      = $this->modelavalia_conteudo->buscar();
        $dados['avalia_subconteudos']   = $this->modelavalia_subconteudo->buscar();
        $dados['avalia_origens']        = $this->modelavalia_origem->buscar();
        $dados['edicoes']               = $this->modeledicao->buscar();

        $dados['titulo'] = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_item/avalia_item', $dados);
        $this->load->view('template/html-footer');
    }
    public function popula_modal_veritem(){
        $id         = $this->input->post('id');
        $dados['registros'] = $this->modelavalia_item->get_consulta_pdf($id);
        $this->load->view('avaliacao/modal_veritem', $dados);
    }


    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_avalia_item         = $this->input->post('ci_avalia_item');
            $ds_codigo              = $this->input->post('ds_codigo');
            $cd_dificuldade         = $this->input->post('cd_dificuldade');
            $cd_etapa		        = $this->input->post('cd_etapa');
            $cd_disciplina          = $this->input->post('cd_disciplina');
            $cd_avalia_conteudo     = $this->input->post('cd_avalia_conteudo');
            $cd_avalia_subconteudo  = $this->input->post('cd_avalia_subconteudo');
            $cd_avalia_origem       = $this->input->post('cd_avalia_origem');
            $cd_edicao              = $this->input->post('cd_edicao');
            $ds_titulo              = $this->input->post('ds_titulo');
            $origem_acesso          = $this->input->post('origem_acesso');

            $dados['titulo']        = $this->titulo;
            $dados['origem_acesso'] = $origem_acesso;

            $limit = '10';
            $dados['registros'] = $this->modelavalia_item->buscar(  $ci_avalia_item, 
                                                                    $ds_codigo,
                                                                    $cd_dificuldade, 
                                                                    $cd_etapa, 
                                                                    $cd_disciplina, 
                                                                    $cd_avalia_conteudo, 
                                                                    $cd_edicao, 
                                                                    $ds_titulo, 
                                                                    '', $limit, $offset);

            $dados['total_registros'] = $this->modelavalia_item->count_buscar(  $ci_avalia_item, 
                                                                                $ds_codigo,                                                                    
                                                                                $cd_dificuldade, 
                                                                                $cd_etapa, 
                                                                                $cd_disciplina, 
                                                                                $cd_avalia_conteudo, 
                                                                                $cd_edicao, 
                                                                                $ds_titulo);

            $config['base_url']    = base_url("avalia_item/avalia_itens/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('avalia_item/avalia_item_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_avalia_item         = $this->input->post('ci_avalia_item');
        $ds_codigo              = $this->input->post('ds_codigo');
        $cd_dificuldade         = $this->input->post('cd_dificuldade');
        $cd_etapa		        = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_conteudo     = $this->input->post('cd_avalia_conteudo');
        $cd_edicao              = $this->input->post('cd_edicao');
        $ds_titulo              = $this->input->post('ds_titulo');


        $result = $this->modelavalia_item->get_consulta_excel(   $ci_avalia_item,
                                                                    $ds_codigo,
                                                                    $cd_dificuldade,
                                                                    $cd_etapa, 
                                                                    $cd_disciplina, 
                                                                    $cd_avalia_conteudo, 
                                                                    $cd_edicao,
                                                                    $ds_titulo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();

        $ci_avalia_item         = $this->input->post('ci_avalia_item');
        $ds_codigo              = $this->input->post('ds_codigo');
        $cd_dificuldade         = $this->input->post('cd_dificuldade');
        $cd_etapa		        = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_conteudo     = $this->input->post('cd_avalia_conteudo');
        $cd_avalia_subconteudo  = $this->input->post('cd_avalia_subconteudo');
        $cd_avalia_origem       = $this->input->post('cd_avalia_origem');
        $cd_edicao              = $this->input->post('cd_edicao');
        $ds_titulo              = $this->input->post('ds_titulo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelavalia_item->get_consulta_pdf(    $ci_avalia_item,
                                                                            $ds_codigo, 
                                                                            $cd_dificuldade, 
                                                                            $cd_etapa, 
                                                                            $cd_disciplina, 
                                                                            $cd_avalia_conteudo, 
                                                                            $cd_edicao, 
                                                                            $ds_titulo, '', '', '');
        $pagina =$this->load->view('avalia_item/avalia_item_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['avalia_dificuldades']   = $this->modelavalia_dificuldade->buscar();
        $dados['etapas']                = $this->modeletapa->buscar();
        $dados['disciplinas']           = $this->modeldisciplina->buscar();
        $dados['avalia_conteudos']      = $this->modelavalia_conteudo->buscar();
        $dados['avalia_subconteudos']   = $this->modelavalia_subconteudo->buscar();
        $dados['avalia_origens']        = $this->modelavalia_origem->buscar();
        $dados['edicoes']               = $this->modeledicao->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_item/avalia_item_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_avalia_item         = $this->input->post('ci_avalia_item');
        $ds_codigo              = $this->input->post('ds_codigo');
        $cd_dificuldade         = $this->input->post('cd_dificuldade');
        $cd_etapa		        = $this->input->post('cd_etapa');
        $cd_disciplina          = $this->input->post('cd_disciplina');
        $cd_avalia_conteudo     = $this->input->post('cd_avalia_conteudo');
        $cd_avalia_subconteudo  = $this->input->post('cd_avalia_subconteudo');
        $cd_avalia_origem       = $this->input->post('cd_avalia_origem');
        $cd_edicao              = $this->input->post('cd_edicao');
        $ds_titulo              = $this->input->post('ds_titulo');
        $ds_enunciado           = $this->input->post('ds_enunciado');        
        $ds_texto_suporte       = $this->input->post('ds_texto_suporte');
        $ds_fonte_texto         = $this->input->post('ds_fonte_texto');
        $tp_questao             = $this->input->post('fl_tipo_itens'); // Se a alternativa é imagem ou texto
        $ds_comando             = $this->input->post('ds_comando');
        $ds_img_suporte         = $_FILES['ds_img_suporte']['name']; // Pega o nome do arquivo enviado
        $ds_fonte_imagem        = $this->input->post('ds_fonte_imagem');
        $nm_img_suporte         = ""; //Receberá o nome da imagem e a extensão para persistir no banco 
        if ($ds_img_suporte || $ci_avalia_item){
            $nm_img_suporte = $this->input->post('ds_img_suporte_hidden');
        }
        $nr_alternativa_correta = $this->input->post('nr_alternativa_correta');
        $ds_justificativa_01    = $this->input->post('ds_justificativa_01');
        $ds_justificativa_02    = $this->input->post('ds_justificativa_02');
        $ds_justificativa_03    = $this->input->post('ds_justificativa_03');
        $ds_justificativa_04    = $this->input->post('ds_justificativa_04');
        $ext_suporte            = $this->extensao_imagem('ds_img_suporte'); // Pega extensão da imagem
        $fl_tipo_itens          = $this->input->post('fl_tipo_itens');
        $ds_img_item_01         = "";
        $ds_img_item_02         = "";
        $ds_img_item_03         = "";
        $ds_img_item_04         = "";
        $nm_img_item_01         = ""; //Receberá o nome da imagem e a extensão para persistir no banco
        $nm_img_item_02         = ""; //Receberá o nome da imagem e a extensão para persistir no banco
        $nm_img_item_03         = ""; //Receberá o nome da imagem e a extensão para persistir no banco
        $nm_img_item_04         = ""; //Receberá o nome da imagem e a extensão para persistir no banco
        $ext_img_item_01        = "";
        $ext_img_item_02        = "";
        $ext_img_item_03        = "";
        $ext_img_item_04        = "";
        $ds_primeiro_item       = "";
        $ds_segundo_item        = "";
        $ds_terceiro_item       = "";
        $ds_quarto_item         = "";
        if ($fl_tipo_itens =="I"){
            
            $ds_img_item_01         = $_FILES['ds_img_item_01']['name'];
            $ds_img_item_02         = $_FILES['ds_img_item_02']['name'];
            $ds_img_item_03         = $_FILES['ds_img_item_03']['name'];
            $ds_img_item_04         = $_FILES['ds_img_item_04']['name'];
            if ($ds_img_item_01 || $ci_avalia_item){
                $nm_img_item_01 = $this->input->post('ds_img_item_01_hidden');
            }
            if ($ds_img_item_02 || $ci_avalia_item){
                $nm_img_item_02 = $this->input->post('ds_img_item_02_hidden');
            }
            if ($ds_img_item_03 || $ci_avalia_item){
                $nm_img_item_03 = $this->input->post('ds_img_item_03_hidden');
            }
            if ($ds_img_item_04 || $ci_avalia_item){
                $nm_img_item_04 = $this->input->post('ds_img_item_04_hidden');
            }                        
            $ext_img_item_01        = $this->extensao_imagem('ds_img_item_01');
            $ext_img_item_02        = $this->extensao_imagem('ds_img_item_02');
            $ext_img_item_03        = $this->extensao_imagem('ds_img_item_03');
            $ext_img_item_04        = $this->extensao_imagem('ds_img_item_04');

        }else{
            $ds_primeiro_item       = $this->input->post('ds_primeiro_item');
            $ds_segundo_item        = $this->input->post('ds_segundo_item');
            $ds_terceiro_item       = $this->input->post('ds_terceiro_item');
            $ds_quarto_item         = $this->input->post('ds_quarto_item');
            $this->form_validation->set_rules('ds_primeiro_item'    , 'primeira alternativa','min_length[3]|required');
            $this->form_validation->set_rules('ds_segundo_item'     , 'segunda alternativa' ,'min_length[3]|required');
            $this->form_validation->set_rules('ds_terceiro_item'    , 'terceira alternativa','min_length[3]|required');
            $this->form_validation->set_rules('ds_quarto_item'      , 'quarta alternativa'  ,'min_length[3]|required');
        }

        $this->form_validation->set_rules('cd_dificuldade' , 'dificuldade'         ,'required');
        $this->form_validation->set_rules('cd_etapa'            , 'etapa'               ,'required');
        $this->form_validation->set_rules('cd_disciplina'       , 'disciplina'          ,'required');
        $this->form_validation->set_rules('cd_avalia_conteudo'  , 'avalia_conteudo'     ,'required');
        $this->form_validation->set_rules('cd_avalia_subconteudo', 'avalia_subconteudo' ,'required');
        $this->form_validation->set_rules('cd_edicao'           , 'edicao'              ,'required');
        //$this->form_validation->set_rules('tp_questao'          , 'tipo de questao'     ,'required');
        $this->form_validation->set_rules('ds_titulo'           , 'titulo'              ,'min_length[3]|required');
        $this->form_validation->set_rules('ds_enunciado'        , 'enunciado'           ,'min_length[3]|required');


        if ($this->form_validation->run() == FALSE) {
            $this->novo();
        } else {

            if (!$ci_avalia_item) {
                if ($this->modelavalia_item->inserir(   $ci_avalia_item,
                                                        $ds_codigo,
                                                        $cd_dificuldade,
                                                        $cd_etapa,
                                                        $cd_disciplina,
                                                        $cd_avalia_conteudo,
                                                        $cd_avalia_subconteudo,
                                                        $cd_avalia_origem,
                                                        $cd_edicao,
                                                        $ds_titulo,
                                                        $ds_enunciado,
                                                        $tp_questao,
                                                        $ds_comando,
                                                        $ds_primeiro_item,
                                                        $ds_segundo_item,
                                                        $ds_terceiro_item,
                                                        $ds_quarto_item,
                                                        $ds_img_suporte,
                                                        $ds_fonte_imagem,
                                                        $nr_alternativa_correta,
                                                        $ds_justificativa_01,
                                                        $ds_justificativa_02,
                                                        $ds_justificativa_03,
                                                        $ds_justificativa_04,
                                                        $fl_tipo_itens,
                                                        $ds_img_item_01,
                                                        $ds_img_item_02,
                                                        $ds_img_item_03,
                                                        $ds_img_item_04,
                                                        $ds_texto_suporte,
                                                        $ds_fonte_texto)){

                    $ci_avalia_item     = $this->modelavalia_item->get_id( $cd_dificuldade, 
                                                                $ds_codigo, 
                                                                $cd_etapa, 
                                                                $cd_disciplina, 
                                                                $cd_avalia_conteudo, 
                                                                $cd_edicao, 
                                                                $ds_titulo);


                    $this->persistir_Imagem($ci_avalia_item, $ds_img_suporte, $ext_suporte, '_suporte', 'ds_img_suporte');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->persistir_Imagem($ci_avalia_item, $ds_img_item_01, $ext_img_item_01, '_img_item_01', 'ds_img_item_01');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->persistir_Imagem($ci_avalia_item, $ds_img_item_02, $ext_img_item_02, '_img_item_02', 'ds_img_item_02');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->persistir_Imagem($ci_avalia_item, $ds_img_item_03, $ext_img_item_03, '_img_item_03', 'ds_img_item_03');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->persistir_Imagem($ci_avalia_item, $ds_img_item_04, $ext_img_item_04, '_img_item_04', 'ds_img_item_04');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)

                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {
                if ($ds_img_suporte){
                    $nm_img_suporte     =   $ci_avalia_item.'_suporte.'.$ext_suporte; //nome do aquivo = id + extensão
                }
                if ($ds_img_item_01){
                    $nm_img_item_01     =   $ci_avalia_item.'_img_item_01.'.$ext_img_item_01; //nome do aquivo = id + extensão
                }
                if ($ds_img_item_02){
                    $nm_img_item_02     =   $ci_avalia_item.'_img_item_02.'.$ext_img_item_02; //nome do aquivo = id + extensão
                }
                if ($ds_img_item_03){
                    $nm_img_item_03     =   $ci_avalia_item.'_img_item_03.'.$ext_img_item_03; //nome do aquivo = id + extensão
                }
                if ($ds_img_item_04){
                    $nm_img_item_04     =   $ci_avalia_item.'_img_item_04.'.$ext_img_item_04; //nome do aquivo = id + extensão
                }
                
                if ($this->modelavalia_item->alterar(   $ci_avalia_item,
                                                        $ds_codigo,
                                                        $cd_dificuldade,
                                                        $cd_etapa,
                                                        $cd_disciplina,
                                                        $cd_avalia_conteudo,
                                                        $cd_avalia_subconteudo,
                                                        $cd_avalia_origem,
                                                        $cd_edicao,
                                                        $ds_titulo,
                                                        $ds_enunciado,
                                                        $tp_questao,
                                                        $ds_comando,
                                                        $ds_primeiro_item,
                                                        $ds_segundo_item,
                                                        $ds_terceiro_item,
                                                        $ds_quarto_item,
                                                        $nm_img_suporte,
                                                        $ds_fonte_imagem,
                                                        $nr_alternativa_correta,
                                                        $ds_justificativa_01,
                                                        $ds_justificativa_02,
                                                        $ds_justificativa_03,
                                                        $ds_justificativa_04,
                                                        $fl_tipo_itens,
                                                        $nm_img_item_01,
                                                        $nm_img_item_02,
                                                        $nm_img_item_03,
                                                        $nm_img_item_04,
                                                        $ds_texto_suporte,
                                                        $ds_fonte_texto)){

                    $this->upload_img($nm_img_suporte, 'ds_img_suporte', $ext_suporte);
                    $this->upload_img($nm_img_item_01, 'ds_img_item_01', $ext_img_item_01);
                    $this->upload_img($nm_img_item_02, 'ds_img_item_02', $ext_img_item_02);
                    $this->upload_img($nm_img_item_03, 'ds_img_item_03', $ext_img_item_03);
                    $this->upload_img($nm_img_item_04, 'ds_img_item_04', $ext_img_item_04);
     
                    $this->editar($ci_avalia_item, "success");
                }else{
                    $this->editar($ci_avalia_item,"registro_ja_existente");
                }

            }
        }

    }

    // Recebe o nome do campo file do form contendo o arquivo e devolve a extensão do arquivo
    public function extensao_imagem($nm_campo_img){

        $path   = $_FILES[$nm_campo_img]['name'];     // Extrai o nome completo do arquivo enviado
        return  pathinfo($path, PATHINFO_EXTENSION);  // Extraindo a extensão do arquivo
        
    }

    public function persistir_Imagem($id, $campo_post, $extensao, $complemento_nome, $nm_campo){

        if ($campo_post){
            $nm_img     =   $id.$complemento_nome.'.'.$extensao; //nome do aquivo = id + complemento + extensão

            $this->modelavalia_item->grava_img_db($id, $nm_campo, $nm_img);  
            $this->upload_img($nm_img, $nm_campo, $extensao);
        }
    }

    public function editar($id = null, $msg = null){
        $this->verifica_sessao();
        
        $dados['avalia_dificuldades']   = $this->modelavalia_dificuldade->buscar();
        $dados['etapas']                = $this->modeletapa->buscar();
        $dados['disciplinas']           = $this->modeldisciplina->buscar();
        $dados['avalia_conteudos']      = $this->modelavalia_conteudo->buscar();
        $dados['avalia_subconteudos']   = $this->modelavalia_subconteudo->buscar();
        $dados['avalia_origens']        = $this->modelavalia_origem->buscar();
        $dados['edicoes']               = $this->modeledicao->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelavalia_item->buscar($id);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('avalia_item/avalia_item_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelavalia_item->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    public function upload_img($nm_img, $ds_campo_file_img, $ext)
    {
        if(!$this->session->userdata('logado')){
            redirect(base_url('login'));
        }
        $nm_img = mb_strtoupper($nm_img, 'UTF-8');
        $ext = mb_strtoupper($ext, 'UTF-8');
 /* 
        echo '<br/><br/><br/><p>';
        echo '</p>';

        echo '<br/><br/><br/><p>';
        echo ' $nm_img  ='.$nm_img;
        echo ' $ds_campo_file_img  ='.$ds_campo_file_img;
        echo ' $ext  ='.$ext;
        echo '</p>';
*/
        if (($ext == 'JPG') || ($ext == 'JPEG') || ($ext == 'PNG') || ($ext == 'GIF')){   

            $config['upload_path'] = './assets/img/avalia_itens';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $nm_img;
            $config['overwrite'] = TRUE;
            $config['max_size'] = '10240';//5mb

            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($ds_campo_file_img))
                echo 'Arquivo salvo com sucesso.';
            else
                echo $this->upload->display_errors();
        }    
    }
    
}
