<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotsite extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('DX_Auth');
		$this->load->model('adm/ModelAssociados', 'mass');
		$this->load->model('adm/ModelPlanos', 'mplanos');
		$this->load->library('localizacao');
		$this->load->library('tipos');
		$this->load->library('lib_associados');
		$this->load->library('data');
		$this->_container = "frontend/container-hotsite";
		
	}
	
	function index($associado = "")
	{
        $dados['titulo'] = 'Bem vindo';
        if($associado != ""):
        if($this->lib_associados->set_patrocinador($associado) === FALSE)
        	$dados['msg'] = "O patrocinador informado não foi encontrado!";
        endif;        
        		
        $this->load->vars($dados);
		$this->load->view($this->_container);
	}

    function pre_cadastro()
    {
		if ($this->form_validation->run('cadastro') == FALSE):

			//planos
			//$dados['planos'] = $this->mplanos->getPlano()->result();

			//endereco
			$dados['estados'] = $this->localizacao->estados();

			$dados['tipos'] = $this->tipos->endereco();

			//informacoes para contato
			$dados['tp_tel'] = $this->tipos->telefone();
			
			$dados['tabs'] = TRUE;
			
			$dados['titulo'] = 'Hotsite - Cadastro';
			$dados['pagina'] = 'frontend/associados/pre_cadastro';
			$this->load->vars($dados);
			$this->load->view($this->_container);
		else:
			if(($msg = $this->lib_associados->pre_cadastro()) !== FALSE):
					$dados['tabs'] = TRUE;
					$dados['msg'] = $msg;
					$dados['titulo'] = 'Hotsite - Cadastrando';
					$dados['pagina'] = 'themes/backend/messages/confirmacao';
					$this->load->vars($dados);
					$this->load->view($this->_container);
			else:
				$dados['tabs'] = TRUE;
				$dados['msg'] = $this->config->item($this->mass->getErrno(), 'errno');
				$dados['titulo'] = 'Hotsite - Cadastrando';
				$dados['pagina'] = 'themes/backend/messages/confirmacao';
				$this->load->vars($dados);
				$this->load->view($this->_container);
			endif;
		endif;
    }
	
    function cadastro()
    {
		if ($this->dx_auth->captcha_registration)
		{
			$this->form_validation->set_rules('recaptcha_response_field', 'C&oacute;digo de Confirma&ccedil;&atilde;o', 'trim|xss_clean|required|callback_recaptcha_check');
		}
		$this->form_validation->set_rules('plano', 'Plano de assinatura', 'trim|xss_clean|required|callback_plano_check');
		$this->form_validation->set_rules('email', 'email', 'trim|xss_clean|valid_email');
		//$this->form_validation->set_rules('cpf', 'CPF', 'trim|xss_clean|required|is_unique[users.email]');
		if ($this->form_validation->run() == FALSE):

			//planos
			$dados['planos'] = $this->mplanos->getPlano()->result();

			//endereco
			$dados['estados'] = $this->localizacao->estados();

			$dados['tipos'] = $this->tipos->endereco();

			//informacoes para contato
			$dados['tp_tel'] = $this->tipos->telefone();
			
			//Lista dos principais bancos
			$dados['lista_bancos'] = $this->tipos->bancos();

			//Tipos de conta bancária
			$dados['tipos_conta'] = $this->tipos->tpconta();

			$dados['titulo'] = 'Hotsite - Cadastro';
			$dados['pagina'] = 'frontend/associados/criar';
			$this->load->vars($dados);
			$this->load->view($this->_container);
		else:
			if($this->lib_associados->adicionar() === TRUE):
				$this->session->set_flashdata('msg', 
					'Seu cadastro foi efetuado com sucesso!<br>'.
					'Segue abaixo seus dados cadastrados, utilize-os para acessar o sistema.<br><br>'.
					'Nome: '.$this->session->flashdata('nome').
					'ID: '.$this->session->flashdata('id').
					'Login: '.$this->session->flashdata('login').
					'Email: '.$this->session->flashdata('email').
					'Senha: Por questões de segurança não exibiremos sua senha, 
					guarde-a em local seguro e utilize-a juntamente com seu login ou email para acessar o sistema. <br><br>
					Seja bem vindo ao SICOVE!<br><br>'.
					'<strong>Equipe SICOVE</strong>'
					);
				redirect('hotsite/cadastro');
			else:
				$this->session->set_flashdata('msg', $this->config->item($this->mass->getErrno(), 'errno'));
				redirect('hotsite/cadastro');
			endif;
		endif;
    }

	public function plano_check()
	{
		foreach($this->mplanos->getPlano('pid', $this->input->post('plano'))->result() as $plano):
			if(($plano->percentual_ganho != 0) && $this->mass->getPatrocinadorConsumidor($this->input->post('patrocinador')) === TRUE):
				$this->form_validation->set_message('plano_check', 'O patrocinador informado não pode cadastrar empresários em outros planos além do plano "consumo", por favor, altere o plano ou entre em contato com seu patrociador');
				return FALSE;
			else:
				return TRUE;
			endif;
		endforeach;		
	}
/*
	public function planos($plano)
	{
		$p = $this->select_plano($plano);
		if($p === FALSE):
			redirect(site_url());
		else:
			$dados['titulo'] = 'Conheça o plano '.$p['nome'];
			$dados['pagina'] = "frontend/planos/".$p['arquivo'];
			$dados['tabs'] = TRUE;
			
			$this->load->vars($dados);
			$this->load->view($this->_container);
		endif;
	}
	
	public function revista()
	{
		$dados['titulo'] = "Revista SICOVE";
		$dados['pagina'] = "frontend/revista/index";
		$dados['tabs'] = TRUE;
		
		$this->load->vars($dados);
		$this->load->view($this->_container);
	}
	
	public function formas_ganho()
	{
		$dados['titulo'] = "Formas de ganho";
		$dados['pagina'] = "frontend/formas_ganho/index";
		$dados['tabs'] = TRUE;
		
		$this->load->vars($dados);
		$this->load->view($this->_container);
	}
	
	public function armazem()
	{
		$dados['titulo'] = "Armazém SICOVE";
		$dados['pagina'] = "frontend/armazem/index";
		$dados['tabs'] = TRUE;
		
		$this->load->vars($dados);
		$this->load->view($this->_container);
	}
		
	private function select_plano($plano)
	{
		switch($plano):
			case 'light':
				$p['nome'] = 'Light';
				$p['arquivo'] = $plano;
				break;
			case 'pop':
				$p['nome'] = 'Pop';
				$p['arquivo'] = $plano;
				break;
			case 'mega':
				$p['nome'] = 'mega';
				$p['arquivo'] = $plano;
				break;
			case 'top':
				$p['nome'] = 'Top';
				$p['arquivo'] = $plano;
				break;
			default:
				$p = FALSE;
		endswitch;
		
		return $p;
	}
	
	function aviso()
	{
		$this->load->view("frontend/principal/index");
	}
*/

}

/* End of file hotsite.php */
/* Location: ./system/application/controllers/hotsite.php */