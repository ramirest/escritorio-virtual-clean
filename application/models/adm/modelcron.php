<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ModelCron extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Verifica se script está ativo e se ele já foi executado
     * do contrário, não permite sua execução
     */
    function verificaStatusScript($script){
        $ret = $this->db->query("
                        select status from scripts
                        where descricao = '$script'
                        and status = 'A'
                        and (day(data_execucao) != day(now()) or data_execucao is null)
        ");

        if($ret->num_rows() > 0):
            $this->db->set('data_execucao', 'now()', FALSE);
            $this->db->where('descricao', $script);
            $this->db->update('scripts');
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}