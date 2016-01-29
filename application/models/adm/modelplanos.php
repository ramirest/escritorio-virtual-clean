<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelplanos extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_tabela = "planos";
	}
	
	function _setPlano($dados)
	{
		$plano = array(
					   'nmplano'=>$dados['nmplano'],
					   'percentual_ganho'=>$dados['percentual_ganho'],
					   'info'=>$dados['info'],
					   'valor_plano'=>$dados['valor_plano'],
					   'valor_entrada'=>$dados['valor_entrada'],
					   'qtde_parcelas'=>$dados['qtde_parcelas'],
					   'valor_parcelas'=>$dados['valor_parcelas'],
					   'pontos_binario'=>$dados['pontos_binario'],
                       'pontos_binario_entrada'=>$dados['pontos_binario_entrada'],
                       'pontos_binario_parcela'=>$dados['pontos_binario_parcela'],
					   'minimo_saque'=>$dados['minimo_saque'],
					   'maximo_diario'=>$dados['maximo_diario'],
					   );
		return $plano;
	}
	
	function getCaderno($key = '', $value = '')
	{
		$this->db->select("*");
		$this->db->from($this->_tabela);
		
		if($key != ''):
			$this->db->where($key, $value);
		endif;
                $this->db->order_by('cid', 'asc');
		
		$cadernos = $this->db->get();
		
		if($cadernos->num_rows() > 0):
			return $cadernos;			
		else:
			return FALSE;
		endif;
	}
	
	
	function inserirPlano($dados)
	{
        //verificar se o plano ja esta cadastrado
        if($this->getPlano('nmplano', $dados['nmplano']) === FALSE):
            $this->db->set($this->_setPlano($dados));
            $this->db->insert($this->_tabela);
            return TRUE;
        else:
            return FALSE;
        endif;
   
	}
	
	function editarPlano($dados)
	{
		$this->db->set($this->_setPlano($dados));
		$this->db->where("pid", $dados['pid']);
		if($this->db->update($this->_tabela))
		  return TRUE;
		else
		  return FALSE;
	}
	
    function excluirPlano($pid){
        $this->db->where("pid", $pid);
        $this->db->delete($this->_tabela);
    }

	function getPlano($key = '', $value = '')
	{
		$this->db->select();
		$this->db->from($this->_tabela);
		
		if($key != ''):
			$this->db->where($key, $value);
		endif;
                $this->db->order_by('percentual_ganho', 'asc');
		
		$planos = $this->db->get();
		
		if($planos->num_rows() > 0):
			return $planos;			
		else:
			return FALSE;
		endif;
	}

}

/* End of file modelplanos.php */
/* Location: ./system/application/models/adm/modelplanos.php */