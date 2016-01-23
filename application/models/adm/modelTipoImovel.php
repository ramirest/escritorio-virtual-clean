<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelTipoImovel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->_tabela = "tipo_imovel";
    }

    function getTipoImovel($key = '', $value = '')
    {
        if($key != ''):
            $this->db->where($key, $value);
        endif;

        $this->db->order_by('descricao', 'asc');

        $tipoImovel = $this->db->get($this->_tabela);

        if($tipoImovel->num_rows() > 0)
            return $tipoImovel;
        else
            return FALSE;
    }

}

/* End of file modelTipoImovel.php */
/* Location: ./system/application/models/adm/modelTipoImovel.php */