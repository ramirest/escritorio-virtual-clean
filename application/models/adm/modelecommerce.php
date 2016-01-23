<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelecommerce extends CI_Model {

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
     * 1 - EscritÃ³rio Virtual
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

    function listaProdutos($sku=""){
        $db_loja = $this->load->database('loja', TRUE);

        if(!empty($sku))
            $and_where="AND sku = $sku";
        else
            $and_where="LIMIT 4";

        $produtos = $db_loja->query("
                            select * from lista_produtos where status = 1 and sku != '21656932561' $and_where
            ");
        return $produtos;
    }

    function getFaturasProdutos($key, $value){

        $where_data = "$key = $value";

        $faturas = $this->db->query("
                    select
                        pvid pid,
                        dtpedido,
                        f.fid,
                        f.valor,
                        f.dtvencimento,
                        f.status,
                        ass.aid,
                        ass.cep,
                        ass.logradouro,
                        ass.numero,
                        ass.complemento,
                        ass.bairro,
                        ass.cidade,
                        ass.estado,
                        ass.cpf,
                        ass.Nome
                    from pedidos_venda pv
                    inner join faturas f on f.pid = pv.pvid
                    inner join get_associado ass on ass.aid = pv.aid
                    where $where_data
        ");

        return $faturas;
    }

}

/* End of file modelecommerce.php */
/* Location: ./system/application/models/adm/modelecommerce.php */