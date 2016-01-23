<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produtos extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library("general");
        $this->load->library('grocery_CRUD');

        $this->load->model('adm/ModelEcommerce', 'mecom');

        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";

    }

    function index(){
        if($this->dx_auth->is_logged_in()):
            try{
                $this->db = $this->load->database('loja',true);
                $crud = new grocery_CRUD();

                $crud->set_theme('product-list');
                $crud->set_model('adm/modelecommerce_crud');
                $crud->set_table('lista_produtos');
                $crud->where("sku !=", "21656932561");
                $crud->where("status",1);
                $crud->display_as('preco','Preço');
                $crud->display_as('sku','SKU');
                $crud->display_as('title','Título');
                $crud->columns('sku', 'title', 'preco');
                $crud->unset_operations();


                $output = $crud->render();

                $output->titulo = "Catálogo de Produtos";
                $pagina = $this->_container_crud;
                $this->load->vars((object)$output);
                $this->load->view($pagina);

            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }

        else:
            $this->general->redirect('login');
        endif;
    }

    function visualizar($sku){
        if($this->dx_auth->is_logged_in()):
            if($sku):
                $prod_result = $this->mecom->listaProdutos($sku);
                $prod_count = $prod_result->num_rows();
                if($prod_count > 0):
                    $this->load->helper('inflector');
                    $dados['produto'] = $prod_result->row();
                    $dados['page_plugin'] = 'ecommerce';
                else:
                    $dados['produto'] = FALSE;
                endif;

                $dados['titulo'] = 'Visualizar produto';
                $dados['pagina'] = 'themes/backend/produtos/visualizar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;

    }


}

/* End of file produtos.php */
/* Location: ./system/application/controllers/escritorio-virtual/produtos.php */