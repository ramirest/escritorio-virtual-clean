<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php echo form_open('escritorio-virtual/produtos/editar_produto/'.$produto->pid,array('name'=>'form1','id'=>'formulario')); ?>
<?php echo form_hidden("pid", $produto->pid); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($categorias)): ?>
  <tr>
    <td>Categoria</td>
    <td><?php echo form_dropdown("cid", $categorias, isset($categoria)?$categoria:0, 'id="cid"'); ?></td>
  </tr>
<?php endif; ?>
  <tr>
    <td>Nome</td>
    <td><?php echo form_input(array("name"=>"nome", "id"=>"nome2"), isset($produto->produto)?$produto->produto:''); ?></td>
  </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o</td>
    <td><?php echo form_textarea(array("name"=>"descricao", "id"=>"descricao2", "cols"=>16,"rows"=>3), isset($produto->descricao)?$produto->descricao:''); ?></td>
  </tr>
  <tr>
    <td>Valor</td>
    <td><?php echo form_input(array("name"=>"valor", "id"=>"valor"), isset($produto->valor)?$produto->valor:''); ?></td>
  </tr>
  <tr>
    <td>Desconto Promocional</td>
    <td><?php echo form_input(array("name"=>"desconto_promo", "id"=>"desconto_promo"), isset($produto->desconto_promo)?$produto->desconto_promo:''); ?>%</td>
  </tr>
  <tr>
    <td>Peso</td>
    <td><?php echo form_input(array("name"=>"peso", "id"=>"peso"), isset($produto->peso)?$produto->peso:''); ?></td>
  </tr>
  <tr>
    <td>Quantidade em estoque</td>
    <td><?php echo form_input(array("name"=>"qtde_estoque", "id"=>"qtde_estoque"), isset($produto->qtde_estoque)?$produto->qtde_estoque:''); ?></td>
  </tr>
  <tr>
    <td>
    	<input type="submit" name="editar" value="Editar" class="ui-button ui-state-default ui-corner-all" />
    </td>
  </tr>
</table>
</form>
</body>
</html>