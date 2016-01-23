<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelestoque extends CI_Model {

    var $tabela1 = 'movimentacao_estoque';
    var $tabela2 = 'produtos';
    var $tabela3 = 'revista';
    var $tabela4 = 'associados';
    var $tabela5 = 'ass_dados_pessoais';
    var $tabela6 = 'users';
    var $tabela7 = 'parceiros';

    function __construct()
    {
        parent::__construct();
    }

    /*
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
    */

    function listaProdutos($tipo)
    {
        if ($tipo == "S") {
            $fields = "m.meid, m.tipo, m.data, m.qtde, prod.pid, prod.descricao, d.nome_completo";
            $jointable = $this->tabela5." d";
            $on = "d.aid = m.aid";
        }
        else {
            $fields = "m.meid, m.tipo, m.data, m.qtde, prod.pid, prod.descricao";
            $jointable = $this->tabela7." p";
            $on = "p.pid = m.fornecedor";
        }
        $this->db->select($fields);
        $this->db->from($this->tabela1." m");
        $this->db->join($this->tabela3." rev", "rev.rid = m.rid");
        $this->db->join($this->tabela2." prod","prod.pid = rev.pid");
        $this->db->join($jointable, $on);
        $produto = $this->db->get();

        if($produto->num_rows() == 0)
            return FALSE;
        else
            return $produto;
    }


    function produtos()
    {
        $this->db->select("prod.descricao, rev.rid rid, rev.descricao descri");
        $this->db->from($this->tabela2." prod");
        $this->db->join($this->tabela3." rev", "prod.pid = rev.pid");
        $produtos = $this->db->get();

        if($produtos->num_rows() == 0)
            return FALSE;
        else
            return $produtos;
    }

    function selAssoc($username) {
        $this->db->select("u.aid");
        $this->db->from($this->tabela6." u");
        $this->db->where("username", $username);
        $aiduser = $this->db->get();
        if ($aiduser->num_rows() == 0)
            return FALSE;
        else
            return $aiduser->row();
    }

    function selAllAssoc() {
        $this->db->select("u.aid, u.username, dp.nome_completo");
        $this->db->from($this->tabela6." u");
        $this->db->join($this->tabela5." dp", "u.aid = dp.aid");
        $this->db->where("u.aid NOT BETWEEN 0 AND 31");
        $this->db->order_by("dp.nome_completo", "ASC");
        $allusers = $this->db->get();
        if ($allusers->num_rows() == 0)
            return FALSE;
        else
            return $allusers;
    }

    function selAllParc() {
        $this->db->select("p.pid, p.fantasia");
        $this->db->from($this->tabela7." p");
        $this->db->order_by("p.fantasia", "ASC");
        $allparc = $this->db->get();
        if ($allparc->num_rows() == 0)
            return FALSE;
        else
            return $allparc;
    }

    function atualizaEstoque($qtde, $rid, $tipo) {
        /*
        $coluna = array(
                    'qtde' => "qtde - $qtde"
        );
        $this->db->update('estoque',$coluna,);
        */
        $operador = $tipo == 'E'?'+':'-'; //identifica se é entrada ou saída no estoque, se entrada $operador +, se saída $operador -
        $this->db->set('qtde',"qtde $operador $qtde",FALSE);
        $this->db->where('rid', $rid);
        $this->db->update('estoque');
    }

    function movEstoqueSaidaRev($rid, $aid, $qtde, $datamov) {
        $this->db->set('rid',$rid);
        $this->db->set('aid',$aid);
        $this->db->set('tipo','S');
        $this->db->set('qtde',$qtde);
        $this->db->set('data',$datamov);
        $this->db->insert('movimentacao_estoque');
    }

    function movEstoqueEntradaRev($rid, $parc, $qtde, $datamov) {
        $this->db->set('rid',$rid);
        $this->db->set('fornecedor',$parc);
        $this->db->set('tipo','E');
        $this->db->set('qtde',$qtde);
        $this->db->set('data',$datamov);
        $this->db->insert('movimentacao_estoque');
    }


}


/* End of file modelrede.php */
/* Location: ./system/application/models/adm/modelrede.php */