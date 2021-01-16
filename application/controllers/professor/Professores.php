<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professores extends CI_Controller
{
    protected $titulo = 'Cadastro de Professores';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('estado_model', 'modelestado');
        $this->load->model('municipio_model', 'modelmunicipio');  
        $this->load->model('escolas_model', 'modelescola');      
        $this->load->model('professores_model', 'modelprofessor');
        $this->load->model('turmas_model','modelturma');
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

        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['professores']   = $this->modelprofessor->buscar();
        $dados['titulo']        = $this->titulo;

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

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('professor/professor', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_professor       = $this->input->post('ci_professor');
            $nm_professor       = $this->input->post('nm_professor');            
            $nr_cpf             = $this->input->post('nr_cpf');   
            $dt_nascimento      = $this->input->post('dt_nascimento');           
            $ds_email           = $this->input->post('ds_email');
            $fl_formacao        = $this->input->post('fl_formacao');
            $ds_outra_formacao  = $this->input->post('ds_outra_formacao');
            $cd_cidade          = $this->input->post('cd_cidade');
            $nr_cep             = $this->input->post('nr_cep');
            $ds_rua             = $this->input->post('ds_rua');
            $nr_residencia      = $this->input->post('nr_residencia');
            $ds_bairro          = $this->input->post('ds_bairro');
            $ds_complemento     = $this->input->post('ds_complemento');
            $ds_referencia      = $this->input->post('ds_referencia');

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelprofessor->buscar($ci_professor, 
                                    $nm_professor,
                                    $nr_cpf, 
                                    $dt_nascimento,
                                    $ds_email, 
                                    $fl_formacao,
                                    $ds_outra_formacao,
                                    $cd_cidade,
                                    $nr_cep,
                                    $ds_rua,
                                    $nr_residencia,
                                    $ds_bairro,
                                    $ds_complemento,
                                    $ds_referencia,
                                                            '', $limit, $offset);

            $dados['total_registros'] = $this->modelprofessor->count_buscar($ci_professor, 
                                    $nm_professor,
                                    $nr_cpf, 
                                    $dt_nascimento,
                                    $ds_email, 
                                    $fl_formacao,
                                    $ds_outra_formacao,
                                    $cd_cidade,
                                    $nr_cep,
                                    $ds_rua,
                                    $nr_residencia,
                                    $ds_bairro,
                                    $ds_complemento,
                                    $ds_referencia);

            $config['base_url']    = base_url("professor/professores/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('professor/professor_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_professor       = $this->input->post('ci_professor');
        $nm_professor       = $this->input->post('nm_professor');
        $nr_cpf             = $this->input->post('nr_cpf');
        $dt_nascimento      = $this->input->post('dt_nascimento');
        $ds_email           = $this->input->post('ds_email');
        $fl_formacao        = $this->input->post('fl_formacao');
        $ds_outra_formacao  = $this->input->post('ds_outra_formacao');
        
        $cd_cidade          = $this->input->post('cd_cidade');
        $nr_cep             = $this->input->post('nr_cep');
        $ds_rua             = $this->input->post('ds_rua');
        $nr_residencia      = $this->input->post('nr_residencia');
        $ds_bairro          = $this->input->post('ds_bairro');
        $ds_complemento     = $this->input->post('ds_complemento');
        $ds_referencia      = $this->input->post('ds_referencia');

        $result = $this->modelprofessor->get_consulta_excel($ci_professor,
                                                            $nm_professor,                                                            
                                                            $nr_cpf,
                                                            $dt_nascimento,
                                                            $ds_email,
                                                            $fl_formacao,
                                                            $ds_outra_formacao,
                                                            $cd_cidade,
                                                            $nr_cep,
                                                            $ds_rua,
                                                            $nr_residencia,
                                                            $ds_bairro,
                                                            $ds_complemento,
                                                            $ds_referencia);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_professor       = $this->input->post('ci_professor');
        $nm_professor       = $this->input->post('nm_professor');
        $nr_cpf             = $this->input->post('nr_cpf');
        $dt_nascimento      = $this->input->post('dt_nascimento');
        $ds_email           = $this->input->post('ds_email');
        $fl_formacao        = $this->input->post('fl_formacao');
        $ds_outra_formacao  = $this->input->post('ds_outra_formacao');
        $cd_cidade          = $this->input->post('cd_cidade');
        $nr_cep             = $this->input->post('nr_cep');
        $ds_rua             = $this->input->post('ds_rua');
        $nr_residencia      = $this->input->post('nr_residencia');
        $ds_bairro          = $this->input->post('ds_bairro');
        $ds_complemento     = $this->input->post('ds_complemento');
        $ds_referencia      = $this->input->post('ds_referencia');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelprofessor->get_consulta_pdf(  $ci_professor, 
                                                                        $nm_professor,
                                                                        $nr_cpf, 
                                                                        $dt_nascimento,
                                                                        $ds_email, 
                                                                        $fl_formacao,
                                                                        $ds_outra_formacao,
                                                                        $cd_cidade,
                                                                        $nr_cep,
                                                                        $ds_rua,
                                                                        $nr_residencia,
                                                                        $ds_bairro,
                                                                        $ds_complemento,
                                                                        $ds_referencia, '', '', '');
        $pagina =$this->load->view('professor/professor_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['estado'] = $this->modelestado->selectEstados();
        $dados['professores']   = $this->modelprofessor->buscar();

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('professor/professor_cad',$dados);
        $this->load->view('template/html-footer');
    }

    public function salvar(){
        $this->verifica_sessao();

        $ci_professor       = $this->input->post('ci_professor');
        $nm_professor       = strtoupper ($this->input->post('nm_professor'));
        $cd_estado          = $this->input->post('cd_estado');
        $nr_cpf             = $this->input->post('nr_cpf');   
        $dt_nascimento      = $this->input->post('txt_data');           
        $ds_email           = $this->input->post('ds_email');
        $fl_formacao        = $this->input->post('fl_formacao');
        $ds_outra_formacao  = $this->input->post('ds_outra_formacao');
        $ds_telefone        = $this->input->post('ds_telefone');
        $fl_sexo            = $this->input->post('fl_sexo');
        $cd_cidade          = $this->input->post('cd_cidade');
        $nr_cep             = $this->input->post('nr_cep');
        $ds_rua             = $this->input->post('ds_rua');
        $nr_residencia      = $this->input->post('nr_residencia');
        $ds_bairro          = $this->input->post('ds_bairro');
        $ds_complemento     = $this->input->post('ds_complemento');
        $ds_referencia      = $this->input->post('ds_referencia');
        $nm_formacao_letras = $this->input->post('nm_formacao_letras');

        $data = implode('/',array_reverse(explode('/',$dt_nascimento))); // Converte data para padrão amaericano

        $dt_nascimento = $data;

        $img	        = $this->input->post('img');

        $ds_img         = $_FILES['img']['name'];
        
        if ($ds_img || $ci_professor){
            $nm_img = $this->input->post('ds_img_hidden');
        }
        $ext_img        = $this->extensao_imagem('img');
        

        
        $this->form_validation->set_rules('nm_professor', 'Nome do professor','required|min_length[3]');
        $this->form_validation->set_rules('fl_sexo', 'Sexo','required');
        $this->form_validation->set_rules('cd_cidade', 'Municipio','required');
        $this->form_validation->set_rules('nr_cpf', 'CPF','required');
        $this->form_validation->set_rules('txt_data', 'Data de nascimento','required');
		$this->form_validation->set_rules('ds_email', 'E-mail','required');
        $this->form_validation->set_rules('fl_formacao', 'Formação','required');
		
        if ($this->form_validation->run() == FALSE) {
            if (!$ci_professor) { 
                $this->novo();
            }else{
                $this->editar($ci_professor);
            }
        } else {

            if (!$ci_professor) {
                if ($this->modelprofessor->inserir( $ci_professor, 
                                                    $nm_professor,
                                                    $nr_cpf, 
                                                    $dt_nascimento,
                                                    $ds_email, 
                                                    $fl_formacao,
                                                    $ds_outra_formacao,
                                                    $ds_telefone,
                                                    $fl_sexo,
                                                    $cd_cidade,
                                                    $nr_cep,
                                                    $ds_rua,
                                                    $nr_residencia,
                                                    $ds_bairro,
                                                    $ds_complemento,
                                                    $ds_referencia,
                                                    $nm_formacao_letras)){

                    $ci_professor = $this->modelprofessor->get_id($nr_cpf);

                    $this->persistir_Imagem($ci_professor, $ds_img, $ext_img, '', 'img');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->novo("success");
                }else{
                    $this->novo("registro_ja_existente");
                }
            }
            else {    

                if ($ds_img){
                    $nm_img = md5($ci_professor).'.'.$ext_img; //nome do aquivo = id + extensão
                }                
                
                if ($this->modelprofessor->alterar( $ci_professor, 
                                                    $nm_professor,
                                                    $nr_cpf, 
                                                    $dt_nascimento,
                                                    $ds_email, 
                                                    $fl_formacao,
                                                    $ds_outra_formacao,
                                                    $nm_img,
                                                    $ds_telefone,
                                                    $fl_sexo,
                                                    $cd_cidade,
                                                    $nr_cep,
                                                    $ds_rua,
                                                    $nr_residencia,
                                                    $ds_bairro,
                                                    $ds_complemento,
                                                    $ds_referencia,
                                                    $nm_formacao_letras)){

                    $this->upload_img($nm_img, 'img', $ext_img);
                    $this->editar($ci_professor, $cd_estado, "success");
                }else{
                    $this->editar($ci_professor, $cd_estado, "registro_ja_existente");
                }

            }
        }

    }

    public function editar($id = null, $estado = null, $msg = null){
        $this->verifica_sessao();

        $dados['estados'] = $this->modelestado->get_estados();
        $dados['municipios']  = $this->modelmunicipio->get_municipios($estado);

        $dados['professores']   = $this->modelprofessor->buscar();
        
        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $dados['registros']   = $this->modelprofessor->buscar($id);
        
        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('professor/professor_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelprofessor->excluir($id);
            $this->listagem_consulta();
            //$this->index("success");
        }else{
            echo $status_sessao;
        }
    }
    // Recebe o nome do campo file do form contendo o arquivo e devolve a extensão do arquivo
    public function extensao_imagem($nm_campo_img){

        $path   = $_FILES[$nm_campo_img]['name'];     // Extrai o nome completo do arquivo enviado
        return  pathinfo($path, PATHINFO_EXTENSION);  // Extraindo a extensão do arquivo
        
    }

    public function persistir_Imagem($id, $campo_post, $extensao, $complemento_nome, $nm_campo){

        if ($campo_post){
            $nm_img = md5($id).$complemento_nome.'.'.$extensao; //nome do aquivo = id + complemento + extensão

            $this->modelprofessor->grava_img_db($id, $nm_campo, $nm_img);  
            $this->upload_img($nm_img, $nm_campo, $extensao);
        }
    }

    public function upload_img($nm_img, $ds_campo_file_img, $ext)
    {
        if(!$this->session->userdata('logado')){
            redirect(base_url('login'));
        }
        // $nm_img = mb_strtoupper($nm_img, 'UTF-8');
       $ext = mb_strtoupper($ext, 'UTF-8');
 
        // echo '<br/><br/><br/><p>';
        // echo '</p>';

        // echo '<br/><br/><br/><p>';
        // echo ' <br/>$nm_img  ='.$nm_img;
        // echo ' <br/>$ds_campo_file_img  ='.$ds_campo_file_img;
        // echo '<br/> $ext  ='.$ext;
        // echo '</p>';

        if (($ext == 'JPG') || ($ext == 'JPEG') || ($ext == 'PNG') || ($ext == 'GIF')){   

            $config['upload_path'] = './assets/img/professores';
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
