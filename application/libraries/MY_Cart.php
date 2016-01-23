<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart (Extended to native)
 * @author		Ramires Teixeira
 * @link		http://codeigniter.com/user_guide/libraries/cart.html
 */
class MY_Cart extends CI_Cart {

    public function __contruct(){
        parent::__construct();
    }

    /**
     * Format Number
     *
     * Returns the supplied number with commas and a decimal point.
     *
     * @access	public
     * @return	integer
     */
    function format_number_BRL($n = '')
    {
        if ($n == '')
        {
            return '';
        }
        $number = substr($n, 0, -2);
        $number .= str_pad(substr($n, -2, 2), 3, ",", STR_PAD_LEFT);

        return $number;
    }

    function unformat_number($n){
        $rmv = array('.',',');
        return str_replace($rmv, "", $n);
    }

    function converte_peso($peso_g){
        return $peso_g * 0.001;
    }
    function check_status($status){
        switch($status):
            case STATUS_PENDENTE:
            case STATUS_AGUARDANDO_PAGAMENTO:
                $status = 'Aguardando pagamento';
                break;
            case STATUS_PAGO:
            case STATUS_AGUARDANDO_FATURAMENTO:
            case STATUS_FATURADO:
                $status = 'Processando';
                break;
            case STATUS_ENVIADO:
                $status = 'Enviado aos correios';
                break;
            case STATUS_ENTREGUE:
                $status = 'Entregue';
                break;
            case STATUS_CANCELADO:
                $status = 'Cancelado';
                break;
        endswitch;
        return $status;
    }

    function check_status_all($status){
        switch($status):
            case STATUS_PENDENTE:
                $status = 'Pendente';
                break;
            case STATUS_AGUARDANDO_PAGAMENTO:
                $status = 'Aguardando pagamento';
                break;
            case STATUS_PAGO:
                $status = 'Pago';
                break;
            case STATUS_AGUARDANDO_FATURAMENTO:
                $status = 'Aguardando faturamento';
                break;
            case STATUS_FATURADO:
                $status = 'Processando';
                break;
            case STATUS_ENVIADO:
                $status = 'Enviado aos correios';
                break;
            case STATUS_ENTREGUE:
                $status = 'Entregue';
                break;
            case STATUS_CANCELADO:
                $status = 'Cancelado';
                break;
        endswitch;
        return $status;
    }

}