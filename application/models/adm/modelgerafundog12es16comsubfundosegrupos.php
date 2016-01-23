<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelgerafundog12es16comsubfundosegrupos extends CI_Model {

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

    function geraFundoG12(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_fundo (fid, valor, data)
            select f.fid, sum(valor) valor, adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
            from fundos f inner join fundo_origem fo on f.fid = fo.fid
                          inner join ass_saldo s on s.aid = fo.aid
            where descricao = 'G12'
            group by f.fid
            having sum(valor) > 0
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar o saldo mensal do fundo G12. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoG12'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Saldo mensal do fundo G12 foi gerado com sucesso', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoG12');
        else:
            $this->geraLog('INFO', 'Saldo mensal do fundo G12 não foi gerado', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoG12');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoG12');
    }

    function zeraSaldoMembrosFundoG12(){
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = 0
            where aid in (select fo.aid
            from fundos f inner join fundo_origem fo on f.fid = fo.fid
            where descricao = 'G12')
        ") or die($this->geraLog('ERRO', 'Não foi possível zerar o saldo dos membros do fundo G12. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoG12'));

        if($this->db->affected_rows() > 0)
            $this->geraLog('INFO', 'Atualização do saldo do associado efetuada com sucesso', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoG12');
        else
            $this->geraLog('INFO', 'Atualização do saldo do associado não efetuada', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoG12');
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoG12');
    }

    function geraSubFundosQueCompoemG12(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_subfundo (sfid, valor, data)
            select s.sfid, round(smf.valor*s.percentual,2) valor, smf.data
            from fundos f inner join saldo_mensal_fundo smf on f.fid = smf.fid
                          inner join subfundos s on f.fid = s.fid
            where f.descricao = 'G12'
              and data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar os subfundos que compõem o G12. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemG12'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Subfundos que compõem o G12 foram gerados com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemG12');
        else:
            $this->geraLog('INFO', 'Subfundos que compõem o G12 não foram gerados.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemG12');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemG12');
    }

    function geraGruposQueCompoemG12(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_grupo (gid, valor, data)
            select gid, round(total_grupo,2) valor,
                   adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
            from
            (select f.fid, f.descricao fundo, s.sfid, s.descricao subfundo, g.gid, g.descricao grupo, g.percentual, smsf.valor,
                   (g.percentual * smsf.valor) total_grupo
            from fundos f inner join subfundos s on f.fid = s.fid
                          inner join grupos g on s.sfid = g.sfid
                          inner join saldo_mensal_subfundo smsf on smsf.sfid = s.sfid
            where f.descricao = 'G12'
              and smsf.data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)) temp
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar os grupos que compõem o G12. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemG12'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Grupos que compõem o G12 foram gerados com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemG12');
        else:
            $this->geraLog('INFO', 'Grupos que compõem o G12 não foram gerados.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemG12');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemG12');
    }

    function geraFundoS16(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_fundo (fid, valor, data)
            select f.fid, round(sum(valor),2) valor,
                   adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
            from fundos f inner join fundo_origem fo on f.fid = fo.fid
                                        inner join ass_saldo s on s.aid = fo.aid
            where descricao = 'S16'
            group by f.fid
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar o fundo S16. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoS16'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Fundo S16 foi gerado com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoS16');
        else:
            $this->geraLog('INFO', 'Fundo S16 não foi gerado.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoS16');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraFundoS16');
    }

    function zeraSaldoMembrosFundoS16(){
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = 0
            where aid in (select fo.aid
            from fundos f left join fundo_origem fo on f.fid = fo.fid
            where descricao = 'S16')
        ") or die($this->geraLog('ERRO', 'Não foi possível zerar o saldo dos membros do fundo S16. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoS16'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Os saldos dos membros do fundo S16 foram zerados com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoS16');
        else:
            $this->geraLog('INFO', 'Os saldos dos membros do fundo S16 não foram zerados.', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoS16');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'zeraSaldoMembrosFundoS16');
    }

    function geraSubFundosQueCompoemS16(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_subfundo (sfid, valor, data)
            select s.sfid, round((smf.valor*s.percentual),2) valor, smf.data
            from fundos f inner join saldo_mensal_fundo smf on f.fid = smf.fid
                          inner join subfundos s on f.fid = s.fid
            where f.descricao = 'S16'
              and data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar os subfundos que compõem o S16. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemS16'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Os subfundos que compõem o S16 foram gerados com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemS16');
        else:
            $this->geraLog('INFO', 'Os subfundos que compõem o S16 não foram gerados.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemS16');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSubFundosQueCompoemS16');
    }

    function geraGruposQueCompoemS16(){
        $this->db->trans_start();
        $this->db->query("
            insert into saldo_mensal_grupo (gid, valor, data)
            select gid, round(total_grupo,2) valor,
                   adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1) data
            from
            (select f.fid, f.descricao fundo, s.sfid, s.descricao subfundo, g.gid, g.descricao grupo, g.percentual, smsf.valor,
                   (g.percentual * smsf.valor) total_grupo
            from fundos f inner join subfundos s on f.fid = s.fid
                          inner join grupos g on s.sfid = g.sfid
                          inner join saldo_mensal_subfundo smsf on smsf.sfid = s.sfid
            where f.descricao = 'S16'
              and smsf.data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)) temp
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar os grupos que compõem o S16. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemS16'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Os grupos que compõem o S16 foram gerados com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemS16');
        else:
            $this->geraLog('INFO', 'Os grupos que compõem o S16 não foram gerados.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemS16');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraGruposQueCompoemS16');
    }

    function geraSaidasMembrosOrigemFundosG12(){
        // Tipo de Saída "7" corresponde a Transferência para Fundo
        // Fundo Origem "1" corresponde a ass_saldo
        // Fundo "5": G12
        $this->db->trans_start();
        $this->db->query("
            insert into ass_saida(aid, tsid, omid, valor, data)
            select s.aid, 7 tipo_saida, 1 fundo_origem, valor, now() data
            from fundo_origem fo  inner join ass_saldo s on s.aid = fo.aid
            where fid = 5
              and valor > 0
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as saídas de saldo dos membros dos fundos de origem do G12. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosG12'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem do G12 foram geradas com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosG12');
        else:
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem do G12 não foram geradas.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosG12');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosG12');
    }

    function geraSaidasMembrosOrigemFundosS16(){
        // Tipo de Saída "7" corresponde a Transferência para Fundo
        // Fundo Origem "1" corresponde a ass_saldo
        // Fundo "6": S16
        $this->db->trans_start();
        $this->db->query("
            insert into ass_saida(aid, tsid, omid, valor, data)
            select s.aid, 7 tipo_saida, 1 fundo_origem, valor, now() data
            from fundo_origem fo  inner join ass_saldo s on s.aid = fo.aid
            where fid = 6
              and valor > 0
        ") or die($this->geraLog('ERRO', 'Não foi possível gerar as saídas de saldo dos membros dos fundos de origem do S16. '.mysql_error().': '.mysql_errno(), 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosS16'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem do S16 foram geradas com sucesso.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosS16');
        else:
            $this->geraLog('INFO', 'As saídas de saldo dos membros dos fundos de origem do S16 não foram geradas.', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosS16');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'geraFundoG12eS16ComSubFundoEGrupos', 'geraSaidasMembrosOrigemFundosS16');
    }

}