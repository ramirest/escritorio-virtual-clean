<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class modelprocessabinariodiario extends CI_Model {

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

    function buscaTotalPontosAcumulados($aid){
        $acumulados = $this->db->query("
                          select pa.pontos, graduacao_atual, (select gid from graduacoes where pontos in (select max(pontos) maximo from graduacoes where pontos <= pa.pontos)) graduacao_necessaria
                          from pontos_acumulados pa inner join associados a on a.aid = pa.aid
                          where pa.aid = '$aid'");

        if($acumulados->num_rows() > 0):
            return $acumulados->row();
        else:
            return FALSE;
        endif;
    }

    function geraGraduacao($aid, $graduacao){
        $this->db->query("
            insert into graduacao_associado (aid, gid)
            values($aid, $graduacao)
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Graduação para associado gerada com sucesso.",'processaBinarioDiario','geraGraduacao');
        else:
            if(mysql_errno()):
                $this->geraLog('ERRO',"Erro ao gerar graduação para associados. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraGraduacao');
                die();
            else:
                $this->geraLog('ERRO',"Nenhuma graduação gerada.",'processaBinarioDiario','geraGraduacao');
            endif;
        endif;
    }

    function geraRegistroPontosBinariosAssociadosSemPontosEComFaturasAtrasadas(){
        $this->db->query("
            insert into pontos_binario (aid, pontos_direita, pontos_esquerda, data)
            select a.aid, pb.pontos_direita, pb.pontos_esquerda, current_date() data
            from associados a inner join pontos_binario pb on pb.aid = a.aid
                                        and pb.data = adddate(current_date(),-1)
            where a.status <> 'I'
            and ((pontos_direita = 0 or pontos_esquerda = 0) or (a.status = 'P'))
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Pontos binário para associados sem pontos e com faturas atrasadas gerados com sucesso.",'processaBinarioDiario','geraRegistroPontosBinariosAssociadosSemPontosEComFaturasAtrasadas');
        else:
            if(mysql_errno()):
                $this->geraLog('ERRO',"Erro ao gerar pontos binário para associados sem pontos e com faturas atrasadas. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraRegistroPontosBinariosAssociadosSemPontosEComFaturasAtrasadas');
                die();
            else:
                $this->geraLog('INFO',"Nenhum associado sem pontos e com faturas atrasadas encontrado.",'processaBinarioDiario','geraRegistroPontosBinariosAssociadosSemPontosEComFaturasAtrasadas');
            endif;
        endif;
    }

    function geraRegistroPontosBinariosAssociadosInativos(){
        $this->db->query("
            insert into pontos_binario (aid, pontos_direita, pontos_esquerda, data)
            select aid, 0 pontos_direita, 0 pontos_esquerda, current_date() data
            from associados
            where status = 'I'
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Pontos binário para associados inativos gerados com sucesso.",'processaBinarioDiario','geraRegistroPontosBinariosAssociadosInativos');
        else:
            if(mysql_errno()):
                $this->geraLog('ERRO',"Erro ao gerar pontos binário para associados inativos. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraRegistroPontosBinariosAssociadosInativos');
                die();
            else:
                $this->geraLog('INFO',"Nenhum associado inativo encontrado.",'processaBinarioDiario','geraRegistroPontosBinariosAssociadosInativos');
            endif;
        endif;
    }

    function getAssociados()
    {
        $results = array();
        $query = $this->db->query("
		    select a.aid, pb.pontos_direita, pb.pontos_esquerda, ap.pid, af.fid, date(af.dtpagamento) dtpagamento, af.dtvencimento,
                   pb_ruim.pbid, pl.percentual_ganho
# aqui eu relaciono na tabela pontos_binarios para pegar os pontos atuais do associado. se ele  tiver pago sua fatura no
#dia de ontem, o que nessecitaria de processamento diferenciado, então esses pontos da perna direita e esquerda serão
#os processados
            from associados a inner join pontos_binario pb on pb.aid = a.aid
                                                          and pb.data = adddate(current_date(),-1)
# este relacionamento é uma ponte para verificar as faturas, porém ele tem que estar ativo. os pedidos desativados não
# são válidos para esta execução. evitando que venham todos pedidos que um associado poderia ter eu busco o pedido
# mais atual. não pode vir mais de um pedido, senão o registro de um usuário seria duplicado na consulta.
# não pode ser inner join pq no futuro poderão existir associados como clientes
                              left  join ass_pedidos ap on ap.aid = a.aid
                                                       and ap.pid = a.pedido_atual
# aqui é left join, pq eu busco uma fatura processada ontem e que foi paga em atrazo, pois quando isto acontecer os dias
# em atraso que o associado estava em débito não terão os processamentos de pontos binários. é left pq pode ou não existir
# associados nesta situação, e isto não impede que todos recebam, apenas inibe o recebimento dos pontos gerandos no periodo
# irregular
                              left  join ass_faturas af on af.pedido = ap.pid
																											 and af.dtpagamento > af.dtvencimento
																											 and af.dtgeracao_pontos = adddate(current_date(),-1)
																											 and af.dtpagamento is not null
# aqui eu garanto que o usuário não tem fatura atrasada e que ele tenha pontos nas suas pernas, pois a rotina que gera
# o registro na tabela pontos_binarios dos associados que não poderão ter seus pontos convertidos em dinheiro, roda primeiro
# que esta
                              left join pontos_binario pb_ruim on a.aid = pb_ruim.aid
                                                              and pb_ruim.data = current_date()
                              left join planos pl on pl.pid = a.plano_atual
            where a.status = 'A'
              and pb_ruim.pbid is null
        ");

        if($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }

    function calculaEProcessaPontosRetroativos($aid, $data_vencimento, $data_pagamento){
        $results = array();
        $query = $this->db->query("
        # esta consulta busca os pontos dos associados nas data de pagamento e data de vencimento.
        # estes pontos serão usados para calcular quantos pontos o associado tem pra receber, mais em outro método, que
        # será pego os pontos do associado até o momento, que são os com data de ontem e esses pontos serão subtraídos
        # dos pontos na data de pagamento, que são os retornados por esta consulta, tendo assim os pontos gerados pelo
        # associado na data no período que ele estava ok om seus débitos com a sicove. depois esses pontos do resultado
        # serão somados aos pontos na data de vencimento, que são os pontos gerados pelo usuário na data em que ele
        # também estava ok  com seus débitos com a sicove.

        select p_vc.pontos_direita pontos_direita_venc, p_vc.pontos_esquerda pontos_esquerda_venc,
               p_pg.pontos_direita pontos_direita_pgto, p_pg.pontos_esquerda pontos_esquerda_pgto
        from associados a inner join pontos_binario p_vc on a.aid = p_vc.aid and p_vc.data = '".$data_vencimento."'
		        		  inner join pontos_binario p_pg on a.aid = p_pg.aid and p_pg.data = '".$data_pagamento."'
        where a.aid = ".$aid);

        if($query->num_rows() > 0) {
            $results = $query->row();
        }
        return $results;
    }

    function atualizaPontosAcumuladosParaGraduacao($associado, $pontos){
        $this->db->query("
            update pontos_acumulados
            set pontos = pontos + ".$pontos."
            where aid in (".$associado.")
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Atualização dos pontos acumulados para graduação do associado #$associado gerados com sucesso.",'processaBinarioDiario','atualizaPontosAcumuladosParaGraduacao');
        else:
            $this->geraLog('ERRO',"Erro ao atualizar os pontos acumulados para graduação do associado #$associado. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','atualizaPontosAcumuladosParaGraduacao');
        endif;
    }

    function geraValorSaldo($associado, $valor){
        $this->db->query("
            update ass_saldo
            set
            valor = valor + ".$valor."
            where aid in (".$associado.")
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Saldo gerado com sucesso para o associado #$associado.",'processaBinarioDiario','geraValorSaldo');
        else:
            $this->geraLog('ERRO',"Erro ao gerar o saldo do associado #$associado. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraValorSaldo');
        endif;
    }

    function geraValorEntrada($associado, $valor){
        $this->db->query("
            insert into ass_entrada (aid, teid, valor, data)
            values (".$associado.",1,".$valor.",now())
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Entrada gerada com sucesso para o associado #$associado.",'processaBinarioDiario','geraValorEntrada');
        else:
            $this->geraLog('ERRO',"Erro ao gerar a entrada do associado #$associado. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraValorEntrada');
        endif;
    }

    function geraRegistroPontosBinariosAssociados($associado, $pontos_direita, $pontos_esquerda){
        $this->db->query("
            insert into pontos_binario (aid, pontos_direita, pontos_esquerda, data)
            values (".$associado.", ".$pontos_direita.", ".$pontos_esquerda.", curdate())
        ");

        if($this->db->affected_rows() > 0):
            $this->geraLog('INFO',"Registro dos pontos binário gerado com sucesso para o associado #$associado.",'processaBinarioDiario','geraRegistroPontosBinariosAssociados');
        else:
            $this->geraLog('ERRO',"Erro ao gerar registro dos pontos binário do associado #$associado. Erro: " . mysql_error().'---'.mysql_errno(),'processaBinarioDiario','geraRegistroPontosBinariosAssociados');
        endif;
    }
}

/* End of file modelprocessabinariodiario.php */
/* Location: ./system/application/models/adm/modelprocessabinariodiario.php */