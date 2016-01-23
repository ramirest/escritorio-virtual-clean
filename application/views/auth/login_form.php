<?php
$username = array(
    'name'	=> 'username',
    'id'	=> 'username',
    'size'	=> 30,
    'class' => 'form-control form-login',
    'style' => 'text-transform: lowercase;',
    'placeholder' => 'Usuário',
    'value' => set_value('username')
);

$password = array(
    'name'	=> 'password',
    'id'	=> 'password',
    'class' => 'form-control form-login',
    'placeholder' => 'Senha',
    'size'	=> 30
);

$remember = array(
    'name'	=> 'remember',
    'id'	=> 'remember',
    'value'	=> 1,
    'checked'	=> set_value('remember')
);

$submit = array(
    'name' => 'enviar',
    'id' => 'enviar',
    'type' => 'submit',
    'class'=>'btn btn-lg btn-azul-claro btn-block',
    'content' => 'Entrar'
);

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sicove</title>

    <!-- GLOBAL STYLES -->
    <link href="<?php echo $this->config->item('assets');?>login/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="<?php echo $this->config->item('assets');?>login/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- PAGE LEVEL PLUGIN STYLES -->

    <!-- THEME STYLES -->
    <link href="<?php echo $this->config->item('assets');?>login/css/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="<?php echo $this->config->item('assets');?>login/js/html5shiv.js"></script>
    <script src="<?php echo $this->config->item('assets');?>login/js/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login">


<div class="row">
    <div class="col-md-12 portlet-azul-escuro login-tamanho1">


        <div class="col-md-5">
            <div class="portlet-title  img-resp-login22" style="text-align: center">
                <img class="img-responsive img-resp-login2" src="<?php echo $this->config->item('assets');?>login/img/logo.png">

            </div>
        </div>


        <div class="col-md-7">
            <div class="row">
                <?php echo $this->dx_auth->get_auth_error()?$this->config->item('err_msg_style').$this->dx_auth->get_auth_error().$this->config->item('msg_style_end'):''; ?>

                <?php if($this->session->flashdata('msg')): ?>
                    <p class="alert alert-info"><?php echo $this->session->flashdata('msg'); ?></p>
                <?php endif; ?>
                <?php if($this->session->flashdata('nova_senha')): ?>
                    <p class="alert alert-info"><?php echo $this->session->flashdata('nova_senha'); ?></p>
                <?php endif; ?>
                <?php echo form_error($username['name'], $this->config->item('err_msg_style'), $this->config->item('msg_style_end')); ?>
            </div>
            <div class="row">

                <?php echo form_open($this->uri->uri_string(), array('accept-charset'=>'UTF-8', 'role'=>'form', 'id'=>'login-form')); ?>

                <?php if(isset($_REQUEST['redirect'])): ?>
                    <input type="hidden" name="redirect" id="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect']); ?>">
                <?php endif; ?>


                <div class="col-sm-12 marg_resp">

                    <div  class = "col-sm-4">
                        <div class="form-group form-login12">
                            <?php echo form_input($username); ?>
                        </div>
                        <div class="checkbox checkbox01">
                            <label>
                                <?php echo form_checkbox($remember);?> Mantenha-me conectado
                            </label>
                        </div>
                    </div>

                    <div  class = "col-sm-4">
                        <div class="form-group form-login12">
                            <?php echo form_password($password); ?>
                        </div>
                        <div class="esqueceu-senha">
                            <?php echo anchor_popup('recuperar_senha', 'Esqueceu a senha?'); ?>
                        </div>
                    </div>

                    <div  class = "col-sm-4">
                        <div class="row">
                            <div  class = "col-sm-6 pd-in">
                                <?php echo form_button($submit); ?>
                            </div>
                            <div  class = "col-sm-6 pd-in">
                                <?php echo anchor('escritorio-virtual/empresarios/cadastro', 'Novo Empresário', array('class'=>'btn btn-lg btn-azul-escuro btn-block')); ?>
                            </div>
                        </div>
                    </div>

                </div>

                <?php echo form_close()?>
            </div>
        </div>
    </div>

</div>
</div>


<div class="container">
    <div class="row">
        <div class="col-lg-12"  style="text-align: center; padding: 0">


        </div>
    </div>
</div>




<!-- GLOBAL SCRIPTS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo $this->config->item('assets');?>login/js/plugins/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('assets');?>login/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- HISRC Retina Images -->
<script src="<?php echo $this->config->item('assets');?>login/js/plugins/hisrc/hisrc.js"></script>

<!-- PAGE LEVEL PLUGIN SCRIPTS -->

<!-- THEME SCRIPTS -->
<!--<script src="<?php echo $this->config->item('assets');?>login/js/flex.js"></script>-->

</body>

</html>
