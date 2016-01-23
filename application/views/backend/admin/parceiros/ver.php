<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/themes/blue/style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_css');?>jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#excluir-plano").dialog({
        bgiframe:true,
        resizable:false,
        height:140,
        modal:true,
        autoOpen:false,
        buttons:{
            Cancelar:function(){
                $(this).dialog('close');
            },
            'Excluir plano':function(){
                $("body").load($(this).attr("registro"));
            }
        }
    });
    $("#tabela-planos").tablesorter({widgets:['zebra']});
    $("#tabela-planos .ui-icon-trash").click(function(){
        $("#excluir-plano").attr("registro", $(this).attr("id"));
        $("#excluir-plano").dialog('open');
    })
});
</script>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<div id="excluir-plano" class="ui-widget-content"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0"></span>Tem certeza de que deseja excluir este plano?</div>
<table id="tabela-planos">
<thead>
  <tr>
    <th>Plano</th>
  </tr>
</thead>
<tbody>
<?php
if(isset($planos) && ($planos !== false)):
    foreach($planos->result() as $v):
        echo "<tr id='$v->oid'>".
               "<td>". $v->valor . "</td>".
               "<td><a href='#' id='planos/excluir/". $v->pid ."' class='ui-icon ui-icon-trash'></td>".
             "</tr>";
    endforeach;
endif;
echo "<a href='".site_url("adm/planos/criar/$operadora")."' class='ui-icon ui-icon-document' title='Adicionar Plano'>Adicionar Plano</a></td>";
?>
</tbody>
</table>
</body>
</html>