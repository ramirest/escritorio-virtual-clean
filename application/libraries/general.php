<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class General {

    function __construct(){
        $this->ci =& get_instance();
    }
	
	function redirect($page){
	  	if(!headers_sent()):
			redirect($page);
		else:
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.site_url($page).'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.site_url($page).'" />';
			echo '</noscript>';
		endif;
	}
	
	function user_active_check($username){
		
		$this->ci->load->model ( "adm/ModelAssociados", "mass" );
		$result = $this->ci->mass->is_associado_active ( $username == "" ? $this->input->post ( "username" ) : $username );
		if ($result === FALSE) :
			$this->ci->form_validation->set_error_delimiters ( $this->ci->config->item ( 'err_msg_style' ), $this->ci->config->item ( 'msg_style_end' ) );
			$this->ci->form_validation->set_message ( 'user_active_check', 'Você ainda não ativou seu cadastro, por favor, entre em contato com seu líder ou com nossa central de atendimento para efetuar o pagamento e ativar seu cadastro.' );
			$result = FALSE;
		
		endif;
				
		return $result;
		
	}

    function FormataDataBR($data){
        if ($data == '')
            return '';
        $data_f = explode('-',$data);
        return $data_f[2].'/'.$data_f[1].'/'.$data_f[0];
    }


    function numberBR($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

}

/* End of file modelGeneral.php */
/* Location: ./system/application/libraries/modelGeneral.php */