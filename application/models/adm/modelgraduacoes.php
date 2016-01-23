<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelgraduacoes extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_tabela = "graduacoes";
	}
	
	function _setGraduacao($dados)
	{
		$graduacao = array(
					   'nmgraduacao'=>$dados['nmgraduacao'],
					   'pontos'=>$dados['pontos']
					   );
		return $graduacao;
	}
	
	function inserirGraduacao($dados)
	{
        //verificar se a graduação ja esta cadastrada
        if($this->getGraduacao('nmgraduacao', $dados['nmgraduacao']) === FALSE):
            $this->db->set($this->_setGraduacao($dados));
            $this->db->insert($this->_tabela);
            return TRUE;
        else:
            return FALSE;
        endif;
   
	}
	
	function editarGraduacao($dados)
	{
		$this->db->set($this->_setGraduacao($dados));
		$this->db->where("gid", $dados['gid']);
		if($this->db->update($this->_tabela))
		  return TRUE;
		else
		  return FALSE;
	}
	
    function excluirGraduacao($pid){
        $this->db->where("gid", $pid);
        $this->db->delete($this->_tabela);
    }

	function getGraduacao($key = '', $value = '')
	{
		$this->db->select();
		$this->db->from($this->_tabela);
		
		if($key != ''):
			$this->db->where($key, $value);
		endif;
                $this->db->order_by('pontos', 'asc');
		
		$graduacoes = $this->db->get();
		
		if($graduacoes->num_rows() > 0):
			return $graduacoes;			
		else:
			return FALSE;
		endif;
	}

}

/* End of file modelgraduacoes.php */
/* Location: ./system/application/models/adm/modelgraduacoes.php */