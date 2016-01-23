<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelprocessaunilevelmensal extends CI_Model {

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

    function geraEntradasUnilevel(){
        $this->db->trans_start();
        $this->db->query("insert into ass_entrada(aid, valor, teid, data)
                          select aid, (sum(valor_g1 + valor_g2 + valor_g3 + valor_g4 + valor_g5 + valor_g6 + valor_g7 + valor_g8 + valor_g9 +
                                           valor_g10 + valor_g11 + valor_g12)) total, 2 tipo_entrada, now() data
                          from saldo_unilevel su
                          where data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
                            and (valor_g1 > 0
                             or valor_g2 > 0
                             or valor_g3 > 0
                             or valor_g4 > 0
                             or valor_g5 > 0
                             or valor_g6 > 0
                             or valor_g7 > 0
                             or valor_g8 > 0
                             or valor_g9 > 0
                             or valor_g10 > 0
                             or valor_g11 > 0
                             or valor_g12 > 0)
                          group by aid
        ") or die($this->geraLog('ERRO','Erro ao gerar entradas do unilevel. '.mysql_error().': '.mysql_errno(), 'processaUnilevelMensal', 'geraEntradasUnilevel'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO','Entradas do unilevel foram geradas com sucesso', 'processaUnilevelMensal', 'geraEntradasUnilevel');
        else:
            $this->geraLog('INFO','Nenhuma entrada do unilevel foi gerada.', 'processaUnilevelMensal', 'geraEntradasUnilevel');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'processaUnilevelMensal', 'geraEntradasUnilevel');
    }

    function geraSaldo(){
        $this->db->trans_start();
        $this->db->query("update ass_saldo inner join
            (select aid, (sum(valor_g1 + valor_g2 + valor_g3 + valor_g4 + valor_g5 + valor_g6 + valor_g7 + valor_g8 + valor_g9 +
                         valor_g10 + valor_g11 + valor_g12)) total
            from saldo_unilevel su
            where data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
                and (valor_g1 > 0
                 or valor_g2 > 0
                 or valor_g3 > 0
                 or valor_g4 > 0
                 or valor_g5 > 0
                 or valor_g6 > 0
                 or valor_g7 > 0
                 or valor_g8 > 0
                 or valor_g9 > 0
                 or valor_g10 > 0
                 or valor_g11 > 0
                 or valor_g12 > 0)
            group by aid) temp on ass_saldo.aid = temp.aid
            set
            valor = valor + total
        ") or die($this->geraLog('ERRO','Erro ao gerar saldo. '.mysql_error().': '.mysql_errno(), 'processaUnilevelMensal', 'geraSaldo'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO','Saldo foi gerado com sucesso', 'processaUnilevelMensal', 'geraSaldo');
        else:
            $this->geraLog('INFO','Nenhum saldo foi gerado.', 'processaUnilevelMensal', 'geraSaldo');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'processaUnilevelMensal', 'geraSaldo');
    }

    function geraRegistroSaldoUnilevelAssociadosRestantes(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_unilevel (aid, valor_g1, valor_g2, valor_g3, valor_g4, valor_g5, valor_g6, valor_g7, valor_g8,
                        valor_g9, valor_g10, valor_g11, valor_g12, data)
            select pu.aid, 0 valor_g1, 0 valor_g2, 0 valor_g3, 0 valor_g4, 0 valor_g5, 0 valor_g6, 0 valor_g7, 0 valor_g8,
                               0 valor_g9, 0 valor_g10, 0 valor_g11, 0 valor_g12,
                               adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
            from pontos_unilevel pu left join saldo_unilevel su_jaCriadaNoMes on su_jaCriadaNoMes.aid = pu.aid
                                                                             and su_jaCriadaNoMes.data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
            where pu.ano = year(adddate(now(),interval -1 month))
              and pu.mes = month(adddate(now(),interval -1 month))
              and su_jaCriadaNoMes.suid is null
        ") or die($this->geraLog('ERRO','Erro ao gerar registros de saldo do unilevel dos associados restantes. '.mysql_error().': '.mysql_errno(), 'processaUnilevelMensal', 'geraRegistroSaldoUnilevelAssociadosRestantes'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO','Registros de saldo do unilevel dos associados restantes foram gerados com sucesso', 'processaUnilevelMensal', 'geraEntradasUnilevel');
        else:
            $this->geraLog('INFO','Nenhum registro de saldo do unilevel dos associados restantes foi gerado.', 'processaUnilevelMensal', 'geraEntradasUnilevel');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'processaUnilevelMensal', 'geraEntradasUnilevel');
    }

    function geraSaldoUnilevelMensalAssociados(){
        $this->db->trans_start();
        $this->db->query("
              insert into saldo_unilevel (aid, valor_g1, valor_g2, valor_g3, valor_g4, valor_g5, valor_g6, valor_g7,
                                          valor_g8, valor_g9, valor_g10, valor_g11, valor_g12, data)
              select temp2.aid,
                     round((p.perc_ganhos_unilevel_g1 * pu_atual.pontos_g1),2) valor_g1,
                     round((p.perc_ganhos_unilevel_g2 * pu_atual.pontos_g2),2) valor_g2,
                     round((p.perc_ganhos_unilevel_g3 * pu_atual.pontos_g3),2) valor_g3,
                     round((p.perc_ganhos_unilevel_g4 * pu_atual.pontos_g4),2) valor_g4,
                     round((p.perc_ganhos_unilevel_g5 * pu_atual.pontos_g5),2) valor_g5,
                     round((p.perc_ganhos_unilevel_g6 * pu_atual.pontos_g6),2) valor_g6,
                     round((p.perc_ganhos_unilevel_g7 * pu_atual.pontos_g7),2) valor_g7,
                     round((p.perc_ganhos_unilevel_g8 * pu_atual.pontos_g8),2) valor_g8,
                     round((p.perc_ganhos_unilevel_g9 * pu_atual.pontos_g9),2) valor_g9,
                     round((p.perc_ganhos_unilevel_g10 * pu_atual.pontos_g10),2) valor_g10,
                     round((p.perc_ganhos_unilevel_g11 * pu_atual.pontos_g11),2) valor_g11,
                     round((p.perc_ganhos_unilevel_g12 * pu_atual.pontos_g12),2) valor_g12,
                     adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
        from (select temp.aid, temp.plano_atual, count(temp.ft_sem_pgto) total_sem_pgto, count(temp.ft_atraso) total_atraso
                    from ( select a.aid, a.plano_atual, f_sem_pgto.fid ft_sem_pgto, f_atraso.fid ft_atraso
                                 from associados a inner join pontos_unilevel pu_semPontos on pu_semPontos.aid = a.aid # retira todos usuários sem pontos
                                                                                                                                                    and pu_semPontos.ano = year(adddate(now(),interval -1 month))
                                                                                                                                                    and pu_semPontos.mes = month(adddate(now(),interval -1 month))
                                                                                                                                                    and (pu_semPontos.pontos_g1 > 0
                                                                                                                                                     or pu_semPontos.pontos_g2 > 0
                                                                                                                                                     or pu_semPontos.pontos_g3 > 0
                                                                                                                                                     or pu_semPontos.pontos_g4 > 0
                                                                                                                                                     or pu_semPontos.pontos_g5 > 0
                                                                                                                                                     or pu_semPontos.pontos_g6 > 0
                                                                                                                                                     or pu_semPontos.pontos_g7 > 0
                                                                                                                                                     or pu_semPontos.pontos_g8 > 0
                                                                                                                                                     or pu_semPontos.pontos_g9 > 0
                                                                                                                                                     or pu_semPontos.pontos_g10 > 0
                                                                                                                                                     or pu_semPontos.pontos_g11 > 0
                                                                                                                                                     or pu_semPontos.pontos_g12 > 0)
                                                                     left  join ass_faturas f_sem_pgto on f_sem_pgto.pedido = a.plano_atual
                                                                                                                                        and f_sem_pgto.dtvencimento <= adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
                                                                                                                                        and f_sem_pgto.dtpagamento is null
                                                                     left  join ass_faturas f_atraso on f_atraso.pedido = a.plano_atual
                                                                                                                                    and f_atraso.dtvencimento <= adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
                                                                                                                                    and f_atraso.dtpagamento is not null
                                                                                                                                    and f_atraso.dtpagamento > adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
                                 where a.plano_atual not in (52,53) # retira os basic e clientes
                                     and a.plano_atual is not null # retira todos que não tem plano assinado ainda
                                     and a.status = 'A') temp
                    group by temp.aid, temp.plano_atual
                    having count(temp.ft_sem_pgto) = 0 or count(temp.ft_atraso) = 0 # retira todos que não pagaram a fatura do mês passado ou anterior ou que pagaram ela em atrazo
        ) temp2	inner join planos p on temp2.plano_atual = p.pid
                inner join pontos_unilevel pu_atual on pu_atual.aid = temp2.aid
                                                   and pu_atual.ano = year(adddate(now(),interval -1 month))
                                                   and pu_atual.mes = month(adddate(now(),interval -1 month))
        ") or die($this->geraLog('ERRO','Erro ao gerar saldo do unilevel mensal dos associados. '.mysql_error().': '.mysql_errno(), 'processaUnilevelMensal', 'geraSaldoUnilevelMensalAssociados'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO','Saldo do unilevel mensal dos associados foram gerados com sucesso', 'processaUnilevelMensal', 'geraSaldoUnilevelMensalAssociados');
        else:
            $this->geraLog('INFO','Nenhum saldo do unilevel mensal dos associados foi gerado.', 'processaUnilevelMensal', 'geraSaldoUnilevelMensalAssociados');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'processaUnilevelMensal', 'geraSaldoUnilevelMensalAssociados');
    }
}