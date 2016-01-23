<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/themes/blue/style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_css');?>jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#excluir-fatura").dialog({
        bgiframe:true,
        resizable:false,
        height:140,
        modal:true,
        autoOpen:false,
        buttons:{
            Cancelar:function(){
                $(this).dialog('close');
            },
            'Excluir Fatura':function(){
                $("body").load($(this).attr("registro"));
            }
        }
    });
    $("#tabela-faturas").tablesorter({widgets:['zebra']});
    $(".ui-icon-trash").click(function(){
        $("#excluir-fatura").attr("registro", $(this).attr("id"));
        $("#excluir-fatura").dialog('open');
    })
});
</script>
<title>Gerenciamento de Faturas</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<div id="excluir-fatura" class="ui-widget-content"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0"></span>Tem certeza de que deseja excluir esta fatura?</div>
<table id="tabela-faturas" class="tablesorter">
<thead>
  <tr>
    <th>N&uacute;mero da fatura</th>
    <th>ID</th>
    <th>Valor</th>
    <th>Situa&ccedil;&atilde;o</th>
  </tr>
</thead>
<tbody>
<?php
if(isset($faturas)):
    foreach($faturas->result() as $v):
        $lista = "<tr id='$v->fid'>".
                 "<td>". $v->fid . "</td>".
                 "<td>". $v->uid . "</td>".
                 "<td>". $v->valor . "</td>".
                 "<td>". $v->situacao . "</td>";
        if($v->situacao != "Quitada"):
          $lista = $lista . "<td><a href='faturas/editar/". $v->fid ."' class='ui-icon ui-icon-pencil'></td>".
                            "<td><a href='#' id='faturas/excluir/". $v->fid ."' class='ui-icon ui-icon-trash'></td>";
        endif;
        $lista = $lista . "</tr>";
        echo $lista;
    endforeach;
endif;
echo "<a href='".site_url("escritorio-virtual/faturas/criar")."' class='ui-icon ui-icon-document' title='Criar Fatura'>Criar Fatura</a></td>";
?>
</tbody>
</table>
</body>
</html>