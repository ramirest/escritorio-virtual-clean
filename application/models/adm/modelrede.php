<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelrede extends CI_Model {
	
	var $tabela1 = 'associados';
	var $tabela2 = 'ass_dados_pessoais';
	var $tabela3 = 'ass_pj';
	var $tabela4 = 'graduacoes';
	var $tabela5 = 'ass_rendimentos';
	var $tabela6 = 'get_associado';
	function __construct()
	{
		parent::__construct();
	}
	
	function getLinear($associado)
	{
		$this->db->select("ass.aid, ass.rede, IF(ass.tp_cadastro = 'PF', pessoaf.nome_completo, pessoaj.nome_fantasia) as nome", FALSE);
		$this->db->from($this->tabela1." ass");
		$this->db->join($this->tabela2." pessoaf", "pessoaf.aid = ass.aid");
		$this->db->join($this->tabela3." pessoaj", "pessoaj.aid = ass.aid");
		$this->db->where("ass.patrocinador", $associado);
		$linear = $this->db->get();
		
		if($linear->num_rows() == 0)
			return FALSE;
		else
			return $linear;
	}
	
	/**
	 * 
	 * @param integer $associado
	 * @param integer $deep
     * @param integer $level
     * @param array $rede
	 */

    var $div = '%s<tr><td>%s</td><td>#%s</td><td>%s</td></tr>';

    function getUnilevel($associado, $deep, $level, &$rede){
        $this->db->select("aid, patrocinador, Nome, Login");
        $this->db->where('patrocinador', $associado);
        $associados = $this->db->get('get_associado');

        if($associados->num_rows() > 0):
            $i = 0;
            foreach($associados->result() as $ass):
                $i++;
                $rede[$level][] = sprintf($this->div, "", $ass->Nome, $ass->aid, $ass->Login);
                if($i <= $deep)
                    $this->getUnilevel($ass->aid, $deep-1, $level+1, $rede);
            endforeach;
        endif;

    }

    /**
     * Conta a quantidade de pessoas esse empresário patrocinou pessoalmente
     *
     * @param $patrocinador integer
     * @return integer
     */

    function CountPatrocinador($patrocinador)
    {
        $this->db->where("patrocinador", $patrocinador);

        return $this->db->count_all_results("get_associado");
    }

	function find($aid)
	{
		$this->db->where("aid", $aid);
		$binario = $this->db->get("monta_rede");

		if($binario->num_rows() == 0)
			return FALSE;
		else
			return $binario->row();
	}

	function getBinario($associado, $rede = "")
	{
		$this->db->where("upline", $associado);
		if($rede != "") $this->db->where("rede", $rede);
		$binario = $this->db->get("monta_rede");
		
		if($binario->num_rows() == 0)
			return FALSE;
		else
			return $binario;
	}
	
	function arvore($associado)
	{	
		$binario = $this->db->query("SELECT a1.aid aid1, a1.Nome nome1, a1.rede rede1, 
		(SELECT Nome from get_associado where aid = a1.patrocinador) patrocinador1, 
		a1.patrocinador pat_id1, a1.graduacao graduacao1, a1.status status1, a1.plano plano1, a1.valor_plano valor_plano1, a2.aid aid2, a2.Nome nome2,
		a2.rede rede2, (SELECT Nome from get_associado where aid = a2.patrocinador) patrocinador2, 
		a2.patrocinador pat_id2, a2.graduacao graduacao2, a2.status status2, a2.plano plano2, a2.valor_plano valor_plano2
		FROM get_associado a1
		LEFT JOIN get_associado a2 ON (a2.upline = a1.aid)
		WHERE a1.aid = $associado");
		
		if($binario->num_rows() == 0)
			return FALSE;
		else
			return $binario;
	}
	
	
	function get_arvore($associado, $rede = "")
	{	
		$this->db->select("a1.aid aid1, a1.Nome nome1, a1.rede rede1, (SELECT Nome from get_associado where aid = a1.patrocinador) patrocinador1, a1.graduacao graduacao1, a1.status status1");
		$this->db->select("a2.aid aid2, a2.Nome nome2, a2.rede rede2, (SELECT Nome from get_associado where aid = a2.patrocinador) patrocinador2, a2.graduacao graduacao2, a2.status status2");
		$this->db->select("a3.aid aid3, a3.Nome nome3, a3.rede rede3, (SELECT Nome from get_associado where aid = a3.patrocinador) patrocinador3, a3.graduacao graduacao3, a3.status status3");
		$this->db->select("a4.aid aid4, a4.Nome nome4, a4.rede rede4, (SELECT Nome from get_associado where aid = a4.patrocinador) patrocinador4, a4.graduacao graduacao4, a4.status status4");
		$this->db->select("a5.aid aid5, a5.Nome nome5, a5.rede rede5, (SELECT Nome from get_associado where aid = a5.patrocinador) patrocinador5, a5.graduacao graduacao5, a5.status status5");
		$this->db->from($this->tabela6." a1");
		$this->db->join($this->tabela6." a2", "a2.upline = a1.aid");
		$this->db->join($this->tabela6." a3", "a3.upline = a2.aid");
		$this->db->join($this->tabela6." a4", "a4.upline = a3.aid");
		$this->db->join($this->tabela6." a5", "a5.upline = a4.aid");
		$this->db->where("a1.aid", $associado);
		if($rede != "") $this->db->where("a2.rede", $rede);
		$this->db->group_by(array("a2.rede", "a3.rede", "a4.rede", "a5.rede"));
		//$this->db->order_by("a5.aid", "desc");
		$binario = $this->db->get($this->tabela6);
		
		if($binario->num_rows() == 0)
			return FALSE;
		else
			return $binario;
	}
	
	/*
	*
	* @param $field Campo a ser retornado do banco de dados
	* @param $aid Código do associado
	* @param $aid Flag indicadora se deve haver um relacionamento com a tabela de dados pessoais/contato associado
	* @param $aid Flag indicadora se deve haver um relacionamento com a tabela de graduações
	* @return String
	*/
	
	function getField($field, $aid, $rel_ass = FALSE, $rel_grad = FALSE)
	{
		$this->db->select($field);
		$this->db->from($this->tabela1." ass");
		if($rel_ass === TRUE):
			$this->db->join($this->tabela2." pessoaf", "pessoaf.aid = ass.aid", "left");
			$this->db->join($this->tabela3." pessoaj", "pessoaj.aid = ass.aid", "left");
		endif;
		if($rel_grad === TRUE):
			$this->db->join($this->tabela4." grad", "grad.gid = ass.graduacao");
		endif;
		$this->db->where("ass.aid", $aid);
		
		$res = $this->db->get();
		
		if($res->num_rows() == 0):
			return FALSE;
		else:
			foreach($res->result() as $f):
				return $f->$field;
			endforeach;
		endif;
	}

    /*
     * @abstract Verifica se a solicitação de saque feita pelo associado poderá ser concretizada
     */

    function verificaSolicitacaoSaque($aid)
    {
        $solicitacao = $this->db->query("
                                select a.aid,
                                    (select count(*) from associados where patrocinador = a.aid and rede = 'D' and status = 'A') total_direita,
                                    (select count(*) from associados where patrocinador = a.aid and rede = 'E' and status = 'A') total_esquerda,
                                    (select count(*) from ass_dependentes where aid = a.aid) total_dependentes,
                                    (select count(*) from ass_info_banco where aid = a.aid) total_contas,
                                    (select count(*) from ass_dados_pessoais where aid = a.aid and pis_pasep <> '') pis_pasep,
                                    (select (case when sum(valor_inss) is not null then sum(valor_inss)+sum(valor_taxa)+sum(valor_inss)+sum(valor_ir) else 0 end) valor_inss from ass_solicitacao_deposito where aid = a.aid
                                                                                          and year(data_solicitacao) = year(curdate())
                                                                                          and month(data_solicitacao) = month(curdate())) inss_pago,
                                    (select (case when sum(valor) is not null then sum(valor) else 0 end) valor from ass_solicitacao_deposito where aid = a.aid
                                                                                                                    and data_deposito is not null
																													and year(data_solicitacao) = year(curdate())
																													and month(data_solicitacao) = month(curdate())) valor_pago
                                from associados a
                                where a.aid = $aid
                                and a.status = 'A'
                            ");

        if($solicitacao->num_rows() > 0)
            return $solicitacao->row();
        else
            return FALSE;
    }

    function buscaParametrosInss()
    {
        $parametros = $this->db->query("
                                select percentual_inss, teto_inss, valor_dependente
                                from ass_parametros_impostos
                                where year(dt_inicial) = year(curdate())
                                and dt_final is null
                            ");

        if($parametros->num_rows() > 0)
            return $parametros->row();
        else
            return FALSE;
    }

    function buscaParametrosIrrf($valor)
    {
        $parametros = $this->db->query("
                                    select * from
                                    (select base_calculo_inicial, (case when base_calculo_final is null then 99999999999999 else base_calculo_final end) base_calculo_final, aliquota, parcela_deduzir, dt_inicial, dt_final
                                    from ass_irrf
                                    where dt_final is null) temp
                                    where $valor between base_calculo_inicial and base_calculo_final");

        if($parametros->num_rows() > 0)
            return $parametros->row();
        else
            return FALSE;
    }
	
}


/* End of file modelrede.php */
/* Location: ./system/application/models/adm/modelrede.php */