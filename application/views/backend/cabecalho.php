<!DOCTYPE html>
<html lang="pt_BR">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->config->item('nome_site'); ?> - Administração :: <?php echo $titulo;?></title>
	
    <?php
    $assets_crud = $this->config->item('assets_crud');
    $tema = array('css' => $assets_crud."themes/escritorio-virtual/css-flex/",
                  'js'  => $assets_crud."themes/escritorio-virtual/js-flex/",
                  'icons'  => $assets_crud."themes/escritorio-virtual/icons-flex/");
	?>
    <!-- Cria o efeito de carregamento no topo da página -->
    <link href="<?php echo $tema['css']; ?>plugins/pace/pace.css" rel="stylesheet">
    <script src="<?php echo $tema['js']; ?>plugins/pace/pace.js"></script>

    <!-- ESTILOS GLOBAIS -->
    <link href="<?php echo $tema['css']; ?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="<?php echo $tema['icons']; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- PAGE LEVEL PLUGIN STYLES -->

    <!-- ESTILOS DO TEMA. -->
    <link href="<?php echo $tema['css']; ?>style.css" rel="stylesheet">
    <link href="<?php echo $tema['css']; ?>plugins.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="<?php echo $tema['js']; ?>html5shiv.js"></script>
      <script src="<?php echo $tema['js']; ?>respond.min.js"></script>
    <![endif]-->
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
