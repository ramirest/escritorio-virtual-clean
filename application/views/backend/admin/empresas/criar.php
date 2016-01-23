<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de empresas parceiras</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<?php echo form_open('escritorio-virtual/empresas/criar', array('id'=>'cria-empresa','name'=>'cria-empresa')); ?>
<?php echo form_fieldset('Informações da empresa'); ?>
<table>
    <?php
	$itens_form = $this->config->item('itens_form');
	$itens_form_opt = $itens_form['empresa_type_options'];
	$itens_form_opt_tel = $itens_form['empresa_tel_type_options'];
	$t = 0;
	foreach($itens_form['empresa'] as $k=>$v):
	?>
    <tr>
      <td><?php echo $v; ?></td>
      <td>
	  <?php
	  //verifica os tipos de campos a serem utilizados no formulário
	  if(array_key_exists($t, $itens_form['empresa_types']) && 
	  	$itens_form['empresa_types'][$t] == 'dropdown'):
		echo form_dropdown($k, $itens_form_opt[$k], $itens_form_opt['default']);
	  else:		
	  	echo form_input(array('name'=>$k, 'id'=>$k, 'size'=>50), set_value($k));
	  endif;
	  ?>
      </td>
      <td><?php echo form_error($k); ?></td>
    </tr>
    <?php 
	$t++;
	endforeach;
	?>
</table>
<?php echo form_fieldset_close(); ?>
<?php echo form_fieldset('Endereço'); ?>
<table>
    <?php
	$itens_form = $this->config->item('itens_form');
	$t = 0;
	foreach($itens_form['empresa_endereco'] as $k=>$v):
	?>
    <tr>
      <td><?php echo $v; ?></td>
      <td>
	  <?php
		echo form_input(array('name'=>$k, 'id'=>$k, 'size'=>50), set_value($k));
	  ?>
      </td>
      <td><?php echo form_error($k); ?></td>
    </tr>
    <?php 
	$t++;
	endforeach;
	?>
</table>
<?php echo form_fieldset_close(); ?>
<?php echo form_fieldset('Telefone'); ?>
<table>
    <?php
	$itens_form = $this->config->item('itens_form');
	$t = 0;
	foreach($itens_form['empresa_telefone'] as $k=>$v):
	?>
    <tr>
      <td><?php echo $v; ?></td>
      <td>
	  <?php
	  //verifica os tipos de campos a serem utilizados no formulário
	  if(array_key_exists($t, $itens_form['empresa_tel_types']) && 
	  	$itens_form['empresa_tel_types'][$t] == 'dropdown'):
		echo form_dropdown($k, $itens_form_opt_tel[$k], $itens_form_opt_tel['default']);
	  else:		
	  	echo form_input(array('name'=>$k, 'id'=>$k, 'size'=>50), set_value($k));
	  endif;
	  ?>
      </td>
      <td><?php echo form_error($k); ?></td>
    </tr>
    <?php 
	$t++;
	endforeach;
	?>
</table>
<?php echo form_fieldset_close(); ?>
<?php echo form_hidden(array('name'=>'eid'), set_value('eid')); ?>
<button id="criar-empresa" class="ui-button ui-state-default ui-corner-all">Adicionar Empresa</button>
</form>
</body>
</html>