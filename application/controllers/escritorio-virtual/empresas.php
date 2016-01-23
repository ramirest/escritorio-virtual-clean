<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/********************************************************
*	Empresas parceiras									*
*-------------------------------------------------------*
*	Author: Ramires Teixeira (ramirest@gmail.com)		*
*
*
********************************************************/

class Empresas extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("adm/modelempresas", "mempresas");
        $data['backend'] = "admin";
        $this->load->vars($data);
        $this->_container = "backend/container";
    }

    function index(){
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            if(($dados['empresas'] = $this->mempresas->getEmpresa()) !== false):
                $dados['titulo'] = 'Gerenciamento de empresas parceiras';
                $dados['pagina'] = 'backend/admin/empresas/listar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                redirect('adm/empresas/criar');
            endif;
        endif;
      else:
        redirect('principal');
      endif;
    }

    function criar()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->form_validation->set_rules('razao_social','Razão social','required');
            if($this->form_validation->run() == FALSE):
                $dados['titulo'] = 'Adicionar Empresa';
                $dados['pagina'] = 'backend/admin/empresas/criar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $v = $this->_tratar_form_empresa();
                if($this->mempresas->inserirEmpresa($v) == TRUE):
                    $this->session->set_flashdata('msg', 'Empresa adicionada com sucesso!');
                    redirect('adm/empresas');
                else:
                    $this->session->set_flashdata('msg', 'Empresa j&aacute; cadastrada, verifique as informa&ccedil;&otilde;es e tente novamente!');
                    redirect('adm/empresas/criar');
                endif;
            endif;
        endif;
      else:
        redirect('principal');
      endif;
    }

    function editar($id = '', $ver = FALSE)
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
		            $this->form_validation->set_rules('razao_social','Razão Social','required');
            if($this->form_validation->run() == FALSE || $ver === TRUE):
                foreach($this->mempresas->getEmpresa('eid', $id)->result() as $e):
                    $dados['empresa'] = $e;
                endforeach;
                $dados['titulo'] = $ver===TRUE?'Detalhes da empresa':'Editar Empresa';
                $dados['pagina'] = 'backend/admin/empresas/'.$ver===TRUE?'ver':'editar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $v = $this->_tratar_form_empresa(TRUE);
                $this->mempresas->editarEmpresa($v);
                $this->session->set_flashdata('msg', 'A empresa "'. $v['razao_social'] .'" foi editada com sucesso!');
                redirect('adm/empresas');
            endif;
        endif;
      else:
        redirect('principal');
      endif;
    }

    function excluir()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->mempresas->excluirEmpresa($this->uri->segment(4));
            $this->session->set_flashdata('msg', 'Empresa excluída com sucesso!');
            redirect('adm/empresas');
        endif;
      else:
        redirect('principal');
      endif;
    }

    function _tratar_form_empresa($editar = FALSE)
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
			//configura o valor para o codigo da empresa
			//se estiver criando um novo registro, o valor será vazio, 
			//caso contrario será o codigo da empresa a ser editado
            if($editar == TRUE):
                $v['eid'] = $this->uri->segment(4);
			else:
				$v['eid'] = '';
            endif;
			//load config items
			$itens_form = $this->config->item('itens_form');
			foreach($itens_form['empresa'] as $k=>$ignore):
				$v[$k] = $this->input->post($k);
			endforeach;
			foreach($itens_form['empresa_endereco'] as $k=>$ignore):
				$v['endereco'][$k] = $this->input->post($k);
			endforeach;
			foreach($itens_form['empresa_telefone'] as $k=>$ignore):
				$v['telefone'][$k] = $this->input->post($k);
			endforeach;
            return $v;
        endif;
      else:
        redirect('principal');
      endif;
    }

}

/* End of file empresas.php */
/* Location: ./sys/application/controllers/adm/empresas.php */