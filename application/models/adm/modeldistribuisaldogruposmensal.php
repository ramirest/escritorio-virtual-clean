<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modeldistribuisaldogruposmensal extends CI_Model {

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

    function buscaMontanteGrupo($descricao){
        $resultado = $this->db->query("
            select smg.gid, valor, data descricao
            from saldo_mensal_grupo smg inner join grupos g on smg.gid = g.gid
            where descricao = '".$descricao."'
              and data = adddate(str_to_date(concat('01,',cast(month(now()) as char(2)),',',cast(year(now()) as char(4))),'%d,%m,%Y'),-1)
        ");

        if($resultado->num_rows() > 0):
            $this->geraLog('INFO', "Montante do grupo $descricao retornado com sucesso", 'distribuiSaldoGruposMensal', 'buscaMontanteGrupo');
            $resultado = $resultado->row();
            return $resultado->valor;
        else:
            $this->geraLog('INFO', "Montante do grupo $descricao NÃO retornado", 'distribuiSaldoGruposMensal', 'buscaMontanteGrupo');
            return false;
        endif;
    }

    function buscaFuncionariosComMontanteGrupoGerencialDividido($montanteGrupoGerencial){
        $results = array();
        $query = $this->db->query("
            select temp.*, round((montante_grupo/total_peso*peso),2) valor_funcionario
            from
            (select f.aid, f.fid, funcao.descricao, funcao.peso,
            (select sum(peso)
            from funcionarios f inner join funcao on f.funcao = funcao.fid
            where f.ativo = 1) total_peso, ".$montanteGrupoGerencial." montante_grupo
            from funcionarios f inner join funcao on f.funcao = funcao.fid
            where f.ativo = 1) temp
        ");

        if($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    function atualizaSaldoComBonusGerencial($aid, $valor, $origem) {
        $this->db->trans_start();
        if($origem == 1)
            $tabela_saldo = "ass_saldo";
        else
            $tabela_saldo = "ass_saldo_membro";
        $this->db->query("
            update $tabela_saldo
            set valor = valor + ".$valor."
            where aid = ".$aid."
        ") or die($this->geraLog('ERRO', "Erro ao atualizar saldo com bônus gerencial para o associado #$aid. Valor: $valor. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusGerencial'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', 'Saldo com bônus gerencial atualizado com sucesso.', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusGerencial');
        else:
            $this->geraLog('INFO', 'Saldo com bônus gerencial NÃO foi atualizado.', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusGerencial');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusGerencial');
    }

    function buscaIdTipoEntrada($descricao){
        $resultado = $this->db->query("
            select * from tipo_entrada where descricao = '".$descricao."'
        ");

        if($resultado->num_rows() > 0):
            $resultado = $resultado->row();
            return $resultado->teid;
        else:
            return false;
        endif;
    }

    function incluiRegistroEntradaParaAssociado($aid, $valor, $tipoEntrada, $origem){
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada (aid, teid, valor, data, omid)
            values ($aid, $tipoEntrada, $valor, now(), $origem)
        ") or die($this->geraLog('ERRO', "Erro ao inserir o registro de entrada para o associado #$aid. Valor: $valor. Tipo de entrada: $tipoEntrada. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociado'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Registro de entrada inserido com sucesso para o associado #$aid. Valor: $valor. Tipo de entrada: $tipoEntrada.", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociado');
        else:
            $this->geraLog('INFO', "Registro de entrada NÃO inserido para o associado #$aid. Valor: $valor. Tipo de entrada: $tipoEntrada.", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociado');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociado');
    }

    function buscaTotalAssociadosAReceberBonusLinear(){
        $resultado = $this->db->query("
            select count(*) total_elegiveis
            from (
            select a.patrocinador, count(*) total_indicados
            from associados a inner join planos p on a.plano_atual = p.pid
                                                inner join associados patro on patro.aid = a.patrocinador
                                                inner join planos p_patro on patro.plano_atual = p_patro.pid
            where a.status = 'A'
                and patro.status = 'A'
                and a.patrocinador <> 0
                and p.nmplano <> 'Cliente'
                and p_patro.nmplano <> 'Cliente'
            group by patrocinador
            having count(*) >= 12) temp
        ");

        if($resultado->num_rows() > 0):
            $resultado = $resultado->row();
            return $resultado->total_elegiveis;
        else:
            return false;
        endif;
    }

    function atualizaSaldoComBonusLinear($valor_por_associado){
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = valor + ".$valor_por_associado."
            where aid in (select a.patrocinador
                          from associados a inner join planos p on a.plano_atual = p.pid
                                            inner join associados patro on patro.aid = a.patrocinador
                                            inner join planos p_patro on patro.plano_atual = p_patro.pid
                          where a.status = 'A'
                            and patro.status = 'A'
                            and a.patrocinador <> 0
                            and p.nmplano <> 'Cliente'
                            and p_patro.nmplano <> 'Cliente'
                          group by patrocinador
                          having count(*) >= 12)
        ") or die($this->geraLog('ERRO', "Erro ao atualizar saldo com bônus linear. Valor por associado: $valor_por_associado. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLinear'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Atualização de saldo com bônus linear efetuada com sucesso. Valor por associado: $valor_por_associado. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLinear');
        else:
            $this->geraLog('INFO', "Atualização de saldo com bônus linear NÃO efetuada. Valor por associado: $valor_por_associado. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLinear');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLinear');
    }

    function incluiRegistroEntradaParaAssociadosLinear($valor_por_associado, $tipoEntrada){
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada (aid, teid, valor, data)
            select a.patrocinador, ".$tipoEntrada." teid, ".$valor_por_associado." valor, now() date
            from associados a inner join planos p on a.plano_atual = p.pid
                              inner join associados patro on patro.aid = a.patrocinador
                              inner join planos p_patro on patro.plano_atual = p_patro.pid
            where a.status = 'A'
                and patro.status = 'A'
                and a.patrocinador <> 0
                and p.nmplano <> 'Cliente'
                and p_patro.nmplano <> 'Cliente'
            group by patrocinador
            having count(*) >= 12
        ") or die($this->geraLog('ERRO', "Erro ao incluir registros de entrada para associados no bônus linear. Valor por associado: $valor_por_associado. Tipo de entrada: $tipoEntrada. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLinear'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Registros de entrada para associados com bônus linear inseridos com sucesso. Valor por associado: $valor_por_associado. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLinear');
        else:
            $this->geraLog('INFO', "Registros de entrada para associados com bônus linear NÃO inseridos. Valor por associado: $valor_por_associado. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLinear');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLinear');
    }

    function buscaTotalAssociadosPlanoCash($nmplano){
        $resultado = $this->db->query("
            select count(*) total
            from associados a inner join ass_configuracoes c on a.aid = c.aid
                              inner join planos p on p.pid = c.plano_cash
            where a.status = 'A'
              and p.nmplano = '".$nmplano."'
        ");

        if($resultado->num_rows() > 0):
            $resultado = $resultado->row();
            return $resultado->total;
        else:
            return false;
        endif;
    }

    function atualizaSaldoComBonusCash($valor_por_associado, $nmplanos){
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = valor + ".$valor_por_associado."
            where aid in (select a.aid
                          from associados a inner join ass_configuracoes c on a.aid = c.aid
                                            inner join planos p on c.plano_cash = p.pid
                                                               and p.nmplano in (".$nmplanos.")
                          where a.status = 'A')
        ") or die($this->geraLog('ERRO', "Erro ao atualizar saldo com bônus cash. Valor por associado: $valor_por_associado. Planos: $nmplanos. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusCash'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Atualização de saldo com bônus cash efetuada com sucesso. Valor por associado: $valor_por_associado. Planos: $nmplanos. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusCash');
        else:
            $this->geraLog('INFO', "Atualização de saldo com bônus cash NÃO efetuada. Valor por associado: $valor_por_associado. Planos: $nmplanos. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusCash');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusCash');
    }

    function incluiRegistroEntradaParaAssociadosCash($valor_por_associado, $tipoEntrada, $nmplanos){
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada (aid, teid, valor, data)
            select a.aid, ".$tipoEntrada." teid, ".$valor_por_associado." valor, now() data
            from associados a inner join ass_configuracoes c on a.aid = c.aid
                              inner join planos p on c.plano_cash = p.pid
                                                 and p.nmplano in (".$nmplanos.")
            where a.status = 'A'
        ") or die($this->geraLog('ERRO', "Erro ao inserir registros de entrada para associados no bônus cash. Valor por associado: $valor_por_associado. Planos: $nmplanos. Tipo de entrada: $tipoEntrada. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosCash'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Registros de entrada para associados no bônus cash inseridos com sucesso. Valor por associado: $valor_por_associado. Planos: $nmplanos. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosCash');
        else:
            $this->geraLog('INFO', "Registros de entrada para associados no bônus cash NÃO inseridos. Valor por associado: $valor_por_associado. Planos: $nmplanos. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosCash');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosCash');
    }

    function buscaTotalAssociadosGraduacao($nmgraduacoes){
        $resultado = $this->db->query("
            select count(*) total
            from associados a inner join graduacao_associado ga on a.aid = ga.aid
                                                               and ga.dtdesativacao is null
                                                               and ga.data in (select max(gg.data) data
                                                                               from graduacao_associado gg
                                                                               where gg.aid = a.aid
                                                                                 and gg.dtdesativacao is null)
                              inner join graduacoes g on ga.gid = g.gid
                                                     and g.nmgraduacao in (".$nmgraduacoes.")
            where a.status = 'A'
        ");

        if($resultado->num_rows() > 0):
            $resultado = $resultado->row();
            return $resultado->total;
        else:
            return false;
        endif;
    }

    function atualizaSaldoComBonusLideranca($valor_por_associado, $nmgraduacoes){
        $this->db->trans_start();
        $this->db->query("
            update ass_saldo
            set valor = valor + ".$valor_por_associado."
            where aid in (select a.aid
            from associados a inner join graduacao_associado ga on a.aid = ga.aid
                                                               and ga.dtdesativacao is null
                                                               and ga.data in (select max(gg.data) data
                                                                               from graduacao_associado gg
                                                                               where gg.aid = a.aid
                                                                                 and gg.dtdesativacao is null)
                              inner join graduacoes g on ga.gid = g.gid
                                                     and g.nmgraduacao in (".$nmgraduacoes.")
            where a.status = 'A')
        ") or die($this->geraLog('ERRO', "Erro ao atualizar saldo com bônus de liderança. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLideranca'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Atualizações dos saldos com bônus de liderança efetuadas com sucesso. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLideranca');
        else:
            $this->geraLog('INFO', "Atualizações dos saldos com bônus de liderança NÃO efetuadas. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. ", 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLideranca');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'atualizaSaldoComBonusLideranca');
    }

    function incluiRegistroEntradaParaAssociadosLideranca($valor_por_associado, $tipoEntrada, $nmgraduacoes){
        $this->db->trans_start();
        $this->db->query("
            insert into ass_entrada (aid, teid, valor, data)
            select a.aid, ".$tipoEntrada." teid, ".$valor_por_associado." valor, now() data
            from associados a inner join graduacao_associado ga on a.aid = ga.aid
												   and ga.dtdesativacao is null
												   and ga.data in (select max(gg.data) data
																   from graduacao_associado gg
																   where gg.aid = a.aid
																	 and gg.dtdesativacao is null)
				  inner join graduacoes g on ga.gid = g.gid
										 and g.nmgraduacao in (".$nmgraduacoes.")
            where a.status = 'A'
        ") or die($this->geraLog('ERRO', "Erro ao inserir registros de entrada para associados com bônus de liderança. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. Tipo de entrada: $tipoEntrada. ".mysql_error().': '.mysql_errno(), 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLideranca'));

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO', "Registros com entrada para associados com bônus de liderança inseridos com sucesso. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLideranca');
        else:
            $this->geraLog('INFO', "Registros com entrada para associados com bônus de liderança NÃO inseridos. Valor por associado: $valor_por_associado. Graduações: $nmgraduacoes. Tipo de entrada: $tipoEntrada. ", 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLideranca');
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'distribuiSaldoGruposMensal', 'incluiRegistroEntradaParaAssociadosLideranca');
    }

    function buscaOrigemSaldo($aid){
        $origem = $this->db->query("
              select * from ass_saldo_membro where aid = $aid
        ");

        if($origem->num_rows() > 0)
            return 2;
        else
            return 1;
    }

}