<?php
	// show user messages sent by controller
	echo output_msg($type = null);
?>

<form method="post" action="<?php echo $action; ?>">
	<div id="container">
            <label>Autor*</label><br>
            <?php echo form_input('autor', $values['autor']); ?>
            <?php echo form_error('autor'); ?><br><br>

            <label>T&iacute;tulo*</label><br>
            <?php echo form_input('titulo', $values['titulo']); ?>
            <?php echo form_error('titulo'); ?><br><br>

            <label>Subt&iacute;tulo*</label><br>
            <?php echo form_input('subtitulo', $values['titulo']); ?>
            <?php echo form_error('subtitulo'); ?><br><br>

            <label>Corpo*</label><br>
            <?php echo form_textarea('corpo', $values['corpo']); ?>
            <?php echo form_error('corpo'); ?><br><br>

            <label>Data*</label><br>
            <?php echo form_input('data', $values['data']); ?>
            <?php echo form_error('data'); ?><br><br>

            <label>Publicado</label><br>
            Sim <?php echo form_radio('publicado', 'S', $values['publicado']=='S'?TRUE:FALSE); ?><br />
            N&atilde;o <?php echo form_radio('publicado', 'N', $values['publicado']=='N'?TRUE:FALSE); ?>
            <?php echo form_error('publicado'); ?><br><br>

            <input type=submit value=" Salvar ">

            <input type=button onclick="location.href='<?php echo site_url('adm/noticias/index/'); ?>';" value="Voltar" class="buttonAdmin" style="margin-left:20px;">
	</div>
	<input type=hidden name=nid value="<?php echo $values['nid']; ?>">
</form>
</body>
</html>
