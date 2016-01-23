<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/themes/blue/style.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().$this->config->item('mmn_misc');?>tablesorter/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#tabela-paginas").tablesorter({widgets:['zebra']});
});
</script>
<title>Gerenciamento de P&aacute;ginas</title>
</head>

<body>
<table id="tabela-redes">
<thead>
  <tr>
    <th>Visualizar</th>
  </tr>
</thead>
<tbody>
<?php
if(isset($redes)):
    foreach($redes->result() as $v):
        echo "<tr>".
               "<td>". $v->nome_completo . "</td>".
               "<td>". $v->cidade . "</td>".
               "<td>". $v->estado . "</td>".
             "</tr>";
    endforeach;
endif;
?>
</tbody>
</table>
</body>
</html>