<?php
if(!$this->session->flashdata('nome')):
    redirect('principal');
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Cadastro efetuado</title>
    </head>
    <body>
        <p>Seja bem vindo <?php echo $this->session->flashdata('nome'); ?> &agrave; Celular Card Club</p>
        <p>voc&ecirc; receber&aacute; um email contendo seus dados de acesso</p>
        <p>para acessar seu <?php echo anchor('associado', 'escrit&oacute;rio virtual'); ?>, utilize os dados a seguir:</p>
        <p>
            <em>ID (usu&aacute;rio)</em><br />
            <strong><?php echo $this->session->flashdata('id'); ?></strong><br /><br />
            ou<br /><br />
            <em>Email</em><br />
            <strong><?php echo $this->session->flashdata('email'); ?></strong><br /><br />
            e<br /><br />
            <em>Senha</em><br />
            <strong><?php echo $this->session->flashdata('senha'); ?></strong>
        </p>
    </body>
</html>