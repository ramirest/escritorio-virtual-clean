<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../../assets/js/categorias.js"></script>
<title>Untitled Document</title>

</head>

<body>
<dir id="dlg-exclui-categoria">Tem certeza de que deseja excluir esta categoria?</dir>
<div id="dlg-edita-categoria"></div>
<div id="dlg-cadastro-categoria">
<p id="validateTips"></p>
<?php echo form_open('escritorio-virtual/produtos/inserir_categoria', array('id'=>'categoria','name'=>'categoria')); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Nome</td>
    <td><?php echo form_input(array("name"=>"nome", "id"=>"nome")); ?></td>
  </tr>
  <tr>
    <td>Descri&ccedil;&atilde;o</td>
    <td><?php echo form_textarea(array("name"=>"descricao", "id"=>"descricao", "cols"=>16,"rows"=>3)); ?></td>
  </tr>
<?php if(isset($listcategorias)): ?>
  <tr>
    <td>Categoria</td>
    <td><?php echo form_dropdown("cpid", $listcategorias, '', 'id="cpid"'); ?></td>
  </tr>
<?php endif; ?>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 1</td>
    <td><?php echo form_input(array("name"=>"cn1", "id"=>"cn1")); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 2</td>
    <td><?php echo form_input(array("name"=>"cn2", "id"=>"cn2")); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 3</td>
    <td><?php echo form_input(array("name"=>"cn3", "id"=>"cn3")); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 4</td>
    <td><?php echo form_input(array("name"=>"cn4", "id"=>"cn4")); ?></td>
  </tr>
  <tr>
    <td>Comiss&atilde;o n&iacute;vel 5</td>
    <td><?php echo form_input(array("name"=>"cn5", "id"=>"cn5")); ?></td>
  </tr>
</table>
</form>
</div>
<div id="categoria">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th>Categoria</th>
    <th>Descri&ccedil;&atilde;o</th>
    <th>A&ccedil;&atilde;o</th>
  </tr>
</thead>
<tbody>
<?php 

if(isset($categorias)):
	foreach($categorias->result() as $v):
		echo "<tr id='". $v->cid ."'>".
			 	"<td>" . $v->nome . "</td>".
			 	"<td>" . $v->descricao . "</td>".
				"<td><span id='".$v->cid."' class='ui-icon ui-icon-pencil' /></td>".
                "<td><span id='".$v->cid."' class='ui-icon ui-icon-trash' /></td>".
			 "</tr>";
	endforeach;
else:
	echo "Nenhuma categoria cadastrada";
endif;

?>
<script>
    $("tbody tr td span[class=ui-icon ui-icon-pencil]").click(function(){
        $("#dlg-edita-categoria").text($("#dlg-edita-categoria").load("produtos/carregar_categoria/"+$(this).attr("id")));
        $("#dlg-edita-categoria").dialog('open');
    })
        .hover(
            function(){
                $(this).css("cursor", "pointer");
            },
            function(){
                $(this).css("cursor", "default")
            })
    $("tbody tr td span[class=ui-icon ui-icon-trash]").click(function(){
        $("#dlg-exclui-categoria").attr("title", $.excluir($(this).attr("id")));
        $("#dlg-exclui-categoria").dialog('open');
    })
        .hover(
            function(){
                $(this).css("cursor", "pointer");
            },
            function(){
                $(this).css("cursor", "default")
            })
</script>
</tbody>
</table>
</div>
<button id="criar-categoria" class="ui-button ui-state-default ui-corner-all">Criar Categoria</button>
</body>
</html>