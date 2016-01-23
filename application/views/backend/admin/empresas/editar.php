<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Parceiros</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<?php echo form_open("escritorio-virtual/empresas/editar/".$empresa->eid, array('id'=>'edita-empresa','name'=>'edita-empresa')); ?>
<table class="listing form">
    <tr>
      <td>Nome</td>
      <td><?php echo form_input(array('name'=>'razao_social', 'id'=>'razao_social', 'size'=>83), set_value('razao_social', $empresa->razao_social)); ?></td>
    </tr>
</table>
<button id="editar-parceiro" class="ui-button ui-state-default ui-corner-all">Editar Empresa</button>
</form>
</body>
</html>