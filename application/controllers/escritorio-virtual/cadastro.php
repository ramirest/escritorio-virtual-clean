<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cadastro extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('adm/ModelAssociados', 'mass');
        $this->load->model("adm/Modelrede", "mrede");
        $this->load->model('adm/ModelPlanos', 'mplanos');
        $this->load->model('adm/Modelpedidos', 'mped');
        $this->load->model("adm/ModelLocalizacao", "mlocalizacao");
        $this->load->model("adm/ModelGeneral", "mGeneral");
        $this->load->library('localizacao');
        $this->load->library('tipos');
        $this->load->library('general');
        $this->load->library('data');
        $this->load->helper("text");
        $this->_container = "backend/container";
    }

    function index($patrocinador = FALSE)
    {
        $dados['page_js_foot'] = "rede";
        if ($this->form_validation->run('cadastro') === FALSE):
            $dados['patrocinador'] = $patrocinador!==FALSE?$this->mass->getAssociado($patrocinador, '', '', '', 'aid, Nome', TRUE):FALSE;
            //endereco
            $dados['estados'] = $this->mGeneral->fillCombo($this->mlocalizacao->getEstado(), 'uf', 'uf');
            //seleciona a lista de profissões e define o valor padrão "908" => (NÃO INFORMADO)
            $dados['profissoes'] = $this->mGeneral->fillCombo($this->mass->getProfissoes(), 'pid', 'descricao', '908');
            //tipos de endereços
            $dados['tipos'] = $this->tipos->endereco();

            $dados['titulo'] = 'Cadastro de Empreendedores';
            $dados['pagina'] = 'themes/backend/empresarios/cadastro';
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            //se tudo correr bem com o cadastro, leva o usuário para escolher seu plano
            if(($msg = $this->lib_associados->pre_cadastro()) !== FALSE):
                $dados['msg'] = $msg;
                $dados['titulo'] = 'Cadastro de Empreendedores';
                $dados['pagina'] = 'themes/backend/empresarios/escolha_plano';

                //busca a lista de planos
                $dados['planos'] = $this->mplanos->getPlano();
                //busca a lista de cadernos
                $dados['cadernos'] = $this->mass->getCaderno();

                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $dados['msg'] =  $this->config->item($this->mass->getErrno(), 'errno');
                $dados['titulo'] = 'Cadastro de Empreendedores';
                $dados['pagina'] = 'themes/backend/messages/confirmacao';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        endif;

    }


}

/* End of file cadastro.php */
/* Location: ./system/application/controllers/escritorio-virtual/cadastro.php */
