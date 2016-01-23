<?php
/*****************************************************
* 	Autor - Ramires Teixeira - ramirest@gmail.com	 *
*													 *
*	script de gerenciamento do escritorio virtual	 *
*													 *
*													 *
*													 *
*													 *
******************************************************/


class Rede extends CI_Controller {

    var $total = 0;
    var $ativos = 0;
    var $inativos = 0;
    var $pendentes = 0;
	var $dados;
	var $redeE;
	var $redeD;
	var $countR = 0;
	var $usuario;

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

    public function solicitarsaque()
    {
        if($this->dx_auth->is_logged_in()):

            $Codigo = $this->dx_auth->get_associado_id();
            $dados['Codigo'] = $Codigo;
            $origem = $this->dx_auth->get_fundo_origem();
			
			// Total Saldo
			if($origem !== FALSE)
				$tabela_saldo = "ass_saldo_membro";
			else
				$tabela_saldo = "ass_saldo";

			$consulta  = "select valor  as TotalSaldo from $tabela_saldo where aid = $Codigo";
			$sqlSaldo = $this->db->query($consulta);

			if($sqlSaldo->num_rows() > 0):
				$l = $sqlSaldo->result_array();
				$TotalSaldo = $l['TotalSaldo'];
			else:
				$TotalSaldo = 0;
			endif;
			$dados['TotalSaldo'] = $TotalSaldo;


			// Total Saldo ass_deposito
			$consulta  = "  select sum(valor)  as TotalPendente from get_solicitar_saque
					  where get_solicitar_saque.aid = '$Codigo'
					  and get_solicitar_saque.`Status` != 'Concluído'
					  and get_solicitar_saque.`Status` != 'Cancelado'  ";
			$sqlSaldo = $this->db->query($consulta);

			if($sqlSaldo->num_rows() > 0):
				$l = $sqlSaldo->result_array();
				$TotalPendente = $l['TotalPendente'];
			else:
				$TotalPendente = 0;
			endif;
			$dados['TotalPendente'] = $TotalPendente;
			
			
			
			
            $dados['pagina'] = "themes/backend/empresarios/rede/solicitarsaque";
            $dados['titulo'] = 'Solicitações de Saque';
			
			
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

            if(($fundo = $this->mass->getFundo($assoc)) !== FALSE)
                $origem = $fundo->fid;
            else
                $origem = FALSE;

            if($origem)
                $tabela_saldo = "ass_saldo_membro";
            else
                $tabela_saldo = "ass_saldo";
            // Total Saldo
            $consulta  = " select valor  as TotalSaldo from $tabela_saldo  where aid = '$assoc' ";
            $sqlSaldo = $this->db->query($consulta);

            if($sqlSaldo->num_rows() > 0):
                $l = $sqlSaldo->result_array();
                $TotalSaldo = $l['TotalSaldo'];
            else:
                $TotalSaldo = 0;
            endif;

            // Total Saldo ass_deposito
            $consulta  = "  select sum(valor)  as TotalPendente from get_solicitar_saque
            where get_solicitar_saque.aid = '$assoc'
            and get_solicitar_saque.`Status` != 'Concluído'
             and get_solicitar_saque.`Status` != 'Cancelado'  ";
            $sqlSaldo = $this->db->query($consulta);

            if($sqlSaldo->num_rows() > 0):
                $l = $sqlSaldo->result_array();
                $TotalPendente = $l['TotalPendente'];
            else:
                $TotalPendente = 0;
            endif;

            $TotalSaldoGeral = $TotalSaldo-$TotalPendente;

            if(trim($valor)==""):
                $this->session->set_flashdata('mensagem_erro','Campo valor obrigatório.');
                $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
            else:

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


                $sqlSaqueSemanal = $this->db->query($sqlSaqueSemanal);

                if($sqlSaqueSemanal->num_rows() > 0)
                    $erroNumeroSemana = 1;
                else
                    $erroNumeroSemana = 0;

                if(($valor<=$TotalSaldoGeral) and ($valor>0) and ($valor>=100)  and ($erroNumeroSemana==0)):
                    // Descobre o NÃºmero da semana
                    $date = date('y-m-d');
                    $duedt = explode("-", $date);
                    $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
                    $week  = (int)date('W', $date);
                    //  echo "NÃºmero da semana: " . $week;

                    if(($solicitacao = $this->mrede->verificaSolicitacaoSaque($assoc)) !== FALSE):

                        //verifica se associado está com o binário ativo
                        if(($solicitacao->total_direita == 0) || ($solicitacao->total_esquerda == 0)):
                            $this->session->set_flashdata('mensagem_erro','Saque não permitido. <br>Motivo: Você precisa ativar seu binário para fazer sua solicitação de saque.');
                            $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                        elseif($solicitacao->pis_pasep == 0):
                            $this->session->set_flashdata('mensagem_erro','Saque não permitido. <br>Motivo: Você precisa informar o número do seu pis/pasep para fazer a solicitação de saque.');
                            $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                        else:
                            $msg1 = "";
                            $msg2 = "";
                            if($solicitacao->total_dependentes == 0)
                                $msg1 = "<br>Você não cadastrou nenhum dependente, caso tenha esquecido, por favor ".anchor("escritorio-virtual/empresarios/editar/dependentes/$assoc", "cadastre agora.");
                            if($solicitacao->total_contas == 0)
                                $msg2 = "<br>Você ainda não cadastrou sua conta bancária, por favor ".anchor("escritorio-virtual/empresarios/editar/banco/$assoc", "cadastre-a aqui")." ou sua solicitação será cancelada.";

                            $paramInss = $this->mrede->buscaParametrosInss();
                            //Total já pago ao associado no mês vigente
                            $valor_pago = $solicitacao->valor_pago;
                            //Para calcular o inss e irrf será utilizado o montante que o associado já recebeu no mês
                            //vigente acrescido do valor que está sendo solicitado no momento
                            $valor_calculo = $valor;

                            $inss = $this->calculaInss($valor_calculo, $paramInss, $solicitacao->inss_pago);

                            $irrf_pagar = $this->calculaIrrf($valor_calculo, $paramInss, $inss, $solicitacao->total_dependentes);

                            $valor_taxa = $this->config->item('taxa_saque');

                            //verificar
                            $valor_final = $valor - $inss - $irrf_pagar - $valor_taxa;


                            // Gera solicitacao de deposito
                            $q = "INSERT INTO ass_solicitacao_deposito
                                  SET aid = '".$assoc."',
                                      stid='2',
                                      fid = NULL,
                                      valor = '".$valor_final."',
                                      valor_taxa = '".$valor_taxa."',
                                      valor_inss = '".$inss."',
                                      valor_ir = '".$irrf_pagar."',
                                      data_solicitacao = now(),
                                      numero_semana ='".$week."',
                                      data_deposito = NULL,
                                      num_documento = NULL,
                                      bloqueado = 'N'";
                            $d = $this->db->query($q);
                            $_sdid = $this->db->insert_id();

                            // Gera detalhamento da transacao
                            // stid == 1 - Iniciado
                            $q = "INSERT INTO transacao_deposito
                            SET sdid = '".$_sdid."', stid = '2', data = now(), detalhes = NULL";
                            $d = $this->db->query($q);

                            $this->session->set_flashdata('mensagem_sucesso',"Solicitação efetuada com sucesso.$msg1.$msg2");
                            $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                        endif;
                    else:
                        $this->session->set_flashdata('mensagem_erro','Transação não efetuada por não atender ao requisitos básicos de saque.');
                        $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                    endif;

                else:

                    $this->session->set_flashdata('mensagem_erro','Transação não efetuada por não atender a um ou mais requisitos para solicitação.');
                    $this->general->redirect("escritorio-virtual/rede/solicitarsaque/".$assoc."");
                endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function calculaInss($valor, $paramInss, $inss_pago)
    {
        //obtém informações do valor do teto do inss vigente
        $tetoINSS = $paramInss->teto_inss;
        //obtém informações do total do valor pago de inss até o momento no mês atual
        $valorINSSJaPago = $inss_pago;
        //calcula o valor do inss na operação atual
        $valorINSSAtual = $valor * $paramInss->percentual_inss;


        // Verifica se o valor teto do inss já foi recolhido, nesse caso, não será necessário
        // subtrair esse valor da solicitação do usuário
        if(($valorINSSAtual + $valorINSSJaPago) >= $tetoINSS):
            $inss = 0;
        else:
            //Verifica o valor que ainda precisa ser recolhido do usuário
            $valorRecolhimento = $tetoINSS - $valorINSSJaPago;

            // Verifica se o valor a ser recolhido é menor ou igual ao valor calculado para
            // a operação atual, nesse caso, esse valor será recolhido, do contrário, será
            // recolhido apenas o valor calculado
            if ($valorRecolhimento <= $valorINSSAtual):
                $inss = $valorRecolhimento;
            else:
                //abate o valor já pago anteriormente e recolhe apenas o valor devido
                $inss = $valorINSSAtual;
            endif;
        endif;

        return $inss;
    }


    function calculaIrrf($valor, $paramInss, $inss, $total_dependentes)
    {
        //Calcula valor a deduzir com dependentes
        $deducaoDependente = $paramInss->valor_dependente * $total_dependentes;
        //define a base de cálculo
        $base_calculo = $valor - $inss - $deducaoDependente;
        //Busca os parâmetros do IRRF e verifica se há valor a recolher do irrf
        $paramIrrf = $this->mrede->buscaParametrosIrrf($base_calculo);

        if($paramIrrf->aliquota > 0):
            //Calcula valor do IRRF
            $valor_irrf = $base_calculo * $paramIrrf->aliquota;
            //IRRF a pagar
            $irrf_pagar = $valor_irrf - $paramIrrf->parcela_deduzir;
        else:
            $irrf_pagar = 0;
        endif;

        return $irrf_pagar;
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

    function patrocinador()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("user")):
            $this->load->library("table");
            $this->table->set_heading("#", "Nome");
            if(($down = $this->musu->getPatrocinador($this->dx_auth->get_username())) !== FALSE):
                foreach($down->result() as $u):
                  $this->table->add_row("Patrocinador Direto", $u->nome_completo);;
                endforeach;
            endif;
            $dados['uplines'] = $this->table->generate();

            $dados['titulo'] = "Uplines";
            $dados['pagina'] = "themes/backend/empresarios/rede/uplines";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      endif;
    }

    function linear($status = "T"){
        if($this->dx_auth->is_logged_in()):
            $dados['titulo'] = 'Rede Linear';
            $dados['page_js_foot'] = "tables";
            //verifica se o usuário tem privilégios administrativos
            if($this->dx_auth->is_role(array("admin","root"))):
                //retorna os empresários com o status selecionado, ou caso contrário, exibe todos
                if(($dados['associados'] = $this->mass->getAssociado('','status', $status)) !== false):
                    $pass = TRUE;
                else:
                    $pass = FALSE;
                endif;
            elseif($this->dx_auth->is_role("user")):
                //retorna os empresários cujo o patrocinador seja o usuário logado
                if(($dados['associados'] = $this->mass->getAssociado('','patrocinador', $this->dx_auth->get_associado_id())) !== false):
                    $pass = TRUE;
                else:
                    $pass = FALSE;
                endif;
            endif;

            $dados['cadastros_semana'] = $this->mass->getCadastros('semana')->qtde;
            $dados['cadastros_mes'] = $this->mass->getCadastros('mes')->qtde;

            //verifica se existe registros a serem exibidos na página
            if($pass === TRUE)
                $dados['pagina'] = 'themes/backend/empresarios/rede/linear';
            else
                $dados['conteudo'] = 'Nenhum associado nessa categoria';

            $this->load->vars($dados);
            $this->load->view($this->_container);

        else:
            $this->general->redirect('login');
        endif;
    }
    
    /**
     * Exibição da rede unilevel
     * 
     * 
     * @param integer $aid
     * @return array
     */
    
    function unilevel($aid){
		if ($this->dx_auth->is_logged_in ()) :
            //Verifica se o código do empresário informado via get é o código do empresário logado,
            //do contrário não permite a visualização da rede unilevel
			if ($aid && ($this->dx_auth->get_associado_id() == $aid)) :
				
				$deep = $this->config->item('profundidade_unilevel');
				$rede = array();

                $this->mrede->getUnilevel($aid, $deep, 1, $rede);
                $dados['associados'] = $rede;

                $dados['titulo'] = "Rede Unilevel";
                $dados['page_style'] = "rede";
                $dados['page_js_foot'] = "rede";
                $dados['pagina'] = "themes/backend/empresarios/rede/unilevel";
                $this->load->vars($dados);
                $this->load->view($this->_container);

			else :
				$this->general->redirect ('escritorio-virtual/dashboard');
			endif;
		 else :
			redirect ( "login" );
		endif;
    	     	
    }

    /**
     * Exibição da rede binária
     *
     *      Exibe as redes de forma automatica, sendo que estas são	geradas
     *		à partir do cadastro do usuario:
     *		Na configuração do usuario é possível configurar se os novos cadastros
     *		entrarão de forma automática na rede ou se estes devem entrar em uma ou outra.
     *
     *		Geração Automática
     *
     *		O sistema verifica as duas redes do usuário (D e E) e na rede em que
     *		houver o menor número de pontos o sistema irá inserir o novo usuário.
     *		Havendo igualdade na quantidade de pontos, o sistema irá inserir
     *		na rede que houver o menor número de usuários.
     *
     *		Definição da rede
     *
     *		Nesta opção o usuário deverá escolher entre as duas redes (D e E) e após definido,
     *		todos os novos cadastros serão direcionados para esta.
     *
     *
     *  @access private
     *  @param $aid Codigo do associado
     *	@param $rede Rede direita ou esquerda
     *  @return string
  	 */
    
    function binario($aid = "")
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role(array("user","admin","root"))):

			if($aid):
					$qtde_re = 0;
					$qtde_rd = 0;
					$this->mass->_conta_rede($aid, 'E', $qtde_re);
					$this->mass->_conta_rede($aid, 'D', $qtde_rd);
					$minha_rede = array();
					$this->mass->_getMinhaRede($this->dx_auth->get_associado_id(), $minha_rede);
				if(array_key_exists($aid, $minha_rede) || ($this->dx_auth->get_associado_id() == $aid)):
					$dados['html'] = $this->html_arvore($aid);
					$inicio = $this->dx_auth->get_associado_id();
					$dados['inicio'] = anchor("escritorio-virtual/rede/binario/$inicio", "INÍCIO", 'class="btn btn-block btn_viwer_num_cad btn_cad01"');
					$dados['rede_esquerda'] = $qtde_re;
					$dados['rede_direita'] = $qtde_rd;
                    $dados['pontos_esquerda'] = $this->mass->conta_pontos_binario($aid, 'E');
                    $dados['pontos_direita'] = $this->mass->conta_pontos_binario($aid, 'D');

					//$dados['voltar'] = !is_null($this->anterior)?anchor("escritorio-virtual/rede/binario/$this->anterior", "««VOLTAR", 'class="but_voltar"'):anchor("", "««VOLTAR", 'class="but_voltar"');

                    //resumo
                    $html = <<<HTML
                    <div class="list-group" style="max-width: 227px;">
                    <a href="#" class="list-group-item rededts">Total de usuários:<span class="badge green rededt" style="">{$this->total}</span></a>
                    <a href="#" class="list-group-item rededts">Usuários Ativos:<span class="badge orange rededt" style="">{$this->ativos}</span></a>
                    <a href="#" class="list-group-item rededts">Usuários Inativos:<span class="badge blue rededt" style=" background-color: #979797;">{$this->inativos}</span></a>
                    <a href="#" class="list-group-item rededts">Usuários Pendentes:	<span class="badge blue rededt" style="background-color: #DF5050; ">{$this->pendentes}</span></a>
                    </div>
HTML;
                    //montagem da rede linear
                    $dados['rede'] = $html;

                 /*   $this->table->add_row("Total de usu&aacute;rios:", $this->total);
					$this->table->add_row("Usu&aacute;rios Ativos:", $this->ativos);
					$this->table->add_row("Usu&aacute;rios Inativos:", $this->inativos);
					$this->table->add_row("Usu&aacute;rios Pendentes:", $this->pendentes);

					//montagem da rede linear
					$dados['rede'] = $this->table->generate();
*/

					$dados['titulo'] = "Rede Binária";
					$dados['page_style'] = "rede";
					$dados['page_js_foot'] = "rede";
					$dados['pagina'] = "themes/backend/empresarios/rede/binario";
					$this->load->vars($dados);
					$this->load->view($this->_container);
 				else:
                    $this->general->redirect ('escritorio-virtual/dashboard');
				endif;
 			else:
                $this->general->redirect ('escritorio-virtual/dashboard');
			endif;
        else:
            //Exibe mensagem ao usuário de acesso não autorizado
            $dados['titulo'] = "Acesso não autorizado";
            $dados['pagina'] = "themes/backend/messages/sem_permissao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        $this->general->redirect("login");
      endif;
    }

    /**
     * 
     * @param integer $patrocinador
     * @param integer $upline
     * @return boolean
     */

	private function is_derramamento($patrocinador, $upline)
	{
		if($patrocinador == $upline)
			return FALSE;
		else
			return TRUE;
	}
	
	/**
	 * 
	 * @param integer $aid
	 * @param string $nivel
	 * @param string $rede
	 * @return array
	 */

	private function _monta_rede($aid, $nivel, $rede = "")
	{
		${"empE$nivel"} = NULL;
		${"empD$nivel"} = NULL;
		if(!empty($aid) && (($a = $this->mrede->arvore($aid)) !== FALSE)):
			switch($a->num_rows()):
				case 1:
					$r = $a->row();
					$patrocinador = array('nome'=>$r->nome1, 'graduacao'=>$r->graduacao1, 'status'=>$this->_status($r->status1, $r->valor_plano1));
					if(!is_null($r->aid2)):
						if($nivel == 1)
							$rede = $this->_rede($r->rede2);
						//	aloca o empresário à esquerda ou à direita baseado em algumas regras:
						//	Se o patrocinador for o mesmo que o upline, então a posição do empresário
						//	obedecerá o campo "rede", caso contrário, se o patrocinador for diferente
						//	este empresário será alocado na linha de derramamento* do usuário em questão
						//
						//	Será considerado linha de derramamento o lado esquerdo da rede esquerda
						//	e o lado direito da rede direita

						if($this->is_derramamento($r->pat_id2, $r->aid1) === FALSE):
							${"emp$r->rede2$nivel"} = array(
														 'vazio'=>FALSE,
														 'nome'=>$r->nome2,
														 'aid'=>$r->aid2,
														 'graduacao'=>$r->graduacao2,
														 'status'=>$this->_status($r->status2, $r->valor_plano2),
														 'patrocinador'=>$r->patrocinador2,
														 'nivel'=>$nivel);
							if($r->rede2 == 'D')
								${"empE$nivel"} = NULL;
							else
								${"empD$nivel"} = NULL;
						else:
							${"emp$r->rede2$nivel"} = array(
														 'vazio'=>FALSE,
														 'nome'=>$r->nome2,
														 'aid'=>$r->aid2,
														 'graduacao'=>$r->graduacao2,
														 'status'=>$this->_status($r->status2, $r->valor_plano2),
														 'patrocinador'=>$r->patrocinador2,
														 'nivel'=>$nivel);
						endif;
						if(isset(${"empE$nivel"}) && ${"empE$nivel"} == NULL):
							${"empE$nivel"} = array('vazio'=>TRUE);
						elseif(isset(${"empD$nivel"}) &&  ${"empD$nivel"} == NULL):
							${"empD$nivel"} = array('vazio'=>TRUE);
						endif;
					else:
						${"empD$nivel"} = array('vazio'=>TRUE);
						${"empE$nivel"} = array('vazio'=>TRUE);
					endif;
					break;
				case 2:
					$fr = $a->first_row();
					if($nivel == 1)
						$rede = $this->_rede($fr->rede2);
					$patrocinador = array('nome'=>$fr->nome1, 'graduacao'=>$fr->graduacao1, 'status'=>$this->_status($fr->status1, $fr->valor_plano1));

					${"emp$fr->rede2$nivel"} = array(
												 'vazio'=>FALSE,
												 'nome'=>$fr->nome2,
												 'aid'=>$fr->aid2,
												 'graduacao'=>$fr->graduacao2,
												 'status'=>$this->_status($fr->status2, $fr->valor_plano2),
												 'patrocinador'=>$fr->patrocinador2,
												 'nivel'=>$nivel);
					$lr = $a->last_row();
					if($nivel == 1)
						$rede = $this->_rede($lr->rede2);

					${"emp$lr->rede2$nivel"} = array(
												 'vazio'=>FALSE,
												 'nome'=>$lr->nome2,
												 'aid'=>$lr->aid2,
												 'graduacao'=>$lr->graduacao2,
												 'status'=>$this->_status($lr->status2, $lr->valor_plano2),
												 'patrocinador'=>$lr->patrocinador2,
												 'nivel'=>$nivel);
					break;
			endswitch;
		else:
			${"empD$nivel"} = array('vazio'=>TRUE);
			${"empE$nivel"} = array('vazio'=>TRUE);
		endif;

		if($nivel == 1)
		  $ret = array('patrocinador'=>$patrocinador, "empD$nivel"=>${"empD$nivel"}, "empE$nivel"=>${"empE$nivel"});
		else
		  $ret = array("empD$nivel"=>${"empD$nivel"}, "empE$nivel"=>${"empE$nivel"});

		return $ret;
	}

var $anterior;

	function html_arvore($aid)
	{
        $img_url = $this->config->item('img');

        //retorna o resultado do nível 1 (patrocinador e dois empresários)
		$nivel1 = $this->_monta_rede($aid, 1);
		$patrocinador = $this->_elements($nivel1['patrocinador']['nome'], $nivel1['patrocinador']['graduacao'], "", $nivel1['patrocinador']['status']);
		
		//monta html do nível 1
		if($nivel1['empE1']['vazio'] === FALSE):
			$ic01e = $this->_elements($nivel1['empE1']['nome'], $nivel1['empE1']['graduacao'], $nivel1['empE1']['nivel'], $nivel1['empE1']['status'], $nivel1['empE1']['aid']);
			
			//retorna o resultado do nível 2 (quatro empresários), dois em cada resultado
			$nivel2e = $this->_monta_rede($nivel1['empE1']['aid'], 2, 'e');	
		
			//monta o html do nível 2, 1 empresário em cada posição do nível
			if($nivel2e['empE2']['vazio'] === FALSE):
				$ic02ea = $this->_elements($nivel2e['empE2']['nome'], $nivel2e['empE2']['graduacao'], $nivel2e['empE2']['nivel'], $nivel2e['empE2']['status'], $nivel2e['empE2']['aid']);
		
				//retorna o resultado do nível 3 (oito empresários), dois em cada resultado
				$nivel3ea = $this->_monta_rede($nivel2e['empE2']['aid'], 3, 'e');
			
				//monta o html do nível 3, 1 empresário em cada posição do nível, totalizando os oito
				if($nivel3ea['empE3']['vazio'] === FALSE):
					$ic03ea = $this->_elements($nivel3ea['empE3']['nome'], $nivel3ea['empE3']['graduacao'], $nivel3ea['empE3']['nivel'], $nivel3ea['empE3']['status'], $nivel3ea['empE3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4ea = $this->_monta_rede($nivel3ea['empE3']['aid'], 4, 'e');	
		
					//monta o html do nível 4, 1 empresário em cada posição do nível, totalizando os dezesseis
					if($nivel4ea['empE4']['vazio'] === FALSE)
						$ic04ea = $this->_elements($nivel4ea['empE4']['nome'], $nivel4ea['empE4']['graduacao'], $nivel4ea['empE4']['nivel'], $nivel4ea['empE4']['status'], $nivel4ea['empE4']['aid']);
					else
						$ic04ea = $this->_posicao_vazia('e', 4);
					
					if($nivel4ea['empD4']['vazio'] === FALSE)
						$ic04da = $this->_elements($nivel4ea['empD4']['nome'], $nivel4ea['empD4']['graduacao'], $nivel4ea['empD4']['nivel'], $nivel4ea['empD4']['status'], $nivel4ea['empD4']['aid']);	
					else
						$ic04da = $this->_posicao_vazia('e', 4);
				else:
					$ic03ea = $this->_posicao_vazia('e', 3);
			
					$ic04ea = $this->_posicao_vazia('e', 4);
					$ic04da = $this->_posicao_vazia('e', 4);
				endif;
					
				if($nivel3ea['empD3']['vazio'] === FALSE):
					$ic03da = $this->_elements($nivel3ea['empD3']['nome'], $nivel3ea['empD3']['graduacao'], $nivel3ea['empD3']['nivel'], $nivel3ea['empD3']['status'], $nivel3ea['empD3']['aid']);	
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4da = $this->_monta_rede($nivel3ea['empD3']['aid'], 4, 'd');
		
					if($nivel4da['empD4']['vazio'] === FALSE)
						$ic04eb = $this->_elements($nivel4da['empE4']['nome'], $nivel4da['empE4']['graduacao'], $nivel4da['empE4']['nivel'], $nivel4da['empE4']['status'], $nivel4da['empE4']['aid']);
					else
						$ic04eb = $this->_posicao_vazia('e', 4);
					
					if($nivel4da['empD4']['vazio'] === FALSE)
						$ic04db = $this->_elements($nivel4da['empD4']['nome'], $nivel4da['empD4']['graduacao'], $nivel4da['empD4']['nivel'], $nivel4da['empD4']['status'], $nivel4da['empD4']['aid']);
					else
						$ic04db = $this->_posicao_vazia('e', 4);
				else:
					$ic03da	= $this->_posicao_vazia('e', 3);
					
					$ic04eb = $this->_posicao_vazia('e', 4);
					$ic04db = $this->_posicao_vazia('e', 4);
				endif;
			else:
				$ic02ea = $this->_posicao_vazia('e', 2);
		
				$ic03ea = $this->_posicao_vazia('e', 3);
				$ic03da	= $this->_posicao_vazia('e', 3);
		
				$ic04ea = $this->_posicao_vazia('e', 4);
				$ic04da = $this->_posicao_vazia('e', 4);
				
				$ic04eb = $this->_posicao_vazia('e', 4);
				$ic04db = $this->_posicao_vazia('e', 4);		
			endif;
				
			
			if($nivel2e['empD2']['vazio'] === FALSE):
				$ic02da = $this->_elements($nivel2e['empD2']['nome'], $nivel2e['empD2']['graduacao'], $nivel2e['empD2']['nivel'], $nivel2e['empD2']['status'], $nivel2e['empD2']['aid']);
		
				//retorna o resultado do nível 3 (oito empresários), dois em cada resultado
				$nivel3da = $this->_monta_rede($nivel2e['empD2']['aid'], 3, 'd');
		
				if($nivel3da['empE3']['vazio'] === FALSE):
					$ic03eb = $this->_elements($nivel3da['empE3']['nome'], $nivel3da['empE3']['graduacao'], $nivel3da['empE3']['nivel'], $nivel3da['empE3']['status'], $nivel3da['empE3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4eb = $this->_monta_rede($nivel3da['empE3']['aid'], 4, 'e');	
		
					if($nivel4eb['empE4']['vazio'] === FALSE)
						$ic04ec = $this->_elements($nivel4eb['empE4']['nome'], $nivel4eb['empE4']['graduacao'], $nivel4eb['empE4']['nivel'], $nivel4eb['empE4']['status'], $nivel4eb['empE4']['aid']);
					else
						$ic04ec = $this->_posicao_vazia('e', 4);
					
					if($nivel4eb['empD4']['vazio'] === FALSE)
						$ic04dc = $this->_elements($nivel4eb['empD4']['nome'], $nivel4eb['empD4']['graduacao'], $nivel4eb['empD4']['nivel'], $nivel4eb['empD4']['status'], $nivel4eb['empD4']['aid']);
					else
						$ic04dc = $this->_posicao_vazia('e', 4);
				else:
					$ic03eb	= $this->_posicao_vazia('e', 3);
					
					$ic04ec = $this->_posicao_vazia('e', 4);
					$ic04dc = $this->_posicao_vazia('e', 4);
				endif;
				
				if($nivel3da['empD3']['vazio'] === FALSE):
					$ic03db = $this->_elements($nivel3da['empD3']['nome'], $nivel3da['empD3']['graduacao'], $nivel3da['empD3']['nivel'], $nivel3da['empD3']['status'], $nivel3da['empD3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4db = $this->_monta_rede($nivel3da['empD3']['aid'], 4, 'd');
	
					if($nivel4db['empE4']['vazio'] === FALSE)
						$ic04ed = $this->_elements($nivel4db['empE4']['nome'], $nivel4db['empE4']['graduacao'], $nivel4db['empE4']['nivel'], $nivel4db['empE4']['status'], $nivel4db['empE4']['aid']);
					else
						$ic04ed = $this->_posicao_vazia('e', 4);
					
					if($nivel4db['empD4']['vazio'] === FALSE)
						$ic04dd = $this->_elements($nivel4db['empD4']['nome'], $nivel4db['empD4']['graduacao'], $nivel4db['empD4']['nivel'], $nivel4db['empD4']['status'], $nivel4db['empD4']['aid']);
					else
						$ic04dd = $this->_posicao_vazia('e', 4);
				else:
					$ic03db	= $this->_posicao_vazia('e', 3);
					
					$ic04ed = $this->_posicao_vazia('e', 4);
					$ic04dd = $this->_posicao_vazia('e', 4);
				endif;
			else:
				$ic02da = $this->_posicao_vazia('e', 2);
		
				$ic03eb	= $this->_posicao_vazia('e', 3);
				$ic03db	= $this->_posicao_vazia('e', 3);
		
				$ic04ec = $this->_posicao_vazia('e', 4);
				$ic04dc = $this->_posicao_vazia('e', 4);
				
				$ic04ed = $this->_posicao_vazia('e', 4);
				$ic04dd = $this->_posicao_vazia('e', 4);
		
			endif;
		else:
			$ic01e = $this->_posicao_vazia('e', 1);
			
			$ic02ea = $this->_posicao_vazia('e', 2);
			$ic02da = $this->_posicao_vazia('e', 2);
	
			$ic03ea = $this->_posicao_vazia('e', 3);
			$ic03da	= $this->_posicao_vazia('e', 3);
			$ic03eb	= $this->_posicao_vazia('e', 3);
			$ic03db	= $this->_posicao_vazia('e', 3);
	
			$ic04ea = $this->_posicao_vazia('e', 4);
			$ic04da = $this->_posicao_vazia('e', 4);
			
			$ic04eb = $this->_posicao_vazia('e', 4);
			$ic04db = $this->_posicao_vazia('e', 4);
			
			$ic04ec = $this->_posicao_vazia('e', 4);
			$ic04dc = $this->_posicao_vazia('e', 4);
			
			$ic04ed = $this->_posicao_vazia('e', 4);
			$ic04dd = $this->_posicao_vazia('e', 4);
		endif;
		
		if($nivel1['empD1']['vazio'] === FALSE):
			$ic01d = $this->_elements($nivel1['empD1']['nome'], $nivel1['empD1']['graduacao'], $nivel1['empD1']['nivel'], $nivel1['empD1']['status'], $nivel1['empD1']['aid']);
	
			//retorna o resultado do nível 2 (quatro empresários), dois em cada resultado
			$nivel2d = $this->_monta_rede($nivel1['empD1']['aid'], 2, 'd');
		
			if($nivel2d['empE2']['vazio'] === FALSE):
				$ic02eb = $this->_elements($nivel2d['empE2']['nome'], $nivel2d['empE2']['graduacao'], $nivel2d['empE2']['nivel'], $nivel2d['empE2']['status'], $nivel2d['empE2']['aid']);
		
				//retorna o resultado do nível 3 (oito empresários), dois em cada resultado
				$nivel3eb = $this->_monta_rede($nivel2d['empE2']['aid'], 3, 'e');	
			
				if($nivel3eb['empE3']['vazio'] === FALSE):
					$ic03ec = $this->_elements($nivel3eb['empE3']['nome'], $nivel3eb['empE3']['graduacao'], $nivel3eb['empE3']['nivel'], $nivel3eb['empE3']['status'], $nivel3eb['empE3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4ec = $this->_monta_rede($nivel3eb['empE3']['aid'], 4, 'e');	
			
					if($nivel4ec['empE4']['vazio'] === FALSE)
						$ic04ee = $this->_elements($nivel4ec['empE4']['nome'], $nivel4ec['empE4']['graduacao'], $nivel4ec['empE4']['nivel'], $nivel4ec['empE4']['status'], $nivel4ec['empE4']['aid']);
					else
						$ic04ee = $this->_posicao_vazia('d', 4);
					
					if($nivel4ec['empD4']['vazio'] === FALSE)	
						$ic04de = $this->_elements($nivel4ec['empD4']['nome'], $nivel4ec['empD4']['graduacao'], $nivel4ec['empD4']['nivel'], $nivel4ec['empD4']['status'], $nivel4ec['empD4']['aid']);	
					else
						$ic04de = $this->_posicao_vazia('d', 4);
				else:
					$ic03ec = $this->_posicao_vazia('d', 3);	
			
					$ic04ee = $this->_posicao_vazia('d', 4);
					$ic04de = $this->_posicao_vazia('d', 4);
				endif;
				
				if($nivel3eb['empD3']['vazio'] === FALSE):
					$ic03dc = $this->_elements($nivel3eb['empD3']['nome'], $nivel3eb['empD3']['graduacao'], $nivel3eb['empD3']['nivel'], $nivel3eb['empD3']['status'], $nivel3eb['empD3']['aid']);	
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4dc = $this->_monta_rede($nivel3eb['empD3']['aid'], 4, 'd');
			
					if($nivel4dc['empE4']['vazio'] === FALSE)
						$ic04ef = $this->_elements($nivel4dc['empE4']['nome'], $nivel4dc['empE4']['graduacao'], $nivel4dc['empE4']['nivel'], $nivel4dc['empE4']['status'], $nivel4dc['empE4']['aid']);
					else
						$ic04ef = $this->_posicao_vazia('d', 4);
					
					if($nivel4dc['empD4']['vazio'] === FALSE)
						$ic04df = $this->_elements($nivel4dc['empD4']['nome'], $nivel4dc['empD4']['graduacao'], $nivel4dc['empD4']['nivel'], $nivel4dc['empD4']['status'], $nivel4dc['empD4']['aid']);
					else
						$ic04df = $this->_posicao_vazia('d', 4);
				else:
					$ic03dc	= $this->_posicao_vazia('d', 3);	
			
					$ic04ef = $this->_posicao_vazia('d', 4);
					$ic04df = $this->_posicao_vazia('d', 4);
				endif;
			else:
				$ic02eb = $this->_posicao_vazia('d', 2); 
			
				$ic03ec = $this->_posicao_vazia('d', 3);	
				$ic03dc	= $this->_posicao_vazia('d', 3);	
			
				$ic04ee = $this->_posicao_vazia('d', 4);
				$ic04de = $this->_posicao_vazia('d', 4);
				
				$ic04ef = $this->_posicao_vazia('d', 4);
				$ic04df = $this->_posicao_vazia('d', 4);
			endif;	
			
			if($nivel2d['empD2']['vazio'] === FALSE):
				$ic02db = $this->_elements($nivel2d['empD2']['nome'], $nivel2d['empD2']['graduacao'], $nivel2d['empD2']['nivel'], $nivel2d['empD2']['status'], $nivel2d['empD2']['aid']);
		
				$nivel3db = $this->_monta_rede($nivel2d['empD2']['aid'], 3, 'd');	
		
				if($nivel3db['empE3']['vazio'] === FALSE):
					$ic03ed = $this->_elements($nivel3db['empE3']['nome'], $nivel3db['empE3']['graduacao'], $nivel3db['empE3']['nivel'], $nivel3db['empE3']['status'], $nivel3db['empE3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4ed = $this->_monta_rede($nivel3db['empE3']['aid'], 4, 'e');	
		
					if($nivel4ed['empE4']['vazio'] === FALSE)
						$ic04eg = $this->_elements($nivel4ed['empE4']['nome'], $nivel4ed['empE4']['graduacao'], $nivel4ed['empE4']['nivel'], $nivel4ed['empE4']['status'], $nivel4ed['empE4']['aid']);
					else
						$ic04eg = $this->_posicao_vazia('d', 4);
					
					if($nivel4ed['empD4']['vazio'] === FALSE)	
						$ic04dg = $this->_elements($nivel4ed['empD4']['nome'], $nivel4ed['empD4']['graduacao'], $nivel4ed['empD4']['nivel'], $nivel4ed['empD4']['status'], $nivel4ed['empD4']['aid']);	
					else
						$ic04dg = $this->_posicao_vazia('d', 4);
				else:
					$ic03ed	= $this->_posicao_vazia('d', 3);	
			
					$ic04eg = $this->_posicao_vazia('d', 4);
					$ic04dg = $this->_posicao_vazia('d', 4);
				endif;
				
				if($nivel3db['empD3']['vazio'] === FALSE):
					$ic03dd = $this->_elements($nivel3db['empD3']['nome'], $nivel3db['empD3']['graduacao'], $nivel3db['empD3']['nivel'], $nivel3db['empD3']['status'], $nivel3db['empD3']['aid']);
				
					//retorna o resultado do nível 4 (dezesseis empresários), dois em cada resultado
					$nivel4dd = $this->_monta_rede($nivel3db['empD3']['aid'], 4, 'd');
		
					if($nivel4dd['empE4']['vazio'] === FALSE)
						$ic04eh = $this->_elements($nivel4dd['empE4']['nome'], $nivel4dd['empE4']['graduacao'], $nivel4dd['empE4']['nivel'], $nivel4dd['empE4']['status'], $nivel4dd['empE4']['aid']);
					else
						$ic04eh = $this->_posicao_vazia('d', 4);
					
					if($nivel4dd['empD4']['vazio'] === FALSE)
						$ic04dh = $this->_elements($nivel4dd['empD4']['nome'], $nivel4dd['empD4']['graduacao'], $nivel4dd['empD4']['nivel'], $nivel4dd['empD4']['status'], $nivel4dd['empD4']['aid']);
					else
						$ic04dh = $this->_posicao_vazia('d', 4);		
				else:
					$ic03dd	= $this->_posicao_vazia('d', 3);	
			
					$ic04eh = $this->_posicao_vazia('d', 4);
					$ic04dh = $this->_posicao_vazia('d', 4);		
				endif;
			else:
				$ic02db = $this->_posicao_vazia('d', 2);
			
				$ic03ed	= $this->_posicao_vazia('d', 3);	
				$ic03dd	= $this->_posicao_vazia('d', 3);	
			
				$ic04eg = $this->_posicao_vazia('d', 4);
				$ic04dg = $this->_posicao_vazia('d', 4);
				
				$ic04eh = $this->_posicao_vazia('d', 4);
				$ic04dh = $this->_posicao_vazia('d', 4);		
			endif;
		else:
			$ic01d = $this->_posicao_vazia('d', 1);
		
			$ic02eb = $this->_posicao_vazia('d', 2); 
			$ic02db = $this->_posicao_vazia('d', 2);
		
			$ic03ec = $this->_posicao_vazia('d', 3);	
			$ic03dc	= $this->_posicao_vazia('d', 3);	
			$ic03ed	= $this->_posicao_vazia('d', 3);	
			$ic03dd	= $this->_posicao_vazia('d', 3);	
		
			$ic04ee = $this->_posicao_vazia('d', 4);
			$ic04de = $this->_posicao_vazia('d', 4);
			
			$ic04ef = $this->_posicao_vazia('d', 4);
			$ic04df = $this->_posicao_vazia('d', 4);
			
			$ic04eg = $this->_posicao_vazia('d', 4);
			$ic04dg = $this->_posicao_vazia('d', 4);
			
			$ic04eh = $this->_posicao_vazia('d', 4);
			$ic04dh = $this->_posicao_vazia('d', 4);		
		endif;
			
		return <<<HTML
		
	{$patrocinador}
	
	<br class="quebra" />
	
	<div class="re">

	    <div class="r1ad">
            {$ic01e}
		</div>

		<br class="quebra" />

        <div class="seta1">
            <div class="seta1_ind">
                <img src="{$img_url}arvore/l3.png">
            </div>
        </div>

		<div class="r2ad">
			{$ic02ea}
			{$ic02da}
		</div>
		
		<br class="quebra" />

        <div class="seta2">
            <div class="seta2_ind">
                <a href="#">   <img src="{$img_url}arvore/l2.png"></a>
            </div>

            <div class="seta2_ind">
                <a href="#">  <img src="{$img_url}arvore/l2.png"></a>
            </div>
        </div>

		<div class="r3ad">
			{$ic03ea}	
			{$ic03da}	
			{$ic03eb}	
			{$ic03db}	
		</div>
		
		<br class="quebra" />	
		
        <div class="seta3">

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

        </div>

		<div class="r4ad">
            {$ic04ea}
            {$ic04da}

            {$ic04eb}
            {$ic04db}

            {$ic04ec}
            {$ic04dc}

            {$ic04ed}
            {$ic04dd}
		</div>
	</div>
	
	<!--////////////////////direito///////////////////////////-->
	
	<div class="rd">

        <div class="r1ad">
		    {$ic01d}
		</div>

		<br class="quebra" />

        <div class="seta1">
            <div class="seta1_ind">
                <img src="{$img_url}arvore/l3.png">
            </div>
        </div>

		<div class="r2ad">
			{$ic02eb}
			{$ic02db}
		</div>
		
		<br class="quebra" />

        <div class="seta2">
            <div class="seta2_ind">
                <a href="#">   <img src="{$img_url}arvore/l2.png"></a>
            </div>

            <div class="seta2_ind">
                <a href="#">  <img src="{$img_url}arvore/l2.png"></a>
            </div>
        </div>

		<div class="r3ad">
			{$ic03ec}	
			{$ic03dc}	
			{$ic03ed}	
			{$ic03dd}	
		</div>
		
		<br class="quebra" />

        <div class="seta3">

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

            <div class="seta3_ind">
                <img src="{$img_url}arvore/l1.png" />
            </div>

        </div>

		<div class="r4ad">
            {$ic04ee}
            {$ic04de}

            {$ic04ef}
            {$ic04df}

            {$ic04eg}
            {$ic04dg}

            {$ic04eh}
            {$ic04dh}
		</div>
	</div>
HTML;
	
	}

/*
 * Gera os elementos vazios da árvore binária
 *
 *		Monta os elementos vazios quando não houver associado nas posições da árvore
 *
 *
 *  @access private
 *  @param $rede Direta e Esquerda (D e E)
 *	@param $matriz Contador que auxilia na montagem da matriz binária, configurando o nível da rede binária/
 *  @return string
 */

private function _posicao_vazia($rede, $nivel)
{
	return '<div class="r'.$nivel.'ad_ind">'.
				$this->config->item('rede_posicao_vazia').
		   '</div>';
}

/**
 * Gera os elementos da árvore binária
 *
 *		Monta os elementos com os dados de cada associado encontrado na rede
 *		do associado patrocinador informado como argumento do método "binário"
 *
 *		Composição das classes CSS
 *
 *		ex: ic01e
 *
 *		ic0 - Prefixo
 *		1-4 - Nível de apresentação da rede
 *		e,d,c,i,p -	"e" e "d" indicam um usuário ativo nas respectivas redes, esquerda e direita.
 *					"c" - Indica um usuário tipo "consumidor" que, entre outras limitações, apenas
 *						  gera pontos na rede, sem no entanto participar do plano de marketing/bonificação
 * 						  da empresa.
 *					"i" - Indica um usuário inativo
 *					"p" - Indica um usuário pendente
 *
 *  @access private
 *  @param $rede Direta e Esquerda (D e E)
 *	@param $matriz Contador que auxilia na montagem da matriz binária, configurando o nível da rede binária/
 *  @param $status Status do associado
 *	@param $nome Nome do associado
 *	@param $graduacao Graduação do associado
 *  @return string
 */
private function _elements($nome, $graduacao, $nivel = "", $status="", $aid = "")
{
//tooltip para colocar no início da tag html abaixo

    $img_url = $this->config->item('img');
	$graduacao = $this->_graduacao($graduacao);
	
	if($nivel != ''): 
	$detalhes = <<<HTML
                    <span>
                        <div class="tooltip_tit">{$nome}</div>
                        <div class="tooltip_grad">{$graduacao}</div>
                        <!--<div class="tooltip_pts"></div>-->
                    </span>
					<img src="{$img_url}arvore/ic_{$status}.png">
HTML;
	$link = anchor("escritorio-virtual/rede/binario/$aid", "$detalhes", "class='dcontexto'");
    $html =	<<<HTML
			<div class="r{$nivel}ad_ind">
				{$link}
			</div>
HTML;
return $html;
	else:
		$html =	<<<HTML
		<br class="quebra"> <br><br>
        <div class="pr">
            <div class="pr_ind">
                <a href="#" class="dcontexto">
                    <span>
                        <div class="tooltip_tit">{$nome}</div>
                        <div class="tooltip_grad">{$graduacao}</div>
                        <!--<div class="tooltip_pts"></div>-->
                    </span>
                    <img src="{$img_url}arvore/ic_{$status}.png">
                </a>
            </div>
        </div>
HTML;
        return $html;
	endif;
}

private function _check_rede($aid, $current_user)
{
	if($aid == $current_user)
	  return TRUE;
	if(($a = $this->mrede->getBinario($current_user)) !== FALSE):
		foreach ($a->result() as $d):
			if($d->aid == $aid)
			  return TRUE;
			else
				$this->_check_rede($aid, $d->aid);					
				
		endforeach;
	else:
		return FALSE;
	endif;
 }


private function _graduacao($q)
{
	switch ($q):
		case "BRONZE":
			return '<div class="icone bz" title="Bronze"></div>';
			break;
		case "PRATA":
			return '<div class="icone ag" title="Prata"></div>';
			break;
		case "OURO":
			return '<div class="icone ad" title="Associado ouro"></div>';
			break;
		case "RUBI":
			return '<div class="icone dm" title="Associado rubi"></div>';
			break;
		case "SAFIRA":
			return '<div class="icone dm" title="Associado safira"></div>';
			break;
		case "DIAMANTE":
			return '<div class="icone dm" title="Associado diamante"></div>';
			break;
		case "DUPLO DIAMANTE":
			return '<div class="icone dm" title="Associado duplo diamante"></div>';
			break;
		case "DUPLO DIAMANTE EXECUTIVO":
			return '<div class="icone dm" title="Associado duplo diamante executivo"></div>';
			break;
		case "DIAMANTE TRIPLO":
			return '<div class="icone dm" title="Associado diamante triplo"></div>';
			break;
		case "DIAMANTE TRIPLO EXECUTIVO":
			return '<div class="icone dm" title="Associado diamante triplo executivo"></div>';
			break;
		case "EMBAIXADOR":
			return '<div class="icone dm" title="Associado embaixador"></div>';
			break;
		default:
			return '<div class="icone sg" title="Sem graduação"></div>';
	endswitch;
}
	
private function _rede($rd)
{
	switch($rd):
		case 'E':
			$rede = 'e';
			break;
		case 'D':
			$rede = 'd';
			break;
	endswitch;
	return $rede;
}

private function _status($st, $plano)
{
	if(!is_null($plano) && $plano == 0):
		$status = 'c';
	else:
		switch($st):
		  case "I":
			  $status = "inativo";
			  $this->inativos++;
			  break;
		  case "A":
			  $status = "ativo";
			  $this->ativos++;
			  break;
		  case "P":
			  $status = "pendente";
			  $this->pendentes++;
			  break;
		endswitch;
	endif;
  return $status;
}

function setNivel($i)
{
	switch($i):
		case 1:
			return 1;
			break;
		case 2:
		case 3:
			return 2;
			break;
		case 4:
		case 5:
		case 6:
		case 7:
			return 3;
			break;
		case 8:
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
		case 14:
		case 15:
			return 4;
	endswitch;
}


function faturas()
{
  if($this->dx_auth->is_logged_in()):
	if($this->dx_auth->is_role("user")):
		$this->load->library("table");
		$this->load->library("data");
		$this->load->model("Modelboleto", "mboleto");

		//seleciona o dia do vencimento da taxa de manutencao do usuario e o plano
		if(($usuario = $this->musu->getUsuario($this->dx_auth->get_username())) !== FALSE):
		  foreach($usuario->result() as $usu):
			$taxa['vencimento'] = $usu->vencimento_taxa;
			$taxa['plano'] = $usu->pid;
		  endforeach;
		endif;

		$this->table->set_heading("Num. Fatura", "Valor", "Vencimento", "Situa&ccedil;&atilde;o", "Descri&ccedil;&atilde;o", "Op&ccedil;&otilde;es");
		if(($faturas = $this->mboleto->getFaturas('',$this->dx_auth->get_username())) !== FALSE):
		  foreach($faturas->result() as $fatura):
			//caso a fatura esteja em aberto, exibe um link para imprimir
			if($fatura->situacao == "Em Aberto"):
			  $opcoes = anchor("associado/imprimir/$fatura->fid/$fatura->uid","Imprimir");
			else:
			  $opcoes = "";
			endif;
			//monta a tabela com todos os dados da fatura
			$this->table->add_row("#&nbsp;".$fatura->fid, "R$ ".$fatura->valor, $this->data->mysql_to_human($fatura->vencimento), $fatura->situacao, $fatura->descricao, $opcoes);
		  endforeach;
		endif;
		//caso ainda nao tenha sido gerada uma fatura para o mes atual
		//uma nova fatura eh gerada e exibida para o usuario
		if($this->verifica_fatura() === FALSE):
		  $this->load->model('adm/Modelplanos','mplano');
		  //configura o vencimento da fatura
		 //se o dia de vencimento escolhido jah tiver passado, a fatura eh gerada para o proximo mes
		  if (date("d") > $taxa['vencimento']):
			$proximomes = mktime (0, 0, 0, date("m")+1, $taxa['vencimento'],  date("Y"));
			$vencimento = date('Y-m-d', $proximomes);
		  else:
			$vencimento = date('Y-m', now()).'-'.$taxa['vencimento'];
		  endif;

		  
		  //seleciona o valor do plano escolhido pelo usuario
		  if(($plano = $this->mplano->getPlano('p.pid',$taxa['plano'])) !== FALSE):
			  foreach($plano->result() as $p):
				$valor_plano = $p->valor;
			  endforeach;
			  //soma o valor do plano aa taxa de manutencao e gera a fatura
			  $valor = number_format($valor_plano+10.00, 2, ',', '');
			  $descricao = "Taxa de Manutenção e Recarga";
			  $this->mboleto->geraFatura($this->dx_auth->get_username(), $vencimento, $valor, $descricao);
			  //recarrega a pagina para exibir a nova fatura para o usuario
			  redirect('associado/faturas');
		  endif;
		endif;
		$dados['faturas'] = $this->table->generate();

		$dados['titulo'] = "Faturas";
		$dados['pagina'] = "backend/associado/faturas";
		$this->load->vars($dados);
		$this->load->view($this->_container);
	endif;
  else:
	redirect("login");
  endif;
}

    /*
     * Gera boleto para pagamento da fatura
     *
     *
     */
    
    function imprimir($fid, $uid)
    {
          $this->load->library("data");
          $this->load->model("Modelboleto", "mboleto");
          $this->load->model("adm/Modelusuarios", "musu");
          foreach($this->mboleto->getFaturas($fid)->result() as $fatura):
            $dados_boleto['all'] = $fatura;
          endforeach;
          foreach($this->musu->getUsuario($uid)->result() as $usuario):
            $dados_usuarios['all'] = $usuario;
          endforeach;
          foreach($this->musu->getEndereco($uid)->result() as $endereco):
            $dados_usuarios['endereco'] = $endereco;
          endforeach;
          $vencimento = $this->data->mysql_to_human($dados_boleto['all']->vencimento);
          $numero_doc = $dados_boleto['all']->fid;
          $this->session->set_flashdata('valor', $dados_boleto['all']->valor);
          $this->session->set_flashdata('vencimento', $vencimento);
          $this->session->set_flashdata('numero_doc', $numero_doc);
          $this->session->set_flashdata('nomesacado', $dados_usuarios['all']->nome_completo);
          $this->session->set_flashdata('endereco', $dados_usuarios['endereco']->logradouro.", ".$dados_usuarios['endereco']->numero. "&nbsp;" .$dados_usuarios['endereco']->complemento ." - ".$dados_usuarios['endereco']->bairro." - ".$dados_usuarios['endereco']->cidade." - ".$dados_usuarios['endereco']->estado);
          redirect('boleto');        
    }
    
    function recebimento()
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role("user")):
            $dados['usuario'] = $this->dx_auth->get_username();
            if(($recebimento = $this->musu->getFRecebimento($this->dx_auth->get_username())) !== FALSE):
              foreach($recebimento->result() as $rec):
                $dados['recebimento'] = $rec;
              endforeach;
            else:
              $dados['recebimento'] = FALSE;
            endif;
            $dados['bancos'] = $this->tipos->bancos();
            $dados['tpconta'] = $this->tipos->tpconta();

            $dados['submenu'] = $this->_submenu_cadastro();
            $dados['titulo'] = "Recebimento";
            $dados['pagina'] = "backend/associado/meu_cadastro/recebimento";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
      else:
        redirect("login");
      endif;
    }

    //verifica se a fatura do mes atual ja foi gerada
    function verifica_fatura()
    {
      $fatura_gerada = FALSE;
      if(($faturas = $this->mboleto->getFaturas('',$this->dx_auth->get_username())) !== FALSE):
        foreach($faturas->result() as $fatura):
          //verifica se ja foi gerada uma fatura para o mes atual
          $mes = $this->data->select_month($fatura->vencimento);
          if($mes < date('m',now())):
            //caso a fatura do mes ainda não tenha sido gerada
            $fatura_gerada = FALSE;
          else:
            $fatura_gerada = TRUE;
          endif;
        endforeach;
      endif;
      return $fatura_gerada;
    }

    function salvar($sessao, $codigo)
    {
      if($this->dx_auth->is_logged_in()):
        if($this->dx_auth->is_role(array("user", "admin"))):
            $this->load->library("lib_usuarios");
            $v = $this->lib_usuarios->_get_form_values(TRUE);
            switch($sessao):
              case "recebimento":
                  $this->musu->editarFRecebimento($v['inforecebimento'], $v['dados_pessoais']['uid']);
                  $msg = "recebimento atualizado com sucesso";
                  break;
              case "telefone":
                  $this->musu->editarTelefone($v['infocontato']['celular'], $v['dados_pessoais']['uid'], $v['infocontato']['celid']);
                  $this->musu->editarTelefone($v['infocontato']['telefone'], $v['dados_pessoais']['uid'], $v['infocontato']['telid']);
                  $msg = "telefone atualizado com sucesso";
                  break;
              case "endereco":
                  $this->musu->editarEndereco($v['endereco'], $v['dados_pessoais']['uid']);
                  $msg = "endere&ccedil;o atualizado com sucesso";
                  break;
              case "dados_pessoais":
                  //verifica se a fatura do mes ainda não foi gerada, caso tenha sido, não permite alteração do plano
                  if($this->verifica_fatura() === FALSE):
                      $v['dados_pessoais']['pid'] = $v['plano']['pid'];
                      $this->musu->editarUsuario($v['dados_pessoais'], $v['dados_pessoais']['uid']);
                      $msg = "dados pessoais atualizados com sucesso";
                  else:
                      $msg = "n&atilde;o foi poss&iacute;vel efetuar a altera&ccedil;&atilde;o do plano pois a fatura deste m&ecirc;s j&aacute; foi gerada.";
                  endif;
                  break;
            endswitch;
            $this->session->set_flashdata('msg', $msg);
            if($this->dx_auth->is_role("user")):
                redirect('associado/'.$sessao);
            elseif($this->dx_auth->is_role("admin")):
                redirect("adm/usuarios/editar/$sessao/$codigo");
            endif;
        endif;
      else:
        redirect("login");
      endif;
    }

}

/* End of file rede.php */
/* Location: ./system/application/controllers/escritorio-virtual/rede.php */
