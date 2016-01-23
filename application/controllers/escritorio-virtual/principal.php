<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('session');
        $this->load->library('DX_Auth');
        $this->load->library('typography');
        $this->load->library('lib_associados');
        $this->load->library('data');
        $this->_container = "frontend/container";
        $this->load->model('adm/ModelPaginas', 'mpag');
        $this->load->model('adm/ModelNoticias', 'mnot');
        $this->load->helper('text');
        $this->load->helper('cookie');
	}
	
	function index()
	{
		redirect('login');
	}

    function faleconosco()
    {
        $this->form_validation->set_rules('nome','nome','required');
        $this->form_validation->set_rules('email','email','required|valid_email');
        $this->form_validation->set_rules('assunto','assunto','required');
        $this->form_validation->set_rules('mensagem','mensagem','required|xss_clean');
        if($this->form_validation->run() == FALSE):
            $data['values']['nome'] = set_value('nome');
            $data['values']['email'] = set_value('email');
            $data['values']['assunto'] = set_value('assunto');
            $data['values']['mensagem'] = set_value('mensagem');

            $data['titulo'] = 'Fale Conosco';
            $data['pagina'] = 'frontend/principal/faleconosco';
            $this->load->vars($data);
            $this->load->view($this->_container);
        else:

            $this->load->library('email');
            $this->email->from($this->input->post('email'), $this->input->post('nome'));
            $this->email->to('contato@sicove.com.br');

            $this->email->subject($this->input->post('assunto'));
            $this->email->message($this->input->post('mensagem'));

            if($this->email->send()):
              $this->session->set_flashdata('msg', 'Mensagem enviada com sucesso!');
              redirect('principal');
            else:
              $data['erro'] = 'N&atilde;o foi poss&iacute;vel enviar sua mensagem, tente novamente';
              $data['pagina'] = 'frontend/principal/faleconosco';

              $this->load->vars($data);
              $this->load->view($this->_container);
            endif;

        endif;
        
    }

}

/* End of file principal.php */
/* Location: ./system/application/controllers/principal.php */