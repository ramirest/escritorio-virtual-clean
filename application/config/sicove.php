<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
|---------------------------------------------------------------
| CONFIGURACAO GERAL
|---------------------------------------------------------------
 */
##########################
##      Constantes     ##
#########################
define('NOME_EMPRESA', 'Recarga Gold');
//DADOS EMPRESA
define('EMPRESA_CEP', '35160019');

//Configurações de frete
define('EMPRESA_DIAS_FRETE', 7);

//Status das faturas

//Pendente
define('STATUS_PENDENTE', 1);
//Aguardando pagamento
define('STATUS_AGUARDANDO_PAGAMENTO', 2);
//Pago
define('STATUS_PAGO', 3);
//Aguardando faturamento
define('STATUS_AGUARDANDO_FATURAMENTO', 4);
//Faturado
define('STATUS_FATURADO', 5);
//Enviado aos correios/transportadora
define('STATUS_ENVIADO', 6);
//Entregue
define('STATUS_ENTREGUE', 7);
//Cancelado
define('STATUS_CANCELADO', 8);

$config['saudacao_login'] = "Seja bem-vindo à ". NOME_EMPRESA ."!";

##########################
## Regras internas		##
##########################

$config['precadastro'] = TRUE;
//Total de parcelas do cadastro
$config['total_parcelas'] = 12;
$config['taxa_adesao'] = 100;
$config['profundidade_unilevel'] = 12;


// Prazo para vencimento do boleto. Ex: 07/03/2014 -- 09/03/2014
$config['prazo_boleto'] = 7;

$config['notificacao'] = "";
$a = "
<strong>Prezados usuários</strong>
<p><br>
Em virtude de novas implementações que estão sendo efetuadas no sistema,
 os bônus de liderança e cash que deveriam ser disponibilizados no dia 05, <br>excepcionalmente neste mês de agosto,
 ficarão para o dia 10. Os demais bônus e pontuações continuam operando normalmente.<br>
<br>
 Atenciosamente,
<br><br>
". NOME_EMPRESA ."
</p>
";


##########################
##   Valor dos Bônus	##
##########################

/*
*	Bônus de cadastro
*
*	50% do valor da taxa de adesão
*
*/
$config['bonus_cadastro'] = $config['taxa_adesao'] * 0.5;
$config['msg_bonus_cadastro'] = 'Bônus referente ao cadastro do associado(a) %s (# %s).';

/*
*	Bônus de pacotes
*
*	10% do valor do pacote
*
*	Percentual que será calculado baseado no tipo de cadastro do novo associado
*/
$config['bonus_pacotes'] = 0.1;
$config['msg_bonus_pacotes'] = 'Bônus referente ao pacote %s do associado(a) %s (# %s) que será pago %s.';

$config['taxa_saque'] = 10;


#############################
## Configurações do sistema #
#############################
$config['empresa'] = NOME_EMPRESA;
$config['email_suporte'] = 'suporte@recargagold.com';
 
$config['nome_site'] = "";

$config['versao'] = '1.0';

$link_tag['begin'] = '<link href="';
$link_tag['end'] = '" rel="stylesheet">';
$script_tag['begin'] = '<script src="';
$script_tag['end'] = '"></script>';

$config['assets'] = config_item('base_url') . 'assets/';
$config['assets_crud'] = config_item('base_url') . 'assets/grocery_crud/';

$config['gen'] = config_item('base_url') . '/files/general/';

$config['misc'] = config_item('base_url') . '/files/backend/';
$config['img']  = $config['misc'] . 'images/';
$config['css']  = $config['misc'] . 'css/';
$config['js']   = $config['misc'] . 'js/';

$config['misc_f'] = config_item('base_url') . '/files/frontend/';
$config['img_f']  = $config['misc_f'] . 'images/';
$config['css_f']  = $config['misc_f'] . 'css/';
$config['js_f']   = $config['misc_f'] . 'js/';
$config['vds_f']   = $config['misc_f'] . 'videos/';


$config['temas'] = $config['misc'] . 'themes/';
$config['v2'] = $config['temas'] . 'v2.0/';

$config['tema']['css'] = $config['v2'] . 'css/';
$config['tema']['icons'] = $config['v2'] . 'icons/';
$config['tema']['img'] = $config['v2'] . 'img/';
$config['tema']['js'] = $config['v2'] . 'js/';

$config['plugins']['css']['graficos'] = array($link_tag['begin'].$config['tema']['css'] . 'plugins/'.'morris/morris.css'.$link_tag['end']);

$config['plugins']['js']['graficos'] = array(
										$script_tag['begin'].$config['tema']['js'] . 'plugins/'.'morris/raphael-2.1.0.min.js'.$script_tag['end'],										
										$script_tag['begin'].$config['tema']['js'] . 'plugins/'.'morris/morris.js'.$script_tag['end'],										
										$script_tag['begin'].$config['tema']['js'] . 'plugins/'.'morris/graficos.js'.$script_tag['end'],
											);

$config['plugins']['css']['ecommerce'] = array($link_tag['begin'].$config['assets_crud'] . 'themes/escritorio-virtual/css-flex/ecommerce.css'.$link_tag['end']);

$config['plugins']['js']['ecommerce'] = array(
    $script_tag['begin'].$config['assets_crud'] .'themes/escritorio-virtual/js-flex/plugins/elevatezoom/elevatezoom-min.js'.$script_tag['end'],
    $script_tag['begin'].$config['assets_crud'] .'themes/escritorio-virtual/js-flex/ecommerce.js'.$script_tag['end']);

$config['plugins']['css']['date'] = array($link_tag['begin'].$config['tema']['css'] . 'plugins/'.'bootstrap-datepicker/datepicker3.css'.$link_tag['end']);

$config['plugins']['js']['date'] = array($script_tag['begin'].$config['tema']['js'] . 'plugins/'.'bootstrap-datepicker/bootstrap-datepicker.js'.$script_tag['end']);

$config['styles']['rede']	= array($link_tag['begin'].$config['css'].'arvore.css'.$link_tag['end']);

$config['styles']['estoque']	= array(
    $link_tag['begin'].$config['assets_crud'].'themes/escritorio-virtual/css-flex/plugins/bootstrap-datepicker/datepicker3.css'.$link_tag['end'],
    $link_tag['begin'].$config['assets_crud'].'themes/escritorio-virtual/css-flex/plugins/datatables/datatables.css'.$link_tag['end'],
    $link_tag['begin'].$config['assets_crud'].'themes/escritorio-virtual/css-flex/plugins/estoque/estoque.css'.$link_tag['end']
);

$config['styles']['extrato']	= array(
    $link_tag['begin'].$config['assets_crud'].'themes/escritorio-virtual/css-flex/plugins/bootstrap-datepicker/datepicker3.css'.$link_tag['end'],
    $link_tag['begin'].$config['assets_crud'].'themes/escritorio-virtual/css-flex/plugins/datatables/datatables.css'.$link_tag['end']
);

$config['scripts']['funcoes']['foot'] = array($script_tag['begin'].$config['js'].'functions.js'.$script_tag['end']);

$config['scripts']['planos']['foot'] = array($script_tag['begin'].$config['js'].'planos.js'.$script_tag['end']);

$config['scripts']['rede']['foot'] = array(
										$script_tag['begin'].$config['js'].'jquery-validate.min.js'.$script_tag['end'],										
										$script_tag['begin'].$config['gen'].'js/mask.min.js'.$script_tag['end'],										
										$script_tag['begin'].$config['js'].'functions.js'.$script_tag['end'],
											);
$config['scripts']['estoque']['foot'] = array(
    $script_tag['begin'].$config['assets_crud']."themes/escritorio-virtual/js-flex/plugins/bootstrap-datepicker/bootstrap-datepicker.js".$script_tag['end'],
    $script_tag['begin'].$config['assets_crud']."themes/escritorio-virtual/js-flex/plugins/bootstrap/bootstrap-datetimepicker.pt-BR.js".$script_tag['end'],
    $script_tag['begin'].$config['js'].'financeiro/extrato.js'.$script_tag['end'],
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/jquery.dataTables.js'.$script_tag['end'],
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/datatables-bs3.js'.$script_tag['end']
);

$config['scripts']['extrato']['foot'] = array(
    $script_tag['begin'].$config['assets_crud']."themes/escritorio-virtual/js-flex/plugins/bootstrap-datepicker/bootstrap-datepicker.js".$script_tag['end'],
    $script_tag['begin'].$config['assets_crud']."themes/escritorio-virtual/js-flex/plugins/bootstrap/bootstrap-datetimepicker.pt-BR.js".$script_tag['end'],
    $script_tag['begin'].$config['js'].'financeiro/extrato.js'.$script_tag['end'],
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/jquery.dataTables.js'.$script_tag['end'],
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/datatables-bs3.js'.$script_tag['end']
);
$config['scripts']['tables']['foot'] = array(
										$script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/jquery.dataTables.js'.$script_tag['end'],
										$script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/datatables-bs3.js'.$script_tag['end'],
										$script_tag['begin'].$config['js'].'functions.js'.$script_tag['end'],
											);
$config['scripts']['pedidos']['foot'] = array(
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/jquery.dataTables.js'.$script_tag['end'],
    $script_tag['begin'].$config['tema']['js'] . 'plugins/'.'datatables/datatables-bs3.js'.$script_tag['end'],
    $script_tag['begin'].$config['js'].'pedidos.js'.$script_tag['end'],
);
/*
$config['scripts']['rede']['foot'] = array(
										$script_tag['begin'].$config['tema']['js'].'plugins/validate/jquery.validate.min.js'.$script_tag['end']);
*/

//	Mensagens de erro referente aos empresários
$config['errno']['1000'] = 'O Patrocinador escolhido não pode cadastrar empresários no plano escolhido, por favor, escolha o plano "Consumo" para continuar.';
$config['errno']['1010'] = 'Não foi possível localizar informações do empresário informado, por favor, tente novamente.';

//	Mensagens de erro referente aos pedidos/faturas
$config['errno']['2000'] = 'Fatura não encontrada';
$config['errno']['2001'] = 'O pagamento da fatura não foi concretizado';
$config['errno']['2002'] = 'O pagamento da fatura foi completado porém o bônus do patrocinador não foi gerado';
$config['errno']['2003'] = 'Ocorreu um erro ao tentar atualizar o status da fatura, por favor, tente novamente ou entre em contato com o suporte técnico.';


##########################
## HTML e Formulários   ##
##########################
/*	
* Estilização das mensagens de sucessos e erros apresentadas nos formulários
*
* Usado nos formulários: cadastro de associados, boletos
*
*/
$config['ale_msg_style'] = '<small class="%s"><p class="alert alert-warning">';
$config['err_msg_style'] = '<small class="%s"><p class="alert alert-danger">'; //class by bootstrap
$config['suc_msg_style'] = '<small class="%s"><p class="alert alert-success">';

$config['msg_style_end'] = '</p></small>';

$config['rede_posicao_vazia'] = '<a href="#" data-placement="top" data-toggle="tooltip" class="tip-top" data-original-title="Nenhum associado nessa posição!">'.
					'<img src="'.$config['img'].'arvore/ic_empty.png" />'.
				'</a>';
/*
$config['rede_posicao_vazia'] = '<a href="#">'.
					'<img src="'.$config['img'].'arvore/ic_empty.png" />'.
				'</a>';
*/								
/*	
* Estilização dos formularios 
*
* Quando for possível usar dados genéricos 
* e não houver necessidade de utilizar os atributos "id" e/ou "name"
* para esse caso deve-se definir as informações "in-line" para o formulário específico
*
*/
$config['form_style'] = array('class'=>'block-content no-title form');

//tabelas
$config['table_template'] = array('table_open'=>'<table class="table" cellspacing="0" width="100%">');

//botões
//genéricos
$config['btn_save'] = array('name'=>'save',
				 		   'id'=>'save',
						   'class'=>'btn btn-default',
						   'type'=>'submit',
				 		   'content'=>'<i class="fa fa-save"></i>
							 		   Salvar',
				 		   'value'=>'save');

//usado na página de criação de papéis
$config['btn_add'] = array('name'=>'add',
				 		   'id'=>'add',
						   'class'=>'btn btn-default',
				 		   'type'=>'submit',
				 		   'content'=>'<i class="fa fa-plus"></i>
							 		   Adicionar',
				 		   'value'=>'add');
						   
//usado na página de criação de papéis
$config['btn_delete'] = array('name'=>'delete',
							  'id'=>'delete',
							  'class'=>'btn btn-default',
							  'type'=>'submit',
							  'content'=>'<i class="fa fa-minus"></i>
										  Excluir selecionado(s)',
							  'value'=>'delete');
//usado na página de gestão de usuários
$config['btn_ban'] = array('name'=>'ban',
				 		   'id'=>'ban',
						   'class'=>'btn btn-default',		
				 		   'type'=>'submit',
				 		   'content'=>'<i class="fa fa-lock"></i>
							 		   Bloquear',
				 		   'value'=>'ban');
						   
//usado na página de gestão de usuários
$config['btn_unban'] = array('name'=>'unban',
							 'id'=>'unban',
							 'class'=>'btn btn-default',		
							 'type'=>'submit',
							 'content'=>'<i class="fa fa-unlock"></i>
										  Desbloquear', 
							 'value'=>'unban');
//usado na página de gestão de usuários
$config['btn_reset_pass'] = array('name'=>'reset_pass',
							  	  'reset_pass'=>'reset_pass',
								  'class'=>'btn btn-default',		
							  	  'type'=>'submit',
							  	  'content'=>'<i class="fa fa-key"></i>
										  	  Recriar senha', 
							  	  'value'=>'reset_pass');
							  
$config['btn_back_url'] = 'adm';
$config['btn_back_txt'] = '<img src="' . $config['img']
									   . 'icons/fugue/navigation-180.png"'
									   . 'alt="Voltar ao painel"> Voltar ao painel';
										  
$config['btn_back_attr'] = array('class'=>'big-button');


//define os campos das tabelas utilizados para cadastro, os tipos dos campos
// e as opções de seleção para campos do tipo dropdown ou similares
#############
## Empresa ##
#############
$config['itens_form']['empresa'] = array('razao_social'=>'Razão social',
										  'fantasia'=>'Fantasia',
										  'cnpj'=>'CNPJ',
										  'ie'=>'Inscrição estadual',
										  'status'=>'Status');
//informa qual item da lista anterior não é do tipo "input"
$config['itens_form']['empresa_types'] = array(4=>'dropdown');										  
$config['itens_form']['empresa_type_options'] = array('status'=>array('A'=>'Ativo','I'=>'Inativo'),'default'=>'A');

##########################
## Endereços da empresa ##
##########################
$config['itens_form']['empresa_endereco'] = array('tipo'=>'Tipo',
										  'cep'=>'CEP',
										  'logradouro'=>'Logradouro',
										  'numero'=>'Número',
										  'complemento'=>'Complemento',
										  'bairro'=>'Bairro',
										  'cidade'=>'Cidade',
										  'estado'=>'Estado');
##########################
## Telefones da empresa ##
##########################
$config['itens_form']['empresa_telefone'] = array('tp_telefone'=>'Tipo',
										  'numtel'=>'Número');

//informa qual item da lista anterior não é do tipo "input"
$config['itens_form']['empresa_tel_types'] = array(0=>'dropdown');										  
$config['itens_form']['empresa_tel_type_options'] = array('tp_telefone'=>array('comercial'=>'Comercial','fax'=>'Fax','celular'=>'Celular'),'default'=>'comercial');



?>
