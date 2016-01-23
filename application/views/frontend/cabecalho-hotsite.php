<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="image_src" href="<?php echo $this->config->item('misc_f');?>images/logo.png" />
    <title><?php echo $this->config->item('nome_site'); ?> - <?php echo $titulo;?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->config->item('css_f');?>bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="<?php echo $this->config->item('css_f');?>css.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('css_f');?>css_efeito_adesao.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('css_f');?>marketing-b9c402b45c5e90d3a3082550545c5cfb.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('misc_f');?>css/menudrop.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('misc_f');?>css/font/stylesheet.css" rel="stylesheet">
    <?php if(isset($tabs)): ?>
    <link href="<?php echo $this->config->item('misc_f');?>jQueryAssets/jquery.ui.core.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('misc_f');?>jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('misc_f');?>jQueryAssets/jquery.ui.tabs.min.css" rel="stylesheet">
	<style>
        .ui-tabs-vertical { width: 65em; }
        .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
        .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
        .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
        .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
        .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
    </style>
    <?php endif; ?>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
