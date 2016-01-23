<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Fale Conosco</title>
    </head>
    <body>
        <form id="faleconosco" name="faleconosco" method="post" action="<?php echo site_url("faleconosco"); ?>">
        <table>
            <tr>
              <td>Nome</td>
              <td>
                <?php echo form_input(array('name'=>'nome', 'id'=>'nome', 'size'=>83), set_value('nome', isset($values)?$values['nome']:'')); ?>
                <?php echo form_error('nome'); ?>
              </td>
            </tr>
            <tr>
              <td>Email</td>
              <td>
                <?php echo form_input(array('name'=>'email', 'id'=>'email', 'size'=>83), set_value('email', isset($values)?$values['email']:'')); ?>
                <?php echo form_error('email'); ?>
              </td>
            </tr>
            <tr>
              <td>Assunto</td>
              <td>
                <?php echo form_input(array('name'=>'assunto', 'id'=>'assunto', 'size'=>83), set_value('assunto', isset($values)?$values['assunto']:'')); ?>
                <?php echo form_error('assunto'); ?>
              </td>
            </tr>
            <tr>
              <td>Mensagem</td>
              <td>
                <?php echo form_textarea(array('name'=>'mensagem', 'id'=>'mensagem', "cols"=>64,"rows"=>10), set_value('mensagem', isset($values)?$values['mensagem']:'')); ?>
                <?php echo form_error('mensagem'); ?>
              </td>
            </tr>
        </table>
        <button id="enviar" class="ui-button ui-state-default ui-corner-all">Enviar</button>
        </form>
    </body>
</html>
