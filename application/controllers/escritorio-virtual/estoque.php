<?php
/*****************************************************
 * 	Autor - Thiago Augusto - thiagoaug@gmail.com	 *
 *													 *
 *	script de gerenciamento de estoque do escritorio *
 *  virtual	                                         *
 *													 *
 *													 *
 *													 *
 *													 *
 ******************************************************/


class Estoque extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("adm/modelestoque", "mest");
        $this->load->library("data");
        $this->_container = "backend/container";

    }

    function index(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):
                $dados['titulo'] = "Gerenciar Estoque";
                $dados['pagina'] = "themes/backend/estoque/gerenciarestoque";
                if ($this->form_validation->run('gerencia_estoque') === TRUE):
                    $dados['produtos'] = $this->mest->listaProdutos($this->input->post('tp_mov'));
                else:
                    $dados['produtos'] = $this->mest->listaProdutos("S");
                endif;
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            redirect('login');
        endif;
    }

    function saidaestoque(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):

                $dados['titulo'] = "Saída no Estoque";
                $dados['page_style'] = "estoque";
                $dados['page_js_foot'] = "estoque";
                $dados['pagina'] = "themes/backend/estoque/gerenciarestoque";

                $dados['prod'] = $this->mest->produtos();
                $dados['allassoc'] = $this->mest->selAllAssoc();
                if ($this->form_validation->run('saida_estoque') === TRUE):
                    $dados['upEstoque'] = $this->mest->atualizaEstoque($this->input->post('quantidade_txt'),$this->input->post('produto-select'),'S');


                    $assoc = $this->mest->selAssoc($this->input->post('destinatario_txt'));
                    $dados['movSaida'] = $this->mest->movEstoqueSaidaRev($this->input->post('produto-select'),$assoc->aid, $this->input->post('quantidade_txt'), $this->data->human_to_mysql($this->input->post('dataMov')));
                    $dados['assoc'] = $assoc->aid;
                endif;
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            redirect('login');
        endif;
    }

    function entradaestoque(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("admin","root"))):

                $dados['titulo'] = "Entrada no Estoque";
                $dados['page_style'] = "estoque";
                $dados['page_js_foot'] = "estoque";
                $dados['pagina'] = "themes/backend/estoque/gerenciarestoque";
                $dados['prod'] = $this->mest->produtos();


                $dados['allparc'] = $this->mest->selAllParc();
                if ($this->form_validation->run('entrada_estoque') === TRUE):
                    $dados['upEstoque'] = $this->mest->atualizaEstoque($this->input->post('quantidade_txt'),$this->input->post('produto-select'),'E');

                    $dados['movEntrada'] = $this->mest->movEstoqueEntradaRev($this->input->post('produto-select'),$this->input->post('fornecedor_txt'), $this->input->post('quantidade_txt'), $this->data->human_to_mysql($this->input->post('dataMov')));
                    $dados['assoc'] = $assoc->aid;
                endif;
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            redirect('login');
        endif;
    }


}

/* End of file estoque.php */
/* Location: ./system/application/controllers/escritorio-virtual/estoque.php */