<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelpedidos extends CI_Model {

    var $tabela_1 = "ass_pedidos";
    var $tabela_2 = "ass_faturas";
    var $tabela_3 = "associados";
    var $tabela_4 = "ass_dados_pessoais";
    var $tabela_5 = "users";
    var $tabela_6 = "ass_rendimentos";
    var $tabela_7 = "ass_saldo";
    var $tabela_8 = "pedidos_venda";
    var $tabela_9 = "faturas";
    var $tabela_10 = "itens_pedido";
    var $tabela_11 = "faturas_status";
    var $pedido = 0;

    function __construct()
    {
        parent::__construct();
    }

    function get_saldo($aid, $transferencia = FALSE)
    {
        //	Verifica o saldo do associado
        //	Se a verificação vier da consulta para ativação um associado, será
        //	retornado o valor zero e irá avisar o usuário que ele não tem saldo para ativar
        //	um associado.
        //	Se a verificação vier do método de transferência de crédito entre associados
        //	será retornado o valor FALSE nos casos em que não houver um registro na tabela de saldo
        //	e zero nos casos em que esse for o valor disponível para o usuário, assim o método
        //	irá decidir entre inserir um registro ou atualizar o registro existente na tabela de saldo

        $this->db->where("aid", $aid);

        $saldo = $this->db->get($this->tabela_7);

        if($saldo->num_rows() > 0)
            $saldo = $saldo->row()->valor;
        else
            $saldo = $transferencia===FALSE?0:FALSE;

        return $saldo;

    }

    function get_rendimentos()
    {
        $this->db->select("ass.patrocinador");
        $this->db->from($this->tabela_3 . " ass");
        $this->db->where("ass.aid", $aid);

        $patrocinador = $this->db->get();

        if($patrocinador->num_rows() > 0):
            $patrocinador = $patrocinador->row();
            return $patrocinador->patrocinador;
        else:
            return false;
        endif;
    }

    function getPedidosVendas($aid = "", $pid = "", $where_key = "", $where_value = "")
    {
        $this->db->select("ped.pvid pid, ped.dtpedido, fat.fid, fat.sid, fat.valor, fat.dtvencimento, fat.status, ass.aid, concat(dados.nome_completo, ' (<strong>', users.username, '</strong>)') associado", FALSE);
        $this->db->from($this->tabela_8." ped");
        $this->db->join($this->tabela_9." fat", "fat.pid = ped.pvid", "inner");
        $this->db->join($this->tabela_3." ass", "ass.aid = ped.aid", "inner");
        $this->db->join($this->tabela_4." dados", "dados.aid = ass.aid", "left");
        $this->db->join($this->tabela_5." users", "users.aid = ass.aid", "left");
        $this->db->where("fat.status", 1);
        $this->db->or_where("fat.status", 2);
        if(!empty($pid)) $this->db->where("ped.pvid", $pid);
        if(!empty($aid)) $this->db->where("ass.aid", $aid);
        if(!empty($where_key)) $this->db->where($where_key, $where_value);

        $pedidos = $this->db->get();

        if($pedidos->num_rows() > 0)
            return $pedidos;
        else
            return FALSE;
    }

    function getPedidos($aid = "", $pid = "", $where_key = "", $where_value = "")
    {
        $this->db->select("ped.pid, ped.dtpedido, fat.fid, fat.valor, fat.dtvencimento, fat.descricao, fat.status, ass.aid, concat(dados.nome_completo, ' (<strong>', users.username, '</strong>)') associado", FALSE);
        $this->db->from($this->tabela_1." ped");
        $this->db->join($this->tabela_2." fat", "fat.pedido = ped.pid", "left");
        $this->db->join($this->tabela_3." ass", "ass.aid = ped.aid", "left");
        $this->db->join($this->tabela_4." dados", "dados.aid = ass.aid", "left");
        $this->db->join($this->tabela_5." users", "users.aid = ass.aid", "left");
        $this->db->where("fat.status", "Pendente");
        $this->db->or_where("fat.status", "Aguardando");
        if(!empty($pid)) $this->db->where("pedido", $pid);
        if(!empty($aid)) $this->db->where("ass.aid", $aid);
        if(!empty($where_key)) $this->db->where($where_key, $where_value);

        $pedidos = $this->db->get();

        if($pedidos->num_rows() > 0)
            return $pedidos;
        else
            return FALSE;
    }

    function getFaturas($fid = '')
    {
        if($fid != '')
            $this->db->where("fid", $fid);


        $faturas = $this->db->get($this->tabela_2);
        if($faturas->num_rows() > 0):
            return $faturas->row();
        else:
            return FALSE;
        endif;
    }

    /**
     *	Verifica se o status do associado está bloqueado ("Pendente" ou "Inativo"),
     *	em caso positivo retorna TRUE do contrário retorna FALSE
     *
     *
     *	@param	$aid - Código do associado
     */

    function is_associado_blocked($aid)
    {
        $where = "(status = 'P' OR status = 'I') AND aid = $aid";
        $this->db->where($where);

        $ass = $this->db->get($this->tabela_3);

        if($ass->num_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    function get_patrocinador_id($aid)
    {
        $this->db->select("patrocinador");
        $this->db->from($this->tabela_3 . " ass");
        $this->db->where("ass.aid", $aid);

        $patrocinador = $this->db->get();

        if($patrocinador->num_rows() > 0):
            $patrocinador = $patrocinador->row();
            return $patrocinador->patrocinador;
        else:
            return false;
        endif;
    }

    function get_associado_nome($aid)
    {
        $this->db->select("dados.nome_completo nome");
        $this->db->from($this->tabela_3 . " ass");
        $this->db->join($this->tabela_4 . " dados", "dados.aid = ass.aid");
        $this->db->where("ass.aid", $aid);

        $associado = $this->db->get();

        if($associado->num_rows() > 0):
            $associado = $associado->row();
            return $associado->nome;
        else:
            return false;
        endif;
    }


    function mudaStatus($aid, $status)
    {
        $this->db->set('status', $status);
        $this->db->where("aid", $aid);
        $this->db->update($this->tabela_3);
        return $this->db->affected_rows();
    }

    function _geraBonus($aid, $tipo, $subtipo, $valor, $descricao)
    {
        $this->db->set($this->_setBonus($aid, $tipo, $subtipo, $valor, $descricao));
        $this->db->insert($this->tabela_6);
        return $this->db->affected_rows();
    }

    function _setBonus($aid, $tipo, $subtipo, $valor, $descricao)
    {
        $ret = array(
            "aid"=>$aid,
            "tipo"=>$tipo,
            "subtipo"=>$subtipo,
            "valor"=>$valor,
            "descricao"=>$descricao
        );
        return $ret;
    }


    function getBinario($associado, $rede = "")
    {
        $this->db->select("ass.aid,
						   ass.patrocinador,
						   ass.upline, 
						   ass.rede, 
						   ass.status,
						   grad.nmgraduacao graduacao,
						   IF(ass.tp_cadastro = 'PF', pessoaf.nome_completo, pessoaj.nome_fantasia) as nome", FALSE);
        $this->db->from($this->tabela1." ass");
        $this->db->join($this->tabela2." pessoaf", "pessoaf.aid = ass.aid", "left");
        $this->db->join($this->tabela3." pessoaj", "pessoaj.aid = ass.aid", "left");
        $this->db->join($this->tabela4." grad", "grad.gid = ass.graduacao", "left");
        $this->db->where("ass.upline", $associado);
        if($rede != "") $this->db->where("ass.rede", $rede);
        $binario = $this->db->get();

        if($binario->num_rows() == 0)
            return FALSE;
        else
            return $binario;
    }

    function atualiza_saldo($aid, $valor, $transferencia = FALSE, $dados_destinatario = "")
    {
        //	A variável $saldo_anterior só será utilizada quando estiver sendo feito
        //	uma transferência de crédito entre associados, nesse caso será verificado
        //	o saldo anterior do destinatário, se for zero irá verificar se existe algum registro
        //	na tabela de saldo e caso não exista, cria um
        if($transferencia === TRUE):
            $set = array('aid'=>$aid, 'valor'=>$valor);
            $this->db->set($set);
            $this->db->insert($this->tabela_7);
        else:
            $this->db->set('valor', $valor);
            $this->db->where('aid', $aid);
            $this->db->update($this->tabela_7);
        endif;
        return $this->db->affected_rows();
    }

    function geraCredito($form, $tipo = 'C', $subtipo = 'CREDITO')
    {
        //	Variável que verifica se uma fatura está sendo paga
        //	em caso positivo, será gerado um rendimento para o
        //	patrocinador após o pagamento da fatura.

        $fatura_paga = FALSE;

        $credito = $this->_setCreditos($form, $tipo, $subtipo, $fatura_paga);
        //	Se o crédito gerado for apenas o valor da adesão não será gerado
        //	nenhum crédito para o usuário pois o valor será igual a zero.
        //	Do contrário, se o valor do crédito for maior que a taxa de adesão
        //	e o usuário estiver bloqueado, a fatura deste será paga e o restante
        //	créditado em sua conta. Por fim, se o usuário não tiver nenhuma
        //	fatura de adesão pendente o valor será integralmente créditado.
        $ret = 0;
        if($fatura_paga === TRUE):
            //	retornando um valor maior ou igual a 1000 será gerado o
            //	bônus de cadastro para o patrocinador pelo pagamento da fatura,
            //	que foi verificado acima.

            $ret += 1000;
        endif;
        if($credito['valor'] > 0):
            $ret += $this->_geraBonus($credito['aid'],
                $credito['tipo'],
                $credito['subtipo'],
                $credito['valor'],
                $credito['descricao']);
        endif;
        $patrocinador = $credito['credito_patrocinador'];
        if($patrocinador['valor'] > 0):
            $ret += $this->_geraBonus($patrocinador['aid'],
                $patrocinador['tipo'],
                $patrocinador['subtipo'],
                $patrocinador['valor'],
                $patrocinador['descricao']);
        endif;
        if($ret > 0)
            return $ret;
        else
            return FALSE;
    }

    function _setCreditos($form, $tipo, $subtipo, &$fatura_paga)
    {
        $valor_bonus = 0;
        $credito_patrocinador['valor'] = 0;
        $associado = $form['associado'];
        $motivo = $form['motivo'];
        $valor = $form['valor'];
        //	Verifica se o usuário está bloqueado, caso esteja, o valor da adesão é deduzido
        //	e o restante creditado, do contrário, credita o valor integral ao usuário.
        //	Se o usuário estiver bloqueado, será feito o desbloqueio de seu cadastro e também será dado
        //	baixa em sua fatura

        if($this->is_associado_blocked($associado) === TRUE):
            $valor_bonus = $this->config->item('bonus_cadastro');
            $valor = $valor - $this->config->item('taxa_adesao');

            //dados do pedido
            $pedido = $this->getPedidos($associado)->row();

            //dados da fatura
            $fatura = $this->getFaturas($pedido->fid);

            //pagamento da fatura
            $this->pagarFatura($fatura->fid, $associado, TRUE);

            //ativa o associado
            $this->mudaStatus($associado, 'A');

            //fatura foi paga
            $fatura_paga = TRUE;

            //	Verifica se a fatura gera bônus na rede, pois as faturas originadas do fornecimento
            //	de crédito não geram.
            if($fatura->gera_bonus == 'S'):

                //  Prepara os dados para gerar o crédito para o patrocinador e toda rede upline.
                //  Se a fatura que está sendo paga for a taxa de adesão, o valor da variável $valor
                //	será agora o valor do bônus que será pago ao patrocinador e o único crédito gerado será
                //  o bônus de cadastro que gerado apenas para o patrocinador. Caso contrário será gerado
                //  para toda a rede upline e de acordo com o pacote de cada associado, respeitando os devidos
                //  percentuais.

                //	TODO
                //
                //	Gerar bônus para todas as gerações quando a fatura não for da taxa de adesão
                //	nem de crédito gerado para o associado.

                $tipo_p = 'R';
                $subtipo_p = 'CADASTRO';

                $motivo_p = 'Crédito gerado pelo bônus '.
                    $subtipo_p.' através do associado '.
                    $this->get_associado_nome($associado).
                    ' (# '.$associado.')';

                $patrocinador  = $this->get_patrocinador_id($associado);

                $credito_patrocinador = array(
                    'aid'=>$patrocinador,
                    'tipo'=>$tipo_p,
                    'subtipo'=>$subtipo_p,
                    'valor'=>$valor_bonus,
                    'descricao'=>$motivo_p
                );

            endif;
        endif;

        $credito = array(
            'aid'=>$associado,
            'tipo'=>$tipo,
            'subtipo'=>$subtipo,
            'valor'=>$valor,
            'descricao'=>$motivo,
            'credito_patrocinador'=>$credito_patrocinador
        );
        return $credito;
    }

    function geraPedido($associado, $descricao){
        $dados = array('aid'=>$associado, 'descricao'=>$descricao);
        $this->db->insert('ass_pedidos', $dados);
        $this->pedido = $this->db->insert_id();
        return $this->pedido;
    }

    function geraFatura($associado, $vencimento, $valor, $descricao="Taxa de Adesão", $desc_pedido='Pré-cadastro', $gera_bonus = 'S')
    {
        $dados = array("pedido"=>$this->pedido==0?$this->geraPedido($associado, $desc_pedido):$this->pedido,
            "valor"=>$valor,
            "dtvencimento"=>$vencimento,
            "descricao"=>$descricao,
            "status"=>"Pendente",
            "gera_bonus"=>$desc_pedido=='CREDITO'?'N':'S');
        $this->db->insert("ass_faturas", $dados);
        return $this->db->insert_id();
    }

    /*
     * @abstract Registra os logs
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
     * @abstract Recebe notificação do sistema Pagmento e executa todas as rotinas necessárias
     *
     * @param $sid
     * @return bool
     */
    function pagarFaturaVendaPagmento($sid)
    {
        $this->db->trans_start();
        $erro = $this->getErrno();
        $this->db->set('status', STATUS_PAGO);
        $this->db->where("sid", $sid);
        $this->db->update($this->tabela_9);
        if(($rows = $this->db->affected_rows()) > 0):
            //Gera um novo registro na tabela de mudança de status da fatura
        $this->db->query("
                    insert into faturas_status (fid, status)
                    select f.fid, ".STATUS_PAGO." status
                    from faturas where sid = '$sid'
        ");

            $busca_associado = $this->db->query("
                            SELECT ass.aid, f.comissao_vendedor
                            FROM faturas f
                                            INNER JOIN pedidos_venda p ON p.pid = f.pid
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.status = ".STATUS_PAGO." AND f.sid = $sid
                            ");
            $busca_associado = $busca_associado->row();
            $aid = $busca_associado->aid;
            $comissao_vendedor = $busca_associado->comissao_vendedor;

            $this->db->query("
                            INSERT INTO ass_entrada (aid, teid, valor, data)
                            SELECT ass.patrocinador, 25, $comissao_vendedor valor, NOW()
                            FROM associados ass
                            WHERE ass.aid = $aid
                ") or die($this->geraLog('ERRO','Falha ao tentar inserir uma entrada para o patrocinador. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaVendaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Entrada para o patrocinador gerada com sucesso após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaVendaPagmento');
            else:
                $this->geraLog('INFO','Entrada para o patrocinador não pôde ser atualizada após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaVendaPagmento');
            endif;

            $this->db->query("
                            UPDATE ass_saldo s
                            INNER JOIN
                            (SELECT $comissao_vendedor valor, ass.patrocinador
                            FROM associados ass
                            WHERE ass.aid = $aid) temp1 ON s.aid = temp1.patrocinador
                            SET s.valor = s.valor + temp1.valor
                ") or die($this->geraLog('ERRO','Falha ao tentar atualizar o saldo do patrocinador. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaVendaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Saldo do patrocinador atualizado com sucesso após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaVendaPagmento');
            else:
                $this->geraLog('INFO','Saldo do patrocinador não pôde ser atualizado após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaVendaPagmento');
            endif;

        else:
            //Pagamento não concretizado
            return $erro['2001'];
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'retornoPagmento', 'pagarFaturaVendaPagmento');
        else
            return TRUE;

    }

    function pagarFaturaVenda($fid)
    {
        $this->db->trans_start();
        $erro = $this->getErrno();
        $this->db->set('status', STATUS_PAGO);
        $this->db->where("fid", $fid);
        $this->db->update($this->tabela_9);
        if(($rows = $this->db->affected_rows()) > 0):
            //Gera um novo registro na tabela de mudança de status da fatura
            $this->db->set('fid', $fid);
            $this->db->set('status', STATUS_PAGO);
            $this->db->insert($this->tabela_11);

            $this->db->query("
                            INSERT INTO ass_entrada (aid, teid, valor, data)
                            SELECT ass.patrocinador, 25, f.comissao_vendedor valor, NOW()
                            FROM faturas f
                            INNER JOIN pedidos_venda p ON p.pvid = f.pid
                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.fid = $fid
                ") or die($this->geraLog('ERRO','Falha ao tentar inserir uma entrada para o patrocinador. '.mysql_error().': '.mysql_errno(), 'pagarFaturaVenda', 'pagarFaturaVenda'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Entrada para o patrocinador gerada com sucesso após o pagamento da fatura através do sistema', 'pagarFaturaVenda', 'pagarFaturaVenda');
            else:
                $this->geraLog('INFO','Entrada para o patrocinador não pôde ser atualizada após o pagamento da fatura através do sistema', 'pagarFaturaVenda', 'pagarFaturaVenda');
            endif;

            $this->db->query("
                            UPDATE ass_saldo s
                            INNER JOIN
                            (SELECT f.comissao_vendedor valor, ass.patrocinador
                            FROM faturas f
                                            INNER JOIN pedidos_venda p ON p.pvid = f.pid
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.fid = $fid) temp1 ON s.aid = temp1.patrocinador
                            SET s.valor = s.valor + temp1.valor
                ") or die($this->geraLog('ERRO','Falha ao tentar atualizar o saldo do patrocinador. '.mysql_error().': '.mysql_errno(), 'pagarFaturaVenda', 'pagarFaturaVenda'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Saldo do patrocinador atualizado com sucesso após o pagamento da fatura através do sistema', 'pagarFaturaVenda', 'pagarFaturaVenda');
            else:
                $this->geraLog('INFO','Saldo do patrocinador não pôde ser atualizado após o pagamento da fatura através do sistema', 'pagarFaturaVenda', 'pagarFaturaVenda');
            endif;

        else:
            //Pagamento não concretizado
            return $erro['2001'];
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'pagarFaturaVenda', 'pagarFaturaVenda');
        else
            return TRUE;
    }

    function mudaStatusFatura($fid, $status){
        $erro = $this->getErrno();
        //Verifica se o status passado é o status cancelado, nesse caso, não irá avançar, mas cancelar o pedido
        if($status == STATUS_CANCELADO):
            $itens_qry = $this->db->query("
                        select sku,qty from pedidos_venda pv
                        inner join itens_pedido ip on ip.pid = pv.pvid
                        inner join faturas f on f.pid = pv.pvid
                        where f.fid = $fid
            ");
            $itens = $itens_qry->result();
            foreach($itens as $item):
                $db_loja = $this->load->database('loja', TRUE);
                $prod = $db_loja->query("
                            select product_id
                            from lista_produtos
                            where sku = '$item->sku'
                ");
                $prod = $prod->row();

                $db_loja->query("
                            update field_data_commerce_stock set commerce_stock_value = $item->qty
                            where entity_id = $prod->product_id
                ");
            endforeach;
        elseif($status != STATUS_ENTREGUE):
            $status = $status + 1;
        endif;

        //Agora, verifica se o status passado é diferente do status Entregue, pois, nesse caso, não há mais por onde avançar a fatura
        if($status != STATUS_ENTREGUE):
            $this->db->set("status", $status);
            $this->db->where("fid", $fid);
            $this->db->update($this->tabela_9);
            $dados = array(
                        "fid"=>$fid,
                        "status"=>$status);
            $this->db->set($dados);
            $this->db->insert($this->tabela_11);
            if($this->db->affected_rows() > 0)
                return TRUE;
            else
                return $erro['2003'];
        endif;
    }

    /**
     * @abstract Recebe notificação do sistema Pagmento e executa todas as rotinas necessárias para ativação do associado
     *
     * @param $sid
     * @return bool
     */
    function pagarFaturaPagmento($sid)
    {
        $this->db->trans_start();
        $erro = $this->getErrno();
        $this->db->set('status', 'Pago');
        $this->db->set('dtpagamento', date('Y-m-d H:i:s', time()));
        $this->db->where("sid", $sid);
        $this->db->update($this->tabela_2);
        if(($rows = $this->db->affected_rows()) > 0):

            $this->db->query("
                            UPDATE associados a
                            INNER JOIN
                            (SELECT f.fid, f.sid, p.aid, p.plano, p.pid
                            FROM ass_faturas f
                                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.status = 'Pago' AND f.sid = $sid
                            ORDER BY f.fid DESC) temp1 ON temp1.aid = a.aid
                            SET a.plano_atual = temp1.plano, a.pedido_atual = temp1.pid, a.status = 'A'
                ") or die($this->geraLog('ERRO','Falha ao tentar registrar o pagamento efetuado no sistema Pagmento. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Pagamento de fatura efetuado pelo sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            else:
                $this->geraLog('INFO','Não foi possível atualizar as informações do pagamento efetuado através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            endif;

            $busca_associado = $this->db->query("
                            SELECT ass.aid
                            FROM ass_faturas f
                                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.status = 'Pago' AND f.sid = $sid
                            ");
            $busca_associado = $busca_associado->row();
            $aid = $busca_associado->aid;

            $this->db->query("
                            UPDATE ass_configuracoes c
                            INNER JOIN
                                (SELECT ass.aid, (case when p.plano = 48 then 48 else
                                                 (case when p.plano = 49 then 49 else
                                                 (case when p.plano = 50 then 50 else NULL end ) end ) end ) plano
                                 FROM ass_pedidos p
                                              INNER JOIN associados ass ON ass.aid = p.aid
                                 WHERE ass.aid = $aid) temp1 ON temp1.aid = c.aid
                            SET c.plano_cash = temp1.plano
                ") or die($this->geraLog('ERRO','Falha ao atualizar o plano cash do associado. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Plano cash do associado atualizado com sucesso após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            else:
                $this->geraLog('INFO','Plano cash do associado não foi atualizado após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            endif;

            $this->db->query("
                            INSERT INTO ass_entrada (aid, teid, valor, data)
                            SELECT ass.patrocinador, 22, (f.valor*0.20) valor, NOW()
                            FROM ass_faturas f
                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE ass.aid = $aid
                ") or die($this->geraLog('ERRO','Falha ao tentar inserir uma entrada para o patrocinador. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Entrada para o patrocinador gerada com sucesso após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            else:
                $this->geraLog('INFO','Entrada para o patrocinador não pôde ser atualizada após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            endif;

            $this->db->query("
                            UPDATE ass_saldo s
                            INNER JOIN
                            (SELECT (f.valor*0.20) valor, ass.patrocinador
                            FROM ass_faturas f
                                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.sid = $sid) temp1 ON s.aid = temp1.patrocinador
                            SET s.valor = s.valor + temp1.valor
                ") or die($this->geraLog('ERRO','Falha ao tentar atualizar o saldo do patrocinador. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaPagmento'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO','Saldo do patrocinador atualizado com sucesso após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            else:
                $this->geraLog('INFO','Saldo do patrocinador não pôde ser atualizado após o pagamento da fatura através do sistema Pagmento.', 'retornoPagmento', 'pagarFaturaPagmento');
            endif;

            $this->db->query("
                            UPDATE ass_caderno SET status = 'Ativo' WHERE aid = $aid
                ") or die($this->geraLog('ERRO','Falha ao tentar ativar os cadernos do associado. '.mysql_error().': '.mysql_errno(), 'retornoPagmento', 'pagarFaturaPagmento'));

            //  Gravar na revista (rvt_user_bride)   id= increment pass=   aid=
            $conexao = mysqli_connect("aa15cdlwzjztwet.cwc8q91bdfgt.sa-east-1.rds.amazonaws.com", "evsicove", "evs1c0v3","revistapillares")
            or die("Não foi possível conectar com o banco de dados da Revista Pillares!");

            mysqli_query($conexao," INSERT INTO rvt_user_bridge (aid) VALUES ('$aid')  ");

        else:
            //Pagamento não concretizado
            return $erro['2001'];
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'retornoPagmento', 'pagarFaturaPagmento');
        else
            return TRUE;

    }

    function pagarFatura($fid, $aid, $doacao = 'N')
    {
        if($doacao == 'S'):
            $this->db->query("
                            UPDATE ass_pedidos pp
                            INNER JOIN
                            (SELECT p.pid
                            FROM ass_faturas f
                                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.fid = $fid) temp1 ON temp1.pid = pp.pid
                            SET pp.doacao = 'S'
                ") or die($this->geraLog('ERRO','Falha ao tentar atualizar pedido. '.mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));
        endif;
        $this->db->trans_start();
        $erro = $this->getErrno();
        $this->db->set('status', 'Pago');
        $this->db->set('dtpagamento', date('Y-m-d H:i:s', time()));
        $this->db->where("fid", $fid);
        $this->db->update($this->tabela_2);
        if(($rows = $this->db->affected_rows()) > 0):

            $this->db->query("
                            UPDATE associados a
                            INNER JOIN
                            (SELECT f.fid, p.aid, p.plano, p.pid
                            FROM ass_faturas f
                                            INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                            INNER JOIN associados ass ON ass.aid = p.aid
                            WHERE f.status = 'Pago' AND f.fid = $fid
                            ORDER BY f.fid DESC) temp1 ON temp1.aid = a.aid and a.aid = $aid
                            SET a.plano_atual = temp1.plano, a.pedido_atual = temp1.pid, a.status = 'A'
                ") or die($this->geraLog('ERRO',"Falha ao tentar efetuar pagamento de fatura do associado #$aid diretamente pelo sistema. ".mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO',"Pagamento de fatura do associado #$aid efetuado diretamente pelo sistema", 'pagarFatura', 'pagarFatura');
            else:
                $this->geraLog('INFO',"Pagamento de fatura do associado #$aid não pôde ser efetuado através do sistema", 'pagarFatura', 'pagarFatura');
            endif;

            $this->db->query("
                            UPDATE ass_configuracoes c
                            INNER JOIN
                                (SELECT ass.aid, (case when p.plano = 48 then 48 else
                                                 (case when p.plano = 49 then 49 else
                                                 (case when p.plano = 50 then 50 else NULL end ) end ) end ) plano
                                 FROM ass_pedidos p
                                              INNER JOIN associados ass ON ass.aid = p.aid
                                 WHERE ass.aid = $aid) temp1 ON temp1.aid = c.aid
                            SET c.plano_cash = temp1.plano
                ") or die($this->geraLog("ERRO','Falha ao atualizar o plano cash do associado #$aid. ".mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));

            if($this->db->affected_rows() > 0):
                $this->geraLog('INFO',"Plano cash do associado #$aid atualizado com sucesso após o pagamento da fatura através do sistema.", 'pagarFatura', 'pagarFatura');
            else:
                $this->geraLog('INFO',"Plano cash do associado #$aid não foi atualizado após o pagamento da fatura através do sistema.", 'pagarFatura', 'pagarFatura');
            endif;

            if($doacao == 'N'):
                $this->db->query("
                                INSERT INTO ass_entrada (aid, teid, valor, data)
                                SELECT ass.patrocinador, 22, (f.valor*0.20) valor, NOW()
                                FROM ass_faturas f
                                INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                INNER JOIN associados ass ON ass.aid = p.aid
                                WHERE ass.aid = $aid
                    ") or die($this->geraLog('ERRO',"Falha ao tentar inserir uma entrada para o patrocinador do associado #$aid. ".mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));

                if($this->db->affected_rows() > 0):
                    $this->geraLog('INFO',"Entrada para o patrocinador do associado #$aid gerada com sucesso após o pagamento da fatura através do sistema", 'pagarFatura', 'pagarFatura');
                else:
                    $this->geraLog('INFO',"Entrada para o patrocinador do associado #$aid não pôde ser atualizada após o pagamento da fatura através do sistema", 'pagarFatura', 'pagarFatura');
                endif;

                $this->db->query("
                                UPDATE ass_saldo s
                                INNER JOIN
                                (SELECT (f.valor*0.20) valor, ass.patrocinador
                                FROM ass_faturas f
                                                INNER JOIN ass_pedidos p ON p.pid = f.pedido
                                                INNER JOIN associados ass ON ass.aid = p.aid
                                WHERE f.fid = $fid) temp1 ON s.aid = temp1.patrocinador
                                SET s.valor = s.valor + temp1.valor
                    ") or die($this->geraLog('ERRO',"Falha ao tentar atualizar o saldo do patrocinador do associado #$aid. ".mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));

                if($this->db->affected_rows() > 0):
                    $this->geraLog('INFO',"Saldo do patrocinador do associado #$aid atualizado com sucesso após o pagamento da fatura através do sistema", 'pagarFatura', 'pagarFatura');
                else:
                    $this->geraLog('INFO',"Saldo do patrocinador do associado #$aid não pôde ser atualizado após o pagamento da fatura através do sistema", 'pagarFatura', 'pagarFatura');
                endif;
            endif;

            $this->db->query("
                            UPDATE ass_caderno SET status = 'Ativo' WHERE aid = $aid
                ") or die($this->geraLog('ERRO','Falha ao tentar ativar os cadernos do associado. '.mysql_error().': '.mysql_errno(), 'pagarFatura', 'pagarFatura'));

            //  Gravar na revista (rvt_user_bride)   id= increment pass=   aid=
            $conexao = mysqli_connect("aa15cdlwzjztwet.cwc8q91bdfgt.sa-east-1.rds.amazonaws.com", "evsicove", "evs1c0v3","revistapillares")
            or die("Não foi possível conectar com o banco de dados da Revista Pillares!");

            mysqli_query($conexao," INSERT INTO `rvt_user_bridge` (`aid`) VALUES ('$aid')  ");

        else:
            //Pagamento não concretizado
            return $erro['2001'];
        endif;
        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
            $this->geraLog('ERRO', 'Erro ao executar transação', 'pagarFatura', 'pagarFatura');
        else
            return TRUE;

    }

    function getErrno()
    {
        return $this->config->item('errno');
    }

    function editarFatura($uid, $valor, $vencimento, $descricao, $fid, $status = "Pendente")
    {
        $dados = array("uid"=>$uid, "dtvencimento"=>$vencimento, "valor"=>$valor, "status"=>$status, "descricao"=>$descricao);
        $this->db->where("fid", $fid);
        $this->db->update("faturas", $dados);
    }

    function excluirFatura($fid)
    {
        $this->db->where("fid", $fid);
        $this->db->delete("faturas");
    }

}

/* End of file modelpedidos.php */
/* Location: ./system/application/models/adm/modelpedidos.php */