<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    protected $titulo = 'Cadastro de Usuários';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('usuario_model', 'modelusuario');
        $this->load->model('grupo_model'  , 'modelgrupo');
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

        $dados['grupos']        = $this->modelgrupo->buscar();
        $dados['titulo']        = $this->titulo;

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('usuario/usuario', $dados);
        $this->load->view('template/html-footer');
    }

    public function listagem_consulta($offset=null){
        
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $this->load->library('pagination');

            $ci_usuario = $this->input->post('ci_usuario');
            $nm_usuario = $this->input->post('nm_usuario');
            $nm_login   = $this->input->post('nm_login');            
            $nr_cpf     = $this->input->post('nr_cpf');
            if ($this->session->userdata('ci_grupousuario') == 1){ // Se o usuário for administrador
                $cd_grupo   = $this->input->post('cd_grupo');
            }else{
                $cd_grupo   = 3;
            }

            $cd_estado_sme   = '';
            $cd_cidade_sme   = '';

            if ($this->session->userdata('ci_grupousuario') != 1){
                $cd_estado_sme   = $this->session->userdata('cd_estado_sme');
                $cd_cidade_sme   = $this->session->userdata('cd_cidade_sme');
            }

            $dados['titulo'] = $this->titulo;

            $limit = '10';
            $dados['registros'] = $this->modelusuario->buscar(  $ci_usuario, 
                                                                $nm_usuario, 
                                                                $nm_login, 
                                                                $nr_cpf, 
                                                                $cd_grupo,
                                                                $cd_estado_sme,
                                                                $cd_cidade_sme,
                                                                '', $limit, $offset);

            $dados['total_registros'] = $this->modelusuario->count_buscar(  $ci_usuario, 
                                                                            $nm_usuario, 
                                                                            $nm_login, 
                                                                            $nr_cpf, 
                                                                            $cd_grupo,
                                                                            $cd_estado_sme,
                                                                            $cd_cidade_sme);

            $config['base_url']    = base_url("usuario/Usuarios/listagem_consulta");
            $config['total_rows']  = $dados['total_registros'];
            $config['per_page']    = $limit;
            $config['uri_segment'] = '3';
            $config['cur_page'] = $offset;
            $this->pagination->initialize($config);
            $dados['links_paginacao']     = $this->pagination->create_links();

            $this->load->view('usuario/usuario_lista', $dados);
        }else{
            echo $status_sessao;
        }
    }

    public function gerar_excel(){

        $this->verifica_sessao();

        $this->load->library('export_excel');
        $ci_usuario = $this->input->post('ci_usuario');
        $nm_usuario = $this->input->post('nm_usuario');  
        $nm_login   = $this->input->post('nm_login');
        $nr_cpf     = $this->input->post('nr_cpf');
        $cd_grupo   = $this->input->post('cd_grupo');

        $result = $this->modelusuario->get_consulta_excel(  $ci_usuario, 
                                                            $nm_usuario, 
                                                            $nm_login, 
                                                            $nr_cpf, 
                                                            $cd_grupo);
        $this->export_excel->to_excel($result, $this->titulo);
    }
    public function gerar_pdf(){
        $this->verifica_sessao();
        $ci_usuario = $this->input->post('ci_usuario');
        $nm_usuario = $this->input->post('nm_usuario');  
        $nm_login   = $this->input->post('nm_login');
        $nr_cpf     = $this->input->post('nr_cpf');
        $cd_grupo   = $this->input->post('cd_grupo');

        $dados['titulo'] = $this->titulo;

        $dados['registros'] = $this->modelusuario->get_consulta_pdf($ci_usuario, 
                                                                    $nm_usuario, 
                                                                    $nm_login, 
                                                                    $nr_cpf, 
                                                                    $cd_grupo, '', '', '');
        $pagina =$this->load->view('usuario/usuario_pdf', $dados, true);

        $this->load->library('pdf');

        $filename = 'report_'.time();
        $this->pdf->generate($pagina, $filename, true, 'A4', 'portrait');
    }


    public function salvar(){
        $this->verifica_sessao();

        $ci_usuario     = $this->input->post('ci_usuario');
        $nm_usuario     = $this->input->post('nm_usuario');  
        $nm_login       = $this->input->post('nm_login');
        $nr_cpf         = $this->input->post('nr_cpf');

        if ($this->session->userdata('ci_grupousuario') == 1){
            $cd_grupo       = $this->input->post('cd_grupo');
        }else{
            $cd_grupo       = '3';
        }
        
        $fl_sexo        = $this->input->post('rd_fl_sexo');
        $ds_telefone    = $this->input->post('ds_telefone');
        $ds_email       = $this->input->post('ds_email');

        $nr_cep        = $this->input->post('nr_cep');
        $cd_estado     = $this->input->post('cd_estado');
        $cd_cidade     = $this->input->post('cd_cidade');
        $ds_rua        = $this->input->post('ds_rua');
        $nr_residencia = $this->input->post('nr_residencia');
        $ds_bairro     = $this->input->post('ds_bairro');
        $ds_complemento= $this->input->post('ds_complemento');
        $ds_referencia = $this->input->post('ds_referencia');

        $cd_estado_sme = $this->input->post('cd_estado_sme');
        $cd_cidade_sme = $this->input->post('cd_cidade_sme'); 

        $rd_reenviar_email = $this->input->post('rd_reenviar_email'); 

        $cd_escolas_selecionadas = $this->input->post('cd_escolas_selecionadas');
        
        $img	        = $this->input->post('img');

        $ds_img         = $_FILES['img']['name'];
        
        if ($ds_img || $ci_usuario){
            $nm_img = $this->input->post('ds_img_hidden');
        }
        $ext_img        = $this->extensao_imagem('img');

        if (($this->session->userdata('ci_grupousuario') == 1) && ($cd_grupo == 3))
        {
            $cd_estado_sme = $this->input->post('cd_estado_menu_esc');
            $cd_cidade_sme = $this->input->post('cd_cidade_menu_esc'); 
        }
        

		$this->form_validation->set_rules('nm_usuario', 'Nome do  Usuário','required|min_length[3]');
		$this->form_validation->set_rules('ds_email', 'Email','required|valid_email');
		$this->form_validation->set_rules('nr_cpf', 'CPF','required|valid_cpf');
        $this->form_validation->set_rules('ds_telefone', 'Telefone','required|valid_phone');
        $this->form_validation->set_rules('nm_login', 'User','required|min_length[3]');
        $this->form_validation->set_rules('cd_grupo', 'Grupo','required');
        if ($cd_grupo == 2){
            $this->form_validation->set_rules('cd_estado_sme', 'Estado da SME','required');
            $this->form_validation->set_rules('cd_cidade_sme', 'Município da SME','required');
        }
		
        if ($this->form_validation->run() == FALSE) {
            if (!$ci_usuario) { 
                $this->novo();
            }else{
                $this->editar($ci_usuario);
            }
        } else {

            if (!$ci_usuario) {
                if ($this->modelusuario->inserir(   $nm_usuario,
                                                    $nm_login,
                                                    $nr_cpf,
                                                    $cd_grupo,
                                                    $fl_sexo,
                                                    $ds_telefone,
                                                    $ds_email,
                                                    $nr_cep,
                                                    $cd_estado,
                                                    $cd_cidade,
                                                    $ds_rua,
                                                    $nr_residencia,
                                                    $ds_bairro,
                                                    $ds_complemento,
                                                    $ds_referencia,
                                                    $cd_estado_sme,
                                                    $cd_cidade_sme,
                                                    $cd_escolas_selecionadas)){

                    $ci_usuario = $this->modelusuario->get_id($nr_cpf);

                    $this->persistir_Imagem($ci_usuario, $ds_img, $ext_img, '', 'img');// Formato ($id, $campo_post, $extensao, $complemento_nome, $nm_campo)
                    $this->EnviarEmail($ci_usuario, $nm_usuario, $ds_email);
                    $this->novo("success");
                }else{                    
                    $this->novo("registro_ja_existente");
                }
            }
            else {    

                if ($ds_img){
                    $nm_img = md5($ci_usuario).'.'.$ext_img; //nome do aquivo = id + extensão
                }                
                
                if ($this->modelusuario->alterar(   $ci_usuario,
                                                    $nm_usuario,
                                                    $nm_login,
                                                    $nr_cpf,
                                                    $cd_grupo,
                                                    $fl_sexo,
                                                    $nm_img,
                                                    $ds_telefone,
                                                    $ds_email,
                                                    $nr_cep,
                                                    $cd_estado,
                                                    $cd_cidade,
                                                    $ds_rua,
                                                    $nr_residencia,
                                                    $ds_bairro,
                                                    $ds_complemento,
                                                    $ds_referencia, 
                                                    $cd_estado_sme,
                                                    $cd_cidade_sme,
                                                    $cd_escolas_selecionadas)){

                    $this->upload_img($nm_img, 'img', $ext_img);
                    if ($rd_reenviar_email == 'S'){
                        $this->EnviarEmail($ci_usuario, $nm_usuario, $ds_email);
                    }
                    
                    $this->editar($ci_usuario, "success");
                }else{
                    $this->editar($ci_usuario,"registro_ja_existente");
                }

            }
        }

    }

    public function novo($msg = null){
        $this->verifica_sessao();

        $dados['grupos']    = $this->modelgrupo->buscar();
        $dados['estado']    = $this->modelestado->selectEstados();

        if ($this->session->userdata('ci_grupousuario') != 1){
            $cd_cidade_sme = '';
            $cd_estado_sme = '';

            $cd_cidade_sme = $this->session->userdata('cd_cidade_sme');
            $cd_estado_sme = $this->session->userdata('cd_estado_sme');

            $dados['escolas_municipio'] = $this->modelusuario->buscar_escolas('', $cd_cidade_sme, $cd_estado_sme);
        }

        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('usuario/usuario_cad',$dados);
        $this->load->view('template/html-footer');
    }
    public function editar($id = null, $msg = null){
        $this->verifica_sessao();
        
        $dados['grupos']    = $this->modelgrupo->buscar();

        $dados['usuarioescolas']   = $this->modelusuario->buscar_escolas($id, '', '', 'selecionadas');
        $dados['registros']        = $this->modelusuario->buscar($id);
        $cd_estado = '';
        $cd_cidade = '';
        $cd_estado_sme = '';
        $cd_cidade_sme = '';
        foreach ($dados['registros'] as $dado){
            $cd_estado = $dado->cd_estado;
            $cd_cidade = $dado->cd_cidade;

            $cd_estado_sme = $dado->cd_estado_sme?$dado->cd_estado_sme:$cd_estado;            
            $cd_cidade_sme = $dado->cd_cidade_sme?$dado->cd_cidade_sme:$cd_cidade;
            
        }
        $dados['estado']        = $this->modelestado->selectEstados($cd_estado);
        if ($cd_estado){
            $dados['municipios']    = $this->modelcidade->selectCidade($cd_estado, '', '', '', $cd_cidade);
        }
        if ($cd_estado_sme){
            $dados['estados_sme']       = $this->modelestado->selectEstados($cd_estado_sme);
            $dados['municipios_sme']    = $this->modelcidade->selectCidade($cd_estado_sme, '', '', '', $cd_cidade_sme);
        }
        if ($this->session->userdata('ci_grupousuario') == 1){


            $dados['escolas_municipio'] = $this->modelusuario->buscar_escolas($id, $cd_cidade_sme, $cd_estado_sme);

        }else{
            $cd_cidade_sme = $this->session->userdata('cd_cidade_sme');
            $cd_estado_sme = $this->session->userdata('cd_estado_sme');

            $dados['escolas_municipio'] = $this->modelusuario->buscar_escolas($id, $cd_cidade_sme, $cd_estado_sme);
        }


        $dados['titulo'] = $this->titulo;
        $dados['msg'] = $msg;
        if ($msg != null) {
            $dados['msg'] = $msg;
        }

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/mensagens');
        $this->load->view('usuario/usuario_alt', $dados);
        $this->load->view('template/html-footer');
    }

    public function excluir(){
        $status_sessao = $this->verifica_sessao('rotina_ajax');
        
        if ($status_sessao!='sessaooff') {
            $id    = $this->input->post('id');
            $this->modelusuario->excluir($id);
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

            $this->modelusuario->grava_img_db($id, $nm_campo, $nm_img);  
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

            $config['upload_path'] = './assets/img/usuarios';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $nm_img;
            $config['overwrite'] = TRUE;
            $config['max_size'] = '10240';//5mb

            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload($ds_campo_file_img))
                echo 'Arquivo salvo com sucesso.';
            else
                echo '<br/><br/>'.$this->upload->display_errors();
        }    
    }
    public function EnviarEmail($ci_usuario, $nm_usuario, $ds_email)
    {
        $dados['ci_usuario'] = $ci_usuario;
        $dados['nm_usuario'] = $nm_usuario;
        $dados['ds_email']   = $ds_email;
        $dados['mensagem']   = 'Clique no botão abaixo para confimar o seu cadastro.';
        
        $this->load->library('email');
        
        $this->email->from('naoresponda@saev.educacao.ws','Sistema SAEV'); // Remetente        
        $this->email->to($dados['ds_email'],$dados['nm_usuario']); // Destinatário
 
        $this->email->subject('Por favor confirme seu cadastro - SAEV');
 
        $this->email->message($this->load->view('usuario/email',$dados, TRUE));

        $this->email->attach(base_url('assets/images/indice.jpg'));
 
        /*
         * Se o envio foi feito com sucesso, define a mensagem de sucesso
         * caso contrário define a mensagem de erro, e carrega a view home
         */
        if($this->email->send())
        {
            $this->session->set_flashdata('success','Email enviado com sucesso!');
        }
        else
        {
            $this->session->set_flashdata('error',$this->email->print_debugger());
            //echo '<br><br><br><br><br><br><br><br>';
            //echo $this->email->print_debugger();
            //$this->load->view('home');
        }
    }
}
