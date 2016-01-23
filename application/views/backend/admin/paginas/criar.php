<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>/wysiwyg/styles/wysiwyg.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>wysiwyg/scripts/wysiwyg-settings.js"></script>

<script type="text/javascript">
    var configs = new WYSIWYG.Settings();
    configs.ImagesDir = '<?php echo base_url().$this->config->item('mmn_misc'); ?>wysiwyg/images/';
    configs.PopupsDir = '<?php echo base_url().$this->config->item('mmn_misc'); ?>wysiwyg/popups/';
    WYSIWYG.attach('all', configs);
</script>
<title>Gerenciamento de P&aacute;ginas</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<form id="cria-pagina" name="cria-pagina" method="post" action="<?php echo site_url("adm/paginas/criar") ?>">
<table>
    <tr>
      <td>T&iacute;tulo</td>
      <td><?php echo form_input(array('name'=>'titulo', 'id'=>'titulo', 'size'=>83), set_value('titulo')); ?></td>
    </tr>
    <tr>
      <td>Corpo</td>
      <td><?php echo form_textarea(array('name'=>'corpo', 'id'=>'corpo', "cols"=>80,"rows"=>10), set_value('corpo')); ?></td>
    </tr>
</table>
<button id="criar-pagina" class="ui-button ui-state-default ui-corner-all">Criar P&aacute;gina</button>
</form>
</body>
</html>