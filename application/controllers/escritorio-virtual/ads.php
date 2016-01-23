<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ads extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library("general");
        $this->load->library('grocery_CRUD');

        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";
    }

    function index($adsid){


        $this->db->where('md5(adsid)', $adsid);
        $ads_result = $this->db->get("ads");
        if($ads_result->num_rows() > 0):
            $this->db->query("
            insert into ads_report (adsid, aid)
                values (".$ads_result->row()->adsid.", ".$this->dx_auth->get_associado_id().")
                ");
            $this->general->redirect(prep_url($ads_result->row()->url_destino));
        else:
            $this->general->redirect('escritorio-virtual/dashboard');
        endif;
    }

    function gerenciar(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                    set_table('ads')->
                    set_subject('Anúncios')->
                    unset_fields('data')->
                    field_type('status', 'true_false')->
                    required_fields('titulo')->
                    columns('titulo', 'descricao')->
                    display_as('titulo', 'Título')->
                    display_as('descricao', 'Descrição')->
                    display_as('url_destino', 'URL de destino')->
                    display_as('url_imagem', 'URL da imagem');

                    $output = $crud->render();

                    $output->titulo = "Gestão de Conteúdo";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }



}

/* End of file ads.php */
/* Location: ./system/application/controllers/escritorio-virtual/ads.php */
