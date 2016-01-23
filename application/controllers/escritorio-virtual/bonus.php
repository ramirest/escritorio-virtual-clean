<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bonus extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('tipos');
        $this->load->library('localizacao');
        $this->load->library('general');
        $this->load->library('data');
        $this->load->helper("text");
        $this->load->model("adm/Modelrede", "mrede");
        $this->load->model("adm/Modelassociados", "mass");
        $this->_container = "backend/container";
    }

    function index()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->load->model("adm/Modelcomissoes","mcom");
            $this->load->library("table");
            $this->load->library("data");
            $mes = $this->input->post('mes')?$this->input->post('mes'):date('m');
            $ano = $this->input->post('ano')?$this->input->post('ano'):date('Y');
            if(($comissoes = $this->mcom->getComissao('','', true, $ano, $mes)) !== FALSE):
            $this->_template();
            $this->table->set_heading("Associado", "Valor", "Pago", "A&ccedil;&atilde;o");
              foreach($comissoes->result() as $comissao):
                $this->table->add_row($comissao->associado." <strong>[$comissao->codigo]</strong>", $comissao->valor, $comissao->pago=="S"?"Sim":"Não", $comissao->pago=="N"?anchor("adm/bonus/pagar/$comissao->codigo/true", "Confirmar todos pagamentos"):"");
              endforeach;
            else:
              $this->table->add_row("nenhuma comiss&atilde;o!");
            endif;

            $dados['bonus'] = $this->table->generate();
            $dados['titulo'] = "B&ocirc;nus";
            $dados['pagina'] = "backend/associado/bonus";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        redirect("login");
      endif;
    }

    function binario(){
        $dados['titulo'] = "Relatório de bônus binário";
        $dados['pagina'] = "themes/backend/relatorios/bonus/binario";
        $this->load->vars($dados);
        $this->load->view($this->_container);
    }

    function unilevel(){
        if($this->dx_auth->is_logged_in()):
            $dados['pagina'] = "themes/backend/relatorios/bonus/unilevel";
            $dados['titulo'] = 'Bônus Unilevel';

            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }

    function origemUnilevel()
    {
        if($this->dx_auth->is_logged_in()):
            $dados['titulo'] = "Origem do Unilevel";
            $dados['pagina'] = "themes/backend/relatorios/bonus/origemUnilevel";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }

    function capacitacao(){


    }

    function cash(){

    }

    function click(){

    }

    function distribuidor(){

    }

    function executivo(){

    }

    function lideranca(){

    }

    function linear(){

    }

    function palestrantes(){

    }

    function planos(){

    }

    function revendedor(){

    }

    function detalhado()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("admin")):
            $this->load->model("adm/Modelcomissoes","mcom");
            $this->load->library("table");
            $this->load->library("data");
            $mes = $this->input->post('mes')?$this->input->post('mes'):date('m');
            $ano = $this->input->post('ano')?$this->input->post('ano'):date('Y');
            if(($comissoes = $this->mcom->getComissao('','', false, $ano, $mes)) !== FALSE):
            $this->_template();
            $this->table->set_heading("Associado" ,"Indicado","Valor","Tipo","Descri&ccedil;&atilde;o","Pago","Data Processamento/pagamento","A&ccedil;&atilde;o");
              foreach($comissoes->result() as $comissao):
                $this->table->add_row($comissao->associado, $comissao->indicado, $comissao->valor, $comissao->tipo, $comissao->descricao, $comissao->pago=="S"?"Sim":"N&atilde;o", $this->data->mysql_to_human($comissao->data), $comissao->pago=="N"?anchor("adm/bonus/pagar/$comissao->cid", "Confirmar pagamento"):"");
              endforeach;
            else:
              $this->table->add_row("nenhuma comiss&atilde;o!");
            endif;

            $dados['bonus'] = $this->table->generate();
            $dados['titulo'] = "B&ocirc;nus";
            $dados['pagina'] = "backend/associado/bonus";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      endif;
    }

    function _template()
    {
        $tpl = array(
                    'table_open'=>'<table border="0" cellpadding="4" cellspacing="0" class="tablesorter">',
                    'heading_cell_start'=>'<th class="header">',
                    'row_start'=>'<tr class="even">',
                    'row_alt_start'=>'<tr class="odd">'
                    );

        $this->table->set_template($tpl);

    }

    function pagar($codigo, $resumido=false)
    {
        $obj = array('pago'=>'S');
        if($resumido==true):
          //caso o usuario confirme o pagamento no extrato resumido
          //o codigo fornecido sera o do associado, caso contrario,
          //sera o codigo da comissao
          $this->mcom->update('', $obj, $codigo);
        else:
          $this->mcom->update($codigo, $obj);
        endif;
        redirect("adm/bonus");
    }
}
?>
