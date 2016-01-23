<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Parceiros</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<form id="edita-parceiro" name="edita-parceiro" method="post" action="<?php echo site_url("escritorio-virtual/parceiros/editar/".$pa->pid) ?>">
<table class="listing form">
    <tr>
      <td>Nome</td>
      <td><?php echo form_input(array('name'=>'nome', 'id'=>'nome', 'size'=>83), set_value('nome', $pa->nome)); ?></td>
    </tr>
</table>
<button id="editar-parceiro" class="ui-button ui-state-default ui-corner-all">Editar Parceiro</button>
</form>
</body>
</html>