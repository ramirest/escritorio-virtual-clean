<form action="<?php echo site_url("auth/login"); ?>" method="post">
<div style="color:#ff0000"><?php echo $this->dx_auth->get_auth_error(); ?></div>
<div class="table">
<img src="img/bg-th-left.gif" width="8" height="7" alt="" class="left" />
<img src="img/bg-th-right.gif" width="7" height="7" alt="" class="right" />
<table class="listing form">
<tr>
    <th class="full" colspan="2">Login de Usu&aacute;rio</th>
</tr>
<tr>
    <td class="first">Nome de Usu&aacute;rio:</td>
    <td class="last">
      <?php echo form_input('username'); ?>
      <?php echo form_error('username'); ?>
    </td>
</tr>
<tr>
    <td class="first">Senha:</td>
    <td class="last">
      <?php echo form_password('password'); ?>
      <?php echo form_error('password'); ?>
    </td>
</tr>
<tr>
    <th class="full" colspan="2"><?php echo form_submit('enviar', 'Enviar'); ?></th>
</tr>
</table>
</div>
</form>