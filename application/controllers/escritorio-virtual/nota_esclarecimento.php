<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota_esclarecimento extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library("general");
        $this->load->model('adm/ModelAssociados', 'mass');
        $this->_container = "backend/container";
    }

    function index()
    {
        if($this->dx_auth->is_logged_in()):
            $dados['pagina'] = 'themes/backend/esclarecimento';
            $dados['titulo'] = "Nota de esclarecimento";


            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }
}

/* End of file nota_esclarecimento.php */
/* Location: ./system/application/controllers/escritorio-virtual/nota_esclarecimento.php */
