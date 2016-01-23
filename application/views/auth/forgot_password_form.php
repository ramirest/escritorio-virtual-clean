<?php

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'maxlength'	=> 80,
	'size'	=> 30,
    'class'=>'form-control',
    'placeholder'=>'Digite seu nome de usuário ou email',
	'value' => set_value('login')
);

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login de usuários SICOVE!</title>

    <!-- GLOBAL STYLES -->
    <link href="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/css-flex/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/icons-flex/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- PAGE LEVEL PLUGIN STYLES -->

    <!-- THEME STYLES -->
    <link href="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/css-flex/style.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/css-flex/plugins.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/html5shiv.js"></script>
    <script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login special-page">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 tody" style="margin-top: 83px;">

            <div class="portlet portlet-green">

                <div class="portlet-body">

                    <fieldset>

                        <h4><strong style="color: #34495e;">Esqueci a Senha</strong></h4>
                        <?php echo form_open($this->uri->uri_string()); ?>

                        <?php echo $this->dx_auth->get_auth_error(); ?>

                        <div class="form-group">
                            <?php echo form_input($login); ?>
                            <?php echo form_error($login['name']); ?>
                        </div>
                        <?php echo form_submit('reset', 'Recuperar senha', 'class="btn btn-lg btn-green btn-block"'); ?>

                        <?php echo form_close()?>

                    </fieldset>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- GLOBAL SCRIPTS -->
<script src="<?php echo $this->config->item('assets_crud');?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/plugins/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- HISRC Retina Images -->
<script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/plugins/hisrc/hisrc.js"></script>

<!-- PAGE LEVEL PLUGIN SCRIPTS -->

<!-- THEME SCRIPTS -->
<script src="<?php echo $this->config->item('assets_crud');?>themes/escritorio-virtual/js-flex/flex.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-51536975-2', 'sicove.com.br');
    ga('send', 'pageview');

</script>

</body>

</html>