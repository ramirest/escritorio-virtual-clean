<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ecommerce extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library("general");
        $this->load->library("correios");
        $this->load->model('adm/ModelAssociados', 'mass');
        $this->load->model('adm/ModelEcommerce', 'mecom');
        $this->_container = "backend/container";
    }

    function add_cart(){
        $dados['id'] = $this->input->post('sku');
        $dados['qty'] = $this->input->post('qty');
        $dados['price'] = $this->input->post('price');
        $dados['name'] = $this->input->post('title');
        //$peso_total = $this->input->post('peso') * $this->input->post('qty');
        //$frete = $this->correios->calcula_frete('41106', EMPRESA_CEP, $this->cep, $this->cart->converte_peso($peso_total),'n',0,'n');
        $dados['options'] = array('title'=>$this->input->post('title2'),
            'pbin'=>$this->input->post('pbin'),
			'puni'=>$this->input->post('puni'),
			'frete'=>$this->input->post('peso'));
        $sku = "";
        foreach ($this->cart->contents() as $items):
            if($items['sku'] == $this->input->post('sku'))
                $sku = $items['id'];
        endforeach;
        $sku = empty($sku)?$this->input->post('sku'):$sku;

        if(($qtde = $this->_check_stock($sku, $this->input->post('qty'))) === TRUE):
            if($this->cart->insert($dados))
                $result = $this->_update_cart_html();
            else
                $result = 1;//"Ocorreu um erro ao adicionar o produto ao carrinho.";
        else:
            $result = 2;//"A quantidade desejada não está disponível em nosso estoque, por favor, selecione um valor menor.";
        endif;

        echo $result;
    }

    function update_cart(){

        $data['rowid'] = $this->input->post('rowid');
        $data['qty'] = $this->input->post('qty');
        foreach ($this->cart->contents() as $items):
            if($items['rowid'] == $this->input->post('rowid'))
                $sku = $items['id'];
        endforeach;

        if($this->_check_stock($sku, $this->input->post('qty')) === TRUE):
            if($this->cart->update($data))
                echo $this->_update_cart_html();
            else
                echo 1;
        else:
            echo 2;
        endif;

    }

    function _check_stock($sku, $qty){
        $db_loja = $this->load->database('loja', TRUE);
        $prod = $db_loja->query("
                            select product_id, commerce_stock_value from commerce_product cp
                            inner join field_data_commerce_stock s on s.entity_id = cp.product_id
                            where sku = '$sku'
                ");
        $prod = $prod->row();
        $new_stock = $prod->commerce_stock_value - $qty;
        if($new_stock >= 0)
            return TRUE;
        else
            return $prod->commerce_stock_value;
    }

    function busca_cep_associado(){
        $aid = $this->dx_auth->get_associado_id();
        $qry_cep = $this->db->query("
                        select cep from ass_enderecos
                        where aid = $aid
                ");
        $cep = explode('-', $qry_cep->row()->cep);
        return $cep[0].$cep[1];
    }

    function cart(){
        if($this->dx_auth->is_logged_in()):
            $dados['page_plugin'] = 'ecommerce';
            $dados['pagina'] = "themes/backend/ecommerce/cart";
            $dados['titulo'] = 'Meu carrinho';
            $dados['cep'] = $this->busca_cep_associado();;
            //$this->cart->destroy();

            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }

    function _update_cart_html(){

        $total_itens = $this->cart->total_items();
        $total_itens = $total_itens > 0 ? $total_itens > 1 ? $total_itens . ' Ã­tens' : $total_itens . ' Ã­tem'.' no carrinho':'Carrinho vazio';

        $elementos = "";
        foreach ($this->cart->contents() as $items):
            $title = word_limiter($items['options']['title'], 4);
            $qty = word_limiter($items['qty'], 4);

            $elementos .= '<li>
                                <a href="#">
                                    <div class="alert-icon green pull-left">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    '.$title.'
                                    <span class="badge green pull-right">'.$qty.'</span>
                                </a>
                            </li>';
        endforeach;
        $total_carrinho = $this->cart->total_items();
        $link_carrinho = anchor('escritorio-virtual/ecommerce/cart', 'Visualizar carrinho');

        $conteudo = <<<HTML
                    <li class="dropdown" id="cart_drop">
                        <a href="#" class="alerts-link dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="number">{$total_carrinho}</span><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-scroll dropdown-alerts">

                            <!-- Alerts Dropdown Heading -->
                            <li class="dropdown-header">
                                <i class="fa fa-shopping-cart"></i> {$total_itens}
                            </li>

                            <!-- Alerts Dropdown Body - This is contained within a SlimScroll fixed height box. You can change the height using the SlimScroll jQuery features. -->
                            <li id="alertScroll">
                                <ul class="list-unstyled">
                                    {$elementos}
                                </ul>
                            </li>

                            <!-- Alerts Dropdown Footer -->
                            <li class="dropdown-footer">
                                {$link_carrinho}
                            </li>

                        </ul>
                    </li>
                        <!-- /.dropdown-menu -->
HTML;
        return $conteudo;
    }

    function meus_pedidos(){

        $dados['faturas'] = $this->mecom->getFaturasProdutos('ass.aid', $this->dx_auth->get_associado_id());

        $dados['pagina'] = "themes/backend/ecommerce/checkout/payment";
        $dados['titulo'] = 'Pagar fatura';
        $this->load->vars($dados);
        $this->load->view($this->_container);
    }

    function checkout(){

        if($this->_save_checkout() === TRUE):
            //Esvazia o carrinho apÃ³s a conclusÃ£o do pedido
            $this->cart->destroy();
            $dados['pagina'] = "themes/backend/ecommerce/checkout/payment";
            $dados['titulo'] = 'Pagar fatura';

            $dados['faturas'] = $this->mecom->getFaturasProdutos('ass.aid', $this->dx_auth->get_associado_id());

            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('escritorio-virtual/ecommerce/cart');
            /*            $dados['page_plugin'] = 'ecommerce';
                        $dados['pagina'] = "themes/backend/ecommerce/checkout/fail";
                        $dados['titulo'] = 'Meus pedidos';
                        //$this->cart->destroy();

                        $this->load->vars($dados);
                        $this->load->view($this->_container);*/
        endif;
    }

    function _save_checkout(){
        $aid = $this->dx_auth->get_associado_id();

        $this->db->query("
                    insert into pedidos_venda (aid)
                    values ($aid)
        ");
        if($this->db->affected_rows() > 0):
            $pid = $this->db->insert_id();
            $this->db->query("
                    insert into logs (tipo, descricao, rotina, metodo, oid)
                    values ('INFO', 'Pedido #$pid realizado pelo associado #$aid no escritÃ³rio virtual.', 'Carrinho', 'checkout', 1)
            ");

            $pbin = 0;
            $puni = 0;
            $rows = 0;
            $comissao_vendedor = 0;
            $peso_total = 0;
            foreach ($this->cart->contents() as $items):
                if ($this->cart->has_options($items['rowid']) == TRUE):
                    foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value):
                        switch($option_name):
                            case 'peso':
                                $peso_total = $peso_total + ($items['qty'] * $option_value);
                                break;
                        endswitch;
                    endforeach;
                endif;
                $qty = $items['qty'];
                $items['rowid'];
                $sku = $items['id'];
                $subtotal = $this->cart->format_number_BRL($items['subtotal']);
                $this->db->query("
                            insert into itens_pedido (pid, sku, qty)
                            values ($pid, '$sku', $qty)
                ");
                $rows += $this->db->affected_rows();
                //consulta das informaÃ§Ãµes do produto no banco de dados evitando que o usuÃ¡rio intercepte e altere as informaÃ§Ãµes
                $produtos = $this->mecom->listaProdutos($sku);
                $pbin = $pbin+($produtos->row()->pbinario*$qty);
                $puni = $puni+($produtos->row()->punilevel*$qty);
                //Efetua a baixa no estoque
                $db_loja = $this->load->database('loja', TRUE);
                $prod = $db_loja->query("
                            select product_id, qtde_estoque, comissao_vendedor
                            from lista_produtos
                            where sku = '$sku'
                ");
                $prod = $prod->row();
                $new_stock = $prod->qtde_estoque - $qty;
                $product_id = $prod->product_id;
                $comissao_vendedor = $comissao_vendedor + ($subtotal * $prod->comissao_vendedor);
                $db_loja->query("
                            update field_data_commerce_stock set commerce_stock_value = $new_stock
                            where entity_id = $product_id
                ");
            endforeach;
            $frete = $this->correios->calcula_frete('41106', EMPRESA_CEP, $this->busca_cep_associado(), $this->cart->converte_peso($peso_total),'n',0,'n');
            if($rows > 0):
                $this->db->query("
                    insert into logs (tipo, descricao, rotina, metodo, oid)
                    values ('INFO', 'Ãtens de venda do pedido #$pid do associado #$aid foram salvos com sucesso.', 'Carrinho', 'checkout', 1)
            ");
                $valor_frete = $this->cart->format_number_BRL($this->cart->unformat_number($frete['valor']));
                $valor = $this->cart->format_number_BRL($this->cart->total()+$this->cart->unformat_number($frete['valor']));
                $dtvencimento = date('Y-m-d', strtotime("+5 days"));
                $this->db->query("
                            update pedidos_venda
                            set prazo_entrega = ".$frete['prazo']."
                            where pvid = $pid
                ");
                $dados = array(
                    "pid"=>$pid,
                    "valor"=>str_replace(",",".", $valor),
                    "valor_frete"=>str_replace(",", ".", $valor_frete),
                    "pontos_binario"=>$pbin,
                    "pontos_unilevel"=>$puni,
                    "comissao_vendedor"=>$comissao_vendedor,
                    "dtvencimento"=>$dtvencimento);

                $this->db->set($dados);
                $this->db->insert("faturas");

                if($this->db->affected_rows() > 0):
                    $fid = $this->db->insert_id();
                    $this->db->set("fid", $fid);
                    $this->db->insert("faturas_status");

                    $dados = array(
                        "tipo"=>"INFO",
                        "descricao"=>"Fatura do pedido #$pid do associado #$aid foi gerada com sucesso.",
                        "rotina"=>"Carrinho",
                        "metodo"=>"checkout",
                        "oid"=>1);
                    $this->db->set($dados);
                    $this->db->insert("logs");
                    return TRUE;
                else:
                    $this->db->query("
                                insert into logs (tipo, descricao, rotina, metodo, oid)
                                values ('ERRO', 'Não foi possível salvar a fatura do pedido de venda #$pid do associado #$aid.', 'Carrinho', 'checkout', 1)
                    ");                    return FALSE;
                endif;
            else:
                $this->db->query("
                    insert into logs (tipo, descricao, rotina, metodo, oid)
                    values ('ERRO', 'NÃ£o foi possÃ­vel salvar os Ã­tens do pedido de venda do associado #$aid.', 'Carrinho', 'checkout', 1)
            ");
                return FALSE;
            endif;
        else:
            $this->db->query("
                    insert into logs (tipo, descricao, rotina, metodo, oid)
                    values ('ERRO', 'NÃ£o foi possÃ­vel salvar o pedido de venda do associado #$aid.', 'Carrinho', 'checkout', 1)
            ");
            return FALSE;
        endif;
    }

}


/* End of file ecommerce.php */
/* Location: ./system/application/controllers/escritorio-virtual/ecommerce.php */