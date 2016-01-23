<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cadastro de Associados</title>
</head>

<body>

<div id="formulario">
<form action="<?php echo site_url("escritorio-virtual/usuarios/editar/".$usuario->uid); ?>" method="post" id="cadastro">
<?php echo form_hidden('uid', $usuario->uid); ?>
<?php echo form_hidden('rid', $recebimento->rid); ?>

<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Plano de Assinatura</th>
</tr>
<tr>
	<td class="first">Selecione o Plano</td>
    <td class="last">
    <?php echo form_dropdown('plano', $planos, isset($usuario->pid)?$usuario->pid:''); ?>
	</td>
</tr>
</table>
</div>
</fieldset>
<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Dados Pessoais</th>
</tr>
<tr>
	<td class="first">Nome Completo</td>
    <td class="last">
    	<?php echo form_input('nome_completo', isset($usuario->nome_completo)?$usuario->nome_completo:'');  ?>
		<?php echo form_error('nome_completo', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">CPF</td>
    <td class="last">
    	<?php echo form_input('cpf', isset($pf->cpf)?$pf->cpf:'');  ?>
		<?php echo form_error('cpf', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">RG</td>
    <td class="last">
    	<?php echo form_input('rg', isset($pf->rg)?$pf->rg:'');  ?>
		<?php echo form_error('rg', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Data de Nascimento</td>
    <td class="last">
    	<?php echo form_input('dtnasc', $this->data->mysql_to_human($pf->dtnasc)); ?>
		<?php echo form_error('dtnasc', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
</table>
</div>
</fieldset>
<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Endere&ccedil;o</th>
</tr>
<tr>
	<td class="first">Tipo</td>
    <td class="last">
    	<?php echo form_dropdown('tipo', $tipos, $tipo); ?>
		<?php echo form_error('tipo', '<div class="erro">', '</div>'); ?>
	</td>
</tr>
<tr>
	<td class="first">CEP</td>
    <td class="last">
    	<?php echo form_input('cep', isset($endereco->cep)?$endereco->cep:''); ?>
		<?php echo form_error('cep', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Logradouro</td>
    <td class="last">
    	<?php echo form_input('logradouro', isset($endereco->logradouro)?$endereco->logradouro:''); ?>
		<?php echo form_error('logradouro', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">N&uacute;mero</td>
    <td class="last">
    	<?php echo form_input('numero', isset($endereco->numero)?$endereco->numero:''); ?>
		<?php echo form_error('numero', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Complemento</td>
    <td class="last">
    	<?php echo form_input('complemento', isset($endereco->complemento)?$endereco->complemento:''); ?>
    </td>
</tr>
<tr>
	<td class="first">Bairro</td>
    <td class="last">
    	<?php echo form_input('bairro', isset($endereco->bairro)?$endereco->bairro:''); ?>
		<?php echo form_error('bairro', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Cidade</td>
    <td class="last">
    	<?php echo form_input('cidade', isset($endereco->cidade)?$endereco->cidade:''); ?>
		<?php echo form_error('cidade', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Estado</td>
    <td class="last">
    	<?php echo form_dropdown('estado', $estados, $estado); ?>
		<?php echo form_error('estado', '<div class="erro">', '</div>'); ?>
	</td>
</tr>
</table>
</div>
</fieldset>
<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Informa&ccedil;&otilde;es para Contato</th>
</tr>
<tr>
	<td class="first">Email</td>
	<td class="last">
    	<?php echo form_input('email', isset($email->email)?$email->email:''); ?>
		<?php echo form_error('email', '<div class="erro">', '</div>'); ?>
    </td>
</tr>
<tr>
	<td class="first">Telefone</td>
	<td class="last">
    	<?php echo form_input('numtel', isset($telefone->numtel)?$telefone->numtel:''); ?> <?php echo form_dropdown('tp_telefone', $tp_tel, $telefone->tp_telefone); ?>
	</td>
</tr>
</table>
</div>
</fieldset>
<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="3">Informa&ccedil;&otilde;es da Conta</th>
</tr>
<tr>
	<td class="first">Login</td>
    <td class="last">
    	<?php echo form_input('login', isset($login->username)?$login->username:''); ?>
    </td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td class="first">Senha</td>
    <td class="last">
    	<?php echo form_password('senha'); ?>
    </td>
    <td>Se n&atilde;o quiser alterar a senha, deixe este campo em branco</td>
</tr>
<tr>
	<td class="first">Patrocinador</td>
    <td class="last">
		<?php echo form_input('patrocinador', isset($patrocinador->uid)?$patrocinador->uid:''); ?>
    </td>
    <td class="last"><?php echo $patrocinador->nome_completo; ?></td>
</tr>
</table>
</div>
</fieldset>
<fieldset>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Informa&ccedil;&otilde;es Para Recebimento</th>
</tr>
<tr>
	<td class="first">Titular da Conta</td>
    <td class="last"><?php echo form_input('titular', isset($recebimento->titular)?$recebimento->titular:''); ?></td>
</tr>
<tr>
	<td class="first">Banco</td>
    <td class="last"><?php echo form_input('cbanco', isset($recebimento->cbanco)?$recebimento->cbanco:''); ?></td>
</tr>
<tr>
	<td class="first">Tipo de Conta</td>
    <td class="last"><?php echo form_input('tpconta', isset($recebimento->tpconta)?$recebimento->tpconta:''); ?></td>
</tr>
<tr>
	<td class="first">Ag&ecirc;ncia</td>
    <td class="last"><?php echo form_input('agencia', isset($recebimento->agencia)?$recebimento->agencia:''); ?></td>
</tr>
<tr>
	<td class="first">Conta</td>
    <td class="last"><?php echo form_input('conta', isset($recebimento->conta)?$recebimento->conta:''); ?></td>
</tr>
<tr>
	<td class="first">Opera&ccedil;&atilde;o</td>
    <td class="last"><?php echo form_input('op', isset($recebimento->op)?$recebimento->op:''); ?></td>
</tr>
<tr>
	<td><input name="editar" value="Editar" type="submit"></td>
    <td><input name="limpar" value="Limpar Formul&aacute;rio" type="reset"></td>
</tr>
</table>
</div>
</fieldset>
</form>
</div>
</div>
</body>
</html>