<?php
/*
DESENVOLVIDO POR EDGAR SERRA
http://www.edgarserra.com

Adaptado para codeigniter por Ramires Teixeira
*/

/*
A função é composta dos seguintes itens:

$servico: Modalidade de frete, modalidadas válidas:
41106 - PAC
40010 - SEDEX
40045 - SEDEX a Cobrar
40215 - SEDEX 10
40290 - SEDEX Hoje

$cep_origem: CEP de origem, utilize apenas números!
$cep_destino: CEP de destino, utilize apenas números!
$peso: Peso da encomenda, qualquer valor entre 0.3 e 30 kg.
$mao_propria: Entrega na sua casa, só são aceitos dois valores 's' e 'n', se for passado outro valor a função entenderá como 'n'
$valor_declarado: Valor declarado da encomenda, se desejar declarar, por exemplo, R$1,00, use 100.
$aviso_recebimento: Aviso de recebimento, só são aceitos dois valores 's' e 'n', se for passado outro valor a função entenderá como 'n'

Abaixo o exemplo de uso:
40010 - Sedex
97032120 - CEP de origem
71939360 - CEP de destino
2 - Peso (2 kilos)
n - Mão própria
700 - Valor declarado (R$7,00)
s - Aviso de recebimento
*/
//echo calcula_frete('40010','97032120','71939360','2','n','700','s');

?>





<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correios {

    function calcula_frete($servico,$cep_origem,$cep_destino,$peso,$mao_propria,$valor_declarado,$aviso_recebimento){

        $mao_propria = (strtolower($mao_propria) == 's')?'s':'n';
        $aviso_recebimento = (strtolower($aviso_recebimento) == 's')?'s':'n';

        $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=14313251&sDsSenha=19634885&sCepOrigem='. $cep_origem .'&sCepDestino='. $cep_destino .'&nVlPeso='. $peso .'&nCdFormato=1&nVlComprimento=20&nVlAltura=5&nVlLargura=15&sCdMaoPropria='. $mao_propria .'&nVlValorDeclarado='. $valor_declarado .'&sCdAvisoRecebimento='. $aviso_recebimento .'&nCdServico='. $servico .'&nVlDiametro=0&StrRetorno=xml';;

        $frete_calcula = simplexml_load_string(file_get_contents($url));
        /*
        CASO QUEIRA VER TUDO QUE VEM DO SITE DOS CORREIOS, DESCOMENTE A LINHA ABAIXO.
        echo print_r($frete_calcula);
        */
        $frete = $frete_calcula->cServico;

        if($frete->Erro == '0'){

            switch($frete->Codigo){
                case 41106: $servico = 'PAC'; break;
                case 40045: $servico = 'SEDEX a Cobrar'; break;
                case 40215: $servico = 'SEDEX 10'; break;
                case 40290: $servico = 'SEDEX Hoje'; break;
                default: $servico = 'SEDEX';
            }

            //$retorno = 'Serviço: '.$servico.'<br>';
            $retorno = array('valor'=>$frete->Valor, 'prazo'=>$frete->PrazoEntrega);
            //$retorno = $frete->Valor.'<br>';
            //$retorno .= 'Prazo de entrega: '.$frete->PrazoEntrega.' dia(s)';

        }elseif($frete->Erro == '7'){

            $retorno = array('valor'=>'Serviço temporariamente indisponível, tente novamente mais tarde.');

        }else{

            $retorno = array('valor'=>'Erro no cálculo do frete, código de erro: '.$frete->Erro);

        }

        return $retorno;

    }

}





/* End of file Correios.php */
/* Location: ./system/application/libraries/correios.php */