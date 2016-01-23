<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/themes/blue/style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_css');?>jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_js');?>jquery.detailsRow.js"></script>
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#excluir-parceiro").dialog({
        bgiframe:true,
        resizable:false,
        height:140,
        modal:true,
        autoOpen:false,
        buttons:{
            Cancelar:function(){
                $(this).dialog('close');
            },
            'Excluir Empresa':function(){
                $("body").load($(this).attr("registro"));
            }
        }
    });
    $("#tabela-parceiros").tablesorter({widgets:['zebra']});
    $("#tabela-parceiros .ui-icon-trash").click(function(){
        $("#excluir-parceiro").attr("registro", $(this).attr("id"));
        $("#excluir-parceiro").dialog('open');
    })
});
</script>
<title>Gerenciamento de empresas parceiras</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<div id="excluir-parceiro" class="ui-widget-content"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0"></span>Tem certeza de que deseja excluir esta empresa?</div>
<table id="tabela-parceiros" class="tablesorter">
<thead>
  <tr>
    <th>Código</th>
    <th>Empresas</th>
  </tr>
</thead>
<tbody>
<?php
if(isset($empresas)):
    foreach($empresas->result() as $v):
        echo "<tr id='$v->eid'>".
               "<td>". $v->eid . "</td>".
               "<td>". $v->razao_social . "</td>".
               "<td><a href='empresas/ver/". $v->eid ."' class='ui-icon ui-icon-search'></td>".
               "<td><a href='empresas/editar/". $v->eid ."' class='ui-icon ui-icon-pencil'></td>".
               "<td><a href='#' id='empresas/excluir/". $v->eid ."' class='ui-icon ui-icon-trash'></td>".
             "</tr>";
    endforeach;
endif;
echo "<a href='".site_url("escritorio-virtual/empresas/criar")."' class='ui-icon ui-icon-document' title='Adicionar Empresa'>Adicionar Empresa</a></td>";
?>
</tbody>
</table>
</body>
</html>