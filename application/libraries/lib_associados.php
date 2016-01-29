<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_associados {

    function __construct(){
        $this->ci =& get_instance();
		$this->ci->load->helper("text");
        $this->ci->load->library('DX_Auth');
		$this->ci->load->library("typography");
		$this->ci->load->library('Session');
		$this->ci->load->library("data");
        $this->ci->load->model('adm/ModelAssociados', 'mass');
        $this->ci->load->model('Modelboleto', 'mboleto');
        $this->ci->load->model('adm/Modelplanos', 'mplano');
		$this->ci->load->model('adm/Modelpedidos', 'mped');
		$this->ci->load->model('adm/Modelrede', 'mrede');
    }
	
	public function _getNomeAssociado($associado="", $sobrenome = FALSE){
		  $aid = $associado==""?$this->ci->dx_auth->get_associado_id():$associado;
		  $dados = word_limiter($this->ci->mass->get_name($aid)->nome,$sobrenome===TRUE?2:1,"");
		  return $dados;											
	}
	
	public function set_patrocinador($patrocinador){
		if(($patrocinador = $this->ci->mass->getAssociado('', 'Login', $patrocinador)) !== FALSE):
			$pat = $patrocinador->row();
			$this->ci->session->set_userdata('patrocinador', $pat);
			return TRUE;
		else:
			return FALSE;
		endif;			
	}

	public function get_saldo(){
		if(($rendimentos = $this->ci->mped->get_saldo($this->ci->dx_auth->get_associado_id())) !== FALSE)
			$saldo = $rendimentos;
		else
			$saldo = '0.00';
			
		return $saldo;	
	}
		
	function pre_cadastro(){
        $form = $this->_get_form_values();
        //efetua o cadastro do associado
        if(($id = $this->ci->mass->pre_cadastro($form)) !== FALSE):

			$this->ci->mass->geraLog('INFO', 'Gerando dados de usuário na sessão', 'Cadastro', 'pre_cadastro');
			$this->ci->session->set_userdata("aid",$id);
		  //cria o associado de acesso ao sistema e envia um email de confirmacao
          $this->ci->dx_auth->register($form['infoconta']['login'], $form['infoconta']['senha'], $form['infocontato']['email'], $id);		  
		  
          //configuracao do boleto
          if(($boleto = $this->ci->mboleto->getBoleto()) !== FALSE):
            foreach($boleto->result() as $result):
              $dados_boleto['all'] = $result;
            endforeach;

            //vencimento da taxa de adesao
            $vencimento = date("Y-m-d", now() + ($dados_boleto['all']->dias_prazo_pagamento * 86400));
			
            $valor_cobrado = str_replace(",", ".",$this->ci->config->item('taxa_adesao'));
            //calcula valor da taxa de adesao
            $valor=number_format($valor_cobrado+$dados_boleto['all']->taxa_boleto, 2, ',', '');
			

            //gera faturas
			//$this->ci->mped->geraFatura($this->ci->mass->aid, $vencimento, $valor);
			$msg = 
				$this->ci->config->item('suc_msg_style'). 
				'Seu cadastro foi efetuado com sucesso!<br>'.
				'Segue abaixo seus dados cadastrados, utilize-os para acessar o sistema.<br><br>'.
				'Nome: '.$form['dados_pessoais']['nome_completo']."<br>".
				'ID: '.$id."<br>".
				'Login: '.$form['infoconta']['login']."<br>".
				'Email: '.$form['infocontato']['email']."<br><br>".
				'Seja bem vindo ao '. NOME_EMPRESA .'!<br><br>'.
				'<strong>Equipe '. NOME_EMPRESA .'</strong>'.
				$this->ci->config->item('msg_style_end');
				
								
				
				
          endif;
          return $msg;
        else:
          return FALSE;
        endif;
	}

	function _get_form_values($editando = FALSE)
	{
		if($editando===TRUE):
			//caso esteja editando um registro
			$v['dados_pessoais']['aid'] = $this->ci->input->post('aid');
		endif;
		//dados pessoais
	//	$v['dados_pessoais']['tp_cadastro'] = $this->ci->input->post('tp_cadastro');			
		$v['dados_pessoais']['nome_completo'] = $this->ci->typography->format_characters($this->ci->input->post('nome_completo'));
		$v['dados_pessoais']['sexo'] = $this->ci->input->post('sexo');
		$v['dados_pessoais']['dtnasc'] = $this->ci->data->human_to_mysql($this->ci->input->post('dtnasc'));
		$v['dados_pessoais']['cpf'] = $this->ci->input->post('cpf');
		$v['dados_pessoais']['rg'] = $this->ci->input->post('rg');
		$v['dados_pessoais']['pis_pasep'] = $this->ci->input->post('pis_pasep');
		$v['dados_pessoais']['profissao'] = $this->ci->typography->format_characters($this->ci->input->post('profissao'));
		$v['dados_pessoais']['funcao_empresa'] = $this->ci->typography->format_characters($this->ci->input->post('funcao_empresa'));
/*		if($this->ci->input->post('tp_cadastro') == 'PJ'):
			$v['dados_empresa']['nome_fantasia'] = $this->ci->input->post('nome_fantasia');
			$v['dados_empresa']['razao_social'] = $this->ci->input->post('razao_social');
			$v['dados_empresa']['cnpj'] = $this->ci->input->post('cnpj');
			$v['dados_empresa']['ie'] = $this->ci->input->post('ie');
		endif;*/

		//endereco
		$v['endereco']['tipo'] = $this->ci->input->post('tipo');
		$v['endereco']['cep'] = $this->ci->input->post('cep');
		$v['endereco']['logradouro'] = $this->ci->typography->format_characters($this->ci->input->post('logradouro'));
		$v['endereco']['numero'] = $this->ci->input->post('numero');
		$v['endereco']['complemento'] = $this->ci->input->post('complemento');
		$v['endereco']['bairro'] = $this->ci->typography->format_characters($this->ci->input->post('bairro'));
		$v['endereco']['cidade'] = $this->ci->typography->format_characters($this->ci->input->post('cidade'));
		$v['endereco']['estado'] = $this->ci->input->post('estado');

		//informacoes para contato
		$v['dados_pessoais']['tel_fixo'] = $this->ci->input->post('tel_fixo');
		$v['dados_pessoais']['tel_celular'] = $this->ci->input->post('tel_celular');
        $v['dados_pessoais']['tel_comercial'] = $this->ci->input->post('tel_comercial');
		$v['infocontato']['email'] = $this->ci->input->post('email');

		//informacoes da conta do associado
		$v['infoconta']['login'] = strtolower($this->ci->input->post('login'));
		$v['infoconta']['senha'] = $this->ci->input->post('senha');
        $patrocinador_txt = $this->ci->input->post('patrocinador_txt');

        if(isset($patrocinador_txt) && !empty($patrocinador_txt) && $patrocinador_txt != ''):
            $ass = $this->ci->mass->getUserByLogin($this->ci->input->post('patrocinador_txt'));

            if($ass === FALSE):
                $ass = 0;
                $this->ci->load->model('adm/modelgeneral', 'mgen');
                $this->ci->mgen->geraLog('ERRO', 'Associado sem patrocinador. Login informado para patrocinador: '.$this->ci->input->post('patrocinador_txt'),'cadastro_de_associados', '_get_form_values');
            endif;

            $v['infoconta']['patrocinador'] = $ass->aid;//$this->ci->input->post('patrocinador');
        else:
            $v['infoconta']['patrocinador'] = $this->ci->input->post('patrocinador');
        endif;
        //rede onde o associado deverá ser alocado
		//$v['infoconta']['rede_alocacao'] = $this->ci->input->post('rede_alocacao');

		//informacoes para bancárias para recebimento
        $v['infobanco']['titular'] = $this->ci->input->post('titular');
        $v['infobanco']['banco'] = $this->ci->input->post('banco');
        $v['infobanco']['tpconta'] = $this->ci->input->post('tpconta');
        $v['infobanco']['agencia'] = $this->ci->input->post('agencia');
        $v['infobanco']['conta'] = $this->ci->input->post('conta');
        $v['infobanco']['op'] = $this->ci->input->post('op');
		//dados do dependente
        $v['dependente']['tdid'] = $this->ci->input->post('tdid');
        $v['dependente']['nome_completo'] = $this->ci->input->post('nome_dependente');
        $v['dependente']['sexo'] = $this->ci->input->post('sexo');
        $v['dependente']['dtnasc'] = $this->ci->data->human_to_mysql($this->ci->input->post('dtnasc'));
        $v['dependente']['cpf'] = $this->ci->input->post('cpf');

 		//informações sobre o plano
/* 		$v['plano']['pid'] = $this->ci->input->post('plano');
 */
		//Forma de pagamento do plano
/*         $v['forma_pgto'] = $this->ci->input->post('forma_pgto_plano');
 */
		return $v;

	}

}

/* End of file lib_associados.php */
/* Location: ./system/application/libraries/lib_associados.php */
