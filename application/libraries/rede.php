<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rede {

    var $valor_adesao = 20.00;
    var $valor_manutencao = 10.00;
    var $porcentagem_adesao = 40;
    var $porcentagem_manutencao = 10;

    function __construct(){
        $this->ci =& get_instance();
        $this->ci->load->model('adm/ModelUsuarios', 'musu');
        $this->ci->load->model('adm/Modelcomissoes', 'mcom');
    }

    //gera comissao para todos os uplines
    function gerar_comissoes($uid, $tipo = ''){
        //gera comissao para o patrocinador direto (nivel 1)
        if(($n1 = $this->ci->musu->getPatrocinador($uid)) !== false):
          foreach($n1->result() as $pat1):
            $patN1 = $pat1->uid;
            if($patN1 != 0)
              $this->_gerar_comissao($patN1, $uid, $tipo);
          endforeach;
          //se o tipo da comissao for "adesao", apenas o patrocinador direto irá receber
          //a comissao de 40% do valor pago
          if($tipo != "Adesão"):
			  //gera comissao para o patrocinador nivel 2
			  if(($n2 = $this->ci->musu->getPatrocinador($patN1)) !== false):
				foreach($n2->result() as $pat2):
				  $patN2 = $pat2->uid;
				  if($patN2 != 0)
					$this->_gerar_comissao($patN2, $uid, $tipo);
				endforeach;
				  //gera comissao para o patrocinador nivel 3
				if(($n3 = $this->ci->musu->getPatrocinador($patN2)) !== false):
				  foreach($n3->result() as $pat3):
					$patN3 = $pat3->uid;
					if($patN3 != 0)
					  $this->_gerar_comissao($patN3, $uid, $tipo);
				  endforeach;
					//gera comissao para o patrocinador nivel 4
					if(($n4 = $this->ci->musu->getPatrocinador($patN3)) !== false):
					  foreach($n4->result() as $pat4):
						$patN4 = $pat4->uid;
						if($patN4 != 0)
						  $this->_gerar_comissao($patN4, $uid, $tipo);
					  endforeach;
						//gera comissao para o patrocinador nivel 5 que tenha qualificacao AG, AD ou DM
						if(($n5 = $this->ci->musu->getPatrocinador($patN4)) !== false):
						  foreach($n5->result() as $pat5):
							$patN5 = $pat5->uid;
							if($patN5 != 0):
							  if($this->ci->musu->getQualificacao($patN5) == 'AG' ||
								 $this->ci->musu->getQualificacao($patN5) == 'AD' ||
								 $this->ci->musu->getQualificacao($patN5) == 'DM'):
									$this->_gerar_comissao($patN5, $uid, $tipo);
							  endif;
							endif;
						  endforeach;
							//gera comissao para o patrocinador nivel 6 que tenha qualificacao AD ou DM
							if(($n6 = $this->ci->musu->getPatrocinador($patN5)) !== false):
							  foreach($n6->result() as $pat6):
								$patN6 = $pat6->uid;
								if($patN6 != 0):
								  if($this->ci->musu->getQualificacao($patN6) == 'AD' ||
									 $this->ci->musu->getQualificacao($patN6) == 'DM'):
										$this->_gerar_comissao($patN6, $uid, $tipo);
								  endif;
								endif;
							  endforeach;
								//gera comissao para o patrocinador nivel 7 que tenha qualificacao DM
								if(($n7 = $this->ci->musu->getPatrocinador($patN6)) !== false):
								  foreach($n7->result() as $pat7):
									$patN7 = $pat7->uid;
									if($patN7 != 0 && $this->ci->musu->getQualificacao($patN7) == 'DM')
									  $this->_gerar_comissao($patN7, $uid, $tipo);
								  endforeach;
								endif;//n7
							endif;//n6
						endif;//n5
					endif;//n4
				endif;//n3
			  endif;//n2
          endif;//verificação do tipo
        endif;//n1
    }

    //gera comissao para todos os niveis
    private function _gerar_comissao($patrocinador, $downline, $tipo){
        //valores estaticos, deverao ser alterados para valores definidos pelo usuario
        //atraves da area administrativa
        if($tipo == "Adesão"):
            $valor = $this->valor_adesao * $this->porcentagem_adesao / 100;
        elseif($tipo == "Rede"):
            $valor = $this->valor_manutencao * $this->porcentagem_manutencao / 100;
        endif;
          $this->ci->mcom->inserirComissao($patrocinador, $downline, number_format($valor,2,',',''), $tipo);
    }

}

/* End of file rede.php */
/* Location: ./system/application/libraries/rede.php */