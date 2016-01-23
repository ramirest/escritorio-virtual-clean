<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library("general");
        $this->load->library('grocery_CRUD');

        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";
    }

    function index($cid){
        if($this->dx_auth->is_logged_in()):
            $this->db->where('cid', $cid);
            $conteudo = $this->db->get('cms');
            if($conteudo->num_rows() > 0):
                $dados['conteudo'] = $conteudo->row();

                $dados['pagina'] = 'themes/backend/cms';
                $tipo = $conteudo->row()->tp_conteudo=='noticia'?'Notícia':'Novidade';
                $dados['titulo'] = $tipo;
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $this->general->redirect('escritorio-virtual/dashboard');
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function gerenciar(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                    set_table('cms')->
                    set_subject('Conteúdo')->
                    unset_fields('data')->
                    set_rules('corpo', 'Corpo', 'prep_for_form')->
                    field_type('status', 'true_false')->
                    required_fields('titulo','corpo','tp_conteudo')->
                    columns('titulo', 'tp_conteudo')->
                    display_as('titulo', 'Título')->
                    display_as('noticia', 'Notícia')->
                    display_as('tp_conteudo', 'Tipo de conteúdo')->
                    display_as('url_imagem', 'URL da Imagem');

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

/* End of file cms.php */
/* Location: ./system/application/controllers/escritorio-virtual/cms.php */
