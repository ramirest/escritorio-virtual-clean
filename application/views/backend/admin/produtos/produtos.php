<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gerenciamento de Produtos</title>
</head>

<body>
<?php echo @$msg; ?><br />

<div id="tabs-produtos">
    <ul>
        <li><?php echo anchor(site_url("escritorio-virtual/produtos/ver"), "Produtos"); ?></li>
        <li><?php echo anchor(site_url("escritorio-virtual/categorias/ver"), "Categorias");?></li>
    </ul>
</div>
</body>
</html>