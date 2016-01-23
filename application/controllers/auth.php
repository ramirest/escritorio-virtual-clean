<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('general');
        $data['backend'] = "associado";
        $this->load->vars($data);
        $this->_container = "backend/container";
	}
	
	function index()
	{
		$this->login();
	}

    function token(){
        $credentials = $this->__get_credentials();
        OAuth2\Autoloader::register();

        $server = new OAuth2\Server();
    }

    function __get_credentials(){
        $credentials['grant_type'] = 'password';
        $credentials['client_id'] = $this->input->post('application');
        $credentials['client_secret'] = $this->input->post('app_pass');
        $credentials['username'] = $this->input->post('username');
        $credentials['password'] = $this->input->post('password');
        return $credentials;
    }
	
	/* Callback function */
	
	function email_check()
	{
		$result = $this->dx_auth->is_email_available($this->input->post("email"));
        if($this->input->post("email") == NULL):
            echo $this->config->item('err_msg_style').'Você esqueceu de informar seu email!'.$this->config->item('msg_style_end');
        elseif(!$this->form_validation->valid_email($this->input->post("email"))):
            echo $this->config->item('ale_msg_style').'Por favor, informe um email válido!'.$this->config->item('msg_style_end');
        else:
            if ( !$result):
                echo $this->config->item('ale_msg_style').'Este email j&aacute; est&aacute; sendo usado, ser&aacute; que voc&ecirc; <strong><a href="'.site_url("recuperar_senha").'">esqueceu sua senha?</a></strong>'.$this->config->item('msg_style_end');
            endif;
        endif;
	}

	function captcha_check($code)
	{
		$result = TRUE;
		
		if ($this->dx_auth->is_captcha_expired())
		{
			// Will replace this error msg with $lang
			$this->form_validation->set_message('captcha_check', 'Your confirmation code has expired. Please try again.');			
			$result = FALSE;
		}
		elseif ( ! $this->dx_auth->is_captcha_match($code))
		{
			$this->form_validation->set_message('captcha_check', 'Your confirmation code does not match the one in the image. Try again.');			
			$result = FALSE;
		}

		return $result;
	}
	
	function user_active_check($username = "")
	{
		return $this->general->user_active_check($username);
	}
	
	function recaptcha_check()
	{
		$result = $this->dx_auth->is_recaptcha_match();		
		if ( ! $result)
		{
			$this->form_validation->set_message('recaptcha_check', 'Your confirmation code does not match the one in the image. Try again.');
		}
		
		return $result;
	}
	
	/* End of Callback function */
	
	
	function login()
	{
		if ( ! $this->dx_auth->is_logged_in())
		{
			$val = $this->form_validation;
			
			// Set form validation rules
            //$val->set_rules('username', 'nome de usuário', 'trim|required|xss_clean|callback_user_active_check');
			$val->set_rules('username', 'nome de usuário', 'trim|required|xss_clean');
			$val->set_rules('password', 'senha', 'trim|required|xss_clean');
			$val->set_rules('remember', 'permanecer conectado', 'integer');

			// Set captcha rules if login attempts exeed max attempts in config
			if ($this->dx_auth->is_max_login_attempts_exceeded())
			{
				$val->set_rules('captcha', 'Código de confirmação', 'trim|required|xss_clean|callback_captcha_check');
			}
				
			if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember')))
			{
				// Redirect to homepage
                $this->general->redirect('escritorio-virtual/dashboard');
			}
			else
			{
				// Check if the user is failed logged in because user is banned user or not
				if ($this->dx_auth->is_banned())
				{
					// Redirect to banned uri
					$this->dx_auth->deny_access('banned');
				}
				else
				{						
					// Default is we don't show captcha until max login attempts eceeded
					$data['show_captcha'] = FALSE;
				
					// Show captcha if login attempts exceed max attempts in config
					if ($this->dx_auth->is_max_login_attempts_exceeded())
					{
						// Create catpcha						
						$this->dx_auth->captcha();
						
						// Set view data to show captcha on view file
						$data['show_captcha'] = TRUE;
					}
					
					// Load login page view
                    $data['titulo'] = "Login";
                    $data['pagina'] = $this->dx_auth->login_view;
					$data['page_login'] = TRUE;
                    $this->load->vars($data);
					$this->load->view($this->_container);
				}
			}
		}
		else
		{
               $this->general->redirect('escritorio-virtual/dashboard');
		}
	}
	
	function logout()
	{
		$this->dx_auth->logout();
        $this->session->set_flashdata('msg', 'Sua sessão foi encerrada!');
		$this->general->redirect(self::login());
	}
	
	function activate()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Activate user
		if ($this->dx_auth->activate($username, $key)) 
		{
			$data['auth_message'] = 'Your account have been successfully activated. '.anchor(site_url($this->dx_auth->login_uri), 'Login');
			$this->load->view($this->dx_auth->activate_success_view, $data);
		}
		else
		{
			$data['auth_message'] = 'The activation code you entered was incorrect. Please check your email again.';
			$this->load->view($this->dx_auth->activate_failed_view, $data);
		}
	}
	
	function forgot_password()
	{
		$val = $this->form_validation;
		
		// Set form validation rules
		$val->set_rules('login', 'nome de usuário ou email', 'trim|required|xss_clean');

		// Validate rules and call forgot password function
		if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login')))
		{
			$data['auth_message'] = 'Um email foi enviado para seu email com instruções de como ativar sua nova senha.';

			$data['titulo'] = "Recuperação de senha";
			$data['pagina'] = $this->dx_auth->forgot_password_success_view;
			$data['page_login'] = TRUE;
			$this->load->vars($data);
			$this->load->view($this->_container);
		}
		else
		{
			$data['titulo'] = "Recuperação de senha";
			$data['pagina'] = $this->dx_auth->forgot_password_view;
			$data['page_login'] = TRUE;
			$this->load->vars($data);
			$this->load->view($this->_container);
		}
	}
	
	function reset_password()
	{
		// Get username and key
		$username = $this->uri->segment(3);
		$key = $this->uri->segment(4);

		// Reset password
		if ($this->dx_auth->reset_password($username, $key))
		{
			$data['auth_message'] = 'Sua senha foi recriada com sucesso, '.anchor(site_url($this->dx_auth->login_uri), 'Login');
			$this->load->view($this->dx_auth->reset_password_success_view, $data);
		}
		else
		{
			$data['auth_message'] = 'Falha ao recriar sua senha. <br>Seu nome de usuário e chave de ativação estão incorretos ou a ativação já foi efetuada utilizando estes dados. <br>Por favor, verifique seu email novamente e siga as instruções, se ainda assim não for possível acessar sua conta, tente solicitar sua senha novamente.';
			$this->load->view($this->dx_auth->reset_password_failed_view, $data);
		}
	}		

	// Example how to get permissions you set permission in /backend/custom_permissions/
	function custom_permissions()
	{
		if ($this->dx_auth->is_logged_in())
		{
			echo 'My role: '.$this->dx_auth->get_role_name().'<br/>';
			echo 'My permission: <br/>';
			
			if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit'))
			{
				echo 'Edit is allowed';
			}
			else
			{
				echo 'Edit is not allowed';
			}
			
			echo '<br/>';
			
			if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete'))
			{
				echo 'Delete is allowed';
			}
			else
			{
				echo 'Delete is not allowed';
			}
		}
	}
}
?>