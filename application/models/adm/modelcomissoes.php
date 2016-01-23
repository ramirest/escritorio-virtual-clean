<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelcomissoes extends CI_Model {

	function __contruct()
	{
		parent::__construct();
	}

    function inserirComissao($uid, $downline = '', $valor = 0.0, $tipo = '', $descricao = '')
    {
        $dados = array('uid'=>$uid, 'downline'=>$downline, 'valor'=>$valor, 'tipo'=>$tipo, 'descricao'=>$descricao);
        $this->db->insert("mmn_comissoes", $dados);
    }

    function getComissao($cid = '', $uid = '', $resumido = false, $ano = '', $mes = '')
    {
        if($resumido == true):
          $sql_frag = ", sum(c.valor) valor";
        else:
          $sql_frag = "";
        endif;
        $this->db->select("c.*, i.nome_completo indicado, a.nome_completo associado, a.uid codigo".$sql_frag);
        $this->db->from("mmn_comissoes c");
        $this->db->join("mmn_usuarios i", "i.uid = c.downline");
        $this->db->join("mmn_usuarios a", "a.uid = c.uid");
        if($cid != ''):
          $this->db->where("c.cid", $cid);
        endif;

        if($uid != ''):
          $this->db->where("c.uid", $uid);
        endif;

        if(($ano && $mes) != ''):
          if($mes != 'todos')
            $this->db->like('c.data', $ano."-".$mes);
        endif;

        if($resumido == true):
          $this->db->group_by("associado, pago");
          $this->db->order_by("associado, valor", "asc");
        else:
          $this->db->order_by("associado, valor", "asc");
        endif;

	$comissoes = $this->db->get();
        if($comissoes->num_rows() > 0):
            return $comissoes;
        else:
            return FALSE;
        endif;
    }

    function update($cid, $obj, $codigo = '') {
            if($codigo == ''):
              $this->db->where('cid', $cid);
            else:
              $this->db->where('uid', $codigo);
            endif;
            $this->db->update("mmn_comissoes", $obj);
    }
}


/* End of file modelcomissoes.php */
/* Location: ./system/application/models/adm/modelcomissoes.php */