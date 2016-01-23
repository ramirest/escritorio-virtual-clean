<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->config->item('nome_site'); ?> - Administração :: <?php echo $titulo;?></title>
	
    <?php
    $tema = $this->config->item('tema');
	?>

    <?php
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>

    <?php
	if(isset($page_plugin)):
		$plugins = $this->config->item('plugins');
		foreach($plugins['css'][$page_plugin] as $plugin):
			echo $plugin;
		endforeach;
	endif;
    	
	if(isset($page_style)):
		$styles = $this->config->item('styles');
		foreach($styles[$page_style] as $style):
			echo $style;
		endforeach;
	endif;
	
	if(isset($page_js)):
		$scripts = $this->config->item('scripts');
		foreach($scripts[$page_js] as $script):
			echo $script;
		endforeach;
	endif;
	?>

</head>
