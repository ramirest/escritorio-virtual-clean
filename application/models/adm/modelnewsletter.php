<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelnewsletter extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function salvar($titulo, $mensagem){
        $this->db->set(array('titulo'=>$titulo, 'mensagem'=>$mensagem));
        $this->db->insert("mmn_newsletters");
    }

}

/* End of file modelnewsletter.php */
/* Location: ./system/application/models/adm/modelnewsletter.php */