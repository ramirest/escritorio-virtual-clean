<?php

/**
 * Classe com alguns métodos 'callback' disponíveis no sistema.
 * 
 * @author	Ramires Teixeira
 * @version	1.0.0
 *
 */


class Callback extends CI_Controller {


    function __construct(){
        parent::__construct();
        $this->load->library("DX_Auth");
        $this->load->library("general");
        $this->load->model("adm/modelGeneral", "mgen");
        $this->load->model("adm/Modelrede", "mrede");
        $this->load->model("adm/Modelpedidos", "mped");
        $this->load->model("adm/ModelLocalizacao", "mlocalizacao");
        $this->load->model("adm/Modelassociados", "mass");
    }

    function geraLog($tipo, $descricao, $rotina = "", $metodo = "", $origem_log=1){
        $this->mgen->geraLog($tipo, $descricao, $rotina, $metodo, $origem_log);
    }
	
	function set_novos_cadastros(){
		$rede = $this->input->post("novos_cadastros");
		switch($rede):
			case 'AUTO':
				$html = <<<HTML
				<div class="col-lg-12" style="padding-left: 0px!important; margin-bottom: 15px;"><strong class="conf34">Atualmente os novos empresários estão sendo direcionados para sua REDE MENOR</strong></div>
<div> <strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="direita" value="D"></span>Direita</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="esquerda" value="E"></span>Esquerda</a>
</div>
</div>
HTML;
				break;
			case 'D':
				$html = <<<HTML
				<div class="col-lg-12" style="padding-left: 0px!important; margin-bottom: 15px;"><strong class="conf34">Atualmente os novos empresários estão sendo direcionados para sua rede da DIREITA</strong></div>
<div class="checkable-list"> <strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="AUTO" value="AUTO"></span>Rede menor</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="esquerda" value="E"></span>Esquerda</a>
</div>
</div>
HTML;
				break;
			case 'E':
				$html = <<<HTML
				<strong>Atualmente os novos empresários estão sendo direcionados para sua rede da ESQUERDA</strong>
<div class="checkable-list"> <strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="AUTO" value="AUTO"></span>Rede menor</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="direita" value="D"></span>Direita</a>
</div>
</div>
HTML;
				break;
		endswitch;
		$result = $this->mass->_setNovosCadastros($this->dx_auth->get_associado_id(), $rede);
		if ($result == 0):
			echo $this->config->item('err_msg_style').'Ocorreu um erro ao atualizar suas configurações, tente novamente ou entre em contato com a central de atendimento'.$this->config->item('msg_style_end');
		else:
            $msg = $this->config->item('suc_msg_style').
				 'Suas configurações foram salvas com sucesso'.
				 $this->config->item('msg_style_end');
			echo form_open().
				 $msg.
				 '<br>'.
				 $html.
				 form_close();	 
        endif;
	}

	function get_novos_cadastros(){
		$result = $this->mass->_getNovosCadastros($this->dx_auth->get_associado_id());
		switch ($result):
			case 'AUTO':		
				$html = <<<HTML
				<div class="col-lg-12" style="padding-left: 0px!important; margin-bottom: 15px;"><strong class="conf34">Atualmente os novos empresários estão sendo direcionados para sua REDE MENOR</strong></div>
<div class="checkable-list"> <strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="direita" value="D"></span>Direita</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="esquerda" value="E"></span>Esquerda</a>
</div>
</div>
HTML;
				break;
			case 'D':
				$html = <<<HTML
				<div class="col-lg-12" style="padding-left: 0px!important; margin-bottom: 15px;"><strong class="conf34">Atualmente os novos empresários estão sendo direcionados para sua rede da DIREITA</strong></div>
<div class="checkable-list"> <strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="AUTO" value="AUTO"></span>Rede menor</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="esquerda" value="E"></span>Esquerda</a>
</div>
</div>
HTML;
				break;
			case 'E':
				$html = <<<HTML
				<div class="col-lg-12" style="padding-left: 0px!important; margin-bottom: 15px;"><strong class="conf34">Atualmente os novos empresários estão sendo direcionados para sua rede da esquerda</strong></div>
<div class="checkable-list"><strong>Direcionar os novos associados para a rede</strong>
<div class="list-group conf33">
<a  class="list-group-item"><span class="badge green conf01"><input type="radio" class="radio33" name="novos_cadastros" id="AUTO" value="AUTO"></span>Rede menor</a>
<a  class="list-group-item"><span class="badge orange conf01"><input type="radio" class="radio33" name="novos_cadastros" id="direita" value="D"></span>Direita</a>
</div>
</div>
HTML;
				break;
		endswitch;
			echo form_open().
				 $html.
				 form_close();	 
	}

	function associado_check()
	{
		$result = $this->mass->getAssociado('', 'Login', $this->input->post("usuario"));
		if ($result === FALSE):
			echo $this->config->item('err_msg_style').'O associado informado não existe.'.$this->config->item('msg_style_end');
		else:
            foreach($result->result() as $ass):
                $associado['nome'] = $ass->Nome;
                $associado['id'] = $ass->aid;
            endforeach;
            echo $this->config->item('suc_msg_style').
				 $associado['nome'].
				 '<input type="hidden" name="aid" id="aid" value="'.$associado['id'].'">'.
				 $this->config->item('msg_style_end');
        endif;
	}

    function associado_load($aid)
    {
      if($this->dx_auth->is_logged_in()):
		$this->load->helper('text');
		
		$dados['associado'] = $this->mass->getAssociado($aid)->row();

		$dados['titulo'] = 'Gerenciamento de Empresários';
		$this->load->vars($dados);
		$this->load->view('themes/backend/empresarios/exibe');
      else:
        redirect('principal');
      endif;
    }

	function preparaCep($endereco, $bairro, $cidade, $estado, $msg=""){
		if($msg != "")
		 $msg = '<div class="row"><div class="alert alert-warning col-sm-4">'.$msg.'</div></div>';
		else
		 $msg = "";
        $logradouro = array(
					'name'=>'logradouro',
					'id'=>'logradouro',
					'value'=>set_value('logradouro', $endereco),
					'class'=>'form-control');

        $logradouro = form_input($logradouro);

		$numero = array(
			'name'=>'numero',
			'id'=>'numero',
			'value'=>set_value('numero'),
			'class'=>'form-control');

		$numero = form_input($numero);

		$complemento = array(
			'name'=>'complemento',
			'value'=>set_value('complemento'),
			'class'=>'form-control');

		$complemento = form_input($complemento);

		$bairro = array(
			'name'=>'bairro',
			'id'=>'bairro',
			'value'=>set_value('bairro', $bairro),
			'class'=>'form-control');

		$bairro = form_input($bairro);

		$cidade = array(
			'name'=>'cidade',
			'id'=>'cidade',
			'value'=>set_value('cidade', $cidade),
			'class'=>'form-control');

		$cidade = form_input($cidade);

		$estado = array(
			'name'=>'estado',
			'id'=>'estado',
			'value'=>set_value('estado', $estado),
			'class'=>'form-control');

		$estado = form_input($estado);
		$html = <<<HTML
			{$msg}
            <div style=" font-size:15px; margin-top:15px;">Endereço:</div>
            <div class="row">    
                <p class="col-md-10" style=" margin-top:2px;">
                {$logradouro}
                </p>
            </div>
              
            <div style=" font-size:15px; margin-top:15px;">Número:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				{$numero}
                </p>
              </div>
              
            <div style=" font-size:15px; margin-top:15px;">Complemento:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				{$complemento}
                </p>
             </div> 
              
            <div style=" font-size:15px; margin-top:15px;">Bairro:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				{$bairro}
                </p>
              </div>
              
            <div style=" font-size:15px; margin-top:15px;">Cidade:</div>
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
				{$cidade}
                </p>
              </div>
              
            <div style=" font-size:15px;  margin-top:15px;">Estado:</div>
              
            <div class="row">    
                <p class="col-md-4" style=" margin-top:2px;">
                {$estado}
                </p>
            </div>
HTML;

	return $html;
	}
	
	function buscacep()
	{
		$cep = $this->input->post('cep');
		if(!empty($cep)):
			if(($endereco = $this->mlocalizacao->getEndereco($cep)) !== FALSE):
				echo $this->preparaCep($endereco->endereco, $endereco->bairro, $endereco->cidade, $endereco->estado);
			else:
				echo $this->preparaCep($endereco->endereco, $endereco->bairro, $endereco->cidade, $endereco->estado, "CEP não encontrado");
			endif;
		else:
			//echo $this->preparaCep($endereco->endereco, $endereco->bairro, $endereco->cidade, $endereco->estado, "CEP não informado");
		endif;
	}

	function checkcep($cep){
		if(!empty($cep)):
			if(($endereco = $this->mlocalizacao->getEndereco($cep)) !== FALSE):
				$arr = array("endereco"=>"$endereco->endereco",
							"bairro"=>"$endereco->bairro",
							"cidade"=>"$endereco->cidade",
							"estado"=>"$endereco->estado",
							"resultado"=>"1");
				return $arr;
			else:
				return FALSE;
			endif;
		else:
			return FALSE;
		endif;
	}
	
	function buscacep2()
	{
        $cep = $this->input->get('cep');
		echo json_encode($this->checkcep($cep));
	}

    function login_check()
    {
        $this->load->model ( "adm/ModelAssociados", "mass" );
        $login = $this->input->post ( "login" );
        //verifica se o login já está sendo utilizado
        $result = $this->mass->getAssociado ( '', 'Login', $login, '', 'Login' );
        if ($result != FALSE) :
            echo '<p class="alert alert-danger">Este login já está sendo utilizado.</p>';
        endif;
    }

    function cpf_check()
	{
		$this->load->model ( "adm/ModelAssociados", "mass" );
		$cpf = $this->input->post ( "cpf" );
		if ($cpf == '___.___.___-__') :
			echo '<p class="alert alert-danger">Por favor, informe seu CPF.</p>';
		elseif ($this->cpf_validation($cpf) === TRUE) :
            //verifica se o cpf já está sendo utilizado
			$result = $this->mass->getAssociado ( '', 'cpf', $cpf, '', 'cpf' );
			if ($result != FALSE) :
				echo '<p class="alert alert-danger">Este cpf já está sendo usado.</p>';
			endif;
		else :
			echo '<p class="alert alert-danger">O CPF informado não é válido</p>';
		endif;		
	}
	
	function patrocinador_check()
	{
		$this->load->model ( "adm/ModelAssociados", "mass" );
		$result = $this->mass->getAssociado ( '', 'Login', $this->input->post ( "usuario" ) );
		if ($this->input->post ( "usuario" ) == NULL) :
			echo '<p class="alert alert-danger">Você precisa informar um patrocinador para continuar!</p>';
		elseif ($result === FALSE) :
			echo '<p class="alert alert-danger">O usuário informado não existe.</p>';
		else :
            foreach ( $result->result () as $pat ) :
                $patrocinador ['nome'] = $pat->Nome;
                $patrocinador ['id'] = $pat->aid;
            endforeach;
            echo '<p class="alert alert-success">' . $patrocinador ['nome'] . '<input type="hidden" name="patrocinador" value="' . $patrocinador ['id'] . '"></p>';
		endif;
	}
	
	function cpf_validation($cpf)
	{
	
		/**
		 * Verifica se o CPF informado é valido
		 * @param     string
		 * @return     bool
		 */
		// Verifiva se o número digitado contém todos os digitos
		$cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
	
		// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
		if (strlen($cpf) != 11 ||
		$cpf == '00000000000' ||
		$cpf == '11111111111' ||
		$cpf == '22222222222' ||
		$cpf == '33333333333' ||
		$cpf == '44444444444' ||
		$cpf == '55555555555' ||
		$cpf == '66666666666' ||
		$cpf == '77777777777' ||
		$cpf == '88888888888' ||
		$cpf == '99999999999') {
			return FALSE;
		} else {
			// Calcula os números para verificar se o CPF é verdadeiro
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
	
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return FALSE;
				}
			}
			return TRUE;
		}
	}
}

/* End of file callback.php */
/* Location: ./system/application/controllers/callback.php */