<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relatorios extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library("DX_Auth");
        $this->load->library("general");
        $this->load->model("adm/Modelcomissoes", "mcom");
        $data['backend'] = 'admin';
        $this->load->vars($data);
        $this->_container = "backend/container";
    }



    function indicadores()
    {
        if($this->dx_auth->is_logged_in()):
           
            $dados['page_plugin'] = 'graficos';
            $dados['pagina'] = 'themes/backend/relatorios/indicadores';
          
            $dados['titulo'] = "Indicadores ";

            $dados['page_js_foot'] = 'funcoes';

            //$codigo = $this->dx_auth->get_associado_id();
			
			$sql = $this->db->query(" select * from indicadores");
			
			
			$ultra_sql_prefixo = ' select temp2.iid, i.descricao, temp2.Total, i.scriptDetalhes from ( ';
			$ultra_sql = '';
			foreach($sql->result_array() as $lin):
				if ($ultra_sql==''){
					$ultra_sql .= $lin['script'];
				} else {
					$ultra_sql .= ' union '.$lin['script'];
				}
			endforeach;

			$ultra_sql = $ultra_sql_prefixo.$ultra_sql;
			$ultra_sql .= ' ) temp2 inner join indicadores i on i.iid = temp2.iid order by temp2.Total desc, i.descricao';
			
			$dados['ultra_sql'] = $ultra_sql;
			

            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }
    
    function logs()
    {
        if($this->dx_auth->is_logged_in()):
           
            $dados['page_plugin'] = 'graficos';
            $dados['pagina'] = 'themes/backend/relatorios/logs';
          
            $dados['titulo'] = "Logs ";

            $dados['page_js_foot'] = 'funcoes';

            $codigo = $this->dx_auth->get_associado_id();

        
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }


    function index()
    {
    }

    function bonus($bonus){
        $this->$bonus();
    }

    function binario(){
        if($this->dx_auth->is_logged_in()):
            $dados['titulo'] = "Relatório de bônus binário";
            $dados['pagina'] = "themes/backend/relatorios/bonus/binario";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
    }

    function detalhesIndicadores($iid)
    {
        if($this->dx_auth->is_logged_in()):
			
			//$iid = $this->input->get("indicador");
			$sql = "select * from indicadores where iid = '$iid'";

			$titulo = '';
			$consulta = $this->db->query($sql);
			if($consulta->num_rows() > 0){
				$l = $consulta->row_array();
				$titulo = $l['descricao'];
				$scriptDetalhes = $l['scriptDetalhes'];
			}
			$dados['scriptDetalhes'] = $scriptDetalhes;
		
		
            $dados['titulo'] = "Detalhes do Indicador";
            $dados['pagina'] = "themes/backend/relatorios/detalhesIndicadores";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Método para exibição do bônus capacitação
     *
     * Exibição de todos os indicados diretos do usuário autenticado com os
     * respectivos valores à receber de cada um e a totalização
     *
     * @param integer $aid
     */

    function capacitacao($aid){
        if($this->dx_auth->is_logged_in()):
            $dados['titulo'] = "Relatório de bônus capacitação";
            $dados['pagina'] = "themes/backend/relatorios/bonus/capacitacao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
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

    function unilevel(){

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
