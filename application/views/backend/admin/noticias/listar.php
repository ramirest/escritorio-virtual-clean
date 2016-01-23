<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Not&iacute;cias</title>
	<script>
		function remove(id) {
			if (confirm("Tem certeza?")) {
				window.location = '<?php echo site_url('adm/noticias/delete'); ?>/'+id;
			}
		}
	</script>
</head>

<body>

<?php
	// show user messages sent by controller
	echo output_msg($type = null);
?>

<div id="container">
    <h1>NOT&Iacute;CIAS</h1>
	<table id="listing" cellspacing=0>
		<tr>
                    <th width=45%>T&iacute;tulo</th>
                    <th width=45%>Autor</th>
                    <th width=10%>A&ccedil;&otilde;es</th>
		</tr>
		<?php foreach($lista as $noticia): ?>
			<tr>
                            <td><?php echo $noticia->titulo; ?></td>
                            <td><?php echo $noticia->autor; ?></td>
                            <td align="center">
                                    <a href="<?php echo site_url("adm/noticias/prepareUpdate/$noticia->nid"); ?>">editar</a>
                                    <a href="#" onclick="remove(<?php echo $noticia->nid; ?>);">excluir</a>
                            </td>
			</tr>
		<?php endforeach ?>
	</table>
	<div style="padding:10px;"><?php echo $pagination; ?><br clear="all" /></div>
	<input type=button onclick="location.href='<?php echo site_url('adm/noticias/prepareInsert/'); ?>';" value="Nova notícia" class="buttonAdmin">
</div>

</body>
</html>