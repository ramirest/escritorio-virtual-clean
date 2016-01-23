<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelpontos extends CI_Model {

    var $tabela_1 = "ass_pedidos";
    var $tabela_2 = "ass_faturas";
    var $tabela_3 = "associados";
    var $tabela_4 = "ass_dados_pessoais";
    var $tabela_5 = "users";
    var $tabela_6 = "ass_rendimentos";
    var $tabela_7 = "ass_saldo";
    var $pedido = 0;

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

    /**
     * @abstract busca as faturas pagas para gerar os bônus
     *
     * @param string $fields
     * @return mixed
     */
    function getFaturasPagas($fields = "")
    {
        if(!empty($fields))
            $this->db->select($fields);

        $faturas = $this->db->get('get_faturas_pagas');

        if($faturas->num_rows() > 0)
            return $faturas->result();
        else
            return FALSE;
    }

    /**
     * @abstract Marca a data/hora em que os pontos foram gerados para a fatura e retorna a quantidade de linhas afetadas
     *
     * @param int $fatura
     * @return int
     */

    function setDtgeracao_pontos($fatura)
    {
        $hora = date("Y-m-d H:i:s", mktime(date('H', time()), date('i', time()), date('s', time()), date('m', time()), date('d', time()), date('Y', time())));
        $this->db->set('dtgeracao_pontos', $hora);
        $this->db->where("fid", $fatura);
        $this->db->update($this->tabela_2);
        return $this->db->affected_rows();
    }


    /*
     *
     * Método de atualização dos pontos binários de toda a linha ascendente do usuário que confirmou o pagamento
     * de sua fatura. O script busca uma determinada quantidade de registros e atualiza os pontos destes empresários
     * encontrados.
     * Na geração dos pontos é verificado a quantidade de registros afetados na atualização dos pontos,
     * sempre que houver uma quantidade igual ao total configurado para ser executado no momento, o script de atualização
     * deverá ser executado novamente para tentar gerar os pontos da linha ascendente do usuário em questão.
     * Somente quando a quantidade de registros efetados for menor que o total, termina a execução do script.
     *
     */

    function geraPontosBinario($aid, $pontos, $data)
    {
        $this->db->query("
            UPDATE pontos_binario pb
                    INNER JOIN (
                            select aid, rede, (case when rede = 'D' then $pontos else 0 end) pts_direita,
                            (case when rede = 'E' then $pontos else 0 end) pts_esquerda
                            from

                             (select ass.aid,
                                        (case when ass.aid = temp.u1 then temp.r1 else
                                        (case when ass.aid = temp.u2 then temp.r2 else
                                        (case when ass.aid = temp.u3 then temp.r3 else
                                        (case when ass.aid = temp.u4 then temp.r4 else
                                        (case when ass.aid = temp.u5 then temp.r5 else
                                        (case when ass.aid = temp.u6 then temp.r6 else
                                        (case when ass.aid = temp.u7 then temp.r7 else
                                        (case when ass.aid = temp.u8 then temp.r8 else
                                        (case when ass.aid = temp.u9 then temp.r9 else
                                        (case when ass.aid = temp.u10 then temp.r10 else
                                        (case when ass.aid = temp.u11 then temp.r11 else
                                        (case when ass.aid = temp.u12 then temp.r12 else
                                        (case when ass.aid = temp.u13 then temp.r13 else
                                        (case when ass.aid = temp.u14 then temp.r14 else
                                        (case when ass.aid = temp.u15 then temp.r15 else
                                        (case when ass.aid = temp.u16 then temp.r16 else
                                        (case when ass.aid = temp.u17 then temp.r17 else
                                        (case when ass.aid = temp.u18 then temp.r18 else
                                        (case when ass.aid = temp.u19 then temp.r19 else
                                        (case when ass.aid = temp.u20 then temp.r20 else
                                        (case when ass.aid = temp.u21 then temp.r21 else
                                        (case when ass.aid = temp.u22 then temp.r22 else
                                        (case when ass.aid = temp.u23 then temp.r23 else
                                        (case when ass.aid = temp.u24 then temp.r24 else '' end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) end) rede
                             from associados ass inner join (select
                                                                u1.aid u1,u2.aid u2,u3.aid u3,u4.aid u4,u5.aid u5,u6.aid u6,u7.aid u7,u8.aid u8,u9.aid u9,u10.aid u10,
                                                                u11.aid u11,u12.aid u12,u13.aid u13,u14.aid u14,u15.aid u15,u16.aid u16,u17.aid u17,u18.aid u18,u19.aid u19,u20.aid u20,
                                                                u21.aid u21,u22.aid u22,u23.aid u23,u24.aid u24,
                                                                a.rede r1,u1.rede r2,u2.rede r3,u3.rede r4,u4.rede r5,u5.rede r6,u6.rede r7,u7.rede r8,u8.rede r9,u9.rede r10,
                                                                u10.rede r11,u11.rede r12,u12.rede r13,u13.rede r14,u14.rede r15,u15.rede r16,u16.rede r17,u17.rede r18,u18.rede r19,u19.rede r20,
                                                                u20.rede r21,u21.rede r22,u22.rede r23,u23.rede r24
                                                            from associados a left join associados u1 on a.upline = u1.aid
                                                                              left join associados u2 on u1.upline = u2.aid
                                                                              left join associados u3 on u2.upline = u3.aid
                                                                              left join associados u4 on u3.upline = u4.aid
                                                                              left join associados u5 on u4.upline = u5.aid
                                                                              left join associados u6 on u5.upline = u6.aid
                                                                              left join associados u7 on u6.upline = u7.aid
                                                                              left join associados u8 on u7.upline = u8.aid
                                                                              left join associados u9 on u8.upline = u9.aid
                                                                              left join associados u10 on u9.upline = u10.aid

                                                                              left join associados u11 on u10.upline = u11.aid
                                                                              left join associados u12 on u11.upline = u12.aid
                                                                              left join associados u13 on u12.upline = u13.aid
                                                                              left join associados u14 on u13.upline = u14.aid
                                                                              left join associados u15 on u14.upline = u15.aid
                                                                              left join associados u16 on u15.upline = u16.aid
                                                                              left join associados u17 on u16.upline = u17.aid
                                                                              left join associados u18 on u17.upline = u18.aid
                                                                              left join associados u19 on u18.upline = u19.aid
                                                                              left join associados u20 on u19.upline = u20.aid

                                                                              left join associados u21 on u20.upline = u21.aid
                                                                              left join associados u22 on u21.upline = u22.aid
                                                                              left join associados u23 on u22.upline = u23.aid
                                                                              left join associados u24 on u23.upline = u24.aid
                                                            where a.aid = $aid) temp on (
                                                            (ass.aid = temp.u1) or
                                                            (ass.aid = temp.u2) or
                                                            (ass.aid = temp.u3) or
                                                            (ass.aid = temp.u4) or
                                                            (ass.aid = temp.u5) or
                                                            (ass.aid = temp.u6) or
                                                            (ass.aid = temp.u7) or
                                                            (ass.aid = temp.u8) or
                                                            (ass.aid = temp.u9) or
                                                            (ass.aid = temp.u10) or
                                                            (ass.aid = temp.u11) or
                                                            (ass.aid = temp.u12) or
                                                            (ass.aid = temp.u13) or
                                                            (ass.aid = temp.u14) or
                                                            (ass.aid = temp.u15) or
                                                            (ass.aid = temp.u16) or
                                                            (ass.aid = temp.u17) or
                                                            (ass.aid = temp.u18) or
                                                            (ass.aid = temp.u19) or
                                                            (ass.aid = temp.u20) or
                                                            (ass.aid = temp.u21) or
                                                            (ass.aid = temp.u22) or
                                                            (ass.aid = temp.u23) or
                                                            (ass.aid = temp.u24)) where ass.status <> 'I') temp3
                    ) temp4 ON temp4.aid = pb.aid
            SET
            pb.pontos_direita = pb.pontos_direita + temp4.pts_direita,
            pb.pontos_esquerda = pb.pontos_esquerda + temp4.pts_esquerda
            WHERE data = '$data'

        ") or die($this->geraLog('ERRO',"Erro ao gerar pontos binário para uplines do empresário #$aid. Erro: " . mysql_error().': '.mysql_errno(),'geraPontosDiario','geraPontosBinario'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Pontos binário foram gerados para os uplines do empresário #$aid.",'geraPontosDiario','geraPontosBinario');
            return $this->BuscaProximoUpline($aid);
        else:
            die($this->geraLog('INFO',"Pontos binário para uplines do empresário #$aid NÃO foram gerados. ",'geraPontosDiario','geraPontosBinario'));
        endif;
    }
    /*
     *
     *  Método que insere os registros na tabela "pontos_unilevel_origem".
     *  Cada Empresário da linha ascendente do Empresário em questão (até as 12ª geração)
     *  terá os pontos contabilizados neste momento.
     *
     *  Esta tabela se relaciona com a tabela "pontos_unilevel" com dados detalhados do ponto gerado
     *  em cada geração para que o empresário possa ter um relatório mais completo.
     *
     */

    function geraPontosUnilevelOrigem($aid, $pontos, $dt_pagamento, $mes, $ano)
    {
        $this->db->query("
                    INSERT INTO pontos_unilevel_origem (puid, associado_origem, pontos, data_processamento, data_pagamento, geracao)
                    select puid, origem, pontos, data_processamento, data_pagamento, geracao from
                    (select temp2.aid, pu.puid, temp2.origem, temp2.pontos, temp2.data_processamento, temp2.data_pagamento, temp2.geracao,
                            ceiling(pl.perc_ganhos_unilevel_g1)+ceiling(pl.perc_ganhos_unilevel_g2)+ceiling(pl.perc_ganhos_unilevel_g3)+
                            ceiling(pl.perc_ganhos_unilevel_g4)+ceiling(pl.perc_ganhos_unilevel_g5)+ceiling(pl.perc_ganhos_unilevel_g6)+
                            ceiling(pl.perc_ganhos_unilevel_g7)+ceiling(pl.perc_ganhos_unilevel_g8)+ceiling(pl.perc_ganhos_unilevel_g9)+
                            ceiling(pl.perc_ganhos_unilevel_g10)+ceiling(pl.perc_ganhos_unilevel_g11)+ceiling(pl.perc_ganhos_unilevel_g12) geracao_ganho
                    from (
                    select
                        ass.aid,
                        ass.plano_atual,
                        ass.status,
                        $aid origem,
                        $pontos pontos,
                        now() data_processamento,
                        '$dt_pagamento' data_pagamento,
                        (case when ass.aid = temp.u1 then 1 else
                        (case when ass.aid = temp.u2 then 2 else
                        (case when ass.aid = temp.u3 then 3 else
                        (case when ass.aid = temp.u4 then 4 else
                        (case when ass.aid = temp.u5 then 5 else
                        (case when ass.aid = temp.u6 then 6 else
                        (case when ass.aid = temp.u7 then 7 else
                        (case when ass.aid = temp.u8 then 8 else
                        (case when ass.aid = temp.u9 then 9 else
                        (case when ass.aid = temp.u10 then 10 else
                        (case when ass.aid = temp.u11 then 11 else
                        (case when ass.aid = temp.u12 then 12 else '' end) end) end) end) end) end) end) end) end) end) end) end) geracao
                    from associados ass inner join (select
                                                        u1.aid u1,u2.aid u2,u3.aid u3,u4.aid u4,u5.aid u5,u6.aid u6,u7.aid u7,u8.aid u8,u9.aid u9,u10.aid u10,
                                                        u11.aid u11,u12.aid u12
                                                    from associados a left join associados u1 on a.patrocinador = u1.aid
                                                                      left join associados u2 on u1.patrocinador = u2.aid
                                                                      left join associados u3 on u2.patrocinador = u3.aid
                                                                      left join associados u4 on u3.patrocinador = u4.aid
                                                                      left join associados u5 on u4.patrocinador = u5.aid
                                                                      left join associados u6 on u5.patrocinador = u6.aid
                                                                      left join associados u7 on u6.patrocinador = u7.aid
                                                                      left join associados u8 on u7.patrocinador = u8.aid
                                                                      left join associados u9 on u8.patrocinador = u9.aid
                                                                      left join associados u10 on u9.patrocinador = u10.aid
                                                                      left join associados u11 on u10.patrocinador = u11.aid
                                                                      left join associados u12 on u11.patrocinador = u12.aid
                                                    where a.aid = $aid) temp on (
                                                    (ass.aid = temp.u1) or
                                                    (ass.aid = temp.u2) or
                                                    (ass.aid = temp.u3) or
                                                    (ass.aid = temp.u4) or
                                                    (ass.aid = temp.u5) or
                                                    (ass.aid = temp.u6) or
                                                    (ass.aid = temp.u7) or
                                                    (ass.aid = temp.u8) or
                                                    (ass.aid = temp.u9) or
                                                    (ass.aid = temp.u10) or
                                                    (ass.aid = temp.u11) or
                                                    (ass.aid = temp.u12))
                    ) temp2 left join pontos_unilevel pu on pu.aid = temp2.aid
                                                    and pu.mes = $mes
                                                    and pu.ano = $ano
                            left join planos pl on pl.pid = temp2.plano_atual
                            where temp2.status <> 'I') temp3
                    where geracao <= geracao_ganho
                                ") or die($this->geraLog('ERRO',"Erro ao gravar a origem dos pontos unilevel. Empresário: #$aid. ". mysql_error().': '.mysql_errno(),'geraPontosDiario','geraPontosUnilevelOrigem'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"O empresário #$aid foi gravado como origem dos pontos unilevel.",'geraPontosDiario','geraPontosUnilevelOrigem');
            return TRUE;
        else:
            $this->geraLog('INFO',"Origem dos pontos unilevel NÃO foi gerada. Empresário: #$aid.",'geraPontosDiario','geraPontosUnilevelOrigem');
            return FALSE;
        endif;
    }

    /*
     *
     * Método de atualização dos pontos do unilevel da linha ascendente do empresário (até a 12ª geração) em questão
     * A cada nova entrada, esta tabela será atualizada e a tabela "pontos_unilevel_origem" receberá um novo registro
     * para um relatório mais detalhado sobre cada ponto gerado.
     *
     */

    function geraPontosUnilevel($aid, $pontos, $mes, $ano)
    {
        $this->db->query("
                        UPDATE pontos_unilevel pu
                        INNER JOIN(
                        select
                            ass.aid,
                            (case when ass.aid = temp.u1 then $pontos else 0 end) ptg1,
                            (case when ass.aid = temp.u2 then $pontos else 0 end) ptg2,
                            (case when ass.aid = temp.u3 then $pontos else 0 end) ptg3,
                            (case when ass.aid = temp.u4 then $pontos else 0 end) ptg4,
                            (case when ass.aid = temp.u5 then $pontos else 0 end) ptg5,
                            (case when ass.aid = temp.u6 then $pontos else 0 end) ptg6,
                            (case when ass.aid = temp.u7 then $pontos else 0 end) ptg7,
                            (case when ass.aid = temp.u8 then $pontos else 0 end) ptg8,
                            (case when ass.aid = temp.u9 then $pontos else 0 end) ptg9,
                            (case when ass.aid = temp.u10 then $pontos else 0 end) ptg10,
                            (case when ass.aid = temp.u11 then $pontos else 0 end) ptg11,
                            (case when ass.aid = temp.u12 then $pontos else 0 end) ptg12
                        from associados ass inner join (select
                                                            u1.aid u1,u2.aid u2,u3.aid u3,u4.aid u4,u5.aid u5,u6.aid u6,u7.aid u7,u8.aid u8,u9.aid u9,u10.aid u10,
                                                            u11.aid u11,u12.aid u12
                                                        from associados a left join associados u1 on a.patrocinador = u1.aid
                                                                          left join associados u2 on u1.patrocinador = u2.aid
                                                                          left join associados u3 on u2.patrocinador = u3.aid
                                                                          left join associados u4 on u3.patrocinador = u4.aid
                                                                          left join associados u5 on u4.patrocinador = u5.aid
                                                                          left join associados u6 on u5.patrocinador = u6.aid
                                                                          left join associados u7 on u6.patrocinador = u7.aid
                                                                          left join associados u8 on u7.patrocinador = u8.aid
                                                                          left join associados u9 on u8.patrocinador = u9.aid
                                                                          left join associados u10 on u9.patrocinador = u10.aid
                                                                          left join associados u11 on u10.patrocinador = u11.aid
                                                                          left join associados u12 on u11.patrocinador = u12.aid
                                                        where a.aid = $aid) temp on (
                                                        (ass.aid = temp.u1) or
                                                        (ass.aid = temp.u2) or
                                                        (ass.aid = temp.u3) or
                                                        (ass.aid = temp.u4) or
                                                        (ass.aid = temp.u5) or
                                                        (ass.aid = temp.u6) or
                                                        (ass.aid = temp.u7) or
                                                        (ass.aid = temp.u8) or
                                                        (ass.aid = temp.u9) or
                                                        (ass.aid = temp.u10) or
                                                        (ass.aid = temp.u11) or
                                                        (ass.aid = temp.u12))
                        ) temp2
                        SET
                        pu.pontos_g1 = pu.pontos_g1 + ptg1,
                        pu.pontos_g2 = pu.pontos_g2 + ptg2,
                        pu.pontos_g3 = pu.pontos_g3 + ptg3,
                        pu.pontos_g4 = pu.pontos_g4 + ptg4,
                        pu.pontos_g5 = pu.pontos_g5 + ptg5,
                        pu.pontos_g6 = pu.pontos_g6 + ptg6,
                        pu.pontos_g7 = pu.pontos_g7 + ptg7,
                        pu.pontos_g8 = pu.pontos_g8 + ptg8,
                        pu.pontos_g9 = pu.pontos_g9 + ptg9,
                        pu.pontos_g10 = pu.pontos_g10 + ptg10,
                        pu.pontos_g11 = pu.pontos_g11 + ptg11,
                        pu.pontos_g12 = pu.pontos_g12 + ptg12
                        WHERE pu.mes = $mes and
                              pu.ano = $ano and
                              pu.aid = temp2.aid
        ") or die($this->geraLog('ERRO',"Erro ao gerar pontos unilevel para uplines do empresário: #$aid. ". mysql_error().': '.mysql_errno(), 'geraPontosDiario','geraPontosUnilevelOrigem'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Pontos unilevel foram gerados para os uplines do empresário #$aid.",'geraPontosDiario','geraPontosUnilevel');
            return TRUE;
        else:
            $this->geraLog('INFO',"Pontos unilevel para os uplines do empresário #$aid NÃO foram gerados.",'geraPontosDiario','geraPontosUnilevel');
            return FALSE;
        endif;
    }


    /**
     * Este método serve de auxílio para os métodos de geração de pontos. Executa a view "get_proximo_upline"
     * e caso encontre algum registro, permite que o método continue a execução gerando os pontos para a linha
     * ascendente, do contrário, faz com que seja interrompida a execução do script.
     *
     * @param $aid
     * @return mixed
     */
    function BuscaProximoUpline($aid)
    {
        $this->db->select("u24");
        $this->db->where("aid", $aid);
        $query = $this->db->get("get_proximo_upline");

        if($query->num_rows() > 0):
            $upline = $query->row();
            if(is_null($upline->u24))
                return FALSE;
            else
                return $upline->u24;
        else:
            return FALSE;
        endif;
    }

}

/* End of file modelpontos.php */
/* Location: ./system/application/models/adm/modelpontos.php */