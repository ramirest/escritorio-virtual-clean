<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// +----------------------------------------------------------------------+
// | BoletoPhp - Versao Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo esta disponivel sob a Licenca GPL disponivel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voce deve ter recebido uma copia da GNU Public License junto com     |
// | esse pacote; se nao, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaboracoes de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Joao Prado Maia e Pablo Martins F. Costa				  |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenacao Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto CEF: Elizeu Alcantara         		          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Adaptacao para CodeIgniter: Ramires Teixeira <ramirest@gmail.com>   |
// +----------------------------------------------------------------------+

class Boleto extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library("boleto_cef");
        $this->load->model("Modelboleto","mboleto");
        $this->load->library("session");
    }

    function index(){
        foreach($this->mboleto->getBoleto()->result() as $result):
            $dados_boleto['all'] = $result;
        endforeach;
        $dias_de_prazo_para_pagamento = -1;//$dados_boleto['all']->dias_prazo_pagamento;
        $taxa_boleto = $dados_boleto['all']->taxa_boleto;
        $data_venc = $this->session->flashdata('vencimento');  // Prazo de X dias OU informe data: "13/04/2006";
        $valor_cobrado = $this->session->flashdata('valor'); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
        $valor_cobrado = str_replace(",", ".",$valor_cobrado);
        $valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

        // Composi��o Nosso Numero - CEF SIGCB
        $numero_documento = $this->session->flashdata('numero_doc');
        $dados["dadosboleto"]["nosso_numero1"] = "000"; // tamanho 3
        $dados["dadosboleto"]["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
        $dados["dadosboleto"]["nosso_numero2"] = "000"; // tamanho 3
        $dados["dadosboleto"]["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
        $dados["dadosboleto"]["nosso_numero3"] = str_pad($numero_documento, 9, 0, STR_PAD_LEFT); // tamanho 9

        $dados["dadosboleto"]["numero_documento"] = $numero_documento;	// Num do pedido ou do documento
        $dados["dadosboleto"]["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dados["dadosboleto"]["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
        $dados["dadosboleto"]["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dados["dadosboleto"]["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dados["dadosboleto"]["sacado"] = $this->session->flashdata('nomesacado');
        $dados["dadosboleto"]["endereco1"] = $this->session->flashdata('endereco');
        $dados["dadosboleto"]["endereco2"] = '';

        // INFORMACOES PARA O CLIENTE
        $dados["dadosboleto"]["demonstrativo1"] = $dados_boleto['all']->demonstrativo01;
        $dados["dadosboleto"]["demonstrativo2"] = $dados_boleto['all']->demonstrativo02;
        $dados["dadosboleto"]["demonstrativo3"] = $dados_boleto['all']->demonstrativo03. "<br />Taxa do boleto: ". $taxa_boleto;

        // INSTRUCOES PARA O CAIXA
        $dados["dadosboleto"]["instrucoes1"] = $dados_boleto['all']->instrucoes01;
        $dados["dadosboleto"]["instrucoes2"] = $dados_boleto['all']->instrucoes02;
        $dados["dadosboleto"]["instrucoes3"] = $dados_boleto['all']->instrucoes03;
        $dados["dadosboleto"]["instrucoes4"] = $dados_boleto['all']->instrucoes04;

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dados["dadosboleto"]["quantidade"] = $dados_boleto['all']->quantidade;
        $dados["dadosboleto"]["valor_unitario"] = $dados_boleto['all']->valor_unitario;
        $dados["dadosboleto"]["aceite"] = $dados_boleto['all']->aceite;
        $dados["dadosboleto"]["especie"] = $dados_boleto['all']->especie;
        $dados["dadosboleto"]["especie_doc"] = $dados_boleto['all']->especie_doc;


        // ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


        // DADOS DA SUA CONTA - CEF
        $dados["dadosboleto"]["agencia"] = $dados_boleto['all']->agencia; // Num da agencia, sem digito
        $dados["dadosboleto"]["conta"] = $dados_boleto['all']->conta; 	// Num da conta, sem digito
        $dados["dadosboleto"]["conta_dv"] = $dados_boleto['all']->conta_dv; 	// Digito do Num da conta

        // DADOS PERSONALIZADOS - CEF
        $dados["dadosboleto"]["conta_cedente"] = $dados_boleto['all']->conta_cedente; // ContaCedente do Cliente, sem digito (Somente N�meros)
        $dados["dadosboleto"]["carteira"] = $dados_boleto['all']->carteira;  // C�digo da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

        // SEUS DADOS
        $dados["dadosboleto"]["identificacao"] = $dados_boleto['all']->identificacao;
        $dados["dadosboleto"]["cpf_cnpj"] = $dados_boleto['all']->cnpj;
        $dados["dadosboleto"]["endereco"] = $dados_boleto['all']->endereco;
        $dados["dadosboleto"]["cidade_uf"] = $dados_boleto['all']->cidade_uf;
        $dados["dadosboleto"]["cedente"] = $dados_boleto['all']->razao_social;
        $boleto = $this->boleto_cef->gerar($dados);
        $dados["dadosboleto"]["codigo_barras"] = $boleto['dadosboleto']['codigo_barras'];
        $dados["dadosboleto"]["linha_digitavel"] = $boleto["dadosboleto"]["linha_digitavel"];
        $dados["dadosboleto"]["agencia_codigo"] = $boleto["dadosboleto"]["agencia_codigo"];
        $dados["dadosboleto"]["nosso_numero"] = $boleto["dadosboleto"]["nosso_numero"];
        $dados["dadosboleto"]["codigo_banco_com_dv"] = $boleto["dadosboleto"]["codigo_banco_com_dv"];

        $this->load->vars($dados);
        $this->load->view("boleto/cef");
    }

}

/* End of file boleto.php */
/* Location: ./system/application/controllers/boleto.php */