<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="formulario" name="form1" method="post" action="<?php echo site_url("escritorio-virtual/produtos/editar_categoria/". $cat->cid); ?>">
<?php echo form_hidden("cid", $cat->cid); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Nome</td>
    <td><?php echo form_input(array("name"=>"nome", "id"=>"nome2"), isset($cat->nome)?$cat->nome:''); ?></td>
  </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o</td>
    <td><?php echo form_textarea(array("name"=>"descricao", "id"=>"descricao2", "cols"=>16,"rows"=>3), isset($cat->descricao)?$cat->descricao:''); ?></td>
  </tr>
<?php if(isset($categorias)): ?>
  <tr>
    <td>Categoria</td>
    <td><?php echo form_dropdown("cpid", $categorias, isset($categoria)?$categoria:0, 'id="cpid"'); ?></td>
  </tr>
<?php endif; ?>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 1</td>
    <td><?php echo form_input(array("name"=>"cn1", "id"=>"cn1"), isset($cat->cn1)?$cat->cn1:''); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 2</td>
    <td><?php echo form_input(array("name"=>"cn2", "id"=>"cn2"), isset($cat->cn2)?$cat->cn2:''); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 3</td>
    <td><?php echo form_input(array("name"=>"cn3", "id"=>"cn3"), isset($cat->cn3)?$cat->cn3:''); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 4</td>
    <td><?php echo form_input(array("name"=>"cn4", "id"=>"cn4"), isset($cat->cn4)?$cat->cn4:''); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 5</td>
    <td><?php echo form_input(array("name"=>"cn5", "id"=>"cn5"), isset($cat->cn5)?$cat->cn5:''); ?></td>
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