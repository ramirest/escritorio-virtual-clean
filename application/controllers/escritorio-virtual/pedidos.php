<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('adm/modelpedidos', 'mped');
        $this->load->model('adm/modelassociados', 'mass');
        $this->load->model('modelboleto', 'mboleto');
        $this->load->library('data');
        $this->load->library('lib_associados');
        $this->load->library('general');
        $this->load->library("typography");
        $this->load->library('grocery_CRUD');

        $this->_container = "backend/container";
        $this->_container_crud = "themes/backend/container";
    }

    function index(){
        redirect('escritorio-virtual/pedidos/gerenciar_planos');
    }
    //Verifica o status do pedido e retorna a string legível correspondente ao resultado
    public $status;
    public $detalhes_pedido = "";

    function callback_check_status($value, $row){
        $this->status = $value;
        return $this->cart->check_status($value);
    }

    /**
     * Gerenciar pedidos de vendas dos produtos
     *
     * @param string $msg
     */

    function gerenciar_vendas($msg = ""){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                try{
                    $crud = new grocery_CRUD();

                    $crud->set_theme('escritorio-virtual')->
                    set_table('faturas')->
                    set_relation('pid','pedidos_venda','pvid')->
                    set_subject('Pedido')->
                    required_fields('aid','valor','pontos_binario','pontos_unilevel','status')->
                    add_action('Avançar fatura','Confirma o avanço desta fatura e alteração do status atual para o próximo estágio?','escritorio-virtual/pedidos/avancar_fatura','fa fa-arrow-right confirmation')->
                    add_action('Confirmar pagamento','Deseja confirmar o pagamento desta fatura?<br>Esta ação não poderá ser desfeita.','escritorio-virtual/pedidos/confirma_pagamento','fa fa-money confirmation')->
                    add_action('Cancelar pedido','Tem certeza de que deseja cancelar este pedido?','escritorio-virtual/pedidos/cancelar_pedido','fa fa-times-circle confirmation')->
                    add_action('Detalhes do pedido','','escritorio-virtual/pedidos/visualizar','fa fa-tasks')->
                    //add_action('Status do pedido',$this->detalhes_pedido,'','fa fa-list-alt presentation')->
                    unset_add()->
                    unset_edit()->
                    unset_delete()->
                    unset_edit_fields('pid','sid','valor','pontos_binario','pontos_unilevel','dtvencimento','dtgeracao_pontos','num_parcela','dtultalter')->
                    field_type('status','dropdown',array(STATUS_PAGO=>'Pago',STATUS_AGUARDANDO_FATURAMENTO=>'Aguardando faturamento',STATUS_FATURADO=>'Faturado',
                                                         STATUS_ENVIADO=>'Enviado',STATUS_ENTREGUE=>'Entregue',STATUS_CANCELADO=>'Cancelado'))->
                    columns('fid','valor','dtvencimento','status')->
                    callback_column('status',array($this,'callback_check_status'))->
                    display_as('fid', 'Fatura')->
                    display_as('dtvencimento', 'Vencimento')->
                    display_as('status', 'Status');

                    $output = $crud->render();

                    $output->titulo = "Gerenciar pedidos de venda";
                    $pagina = $this->_container_crud;
                    $this->load->vars((object)$output);
                    $this->load->view($pagina);

                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function visualizar($pid = ""){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                $this->load->library('data');

                $dados['pedidos'] = $this->db->query("
                                            select a.aid,
                                                         pv.dtpedido,
                                                         pv.prazo_entrega,
                                                         f.fid,
                                                         f.valor,
                                                         f.valor_frete,
                                                         f.pontos_binario,
                                                         f.pontos_unilevel,
                                                         f.comissao_vendedor,
                                                         f.dtvencimento,
                                                         f.`status`,
                                                         ip.sku,
                                                         ip.qty,
                                                         dp.nome_completo nome,
                                                         e.cep,
                                                         e.logradouro,
                                                         e.numero,
                                                         e.complemento,
                                                         e.bairro,
                                                         e.cidade,
                                                         e.estado,
                                                         concat(dp.tel_fixo, '<br>', dp.tel_celular, '<br>', dp.tel_comercial) telefones
                                            from pedidos_venda pv
                                            inner join faturas f on f.pid = pv.pvid
                                            inner join itens_pedido ip on ip.pid = pv.pvid
                                            inner join associados a on a.aid = pv.aid
                                            inner join ass_dados_pessoais dp on dp.aid = a.aid
                                            inner join ass_enderecos e on e.aid = a.aid
                                            where pvid = $pid
                ");
                $dados['titulo'] = "Detalhes do pedido";
                $dados['pagina'] = "themes/backend/pedidos/visualizar";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Gerenciar pedidos de vendas dos planos
     *
     * @param string $msg
     */

    function gerenciar_planos($msg = ""){
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                if(!empty($msg)):
                    if($msg == 1):
                        $dados['msg'] = $this->config->item('suc_msg_style').
                            'Pagamento confirmado com sucesso'.
                            $this->config->item('msg_style_end');
                    else:
                        $dados['msg'] = $this->config->item('err_msg_style').
                            'Ocorreu um erro ao confirmar o pagamento, tente novamente ou entre em contato com o suporte técnico e informe a seguinte mensagem de erro: ' . $msg .
                            $this->config->item('msg_style_end');
                    endif;
                endif;

                $dados['pedidos'] = $this->mped->getPedidos();
                $dados['titulo'] = "Gerenciar Pedidos";
                $dados['pagina'] = "themes/backend/pedidos/gerenciar_planos";
                $dados['page_js_foot'] = "pedidos";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            else:
                //Exibe mensagem ao usuário de acesso não autorizado
                $dados['titulo'] = "Acesso não autorizado";
                $dados['pagina'] = "themes/backend/messages/sem_permissao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Confirma o pagamento da fatura de venda
     *
     * @param int $fatura
     * @param int $aid
     */

    function confirma_pagamento($fatura)
    {
        @ob_end_clean();
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                if(($return = $this->mped->pagarFaturaVenda($fatura)) === TRUE):
                    $msg_sucesso = "Pagamento confirmado com sucesso";
                echo json_encode(array("success"=>$return,"success_message"=>$msg_sucesso));
                else:
                    echo json_encode(array("success"=>false,"error_message"=>$return));
                endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Avança o status da fatura de venda após o pagamento
     *
     * @param int $fatura
     * @param int $aid
     */

    function avancar_fatura($fatura)
    {
        @ob_end_clean();
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                $this->callback_check_status($fatura);
                if($this->status > 2):
                    if(($return = $this->mped->mudaStatusFatura($fatura, $this->status)) === TRUE):
                        $msg_sucesso = "O registro foi atualizado com sucesso";
                        echo json_encode(array('success'=>true,'success_message'=>$msg_sucesso));
                    else:
                        echo json_encode(array('success'=>false,'error_message'=>$return));
                    endif;
                else:
                    echo json_encode(array('success'=>false,'error_message'=>"A fatura ainda não foi paga, não é possível alterar seu status."));
                endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }
    /**
     * Efetua o cancelamento do pedido
     *
     * @param int $fatura
     * @param int $aid
     */

    function cancelar_pedido($fatura)
    {
        @ob_end_clean();
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                $this->callback_check_status($fatura);
                    if(($return = $this->mped->mudaStatusFatura($fatura, STATUS_CANCELADO)) === TRUE):
                        $msg_sucesso = "O pedido foi cancelado com sucesso";
                        echo json_encode(array('success'=>true,'success_message'=>$msg_sucesso));
                    else:
                        echo json_encode(array('success'=>false,'error_message'=>$return));
                    endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     * Efetua o pagamento da fatura do plano do associado
	 *
     * @param int $fatura
     * @param int $aid
     */

    function pagar_fatura($fatura, $aid)
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                if(($erro = $this->mped->pagarFatura($fatura, $aid)) === TRUE)
                    $dados['msg'] = 1;
                else
                    $dados['msg'] = $erro;

                $this->general->redirect("escritorio-virtual/pedidos/gerenciar_planos/".$dados['msg']);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /**
     *  Processa o pagamento da fatura recebido através do sistema Pagmento
     */

    function retornoPagmento()
    {
        if(!empty($_REQUEST['retorno'])):
            $xml = $this->ler_xml($_REQUEST['retorno']);
            if($xml['transacao'] == 'pagamento' && $xml['status'] == 1)
                $this->mped->pagarFaturaPagmento($xml['sid']);
        endif;
    }

    function ler_xml($xml){
        $xml = new SimpleXMLElement($xml);
        $resultado = array();
        foreach ($xml->children() as $c => $v){
            $resultado[$c] = utf8_decode((string)$v);
        }
        return $resultado;
    }


    /**
     *
     * @param int $fatura
     * @param int $aid
     */

    function ativar_doacao($fatura, $aid)
    {
        if($this->dx_auth->is_logged_in()):
            if($this->dx_auth->is_role(array("root", "admin"))):
                if(($erro = $this->mped->pagarFatura($fatura, $aid, 'S')) === TRUE)
                    $dados['msg'] = 1;
                else
                    $dados['msg'] = $erro;

                $this->general->redirect("escritorio-virtual/pedidos/gerenciar_planos/".$dados['msg']);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function gerar_credito($aid = "")
    {
        if($this->dx_auth->is_logged_in()):
            $dados['page_js_foot'] = "funcoes";
            if($this->dx_auth->is_role(array("root", "admin"))):
                if($aid != ""):
                    if(($associado = $this->mass->getAssociado($aid)) !== FALSE):
                        $dados['associado'] = $associado->row();
                    endif;
                endif;
                $this->form_validation->set_rules('motivo', '<strong>motivo do crédito</strong>', 'trim|xss_clean|required');
                $this->form_validation->set_rules('valor', '<strong>valor</strong>', 'trim|xss_clean|required');
                //$this->form_validation->set_rules('cpf', 'CPF', 'trim|xss_clean|required|is_unique[users.email]');
                if ($this->form_validation->run() === FALSE):
                    $dados['titulo'] = "Gerar crédito";
                    $dados['pagina'] = "themes/backend/pedidos/gerar_credito";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                else:
                    $form = $this->_get_form_values('gerar_credito');
                    //As faturas originadas dos fornecimentos de crédito não geram bônus quando forem pagas
                    if(($ret = $this->mped->geraCredito($form)) == 1000):
                        //	O valor do crédito foi o suficiente para pagar apenas a fatura pendente
                    elseif($ret > 0):
                        $this->mped->geraFatura($form['associado'],
                            date("Y-m-d", now() + (10 * 86400)),
                            $form['valor'],
                            $form['motivo'], 'CREDITO');

                        $dados['msg'] = $this->config->item('suc_msg_style').
                            'Crédito concedido com sucesso!'.
                            $this->config->item('msg_style_end');

                    else:
                        $dados['msg'] = $this->config->item('err_msg_style').
                            'Ocorreu um erro ao gerar o crédito, tente novamente ou entre em contato com o suporte técnico'.
                            $this->config->item('msg_style_end');

                    endif;
                    $dados['titulo'] = "Gerar crédito";
                    $dados['pagina'] = "themes/backend/messages/confirmacao";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    function _get_form_values($form)
    {
        //Associado
        $v['associado'] = $this->input->post('aid');
        $v['valor'] = $this->input->post('valor');
        //	No módulo de geração de crédito haverá o campo motivo para justificar o crédito gerado
        if($form == 'gerar_credito'):
            $v['motivo'] = $this->typography->format_characters($this->input->post('motivo'));
        endif;

        return $v;
    }

    /*
    *	Ativa um associado usando os créditos do usuário atual
    */

    function ativar($aid)
    {
        if($this->dx_auth->is_logged_in()):
            $patrocinador = $this->dx_auth->get_associado_id();
            if(($pedido = $this->mped->getPedidos($aid, "", "fat.valor", $this->config->item('taxa_adesao'))) !== FALSE):
                $pedido = $pedido->row();
                if(($saldo_patrocinador = $this->mped->get_saldo($patrocinador)) > $this->config->item('taxa_adesao')):
                    //subtrai o valor do cadastro da conta do associado
                    $novo_saldo = $saldo_patrocinador - $this->config->item('taxa_adesao');
                    $this->mped->atualiza_saldo($patrocinador, $novo_saldo);

                    //efetua o pagamento da fatura do associado (downline)
                    if(($fatura = $this->mped->pagarFatura($pedido->fid, $aid)) !== FALSE):
                        $dados['msg'] = $this->config->item('suc_msg_style').
                            'Ativação efetuada com sucesso'.
                            $this->config->item('msg_style_end');
                    endif;
                else:
                    $dados['msg'] = $this->config->item('err_msg_style').
                        'Você não tem crédito suficiente'.
                        $this->config->item('msg_style_end');
                endif;
            else:
                $dados['msg'] = $this->config->item('ale_msg_style').
                    'Nenhuma fatura encontrada para o associado selecionado, entre em contato com a central de atendimento '.
                    $this->config->item('empresa').$this->config->item('msg_style_end');
            endif;
            $dados['titulo'] = "Ativação de empresários";
            $dados['pagina'] = "themes/backend/messages/confirmacao";
            $this->load->vars($dados);
            $this->load->view($this->_container);
        endif;
    }

    /*
    *	Transferência de créditos entre associados
    */

    function transferir_credito($aid = "")
    {
        if($this->dx_auth->is_logged_in()):
            $dados['page_js_foot'] = "funcoes";
            if($aid != ""):
                if(($associado = $this->mass->getAssociado($aid)) !== FALSE):
                    $this->form_validation->set_rules('valor', '<strong>valor</strong>', 'trim|xss_clean|required');
                    if ($this->form_validation->run() === FALSE):
                        $dados['associado'] = $associado->row();
                        $dados['titulo'] = "Transferência de crédito entre empresários";
                        $dados['pagina'] = "themes/backend/pedidos/transferir_credito";
                        $this->load->vars($dados);
                        $this->load->view($this->_container);
                    else:
                        $form = $this->_get_form_values('transferencia');
                        $remetente = $this->dx_auth->get_associado_id();
                        if(($saldo_remetente = $this->mped->get_saldo($remetente)) > $this->config->item('taxa_adesao')):
                            if($this->transferencia($form['associado'], $form['valor']) === TRUE):
                                $dados['msg'] = $this->config->item('suc_msg_style').
                                    'Transferência efetuada com sucesso!'.
                                    $this->config->item('msg_style_end');
                            else:
                                $dados['msg']  = $this->config->item('err_msg_style').
                                    'A transferência não pode ser concluída, tente novamente mais tarde ou entre em contato com nossa central de atendimento!'.
                                    $this->config->item('msg_style_end');
                            endif;
                        else:
                            $dados['msg'] = $this->config->item('err_msg_style').
                                'Você não tem crédito suficiente'.
                                $this->config->item('msg_style_end');
                        endif;
                        $dados['titulo'] = "Transferência de crédito entre empresários";
                        $dados['pagina'] = "themes/backend/messages/confirmacao";
                        $this->load->vars($dados);
                        $this->load->view($this->_container);
                    endif;
                else:
                    $dados['msg'] = $this->config->item('err_msg_style').
                        'Não foi possível encontrar o associado, tente novamente ou entre em contato com o suporte técnico.'.
                        $this->config->item('msg_style_end');
                    $dados['titulo'] = "Transferência de crédito entre empresários";
                    $dados['pagina'] = "themes/backend/messages/confirmacao";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                endif;
            else:
                $this->form_validation->set_rules('valor', '<strong>valor</strong>', 'trim|xss_clean|required');
                if ($this->form_validation->run() === FALSE):
                    $dados['titulo'] = "Transferência de crédito entre empresários";
                    $dados['pagina'] = "themes/backend/pedidos/transferir_credito";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                else:
                    $form = $this->_get_form_values('transferencia');
                    $remetente = $this->dx_auth->get_associado_id();
                    if(($saldo_remetente = $this->mped->get_saldo($remetente)) > $this->config->item('taxa_adesao')):
                        if($this->transferencia($form['associado'], $form['valor']) === TRUE):
                            $dados['msg'] = $this->config->item('suc_msg_style').
                                'Transferência efetuada com sucesso!'.
                                $this->config->item('msg_style_end');
                        else:
                            $dados['msg'] = $this->config->item('err_msg_style').
                                'A transferência não pode ser concluída, tente novamente mais tarde ou entre em contato com nossa central de atendimento!'.
                                $this->config->item('msg_style_end');
                        endif;
                    else:
                        $dados['msg'] = $this->config->item('err_msg_style').
                            'Você não tem crédito suficiente'.
                            $this->config->item('msg_style_end');
                    endif;
                    $dados['titulo'] = "Transferência de crédito entre empresários";
                    $dados['pagina'] = "themes/backend/messages/confirmacao";
                    $this->load->vars($dados);
                    $this->load->view($this->_container);
                endif;
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

    /*
    *	Executa a transferência
    */

    function transferencia($destinatario, $valor)
    {
        if($this->dx_auth->is_logged_in()):
            $remetente = $this->dx_auth->get_associado_id();
            $erro = $this->mped->getErrno();
            //verifica o saldo do remetente
            if(($saldo_remetente = $this->lib_associados->get_saldo($remetente)) >= $valor):
                //efetua a transferência
                $novo_saldo_remetente = $saldo_remetente - $valor;
                $this->mped->atualiza_saldo($remetente, $novo_saldo_remetente);
                $dados_destinatario = array('valor'=>$valor,
                    'associado'=>$destinatario,
                    'motivo'=>'Transferência de crédito entre empresários.'.
                        ' De '.$this->lib_associados->_getNomeAssociado($remetente, TRUE).
                        ' para '.$this->lib_associados->_getNomeAssociado($destinatario, TRUE));
                if(($ret = $this->mped->geraCredito($dados_destinatario, 'T', 'TRANSFERENCIA')) !== FALSE)
                    return TRUE;
                else
                    return FALSE;

            else:
                $dados['msg'] = $this->config->item('err_msg_style').
                    'Saldo insuficiente para efetuar a transferência.'.
                    $this->config->item('msg_style_end');
                $dados['titulo'] = "Transferência de crédito entre empresários";
                $dados['pagina'] = "themes/backend/messages/confirmacao";
                $this->load->vars($dados);
                $this->load->view($this->_container);
            endif;
        else:
            $this->general->redirect('login');
        endif;
    }

}

/* End of file pedidos.php */
/* Location: ./system/application/controllers/adm/pedidos.php */