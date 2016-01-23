<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelgeneral extends CI_Model {

    function fillCombo($query, $key, $value, $empty_value="0")
    {
        $dropdowns = $query->result();
        $dropDownList[$empty_value] = "Selecione";
        foreach($dropdowns as $dropdown)
        {
            $dropDownList[$dropdown->$key] = $dropdown->$value;
        }
        $finalDropDown = $dropDownList;
        return $finalDropDown;
    }


    /*
     * @abstract Registra os logs do sistema de acordo com seus tipos, o quais são:
     * INFO - Logs informativos de eventos do sistema.
     * ERRO - Logs de erros no sistema.
     * DEBUG - Logs de eventos para debug do sistema.
     *
     * origem_log:
     * 1 - Escritório virtual
     * 2 - Revista Pillares
     *
     * @param @tipo
     * @param @descricao
     * @param @rotina
     * @param @metodo
     * @param @origem_log
     */

    function geraLog($tipo, $descricao, $rotina = "", $metodo = "", $origem_log=1)
    {
        $log = array(
            'tipo'=>$tipo,
            'descricao'=>$descricao,
            'rotina'=>$rotina,
            'metodo'=>$metodo,
            'oid'=>$origem_log);

        $this->db->set($log);
        $this->db->insert("logs");
    }

}
