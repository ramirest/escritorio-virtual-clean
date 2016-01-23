<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Faturas</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<form id="edita-fatura" name="edita-fatura" method="post" action="<?php echo site_url("escritorio-virtual/faturas/editar/".$fatura->fid) ?>">
<?php echo form_hidden('uid', $fatura->uid); ?>
<table>
    <tr>
      <td>Usu&aacute;rio</td>
      <td><?php echo $fatura->uid; ?></td>
    </tr>
    <tr>
      <td>Vencimento</td>
      <td>
      <?php
          if(isset($fatura->vencimento)):
              $data = $this->data->mysql_to_human($fatura->vencimento);
          else:
              $data = '';
          endif;
          echo form_input('vencimento', $data);
        ?>
      </td>
    </tr>
    <tr>
      <td>Valor</td>
      <td><?php echo form_input(array('name'=>'valor', 'id'=>'valor'), set_value('valor', $fatura->valor)); ?></td>
    </tr>
    <tr>
      <td>Referente a</td>
      <td>
          <strong><?php echo $fatura->descricao; ?></strong>
          <?php echo form_hidden('descricao', $fatura->descricao); ?>
      </td>
    </tr>
    <tr>
      <td>Situa&ccedil;&atilde;o</td>
      <td>
      <?php
        $situacao = array('Em Aberto'=>'Em Aberto', 'Quitada'=>'Quitada', 'Cancelada'=>'Cancelada');
        $attr = 'id="situacao"';
        echo form_dropdown('situacao', $situacao, $fatura->situacao, $attr);
      ?>
      <script type="text/javascript">
          $(function(){
              $("#situacao").change(function(){
                  if($(this).val() == "Quitada"){
                      $("#gerar_comissao").show();
                  }else{
                      $("#gerar_comissao").hide();
                  }
              })
          })
      </script>
      </td>
    </tr>
    <tr id="gerar_comissao" style="display:none;">
      <td>Gerar Comiss&otilde;es?</td>
      <td>
      <?php
        $gerar = array('S'=>'Sim', 'N'=>'Não');
        echo form_dropdown('gerar_comissao', $gerar, "N");
      ?>
      </td>
    </tr>
</table>
<button id="editar-fatura" class="ui-button ui-state-default ui-corner-all">Editar Fatura</button>
</form>
</body>
</html>