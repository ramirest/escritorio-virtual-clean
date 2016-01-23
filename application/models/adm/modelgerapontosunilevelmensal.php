<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelgerapontosunilevelmensal extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * @abstract Registra os logs dos processamentos de pontos
     *
     * TIPO:
     * INFO - Logs informativos.
     * ERRO - Logs de erros.
     * DEBUG - Logs de eventos para debug do sistema.
     *
     * ORIGEM LOG:
     * 1 - Escritório Virtual
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

    function geraRegistroPontosUnilevelTodosAssociados(){
        $this->db->query("
            insert into pontos_unilevel (aid, pontos_g1, pontos_g2, pontos_g3, pontos_g4, pontos_g5, pontos_g6, pontos_g7, pontos_g8,
			pontos_g9, pontos_g10, pontos_g11, pontos_g12, mes, ano)
            select aid, 0 pontos_g1, 0 pontos_g2, 0 pontos_g3, 0 pontos_g4, 0 pontos_g5, 0 pontos_g6, 0 pontos_g7, 0 pontos_g8,
                   0 pontos_g9, 0 pontos_g10, 0 pontos_g11, 0 pontos_g12, month(now()) mes, year(now()) ano
            from associados
        ") or die($this->geraLog('ERRO',"Erro ao gerar os registros dos pontos unilevel do mês. Erro: " . mysql_error().'---'.mysql_errno(),'GeraPontosUnilevelMensal','geraRegistroPontosUnilevelTodosAssociados'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Registros dos pontos unilevel do mês gerados com sucesso.",'GeraPontosUnilevelMensal','geraRegistroPontosUnilevelTodosAssociados');
        else:
            $this->geraLog('INFO',"Registros dos pontos unilevel do mês NÃO foram gerados.",'GeraPontosUnilevelMensal','geraRegistroPontosUnilevelTodosAssociados');
        endif;
    }
}