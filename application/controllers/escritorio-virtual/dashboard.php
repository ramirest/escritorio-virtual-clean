<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library("general");
        $this->load->model('adm/ModelAssociados', 'mass');
        $this->_container = "backend/container";
    }

    function index()
    {
        if($this->dx_auth->is_logged_in()):
            //$this->load->library('calendar');
            //$dados['cal'] = $this->calendar->generate();
            $dados['page_plugin'] = 'graficos';
            $dados['pagina'] = 'themes/backend/dashboard';
            if($this->dx_auth->is_role("admin")):
                $dados['cadastros_semana'] = $this->mass->getCadastros('semana')->qtde;
                $dados['cadastros_mes'] = $this->mass->getCadastros('mes')->qtde;
            endif;
            $dados['titulo'] = "Principal";

            $dados['page_js_foot'] = 'funcoes';

            $codigo = $this->dx_auth->get_associado_id();

            $dados['codigo'] =  $codigo;

            if($codigo):
                $dados['sql'] = $this->db->query("select aid, plano
                                                  from get_associado
                                                  where aid = $codigo") or die(mysql_errno().': '.mysql_error());
            endif;

            $this->db->where('status', '1');
            $cms_result = $this->db->get("cms");
            $cms_count = $cms_result->num_rows();
            $dados['cms_count'] = $cms_count;
            $dados['cms'] = $cms_count > 0 ? $cms_result : FALSE;

            $this->db->where('status', '1');
            $ads_result = $this->db->get("ads");
            $ads_count = $ads_result->num_rows();
            $dados['ads'] = $ads_count > 0 ? $ads_result : FALSE;

            /*
	    if($this->dx_auth->is_role(array("admin","root"))):
                $prod_result = $this->mecom->listaProdutos();
                $prod_count = $prod_result->num_rows();
                if($prod_count > 0):
                    $this->load->helper('inflector');
                    $dados['lista_produtos'] = $prod_result->result();
                    $dados['produto_destaque'] = $prod_result->last_row();
                    $dados['page_plugin'] = 'ecommerce';
                else:
                    $dados['lista_produtos'] = FALSE;
                endif;
            else:
                $dados['lista_produtos'] = FALSE;
            endif;
	    */

            if(($faturas = $this->mass->getFaturas('aid',$codigo, '', 'Pendente')) !== FALSE):
                $dados['faturas'] = $faturas;
            else:
                $dados['msg'] = "";
            endif;

            $this->load->vars($dados);
            $this->load->view($this->_container);
        else:
            $this->general->redirect('login');
        endif;
    }





    public function  mudarplano()
    {
        if($this->dx_auth->is_logged_in()):

            $dados['pagina'] = "themes/backend/empresarios/mudarplano";
            $dados['titulo'] = 'Mudar Plano';


            $dados['Codigo'] = $this->dx_auth->get_associado_id();
            $this->load->vars($dados);
            $this->load->view($this->_container);

        else:
            $this->general->redirect('login');
        endif;
    }

    public function salvamudarplano()
    {

        if($this->dx_auth->is_logged_in()):

            $npid =  $_POST['pid'];
            $cadernos = $_POST['cid'];
            $aid = $_POST['aid'];


            if((isset($npid)) or ($npid!="")):

                if((isset($cadernos)) or ($cadernos!="")):

                    // Busca os dados do plano
                    $q = "SELECT p.pid, p.valor_plano, p.pontos_unilevel, p.pontos_binario
                    FROM planos p
                    WHERE p.pid = '".$npid."'";
                    $d = mysql_query($q);
                    $n = mysql_num_rows($d);

                    if($n == 0)
                        return false;
                    else
                        $plano = mysql_fetch_array($d);

                    // Busca os dados do cliente
                    $q = "SELECT p.pid, p.valor_plano, p.pontos_unilevel, p.pontos_binario
                    FROM planos p
                        JOIN associados a ON p.pid = a.plano_atual
                    WHERE a.aid = '".$aid."'";

                    $d = mysql_query($q);
                    $n = mysql_num_rows($d);
                    if($n == 0)
                        return false;
                    else
                        $assoc = mysql_fetch_array($d);

                    // Gera pedido
                    $q = "INSERT INTO ass_pedidos
                    SET aid = '".$aid."', plano = '".$npid."', dtpedido = NOW(), descricao = 'Mudança Plano', forma_pgto_plano = 'AV'";
                    $d = mysql_query($q);
                    $pid = mysql_insert_id();

                    // Calcula diferenças de valores e pontos
                    $_valor_plano = $plano['valor_plano'] - $assoc['valor_plano'];
                    $_pontos_unilevel = $plano['pontos_unilevel'] - $assoc['pontos_unilevel'];
                    $_pontos_binario = $plano['pontos_binario'] - $assoc['pontos_binario'];

                    // Gera fatura

                    $q = "INSERT INTO ass_faturas
                    SET pedido = '".$pid."', valor = '".$_valor_plano."', dtvencimento = DATE_ADD(CURDATE(), INTERVAL 5 DAY),
                        descricao = 'Mudança de Plano - A Vista', pontos_unilevel = '".$_pontos_unilevel."', pontos_binario = '".$_pontos_binario."',
                        status = 'Pendente', nosso_numero = '', num_parcela='1/1'";
                    // Nosso número será atualizado pela primeira vez

                    $d = mysql_query($q)  or die (mysql_error());
                    $fid = mysql_insert_id();

                    // Gera ass_caderno

                    for($i=0;$i<count($cadernos);$i++):
                        $q = "INSERT INTO ass_caderno SET cid = '".$cadernos[$i]."', aid = '".$aid."', status = 'Inativo'";
                        $d = mysql_query($q) or die (mysql_error());
                    endfor;

                    //  return true;
                    $this->session->set_flashdata('fatura','Sua fatura foi gerada com sucesso!');
                    $this->general->redirect('escritorio-virtual/dashboard');

                else:

                    $this->session->set_flashdata('mensagem_plano','Selecione um plano.');
                    $this->session->set_flashdata('mensagem_caderno','Selecione um caderno.');
                    $this->general->redirect('escritorio-virtual/dashboard/mudarplano');

                endif;

            else:

                $this->session->set_flashdata('mensagem_plano','Selecione um plano.');
                $this->session->set_flashdata('mensagem_caderno','Selecione um caderno.');
                $this->general->redirect('escritorio-virtual/dashboard/mudarplano');

            endif;


        endif;
    }

    /**
     * Realiza o pagamento da fatura do associado.
     * Trata separadamente o pagamento de pedidos de venda para planos e de produtos pois ambos são tratados em tabelas
     * separadas no banco de dados. O segundo argumento do método é usado para informar se deve-se verificar
     * nos pedidos/faturas de planos ou produtos.
     *
     *
     *
     * @param string $fid
     * @param bool $produto
     * @param bool $retorno
     */

    public function pagamento($fid="", $produto = FALSE, $retorno = FALSE){

        $sid = md5(date("YmdHisu"));
        if($produto === FALSE):
            if(($faturas = $this->mass->getFaturas('fid', $fid, '', 'Pendente')) !== FALSE):
            $dados = $faturas->row();

            $this->db->query("
                    update ass_faturas
                    set sid = '$sid',
                        status = 'Aguardando'
                    where fid = $dados->fid
            ");

            else:
                $this->general->redirect('escritorio-virtual/dashboard');
            endif;
        else:
            if(($faturas = $this->mecom->getFaturasProdutos('f.fid', $fid)) !== FALSE):
                $dados = $faturas->row();

                $this->db->query("
                        update faturas
                        set sid = '$sid',
                            status = ".STATUS_AGUARDANDO_PAGAMENTO."
                        where fid = $dados->fid
                ");
                $this->db->query("
                            insert into faturas_status (fid, status)
                            values($dados->fid, ".STATUS_AGUARDANDO_PAGAMENTO.")
                ");

            else:
                $this->general->redirect('escritorio-virtual/dashboard');
            endif;
        endif;

        $descricao_fatura = $produto === FALSE? $dados->descricaofatura : 'Compra realizada no escritório virtual do Sicove';
        $qtde_parcelas = $produto === FALSE? $dados->qtde_parcelas: 1;

            $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $xml .= "<xml>\n";
            $xml .= "<transacao>criartransacao</transacao>\n";
            $xml .= "<sid>$sid</sid>\n";
            $xml .= "<codigoafiliacao>2006993069</codigoafiliacao>\n";
            $xml .= "<chave>32a4f6df63b88cbaaceb0e020981a13ab1d8148ede65a489c30c6dc2b388efb8</chave>\n";
            $xml .= "<credor>$dados->Nome</credor>\n";
            $xml .= "<valor>$dados->valor</valor>\n";
            $xml .= "<datavencimento>$dados->dtvencimento</datavencimento>\n";
			$xml .= "<descricao>$descricao_fatura</descricao>\n";
            $xml .= "<cpf>$dados->cpf</cpf>\n";
            $xml .= "<cep>$dados->cep</cep>\n";
            $xml .= "<cidade>$dados->cidade</cidade>\n";
            $xml .= "<estado>$dados->estado</estado>\n";
            $xml .= "<bairro>$dados->bairro</bairro>\n";
            $xml .= "<endereco>$dados->logradouro</endereco>\n";
            $xml .= "<numero>$dados->numero</numero>\n";
            $xml .= "<complemento>$dados->complemento</complemento>\n";
			$xml .= "<nmaximoparcelas>$qtde_parcelas</nmaximoparcelas>\n";
            $xml .= "<campolivre></campolivre>\n";
            $xml .= "<urlretornoloja>https://escritorio.sicove.com.br/</urlretornoloja>\n"; //@todo criar url de retorno para receber o usuário quando concluir o pagamento
            $xml .= "</xml>\n";


            $url = "https://pagamento.sicove.com.br/ws/";
            echo $this->post_data($url, 'mensagem='.$xml);

    }

    protected function post_data($url, $dados){
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($ch);
            curl_close($ch);
        } else {
            $postdata = http_build_query($dados);
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $res = file_get_contents($url, false, $context);
        }
        return $res;

    }


}

/* End of file dashboard.php */
/* Location: ./system/application/controllers/escritorio-virtual/dashboard.php */
