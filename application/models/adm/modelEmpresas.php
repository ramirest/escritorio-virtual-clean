<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelEmpresas extends CI_Model {

    var $tabela_1 = "empresa";
    var $tabela_2 = "parceiros";

	function __construct()
	{
		parent::__construct();
	}

    function getEmpresas($key = '', $value = '')
    {
        $this->db->select("eid, razao_social", FALSE);
        $this->db->from($this->tabela_1." emp");
        $this->db->join($this->tabela_2." par", "emp.pid = par.pid", "inner");

        if($key != ''):
            $this->db->where($key, $value);
        endif;

        $empresas = $this->db->get();

        if($empresas->num_rows() > 0)
            return $empresas;
        else
            return FALSE;
    }

}

/* End of file modelEmpresas.php */
/* Location: ./sys/application/models/adm/modelEmpresas.php */