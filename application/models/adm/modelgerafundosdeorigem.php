<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelgerafundosdeorigem extends CI_Model {

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

    function geraFundosDeOrigem(){
        // Fundo "3": Programadores
        // Fundo "4": Diretoria
        // Fundo "7": Jornalistas
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_diario_fundo (fid, valor, data)
            select fid, sum(valor) total, adddate(CURRENT_DATE(),-1) data
            from fundo_origem fo  inner join ass_saldo s on s.aid = fo.aid
            # comentado provisoriamente where fid in (3,4,7)
            where fid = 4
            group by fid
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar o saldo diário dos fundos de origem. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraFundosDeOrigem'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Saldo diário dos fundos de origem foram gerados com sucesso.', 'geraFundosDeOrigem', 'geraFundosDeOrigem');
        else:
            $this->geraLog('INFO', 'Saldo diário dos fundos de origem não foram gerados.', 'geraFundosDeOrigem', 'geraFundosDeOrigem');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraFundosDeOrigem');
    }

    function geraSaidasMembrosFundosDeOrigem(){
        // Tipo de Saída "7" corresponde a Transferência para Fundo
        // Fundo Origem "1" corresponde a ass_saldo
        // Fundo "3": Programadores
        // Fundo "4": Diretoria
        // Fundo "7": Jornalistas
        $this->db->trans_start();
        $this->db->query("
            insert into ass_saida(aid, tsid, omid, valor, data)
            select s.aid, 7 tipo_saida, 1 fundo_origem, valor, now() data
            from fundo_origem fo  inner join ass_saldo s on s.aid = fo.aid
            # comentado provisoriamente where fid in (3,4,7)
            where fid = 4
              and valor > 0
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as saídas de saldo dos membros dos fundos de origem. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraSaidasMembrosFundosDeOrigem'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraSaidasMembrosFundosDeOrigem');
        else:
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem não foram geradas.', 'geraFundosDeOrigem', 'geraSaidasMembrosFundosDeOrigem');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraSaidasMembrosFundosDeOrigem');
    }

    function zeraSaldosMembrosFundosDeOrigem(){
        // Fundo "3": Programadores
        // Fundo "4": Diretoria
        // Fundo "7": Jornalistas
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = 0
            # comentado provisoriamente where aid in (select aid from fundo_origem where fid in (3,4,7))
            where aid in (select aid from fundo_origem where fid  = 4)
        ") or die($this->geraLog('ERRO', 'Não foi possível zerar os saldos dos membros que são origem de fundos. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'zeraSaldosMembrosFundosDeOrigem'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Os saldos dos membros que são origem de fundos foram zerados com sucesso.', 'geraFundosDeOrigem', 'zeraSaldosMembrosFundosDeOrigem');
        else:
            $this->geraLog('INFO', 'Os saldos dos membros que são origem de fundos não foram zerados.', 'geraFundosDeOrigem', 'zeraSaldosMembrosFundosDeOrigem');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'zeraSaldosMembrosFundosDeOrigem');
    }

    function geraEntradasMembrosFundoDiretoria(){
        // Fundo "4": Diretoria
        // Tipo de Entrada "7": Diretoria
        // Saldo Origem "1": ass_saldo
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada(aid, teid, omid, valor)
            select s.aid, 7 tipo_entrada, 1 saldo_origem, round(m.valor/5,2) total
            from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
            where m.fid = 4
            and data = adddate(CURRENT_DATE(),-1)
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as entradas dos membros do fundo Diretoria. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraEntradasMembrosFundoDiretoria'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As entradas dos membros do fundo Diretoria foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoDiretoria');
        else:
            $this->geraLog('INFO', 'As entradas dos membros do fundo Diretoria não foram geradas.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoDiretoria');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoDiretoria');
    }

/* comentário feito provisoriamente, para o fundo diretoria da Amanada seja o distribuido para os programadores e jornalistas

    function geraEntradasMembrosFundoProgramadores(){
        // Fundo "3": Programadores
        // Tipo de Entrada "6": Programadores
        // Saldo Origem "1": ass_saldo_membro
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada(aid, teid, omid, valor)
            select s.aid, 6 tipo_entrada, 2 saldo_origem, round(m.valor/10,2) total
            from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
            where m.fid = 3
            and data = adddate(CURRENT_DATE(),-1)
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as entradas dos membros do fundo Programadores. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As entradas dos membros do fundo Programadores foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
        else:
            $this->geraLog('INFO', 'As entradas dos membros do fundo Programadores não foram geradas.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
    }

    function geraEntradasMembrosFundoJornalistas(){
        // Fundo "7": Jornalistas
        // Tipo de Entrada "24": Jornalistas
        // Saldo Origem "1": ass_saldo_membro
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada(aid, teid, omid, valor)
            select s.aid, 24 tipo_entrada, 2 saldo_origem, round(m.valor/10,2) total
            from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
            where m.fid = 7
            and data = adddate(CURRENT_DATE(),-1)
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as entradas dos membros do fundo Jornalistas. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As entradas dos membros do fundo Jornalistas foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
        else:
            $this->geraLog('INFO', 'As entradas dos membros do fundo Jornalistas não foram geradas.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
    }*/

    function distribuiFundoDiretoria(){
        // Fundo "4": Diretoria
        // O valor é dividido por 5, pois são apenas 5 pessoas cadatradas para receber este bônus (Eliane, Amanda, Letto, Breno, JB)
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo inner join (select s.aid, round(m.valor/5,2) total
                                         from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
                                         where m.fid = 4
                                           and data = adddate(CURRENT_DATE(),-1)
                                           ) temp on ass_saldo.aid = temp.aid
            set valor = valor + total
        ") or die($this->geraLog('ERRO', 'Não foi possível atualizar o saldo dos membros do fundo Diretoria. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'distribuiFundoDiretoria'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo dos membros do fundo Diretoria foram atualizados com sucesso.', 'geraFundosDeOrigem', 'distribuiFundoDiretoria');
        else:
            $this->geraLog('INFO', 'O saldo dos membros do fundo Diretoria não foram atualizados.', 'geraFundosDeOrigem', 'distribuiFundoDiretoria');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'distribuiFundoDiretoria');
    }

    /*------------------------------------------------------------------------------------------------------------*/

    function geraEntradasMembrosFundoProgramadores(){
        // Fundo "3": Programadores
        // Tipo de Entrada "6": Programadores
        // Saldo Origem "1": ass_saldo_membro
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada(aid, teid, omid, valor)
            select m.aid, 6 tipo_entrada, 2 saldo_origem, round((s.valor*0.6)/10,2) total
            from ass_saldo s inner join fundo_membros m on m.fid = 3
            where s.aid = 93
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as entradas dos membros do fundo Programadores. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As entradas dos membros do fundo Programadores foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
        else:
            $this->geraLog('INFO', 'As entradas dos membros do fundo Programadores não foram geradas.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoProgramadores');
    }
    function geraEntradasMembrosFundoJornalistas(){
        // Fundo "7": Jornalistas
        // Tipo de Entrada "24": Jornalistas
        // Saldo Origem "1": ass_saldo_membro
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada(aid, teid, omid, valor)
            select m.aid, 24 tipo_entrada, 2 saldo_origem, round((s.valor*0.4)/10,2) total
            from ass_saldo s inner join fundo_membros m on m.fid = 7
            where s.aid = 93
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as entradas dos membros do fundo Jornalistas. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As entradas dos membros do fundo Jornalistas foram geradas com sucesso.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
        else:
            $this->geraLog('INFO', 'As entradas dos membros do fundo Jornalistas não foram geradas.', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'geraEntradasMembrosFundoJornalistas');
    }

    /*------------------------------------------------------------------------------------------------------------*/

    function distribuiFundoProgramadores(){
        // Fundo "3": Programadores
        // O valor é dividido por 10, pois são apenas 10 pessoas cadatradas para receber este bônus (Vinicius, Ramires, Thiago, Raians, Thamires, Plinio, Andre, Renato, Giuliano e Alexandro)
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo_membro inner join (select m.aid, round((s.valor*0.6)/10,2) total
                                                from ass_saldo s inner join fundo_membros m on m.fid = 3
                                                where s.aid = 93
            ) temp on ass_saldo_membro.aid = temp.aid
            set
            valor = valor + total
        ") or die($this->geraLog('ERRO', 'Não foi possível atualizar o saldo dos membros do fundo Programadores. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'distribuiFundoProgramadores'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo dos membros do fundo Programadores foram atualizados com sucesso.', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
        else:
            $this->geraLog('INFO', 'O saldo dos membros do fundo Programadores não foram atualizados.', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
    }
    function distribuiFundoJornalistas(){
        // Subfundo "7": Jornalistas
        // O valor é dividido por 10, pois são apenas 10 pessoas cadatradas para receber este bônus (Cleide, Rubens, Marcio, Auritone, Fabio, Erica, Lucas, Jabour, Davila e Judson)
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo_membro inner join (select m.aid, round((s.valor*0.4)/10,2) total
                                                from ass_saldo s inner join fundo_membros m on m.fid = 7
                                                where s.aid = 93
              ) temp on ass_saldo_membro.aid = temp.aid
            set
            valor = valor + total
        ") or die($this->geraLog('ERRO', 'Não foi possível atualizar o saldo dos membros do fundo Jornalistas. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'distribuiFundoJornalistas'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo dos membros do fundo Jornalistas foram atualizados com sucesso.', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
        else:
            $this->geraLog('INFO', 'O saldo dos membros do fundo Jornalistas não foram atualizados.', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
    }

    function zeraSaldoDaAmanda(){
        // Associado "93": Amanda
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = 0
            where aid = 93
        ") or die($this->geraLog('ERRO', 'Ocorreu um erro ao zerar o saldo da Amanda. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'zeraSaldoDaAmanda'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo da Amanda foi zerado com sucesso.', 'geraFundosDeOrigem', 'zeraSaldoDaAmanda');
        else:
            $this->geraLog('INFO', 'Não foi possível zerar o saldo da Amanda.', 'geraFundosDeOrigem', 'zeraSaldoDaAmanda');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'zeraSaldoDaAmanda');
    }

/*  comentário feito provisoriamente, para o fundo diretoria da Amanada seja o distribuido para os programadores e jornalistas

    function distribuiFundoProgramadores(){
        // Fundo "3": Programadores
        // O valor é dividido por 10, pois são apenas 10 pessoas cadatradas para receber este bônus (Vinicius, Ramires, Thiago, Raians, Thamires, Plinio, Andre, Renato, Giuliano e Alexandro)
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo_membro inner join (select s.aid, round(m.valor/10,2) total
                                                from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
                                                where m.fid = 3
                                                  and data = adddate(current_date(),-1)
            ) temp on ass_saldo_membro.aid = temp.aid
            set
            valor = valor + total
        ") or die($this->geraLog('ERRO', 'Não foi possível atualizar o saldo dos membros do fundo Programadores. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'distribuiFundoProgramadores'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo dos membros do fundo Programadores foram atualizados com sucesso.', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
        else:
            $this->geraLog('INFO', 'O saldo dos membros do fundo Programadores não foram atualizados.', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'distribuiFundoProgramadores');
    }

    function distribuiFundoJornalistas(){
        // Subfundo "7": Jornalistas
        // O valor é dividido por 10, pois são apenas 10 pessoas cadatradas para receber este bônus (Cleide, Rubens, Marcio, Auritone, Fabio, Erica, Lucas, Jabour, Davila e Judson)
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo_membro inner join (select s.aid, 24 tipo_entrada, 2 saldo_origem, round(m.valor/10,2) total
                                                from saldo_diario_fundo m inner join fundo_membros s on m.fid = s.fid
                                                where m.fid = 7
                                                  and data = adddate(now(),-1)
              ) temp on ass_saldo_membro.aid = temp.aid
            set
            valor = valor + total
        ") or die($this->geraLog('ERRO', 'Não foi possível atualizar o saldo dos membros do fundo Jornalistas. '.mysql_error().': '.mysql_errno(), 'geraFundosDeOrigem', 'distribuiFundoJornalistas'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'O saldo dos membros do fundo Jornalistas foram atualizados com sucesso.', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
        else:
            $this->geraLog('INFO', 'O saldo dos membros do fundo Jornalistas não foram atualizados.', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundosDeOrigem', 'distribuiFundoJornalistas');
    }*/

}