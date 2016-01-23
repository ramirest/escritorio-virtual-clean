<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Faturas</title>
<script>
    $(function(){
        $("#uid").change(function(){
            $.ajax({
                type:"POST",
                data:"usuario="+$(this).val(),
                url:"<?php echo site_url("callback/patrocinador_check"); ?>",
                success:function(msg){
                    $("#response_usuario").html(msg);
                    if($("#response_usuario div").hasClass("ui-state-error")){
                        $("#uid").val("");
                    }
                }
            })
        });
        $("#vencimento").mask("99/99/9999", {placeholder: " "});
    })
</script>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<form id="cria-fatura" name="cria-fatura" method="post" action="<?php echo site_url("escritorio-virtual/faturas/criar") ?>">
<table>
    <tr>
      <td>Usu&aacute;rio</td>
      <td>
        <?php echo form_input(array('name'=>'uid', 'id'=>'uid', 'size'=>'50px'), set_value('uid')); ?>
          <div id="response_usuario"></div>
      </td>
    </tr>
    <tr>
      <td>Vencimento</td>
      <td><?php echo form_input(array('name'=>'vencimento', 'id'=>'vencimento'), set_value('vencimento')); ?></td>
    </tr>
    <tr>
      <td>Valor</td>
      <td><?php echo form_input(array('name'=>'valor', 'id'=>'valor'), set_value('valor')); ?></td>
    </tr>
    <tr>
      <td>Referente a</td>
      <?php
      $descricoes = array('Taxa de Adesão'=>'Taxa de Adesão',
                          'Taxa de Manutenção e Recarga'=>'Taxa de Manutenção e Recarga');
      ?>
      <td><?php echo form_dropdown('descricao', $descricoes); ?></td>
    </tr>
</table>
<button id="criar-fatura" class="ui-button ui-state-default ui-corner-all">Criar Fatura</button>
</form>
</body>
</html>