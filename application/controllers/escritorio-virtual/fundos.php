<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fundos extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library("DX_Auth");
        $this->load->library("general");
        $this->load->library('grocery_CRUD');

        $this->load->model("adm/Modelcomissoes", "mcom");
        $data['backend'] = 'admin';
        $this->load->vars($data);
        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";
    }

    function index()
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual');
                    $crud->set_table('fundos');
                    $crud->set_primary_key('aid', 'get_associado');
                    $crud->set_relation_n_n('membros', 'fundo_origem', 'get_associado', 'fid', 'aid', 'Login');

                    $output = $crud->render();

                    $output->titulo = "Gestão dos Fundos";
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

    function subfundos()
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual');
                    $crud->set_table('subfundos');
                    $crud->set_primary_key('aid', 'get_associado');
                    $crud->set_relation('fid', 'fundos', 'descricao');
                    $crud->set_relation_n_n('membros', 'subfundo_membros', 'get_associado', 'sfid', 'aid', 'Login');
                    $crud->display_as('fid', 'Fundo');

                    $output = $crud->render();

                    $output->titulo = "Gestão dos Fundos";
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

    function grupos()
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role("root")):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual');
                    $crud->set_table('grupos');
                    $crud->set_primary_key('aid', 'get_associado');
                    $crud->set_relation('sfid', 'subfundos', 'descricao', '`sfid` not in (select sfid from subfundo_membros)'); //and (select sum(percentual) from grupos where grupos.sfid = subfundos.sfid group by sfid)  < 1');
                    $crud->required_fields('sfid');
                    $crud->display_as('sfid', 'Sub-Fundo');

                    $output = $crud->render();

                    $output->titulo = "Gestão dos Fundos";
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
?>
