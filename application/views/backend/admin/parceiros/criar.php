<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Parceiros</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<form id="cria-parceiro" name="cria-parceiro" method="post" action="<?php echo site_url("adm/parceiros/criar") ?>">
<table>
    <tr>
      <td>Nome</td>
      <td><?php echo form_input(array('name'=>'nome', 'id'=>'nome', 'size'=>50), set_value('nome')); ?></td>
      <td><?php echo form_error("nome"); ?></td>
    </tr>
</table>
<?php echo form_hidden(array('name'=>'pid'), set_value('pid')); ?>
<button id="criar-parceiro" class="ui-button ui-state-default ui-corner-all">Adicionar Parceiro</button>
</form>
</body>
</html>