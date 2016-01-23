<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faturas extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('rede');
        $this->load->library('data');
        $this->load->model("Modelboleto", "mboleto");
        $data['backend'] = "admin";
        $this->load->vars($data);
        $this->_container = "backend/container";
        $this->limit = 10;
    }

    function index()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            if(($dados['faturas'] = $this->mboleto->getFaturas()) !== FALSE):
                $dados['titulo'] = 'Gerenciamento de Faturas';
                $dados['pagina'] = 'backend/admin/faturas/listar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
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
            $this->form_validation->set_rules('uid','Usu&aacute;rio','required');
            if($this->form_validation->run() == FALSE):
                $dados['titulo'] = 'Criar Fatura';
                $dados['pagina'] = 'backend/admin/faturas/criar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $v = $this->_tratar_form_fatura();
                if($this->mboleto->gera_fatura($v['uid'],$this->data->human_to_mysql($v['vencimento']),$v['valor'],$v['descricao']) == TRUE):
                    $this->session->set_flashdata('msg', 'Fatura criada com sucesso!');
                    redirect('adm/faturas');
                else:
                    $dados['msg'] = 'Fatura j&aacute; cadastrada, verifique as informa&ccedil;&otilde;es e tente novamente';
                    $dados['titulo'] = 'Gerenciamento de Faturas';
                    $dados['pagina'] = 'backend/admin/faturas/criar';
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                endif;
            endif;
        endif;
      else:
        redirect('principal');
      endif;
    }

    function carregar()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->load->helper('text');
            $this->db->flush_cache();
            foreach($this->mboleto->getFaturas($this->input->post('fid'))->result() as $v):
                $dados['carregar'] = $v;
            endforeach;
            $dados['titulo'] = 'Gerenciamento de Faturas';
            $this->load->vars($dados);
            $this->load->view('backend/admin/faturas/ver');
        endif;
      else:
        redirect('principal');
      endif;
    }

    function editar($id = '')
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->form_validation->set_rules('uid','Usu&aacute;rio','required');
            if($this->form_validation->run() == FALSE):
                foreach($this->mboleto->getFaturas($id)->result() as $p):
                    $dados['fatura'] = $p;
                endforeach;
                $dados['titulo'] = 'Editar Fatura';
                $dados['pagina'] = 'backend/admin/faturas/editar';
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                $v = $this->_tratar_form_fatura(TRUE);
                $this->mboleto->editarFatura($v['uid'], $v['valor'], $this->data->human_to_mysql($v['vencimento']), $v['descricao'], $v['fid'], $v['situacao']);
                if($v['situacao'] == 'Quitada'):
                  //verifica o status do usuario e caso ainda esteja pendente,
                  //altera para ativo
                  $this->load->model('adm/Modelusuarios', 'musu');
                  if($this->musu->getStatus($v['uid']) == "P"):
                    $this->musu->alterarStatus($v['uid'], "A");
                  endif;
                  if($v['gerar_comissao'] == 'S'):
                    //gerar comissão para todos os uplines
                    if($v['descricao'] == "Taxa de Adesão"):
                        $tipo = "Adesão";
                    elseif($v['descricao'] == "Taxa de Manutenção e Recarga"):
                        $tipo = "Rede";
                    endif;
                    $comissao = $this->rede->gerar_comissoes($v['uid'], $tipo);
                  endif;
                endif;
                $this->session->set_flashdata('msg', 'A Fatura #'. $v['fid'] .' foi editada com sucesso!');
                redirect('adm/faturas');
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
            $this->mboleto->excluirFatura($this->uri->segment(4));
            $this->session->set_flashdata('msg', 'Fatura excluída com sucesso!');
            redirect('adm/faturas');
        endif;
      else:
        redirect('principal');
      endif;
    }

    function _tratar_form_fatura($editar = FALSE)
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            if($editar == TRUE):
                $v['fid'] = $this->uri->segment(4);
                $v['situacao'] = $this->input->post('situacao');
                $v['gerar_comissao'] = $this->input->post('gerar_comissao');
            endif;
            $v['uid'] = $this->input->post('uid');
            $v['valor'] = $this->input->post('valor');
            $v['vencimento'] = $this->input->post('vencimento');
            $v['descricao'] = $this->input->post('descricao');
            return $v;
        endif;
      else:
        redirect('principal');
      endif;
    }

}

/* End of file faturas.php */
/* Location: ./system/application/controllers/adm/faturas.php */