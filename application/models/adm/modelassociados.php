<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelAssociados extends CI_Model {
	
	//Controla o código dos erros apresentados no sistema
	var $errno = FALSE; 
	var $aid;
	//Nome do novo associado
	var $nm_novo_associado;
	//Nome do plano escolhido pelo associado
	var $nm_plano_associado;
	var $binarioD = 0;
	var $binarioE = 0;
	var $patrocinador = FALSE;
	var $upline;
	// associados
    var $_tbl_associados = "associados";
	// users
	var	$_tbl_users  = "users";
	// planos
	var	$_tbl_planos = "planos";
	// contador de registros
	var $total = 0;	
	/**
	* Variável com os principais relacionamentos com a tabela de associados
	*
	*	@var $_relacionamento
	*
	* 0 - ass_dados_pessoais
	* 1 - ass_enderecos
	* 2 - pontos_binario
	* 3 - ass_info_banco
	* 4 - ass_pj
	* 5 - ass_configuracoes
	* 6 - ass_pontos
	* 7 - ass_rendimentos
	* 8 - graduacoes
	*
	*/
	var	$_relacionamento = array(0=>"ass_dados_pessoais",
									   1=>"ass_enderecos", 
									   2=>"pontos_binario",
									   3=>"ass_info_banco",
									   4=>"ass_pj",
									   5=>"ass_configuracoes",
									   6=>"ass_pontos",
									   7=>"ass_rendimentos",
									   8=>"graduacoes",
                                      10=>"ass_saldo",
                                      11=>"pontos_acumulados",
                                      12=>"ass_dependentes");
		
	function __construct()
	{
		parent::__construct();
		$this->load->library("data");
	}
	
	/*
     * @abstract Registra os logs dos eventos
     *
     * TIPO:
     * INFO - Logs informativos.
     * ERRO - Logs de erros.
     * DEBUG - Logs de eventos para debug do sistema.
     *
     * ORIGEM LOG:
     * 1 - Escritório Virtual
     *
     * @param @tipo
     * @param @descricao
     * @param @rotina
     * @param @metodo
     * @param @origem_log
     */

	function geraLog($tipo, $descricao, $rotina = "", $metodo = "", $origem_log=1)
	{
		$log = array(
			'tipo'=>$tipo,
			'descricao'=>$descricao,
			'rotina'=>$rotina,
			'metodo'=>$metodo,
			'oid'=>$origem_log);
		$this->db->set($log);
		$this->db->insert("logs");
	}

	/**
	 *
	 * @param string $tipo
	 */

	function getCadastros($tipo){
		$cad = $this->db->get("cad_$tipo");
		return $cad->row();
	}
	
	/**
	 * 
	 * 
	 * @param array $dados
	 * @return string
	 */
	
	function pre_cadastro($dados){
        $ret = FALSE;

		$this->db->trans_start(TRUE);
			if($this->grava_associado($dados) !== FALSE):
				$this->inserirDadosPessoais($dados);
				isset($dados['endereco'])?$this->inserirEndereco($dados['endereco']):'';
				$this->inserirConfigAssociado($this->aid);
                $this->inserir_pontos_binario($this->aid);
                $this->inserir_saldo($this->aid);
                $this->inserir_pontos_acumulados($this->aid);
				$ret = $this->aid;
			else:
				$ret = FALSE;
			endif;
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE):
			$ret = mysqli_error().'---'.mysqli_errno();
		endif;
		
		return $ret;
	}

    /*
     * @abstract Insere o registro inicial na tabela de saldo
     *
     * @param $aid
     */
    function inserir_pontos_acumulados($aid){
        $dados = array(
            'aid'=>$aid,
            'pontos'=>0
        );
        $this->db->set($dados);
        $this->db->insert($this->_relacionamento[11]);

		$this->geraLog('INFO', 'Registro inserido na tabela "pontos_acumulados"', 'Cadastro', 'inserir_pontos_acumulados');
    }

    /*
     * @abstract Insere o registro inicial na tabela de saldo
     *
     * @param $aid
     */
    function inserir_saldo($aid){
        $dados = array(
                    'aid'=>$aid,
                    'valor'=>0
        );
        $this->db->set($dados);
        $this->db->insert($this->_relacionamento[10]);

		$this->geraLog('INFO', 'Registro inserido na tabela "ass_saldo"', 'Cadastro', 'inserir_saldo');
    }

    /*
     * @abstract Insere o registro inicial na tabela de pontos binário do associado
     *
     * @param $aid
     */

    function inserir_pontos_binario($aid){
        $dados = array(
                    'aid'=>$aid,
                    'pontos_direita'=>0,
                    'pontos_esquerda'=>0,
                    'data'=>date("Y-m-d", mktime(0,0,0, date('m', time()), date('d', time()), date('Y', time()))));
        $this->db->set($dados);
        $this->db->insert($this->_relacionamento[2]);

		$this->geraLog('INFO', 'Registro inserido na tabela "ass_pontos_binario"', 'Cadastro', 'inserir_pontos_binario');
    }

    /*
     * @abstract Insere o registro inicial na tabela de pontos unilevel do associado
     *
     * @param $aid
     */

    function inserir_pontos_unilevel($aid){

        $dados = array(
            'aid'=>$aid,
            'mes'=>date('m'),
            'ano'=>date('Y'));
        $this->db->set($dados);
        $this->db->insert($this->_relacionamento[9]);
    }

    /**
	 * 
	 * @param array $dados
	 * @return boolean
	 */
	
	function grava_associado($dados)
	{
		if(($associado = $this->_setAssociado($dados)) !== FALSE):
			$this->db->set($associado);
			$this->db->insert($this->_tbl_associados);
			$this->_setIdAssociado($this->db->insert_id());

			$this->geraLog('INFO', 'Registro inserido na tabela "associados"', 'Cadastro', 'grava_associado');
		else:
			return FALSE;
		endif;
	}
	
	/**
	 * 
	 * @param array $pedido
	 * @param integer $plano
	 */
	
	function grava_salva_plano($pedido,$plano)
	{
		
		// INSERIR TABELA PLANO PEDIDO;
		$this->db->set($pedido);
		$this->db->insert('ass_pedidos');
		$idpedido = $this->db->insert_id();
		
		
		if($pedido['forma_pgto_plano'] == "AV")
		{
			$parcela = $plano->valor_plano/$plano->qtde_parcelas;
			
			$fatura = array();
			$fatura['pedido'] = $idpedido;
			$fatura['valor'] = $plano->valor_plano;
            $dias_prazo = $this->config->item("prazo_boleto");
			$Data = date('d/m/Y', strtotime("+$dias_prazo days"));
			$fatura['dtvencimento']= $this->data->FormataDataBD($Data);
			
			
			$fatura['descricao']= "Plano de Adesão - A Vista" ;
			$fatura['gera_bonus']= "S" ; // Gera bonus transação financeira
			$fatura['pontos_binario'] = $plano->pontos_binario;
            $fatura['num_parcela'] = '1/1';
			$fatura['status'] = "Pendente";
			
			$this->db->set($fatura);
			$this->db->insert('ass_faturas');
			
		}else if($pedido['forma_pgto_plano'] == "AP")
		{
			
			// INSERIR TABELA FATURAS;
			############################################################# ENTRADA 
			$parcela = (($plano->valor_plano-$plano->valor_entrada)/$plano->qtde_parcelas);
			
			$fatura = array();
			$fatura['pedido'] = $idpedido;
			$fatura['valor'] = $plano->valor_entrada;
			
            $dias_prazo = $this->config->item("prazo_boleto");
            $DtEntrada = date('d/m/Y', strtotime("+$dias_prazo days"));
			$fatura['dtvencimento']= $this->data->FormataDataBD($DtEntrada);
			
			
			$fatura['descricao']= "Plano de Adesão - Entrada" ;
			$fatura['gera_bonus']= "S" ; // Gera bonus transação financeira
			$fatura['pontos_binario'] = $plano->pontos_binario_entrada;
			$fatura['status'] = "Pendente";
			
			$this->db->set($fatura);
			$this->db->insert('ass_faturas');
			########################################################### PARCELAS 
		
			for($i=1;$i<=$plano->qtde_parcelas;$i++)
			{
				$fatura = array();
				$fatura['pedido'] = $idpedido;
				$fatura['valor'] = $parcela;
                $fatura['num_parcela'] = "$i/$plano->qtde_parcelas";
				
				$DtVencimento = $this->data->SomaMesData($DtEntrada,1);
				$fatura['dtvencimento']= $this->data->FormataDataBD($DtVencimento);
				
				$DtEntrada = $DtVencimento ; // FLAG
				
				
				
				$fatura['descricao']= "Plano de Adesão" ;
				$fatura['gera_bonus']= "S" ; // Gera bonus transação financeira
				$fatura['pontos_binario'] = $plano->pontos_binario_parcela;
				$fatura['status'] = "Pendente";
				
				$this->db->set($fatura);
				$this->db->insert('ass_faturas');
			}
			#############################################################
		}
	}
	
	/**
	 * 
	 * @param array $dados
	 * @return boolean|string
	 */
	
	function inserirAssociado($dados)
	{
		$this->db->trans_start();
        //flag controladora do cadastro, caso seja setado para FALSE, o cadastro não é efetuado
        $continue = TRUE;

        if($continue === TRUE):
			if(($associado = $this->_setAssociado($dados)) !== FALSE):
				$this->db->set($associado);
				$this->db->insert($this->_tbl_associados);
	
				$this->_setIdAssociado($this->db->insert_id());
	
				$this->inserirDadosPessoais($dados);
				isset($dados['endereco'])?$this->inserirEndereco($dados['endereco']):'';
				isset($dados['infobanco'])?$this->inserirInfoBanco($dados['infobanco'], $this->aid):'';
				$this->inserirConfigAssociado($this->aid, $dados['forma_pgto']);
				
				/*
				*	Verifica se o associado que foi cadastrado não está no plano "Consumidor"
				*	pois este plano não gera os bônus a seguir por não gerar nenhum valor a pagar
				*	para o associado.
				*
				*	Os associados do tipo consumidor só geram pontos no binário para os uplines
				*	através do consumo na rede Sicove, e da mesma forma, a única forma de geração
				*	de ganhos será através dos pontos no binário que se fizer por seus indicados diretos.
				*
				*/
				
				if($this->getPatrocinadorConsumidor($this->aid) === FALSE):
					/*
					*	Lançamento dos bônus para todas as gerações de acordo com o tipo de cadastro e graduação
					*
					*/
					
					//Bônus de cadastro
					$this->_geraBonus($dados['infoconta']['patrocinador'], 
											  'L', 
											  'CADASTRO', 
											  $this->config->item('bonus_cadastro'), 
											  '1', 
											  sprintf($this->config->item('msg_bonus_cadastro'), $this->nm_novo_associado, $this->aid));
					//Bônus de pacotes						  
					$this->_geraBonus($dados['infoconta']['patrocinador'],
									  'L',
									  'PACOTES',
									  $this->_configBonusPacotes($dados['plano']['pid'], $dados['forma_pgto']),
									  '1',
									  sprintf($this->config->item('msg_bonus_pacotes'), 
											  $this->nm_plano_associado, 
											  $this->nm_novo_associado, 
											  $this->aid,
											  $dados['forma_pgto']=='AV'?'à vista':'à prazo'));						  
					//$this->_geraPontos($dados['infoconta']['patrocinador'],
					//				   $this->_configBonusPacotes($dados['plano']['pid'], $dados['forma_pgto']));						  
				endif;
				return $this->aid;
			else:
				return FALSE;
			endif;
        endif;
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE):
			return mysql_error().'---'.mysql_errno();
		endif;
	}
	
	/**
	 * 
	 * @param string $plano
	 * @param st $forma_pgto
	 * @return number
	 */
	
	function _configBonusPacotes($plano, $forma_pgto)
	{
		if($forma_pgto == 'AV'):
			return $this->getValorPlano($plano, 'valor_plano')->valor * $this->config->item('bonus_pacotes');
		else:
			return $this->getValorPlano($plano, 'valor_entrada')->valor * $this->config->item('bonus_pacotes');
		endif;
	}
	/*
	*
	*	Obtem o valor do plano baseado na forma do pagamento
	*
	*/
	/**
	 * 
	 * @param integer $pid
	 * @param string $tipo_valor
	 * @return boolean
	 */
	
	function getValorPlano($pid, $tipo_valor)
	{
		$this->db->select("nmplano as plano", FALSE);
		$this->db->select($tipo_valor." as valor", FALSE);
		$this->db->where('pid', $pid);
		
		
		$plano = $this->db->get($this->_tbl_planos);
		
		if($plano->num_rows() > 0):
			$this->nm_plano_associado = $plano->row()->plano;
			return $plano->row();
		else:
			return FALSE;
		endif;
	}
	
	function inserirConfigAssociado($aid, $form_pgto = "")
	{
		$this->db->set($this->_setConfigAssociado($aid, $form_pgto));
		$this->db->insert($this->_relacionamento[5]);

		$this->geraLog('INFO', 'Registro inserido na tabela "ass_configuracoes"', 'Cadastro', 'inserirConfigAssociado');
		
	}
	
	function inserirDadosPessoais($dados)
	{
        $this->db->set($this->_setDadosPessoais($dados, $this->aid));
		$this->db->insert($this->_relacionamento[0]);

		$this->geraLog('INFO', 'Registro inserido na tabela "ass_dados_pessoais"', 'Cadastro', 'inserirDadosPessoais');
	}
	
	function editarAssociado($dados, $aid)
	{
		$this->db->set($this->_setAssociado($dados, TRUE));
		$this->db->where("aid", $aid);
		$this->db->update($this->_tbl_associados);
	}

    function alterarStatus($aid, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('aid', $aid);
        $this->db->update($this->_tbl_associados);
    }

    function alterarQualificacao($aid, $qualificacao)
    {
        $this->db->set('qualificacao', $qualificacao);
        $this->db->where('aid', $aid);
        $this->db->update($this->_tbl_associados);
    }
	
	function alterar_senha($user_id, $new_pass)
	{
		$this->db->set('password', $new_pass);
		$this->db->where('id', $user_id);
		return $this->db->update($this->_tbl_users);
	}

	function inserirEndereco($dados)
	{
		$this->db->set($this->_setEndereco($dados, $this->aid));
		$this->db->insert($this->_relacionamento[1]);

		$this->geraLog('INFO', 'Registro inserido na tabela "ass_enderecos"', 'Cadastro', 'inserirEndereco');
	}
	
	function editarEndereco($dados, $aid)
	{
		$this->db->set($this->_setEndereco($dados, $aid));
		$this->db->where("aid", $aid);
		$this->db->update($this->_relacionamento[1]);
	}
	
	function inserirInfoBanco($dados, $aid)
	{
		$this->db->set($this->_setInfoBanco($dados, $aid));
		$this->db->insert($this->_relacionamento[3]);
	}
	
	function editarInfoBanco($dados, $aid)
	{
        if($this->getInfoBanco($aid) === FALSE):
            $this->inserirInfoBanco($dados, $aid);
        else:
            $this->db->set($this->_setInfoBanco($dados, $aid));
            $this->db->where("aid", $aid);
            $this->db->update($this->_relacionamento[3]);
        endif;
		return $this->db->affected_rows();		
	}
	
	function editarDadosPessoais($dados, $aid)
	{
		$this->db->set($this->_setDadosPessoais($dados, $aid));
		$this->db->where("aid", $aid);
		$this->db->update($this->_relacionamento[0]);
		return $this->db->affected_rows();		
	}

    function criarDependente($dados, $aid)
    {
        $data = array(
            'aid'=>$aid,
            'tdid'=>$dados['tdid'],
            'nome_completo' => $dados['nome_completo'],
            'sexo' => $dados['sexo'],
            'dtnasc' => $dados['dtnasc'],
            'cpf' => $dados['cpf']
        );

        $this->db->insert($this->_relacionamento[12], $data);
    }

    function excluirDependente($aid, $adid)
    {
        $this->db->where('aid', $aid);
        $this->db->where('adid', $adid);
        $this->db->delete($this->_relacionamento[12]);
    }

	//getters
    function getTipoDependente($tdid = "")
    {
        if(!empty($tdid))
            $this->db->where("tdid", $tdid);

        $tp_dependente = $this->db->get("tipo_dependente");

        if($tp_dependente->num_rows() > 0)
            return $tp_dependente;
        else
            return FALSE;

    }

    function getProfissoes($pid = "")
    {
        if(!empty($pid))
            $this->db->where("pid", $pid);

        $profissao = $this->db->get("ass_profissao");

        if($profissao->num_rows() > 0)
            return $profissao;
        else
            return FALSE;

    }

    function getQualificacao($aid)
    {
        $this->db->select("qualificacao");
        $this->db->from($this->_tbl_associados);
        $this->db->where("aid", $aid);

        $qualificacao = $this->db->get();

        foreach($qualificacao->result() as $result):
          $ql = $result->qualificacao;
        endforeach;

        return $ql;
    }

    function getStatus($aid)
    {
        $this->db->select("status");
        $this->db->from($this->_tbl_associados);
        $this->db->where("aid", $aid);

        $status = $this->db->get();

        foreach($status->result() as $result):
          $st = $result->status;
        endforeach;

        return $st;
    }

    function is_associado_active($username)
    {
        $this->db->select("ass.status, users.role_id");
        $this->db->from($this->_tbl_associados." ass");
        $this->db->join($this->_tbl_users, "users.aid = ass.aid", "right");
        $this->db->where("username", $username);

        $ret = $this->db->get();
		
		if($ret->num_rows() > 0):		
			if($ret->row()->status == 'A' || $ret->row()->role_id == 9)
				return TRUE;
			else
				return FALSE;
		else:
			return FALSE;		
		endif;		
    }

    function get_num_afiliados($patrocinador)
    {
        $this->db->where("patrocinador", $patrocinador);
        $this->db->from($this->_tbl_associados);
        return $this->db->count_all_results();
    }
	
	function getAssociado($associado = '', $where_key = '', $where_value = '', $rede = '', $fields = '*', $md5 = FALSE)
	{
			
			$this->db->select($fields);
					
            if($where_key != '' && $where_value != "T"):
				$this->db->where($where_key, $where_value);
            endif;
			
			if($associado != ''):
                if($md5 === FALSE)
                    $this->db->where("aid", $associado);
                else
                    $this->db->where("md5(aid)", $associado);
			endif;
			
			if($rede != ''):
				$this->db->where("rede", $rede);
			endif;

            $ass = $this->db->get("get_associado");
			
			if($ass->num_rows() == 0):
			  $ass = '';
			  $where_key = '';
			  $where_value = '';
			endif;
			
            if($ass == '' && $where_key == '' && $where_value == ''):
            	return FALSE;
            else:
  				return $ass;            
            endif;
	}

    function getDependente($associado = '', $where_key = '', $where_value = '', $fields = '*')
    {

        $this->db->select($fields);

        if($where_key != '' && $where_value != "T"):
            $this->db->where($where_key, $where_value);
        endif;

        if($associado != ''):
            $this->db->where("aid", $associado);
        endif;

        $ass = $this->db->get("get_dependentes");

        if($ass->num_rows() == 0):
            $ass = '';
            $where_key = '';
            $where_value = '';
        endif;

        if($ass == '' && $where_key == '' && $where_value == ''):
            return FALSE;
        else:
            return $ass;
        endif;
    }

    function getPatrocinador($aid, $where_key = '', $where_value = '')
	{
		$this->db->select("pat.aid, pat.nome_completo, ass.status");
		$this->db->from($this->_tbl_associados . " ass");
		$this->db->join($this->_relacionamento[0] . " pat", "pat.aid = ass.patrocinador");
		$this->db->where("ass.aid", $aid);
        if($where_key != '' && $where_value != ''):
            $this->db->where($where_key, $where_value);
        endif;
		
		$patrocinador = $this->db->get();
		if($patrocinador->num_rows() > 0):
			return $patrocinador;
		else:
			return false;
		endif;
	}
	
	function getEndereco($aid)
	{
		$this->db->select("*");
		$this->db->from($this->_relacionamento[1]);
		$this->db->where("aid", $aid);
		
		$dados = $this->db->get();
		
		return $dados;
	}

	function getPlanoAtual($aid)
	{
		$this->db->select("plano");
		$this->db->from("get_associado");
		$this->db->where("aid", $aid);
		
		$plano = $this->db->get();
		
		if($plano->num_rows() > 0):
			return $plano;			
		else:
			return false;
		endif;
	}
	
	function getEmail($aid)
	{
		$this->db->select("email");
		$this->db->from($this->_tbl_users);
		$this->db->where("id", $aid);
		
		$email = $this->db->get();
		
		if($email->num_rows() > 0):
			return $email;			
		else:
			return false;
		endif;
	}
	
	function getLogin($aid)
	{
		$this->db->select("username");
		$this->db->from($this->_tbl_users);
		$this->db->where("id", $aid);
		
		$login = $this->db->get();
		
		if($login->num_rows() > 0):
			return $login;			
		else:
			return false;
		endif;
	}
	
	function getInfoBanco($aid)
	{
		$this->db->where("aid", $aid);
		$infobanco = $this->db->get($this->_relacionamento[3]);
		
		if($infobanco->num_rows() > 0):
			return $infobanco;			
		else:
			return FALSE;
		endif;
	}
	
	/**
	*	@abstract	Verifica se um determinado ID está na rede do associado logado.
	*				Se não estiver, impede a visualização da rede que está se tentando exibir
	*
	*	@param integer $patrocinador
	*	@param	array	$minharede
	*
	*/
	
    public function _getMinhaRede($patrocinador, &$minharede)
    {
		if(($a = $this->_getCountBinario($patrocinador)) !== FALSE):
			foreach ($a->result() as $d):
				$id = $d->aid;
				$minharede[$id] = array();
				$this->_getMinhaRede($id, $minharede);					
			endforeach;
		endif;
    }

	
	function _getCountBinario($aid, $rede = ""){
		$this->db->select("aid");
		$this->db->from($this->_tbl_associados);
		$this->db->where("upline", $aid);
		if($rede != "") $this->db->where("rede", $rede);
		$binario = $this->db->get();
		
		if($binario->num_rows() == 0)
			return FALSE;
		else
			return $binario;
	}
	/** 
	*
	*	@abstract Conta os pontos binário do patrocinador para inserir o novo associado
    *            na rede menor caso a configuração de entrada de novos associados esteja marcada como "AUTO"
	*
	*	@param	integer $patrocinador	Patrocinador a ser pesquisado
	*	@param	string	$rede	Rede (do patrocinador) que deverá ser contada
	*/
	
    public function conta_pontos_binario($patrocinador, $rede = "")
    {
        $pontos_rede = $rede=="D"?"pontos_direita":"pontos_esquerda";
        $this->db->select($pontos_rede);
        $this->db->from("pontos_binario");
        $this->db->where("data", date('Y-m-d'));
        $this->db->where("aid", $patrocinador);
        $result = $this->db->get();

        $pontos = $result->row();
        return $pontos->$pontos_rede;
    }

    public function _conta_rede($patrocinador, $rede = "", &$count = 0)
    {
        if(($a = $this->_getCountBinario($patrocinador, $rede)) !== FALSE):
            foreach ($a->result() as $d):
                $count++;
                $this->_conta_rede($d->aid, "", $count);
            endforeach;
        endif;
    }

    function _getNovosCadastros($aid){
		$this->db->select('novos_cadastros');
		$this->db->from($this->_tbl_associados);
		$this->db->where("aid", $aid);
		$res = $this->db->get();
		
		foreach($res->result() as $n):
			return $n->novos_cadastros;
		endforeach;
	}
	
	function _setNovosCadastros($aid, $rede){
        $this->db->set('novos_cadastros', $rede);
        $this->db->where('aid', $aid);
        $this->db->update($this->_tbl_associados);
		return $this->db->affected_rows();
	}

    function setStatusAssociado($aid, $status){
        $this->db->set('status', $status);
        $this->db->where('aid', $aid);
        $this->db->update($this->_tbl_associados);
        return $this->db->affected_rows();
    }
	
	function getPatrocinadorConsumidor($aid)
	{	
		$this->db->select('percentual_ganho');
		$this->db->from($this->_tbl_associados . " ass");
		$this->db->join($this->_tbl_planos, "planos.pid = ass.plano_atual");
		$this->db->where("percentual_ganho", "0");
		$this->db->where("aid", $aid);
		
		$res = $this->db->get();
		
		//retorna true caso o plano do patrocinado seja "consumidor"
		if($res->num_rows() > 0)
			return TRUE;
		else
			return FALSE;		
		
	}
	
	function get_name($aid)
	{
		$this->db->where("aid", $aid);
		
		$res = $this->db->get("get_name");
		
		if($res->num_rows() == 0):
			return FALSE;
		else:
			return $res->row();
		endif;
	}
	
	function _getPercentualPlano($pid)
	{
		$this->db->select('percentual_ganho');
		$this->db->from($this->_tbl_planos);
		$this->db->where("pid", $pid);
		
		$res = $this->db->get();
		
		foreach($res->result() as $n):
			return $n->percentual_ganho;
		endforeach;
	}
	
	function getErrno()
	{
		return $this->errno;
	}

	//setters
	function _setErrno($err)
	{
		$this->errno = $err;
	}
	
/*
*	Define o upline onde, abaixo do qual deve ser inserido o novo associado que estiver sendo cadastrado
*
*	@param $patrocinador - Patrocinador ou Upline a ser pesquisado
*	@param @rede - Rede onde deve ser pesquisado os campos acima
*/
	
	function _setUpline($patrocinador, $rede)
	{
		$this->db->select('aid');
		
		if($this->patrocinador === FALSE):
			$this->db->where('patrocinador', $patrocinador);
			$this->db->where('rede', $rede);
			$query = $this->db->get($this->_tbl_associados);
			
			$this->patrocinador = TRUE;
			
			if($query->num_rows() > 0):
				$associado = $query->last_row();
				$this->upline = $associado->aid;
				$this->_setUpline($associado->aid, $rede);
			else:
				$this->upline = $patrocinador;
				$this->_setUpline($patrocinador, $rede);
			endif;
		else:
			$this->db->where('upline', $patrocinador);
			$this->db->where('rede', $rede);
			$query = $this->db->get($this->_tbl_associados);
			
			if($query->num_rows() > 0):
				$associado = $query->row();
				$this->upline = $associado->aid;
				$this->_setUpline($associado->aid, $rede);
			endif;
		endif;			
	}
	
	function _setIdAssociado($aid)
	{
		$this->aid = $aid;
		$this->geraLog('INFO', 'IdAssociado foi setado', 'Cadastro', 'setIdAssociado');
	}
	
	function _setAssociado($dados)
	{
		if(isset($dados['infoconta']['patrocinador']))
		  $pat = $dados['infoconta']['patrocinador'];
		else
		  return FALSE;
		 
		//	Verifica a configuração do usuário quanto à alocação de novos associados na rede.
		//  Se o cadastro estiver sendo feito através do escritório virtual, esta configuração
		//	poderá ser sobreposta por opção do associado patrocinador ao escolher uma rede diferente
		//	da rede padrão configurada.
		
		$rede = $this->_getNovosCadastros($pat);  
		
		//	Sobrescreve temporariamente a configuração padrão de alocação de novos associados
		//	alocando o novo associado em uma rede diferente da rede padrão. Este recurso não altera
		//	a rede padrão que já está configurada no escritório virtual, sendo usada apenas para o cadastro atual
		
		if(isset($dados['infoconta']['rede_alocacao']) && (($dados['infoconta']['rede_alocacao'] == 'D') || ($dados['infoconta']['rede_alocacao'] == 'E') || ($dados['infoconta']['rede_alocacao'] == 'AUTO')))
			$rede = $dados['infoconta']['rede_alocacao'];
		
		// Verifica a rede menor do patrocinador e caso o sistema esteja configurado
		// para lançar novos cadastros de forma automática, insere o novo associado nessa rede,
        // considerando primeiramente a rede de menor pontuação e caso os pontos das duas redes sejam iguais,
        // considera a rede de menor quantidade de pessoas
		// caso contrário, insere na rede onde está configurado para entrar.
		
		if($rede == 'AUTO'):			
			$this->binarioD = $this->conta_pontos_binario($pat, 'D');
			$this->binarioE = $this->conta_pontos_binario($pat, 'E');
            if($this->binarioD == $this->binarioE):
                $qtde_re = 0;
                $qtde_rd = 0;
                $this->_conta_rede($pat, 'E', $qtde_re);
                $this->_conta_rede($pat, 'D', $qtde_rd);
                if($qtde_rd == $qtde_re):
                    // Verifica qual a rede de derramamento do patrocinador para alocar o novo associado nela
                    // quando não for possível alocá-lo em nenhum outro local.
                    $patrocinador = $this->getAssociado($pat, '', '', '', 'rede');
                    $derramamentoPatrocinador = $patrocinador->row();
                    $rede = $derramamentoPatrocinador->rede;
                elseif($qtde_re < $qtde_rd):
                    $rede = 'E';
                else:
                    $rede = 'D';
                endif;
			elseif($this->binarioE < $this->binarioD):
			  $rede = 'E';
			else:
			  $rede = 'D';
            endif;
		endif;
		
		$this->patrocinador = FALSE;
		$this->_setUpline($pat, $rede);
		
        $associado = array(
                            'patrocinador'=>$pat,
                            'upline'=>$this->upline,
                            'rede'=>$rede,
                            'novos_cadastros'=>'AUTO',
                            'dtcadastro'=>date('Y-m-d'));
        return $associado;
	}
	
	function _setDadosPessoais($dados, $aid)
	{
		//dados pessoais
		$dados_pessoais = array(
							'aid'=>$aid,
							'nome_completo'=>$dados['dados_pessoais']['nome_completo'],
							'sexo'=>$dados['dados_pessoais']['sexo'],
							'dtnasc'=>$dados['dados_pessoais']['dtnasc'],
							'cpf'=>$dados['dados_pessoais']['cpf'],
							'rg'=>$dados['dados_pessoais']['rg'],
							'pis_pasep'=>$dados['dados_pessoais']['pis_pasep'],
							'profissao'=>$dados['dados_pessoais']['profissao'],
							'tel_fixo'=>$dados['dados_pessoais']['tel_fixo'],
                            'tel_celular'=>$dados['dados_pessoais']['tel_celular'],
                            'tel_comercial'=>$dados['dados_pessoais']['tel_comercial']
							);
		$this->nm_novo_associado = $dados['dados_pessoais']['nome_completo'];					
		/*if($dados['dados_pessoais']['tp_cadastro'] == 'PJ'):
			$dados_pessoais = array('empresa'=>$this->_setDadosEmpresa($dados['dados_empresa'], $aid),
									'contato'=>$dados_pessoais);
		endif;*/
		return $dados_pessoais;
		
	}
	
	function _setDadosEmpresa($dados, $aid)
	{		
		$dados_empresa = array(
							'aid'=>$aid,
							'razao_social'=>$dados['razao_social'],
							'nome_fantasia'=>$dados['nome_fantasia'],
							'cnpj'=>$dados['cnpj'],
							'ie'=>$dados['ie']
							);
		$this->nm_novo_associado = $dados['nome_fantasia'];
		return $dados_empresa;
	}
	
	function _setConfigAssociado($aid, $form_pgto = "")
	{
		$config = array(
						'aid'=>$aid); 
						
						//,
						//'forma_pgto_plano'=>$form_pgto);
		return $config;
	}
	
	function _setEndereco($dados, $aid)
	{
		$endereco = array(
						'aid'=>$aid,
						'tipo'=>$dados['tipo'],
						'cep'=>$dados['cep'],
						'logradouro'=>$dados['logradouro'],
						'numero'=>$dados['numero'],
						'complemento'=>$dados['complemento'],
						'bairro'=>$dados['bairro'],
						'cidade'=>$dados['cidade'],
						'estado'=>$dados['estado']
						);
		return $endereco;
	}
	
	function _setInfoBanco($dados, $aid)
	{
		$infobanco = array(
					 'aid'=>$aid,
                     'titular'=>$dados['titular'],
                     'banco'=>$dados['banco'],
                     'tpconta'=>$dados['tpconta'],
                     'agencia'=>$dados['agencia'],
                     'conta'=>$dados['conta'],
                     'op'=>$dados['op']
					  );
		return $infobanco;
	}

    function getFaturas($key = '', $value = '', $fields = "", $status="")
    {
        if(!empty($fields))
            $this->db->select($fields);
        //$this->db->from('get_faturas');

        if($key != ''):
            if($value == 'NULL')
                $this->db->where("$key IS NULL");
            else
                $this->db->where($key, $value);
        endif;

        if(!empty($status))
            $this->db->where('status', $status);

        $faturas = $this->db->get('get_faturas');
        //echo $faturas->num_rows();
        if($faturas->num_rows() > 0):
            return $faturas;
        else:
            return FALSE;
        endif;
    }

    function getUserByLogin($login){

        $this->db->where("username", $login);
        $this->db->select('aid');
        $user = $this->db->get('users');
        if($user->num_rows() > 0)
            return $user->row();
        else
            return FALSE;

    }

    function getFundo($aid){
        $fundo = $this->db->query("
                    select fid
                    from fundo_origem
                    where aid = $aid
        ");

        if($fundo->num_rows() > 0)
            return $fundo->row();
        else
            return FALSE;

    }



}
/* End of file associados.php */
/* Location: ./system/application/models/adm/modelassociados.php */