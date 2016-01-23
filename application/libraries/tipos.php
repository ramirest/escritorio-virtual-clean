<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipos {

    function endereco($pid = ''){
        $endereco = array('Residencial'=>'Residencial',
						  'Comercial'=>'Comercial',
						  'Outros'=>'Outros');
        return $endereco;
    }

    function parceiro(){
        $parceiro = array('Empresa'=>'Empresa',
						  'Associado'=>'Associado');
        return $parceiro;
    }

    function associado(){
        $associado = array('PF'=>'Pessoa Física',
						   'PJ'=>'Pessoa Jurídica');
        return $associado;
    }

    function telefone(){
        $telefone = array(
                        'Residencial'=>'Residencial',
                        'Celular'=>'Celular',
                        );
        return $telefone;
    }

    function tpconta(){
        $tpconta = array(
						 '0'=>'Selecione',
						 'Corrente'=>'Corrente',
                         'Poupança'=>'Poupança');
        return $tpconta;
    }

    function bancos(){
/*
      $bancos =  array(
        "246 - Banco ABC Brasil S.A."=>"246 - Banco ABC Brasil S.A.",
        "25 - Banco Alfa S.A."=>"25 - Banco Alfa S.A.",
        "641 - Banco Alvorada S.A."=>"641 - Banco Alvorada S.A.",
        "29 - Banco Banerj S.A."=>"29 - Banco Banerj S.A.",
        "38 - Banco Banestado S.A."=>"38 - Banco Banestado S.A.",
        "Banco Bankpar S.A."=>"Banco Bankpar S.A.",
        "740 - Banco Barclays S.A."=>"740 - Banco Barclays S.A.",
        "107 - Banco BBM S.A."=>"107 - Banco BBM S.A.",
        "31 - Banco Beg S.A."=>"31 - Banco Beg S.A.",
        "96 - Banco BM&F de Serviços de Liquidação e Custódia S.A"=>"96 - Banco BM&F de Serviços de Liquidação e Custódia S.A",
        "318 - Banco BMG S.A."=>"318 - Banco BMG S.A.",
        "752 - Banco BNP Paribas Brasil S.A."=>"752 - Banco BNP Paribas Brasil S.A.",
        "248 - Banco Boavista Interatlântico S.A."=>"248 - Banco Boavista Interatlântico S.A.",
        "36 - Banco Bradesco BBI S.A."=>"36 - Banco Bradesco BBI S.A.",
        "204 - Banco Bradesco Cartões S.A."=>"204 - Banco Bradesco Cartões S.A.",
        "237 - Banco Bradesco S.A."=>"237 - Banco Bradesco S.A.",
        "225 - Banco Brascan S.A."=>"225 - Banco Brascan S.A.",
        "44 - Banco BVA S.A."=>"44 - Banco BVA S.A.",
        "263 - Banco Cacique S.A."=>"263 - Banco Cacique S.A.",
        "473 - Banco Caixa Geral - Brasil S.A."=>"473 - Banco Caixa Geral - Brasil S.A.",
        "222 - Banco Calyon Brasil S.A."=>"222 - Banco Calyon Brasil S.A.",
        "40 - Banco Cargill S.A."=>"40 - Banco Cargill S.A.",
        "Banco Carrefour S.A."=>"Banco Carrefour S.A.",
        "745 - Banco Citibank S.A."=>"745 - Banco Citibank S.A.",
        "M08 - Banco Citicard S.A."=>"M08 - Banco Citicard S.A.",
        "M19 - Banco CNH Capital S.A."=>"M19 - Banco CNH Capital S.A.",
        "215 - Banco Comercial e de Investimento Sudameris S.A."=>"215 - Banco Comercial e de Investimento Sudameris S.A.",
        "756 - Banco Cooperativo do Brasil S.A. - BANCOOB"=>"756 - Banco Cooperativo do Brasil S.A. - BANCOOB",
        "748 - Banco Cooperativo Sicredi S.A."=>"748 - Banco Cooperativo Sicredi S.A.",
        "505 - Banco Credit Suisse (Brasil) S.A."=>"505 - Banco Credit Suisse (Brasil) S.A.",
        "229 - Banco Cruzeiro do Sul S.A."=>"229 - Banco Cruzeiro do Sul S.A.",
        "3 - Banco da Amazônia S.A."=>"3 - Banco da Amazônia S.A.",
        "083-3 - Banco da China Brasil S.A."=>"083-3 - Banco da China Brasil S.A.",
        "707 - Banco Daycoval S.A."=>"707 - Banco Daycoval S.A.",
        "M06 - Banco de Lage Landen Brasil S.A."=>"M06 - Banco de Lage Landen Brasil S.A.",
        "24 - Banco de Pernambuco S.A. - BANDEPE"=>"24 - Banco de Pernambuco S.A. - BANDEPE",
        "456 - Banco de Tokyo-Mitsubishi UFJ Brasil S.A."=>"456 - Banco de Tokyo-Mitsubishi UFJ Brasil S.A.",
        "214 - Banco Dibens S.A."=>"214 - Banco Dibens S.A.",
        "1 - Banco do Brasil S.A."=>"1 - Banco do Brasil S.A.",
        "47 - Banco do Estado de Sergipe S.A."=>"47 - Banco do Estado de Sergipe S.A.",
        "37 - Banco do Estado do Pará S.A."=>"37 - Banco do Estado do Pará S.A.",
        "41 - Banco do Estado do Rio Grande do Sul S.A."=>"41 - Banco do Estado do Rio Grande do Sul S.A.",
        "4 - Banco do Nordeste do Brasil S.A."=>"4 - Banco do Nordeste do Brasil S.A.",
        "265 - Banco Fator S.A."=>"265 - Banco Fator S.A.",
        "M03 - Banco Fiat S.A."=>"M03 - Banco Fiat S.A.",
        "224 - Banco Fibra S.A."=>"224 - Banco Fibra S.A.",
        "626 - Banco Ficsa S.A."=>"626 - Banco Ficsa S.A.",
        "Banco Fidis S.A."=>"Banco Fidis S.A.",
        "394 - Banco Finasa BMC S.A."=>"394 - Banco Finasa BMC S.A.",
        "M18 - Banco Ford S.A."=>"M18 - Banco Ford S.A.",
        "233 - Banco GE Capital S.A."=>"233 - Banco GE Capital S.A.",
        "734 - Banco Gerdau S.A."=>"734 - Banco Gerdau S.A.",
        "M07 - Banco GMAC S.A."=>"M07 - Banco GMAC S.A.",
        "612 - Banco Guanabara S.A."=>"612 - Banco Guanabara S.A.",
        "M22 - Banco Honda S.A."=>"M22 - Banco Honda S.A.",
        "63 - Banco Ibi S.A. Banco Múltiplo"=>"63 - Banco Ibi S.A. Banco Múltiplo",
        "M11 - Banco IBM S.A."=>"M11 - Banco IBM S.A.",
        "604 - Banco Industrial do Brasil S.A."=>"604 - Banco Industrial do Brasil S.A.",
        "320 - Banco Industrial e Comercial S.A."=>"320 - Banco Industrial e Comercial S.A.",
        "653 - Banco Indusval S.A."=>"653 - Banco Indusval S.A.",
        "630 - Banco Intercap S.A."=>"630 - Banco Intercap S.A.",
        "249 - Banco Investcred Unibanco S.A."=>"249 - Banco Investcred Unibanco S.A.",
        "184 - Banco Itaú BBA S.A."=>"184 - Banco Itaú BBA S.A.",
        "341 - Banco Itaú S.A."=>"341 - Banco Itaú S.A.",
        "479 - Banco ItaúBank S.A."=>"479 - Banco ItaúBank S.A.",
        "Banco Itaucard S.A."=>"Banco Itaucard S.A.",
        "M09 - Banco Itaucred Financiamentos S.A."=>"M09 - Banco Itaucred Financiamentos S.A.",
        "376 - Banco J. P. Morgan S.A."=>"376 - Banco J. P. Morgan S.A.",
        "74 - Banco J. Safra S.A."=>"74 - Banco J. Safra S.A.",
        "217 - Banco John Deere S.A."=>"217 - Banco John Deere S.A.",
        "65 - Banco Lemon S.A."=>"65 - Banco Lemon S.A.",
        "600 - Banco Luso Brasileiro S.A."=>"600 - Banco Luso Brasileiro S.A.",
        "389 - Banco Mercantil do Brasil S.A."=>"389 - Banco Mercantil do Brasil S.A.",
        "755 - Banco Merrill Lynch de Investimentos S.A."=>"755 - Banco Merrill Lynch de Investimentos S.A.",
        "746 - Banco Modal S.A."=>"746 - Banco Modal S.A.",
        "151 - Banco Nossa Caixa S.A."=>"151 - Banco Nossa Caixa S.A.",
        "45 - Banco Opportunity S.A."=>"45 - Banco Opportunity S.A.",
        "623 - Banco Panamericano S.A."=>"623 - Banco Panamericano S.A.",
        "611 - Banco Paulista S.A."=>"611 - Banco Paulista S.A.",
        "643 - Banco Pine S.A."=>"643 - Banco Pine S.A.",
        "Banco Porto Real de Investimentos S.A."=>"Banco Porto Real de Investimentos S.A.",
        "638 - Banco Prosper S.A."=>"638 - Banco Prosper S.A.",
        "747 - Banco Rabobank International Brasil S.A."=>"747 - Banco Rabobank International Brasil S.A.",
        "356 - Banco Real S.A."=>"356 - Banco Real S.A.",
        "633 - Banco Rendimento S.A."=>"633 - Banco Rendimento S.A.",
        "M16 - Banco Rodobens S.A."=>"M16 - Banco Rodobens S.A.",
        "72 - Banco Rural Mais S.A."=>"72 - Banco Rural Mais S.A.",
        "453 - Banco Rural S.A."=>"453 - Banco Rural S.A.",
        "422 - Banco Safra S.A."=>"422 - Banco Safra S.A.",        
        "250 - Banco Schahin S.A."=>"250 - Banco Schahin S.A.",
        "749 - Banco Simples S.A."=>"749 - Banco Simples S.A.",
        "366 - Banco Société Générale Brasil S.A."=>"366 - Banco Société Générale Brasil S.A.",
        "637 - Banco Sofisa S.A."=>"637 - Banco Sofisa S.A.",
        "464 - Banco Sumitomo Mitsui Brasileiro S.A."=>"464 - Banco Sumitomo Mitsui Brasileiro S.A.",
        "082-5 - Banco Topázio S.A."=>"082-5 - Banco Topázio S.A.",
        "M20 - Banco Toyota do Brasil S.A."=>"M20 - Banco Toyota do Brasil S.A.",
        "634 - Banco Triângulo S.A."=>"634 - Banco Triângulo S.A.",
        "208 - Banco UBS Pactual S.A."=>"208 - Banco UBS Pactual S.A.",
        "M14 - Banco Volkswagen S.A."=>"M14 - Banco Volkswagen S.A.",
        "655 - Banco Votorantim S.A."=>"655 - Banco Votorantim S.A.",
        "610 - Banco VR S.A."=>"610 - Banco VR S.A.",
        "370 - Banco WestLB do Brasil S.A."=>"370 - Banco WestLB do Brasil S.A.",
        "Banco Yamaha Motor S.A."=>"Banco Yamaha Motor S.A.",
        "21 - BANESTES S.A. Banco do Estado do Espírito Santo"=>"21 - BANESTES S.A. Banco do Estado do Espírito Santo",
        "719 - Banif-Banco Internacional do Funchal (Brasil)S.A."=>"719 - Banif-Banco Internacional do Funchal (Brasil)S.A.",
        "73 - BB Banco Popular do Brasil S.A."=>"73 - BB Banco Popular do Brasil S.A.",
        "78 - BES Investimento do Brasil S.A.-Banco de Investimento"=>"78 - BES Investimento do Brasil S.A.-Banco de Investimento",
        "69 - BPN Brasil Banco Múltiplo S.A."=>"69 - BPN Brasil Banco Múltiplo S.A.",
        "70 - BRB - Banco de Brasília S.A."=>"70 - BRB - Banco de Brasília S.A.",
        "104 - Caixa Econômica Federal"=>"104 - Caixa Econômica Federal",
        "477 - Citibank N.A."=>"477 - Citibank N.A.",
        "081-7 - Concórdia Banco S.A."=>"081-7 - Concórdia Banco S.A.",
        "487 - Deutsche Bank S.A. - Banco Alemão"=>"487 - Deutsche Bank S.A. - Banco Alemão",
        "751 - Dresdner Bank Brasil S.A. - Banco Múltiplo"=>"751 - Dresdner Bank Brasil S.A. - Banco Múltiplo",
        "62 - Hipercard Banco Múltiplo S.A."=>"62 - Hipercard Banco Múltiplo S.A.",        
        "492 - ING Bank N.V."=>"492 - ING Bank N.V.",
        "652 - Itaú Unibanco Holding S.A."=>"652 - Itaú Unibanco Holding S.A.",
        "488 - JPMorgan Chase Bank"=>"488 - JPMorgan Chase Bank",
        "409 - UNIBANCO - União de Bancos Brasileiros S.A."=>"409 - UNIBANCO - União de Bancos Brasileiros S.A.",
        "230 - Unicard Banco Múltiplo S.A."=>"230 - Unicard Banco Múltiplo S.A.");
 *
 */
      $bancos =  array(
	  	""=>"Selecione",
        "237"=>"Bradesco",
        "1"=>"Banco do Brasil",
        "4"=>"Banco do Nordeste do Brasil",
        "341"=>"Itaú",
        "33"=>"Santander",
        "104"=>"Caixa Econômica Federal",
      	"399"=>"HSBC",
        "409"=>"UNIBANCO");
        return $bancos;
    }

}

/* End of file tipos.php */
/* Location: ./system/application/libraries/tipos.php */