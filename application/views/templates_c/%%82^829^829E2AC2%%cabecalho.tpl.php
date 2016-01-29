<?php /* Smarty version 2.6.25-dev, created on 2016-01-28 15:54:47
         compiled from cabecalho.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ci_config', 'cabecalho.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_ci_config(array('name' => 'assets'), $this);?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>

    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/neon-core.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/custom.css">
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['assets']; ?>
css/skins/yellow.css">

    <script src="<?php echo $this->_tpl_vars['assets']; ?>
js/jquery-1.11.0.min.js"></script>

    <!--[if lt IE 9]><script src="<?php echo $this->_tpl_vars['assets']; ?>
js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body skin-yellow">