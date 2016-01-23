<?php
/*****************************************************
* 	Autor - Vinícius Hósken - vinhosram@gmail.com	 *
*													 *
*	script de gerenciamento do escritorio virtual	 *
*													 *
*													 *
*													 *
*													 *
******************************************************/

class Financeiro extends CI_Controller {

    var $total = 0;
	var $countR = 0;

    function __construct(){
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

	function _getNomeAssociado(){
              $dados = word_limiter($this->mrede->getField(
			  														$this->mass->getTpCadastro($this->dx_auth->get_associado_id())===TRUE?
																	'nome_completo':'nome_fantasia', 
																	$this->dx_auth->get_associado_id(), 
																	TRUE), 
											    1,
												"");
			  return $dados;											
		}

    function index(){
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("user")):
            $dados['titulo'] = "Escrit&oacute;rio Virtual";
            $dados['pagina'] = "backend/associado/principal";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        redirect('login');
      endif;
    }

    public function  solicitarsaque()
    {
        if($this->dx_auth->is_logged_in()):

            $dados['pagina'] = "themes/backend/empresarios/financeiro/solicitarsaque";
            $dados['titulo'] = 'Solicitações de Saque';


            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);

        else:
            $this->general->redirect('login');
        endif;
    }

    public function  extrato(){
        if($this->dx_auth->is_logged_in()):
            $dados['page_js_foot'] = "extrato";
            $dados['page_style'] = 'extrato';
            $dados['pagina'] = "themes/backend/empresarios/financeiro/extrato";
            $dados['titulo'] = 'Extrato';

            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }

    public function  salvasolicitarsaque()
    {
        if($this->dx_auth->is_logged_in()):

            // Implementar arquivo

            $assoc =  $_POST['assoc'];
            $valor = $_POST['valor'];

            $source = array('.', ',');
            $replace = array('', '.');
            $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto


            // Total Saldo
            $consulta  = " select ass_saldo.valor  as TotalSaldo from ass_saldo  where ass_saldo.aid = '$assoc' ";
            $sqlSaldo = mysql_query($consulta) or die (mysql_error());

            if(mysql_num_rows($sqlSaldo)>0)
            {
                $l = mysql_fetch_array($sqlSaldo);
                $TotalSaldo = $l['TotalSaldo'];
            }else
            {
                $TotalSaldo = 0;
            }

            // Total Saldo ass_deposito
            $consulta  = "  select sum(valor)  as TotalPendente from get_solicitar_saque
            where get_solicitar_saque.aid = '$assoc'
            and get_solicitar_saque.`Status` != 'Concluído'
             and get_solicitar_saque.`Status` != 'Cancelado'  ";
            $sqlSaldo = mysql_query($consulta) or die (mysql_error());

            if(mysql_num_rows($sqlSaldo)>0)
            {
                $l = mysql_fetch_array($sqlSaldo);
                $TotalPendente = $l['TotalPendente'];
            }else
            {
                $TotalPendente = 0;
            }

            $TotalSaldoGeral = $TotalSaldo-$TotalPendente;

            if(trim($valor)=="")
            {
                $this->session->set_flashdata('mensagem_erro','Campo valor obrigatório.');
                $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
            }
            else
            {
                // Verifica Saque Semanal

                // Descobre número da semana data atual
                $date = date('Y-m-d');
                $duedt = explode("-", $date);
                $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
                $week  = (int)date('W', $date);

                $anoAtual = date('Y');


                $sqlSaqueSemanal  = "  select *
                      from  get_solicitar_saque
                      where YEAR(get_solicitar_saque.data_solicitacao)='$anoAtual'
                      and get_solicitar_saque.numero_semana ='$week'
                      and Status !='Cancelado'
                      and aid = '$assoc' ";


                echo $sqlSaqueSemanal;

                $sqlSaqueSemanal = mysql_query($sqlSaqueSemanal) or die (mysql_error());

                if(mysql_num_rows($sqlSaqueSemanal)>0)
                {
                    $erroNumeroSemana = 1;
                }else {
                    $erroNumeroSemana = 0;
                }

                if(($valor<=$TotalSaldoGeral) and ($valor>0) and ($valor>=100)  and ($erroNumeroSemana==0))
                {
                    // Descobre o NÃºmero da semana
                    $date = date('y-m-d');
                    $duedt = explode("-", $date);
                    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
                    $week  = (int)date('W', $date);
                    //  echo "NÃºmero da semana: " . $week;

                    // Gera solicitacao de deposito
                    $q = "INSERT INTO ass_solicitacao_deposito
					SET aid = '".$assoc."', stid='2', fid = NULL, valor = '".$valor."', data_solicitacao = now(),
					 numero_semana ='".$week."',  data_deposito = NULL, num_documento = NULL, bloqueado = 'N'";
                    $d = mysql_query($q);
                    $_sdid = mysql_insert_id();

                    // Gera detalhamento da transacao
                    // stid == 1 - Iniciado
                    $q = "INSERT INTO transacao_deposito
					SET sdid = '".$_sdid."', stid = '2', data = now(), detalhes = NULL";
                    $d = mysql_query($q);

                    $this->session->set_flashdata('mensagem_sucesso','Transação efetuada com sucesso.');
                    $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                }
                else
                {

                    $this->session->set_flashdata('mensagem_erro','Saque não permitido.   ');
                    $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                }
            }
        else:
            $this->general->redirect('login');
        endif;
    }

    public function  gerenciarsaque()
    {
        if($this->dx_auth->is_logged_in()):

            $dados['pagina'] = "themes/backend/empresarios/rede/gerenciarsaque";
            $dados['titulo'] = 'Gerenciar Saque';


            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);

        else:
            $this->general->redirect('login');
        endif;
    }

    public function exibirsaque()
    {
        if($this->dx_auth->is_logged_in()):

            $dados['pagina'] = "themes/backend/empresarios/rede/exibirsaque";
            $dados['titulo'] = 'Gerenciar Saque';


            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);

        else:
            $this->general->redirect('login');
        endif;

    }

}

/* End of file financeiro.php */
/* Location: ./system/application/controllers/escritorio-virtual/financeiro.php */
