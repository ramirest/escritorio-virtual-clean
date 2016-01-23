<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelpaginas extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function getPagina($pid = '', $verifica = ''){
        $this->db->select("*");
        $this->db->from("mmn_paginas");
        if($pid != ''):
            $this->db->where("pid", $pid);
        endif;
        if($verifica != ''):
            $this->db->where("titulo", $verifica);
        endif;
        $this->db->order_by('titulo', 'asc');

        $pagina = $this->db->get();

        if($pagina->num_rows() > 0):
            return $pagina;
        else:
            return FALSE;
        endif;
    }

    function inserirPagina($dados){
        //verificar se a pagina ja esta cadastrada
        if($this->getPagina('', $dados['titulo']) === FALSE):
            $this->db->set($dados);
            $this->db->insert("mmn_paginas");
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function editarPagina($dados){
        $this->db->set($dados);
        $this->db->where("pid", $dados['pid']);
        $this->db->update("mmn_paginas");
    }

    function excluirPagina($pid){
        $this->db->where("pid", $pid);
        $this->db->delete("mmn_paginas");
    }

}

/* End of file modelpaginas.php */
/* Location: ./system/application/models/adm/modelpaginas.php */