<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelprodutos extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_categoria($cat = '', $orderby = '', $groupby = '')
	{
		$this->db->select("*");
		$this->db->from("mmn_categoria");
		if($cat != ''):
			$this->db->where("cid", $cat);
		endif;
        if($orderby != ''):
            $this->db->order_by($orderby);
        endif;
        if($groupby != ''):
            $this->db->group_by($groupby);
        endif;
		
		$categoria = $this->db->get();
		
		if($categoria->num_rows > 0):
			return $categoria;
		else:
			return false;
		endif;		
	}
	
	function inserirCategoria($dados)
	{
		$this->db->set($this->_setCategoria($dados));
		$this->db->insert("mmn_categoria");
	}
	
	function editarCategoria($dados)
	{
		$this->db->set($this->_setCategoria($dados));
		$this->db->where("cid", $dados['cid']);
		$this->db->update("mmn_categoria");
	}

    function excluirCategoria($cid)
    {
        $this->db->where("cid", $cid);
        $this->db->delete("mmn_categoria");
    }
	
	function _setCategoria($dados)
	{
		if(isset($dados['cpid'])):
			$cpid = $dados['cpid'];
		else:
			$cpid = 0;
		endif;
		$categoria = array(
						   'nome'=>$dados['nome'],
						   'descricao'=>$dados['descricao'],
						   'cpid'=>$cpid,
						   'cn1'=>$dados['cn1'],
						   'cn2'=>$dados['cn2'],
						   'cn3'=>$dados['cn3'],
						   'cn4'=>$dados['cn4'],
						   'cn5'=>$dados['cn5']						   
						   );
		return $categoria;
	}
	
	function get_produto($pid = '', $orderby = '', $groupby = '')
	{
		$this->db->select("p.pid, p.cid, p.nome produto, p.pid, p.descricao, c.nome categoria");
		$this->db->from("mmn_produtos p");
		$this->db->join("mmn_categoria c", "c.cid = p.cid");
		if($pid != ''):
			$this->db->where("pid", $pid);
		endif;
        if($orderby != ''):
            $this->db->order_by($orderby);
        endif;
        if($groupby != ''):
            $this->db->group_by($groupby);
        endif;
		
		$produto = $this->db->get();
		
		if($produto->num_rows > 0):
			return $produto;
		else:
			return false;
		endif;		
	}
	
	function inserirProduto($dados)
	{
		$this->db->set($this->_setProduto($dados));
		$this->db->insert("mmn_produtos");
	}
	
	function editarProduto($dados)
	{
		$this->db->set($this->_setProduto($dados));
		$this->db->where("pid", $dados['pid']);
		$this->db->update("mmn_produtos");
	}

    function excluirProduto($pid)
    {
        $this->db->where("pid", $pid);
        $this->db->delete("mmn_produtos");
    }
	
	function _setProduto($dados)
	{
		if(isset($dados['cid'])):
			$cid = $dados['cid'];
		else:
			$cid = 0;
		endif;
		$produto = array(
						'cid'=>$cid,
						'nome'=>$dados['nome'],
						'descricao'=>$dados['descricao'],
						'valor'=>$dados['valor'],
						'desconto_promo'=>$dados['desconto_promo'],
						'peso'=>$dados['peso'],
						'qtde_estoque'=>$dados['qtde_estoque']
						   );
		return $produto;
	}
	
}
/* End of file modelprodutos.php */
/* Location: ./system/application/models/adm/modelprodutos.php */