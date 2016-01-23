<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelboleto extends CI_Model {
	
    function __construct(){
        parent::__construct();
    }

    function getBoleto($campos = "")
    {
        if($campos != ""):
            $this->db->select($campos);
        else:
            $this->db->select("*");
        endif;
        $this->db->from("config_boleto");
        
        $dados = $this->db->get();
        if($dados->num_rows() > 0):
            return $dados;
        else:
            return FALSE;
        endif;

    }

    function salva_boleto($dados)
    {
        $this->db->update("config_boleto", $dados);
    }
	
}

/* End of file modelboleto.php */
/* Location: ./system/application/models/modelboleto.php */