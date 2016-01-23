<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modeldesativaassociados extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getAssociadosFaturasAtrasadas(){
        $results = array();
        $query = $this->db->query("
            select a.aid, p.pid, f.fid, f.dtvencimento, datediff(curdate(),f.dtvencimento) tempo_atraso
            from associados a inner join ass_pedidos p on p.aid = a.aid
                                                      and p.plano is not null
                                                      and p.dtdesativacao is null
                              inner join ass_faturas f on f.pedido = p.pid
                                                      and f.dtpagamento is null
                                                      and f.gera_bonus = 'S'
            where a.status <> 'I'
              and datediff(curdate(),f.dtvencimento) >= 95
              and p.dtdesativacao is null
        ");

        if($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    function getAssociadosSemRenovacaoApos1Ano(){
        $results = array();
        $query = $this->db->query("
            select aid, dtpedido, adddate(adddate(dtpedido, interval 1 year), 4) data_limite
            from (select a.aid, max(p.dtpedido) dtpedido
                  from associados a inner join ass_pedidos p on p.aid = a.aid
                  where a.status <> 'I'
                    and p.dtdesativacao is null
                    and p.plano is not null
                  group by a.aid) temp
            where dtpedido >= adddate(adddate(dtpedido, interval 1 year), 4)
        ");

        if($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    function mudaStatusAssociadoParaInativo($associados){
        $this->db->query("
            update associados
            set status = 'I'
            where aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function zeraPontosAcumulados($associados){
        $this->db->query("
            update pontos_acumulados
            set pontos = 0
            where aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function zeraPontosBinario($associados){
        $this->db->query("
            insert into pontos_binario (aid,pontos_direita,pontos_esquerda,data)
            select aid, 0 as pontos_direita, 0 as pontos_esquerda, current_date() data
            from associados
            where aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function zeraPontosUnilevel($associados){
        $this->db->query("
            insert into pontos_unilevel (aid, pontos_g1, pontos_g2, pontos_g3, pontos_g4, pontos_g5, pontos_g6,
            pontos_g7, pontos_g8, pontos_g9, pontos_g10, pontos_g11, pontos_g12, mes, ano)
            select aid, 0 pontos_g1, 0 pontos_g2, 0 pontos_g3, 0 pontos_g4, 0 pontos_g5, 0 pontos_g6, 0 pontos_g7,
                   0 pontos_g8, 0 pontos_g9, 0 pontos_g10, 0 pontos_g11, 0 pontos_g12,
                   EXTRACT(MONTH FROM CURDATE()) mes, EXTRACT(YEAR FROM CURDATE()) ano
            from associados
            where aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function geraSolicitacaoSaqueParaAssociadosComSaldo($associados, $data){
        $this->db->query("
            insert into ass_solicitacao_deposito (aid, valor, data_solicitacao, bloqueado)
            select aid, valor, '".$data."' data_solicitacao, 'N' bloqueado
            from ass_saldo
            where aid in (".$associados.")
              and valor > 0
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function geraStatusTransacaoSolicitacaoSaque($associados, $data){
        $this->db->query("
            insert into transacao_deposito (stid, sdid, data, detalhes)
            select 1 as stid, sdid, '".$data."' as data, 'Gerado pelo Sicove devido a desativação do associado.' detalhes
            from ass_solicitacao_deposito
            where aid in (".$associados.")
              and data_solicitacao = '".$data."'
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function zeraSaldo($associados){
        $this->db->query("
            update ass_saldo
            set
            valor = 0
            where aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function desativaPedidos($associados){
        $this->db->query("
            update ass_pedidos
            set dtdesativacao = now()
            where dtdesativacao is null
            and aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function desativaGraduacoes($associados){
        $this->db->query("
            update graduacao_associado
            set dtdesativacao = now()
            where dtdesativacao is null
              and aid in (".$associados.")
        ");

        if($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }
}