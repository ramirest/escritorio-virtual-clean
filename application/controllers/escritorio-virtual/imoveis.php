<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imoveis extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('adm/modelimoveis', 'mImo');
        $this->load->model('adm/modelTipoImovel', 'mTipoImovel');
        $this->load->model('adm/modelGeneral', 'mGeneral');
        $this->load->model('adm/modelLocalizacao', 'mLocalizacao');
        $this->load->model('adm/modelEmpresas', 'mEmpresas');
        $this->load->library('general');
        $this->load->library("typography");
        $this->load->library("encrypt");

        if($this->dx_auth->is_role(array("root", "admin"))):
            $data['backend'] = "admin";
        elseif($this->dx_auth->is_role(array("user"))):
            $data['backend'] = "associado";
        else:
            $data['backend'] = "associado";
        endif;
        $this->load->vars($data);
        $this->_container = "backend/container";
    }

    function index(){
        redirect('escritorio-virtual/imoveis/gerenciar');
    }

    function gerenciar(){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                $dados['imoveis'] = $this->mImo->getImoveis();
                $dados['titulo'] = "Gerenciamento de Imóveis";
                $dados['pagina'] = "themes/backend/imoveis/gerenciar";
                $dados['page_js_foot'] = "tables";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $this->general->redirect('escritorio-virtual/imoveis');
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function cadastro($iid = "")
    {
        //$iid = $this->encrypt->decode($iid);

        $dados['page_js_foot'] = "rede";

        if ($this->form_validation->run('cadastro_imoveis') === FALSE):
            $dados['estados'] = $this->mGeneral->fillCombo($this->mLocalizacao->getEstado(),'uf','uf');
            $dados['tipos'] = $this->mGeneral->fillCombo($this->mTipoImovel->getTipoImovel(),'tiid','descricao');
            $dados['empresas'] = $this->mGeneral->fillCombo($this->mEmpresas->getEmpresas(),'eid', 'razao_social');

            $dados['titulo'] = 'Adicionar Imóvel';
            $dados['pagina'] = 'themes/backend/imoveis/cadastro';
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            // quando for igual a vazio é porque é uma inserção
            if ($iid == ""):
                $form = $this->_get_form_values();
                if($this->mImo->inserirImovel($form) === TRUE):
                    $this->session->set_flashdata('msg','Imóvel inserido com sucesso.');
                    $this->general->redirect('escritorio-virtual/imoveis/gerenciar');
                endif;
            else:
                $form = $this->_get_form_values($iid);
                if($this->mImo->editarImovel($form) === TRUE):
                    $this->session->set_flashdata('msg','Imóvel alterado com sucesso.');
                    $this->general->redirect('escritorio-virtual/imoveis/gerenciar');
                else:
                    $dados['msg'] = 'Ocorreu um erro ao gravar o imóvel.';
                endif;
            endif;
        endif;
    }

    function alterar($iid = "")
    {
        $dados['page_js_foot'] = "rede";

        if ($this->form_validation->run('cadastro_imoveis') === FALSE):
            $dados['estados'] = $this->mGeneral->fillCombo($this->mLocalizacao->getEstado(),'uf','uf');
            $dados['tipos'] = $this->mGeneral->fillCombo($this->mTipoImovel->getTipoImovel(),'tiid','descricao');
            $dados['empresas'] = $this->mGeneral->fillCombo($this->mEmpresas->getEmpresas(),'eid', 'razao_social');

            if(($imovel = $this->mImo->getImoveis("iid", $iid)) !== FALSE):
                $dados['imovel'] = $imovel->row();
            else:
                $dados['imovel'] = FALSE;
            endif;

            $dados['titulo'] = 'Alteração de Imóvel';
            $dados['pagina'] = 'themes/backend/imoveis/cadastro';
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
    }

    function excluir($iid)
    {
        if($iid!=""):
            if($this->mImo->excluirImovel($iid) === TRUE):
                $this->session->set_flashdata('msg','Imóvel excluído com sucesso.');
                $this->general->redirect('escritorio-virtual/imoveis/gerenciar');
            else:
                $this->session->set_flashdata('msg','Ocorreu um erro ao excluir o imóvel.');
                $this->general->redirect('escritorio-virtual/imoveis/gerenciar');
            endif;
        else:
            $this->session->set_flashdata('msg','Não foi possível excluir o imóvel.');
            $this->general->redirect('escritorio-virtual/imoveis/gerenciar');
        endif;
    }

    function _get_form_values($iid = "")
    {
        if($iid!=""):
            //caso esteja editando um registro
            $v['iid'] = $iid;
        else:
            $v['iid'] = '';
        endif;

        $v['descricao'] = $this->input->post('descricao');
        $v['tipo'] = $this->input->post('tipo');
        $v['cep'] = $this->input->post('cep');
        $v['logradouro'] = $this->input->post('logradouro');
        $v['numero'] = $this->input->post('numero');
        $v['complemento'] = $this->input->post('complemento');
        $v['bairro'] = $this->input->post('bairro');
        $v['cidade'] = $this->input->post('cidade');
        $v['estado'] = $this->input->post('estado');
        $v['telefone'] = $this->input->post('telefone');
        $v['empresa'] = $this->input->post('empresa');

        return $v;
    }
}