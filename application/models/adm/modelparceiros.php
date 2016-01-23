<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelparceiros extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_tabela = "parceiros";
	}
	
	function _setParceiro($dados)
	{
		//configura os campos a serem inseridos no banco de dados
		$parceiro = array(
					   'pid'=>$dados['pid'],
					   'nome'=>$dados['nome'],
					   );
		return $parceiro;
	}
	
	function inserirParceiro($dados)
	{
		$this->db->set($this->_setParceiro($dados));
		$this->db->insert($this->_tabela);
		return TRUE;
	}
	
	function editarParceiro($dados)
	{
		$this->db->set($this->_setParceiro($dados));
		$this->db->where("pid", $dados['pid']);
		$this->db->update($this->_tabela);
	}
	
    function excluirParceiro($pid){
        $this->db->where("pid", $pid);
        $this->db->delete($this->_tabela);
    }

	function getParceiro($key = '', $value = '')
	{
		$this->db->select("*");
		$this->db->from($this->_tabela);
		
		if($key != ''):
			$this->db->where($key, $value);
		endif;
			$this->db->order_by('nome', 'asc');
		
		$parceiros = $this->db->get();
		
		if($parceiros->num_rows() > 0):
			return $parceiros;			
		else:
			return false;
		endif;
	}

}

/* End of file modelparceiros.php */
/* Location: ./sys/app/models/adm/modelparceiros.php */