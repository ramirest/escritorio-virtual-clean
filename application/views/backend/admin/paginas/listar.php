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
    $("#excluir-pagina").dialog({
        bgiframe:true,
        resizable:false,
        height:140,
        modal:true,
        autoOpen:false,
        buttons:{
            Cancelar:function(){
                $(this).dialog('close');
            },
            'Excluir Página':function(){
                $("body").load($(this).attr("registro"));
            }
        }
    });
    $("#tabela-paginas").tablesorter({widgets:['zebra']});
    $("#tabela-paginas").detailsRow('paginas/carregar/',{data:{"pid":"id"}});
    $(".ui-icon-trash").click(function(){
        $("#excluir-pagina").attr("registro", $(this).attr("id"));
        $("#excluir-pagina").dialog('open');
    })
});
</script>
<title>Gerenciamento de P&aacute;ginas</title>
</head>

<body>
<?php echo $this->session->flashdata('msg'); ?>
<div id="excluir-pagina" class="ui-widget-content"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0"></span>Tem certeza de que deseja excluir esta p&aacute;gina?</div>
<table id="tabela-paginas">
<thead>
  <tr>
    <th>T&iacute;tulo da p&aacute;gina</th>
  </tr>
</thead>
<tbody>
<?php
if(isset($paginas)):
    foreach($paginas->result() as $v):
        echo "<tr id='$v->pid'>".
               "<td>". $v->titulo . "</td>".
               "<td><a href='paginas/editar/". $v->pid ."' class='ui-icon ui-icon-pencil'></td>".
               "<td><a href='#' id='paginas/excluir/". $v->pid ."' class='ui-icon ui-icon-trash'></td>".
             "</tr>";
    endforeach;
endif;
echo "<a href='".site_url("adm/paginas/criar")."' class='ui-icon ui-icon-document' title='Criar P&aacute;gina'>Criar P&aacute;gina</a></td>";
?>
</tbody>
</table>
</body>
</html>