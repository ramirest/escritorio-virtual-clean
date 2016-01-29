<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelLocalizacao extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->_estados = "estados";
        $this->_cidades = "cidades";
        $this->_bairros = "bairros";
        $this->_enderecos = "enderecos";
	}

	function getEndereco($cep)
	{
        $sql = $this->db->query("SELECT en.logracompl endereco, b.nome bairro, c.nome cidade, es.uf estado
                                 FROM enderecos en LEFT JOIN bairros b ON (b.id = en.bairro_id)
                                                   LEFT JOIN cidades c ON (c.id = b.cidade)
                                                   LEFT JOIN estados es ON (es.id = c.estado_cod)
                                 WHERE en.cep = '$cep'
                                 UNION
                                 SELECT '' endereco, '' bairro, c.nome cidade, es.uf estado
                                 FROM cidades c INNER JOIN estados es ON (es.id = c.estado_cod)
                                 WHERE cep = '$cep' LIMIT 1");
        if($sql->num_rows() > 0)
            return $sql->row();
        else
            return FALSE;
    }

    function getBairro($bairro = "")
    {
        $this->db->select("b.nome bairro");
        $this->db->from($this->_bairros." b");
        $this->db->join($this->_cidades." c", "c.id = b.cidade");
        $this->db->join($this->_estados." e", "e.id = c.estado_cod");
        if(!empty($bairro))
            $this->db->where("b.nome", $bairro);

        $bairros = $this->db->get();

        if($bairros->num_rows() > 0)
            return $bairros;
        else
            return FALSE;
    }

    function getCidade($cidade = "")
    {
        $this->db->select("c.nome cidade");
        $this->db->from($this->_cidades." c");
        $this->db->join($this->_estados." e", "e.id = c.estado_cod");
        if(!empty($cidade))
            $this->db->where("c.nome", $cidade);

        $cidades = $this->db->get();

        if($cidades->num_rows() > 0)
            return $cidades;
        else
            return FALSE;
    }

    function getEstado($estado = "")
    {
        if(!empty($estado))
            $this->db->where("e.uf", $estado);

        $estados = $this->db->get($this->_estados);

        if($estados->num_rows() > 0)
            return $estados;
        else
            return FALSE;
   }
}