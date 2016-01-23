<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../../../assets/css/blitzer/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="../../../assets/css/principal.css" rel="stylesheet" />
<script src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("jquery", "1");
    google.load("jqueryui", "1");
    google.load("visualization", "1", {packages:['table']});
</script>
<script type="text/javascript" src="../../../assets/js/produtos.js"></script>
<script type="text/javascript">
    var visualization;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Código');
    data.addColumn('string', 'Produto');
    data.addColumn('string', 'Categoria');
    data.addColumn('string', 'Descrição');
    <?php if(isset($produtos)): ?>
        <?php foreach($produtos->result() as $v): ?>
            data.addRow(['<?php echo $v->pid; ?>','<?php echo $v->produto; ?>','<?php echo $v->categoria; ?>','<?php echo $v->descricao; ?>']);
        <?php endforeach; ?>
    <?php endif; ?>

    // Note: This sample shows the select event.
    // The select event is a generic select event,
    // for selecting rows, columns, and cells.
    // However, in this example, only rows are selected.
    // Read more here: http://code.google.com/apis/visualization/documentation/gallery/table.html#Events

    function drawVisualization() {
      visualization = new google.visualization.Table(document.getElementById('lista-produto'));
      visualization.draw(data, null);

      // Add our selection handler.
      //$(function(){visualization}).click(selectHandler);
      google.visualization.events.addListener(visualization, 'select', selectHandler);
    }

    // The selection handler.
    // Loop through all items in the selection and concatenate
    // a single message from all of them.
    function selectHandler() {
      var selection = visualization.getSelection();
      var message = '';
      for (var i = 0; i < selection.length; i++) {
        var item = selection[i];
        var str = data.getFormattedValue(item.row, 0);
      }
      $("#dlg-edita-produto").text($("#dlg-edita-produto").load("carregar_produto/"+str));
      $("#dlg-edita-produto").dialog('open');
    }



    google.setOnLoadCallback(drawVisualization);
</script>
<?php
//		echo "<tr>".
//				"<td><span id='". $v->pid ."' class='ui-icon ui-icon-pencil' /></td>".
//				"<td><span id='". $v->pid ."' class='ui-icon ui-icon-trash' /></td>".
//			 "</tr>";
?>
<title>Untitled Document</title>

</head>

<body>
<div id="dlg-exclui-produto">Tem certeza de que deseja excluir este produto?</div>
<div id="dlg-edita-produto"></div>
<div id="dlg-cadastro-produto">
<p id="validateTips"></p>
<form id="produto" name="produto" method="post" action="<?php echo site_url("adm/produtos/inserir_produto"); ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php if(isset($categorias)): ?>
  <tr>
    <td>Categoria</td>
    <td><?php echo form_dropdown("cid", $categorias, '', 'id="cid"'); ?></td>
  </tr>
<?php endif; ?>
  <tr>
    <td>Nome</td>
    <td><?php echo form_input(array("name"=>"nome", "id"=>"nome")); ?></td>
  </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o</td>
    <td><?php echo form_textarea(array("name"=>"descricao", "id"=>"descricao", "cols"=>16,"rows"=>3)); ?></td>
  </tr>
  <tr>
    <td>Valor</td>
    <td><?php echo form_input(array("name"=>"valor", "id"=>"valor")); ?></td>
  </tr>
  <tr>
    <td>Desconto Promocional</td>
    <td><?php echo form_input(array("name"=>"desconto_promo", "id"=>"desconto_promo")); ?>%</td>
  </tr>
  <tr>
    <td>Peso</td>
    <td><?php echo form_input(array("name"=>"peso", "id"=>"peso")); ?></td>
  </tr>
  <tr>
    <td>Quantidade em Estoque</td>
    <td><?php echo form_input(array("name"=>"qtde_estoque", "id"=>"qtde_estoque")); ?></td>
  </tr>
</table>
</form>
</div>
<div id="lista-produto">
</div>
<button id="cadastrar-produto" class="ui-button ui-state-default ui-corner-all">Cadastrar Produto</button>
</body>
</html>
</body>
</html>