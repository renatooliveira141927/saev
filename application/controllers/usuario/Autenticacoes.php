<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacoes extends CI_Controller {

    /*
     * 2	SME
     * 1	ADMINSTRADOR
     * 3	ESCOLA
     */
    
	public function __construct(){
        parent::__construct();
        $this->clear_cache();
        $this->load->model('autenticacoes_model','modelautenticacao');
 
	}
    function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
	public function pag_login()
	{

		$dados['titulo'] = 'Peinel de Controle';
		$dados['subtitulo'] = 'Entrar no sistema';

        $this->load->view('login', $dados);
    }
    public function telacadastrosenha($id)	{

        $this->session->sess_destroy();
        $dados['dados'] = $id;
        $this->load->view('usuario/cadastrarsenha', $dados);
    }
    public function telaalterarsenha($id = null)	{

        $this->session->sess_destroy();
        $dados['dados'] = $id;
        $this->load->view('usuario/alterarsenha', $dados);
    }

    
	public function logout()	{
        $this->session->sess_destroy();

		redirect(base_url('usuario/autenticacoes/login'));
    }
    
	public function login()	{
       
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txt-user','Usuário','required|min_length[3]');
		$this->form_validation->set_rules('txt-senha','Senha','required|min_length[3]');

		if ($this->form_validation->run() == FALSE){
			$this->pag_login();
		}
		else{

            $usuario = $this->input->post('txt-user');
            $senha   = $this->input->post('txt-senha');

			$dados['usuariologado'] = $this->modelautenticacao->login($usuario, $senha);


            if(count($dados)==1){
                
                foreach ($dados['usuariologado'] as $usuario) {

                    $primeironome = explode(" ", $usuario->nm_usuario);

                    $dadosSessao['ci_usuario']      = $usuario->ci_usuario;
                    $dadosSessao['nm_usuario']      = $usuario->nm_usuario;
                    $dadosSessao['fl_sexo']         = $usuario->fl_sexo;
                    
                    $dadosSessao['img']             = $usuario->img;
                    $dadosSessao['primeironome']    = $primeironome[0];
                    $dadosSessao['cd_grupo']        = $usuario->cd_grupo;
                    $dadosSessao['cd_cidade_sme']   = $usuario->cd_cidade_sme;
                    $dadosSessao['cd_estado_sme']   = $usuario->cd_estado_sme;

                    $dadosSessao['nm_cidade_sme']   = $usuario->nm_cidade;
                    $dadosSessao['nm_estado_sme']   = $usuario->nm_estado;
                   // print_r('<br><br><br><br>$usuario->ci_usuario='. $usuario->ci_usuario);
                }
                
                //return true;

                $dadosSessao['logado'] 		= TRUE;
				$this->session->set_userdata($dadosSessao);

                $this->get_grupo_usuario();
                $this->get_grupo_transacoes_usuario();
                redirect(base_url('home/index'));
			}else{
				$dadosSessao['userlogado']  = NULL;
				$dadosSessao['logado'] 		= FALSE;
				$this->session->set_userdata($dadosSessao);
				redirect(base_url('usuario/autenticacoes/login'));
			}

		}

    }
    
    public function get_grupo_usuario()	{

        $this->load->library('encrypt');
        $id = $this->session->userdata('ci_usuario');

		$grupo_usuarios = $this->modelautenticacao->listar_grupo_usuario($id);
        
        if (count($grupo_usuarios) > 1) {
            $dados['grupo_usuarios'] = $grupo_usuarios;

            foreach ($dados['grupo_usuarios'] as $grupo_usuario) {

                $dadosSessao['ci_escola'] 		= $grupo_usuario->ci_escola;
                $dadosSessao['nm_escola'] 		= $grupo_usuario->nm_escola;
                $dadosSessao['nr_inep'] 	    = $grupo_usuario->nr_inep;
                $dadosSessao['ci_grupousuario'] = $grupo_usuario->ci_grupousuario;
                $dadosSessao['cd_grupo']        = $grupo_usuario->ci_grupousuario;
				$dadosSessao['nm_grupo'] 		= $grupo_usuario->nm_grupo;
                $dadosSessao['tp_administrador']= $grupo_usuario->tp_administrador;
			}

            $menu = array();
            $menu['habilitar_menu'] = false;

            $dadosSessao['troca_escola'] = true;
            $this->session->set_userdata($dadosSessao);
            $this->load->view('template/html-header');
            $this->load->view('template/template', $menu);
            $this->load->view('trocar_escolas', $dados);
            $this->load->view('template/html-footer');

        }elseif (count($grupo_usuarios) == 1){
            $dados['grupo_usuarios'] = $grupo_usuarios;
            $ci_escola      = "";
            $ci_grupousuario= "";
            $nm_escola      = "";
            $nm_grupo       = "";
            foreach ($dados['grupo_usuarios'] as $grupo_usuario) {

                $ci_escola      = $grupo_usuario->ci_escola;
                $nm_escola      = $grupo_usuario->nm_escola;
                $cd_grupo       = $grupo_usuario->ci_grupousuario;
                $nm_grupo       = $grupo_usuario->nm_grupo;
            }
            
            $dadosSessao['troca_escola'] = false;
            $this->session->set_userdata($dadosSessao);

            if ((!$ci_escola) && ($cd_grupo == 3)){
                redirect(base_url('usuario/autenticacoes/login/'.md5('usuario_sem_escola')));
            }

            $this->escolher_acesso($ci_escola, $cd_grupo, $nm_escola, $nm_grupo);
        }else{
            redirect(base_url('usuario/autenticacoes/login/'.md5('usuario_nao_encontrado')));
        }

    }
    public function get_grupo_transacoes_usuario(){
        $id = $this->session->userdata('cd_grupo');
        $grupo_transacoes_usuario = $this->modelautenticacao->listar_grupo_transacoes_usuario($id);

        
        if (count($grupo_transacoes_usuario) > 1) {
            $dados['grupo_transacoes_usuario'] = $grupo_transacoes_usuario;

            $ci_transacao = "";
            $dadosSessao['AUXILIARES']      = FALSE; // Menu Auxiliar
            $dadosSessao['CADASTROS']       = FALSE; // Menu Cadastros
            $dadosSessao['AVALIACOES']      = FALSE; // Menu Avaliações
            
            $dadosSessao['ETAPA'] 		    = FALSE;
            $dadosSessao['ANO LETIVO'] 		= FALSE;
            
            $dadosSessao['EDICAO'] 		    = FALSE;
            $dadosSessao['TIPODEAVALIACAO'] = FALSE;
            $dadosSessao['TURNO']           = FALSE;
            $dadosSessao['CONTEUDO'] 	    = FALSE;
            $dadosSessao['SUBCONTEUDO'] 	= FALSE;
            $dadosSessao['ORIGEM'] 	        = FALSE;
            $dadosSessao['DIFICULDADE'] 	= FALSE;
            $dadosSessao['GRUPO'] 	        = FALSE;
            $dadosSessao['TRANSACAO'] 	    = FALSE;

            $dadosSessao['ENTURMACAO'] 		= FALSE;
            $dadosSessao['ALUNO'] 	        = FALSE;
            $dadosSessao['ESCOLA'] 	        = FALSE;
            $dadosSessao['TURMA'] 	        = FALSE;
            $dadosSessao['PROFESSOR'] 	    = FALSE;
            $dadosSessao['DISCIPLINA'] 	    = FALSE;
            $dadosSessao['DEFICIENCIA']     = FALSE;
            $dadosSessao['USUARIO ADMIN'] 	= FALSE;
            $dadosSessao['USUARIO SME'] 	= FALSE;

            $dadosSessao['AVALIACAO'] 	    = FALSE;
            $dadosSessao['ITEM'] 	        = FALSE;
            $dadosSessao['MONTARAVALIACAO'] = FALSE;

            $dadosSessao['APLICAR AVALIAÇÃO']   = FALSE;
            $dadosSessao['LANÇAR GABARITO']     = FALSE;
            $dadosSessao['TURNO']               = FALSE;

            $dadosSessao['MATRIZ']          = FALSE;
            $dadosSessao['TRANSFERENCIA']   = FALSE;
            $dadosSessao['PARTICIPACAO']   = FALSE;

            foreach ($dados['grupo_transacoes_usuario'] as $item) {
                $ci_transacao = $item->cd_transacao; 
                if ($ci_transacao == 1){
                    $dadosSessao['ETAPA'] 		        = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 2){
                    $dadosSessao['EDICAO'] 		        = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 3){
                    $dadosSessao['TIPODEAVALIACAO'] 	= TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 4){
                    $dadosSessao['CONTEUDO'] 	        = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 5){
                    $dadosSessao['SUBCONTEUDO'] 	    = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 6){
                    $dadosSessao['ORIGEM'] 	            = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 7){
                    $dadosSessao['DIFICULDADE'] 	    = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 8){
                    $dadosSessao['GRUPO'] 	            = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 9){
                    $dadosSessao['TRANSACAO'] 	        = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 10){
                    $dadosSessao['ALUNO'] 	            = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 11){
                    $dadosSessao['ESCOLA'] 	            = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 12){
                    $dadosSessao['TURMA'] 	            = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 13){
                    $dadosSessao['PROFESSOR'] 	        = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 14){
                    $dadosSessao['DISCIPLINA'] 	        = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 15){
                    $dadosSessao['USUARIO ADMIN'] 	    = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 16){
                    $dadosSessao['AVALIACAO'] 	        = TRUE;
                    $dadosSessao['AVALIACOES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 17){
                    $dadosSessao['ITEM'] 	            = TRUE;
                    $dadosSessao['AVALIACOES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 18){
                    $dadosSessao['MONTARAVALIACAO'] 	= TRUE;
                    $dadosSessao['AVALIACOES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 20){
                    $dadosSessao['ENTURMACAO']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 21){
                    $dadosSessao['USUARIO SME']         = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 22){
                    $dadosSessao['APLICAR AVALIAÇÃO']   = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 23){
                    $dadosSessao['LANÇAR GABARITO']     = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 24){
                    $dadosSessao['TURNO']               = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 25){
                    $dadosSessao['ANOLETIVO']           = TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }
                elseif ($ci_transacao == 26){
                    $dadosSessao['MATRIZ']              = TRUE;
                }
                elseif ($ci_transacao == 27){
                    $dadosSessao['TRANSFERENCIA']       = TRUE;
                }
                elseif ($ci_transacao == 28){
                    $dadosSessao['INFREQUENCIA']            = TRUE;
                    $dadosSessao['CADASTRO DE INFREQUENCIA']   = TRUE;
                }
                elseif ($ci_transacao == 29){
                    $dadosSessao['INFREQUENCIA']       = TRUE;
                    $dadosSessao['LIBERACAO DE INFREQUENCIA']       = TRUE;
                }elseif ($ci_transacao == 30){
                    $dadosSessao['DEFICIENCIA'] 		= TRUE;
                    $dadosSessao['AUXILIARES']          = TRUE;
                    $dadosSessao['CADASTROS']           = TRUE;
                }elseif ($ci_transacao == 31){
                	$dadosSessao['PARTICIPACAO']        = TRUE;
                }                
                
            }
            $this->session->set_userdata($dadosSessao);
            
        }
        

    }

    public function EnviarEmail($ci_usuario, $nm_login, $ds_email, $nm_usuario)
    {
        $dados['ci_usuario'] = $ci_usuario;
        $dados['nm_login']   = $nm_login;
        $dados['ds_email']   = $ds_email;
        $dados['nm_usuario'] = $nm_usuario;
        $dados['mensagem']   = 'Clique no botão abaixo para confirmar a alteração de sua senha.';

        $this->load->library('email');

        $this->email->from('naoresponda@saev.com.br','Sistema SAEV'); // Remetente
        $this->email->to($dados['ds_email'],$dados['nm_usuario']); // Destinatário
 
        $this->email->subject('Alteração de senha - SAEV');
 
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

    public function escolher_acesso($ci_escola = null, $cd_grupo = null, $nm_escola = null, $nm_grupo = null)	{
        $this->load->library('encrypt');

        if($ci_escola == null) {
            $ci_escola = $this->encrypt->decode($this->input->post('txt-campo01'), 'Chave de criptografia sistema01');
        }
        if($cd_grupo == null) {
            $cd_grupo = $this->encrypt->decode($this->input->post('txt-campo02'), 'Chave de criptografia sistema01');
        }
        if($nm_escola == null) {
            $nm_escola = $this->encrypt->decode($this->input->post('txt-campo03'), 'Chave de criptografia sistema01');
        }
        if($nm_grupo == null) {
            $nm_grupo = $this->encrypt->decode($this->input->post('txt-campo04'), 'Chave de criptografia sistema01');
        }

        $dadosSessao['ci_escola']       = $ci_escola;
        $dadosSessao['nm_escola']       = $nm_escola;
        $dadosSessao['ci_grupousuario'] = $cd_grupo;
        $dadosSessao['cd_grupo']        = $cd_grupo;
        $dadosSessao['nm_grupo']        = $nm_grupo;
        $this->session->set_userdata($dadosSessao);

        $this->load->view('template/html-header');
        $this->load->view('template/template');
        $this->load->view('template/html-footer');
    }
    public function cadastrarsenha()	{

        $ds_senha   = $this->input->post('ds_senha');
        $ci_usuario = $this->input->post('id');

        $dados['usuariologado'] = $this->modelautenticacao->cadastrarsenha($ci_usuario, $ds_senha);
        redirect(base_url('usuario/autenticacoes/login/'.md5('usuario_cadastrado_com_sucesso')));
    }
    public function email_alterarsenha()	{

        $nr_cpf   = $this->input->post('nr_cpf');
        $ds_email = $this->input->post('ds_email');
        $usuario = $this->modelautenticacao->getId($nr_cpf);
        $ci_usuario    = '';
        $nm_login      = '';
        if (count($usuario) >= 1) {
            foreach ($usuario as $item){
                $ci_usuario    = $item->ci_usuario;
                $nm_login      = $item->nm_login;
                $nm_usuario    = $item->nm_usuario;
            }

            $this->EnviarEmail($ci_usuario, $nm_login, $ds_email, $nm_usuario);
            $this->load->view('usuario/email_enviadosenha');
        }else{
            redirect(base_url('usuario/autenticacoes/telaalterarsenha/'.md5('usuario_nao_encontrado')));
        }
    }
    
}
